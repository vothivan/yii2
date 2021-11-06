<?php
// echo $_SERVER['HTTP_USER_AGENT'];
// echo '<br>---------------------------------------------------------------<br>';
$ag = $_SERVER['HTTP_USER_AGENT'];
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://api.userstack.com/detect?access_key=68d70a2ab9923e39de5285d7f9cfd621&ua='.$ag,
  // CURLOPT_URL => $_SERVER['HTTP_USER_AGENT'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => false,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    // 'Cookie: __cfduid=daad7dcb845d29b9b668c7ed2ccfc60d51611104834'
  ),
));

$response = curl_exec($curl);
// echo $response;
// echo '<br>---------------------------------------------------------------<br>';
curl_close($curl);

$arr = json_decode($response);

// var_dump(
// $arr
// );
if ($arr->device->type == 'desktop') {
	echo 'desktop: '. $arr->os->name;
} else {
	echo '<br>thương hiệu: '.$arr->brand;	
	echo '<br>tên máy: '.$arr->name;	
}

die;
?>