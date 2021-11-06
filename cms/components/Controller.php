<?php 
/**
 * Created by PhpStorm.
 * User: phugt
 * Date: 7/17/15
 * Time: 10:23 AM
 */

namespace cms\components;

use yii\filters\AccessControl;
use Yii;
use common\models\Staff;
/**
 * Class Controller
 * @package frontend\components
 */
class Controller extends \yii\web\Controller
{
	public $clientScript;

	public function init()
	{
		parent::init();
	}

	public function checkAuth(){
		$controllerName = Yii::$app->controller->id;
        $actionName = Yii::$app->controller->action->id;

        if(!\Yii::$app->user->isGuest){
        	$user = Staff::findOne(\Yii::$app->user->id);
            if(!in_array($controllerName, json_decode($user->auths))){
                throw new \yii\web\HttpException(403);
            }
        }
	}
}
