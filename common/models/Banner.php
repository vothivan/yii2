<?php

namespace common\models;

use Yii;
use common\components\TextUtils;
use yii\helpers\Url;

/**
 * This is the model class for table "banner".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 */
class Banner extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName(){
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['image','url'], 'required'],
            [['url', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(){
        return [
            'id' => 'Mã',
            'image' => 'Hình ảnh',
            'image' => 'image',
        ];
    }
}
