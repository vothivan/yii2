<?php

namespace cms\models;

use Yii;
use yii\base\Model;
use common\models\Staff;

class ChangepasswordForm extends Model
{
      public $oldpass;
      public $newpass;
      public $repeatnewpass;

      public function rules(){
          return [
              [['oldpass', 'newpass','repeatnewpass'], 'required'],
              ['oldpass', 'findPasswords'],
              [['newpass','repeatnewpass'], 'string', 'min' => 8, 'max' => 256, 'tooShort' => '{attribute} phải chứa ít nhất 8 ký tự'],
              ['repeatnewpass' , 'compare', 'compareAttribute' => 'newpass', 'message' => 'Xác nhận mật khẩu không trùng khớp'],
          ];
      }

      public function findPasswords($attribute, $params){
           $user = Staff::find()->where([
               'id'=> Yii::$app->user->identity->id
           ])->one();
           if (!Yii::$app->getSecurity()->validatePassword($this->oldpass, $user->password)) {
               $this->addError($attribute,'Sai mật khẩu');
           }
       }

      public function attributeLabels()
      {
          return [
              'oldpass' => 'Mật khẩu',
              'newpass' => 'Mật khẩu mới',
              'repeatnewpass' => 'Xác nhận mật khẩu',
          ];
      }
}
