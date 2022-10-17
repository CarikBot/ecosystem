<?php
/**
 * Job List in Showwcase
 * 
 * USAGE:
 *   curl "http://planet.carik.test/services/other/workspace/jobs/"
 *
 * 
 * @date       17-10-2022 11.20
 * @category   Other
 * @package    Showwcase
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set("allow_url_fopen", 1);
//error_reporting(E_NONE);

require_once "../../config.php";
require_once "../../lib/lib.php";

const URL = 'https://cache.showwcase.com/jobs/recommended?location[]=Indonesia&fields=id,title,score,views,visits,role,applyUrl,slug,salaryFrom,salaryTo,location,arrangement,type,publishedDate,addons,preferences,company(id,logo,name),stacks&updateCache=true&limit=15&skip=0';
const JOB_URL = 'https://www.showwcase.com/job/';

$jobList = curl_get_file_contents(URL);
if ($jobList == false) Output(400, "Maaf, informasi lowongan pekerjaan di Showwcase belum tersedia.\nSilakan coba lagi nanti.");
$jobList = json_decode($jobList, true);

$Text = "*Info Lowongan Pekerjaan dari Showwcase*";
$Text .= "\n";

foreach ($jobList as $job) {
  $title = $job['title'];
  $company = $job['company']['name'];
  $stacks = "";
  foreach ($job['stacks'] as $stack) {
    $stacks .= $stack['name'].',';
  }
  $stacks = rtrim($stacks, ',');
  $jobUrl = JOB_URL . $job['id'].'-'.$job['slug'];

  $Text .= "\n*$title*";
  $Text .= "\n$company";
  if (!empty($stacks)) $Text .= "\nstack: $stacks";
  $Text .= "\n[Detil]($jobUrl)";
  $Text .= "\n";
}

$applyUrl = "https://www.showwcase.com/";
$buttons[] = AddButtonURL("❗️ Apply", $applyUrl);
$buttonList[] = $buttons;

if ($ChannelId == 'telegram'){
  $actions['button'] = $buttonList;
  RichOutput(0, $Text, $actions);  
}
Output(0, $Text);




