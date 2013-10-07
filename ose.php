<?php

$ose_id = "member-98c498639d";
$ose_sk = "d94fe1c53cb6491aec07534a1f1b794b";
$ose_url = "http://lsapi.seomoz.com/linkscape/url-metrics/";

ose_get_link_count("http://ebaker.me.uk");

function ose_get_link_count($url) {
  global $ose_url;
  global $ose_id;
  $signature = ose_generate_signature();
  $request = $ose_url.urlencode($url)."?cols=3072&AccessID=".$ose_id."&Expires=".$signature['expires']."&Signature=".$signature['signature'];
  $response = json_decode(file_get_contents($request));
  $return = array();
  if (is_object($response)){
  	  $return['links_all'] = $response->uid;
  	  $return['links_ext'] = $response->ueid;
  	  $return['links_int'] = $return['links_all'] - $return['links_ext'];
  }
  return $return;
}

function ose_generate_signature() {
  global $ose_id;
  global $ose_sk;
  $expires  = time() + 300;
  $sign_str = $ose_id."\n".$expires;
  $sign_bin = hash_hmac('sha1', $sign_str, $ose_sk, true);
  $sign_url = urlencode(base64_encode($sign_bin));
  return array(
    'expires'   => $expires,
    'signature' => $sign_url,
  );
}
//http://lsapi.seomoz.com/linkscape/url-metrics/moz.com%2fblog?Cols=4&AccessID=member-cf180f7081&Expires=1225138899&Signature=LmXYcPqc%2BkapNKzHzYz2BI4SXfC%3D
