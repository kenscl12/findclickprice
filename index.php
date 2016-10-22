<?php

header("Access-Control-Allow-Origin: http://findclickprice.ru");
ini_set('date.timezone', 'Europe/Moscow');

require_once('config/config.php');

require_once('functions/Log.php');
require_once('functions/FormHandler.php');
require_once('functions/CallApi.php');

$result = Array();

setLog('page start', $config['root_path']);

// тут куча всякого дерьма про то что если форма с файлов отправлена, эта хрень возвращает статус приложения
/*
	result =
				- status
				- items
*/

$file = $_FILES['searchimg'];

if(!empty($file['name'])){
	
	//$file['name'] = translit($file['name']);
	//$file['tmp_name'] = translit($file['tmp_name']);
	
	//print_r($file); exit;
	
	$result = FormHandler($file, $config);
	
	if(count(json_decode($result['items'])) < 1){
		
		$result['status'] = 'no results';
	}
	
} else if(!empty($_POST['url'])){
	$result['items'] = CallAPI('GET', $config['api_url'], $_POST);
	$result['status'] = 'success';
	
	//print_r(json_decode($result['items']));
	
	if(count(json_decode($result['items'])) < 1){
		
		$result['status'] = 'no results';
	}
} else {
	$result['status'] = 'init';
}

require_once('ali/index.html');