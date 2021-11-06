<?php
/**
 * Created by PhpStorm.
 * User: phugt
 * Date: 7/17/15
 * Time: 10:23 AM
 */

namespace frontend\components;

use common\models\Config;
use common\models\InfoConfig;
use common\models\Category;
use common\models\Customer;
use common\models\Promotion;

/**
 * Class Controller
 * @package frontend\components
 */
class Controller extends \yii\web\Controller
{
     public $clientScript;

    public $companyName;
 	public $contactPhone;
	public $contactEmail;
 	public $address;
 	public $slogan;
 	public $linkFb;
	public $linkGg;
 	public $linkYt;
 	public $linkInstagram;
 	public $linkZalo;

    public function init()
    {
        parent::init();

        $model = InfoConfig::findOne(1);
        $this->companyName = $model->companyName;
	 	$this->contactPhone = $model->contactPhone;
		$this->contactEmail = $model->contactEmail;
	 	$this->address = $model->address;
	 	$this->slogan = $model->slogan;
	 	$this->linkFb = $model->linkFb;
		$this->linkGg = $model->linkGg;
	 	$this->linkYt = $model->linkYt;
	 	$this->linkInstagram = $model->linkInstagram;
	 	$this->linkZalo = $model->linkZalo;
    }
}