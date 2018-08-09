<?php


function getYTB($link,$default = ''){
    $result = array();
    $id = getIdYoutube($link);
    if($id)
    {
        $apiYoutube = 'http://www.youtube.com/get_video_info?&video_id='.$id.'&asv=3&el=detailpage&hl=en_US';
        $page = AnimeVN_Source($apiYoutube);
        parse_str($page, $videoInfo);
        if(isset($videoInfo['status']) && $videoInfo['status'] == 'ok')
        {

            $result = array();
            $stream = explode(',', $videoInfo['url_encoded_fmt_stream_map']);
            foreach ($stream as $format)
            {
                parse_str($format, $format_info);
                parse_str(urldecode($format_info['url']), $url_info);
                $type = explode(';', $format_info['type']);
                $itag = $format_info['itag'];
                $infoItag = itagMap($itag);
                $var['type'] = $type[0];
                $var['label'] = $infoItag['quality'];
                /*if($infoItag['quality'] == $default){
                    $var['default'] = 'true';
                }else{
                    $var['default'] = 'false';
                }*/
                $file = urldecode($format_info['url']);
                $var['file'] = preg_replace("/.*googlevideo.com/", "https://redirector.googlevideo.com", $file);
                $var['file'] = preg_replace("/.*google.com/", "https://redirector.googlevideo.com", $var['file']);
                if($var['type'] == 'video/mp4'){
                    array_push($result, $var);
                }
            }
        }
    }
    if(!$result)
    {
        $result = get($link,$default);
    }
    return json_encode($result,JSON_PRETTY_PRINT);
}

function getIdYoutube($link){
    $link = trim($link);
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $link, $id);
    if(!empty($id)) {
        return $id = $id[0];
    }else{
        return false;
    }
}

function readString($string, $findStart, $findEnd)
{
    $start = stripos($string, $findStart);
    if ($start === false)
        return false;
    $length = strlen($findStart);
    $end    = stripos(substr($string, $start + $length), $findEnd);
    if ($end !== false) {
        $rs = substr($string, $start + $length, $end);
    } else {
        $rs = substr($string, $start + $length);
    }
    return $rs ? $rs : false;
}


function itagMap($itag){
    $itag = (int)$itag;
    switch ($itag) {
        case 17:
            $quality = 360;
            $type = "3gpp";
            break;
        case 36:
            $quality = 480;
            $type = "3gpp";
            break;
        case 5:
            $quality = 240;
            $type = "flv";
            break;
        case 34:
            $quality = 360;
            $type = "flv";
            break;
        case 35:
            $quality = 480;
            $type = "flv";
            break;
        case 18:
            $quality = 360;
            $type = "mp4";
            break;
        case 59:
            $quality = 480;
            $type = "mp4";
            break;
        case 22:
            $quality = 720;
            $type = "mp4";
            break;
        case 37:
            $quality = 1080;//1920 x 1080
            $type = "mp4";
            break;
        case 38:
            $quality = 1080;//2048 x 1080
            $type = "mp4";
            break;
        case 43:
            $quality = 360;
            $type = "webm";
            break;
        case 44:
            $quality = 480;
            $type = "webm";
            break;
        case 45:
            $quality = 720;
            $type = "webm";
            break;
        case 46:
            $quality = 1080;
            $type = "webm";
            break;
        default:
            $quality = 0;
            $type = "";
            break;
    }
    
    return array("quality"=>$quality,"type"=>$type);
}
?>