<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "area".
 *
 * @property integer $id
 * @property string $companyName
 * @property string $contactPhone
 * @property integer $contactEmail
 * @property integer $address
 * @property integer $slogan
 * @property integer $linkFb
 * @property integer $linkGg
 * @property integer $linkYt
 * @property integer $bannerHome
 */

class InfoConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'info_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companyName', 'contactPhone', 'contactEmail', 'address', 'slogan', 'linkFb', 'linkGg', 'linkYt','linkInstagram','linkZalo'], 'required'],
            [['companyName','contactEmail','address', 'contactPhone', 'bannerHome'], 'string'],
            [['contactEmail'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'companyName' => 'Tên công ty vận hành sàn',
            'contactPhone' => 'Số tổng đài CSKH',
            'contactEmail' => 'Email hỗ trợ',
            'address' => 'Địa chỉ công ty',
            'slogan' => 'slogan',
            'linkFb' => 'Url fanpage facebook',
            'linkGg' => 'Url google',
            'linkInstagram' => 'Url Instagram',
            'linkZalo' => 'Url zalo',
            'linkYt' => 'Url kênh youtube',
            'bannerHome' => 'Ảnh banner',
        ];
    }

    public static function getInfo(){
        return self::findOne(1);
    }
}
