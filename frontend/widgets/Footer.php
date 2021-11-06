<?php

namespace frontend\widgets;

use common\models\Alias;

class Footer extends \yii\base\Widget
{

    public function run()
    {

        return $this->render('footer');
    }

}
