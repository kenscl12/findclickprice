<?php

require_once 'API.class.php';
require_once 'CURL.class.php';
class Alisearch extends API
{
	
    public function __construct($request, $origin) {
        parent::__construct($request);

        switch($this->method) {
        case 'DELETE':
        case 'POST':
            $this->request = $this->_cleanInputs($_POST);
            break;
        case 'GET':
            $this->request = $this->_cleanInputs($_GET);
			$this->url = $this->request['url'];
			
			$this->fullUrl = 'https://www.google.com/searchbyimage?q=site:aliexpress.com&image_url=' . $this->url;
            break;
        case 'PUT':
            $this->request = $this->_cleanInputs($_GET);
            $this->file = file_get_contents("php://input");
            break;
        default:
            $this->_response('Invalid Method', 405);
            break;
        }
    }

    /**
     * Example of an Endpoint
     */
     protected function example() {
        if ($this->method == 'GET') {
            return "Your name is " . $this->request['User'];
        } else {
            return "Only accepts GET requests";
        }
     }
	 
	 protected function search() {

		$CURL = new Curl($this->fullUrl);
		
		$this->response = $CURL->query();
		
		return $this->parseResult();
	 }
	 
	protected function parseResult() {
		
		//echo '<pre>'; print_r($matches_item); echo '</pre>'; exit();
		
		preg_match_all('/<div class="g">(.+?)<\/div>\s*<\/div>\s*<\/div>/is',$this->response,$matches_item); 
		
		if(count($matches_item) < 1){
			error_log("Error message\n", 3, $config['error_log']);
		}
		
		// $item = implode("[space]",$matches_item[0]);
		// $item = strip_tags($item);
		// $item_array = explode("[space]", $item);
		
		$item_array = $matches_item[1];
		
		$result = array();
		
		//echo '<pre>'; print_r($item_array); echo '</pre>'; exit();
		
		foreach($item_array as $value)
		{
			preg_match_all('/<h3 class="r">(.+?)<\/h3>/is',$value,$matches_title);
			preg_match_all('/<span class="st">(.+?)<\/div>/is',$value,$matches_description);
			preg_match_all('/src="(.+?)"/is',$value,$matches_img);
			preg_match_all('/href="(.+?)"/uis',$value,$matches_url);
			
			
			$text_title = implode("[space]", $matches_title[0]);
			$text_title = strip_tags($text_title);
			$text_title = explode("[space]", $text_title)[0];

			$description = implode("[space]",$matches_description[0]);
			$description = strip_tags($description);
			$description = explode("[space]", $description)[0];
			
			$img = implode("[space]",$matches_img[1]);
			$img = strip_tags($img);
			
			$url = implode("[space]",$matches_url[1]);
			$url = strip_tags($url);
			$url = explode("[space]", $url)[0];
			
			array_push($result, array("title" => $text_title, "description" => $description, "image" => $img, "url" => $url));
		}
		
		return $result;
	}
 }