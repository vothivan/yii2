<?php

namespace frontend\widgets;


use common\models\Alias;
use common\models\Category;
use Yii;

class Navigation extends \yii\base\Widget
{

    public function run()
    {

        /*
        * navigationv1
        */

        // $packages = Yii::$app->session->get('packages');
        // $total = 0;
        // if($packages)
        //     foreach ($packages as $key => $value) {
        //         $total += count($value['items']);
        //     }
        // return $this->render('navigation', [
        //     'categories' => Category::getRoot(true),
        //     'aliases' => Alias::find()->where(['published' => 1])->orderBy('position')->all(),
        //     'packages' => $packages ? $packages : [],
        //     'total' => $total
        // ]);


        /*
        * navigationv2
        */
        return $this->render('navigation');
    }

}
