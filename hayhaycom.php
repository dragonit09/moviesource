<?php 
       function HayHay($curl) {
    if(preg_match('#http://www.hayhaytv.com/(.*?)Tap-(.*?)-hd-(.*?)-xem-phim.html#',$curl,$info)){
  
        
        $episode = 'http://www.hayhaytv.com/getsource/'. $info[3]. '_' . $info[2].'?ip=117.0.207.179';
      
      }elseif(preg_match('#http://www.hayhaytv.com/(.*?)-hd-(.*?)-xem-phim.html#',$curl,$info)){
       
        $episode = 'http://www.hayhaytv.com/getsource/'. $info[2].'__?ip=117.0.207.179';
      
    }else{

      exit('url sai cmnr');

    }


    $ch = curl_init();  
    $timeout = 15;  
    curl_setopt($ch, CURLOPT_USERAGENT, 'Googlebot/2.1 (http://www.googlebot.com/bot.html)');
    curl_setopt($ch, CURLOPT_URL,$episode);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_REFERER, $curl); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    $data = curl_exec($ch);  
    curl_close($ch);



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