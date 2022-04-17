<?php
/**
 * MBTI Test
 * ref:
 *   https://www.16personalities.com/id/tes-kepribadian 
 * 
 * USAGE:
 *   curl "http://localhost:8001/mbti16.php" -d "@body-mbti16.json"
 *   curl "http://ecosystem.carik.id/services/health/personality/mbti16/"  -d "@body-mbti16.json"
 *   
 *
 * @date       17-04-2022 13:25
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
require_once "../../config.php";
date_default_timezone_set('Asia/Jakarta');

const REGEX_EXPRESSION = '/(?<value>(?<=\()[A-Za-z](?=\)))/';
const JENIS_KELAMIN = ['', 'Laki-laki', 'Perempuan'];
const OPTIONS_TEXT = [
  "Sangat Setuju Sekali",
  "Sangat Setuju",
  "Setuju",
  "Biasa aja",
  "Tidak Setuju",
  "Sangat Tidak Setuju",
  "Sangat Tidak Setuju Sekali"  
];

$UserId = @$RequestContentAsJson['user_id'];
$FullName = @$RequestContentAsJson['full_name'];
$Date = date("Y-m-d H:i:s");
$DateAsInteger = strtotime($Date);

$content = readTextFile('ref/mbti16.json');
$dataTest = json_decode($content, true);

if (!isset($RequestContentAsJson['data']['submit'])){
  //Build quetions  
  $dataOptions['options'] = OPTIONS_TEXT;
  $questionNumber = 0;
  foreach ($dataTest as $item) {
    $questionNumber++;
    $label = "a".$questionNumber;
    $title = $item['text'];
    $questions[] = AddQuestion('option', $label, $title, $dataOptions);
    //if (3==$questionNumber) break;
  }
  //shuffle($questions);

  $Text = "*MBTI Test*\nTes MBTI ini bertujuan untuk menemukan diri dalam 16 tipe kepribadian MBTI. Kenali lebih jauh dirimu untuk berkembang setidaknya satu persen setiap harinya!";
  $Text .= "Pilihlah salah satu pernyataan yang paling sesuai dengan diri Anda dengan mengetik angka sesuai pilihan anda.";
  $Text .= "\n\n- Tidak ada jawaban yang benar atau salah dalam test ini.";
  $Text .= "\n- Kerjakan dengan sungguh2 dan jawab jujur sesuai dengan kepribadianmu.";
  $Text .= "\n- Jika kamu keluar di tengah tes, maka seluruh proses tes dan jawaban akan hilang.";
  $Text .= "\n- Cari tempat yang nyaman dan kondusif supaya kamu lebih fokus.";
  $Text .= "\n- Hasil tes bisa kamu dapatkan setelah mengisi semua pertanyaan dengan lengkap.";
  $Text .= "\n";


  $generalQuestion[] = AddQuestion('option', 'jenisKelamin', "#Jenis Kelamin", ["options"=>['Laki-laki', 'perempuan']]);
  $generalQuestion[] = AddQuestion('string', 'institution', "#Nama komunitas/perkumpulan/organisasi/kantor/instansi/lembaga");
  $questionData[] = $generalQuestion;
  $questionData[] = $questions;

  $url = GetBaseUrl() . '/services/health/personality/mbti16/';
  OutputQuestion( $Text, $questionData, $url, 'MBTI Test');
}

// Processing
$institution = strtoupper($RequestContentAsJson['data']['institution']);
$jenisKelamin = $RequestContentAsJson['data']['jenisKelamin'];
$jenisKelamin = JENIS_KELAMIN[$jenisKelamin];
$Data = $RequestContentAsJson['data'];

$questions = [];
foreach ($Data as $key => $value) {
  preg_match('/^a([0-9]*)$/', $key, $matches);
  if (count($matches)==0) continue;
  $answerIndex = $matches[1];
  $realValue = $value-4;

  $questionText = $dataTest[$answerIndex-1]['text'];
  $questions[] = [
    "text" => $questionText,
    "answer" => $realValue
  ];
}

// build raw data 16perso
$output['questions'] = $questions;
$output['gender'] = null;
$output['inviteCode'] = '';
$output['teamInviteKey'] = '';
$output['extraData'] = [];
$outputAsJsonString = json_encode($output);

$options = [
  "http" => [
      "method" => "POST",
      'header'=> "Content-type: application/json\r\n"
        . "Content-Length: " . strlen($outputAsJsonString) . "\r\n",
      'content' => $outputAsJsonString
  ]
];
$context = stream_context_create($options);
$url = 'https://www.16personalities.com/id/hasil-tes';
$result = file_get_contents($url, false, $context);
if (empty($result)){
  //TODO: save current data
  Output("Maaf, penghitungan hasil test tidak berhasil.");
}
$result = @json_decode($result, true)['redirect'];
$testResult = strstr($result, '-');
$testResult = strtoupper(str_replace('-', '', $testResult));

$Text = "Hai $FullName, hasil test MBTI kamu adalah:";
$Text .= "\n*$testResult*";
$Text .= "\n";
$testResult = strtolower($testResult);
$description = readTextFile( "data/mbti-$testResult.txt");
$Text .= "\n".$description;

// test report
$code = sha1($UserId.$DateAsInteger);
$url = "https://carik.id/personality-test/?id=$code";
$Text .= "\nHasil test anda bisa dilihat melalui [tautan ini]($url)";

//TODO: save result test to system

// submit to system
$GFA = new GoogleFormAutomation;
$GFA->FormId = $Config['packages']['health']['personality']['googleform_id'];
$postData = [
  'entry.1497848011' => $code,
  'entry.129360943' => $UserId,
  'entry.1157306265' => strtoupper($FullName),
  'entry.382061660' => $jenisKelamin,
  'entry.558529546' => strtoupper($RequestContentAsJson['data']['institution']),
  'entry.850495111' => 'MBTI2',
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
  preg_match(REGEX_EXPRESSION, $AText, $matches);
  if (count($matches)>0){
    $answerValue = $matches['value'];
    $AText = trim(str_replace("($answerValue)", '', $AText));
  }
  return $AText;
}
