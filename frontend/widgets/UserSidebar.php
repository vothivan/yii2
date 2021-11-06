<?php

namespace frontend\widgets;

use Yii;

class UserSidebar extends \yii\base\Widget
{

    public function run() {
        return $this->render('usersidebar');
    }

}
