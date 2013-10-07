<?php

//SAMPLE USE
//print(resolve_doi("10.3897/BDJ.1.e995"));
//-----------------------------------

//Get URL of a resource from a DOI
function resolve_doi($doi){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $url = "http://dx.doi.org/".$doi;
  
  curl_setopt($ch, CURLOPT_URL, $url);
  $out = curl_exec($ch);
  // line endings is the wonkiest piece of this whole thing
  $out = str_replace("\r", "", $out);
  // only look at the headers
  $headers_end = strpos($out, "\n\n");
  if($headers_end !== false){
    $out = substr($out, 0, $headers_end);
  }
  $headers = explode("\n", $out);
  foreach($headers as $header){
    if(substr($header, 0, 10) == "Location: "){
      $target = substr($header, 10);
      return $target;
    }
  }
  return FALSE;
}