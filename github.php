<?php

$github_endpoint = "https://api.github.com/";


function github_get_commit_count($username) {
  global $github_endpoint;
  $repos = github_get_repos($username);
  $count = 0;
  foreach ($repos as $name => $data) {
  	$request = $github_endpoint."repos/".$name."/git/commits";
  	$response = json_decode(getSslPage($request));
  	$count += sizeof($response);
  }
  return $count;
}

function github_get_repos($username) {
  global $github_endpoint;
  $repos = array();
  $request = $github_endpoint."users/".$username."/repos";
  $response = json_decode(getSslPage($request));
  foreach ($response as $repo) {
  	$repos[$repo->name]['author'] = $repo->owner->login; 
  }
  return $repos;
}

function getSslPage($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}