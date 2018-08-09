<?php
function explode_by($begin,$end,$data) {
    $data = explode($begin,$data);
	$data = explode($end,$data[1]);
    return $data[0];
}
function curl($url){
	$ch = @curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	$head[] = "Connection: keep-alive";
	$head[] = "Keep-Alive: 300";
	$head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$head[] = "Accept-Language: en-us,en;q=0.5";
	$head[] = "Referer: http://animehay.tv/phim/nanatsu-no-taizai-imashime-no-fukkatsu-tap-00-facebook-e51194.html";
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
	$page = curl_exec($ch);
	curl_close($ch);
	return $page;
}
function get($url,$refer) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

	$headers = array();
	$headers[] = "Accept-Encoding: gzip, deflate";
	$headers[] = "Accept-Language: vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5";
	$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.162 Safari/537.36";
	$headers[] = "Accept: */*";
	$headers[] = "Referer: $refer";
	$headers[] = "Cookie: __cfduid=d6d6d1b09ee85764b934c095f04fe48661522870758; _ga=GA1.2.1069492934.1522870759; _gid=GA1.2.1831994671.1522870759";
	$headers[] = "Connection: keep-alive";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	curl_close ($ch);
	return $result;
}
$link = $_GET["link"];
$code = curl($link);
$js = get(explode_by('<script async="true" rel="nofollow" src="','"',$code),$link);
$down = str_replace("\\/","/",explode_by('file:"','"',$js));
$jw[0]["file"] = $down;
$jw[0]["label"] = "video";
$jw[0]["type"] = "video/mp4";
echo json_encode($jw);
?>