<?php

require_once('functions/CallApi.php');

function translit($str)
{
    $tr = array(
        "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
        "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
        "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
        "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
        "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
        "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
        "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
        "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
        "ы"=>"yi","ь"=>"'","э"=>"e","ю"=>"yu","я"=>"ya",
    " "=>"_","?"=>"_","/"=>"_","\\"=>"_",
    "*"=>"_",":"=>"_","*"=>"_","\""=>"_","<"=>"_",
    ">"=>"_","|"=>"_"
    );
    return strtr($str,$tr);
}

function FormHandler($file, $config){
	$file_parts = pathinfo($file['name']);
	
	if(strtolower($file_parts['extension']) == "jpg" || strtolower($file_parts['extension']) == "png" || strtolower($file_parts['extension']) == "jpeg"){
		if (move_uploaded_file($file['tmp_name'], $config['upload_path'] . 
			translit($file['name']))) {
			
			if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
				$_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
			}
			$request['url'] = $config['upload_url'].translit($file['name']);
			
			$result['items'] = CallAPI('GET', $config['api_url'], $request);
			$result['status'] = 'success';
		} else {
			$result['status'] = 'apiError';
		}
	} else {
		$result['status'] = 'extension error';
	}
	
	return $result;
}