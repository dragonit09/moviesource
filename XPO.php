<?php
	define("key", "xpo2017979588179f78df100f850cbe7250a169");
	require_once 'aes_decrypt.class.php';
	function GetXPO($link)
	{
		if (preg_match('#http:\/\/vophim.com\/xem-phim\/(.*?)\/(.*?)/#',$link,$id)) {
			
			$PageFilm = cURL("http://vophim.com/ajax/episodes/?act=player&epid={$id[2]}");

			preg_match_all('/"file":"(.+?)"/i', $PageFilm, $StreamUrl);

			preg_match_all('/"label":"(.+?)"/',$PageFilm,$Label);
			
			$label = $Label[1];

			$Stream = $StreamUrl[1];

			$Result = Array();
			for ($i = 0; $i < count($Stream); $i++)
			{
				$Result[$i]['file'] = GibberishAES::dec($Stream[$i], constant("key"));
				$Result[$i]['label'] = $label[$i];
			}


			return json_encode($Result,JSON_PRETTY_PRINT);
		};
	}

	function cURL($url, $postArray = array(), $setopt = array())
	{
		$opts = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_FOLLOWLOCATION => false,
			// CURLOPT_COOKIEFILE => $cookie,
			// CURLOPT_COOKIEJAR => $cookie,
			CURLOPT_AUTOREFERER => true,
			CURLOPT_HEADER => false,
			CURLOPT_FRESH_CONNECT => true,
			CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.52 Safari/537.36',
			CURLOPT_REFERER => $url
		);
		if(count($postArray) > 0 && $postArray != false){
			$postFields = array(
				'POST' => true, 
				'POSTFIELDS' => http_build_query($postArray),
				'REFERER' => $url
			);
			$setopt = array_merge($setopt, $postFields);
		}
		foreach($setopt as $key => $value){
			$opts[constant('CURLOPT_'.strtoupper($key))] = $value;
		}
		
		$s = curl_init();
		curl_setopt_array($s, $opts);
		$data = curl_exec($s);
		curl_close($s);
		@unlink($cookie);
		return $data;
	}
?>



