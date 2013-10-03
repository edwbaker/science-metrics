<?php

//SAMPLE USE
$id = "C35K34MAAAAJ";
print_r(google_scholar_get_stats($id));
//-----------------------------------

function google_scholar_get_stats($google_scholar_id){
  $return = array();
  $google_scholar_prefix = "http://scholar.google.co.uk/citations?hl=en&user=";
  $google_scholar_page = file_get_contents($google_scholar_prefix . $google_scholar_id);
  //Scholar HTML is not well formatted - parse manually
  $start = strpos($google_scholar_page, '<table id="stats');
  $google_scholar_page = substr($google_scholar_page, $start);
  $end = strpos($google_scholar_page, '</table');
  $google_scholar_page = substr($google_scholar_page, 0, $end);
  //Get citations
  $match_string = '<td class="cit-borderleft cit-data">';
  $start = strpos($google_scholar_page, $match_string);
  $google_scholar_page = substr($google_scholar_page, $start + strlen($match_string));
  $end = strpos($google_scholar_page, '</td>');
  $citation = substr($google_scholar_page, 0, $end);
  $end = strpos($google_scholar_page, '</tr>');
  $google_scholar_page = substr($google_scholar_page, $end);
  $return['citation_count'] = $citation;
  $start = strpos($google_scholar_page, $match_string);
  $google_scholar_page = substr($google_scholar_page, $start + strlen($match_string));
  $end = strpos($google_scholar_page, '</td>');
  $h_index = substr($google_scholar_page, 0, $end);
  $end = strpos($google_scholar_page, '</tr>');
  $google_scholar_page = substr($google_scholar_page, $end);
  $return['h_index'] = $h_index;
  return $return;
}