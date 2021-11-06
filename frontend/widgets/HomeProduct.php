<?php

namespace frontend\widgets;

class HomeProduct extends \yii\base\Widget
{

    public $product;

    public function run()
    {
        return $this->render('homeproduct', [
            'product' => $this->product
        ]);
    }

}
