<?php
function GetAnime($url){



    $source = explode('<script async="true" rel="nofollow" src="', $get);

    $source = explode('"></script>',$source[1]);

    $link = cURL($source[0]);

    

    preg_match_all('/file:"(.*?)","type":"(.*?)","label":"(.*?)",/', $link, $StreamInfo);

        $Label = $StreamInfo[3];
        $StreamUrl = preg_replace('/\\\/', '', $StreamInfo[1]);
        $Result = Array();
        for ($i = 0; $i < count($StreamUrl); $i++)
        {
            $Result[$i]['type'] = 'mp4/video';
        
            $Result[$i]['label'] = $Label[$i];
            $Result[$i]['file'] = $StreamUrl[$i];
        }

        return json_encode($Result, JSON_PRETTY_PRINT);

}
function cURL($url, $postArray = array(), $setopt = array())
    {
        $opts = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_COOKIEFILE => $cookie,
            CURLOPT_COOKIEJAR => $cookie,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.52 Safari/537.36',
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


