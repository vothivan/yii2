<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 */
class OrderProduct extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'order_product';
    }

    /**
     * @inheritdoc
     */
    public function rules() { 
        return [
            [['orderId', 'productId', 'productData', 'name', 'quantity', 'price'], 'required'],
            [['name'], 'string', 'max' => 255],
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

    public function getRating() {
        return $this->hasOne(Rating::className(), ['orderId' => 'orderId', 'productId' => 'productId']);
    }
}
