<?php

// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
	require_once('../methods/Alisearch.class.php');
	
    $API = new Alisearch($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
    echo $API->processAPI();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}

/*
require_once('../functions.php');
$url = $_POST['url'];

//https://www.google.com/searchbyimage?image_url=https://pp.vk.me/c626331/v626331425/21be5/hxamvJYqS38.jpg&q=site:ru www.aliexpress.com
file_put_contents("php://stderr", 'с сайта - '.$url);
$file_path = $url;

$response = curl('https://www.google.com/searchbyimage?q=site:aliexpress.com&image_url='.$file_path, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.65 Safari/537.36');

$text = "Релевантный товар: ".getLinkArray($response);

echo $text;
*/