<?php

include_once('facebook.php');
include_once('twitter.php');
include_once('mendeley.php');
include_once('scholar.php');
include_once('doi.php');
include_once('github.php');
include_once('ose.php');

if (isset($_GET['url'])) {
  process_url($_GET['url']);
}
	
if (isset($_GET['doi'])) {
  process_doi($_GET['doi']);
}

if (isset($_GET['scholar_id'])) {
  process_google_Scholar($_GET['scholar_id']);
}

function process_url($url) {
  print "<h2>[Web content demo] Stats for <a href='$url'>$url</a></h2>";
  print "Facebook shares: ".facebook_get_share_count($url)."<br/>";
  print "Twitter shares:".twitter_get_tweet_count($url)."<br/>";
  $link_counts = ose_get_link_count($url);
  print "On site links to page: ".$link_counts['links_int']."<br/>";
  print "External links to page: ".$link_counts['links_ext'];
}

function process_doi($doi) {
  $urls = array();
  $urls[] = "http://dx.doi.org/".$doi;
  $doi_url = resolve_doi($doi);
  if ($doi_url != FALSE) {
  	$urls[] = $doi_url;
  }
  print "<h2>[Publication demo] Stats for <a href='$doi_url'>$doi</a></h2>";
  print "Mendeley reads: ".mendeley_get_readers($doi)."<br/>";
  print "Facebook shares: ".facebook_get_share_count($doi_url)."<br/>";
  print "Twitter shares: ".twitter_get_tweet_count($urls)."<br/>";
}

function process_google_scholar($scholar_id) {
  print "<h2>[user demo] Google Scholar stats for id <a href='http://scholar.google.co.uk/citations?hl=en&user=$scholar_id'>$scholar_id</a></h2>";
  print "<PRE>";
  print_r(google_scholar_get_stats($scholar_id));
  print "</PRE>";
}

include_once('sf.php');