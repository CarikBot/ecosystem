<?php
/**
 * DevC Jakarta Volunteer Award
 * 
 * USAGE
 *   curl "http://ecosystem.carik.test/services/community/devc-jakarta/form-award/" -d "@body-award.json"
 * 
 * @date       15-05-2022 17.01
 * @category   community
 * @package    DevC Jakarta Volunteer Award
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

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
date_default_timezone_set("Asia/Jakarta");
require_once "../../lib/lib.php";
require_once "../../lib/GoogleForm_lib.php";
require_once "../../config.php";

const VOLUNTEER_LIST = [
  'Adrian',
  'Aisy',
  'Arfi',
  'Bastian',
  'Esa',
  'Gazandi',
  'Ian',
  'Imam',
  'Ina Mutia',
  'Maksum Rifai',
  'Mutia',
  'Rivki',
  'Ryan'
];
const FORM_ID_OWNERSHIP = 'entry.370750581';
const FORM_ID_HELPFUL = 'entry.152991165';
const FORM_ID_COUNTON = 'entry.1829913481';
const FORM_ID_THOUGHTS = 'entry.1734852776';

$UserId = @$RequestContentAsJson['data']['user_id'];
$FullName = @$RequestContentAsJson['data']['FullName'];
$Date = date("Y-m-d H:i:s");
$DateAsInteger = strtotime($Date);
$fileName = "./data/$UserId.txt";

if ('CANCEL' == @$RequestContentAsJson['data']['submit']){
  OutputWithReaction(0, "Pengisian form *DevC Jakarta Volunteer Award* telah dibatalkan.\nTerima kasih.", 'sad');
}

if ('OK' != @$RequestContentAsJson['data']['submit']){
  $str = readTextFile($fileName);
  if (!empty($str)){
    $Text = "Maaf, form ini hanya bisa diisi 1x saja.";
    $Text .= "\nSilakan hubungi DevC Lead jika kamu ingin mengisi ulang form ini";
    $Text .= "\nTerima kasih.";
    OutputWithReaction(0, $Text, 'sorry');
  }

  // Build your question here
  $Text = "*DevC Jakarta Volunteer Award*";
  $Text .= "\nSilakan isi form berikut ini.";
  $Text .= "\n";

  // general question
  $generalQuestion[] = AddQuestion('option', 'ownership', "The one who take ownership[.](https://lh4.googleusercontent.com/jIDHE6klz3IVBuphYcnJFvA6-RE6KvBsCqy6ooOTJDuiLW3mKQtJrHvqt9dRw_76et3-qSAeNjUkKjgots-DjsqQLRuvEL6PKTNn8ITJFIm3XsGouQu3ktntutRg-aoknA=w740)", ["options"=>VOLUNTEER_LIST]);
  $generalQuestion[] = AddQuestion('option', 'helpful', "The one who help you the most[.](https://lh5.googleusercontent.com/25Xh675qYCQ0uokfENFzlh5KFRWk_fUrtyzUoiEMKcQt5Ec2vX0FIuSq_W5bJN2DgfIQhY1vCM3lyLd7qrBmqIgG26Z4cGcxLEfpbmzeXlZQ--aNzomf14kiePnsEwDYqw=w739)", ["options"=>VOLUNTEER_LIST]);
  $generalQuestion[] = AddQuestion('option', 'counton', "The one you can count on to[.](https://lh4.googleusercontent.com/iKtRbxr31wOQpH4_1UkgwPmL1Mvb6xYDYPik-sCWDDccArK88GvcldIeuEwqzoivrT6f1nS7jLfOu2CpvwxJwuOFflFIK1dh__MGDlKFRgkaXzf5skNm3MPZbAtgOtqEng=w740)", ["options"=>VOLUNTEER_LIST]);
  $generalQuestion[] = AddQuestion('string', 'thoughts', "Any thoughts?");

  $questionData[] = $generalQuestion;

  $url = GetBaseUrl() . '/services/community/devc-jakarta/form-award/';
  OutputQuestion( $Text, $questionData, $url, 'Volunteer Award');
}

// Processing Data
$Data = $RequestContentAsJson['data'];

// Save History
$postData = [
  FORM_ID_OWNERSHIP => $Data['ownership_t'],
  FORM_ID_HELPFUL => $Data['helpful_t'],
  FORM_ID_COUNTON => $Data['counton_t'],
  FORM_ID_THOUGHTS => $Data['thoughts'],
];
$str = $Date . '|' . json_encode($postData, true);
writeTextFile($fileName, $str);

// Submit to GFORM
$GFA = new GoogleFormAutomation;
$GFA->FormId = @$Config['packages']['community']['devc-jakarta']['award_form_id'];
if (!$GFA->Submit($postData)){
  $Text = "Maaf, gagal dalam penyimpanan data.\nSilakan hubungi DevC Jakarta Lead.";
  OutputWithReaction(400, $Text, 'sorry');
};

$Text = "Hi $FullName, isian form DevC Jakarta Volunteer Award sudah saya terima.";
$Text .= "\nTerima kasih dan sehat selalu.";
OutputWithReaction(0, $Text, 'love');
