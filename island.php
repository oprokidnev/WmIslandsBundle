<?php

/**
 * Script proxying 
 * @author Andrey Oprokidnev <aa@oprokidnev.ru>
 */
$formId   = isset($_GET['formId']) ? $_GET['formId'] : 'default';
$postData = http_build_query($_POST);

$socket = fsockopen("islands.oprokidnev.ru", 80, $errno, $errstr, 15);
if ($curl   = curl_init()) {
    curl_setopt($curl, CURLOPT_URL, 'http://islands.oprokidnev.ru/' . $_SERVER['HTTP_HOST'] . '.' . $formId . '');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    $response = curl_exec($curl);
    if ($response=json_decode($response,true)) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$response['redirect']);
    }
    curl_close($curl);
} 
  
//
//if(!$socket){
//	echo ' error: ' . $errno . ' ' . $errstr;
//	die;
//}else{
//	$http  = "POST /".$_SERVER['HTTP_HOST'].'.'.$formId." HTTP/1.1\r\n";
//	$http .= "Host: "."islands.oprokidnev.ru"."\r\n";
//	$http .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
//	$http .= "Content-Type: application/x-www-form-urlencoded\r\n";
//	$http .= "Content-length: " . strlen($postData) . "\r\n";
//	$http .= "Connection: close\r\n\r\n";
//	$http .= $postData . "\r\n\r\n";
//	//Sends are header data to the web server
//	fwrite($socket, $http);		
//	$contents = "";
//	//Waits for the web server to send the full response. On every line returned we append it onto the $contents 
//	//variable which will store the whole returned request once completed.
//	while (!feof($socket)) {
//		$contents .= fgets($socket, 4096);
//	}
//    print_r($contents);
//	//Close are request or the connection will stay open untill are script has completed.
//	fclose($socket);
//}
