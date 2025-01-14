<?php
/**
 * Daftar Peserta INL
 *
 * USAGE:
 *   curl "http://ecosystem.carik.test/services/tools/jira/task-list/?package=&status="
 *   curl "http://ecosystem.carik.test/services/tools/jira/task-list/?package=amdalnetdev&status="
 *   curl "http://ecosystem.carik.test/services/tools/jira/task-list/?full=1&package=amdalnetdev&status="
 *
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_NONE);
require_once "../../lib/lib.php";
require_once "../../config.php";

$Full = @$_GET['full'];
$Full = ($Full == 1) ? True : False;
$Package = @urldecode(@$_GET['package']);
$Status = @urldecode(@$_GET['status']);
$Format = @urldecode(@$_GET['format']);
if (empty($Package)) RichOutput(0, "Maaf, parameter informasi yang diminta tidak lengkap.");
if (empty($Status)){
  $Status = @$RequestContentAsJson['data']['$1'];
}
if ($Status == 'todo') $Status = 'TO DO';
if ($Status == 'inprogress') $Status = 'in progress';
if ($Status == 'pending') $Status = 'Pending/Reject';
if ($Status == 'reject') $Status = 'Pending/Reject';
// if ($Status == 'todo') $Status = 'TO DO';
// if ($Status == 'todo') $Status = 'TO DO';
$Status = trim($Status ?? '');
$Package = trim($Package ?? '');

$Text = "*Daftar Task/Issue Project -- ". strtoupper($Status) ." --".strtoupper($Package)."*\n";

if (!empty($Status)){
  $Text .= showIssues($Package, $Status, $Full);

}else{
  $Text .= showIssues($Package, 'in progress', $Full);
  $Text .= "\n";
  $Text .= showIssues($Package, 'to do', $Full);
}

// die($Text);
RichOutput(0, $Text);

function showIssues($APackage, $AStatus, $Full = false){
  $format = @urldecode(@$_GET['format']);
  $text = "\n☑️ *Status: ".strtoupper($AStatus)."*";
  $issues = getIssueList($APackage, $AStatus);
  if (count($issues)>10) $text .= "\nTotal terdapat ".count($issues)." task";
  $i = 1;
  foreach ($issues as $issue) {
    $key = $issue['key'];
    if (empty($key)) continue;
    $title = $issue['fields']['summary'];
    $title = $issue['fields']['summary'];
    $issueURL = "https://$APackage.atlassian.net/browse/$key";
    if ($format == 0){
      $text .= "\n$i. $key: $title";
    }else{
      $text .= "\n$i. $key: [$title]($issueURL)";
    }
    $i++;
    if (!$Full){
      if ($i>10){
        $text .= "\n...";
        break;
      }
    }
  }
  return $text;
}

function getIssueList($APackage, $AStatus){
  $AStatus = urlencode($AStatus);
  $url = str_replace('%package%', $APackage, N8N_JIRA_BASEURL) . "?status=$AStatus";
  $issues = file_get_contents($url);
  if (empty($issues)) return false;
  $issues = json_decode($issues, true);
  return $issues;
}
