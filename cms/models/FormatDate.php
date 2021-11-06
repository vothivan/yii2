<?php
namespace cms\models;
use yii\base\Model;
class FormatDate extends Model {

	public $endTimeLicense;
	public function rules() {
		return [
			[['endTimeLicense'], 'datetime', 'format' => 'php:d/m/Y', 'message'=>'Định dạng thời gian không hợp lệ!'],
		];
	}

	public function attributeLabels() {
		return [];
	}
}
