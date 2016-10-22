<?php

class Curl
{
	protected $url = '';
	
	public function __construct($url) {
		$this->url = $url;
		
	}
	
	public function query() {
		return $this->curl('Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.65 Safari/537.36');
	}
	
	private function curl($user_agent, $retry=0){
		if($retry > 5){
			throw new Exception("Service unavailable");
		}
		
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $this->url);
		curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt ($ch, CURLOPT_HEADER, TRUE);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt ($ch, CURLOPT_REFERER, 'http://www.google.com/');
		curl_setopt ($ch, CURLOPT_COOKIEFILE,"./cookie.txt");
		curl_setopt ($ch, CURLOPT_COOKIEJAR,"./cookie.txt");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = $this->curl_redir_exec($ch);
		curl_close($ch);
		// handling the follow redirect
		if(preg_match("|Location: (https?://\S+)|", $result, $m)){
			return $this->curl($m[1], $user_agent, $retry + 1);
		}
		
		// add another condition here if the location is like Location: /home/products/index.php
		return $result;
	}
	
	private function curl_redir_exec($ch)
    {
        static $curl_loops = 0;
        static $curl_max_loops = 20;
        if ($curl_loops++ >= $curl_max_loops)
        {
            $curl_loops = 0;
            return FALSE;
        }
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        list($header, $data) = explode("\n\n", $data, 2);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code == 301 || $http_code == 302)
        {
            $matches = array();
            preg_match('/Location:(.*?)\n/', $header, $matches);
            $url = @parse_url(trim(array_pop($matches)));
            if (!$url)
            {
                //couldn't process the url to redirect to
                $curl_loops = 0;
                return $data;
            }
            $last_url = parse_url(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
            if (!$url['scheme'])
                $url['scheme'] = $last_url['scheme'];
            if (!$url['host'])
                $url['host'] = $last_url['host'];
            if (!$url['path'])
                $url['path'] = $last_url['path'];
            $new_url = $url['scheme'] . '://' . $url['host'] . $url['path'] . ($url['query']?'?'.$url['query']:'');
            curl_setopt($ch, CURLOPT_URL, $new_url);
            return $this->curl_redir_exec($ch);
        } else {
            $curl_loops=0;
            return $data;
        }
    }
}