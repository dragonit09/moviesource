<?php 

function GETVTV($url){
	preg_match('#https://www.vtvgiaitri.vn/video/(.+)-(.+)-(.+)#',$url,$data);

	$get = AnimeVN_Source("https://www.vtvgiaitri.vn/api/v1/title/$data[1]/season/$data[2]/episode/$data[3]/video");

	preg_match('/"stream":"(.*?)"/',$get,$link_stream);

	
	$Result = Array();
		for ($i = 0; $i < count($link_stream[1]); $i++)
		{
			$Result[$i]['file'] = $link_stream[1];
			$Result[$i]['type'] = 'mp4/video';
		}

	
    return json_encode($Result, JSON_PRETTY_PRINT);
}
 ?>