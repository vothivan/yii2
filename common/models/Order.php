<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $code
 * @property integer $customerId
 * @property string $buyerName
 * @property string $buyerPhone
 * @property string $buyerEmail
 * @property string $buyerAddress
 * @property integer $buyerProvinceId
 * @property integer $buyerDistrictId
 * @property integer $buyerWardId
 * @property string $buyerNote
 * @property integer $createTime
 * @property integer $updateTime
 * @property integer $confirmTime
 * @property integer $doneTime
 * @property integer $customerServiceId
 * @property integer $affiliateId
 * @property string $affiliateCode
 */
class Order extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules() { 
        return [
            [['contactPhone', 'contactName', 'address', 'status'], 'required'],
            [['customerId', 'contactPhone', 'totalPrice', 'createTime', 'confirmTime', 'doneTime', 'cancelTime', 'status'], 'integer'],
            [['contactName', 'contactEmail', 'address', 'note'], 'string'],
            [['contactPhone'], 'string', 'min' => 10 ,'max' => 15],            
            [['contactEmail'], 'string', 'max' => 255],
            [['contactEmail'], 'email'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'customerId' => 'Mã khách hàng',
            'contactName' => 'Tên liên hệ',
            'contactPhone' => 'Số điện thoại liên hệ',
            'contactEmail' => 'Email liên hệ',
            'address' => 'Địa chỉ nhận hàng',
            'note' => 'Ghi chú',
            'confirmTime' => 'Thời gian xác nhận',
            'doneTime' => 'Thời gian hoàn thành',
            'cancelTime' => 'Thời gian hủy',
            'status' => 'Trạng thái',
        ];
    }

    public function getProducts() {
        return $this->hasMany(OrderProduct::className(), ['orderId' => 'id']);
    }

    public function getCustomer() {
        return $this->hasOne(Customer::className(), ['id' => 'customerId']);
    }
}
