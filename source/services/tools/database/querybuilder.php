<?php
/**
 * Query Builder
 *
 * USAGE
 *   curl "http://ecosystem.carik.test/services/tools/database/querybuilder/" -d "@payload/query.json"
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_ALL);

require_once "../../config.php";
require_once "../../lib/lib.php";
require_once('../../lib/CarikOpenAI_lib.php');

const BUILDER_PLATFORM = 'openai';

$responsePrefix = [
  "Query yang terbentuk kira-kira seperti informasi berikut"
];
$prefix = $responsePrefix[array_rand($responsePrefix)];

if (empty($UserId)) $UserId = @$RequestContentAsJson['data']['user_id'];
$userInfo = explode('-', $UserId);
$userId = @$userInfo[1];

if (empty($Text)) $Text = @$RequestContentAsJson['data']['original_text'];
$Sentence = @$RequestContentAsJson['data']['sentence'];
$ChannelId = @$RequestContentAsJson['data']['channel_id'];
$DatabaseProduct = @$RequestContentAsJson['data']['database_value'];
if (empty($DatabaseProduct)) $DatabaseProduct = 'sql';
if (empty($Sentence)) $Sentence = @$RequestContentAsJson['data']['reply_from_text'];
if (empty($Sentence)){
  $Text = @file_get_contents('readme.md');
  Output(0, $Text);
}


$cacheLink = (urlencode($Sentence));
if (strlen($cacheLink)>200) $cacheLink = md5($cacheLink);
$cache = readCache($cacheLink, 60);
if (!empty($cache)){
  $Text = "$prefix:\n $cache";
  Output(0, $Text);
}


$question = "Buat query $DatabaseProduct: \"$Sentence\"";

$responseAnswer = false;
if (BUILDER_PLATFORM == 'you'){
  //$YOU = new Carik\You;
  //$responseAnswer = $YOU->Question($userId, $question);  
}
if (BUILDER_PLATFORM == 'openai'){
  $token = @$Config['services']['openai']['token'];
  $AI = new Carik\OpenAI;
  $AI->Token = $token;
  $result = $AI->ChatCompletition($question);
  if ($result !== false){
    $choices = $result['choices'];
    $text = '';
    foreach ($choices as $choice) {
      $text = @$choice['message']['content']."\n";
    }
    $text = str_replace('?\n\n', '', $text);
    $text = str_replace("?\n\n", '', $text);
    $text = str_replace("*", '\*', $text);
    $text = str_replace("_", '\_', $text);
    //$text = str_replace("_", '', $text);
    $text = str_replace('""', '"', $text);
    $text = trim($text);
    $responseAnswer['code'] = 0;
    $responseAnswer['text'] = $text;
  }
}

if ($responseAnswer == false){
  Output(0, "Maaf, lagi ga bisa bikin query. Masih pusinggg.... Nanti aja dulu yaa.\nMakasih");
}

$answer = @$responseAnswer['text'];
if (empty($answer)){
  Output(0, "Maaf, lagi ga bisa bikin query. Masih pening nihh.... Nanti aja dulu yaa.\nMakasih");
}
if ($ChannelId=='telegram'){
  $answer = str_replace('_', '\_', $answer);
}

writeCache($cacheLink, $answer);

$Text = "$prefix:\n $answer";
Output(0, $Text);
