<?php
$facebook_endpoint = "http://graph.facebook.com/";

//SAMPLE USE
//$urls = array("http://biodiversitydatajournal.com/articles.php?id=995");
//print facebook_get_share_count($urls);
//-----------------------------------



//Function allows for an array to be passed, for pages with multiple URLs
function facebook_get_share_count($urls) {
	if (!is_array($urls)) {
		$urls = array($urls);
	}
	$count = 0;
	global $facebook_endpoint;
	foreach ($urls as $url) {
	  $facebook_response = json_decode(file_get_contents($facebook_endpoint.urlencode($url)));
	  $count += $facebook_response->shares;
	}
	return $count;
}