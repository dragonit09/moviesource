<?php 

function Bioskop45($url){
	$get = AnimeVN_Source($url);
	preg_match('/sources:(.*)/i',$get,$sources);

	
	preg_match_all('/file:"(.*?)",type:"(.*?)",label:"(.*?)"/i',$sources[0], $InfoLink);
	
	

	$File = $InfoLink[1];
	$Type = $InfoLink[2];
	$Label = $InfoLink[3];

	$Result = Array();
	for ($i=0; $i <count($File) ; $i++) { 

		$Result[$i]['file'] = $File[$i];
		$Result[$i]['type'] = $Type[$i];
		$Result[$i]['label'] = $Label[$i];
		
	}

	return json_encode($Result, JSON_PRETTY_PRINT);
}


 ?>