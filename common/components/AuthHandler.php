<?php
namespace common\components;

use common\models\Customer;
use app\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();
        // echo '<pre>';
        $r = new \ReflectionObject($this->client->accessToken);
        $p = $r->getProperty('_params');
        $p->setAccessible(true); // <--- you set the property to public before you read the value

        $obj = $p->getValue($this->client->accessToken);
        // var_dump($this->client);die;
        $preferred_username         = ArrayHelper::getValue($attributes, 'preferred_username');
        $email      = ArrayHelper::getValue($attributes, 'email');
        $name       = ArrayHelper::getValue($attributes, 'name');
        $sub        = ArrayHelper::getValue($attributes, 'sub');
        $token      = $obj['access_token'];
        $expiredAt  = intval($obj['expires_in']) + time();
        // $refreshToken = $obj['refreshToken'];

        $customer   = Customer::find()->where([
            'preferred_username' => $preferred_username,
            'source' => $this->client->getId()
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($customer) { // login
                Yii::$app->user->login($customer, 3600 * 24 * 365);
            } else { // signup
                $customer = Customer::find()->where(['email' => $email])->one();
                if ($email !== null && $customer) {
                    $customer->scenario     = Customer::SCENARIO_UPDATE;
                    $customer->token        = $token;
                    $customer->sub          = $sub;
                    $customer->source       = $this->client->getId();
                    $customer->expiredAt    = $expiredAt;
                    $customer->preferred_username = $preferred_username;
                    $customer->save(false);
                    Yii::$app->user->login($customer, 3600 * 24 * 365);
                } else {
                    $password = \Yii::$app->security->generatePasswordHash(Yii::$app->security->generateRandomString(6));
                    $customer = new Customer([
                        'name'          => $name,
                        'email'         => $email,
                        'password'      => $password,
                        'token'         => $token,
                        'sub'           => $sub,
                        'source'        => $this->client->getId(),
                        'preferred_username'      => $preferred_username,
                        'confirmOtp'    => time(),
                        'joinTime'      => time(),
                        'expiredAt'     => $expiredAt,
                        'activated'     => 1,
                        'provinceId'    => 0,
                        'districtId'    => 0,
                        'vnposPosId'    => 0,
                        'wardId'        => 0,
                    ]);
                    if ($customer->save(false)) {
                        Yii::$app->user->login($customer, 3600 * 24 * 365);
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save user: {errors}', json_encode([
                                'client' => $this->client->getTitle(),
                                'errors' => json_encode($customer->getErrors()),
                            ])),
                        ]);
                    }
                }
            }
        } else { // user already logged in
            $customer = Customer::find()->where([
                'preferred_username' => $preferred_username,
            ])->one();
            if($customer){
                $customer->token    = $token;
                $customer->sub      = $sub;
                $customer->source   = $this->client->getId();
                $customer->expiredAt = $expiredAt;
                $customer->preferred_username = $preferred_username;
                $customer->save();
                Yii::$app->user->login($customer, 3600 * 24 * 365);
            }
            else{
                $customer = new Customer();
                $customer->token = $token;
                $customer->sub  = $sub;
                $customer->name = $token;
                $customer->source = $this->client->getId();
                $customer->expiredAt = $expiredAt;
                $customer->preferred_username = $preferred_username;
                $customer->save();
            }
        }
    }

    /**
     * @param User $user
     */
    private function updateUserInfo(User $user)
    {
        $attributes = $this->client->getUserAttributes();
        $github = ArrayHelper::getValue($attributes, 'login');
        if ($user->github === null && $github) {
            $user->github = $github;
            $user->save();
        }
    }
}