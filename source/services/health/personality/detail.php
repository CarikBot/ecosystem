<?php
/**
 * USAGE
 *   curl "http://localhost:8001/detail.php?keyword=estj"
 * 
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set("allow_url_fopen", 1);
require_once "../../lib/lib.php";
require_once "../../config.php";

const DISC_RESULT = [
  "D" => "Dominance",
  "I" => "Influence",
  "S" => "Steadiness",
  "C" => "Conscientiousness"
];

$Keyword = strtolower(urldecode(@$_GET['keyword']));
if (empty($Keyword)){
  Output(404, 'Maaf, parameter tidak lengkap.');
}
$testName = 'mbti';


$fileName = 'data/'.strtolower($testName.'-'.$Keyword).'.txt';
$description = readTextFile($fileName);
if (empty($description)){
  Output(404, 'Maaf, informasi tidak ditemukan.');
}
$description = str_replace('Ciri-ciri', '*Ciri-ciri*', $description);

if (1==@$_GET['html']){
  $description = preg_replace('/(?:\*)(?:(?!\s))((?:(?!\*|\n).)+)(?:\*)/', '<b>${1}</b>', $description);
  $description = preg_replace('/(?:\_)(?:(?!\s))((?:(?!\_|\n).)+)(?:\_)/', '<i>${1}</i>', $description);
  $description = str_replace("\n", "<br>", $description);
  $description = str_replace("\r", "", $description);
  $description = preg_replace('/(ENFJ|ENFP|ENTJ|ENTP|ESFJ|ESFP|ESTJ|ESTP|INFJ|INFP|INTJ|INTP|ISFJ|ISFP|ISTJ|ISTP)/', '<a href="/personality/${1}">${1}</a>', $description);
}

//die($description);
Output(0, $description);
