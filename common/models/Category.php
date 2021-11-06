<?php

namespace common\models;

use Yii;
use common\components\TextUtils;
use yii\helpers\Url;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 */
class Category extends \yii\db\ActiveRecord
{
    public $count = 0;
    /**
     * @inheritdoc
     */
    public static function tableName(){
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['name','status'], 'required'],
            [['status'], 'integer'],
            [['name',], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(){
        return [
            'id' => 'Mã',
            'parentId' => 'Danh mục cha',
            'name' => 'Tên danh mục',
            'icon' => 'Icon',
            'banner' => 'Banner',
            'bannerMenu' => 'Banner Menu',
            'description' => 'Mô tả',
            'keywords' => 'Keywords',
            'position' => 'Thứ tự',
            'status' => 'Hoạt động',
        ];
    }

    public function getCount(){
        $cid = $this->id;
        $query = Product::find()->orWhere(['like','categories', '['.$cid.',%' ,false]);
            $query->orWhere(['like','categories', '%,'.$cid.',%' ,false]);
            $query->orWhere(['like','categories', '%,'.$cid.']' ,false]);
            $query->orWhere(['like','categories', '['.$cid.']' ,false]);
            $query->orWhere(['categoryId' => $cid]);
        return $query->count();
    }
   

     public function createUrl()
    {
        return Url::to(['product/browse', 'cid' => $this->id, 'cname' => TextUtils::createAlias($this->name)]);
    }
}
