<?php  

  function GetPhimTT($curl){  
    $get = AnimeVN_Source($curl);
    preg_match('#episodeID\s= parseInt\(\'(.*)\'\)#', $get,$episodeID);
    preg_match('#filmID = parseInt\(\'(.*)\'\)#', $get,$filmID);
    $array = array(
      'EpisodeID'=>$episodeID[1],
      'filmID'=>$filmID[1],
      'NextEpisode'=>1,
      'passw'=>12345,
      );
     $post_link = 'http://www.phimtt.com/ajax';
  $ch = curl_init();  
  $timeout = 15;  
  curl_setopt($ch, CURLOPT_URL, $post_link);  
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.57 Safari/537.36");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
  curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 0);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
  curl_setopt($ch, CURLOPT_REFERER, $curl); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  curl_setopt($ch, CURLOPT_POST, count($array));
  curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
  $data = curl_exec($ch);  
  curl_close($ch);

  preg_match('/sources:(.*)/', $data,$StreamLink);

  preg_match_all('/file:\s\"(.*?)\",label:\s\"(.*?)\"/', $StreamLink[1], $StreamInfo);

  
  $StreamUrl = preg_replace('/\\\/', '', $StreamInfo[1]);

  $Label = $StreamInfo[2];
  


    $Result = Array();
    for ($i = 0; $i < count($StreamUrl); $i++)
    {
      $Result[$i]['file'] = $StreamUrl[$i];
      
      $Result[$i]['label'] = $Label[$i];
      
      $Result[$i]['type'] = 'mp4/video';
    }

      return json_encode($Result, JSON_PRETTY_PRINT);

  }
 ?>