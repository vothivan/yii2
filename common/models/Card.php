<?php

namespace common\models;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $price
 * @property integer $denomination
 * @property string $carrier
 * @property integer $code
 * @property string $seri
 * @property integer $code
 * @property string $expiry
 */
class Card extends \yii\db\ActiveRecord
{
    public $count = 0;
    /**
     * @inheritdoc
     */
    public static function tableName(){
        return 'card';
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['name','price','denomination','carrier','code','seri','expiry'], 'required'],
            [['price','denomination'], 'integer'],
            [['seri',], 'string', 'max' <= 11, 'min' => 11],
            [['code',], 'string', 'max' <= 13, 'min' => 13],
            [['name',], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(){
        return [
            'id' => 'Mã',
            'name' => 'Tên thẻ',
            'price' => 'Giá',
            'denomination' => 'Mệnh giá',
            'carier' => 'Nhà mạng',
            'code' => 'Mã thẻ',
            'seri' => 'Số seri',
            'expiry' => 'Ngày hết hạn',
        ];
    }

    }
   

   


