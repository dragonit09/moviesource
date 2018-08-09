<?php 
function GetArchive($url){

   $embed = str_replace('/details/','/embed/',$url);

    $get = AnimeVN_Source($embed);

    preg_match_all('/"file":"(.*?)","type":"(.*?)","height":"(.*?)"/',$get,$StreamInfo);
    
    $Label = $StreamInfo[3];
    $Type = $StreamInfo[2];
    $StreamUrl = $StreamInfo[1];

    $Result = Array();
    for ($i = 0; $i < count($StreamUrl); $i++)
    {
      if ($Type[$i]=='mp4') {

        $Result[$i]['label'] = $Label[$i];
        $Result[$i]['type'] = $Type[$i];
        $Result[$i]['file'] = 'https://archive.org'.$StreamUrl[$i];
      }
    
      
    }

return json_encode($Result,JSON_PRETTY_PRINT);
}
 ?>