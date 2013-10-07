<?php


$twitter_endpoint = "http://urls.api.twitter.com/";

//SAMPLE USE
//$urls = array("http://biodiversitydatajournal.com/articles.php?id=995", "http://dx.doi.org/10.3897/BDJ.1.e995");
//print twitter_get_tweet_count($urls);
//-----------------------------------


//Function allows for an array to be passed, for example containg a dx.doi.org URL and one for journal's website of same paper
function twitter_get_tweet_count($urls) {
	if (!is_array($urls)) {
		$urls = array($urls);
	}
	$count = 0;
	global $twitter_endpoint;
	$twitter_request_url = $twitter_endpoint . "1/urls/count.json?url=";
	foreach ($urls as $url) {
	  $twitter_response = json_decode(file_get_contents($twitter_request_url.$url));
	  $count += $twitter_response->count;
	}
	return $count;
}