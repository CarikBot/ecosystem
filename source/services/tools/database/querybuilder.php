<?php
/**
 * Query Builder
 *
 * USAGE
 *   curl "http://ecosystem.carik.test/services/tools/database/querybuilder/" -d "@payload/query.json"
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
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
$DatabaseProduct = @$RequestContentAsJson['data']['database_value'];
if (empty($DatabaseProduct)) $DatabaseProduct = 'sql';
if (empty($Sentence)) $Sentence = @$RequestContentAsJson['data']['reply_from_text'];
if (empty($Sentence)){
  $Text = @file_get_contents('readme.md');
  Output(0, $Text);
}

$question = "Buat query $DatabaseProduct dan informasi dalam bahasa Indonesia: \"$Sentence\"";

$responseAnswer = false;
if (BUILDER_PLATFORM == 'you'){
  //$YOU = new Carik\You;
  //$responseAnswer = $YOU->Question($userId, $question);  
}
if (BUILDER_PLATFORM == 'openai'){
  $token = @$Config['services']['openai']['token'];
  $AI = new Carik\OpenAI;
  $AI->Token = $token;
  $result = $AI->Completition($question);
  if ($result !== false){
    $choices = $result['choices'];
    $text = '';
    foreach ($choices as $choice) {
      $text = @$choice['text']."\n";
    }
    $text = str_replace('?\n\n', '', $text);
    $text = str_replace("?\n\n", '', $text);
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
  Output(0, "Maaf, lagi ga bisa bikinquery. Masih pening nihh.... Nanti aja dulu yaa.\nMakasih");
}

$Text = "$prefix:\n $answer";
Output(0, $Text);
