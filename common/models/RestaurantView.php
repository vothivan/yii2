<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *

 */
class RestaurantView extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'restaurant_view';
    }


//     id  int(11) Tăng tự động    
// url int(11) 
// name    varchar(255) NULL   
// description text NULL   
// position    int(11) [0] 

    /**
     * @inheritdoc
     */
    public function rules() { 
        return [
            [['url'], 'required'],
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
