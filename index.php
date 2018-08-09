<?php 
header("Content-type:application/json");

function AnimeVN_Source($url)
{
    $ch = @curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    $head[] = "Connection: keep-alive";
    $head[] = "Keep-Alive: 300";
    $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $head[] = "Accept-Language: en-us,en;q=0.5";
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Expect:'
    ));
    $page = curl_exec($ch);
    curl_close($ch);
    return $page;
}


$url = isset($_GET['url'])? $_GET['url']:'';

$default[] = array('file' => 'https://i.rmbl.ws/s8/2/L/m/k/D/LmkDa.aaa.1.MP4', 'label' => 'Auto', 'type' => 'video/mp4');

if (!empty($url)) {

preg_match('/https?:\/\/(?:[-\w]+\.)?([-\w]+)\.\w+(?:\.\w+)?\/?.*/i',$url,$var_link);

	switch ($var_link[1]) {
		case 'phimbathu':
			require_once 'phimbathu.php';
	    	$link = GetBatHu($url);
	    	print_r($link);
	    	break;
	    case 'bilutv':
	    	require_once 'bilu.php';
	    	$link = GetBilu($url);
	    	print_r($link);
	    	break;
	    case 'facebook':
	    	require_once 'facebook.php';
	    	$link = GetFB($url,$token);
	    	print_r($link);
	    	break;
	    case 'vtvgiaitri':
	    	require_once 'vtv.php';
	    	$link = GETVTV($url);
	    	print_r($link);
	    	break;
	    case 'animehay':
	    	require_once 'animehay.php';
	    	$link = GetAnime($url);
	    	print_r($link);
	    	break;
	    case'bioskop45':
	    	require_once 'bioskop45.php';
	    	$link = Bioskop45($url);
	    	print_r($link);
	    	break;
	    case 'banhtv':
	    	require_once 'banhtv.php';
	    	$link = GetBanhTV($url);
	    	print_r($link);
	    	break;
	    case 'xvideo':
	    	require_once 'xvideo.php';
	    	$link = GetXvideo($url);
	    	print_r($link);
	    	break;
	    case 'rumble':
	    	require_once 'rumble.php';
	    	$link = GetRumble($url);
	    	print_r($link);
	    	break;
	    case 'phimtt':
	    	require_once 'phimtt.php';
	    	$link = GetPhimTT($url);
	    	print_r($link);
	    	break;
	    case 'hdsieunhanh':
	    	require_once 'hdsn.php';
	    	$link = HDSN($url);
	    	print_r($link);
	    	break;
	    case 'youtube':
    		require_once 'getYoutube.php';
	    	$link = getYTB($url);
	    	print_r($link);
    		break;
	    case 'hayhaytv':
	    	require_once 'hayhaycom.php';
	    	$link = HayHay($url);
	    	print_r($link);
	    	break;
	    case 'xvideos':
	    	require_once 'xvideo.php';
	    	$link = GetXvideo($url);
	    	print_r($link);
	    	break;
	    case 'archive':
    		require_once 'archive.php';
	    	$link = GetArchive($url);
	    	print_r($link);
    	break;
		default:
			print_r(json_encode($default,JSON_PRETTY_PRINT));
			break;
	}
}else{
	print_r(json_encode($default,JSON_PRETTY_PRINT));
}

 ?>