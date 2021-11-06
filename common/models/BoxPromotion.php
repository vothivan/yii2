<?php

namespace common\models;

use Yii;
use common\components\TextUtils;
use yii\helpers\Url;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $productId
 * @property integer $endTime
 * @property integer $position
 * @property integer $status
 */
class BoxPromotion extends \yii\db\ActiveRecord
{
    public $count = 0;
    /**
     * @inheritdoc
     */
    public static function tableName(){
        return 'box_promotion';
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['productId','status', 'position', 'endTime'], 'required'],
            [['status', 'endTime', 'position', 'productId'], 'integer'],
            [['productId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(){
        return [
            'id' => 'Mã',
            'productId' => 'Mã sản phẩm',
            'name' => 'Tên danh mục',
            'icon' => 'Icon',
            'banner' => 'Banner',
            'bannerMenu' => 'Banner Menu',
            'description' => 'Mô tả',
            'endTime' => 'Thời gian ẩn',
            'position' => 'Thứ tự',
            'status' => 'Hiển thị',
        ];
    }

    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'productId']);
    }
}
