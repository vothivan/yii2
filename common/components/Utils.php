<?php

namespace common\components;

use DateTime;
use DateTimeZone;

class Utils
{
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

	public static function orderByIds($ids, $objects)
	{
		$result = [];
		foreach ($ids as $id) {
			foreach ($objects as $object) {
				if ($object->id == $id) {
					$result[] = $object;
					break;
				}
			}
		}
		return $result;
	}
	public static function generateRandomString($length = 10) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	public static function getTimeOffset(){
		$dateTimeZoneVN = new DateTimeZone("Asia/Bangkok");
		$dateTimeZoneLA = new DateTimeZone("America/Los_Angeles");
		$dateTimeVN = new DateTime(date('Y-m-d h:i:s',1481821200),$dateTimeZoneVN);
		$dateTimeLA = new DateTime(date('Y-m-d h:i:s',1481821200),$dateTimeZoneLA);
		$timeStamVN = $dateTimeVN->getTimestamp();
		$timeStamLA = $dateTimeLA->getTimestamp();
		$timeStamp = 0;

		if ($timeStamVN > $timeStamLA)
			$timeStamp = $timeStamVN - $timeStamLA;
		if ($timeStamLA > $timeStamVN)
			$timeStamp = $timeStamLA - $timeStamVN;

		return $timeStamp - 3600;
	}






     // public static function isLive($url, $useProxy = false)
	public static function request($url){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36',
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_CONNECTTIMEOUT => 30,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_TCP_NODELAY => true,
			CURLOPT_ENCODING => "",
			CURLOPT_FRESH_CONNECT => true,
			CURLOPT_COOKIE => false,
			CURLOPT_COOKIESESSION => false,
			CURLOPT_HTTPHEADER => array(
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
                // "Accept-Encoding: gzip, deflate, br, sdch"
			)
		));
        // if (Yii::$app->params['useProxy'] && $useProxy) {
        //     curl_setopt_array($curl, array(
        //         CURLOPT_PROXY => '108.59.14.200',
        //         CURLOPT_PROXYPORT => '13152'
        //     ));
        // }
		curl_setopt($curl, CURLOPT_URL, $url);
		$response = curl_exec($curl);
		$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if ($http_code != 200) {
			return false;
		}
		if (strlen(trim($response)) < 10) {
			return false;
		}
		curl_close($curl);
		return $response;
	}

}
