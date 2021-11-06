<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *

 */
class Rating extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'rating';
    }

    /**
     * @inheritdoc
     */
    public function rules() { 
        return [
            [['orderId', 'productId', 'rating', 'content', 'createTime', 'customerId'], 'required'],
            [['rating'], 'integer' , 'min' => 1, 'max' => 5, 'tooSmall' => 'Chưa chọn đánh giá!'],
        ];
    }

					         

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'orderId' => 'orderId',
            'productId' => 'productId',
            'rating' => 'Đánh giá',
            'content' => 'Nội dung',
        ];
    }

    public function getCustomer() {
        return $this->hasOne(Customer::className(), ['id' => 'customerId']);
    }
}
