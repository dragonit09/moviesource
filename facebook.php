<?php

function GetID_FB($link){
    preg_match('/https:\/\/www.facebook.com\/(.*)\/videos\/(.*)\/(.*)\/(.*)/U', $link, $id);
    if(isset($id[4])){
        $result = $id[3];
    } else {
        preg_match('/https:\/\/www.facebook.com\/(.*)\/videos\/(.*)\/(.*)/U', $link, $id); // link dạng https://www.facebook.com/userName/videos/IDVideo/
        if(isset($id[3])){
            $result = $id[2];
        }else{
            preg_match('/https:\/\/www.facebook.com\/groups\/(.*)\/permalink\/(.*)/', $link, $id); // link dạng https://www.facebook.com/groups/IDGroups/permalink/IDVideo/
            $result = $id[2];
            $result = substr($result, 0, -1);
        }
    }
    return $result;
}

function Facebook_Groups($curl,$token) {
  $id = GetID_FB($curl);
  $get = AnimeVN_Source("https://graph.facebook.com/{$id}?access_token={$token}");
  $data = json_decode($get,true);
  $id_vpt = $data['object_id'];
  $source = AnimeVN_Source("https://graph.facebook.com/{$id_vpt}?access_token={$token}");
  $link = json_decode($source,true);
  if($link['source']){
    $result[] = array('file' => $link['source'], 'label' => 'Auto', 'type' => 'video/mp4');
  }
  return json_encode($result,JSON_PRETTY_PRINT);
}
$url =$_GET['url'];
function Facebook_Fanpage($curl,$token) {
  $id = GetID_FB($curl);
  $get = AnimeVN_Source("https://graph.facebook.com/{$id}?access_token={$token}");
  $data = json_decode($get,true);
  if($data['source']){
    $result[] = array('file' => $data['source'], 'label' => 'Auto', 'type' => 'video/mp4');
  } 
  return json_encode($result,JSON_PRETTY_PRINT);
}
function GetFB($curl,$token){
  if(strpos($curl, 'groups') !== false){
          $link = Facebook_Groups($curl,$token);
        } else {
          $link = Facebook_Fanpage($curl,$token);
        }
    return $link;
}
$token = 'EAAAAUaZA8jlABAOdJjawUNXiXzFpr8ZBSsFkvZAkevARQNArT7wj3X6PlZAdc1ywx1DdihsMXXkxUifI423QJWZBlqMZCpZC9eLsX7Koo9PI9guW7L6xVUjr5HHW1CscdflexuayIs5MNya2PX3M8cWspKQPzHqZCHJmXFtRNkX1MZCXx19piWZB5K';

?>