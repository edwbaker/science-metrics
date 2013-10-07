<h2>[Scholar Factor - partial implemntation]</h2>
<?php
include_once('scholar.php');
include_once('github.php');

$sf = array();

if (isset($_GET['scholar_id'])) {
  $gs_data = google_scholar_get_stats($_GET['scholar_id']);
  $sf['gs']['name']   = 'Google Scholar';
  $sf['gs']['factor'] = $gs_data['h_index'];
  $sf['gs']['multip'] = 1;
}

if (isset($_GET['github_id'])) {
  $sf['gh']['name']   = 'GitHub';
  $sf['gh']['factor'] = github_get_commit_count($_GET['github_id']);
  $sf['gh']['multip'] = 0.02;
}

$count  = 0;
foreach ($sf as $id => $data) {
  print $data['name']." contributes ".$data['factor']." with a weight of ".$data['multip']."<br/>";
  $count += $data['factor'] * $data['multip'];
}

print "<br/><strong>Scholar Factor total = $count";
