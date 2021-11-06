<?php

namespace frontend\widgets;

class ProductWidget extends \yii\base\Widget
{

    public $product;

    public function run()
    {
        return $this->render('product', [
            'product' => $this->product
        ]);
    }

}
