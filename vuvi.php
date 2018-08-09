<?php 

include 'JavaScriptUnpacker.php';

function GetVuVi($url){
 $get = AnimeVN_Source($url);


$limit = explode("<script type='text/javascript'>",$get);


  $limit = explode('</script>', $limit[4]);




  if (strpos($limit[0], "eval(function(p,a,c,k,e,d)") !== false ){
    $unpacker = new JavascriptUnpacker;

    $link = $unpacker->unpack($limit[0]);

  }else{

    $link = $limit[0];
    
  }



  preg_match_all('/file:"(.*?)"/', $link,$StreamInfo);




        $StreamUrl = preg_replace('/\\\/', '', $StreamInfo[1]);

        $Result= Array();
        for ($i = 0; $i < count($StreamUrl); $i++)
        {
            $Result[$i]['type'] = 'mp4/video';
            $Result[$i]['file'] = $StreamUrl[$i];
        }

        return json_encode($Result, JSON_PRETTY_PRINT);


}





 ?>