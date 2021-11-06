<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "homeboxv2".
 *
 * @property int $id
 * @property string $banner1
 * @property string $banner2
 * @property string $banner3
 * @property int $type
 * @property string $name
 * @property string $categoryIds
 * @property int $activated
 * @property int $createTime
 */
class Homeboxv2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'homeboxv2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'activated', 'createTime'], 'integer'],
            [['name', 'categoryIds'], 'required'],
            [['banner1', 'banner2', 'banner3', 'name'], 'string', 'max' => 150],
            [['categoryIds'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banner1' => 'Banner1',
            'banner2' => 'Banner2',
            'banner3' => 'Banner3',
            'type' => 'Type',
            'name' => 'Name',
            'categoryIds' => 'Category Ids',
            'activated' => 'Activated',
            'createTime' => 'Create Time',
        ];
    }
}
