<?php
function getIdYoutube($curl){
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $curl, $id);
    if(!empty($id)) {
        return $id = $id[0];
    }
    return $curl;
}
function getVideoYoutube($curl) {
    $id = getIdYoutube($curl);
    $getlink = "https://www.youtube.com/watch?v=".$id;
    if ($get = AnimeVN_Source($getlink )) {
        $return = array();
        if (preg_match('/;ytplayer\.config\s*=\s*({.*?});/', $get, $data)) {
            $jsonData  = json_decode($data[1], true);
            $streamMap = $jsonData['args']['url_encoded_fmt_stream_map'];
            foreach (explode(',', $streamMap) as $url)
            {
                $url = str_replace('\u0026', '&', $url);
                
                $url = urldecode($url);
                $url = preg_replace('/codecs="(.*)"/',"",$url);
               
                parse_str($url, $data);
                $dataURL = $data['url'];
                unset($data['url']);
        
                if (strpos($data['type'] , 'video/mp4') !== false) {
                    if (strpos($data['itag'] , '22') !== false){
                         $return['720'] = $dataURL.'&'.urldecode(http_build_query($data));
                    }elseif(strpos($data['itag'] , '18') !== false){
                         $return['file']['480'] = $dataURL.'&'.urldecode(http_build_query($data));
                    }
                  
                }

            }
        }
        $encode =  json_encode($return,JSON_PRETTY_PRINT);

        $link_play = json_decode($encode,1);

        var_dump($link_play);exit;

      
        $result = '';
        if($return){
        foreach ($return as $i => $quality) {
           if (strpos($i, '720') !== false) {
                $result .= '<jwplayer:source file="'.htmlspecialchars($quality).'" label="720p" type="mp4"/>';
            }elseif (strpos($i, '480') !== false) {
                $result .= '<jwplayer:source file="'.htmlspecialchars($quality).'" label="480p" type="mp4"/>'; 
            }
                   
        }
    }
    return $result;
        
        
    }else{
        return 0;
    }
}

?>