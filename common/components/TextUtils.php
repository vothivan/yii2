<?php

namespace common\components;

use common\components\Googl;

class TextUtils {

    public static function createAlias($str) {
        $str = trim($str);
        $str = self::removeDiacritical($str);
        $str = self::removeSpecialChar($str);
        $str = self::stripMultiSpace($str);
        $str = preg_replace('/\s/', '-', $str);
        return strtolower($str);
    }

    public static function createKeyword($str) {
        $str = trim($str);
        $str = self::removeDiacritical($str);
        $str = self::removeSpecialChar($str);
        $str = self::stripMultiSpace($str);
        return strtolower($str);
    }

    public static function removeDiacritical($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        return $str;
    }

    public static function removeSpecialChar($str) {
        return preg_replace('/[^A-Za-z0-9\s]/', '', $str);
    }

    public static function stripMultiSpace($str) {
        return preg_replace('/\s+/', ' ', $str);
    }

    public static function shorternUrl($url){
        $googl = new Googl(\Yii::$app->params['googleAPIKey']);
        return $googl->shorten($url);
    }

    public static function expandUrl($url){
        $googl = new Googl(\Yii::$app->params['googleAPIKey']);
        return $googl->expand($url);
    }

    public static function startsWith($haystack, $needle)
    {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    public static function shortern($string, $length, $ellipses = true, $strip_html = true, $allowable_tags = null)
    {
        //strip tags, if desired
        if ($strip_html) {
            $string = strip_tags($string, $allowable_tags);
            $string = trim(preg_replace("/<p[^>]*><\\/p[^>]*>/", '', $string));
        }

        //no need to trim, already shorter than trim length
        if (strlen($string) <= $length) {
            return $string;
        }

        //find last space within length
        $last_space = strrpos(substr($string, 0, $length), ' ');
        $trimmed_text = substr($string, 0, $last_space);

        //add ellipses (...)
        if ($ellipses) {
            $trimmed_text .= '...';
        }

        return $trimmed_text;
    }

}
