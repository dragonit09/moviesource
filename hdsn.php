<?php 
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

function HDSN($curl) {
    if(preg_match('#http://www.hdsieunhanh.com/(.*?)Tap-(.*?)-hd-(.*?).html#',$curl,$info)){
  
        
        $episode = 'http://www.hdsieunhanh.com/getsource/'. $info[3]. '_' . $info[2].'?ip=27.72.60.5';

        $data = cURL($episode);

      
      }elseif(preg_match('#http://www.hdsieunhanh.com/(.*?)-hd-(.*?).html#',$curl,$info)){
       
        $episode = 'http://www.hdsieunhanh.com/getsource/'. $info[2].'__?ip=27.72.60.5';

        $data = cURL($episode);
        
    }else{

      exit('url sai cmnr');

    } 


    
    preg_match_all('/\"file\":\"(.*?)\",\"label\":(.*?),\"type\":\"(.*?)\"/',$data, $InfoFilm);
    

    $Result = Array();
        $Type = $InfoFilm[3];
        $Label = $InfoFilm[2];
        $StreamUrl = preg_replace('/\\\/', '', $InfoFilm[1]);


        for ($i = 0; $i < count($InfoFilm[1]); $i++)
        {
            $Result[$i]['file'] = $StreamUrl[$i];
            $Result[$i]['type'] = 'mp4/video';
            $Result[$i]['label'] = $Label[$i];
            
        }

        return json_encode($Result, JSON_PRETTY_PRINT);
       
}
 ?>