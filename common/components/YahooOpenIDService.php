<?php

/**
 * YahooOpenIDService class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii2-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace common\components;

use nodge\eauth\openid\Service;

/**
 * Yahoo provider class.
 *
 * @package application.extensions.eauth.services
 */
class YahooOpenIDService extends Service {

    protected $name = 'yahoo';
    protected $title = 'Yahoo';
    protected $type = 'OpenID';
    protected $jsArguments = array('popup' => array('width' => 880, 'height' => 520));
    protected $url = 'https://me.yahoo.com';
    protected $requiredAttributes = array(
        'name' => array('fullname', 'namePerson'),
//		'login' => array('nickname', 'namePerson/friendly'),
//		'email' => array('email', 'contact/email'),
    );
    protected $optionalAttributes = array(
//		'language' => array('language', 'pref/language'),
//		'gender' => array('gender', 'person/gender'),
//		'timezone' => array('timezone', 'pref/timezone'),
//		'image' => array('image', 'media/image/default'),
    );

    /* protected function fetchAttributes() {
      $this->attributes['fullname'] = $this->attributes['name'].' '.$this->attributes['lastname'];
      return true;
      } */

    public function clearToken() {
    }

}
