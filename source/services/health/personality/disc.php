<?php
/**
 * DISC Test
 * 
 * USAGE:
 *   curl "http://localhost:8001/disc.php" -d "@body-disc.json"
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
require_once "../../config.php";

const REGEX_EXPRESSION = '/(?<value>(?<=\()[A-Za-z](?=\)))/';
const JENIS_KELAMIN = ['', 'Laki-laki', 'Perempuan'];

$UserId = @$RequestContentAsJson['UserID'];
$FullName = @$RequestContentAsJson['FullName'];
$Date = date("Y-m-d H:i:s");
$DateAsInteger = strtotime($Date);

if (!isset($RequestContentAsJson['data']['submit'])){
  //Build quetions
  $discContent = readTextFile( 'ref/disc.txt');
  $discContent = str_replace("\r\n", "\n", $discContent);
  $discLine = strtok($discContent, PHP_EOL);

  $index = 1;
  $options = [];
  $values = [];
  $questionNumber = 1;
  while ($discLine !== FALSE) {
    $label = "q".$questionNumber;
    if ($index>1){
      $answerValue = '';
      preg_match(REGEX_EXPRESSION, $discLine, $matches);
      if (count($matches)>0){
        $answerValue = $matches['value'];
      }
      $title = trim(str_replace("($answerValue)", '', $discLine));
      $options[] = substr($title, 3);
      $values[] = $answerValue;
    }
    $discLine = strtok(PHP_EOL);
    $index++;
    if ($index==6) {
      $index = 1;
      $questionNumber++;
      $data['options'] = $options;
      $data['values'] = $values;
      $section03[] = AddQuestion('option', $label, "#", $data);
      $options = [];
      $values = [];
    }
    //if (3==$questionNumber) break;
  }
  shuffle($section03);

  $Text = "*DISC Test*\nPilihlah salah satu pernyataan yang paling sesuai dengan dirimu dengan mengetik angka sesuai pilihanmu.";
  $Text .= "\n\n- Tidak ada jawaban yang benar atau salah dalam test ini.";
  $Text .= "\n- Kerjakan dengan sungguh2 dan jawab jujur sesuai dengan kepribadianmu.";
  $Text .= "\n- Jika kamu keluar di tengah tes, maka seluruh proses tes dan jawaban akan hilang.";
  $Text .= "\n- Hanya perlu waktu kurang dari setengah jam untuk mengerjakan test ini.";
  $Text .= "\n- Cari tempat yang nyaman dan kondusif supaya kamu lebih fokus.";
  $Text .= "\n- Hasil tes bisa kamu dapatkan setelah mengisi semua pertanyaan dengan lengkap.";
  $Text .= "\n";
  


  $section01[] = AddQuestion('option', 'jenisKelamin', "#Jenis Kelamin", ["options"=>['Laki-laki', 'perempuan']]);
  $section01[] = AddQuestion('string', 'institution', "#Nama komunitas/perkumpulan/organisasi/kantor/instansi/lembaga");
  $questionData[] = $section01;
  $questionData[] = $section03;

  $url = GetBaseUrl() . '/services/health/personality/disc/';
  OutputQuestion( $Text, $questionData, $url);  
}

// Processing
$jenisKelamin = $RequestContentAsJson['data']['jenisKelamin'];
$jenisKelamin = JENIS_KELAMIN[$jenisKelamin];

$Data = $RequestContentAsJson['data'];
$score['D'] = 0;
$score['I'] = 0;
$score['S'] = 0;
$score['C'] = 0;
$total = 0;
foreach ($Data as $key => $value) {
  $value = strtoupper($value);
  if (!isset($score[$value])) continue;
  $score[$value] = $score[$value] + 1;
  $total++;
}
arsort($score);

$Text = "Hai $FullName, hasil test DISC kamu adalah:";
$discDominan = "";
$testResult = "";
foreach ($score as $key => $value) {
  $testResult .= "$key";
  if (empty($discDominan)) $discDominan = $key;
}
//$Text .= "\n*$testResult*";
$Text .= "\n";

$discDominan = strtolower($discDominan);
$description = readTextFile( "data/disc-$discDominan.txt");
$Text .= $description;

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
  'entry.850495111' => 'DISC',
  'entry.665691566' => $testResult
];
if (!$GFA->Submit($postData)){
  Output(400, 'Gagal dalam penyimpanan data.');
};

//die($Text);
Output(0, $Text);
