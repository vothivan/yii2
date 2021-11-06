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
class Staff extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff';
    }

    public $repassword;
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'signup';
    const SCENARIO_UPDATE = 'update';

    public static $listAuth = [
        'order' => 'Đơn hàng',
        'category' => 'Danh mục',
        'product' => 'Sản phẩm',
        'customer' => 'Khách hàng',
        'staff' => 'Nhân viên',
        'report' => 'Báo cáo',
        'infoconfig' => 'Thông tin shop',
        'banner' => 'Banner',
        'box' => 'Box khuyến mại',
        'news' => 'Tin tức',
        'category-news' => 'Danh mục tin tức',
        'restaurant-view' => 'Không gian quán',
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [['name', 'phone'], 'required'],
            [['phone'], 'unique'],
            [['status'], 'integer'],
            [['phone'], 'integer', 'message' => 'Số điện thoại không hợp lệ'],
            [['phone'], 'string', 'max' => 15, 'min' => 10],
            [['description', 'address', 'email', 'password', 'auths'], 'string'],
            ['password', 'compare', 'compareAttribute'=>'repassword', 'message'=>"Mật khẩu phải giống nhau!", 'on' => self::SCENARIO_REGISTER],
            ['password', 'compare', 'compareAttribute'=>'repassword', 'message'=>"Mật khẩu phải giống nhau!", 'on' => self::SCENARIO_UPDATE],
            [['password', 'repassword'], 'required', 'on' => self::SCENARIO_REGISTER],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] = ['email', 'phone', 'password'];
        $scenarios[self::SCENARIO_REGISTER] = ['email', 'password', 'phone', 'address', 'name', 'repassword'];
        $scenarios[self::SCENARIO_UPDATE] = ['email', 'password', 'phone', 'address', 'name', 'repassword'];
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
            'repassword' => 'Nhập lại mật khẩu',
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