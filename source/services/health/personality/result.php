<?php
/**
 * USAGE
 *   curl "http://localhost:8001/result.php?id=f3c2c7b0fb3762b31d9a17f4c31bbeb4370485ef"
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
require_once "../../lib/CarikGoogleScript_lib.php";
require_once "../../config.php";

const DISC_RESULT = [
  "D" => "Dominance",
  "I" => "Influence",
  "S" => "Steadiness",
  "C" => "Conscientiousness"
];

$ID = @$_GET['id'];
//$ID = "8c3553e0e07b3455d39af7e2e5661cb7974bef4e";
if (empty($ID)){
  Output(400, 'Maaf, parameter tidak lengkap.');
}

$GS = new GoogleScript;
$GS->DocId = $Config['packages']['health']['personality']['googlesheet_id'];
$GS->ScriptId = $Config['packages']['health']['personality']['script_id'];
$GS->SheetName = 'Form Responses 1';
$testResult = $GS->Get();
if (empty($testResult)){
  Output(400, 'Maaf, informasi hasil test personaliti belum bisa kami akses.\nTunggu beberapa saat lagi yaa..');
}

$resultInfo = [];
foreach ($testResult as $row) {
  if ($row['Code'] != $ID) continue;
  $resultInfo = $row;
}
if (0==count($resultInfo)){
  Output(404, "Hasil test '$ID' tidak ditemukan.");
}
unset($resultInfo['Keterangan']);

$testName = $resultInfo['Test_Name'];
if ('MBTI2'==$testName) $testName = 'MBTI';
$code = $resultInfo['Test_Result'][0];
if ('MBTI'==$testName) $code = strtolower($resultInfo['Test_Result']);
$fileName = 'data/'.strtolower($testName.'-'.$code).'.txt';
$description = readTextFile($fileName);
$description = str_replace('Ciri-ciri', '*Ciri-ciri*', $description);
$description = preg_replace('/(ENFJ|ENFP|ENTJ|ENTP|ESFJ|ESFP|ESTJ|ESTP|INFJ|INFP|INTJ|INTP|ISFJ|ISFP|ISTJ|ISTP)/', '<a href="/personality/${1}">${1}</a>', $description);
$resultInfo['Description'] = $description;
if ('DISC'==$testName) $resultInfo['Test_Result'] = DISC_RESULT[$resultInfo['Test_Result'][0]];

@header("Content-type:application/json");
$output['code'] = 0;
$output['data'] = $resultInfo;
$output = json_encode($output, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
die($output);
