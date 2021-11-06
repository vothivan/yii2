<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auth_group".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $activated
 * @property int $createTime
 */
class AuthGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['activated', 'createTime'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['description'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'activated' => 'Activated',
            'createTime' => 'Create Time',
        ];
    }
}
