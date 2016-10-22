<?php

function setLog($text, $path){
	$logtext = date('m/d/Y h:i:s a', time());
	
	$logtext .=  " - page start";
	
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	$logtext .=  " - " . $ip;
	
	file_put_contents($path . 'searchLog.txt', $logtext.PHP_EOL , FILE_APPEND | LOCK_EX);
}