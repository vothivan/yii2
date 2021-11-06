<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "staff".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $address
 * @property integer $status
 * @property integer $description
 * @property integer $lastLoginTime
 */
class Customer extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    public $repassword;
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'signup';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [['name', 'phone'], 'required'],
            [['password', 'phone', 'name', 'repassword'], 'required', 'on' => self::SCENARIO_REGISTER],
            [['phone'], 'unique'],
            [['status'], 'integer'],
            [['email'], 'email'],
            [['phone'], 'integer', 'message' => 'Số điện thoại không hợp lệ'],
            [['phone'], 'string', 'max' => 15, 'min' => 10],
            [['description', 'address', 'email', 'password'], 'string'],
            ['repassword', 'compare', 'compareAttribute'=>'password', 'message'=>"Mật khẩu phải giống nhau!", 'on' => self::SCENARIO_REGISTER],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] = ['email', 'phone', 'password'];
        $scenarios[self::SCENARIO_REGISTER] = ['email', 'password', 'phone', 'address', 'name', 'repassword'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Địa chỉ email',
            'password' => 'Mật khẩu',
            'repassword' => 'Nhập lại mật khẩu',
            'phone' => 'Số điện thoại',
            'name' => 'Họ tên',
            'address' => 'Địa chỉ',
            'joinTime' => 'Join Time',
            'description' => 'Mô tả',
            'districtId' => 'Quận huyện',
            'wardId' => 'Xã phường',
            'vnposPosId' => 'Bưu cục',
            'isPos' => 'Người bán là bưu điện',
            'identityCard' => 'Số CMND',
            'paymentBank' => 'Ngân hàng',
            'paymentBranch' => 'Chi nhánh ngân hàng',
            'paymentName' => 'Chủ tài khoản',
            'paymentCard' => 'Số tài khoản',
            'cardPicture' => 'Ảnh CMND mặt trước',
            'status' => 'Hoạt động'
        ];
    }

    public function getAuthKey()
    {
        return md5($this->phone . 'adasda34354');
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function validateAuthKey($authKey)
    {
        return $authKey == $this->getAuthKey();
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
}