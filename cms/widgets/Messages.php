<?php

namespace cms\widgets;

class Messages extends \yii\base\Widget
{
    public function run()
    {
        return $this->render('messages');
    }

}
