<?php
$urls =$_GET['$url'];
$token ='EAAAAUaZA8jlABABgXfbfS5FXO3TTfZB27ZAiS4mgSeoS0U7xw8GWfTFiA7rwZCiEkIIb25nC14rwiV2bmE17kjSHYQGr3zNOuaZCbi0qdR1paJumiLqIeDXYnLBtPKdCg7tAZCH3RQZBlGc1aN4OJZC65TiY218XdTCqx90kItBAUwZDZD';
echo GetHDViet($urls,$token);
function GetHDViet($link,$token){  
    $get = AnimeVN_Source('https://anivn.pro/get-token/?link='.$link.'&token='.$token);

    var_dump($get);
    die;

    preg_match('/mid:\s(.*?),/', $get,$id);

    $StreamInfo = AnimeVN_Source('http://movies.hdviet.com/get_movie_play_json?movieid='.$id[1].'&sequence=0');

    preg_match_all('/"playList":"(.*?)","subtitle":\[(.*?)\],/', $StreamInfo, $Streamlink);



     $StreamUrl = preg_replace('/\\\/', '', $Streamlink[1]);


     $Result = Array();
    for ($i = 0; $i < count($StreamUrl); $i++)
    {
      $Result[$i]['type'] = 'hls';
      $Result[$i]['label'] = 'Auto';
      $Result[$i]['file'] = $StreamUrl[$i];
    }

    return json_encode($Result, JSON_PRETTY_PRINT);

}
function AnimeVN_Source($url) {
  $ch = curl_init();  
  $timeout = 15;  
  curl_setopt($ch, CURLOPT_URL, $url);  
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.57 Safari/537.36");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);  
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);  
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);  
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);  
  $data = curl_exec($ch);  
  curl_close($ch);  
  return $data;    
}
 ?>


