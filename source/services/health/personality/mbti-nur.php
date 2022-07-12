<?php
/**
 * MBTI Test
 * sumber data:
 *   Nur Hidayat, @hidayat365
 * 
 * USAGE:
 *   curl "http://localhost:8001/mbti-nur.php" -d @body-mbti-nur.json
 *   
 *
 * @date       30-05-2022 11.29
 * @category   Router
 * @package    router tools
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
ini_set("allow_url_fopen", 1);
require_once "../../lib/lib.php";
require_once "../../lib/GoogleForm_lib.php";
require_once "../../lib/simplexlsx/src/SimpleXLSX.php";
require_once "../../config.php";
date_default_timezone_set('Asia/Jakarta');

$UserId = @$RequestContentAsJson['user_id'];
$FullName = @$RequestContentAsJson['full_name'];
if (empty($UserId)) $UserId = @$RequestContentAsJson['data']['user_id'];
if (empty($FullName)) $FullName = @$RequestContentAsJson['data']['FullName'];
$Date = date("Y-m-d H:i:s");
$DateAsInteger = strtotime($Date);

const MBTI_FILE = "ref/mbti-nur.xlsx";

if ('CANCEL' == @$RequestContentAsJson['data']['submit']){
    Output(0, "Pengisian form Test MBTI (n) telah dibatalkan.\nTerima kasih.");
}

if ('OK' != @$RequestContentAsJson['data']['submit']){
    if (isGroupChat()){
        Output(0, "Maaf, karena berkaitan dengan privasi, fitur ini hanya untuk _direct-chat_ ke Carik saja.");
    }
    if (!( $xlsx = SimpleXLSX::parse(MBTI_FILE))) {
        Output(0, "Maaf, sedang gangguan simulasi testing.");
    }
    // Build your question here
    $Text = "*Test MBTI* (n)";
    $Text .= "\n*Instruksi:*";
    $Text .= "\n Pilih mana yang lebih sesuai dengan diri Anda.";
    $Text .= "\n";

    $questions = [];
    $sheets = $xlsx->sheetNames();
    $questionNumber = 0;
    foreach ($sheets as $sheetIndex => $sheetName) {
        foreach ( $xlsx->rows($sheetIndex) as $r ) {
            $questionNumber++;
            $label = "q".$questionNumber;
            $options = [];
            $data = [];
            $options[] = cleanUpTitle($r[0]);
            $options[] = cleanUpTitle($r[1]);
            $data['options'] = $options;
            $data['values'] = ['A','B'];
            $questions[] = AddQuestion('option', $label, "#", $data);      
        }
    }
    $questionData[] = $questions;

    $url = GetBaseUrl() . '/services/health/personality/mbti-nur/';
    OutputQuestion( $Text, $questionData, $url, 'Test MBTI (nur)');
  
}

// Processing Data
$Data = $RequestContentAsJson['data'];

//EI
$A = 0; $B = 0;
for ($i = 1; $i <= 7; $i++) {
    $value = $Data["q$i"];
    if ('A'==$value) $A++;
    if ('B'==$value) $B++;
}
$EI = ($A > $B) ? 'E' : 'I';

//SN
$A = 0; $B = 0;
for ($i = 8; $i <= 14; $i++) {
    $value = $Data["q$i"];
    if ('A'==$value) $A++;
    if ('B'==$value) $B++;
}
$SN = ($A > $B) ? 'S' : 'N';

//TF
$A = 0; $B = 0;
for ($i = 8; $i <= 14; $i++) {
    $value = $Data["q$i"];
    if ('A'==$value) $A++;
    if ('B'==$value) $B++;
}
$TF = ($A > $B) ? 'T' : 'F';

//JP
$A = 0; $B = 0;
for ($i = 8; $i <= 14; $i++) {
    $value = $Data["q$i"];
    if ('A'==$value) $A++;
    if ('B'==$value) $B++;
}
$JP = ($A > $B) ? 'J' : 'P';

$testResult = "$EI$SN$TF$JP";

$Text = "Hai $FullName, hasil test MBTI kamu adalah:";
$Text .= "\n*$testResult*";
$Text .= "\n";
$testResult = strtolower($testResult);
$description = readTextFile( "data/mbti-$testResult.txt");
$Text .= "\n".$description;
$Text .= "\n\nSumber tes: @hidayat365";


// Test report
$code = sha1($UserId.$DateAsInteger);
$url = "https://carik.id/personality-test/?id=$code";
$Text .= "\nHasil test anda bisa dilihat melalui [tautan ini]($url)";

// Submit result to system
$jenisKelamin = '';
$intitution = 'NURH';
$testName = 'MBTI(n)';
$GFA = new GoogleFormAutomation;
$GFA->FormId = $Config['packages']['health']['personality']['googleform_id'];
$postData = [
  'entry.1497848011' => $code,
  'entry.129360943' => $UserId,
  'entry.1157306265' => strtoupper($FullName),
  'entry.382061660' => $jenisKelamin,
  'entry.558529546' => $intitution,
  'entry.850495111' => $testName,
  'entry.665691566' => strtoupper($testResult),
  'entry.495695927' => $Date,
  'entry.846529421' => json_encode($Data, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE)
];
if (!$GFA->Submit($postData)){
  Output(400, 'Gagal dalam penyimpanan data.');
};

//die($Text);
Output(0, $Text);

function cleanUpTitle($AText){
    //TODO: filtering text
    return $AText;
}