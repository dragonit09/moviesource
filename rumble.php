<?php

function GetRumble($curl){

    $get = AnimeVN_Source($curl);
    if (preg_match_all('/\"ua\":{(.*?)}/', $get, $link)) {
      preg_match_all('/\"(.*?)\":\[\"(.*?)\",(.*?)\]/', $link[1][0],$StreamInfo);

  $StreamUrl = $StreamInfo[2];
  $Label     = $StreamInfo[1];

    $Result = Array();
    for ($i = 0; $i < count($StreamUrl); $i++)
    {
      $Result[$i]['file'] = $StreamUrl[$i];
      $Result[$i]['type'] = 'mp4/video';
      $Result[$i]['label'] = $Label[$i];      

    }
    }else{
      preg_match('/source\ssrc=\"(.*?)\"/', $get, $StreamInfo);

      $Result = Array();

      $Result[0]['file'] = $StreamInfo[1];
    $Result[0]['type'] = 'mp4/video';
    $Result[0]['label'] = 'Auto';
      
    }

  

    $link_stream = '';
    if($Result){
        foreach ($Result as $key => $value) {

              $link_stream .= '<jwplayer:source file="'.htmlspecialchars($value['file']).'" label="'.$value['label'].'" type="mp4"/>';
             
        }
    }
    return $link_stream;
  
}


 ?>