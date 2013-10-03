<?php

$mendeley_consumer_key = "87694469dd54b12976b5c8476f56e1190524c09f3";
$mendeley_endpoint = "http://api.mendeley.com/oapi/";

print(mendeley_get_readers("10.1145/1323688.1323690"));

function mendeley_get_pub_stats_from_doi($doi) {
  global $mendeley_consumer_key;
  global $mendeley_endpoint;
  $doi_encoded = htmlentities($doi);
  $request = $mendeley_endpoint . 'documents/details/' . $doi_encoded . '?type=doi&consumer_key=' . $mendeley_consumer_key;
  $mendeley_response = file_get_contents($request);
  return json_decode($mendeley_response);
}

//Can pass either a DOI or the returned object from mendeley_get_pub_stats_from_doi()
function mendeley_get_readers($parameter) {
  if (!is_object($parameter)) {
  	$parameter = mendeley_get_pub_stats_from_doi($parameter);
  }
  return $parameter->stats->readers;
}