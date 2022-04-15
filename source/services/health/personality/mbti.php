<?php
/**
 * MBTI Test
 * 
 * USAGE:
 *   curl "http://localhost:8001/mbti.php" -d "@body-mbti.json"
 *   
 *
 * @date       14-04-2022 15:25
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

const REGEX_EXPRESSION = '/(?<value>(?<=\()[A-Za-z](?=\)))/';
const JENIS_KELAMIN = ['', 'Laki-laki', 'Perempuan'];
const MBTI_FILE = "ref/mbti.xlsx";

$UserId = @$RequestContentAsJson['UserID'];
$FullName = @$RequestContentAsJson['FullName'];
$Date = date("Y-m-d H:i:s");
$DateAsInteger = strtotime($Date);

if (!isset($RequestContentAsJson['data']['submit'])){
  //Build quetions
  if (!( $xlsx = SimpleXLSX::parse(MBTI_FILE))) {
    Output(0, "Maaf, sedang gangguan simulasi testing.");
  }
  
  $questions = [];
  $sheets = $xlsx->sheetNames();
  $questionNumber = 0;
  foreach ($sheets as $sheetIndex => $sheetName) {
    $rowIndex = 0;
    foreach ( $xlsx->rows($sheetIndex) as $r ) {
      $questionNumber++;
      $label = "q".$questionNumber;

      $options = [];
      $data = [];
      $options[] = cleanUpTitle($r[0]);
      $options[] = cleanUpTitle($r[3]);
      $data['options'] = $options;
      $data['values'] = [$r[1],$r[2]];
      $questions[] = AddQuestion('option', $label, "#", $data);
      //if (3==$questionNumber) break;
    };
  }
  shuffle($questions);

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

  $url = GetBaseUrl() . '/services/health/personality/mbti/';
  OutputQuestion( $Text, $questionData, $url);  
}

// Processing
$jenisKelamin = $RequestContentAsJson['data']['jenisKelamin'];
$jenisKelamin = JENIS_KELAMIN[$jenisKelamin];

$Data = $RequestContentAsJson['data'];
$score['I'] = 0;
$score['E'] = 0;
$score['S'] = 0;
$score['N'] = 0;
$score['T'] = 0;
$score['F'] = 0;
$score['J'] = 0;
$score['P'] = 0;
$total = 0;
foreach ($Data as $key => $value) {
  $value = strtoupper($value);
  if (!isset($score[$value])) continue;
  $score[$value] = $score[$value] + 1;
  $total++;
}
$testResult = ($score['I'] > $score['E']) ? 'I' : 'E';
$testResult .= ($score['S'] > $score['N']) ? 'S' : 'N';
$testResult .= ($score['T'] > $score['F']) ? 'T' : 'F';
$testResult .= ($score['J'] > $score['P']) ? 'J' : 'P';

//TODO: Check validasi data

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

// submit to system
$GFA = new GoogleFormAutomation;
$GFA->FormId = $Config['packages']['health']['personality']['googleform_id'];
$postData = [
  'entry.1497848011' => $code,
  'entry.129360943' => $UserId,
  'entry.1157306265' => strtoupper($FullName),
  'entry.382061660' => $jenisKelamin,
  'entry.558529546' => strtoupper($RequestContentAsJson['data']['institution']),
  'entry.850495111' => 'MBTI',
  'entry.665691566' => strtoupper($testResult)
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
