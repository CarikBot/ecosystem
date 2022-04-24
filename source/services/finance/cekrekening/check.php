<?php
/**
 * Check Rekening
 * 
 * USAGE:
 *   curl "http://localhost:8001/check.php" -d "@body-check.json"
 *   
 *
 * @date       24-04-2022 23:37
 * @category   Finance
 * @package    Check Rekening
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
require_once "../../config.php";
date_default_timezone_set('Asia/Jakarta');

const BANK_LIST = 'https://cekrekening.id/master/bank?enablePage=0';
const ACCOUNT_CHECK = 'https://cekrekening.id/master/cekrekening/report';

$AvailableBank = [];

$UserId = @$RequestContentAsJson['user_id'];
$FullName = @$RequestContentAsJson['full_name'];
if (empty($UserId)) $UserId = @$RequestContentAsJson['data']['user_id'];
if (empty($FullName)) $FullName = @$RequestContentAsJson['data']['FullName'];
$Date = date("Y-m-d H:i:s");
$DateAsInteger = strtotime($Date);

if ('CANCEL' == @$RequestContentAsJson['data']['submit']){
  Output(0, "Cek Rekening telah dibatalkan.\nTerima kasih");
}

if ('OK' != @$RequestContentAsJson['data']['submit']){
  //Build quetions  
  $Text = "*Cek Rekening*";
  $Text .= "\nAnda ingin bertransaksi online?\nIngin men-transfer sejumlah uang ke rekening yang anda baru kenal?\n*Cek dulu disini!*";
  $Text .= "\nMohon lengkapi pertanyaan berikut.";
  $Text .= "\n";

  // get bank list
  $bank = curl_get_file_contents(BANK_LIST);
  $bank = json_decode($bank, true);
  $bank = $bank['data']['content'];
  foreach ($bank as $item) {
    $AvailableBank[] = $item['bankName'];
    # code...
  }

  $generalQuestion[] = AddQuestion('option', 'bank', "Nama Bank", ["options"=> $AvailableBank]);
  $generalQuestion[] = AddQuestion('string', 'account', "Nomor Rekening");

  $questionData[] = $generalQuestion;

  $url = GetBaseUrl() . '/services/finance/cekrekening/check/';
  OutputQuestion( $Text, $questionData, $url, 'Cek Rekening');
}

// Processing
$Data = $RequestContentAsJson['data'];
$fullName = strtoupper($Data['fullName']);

$Account = $Data['account'];
$Account = str_replace(',', '', $Account);
$Account = str_replace('-', '', $Account);
$Account = str_replace('-', '', $Account);
$Account = str_replace(' ', '', $Account);
$BankId = $Data['bank'];
$postData['bankId'] = $BankId;
$postData['bankAccountNumber'] = $Account;
$postData = json_encode($postData);

$options = [
  "http" => [
      "method" => "POST",
      'header'=> "Content-Length: " . strlen($postData) . "\r\n"
        . "Content-Type: application/json\r\n",
      'content' => $postData
  ]
];
$context = stream_context_create($options);
$result = @file_get_contents(ACCOUNT_CHECK, false, $context);
if (empty($result)) Output(0, "Maaf, informasi tentang rekening $Account tidak berhasil Carik temukan.\nCoba lagi nanti yaa.");

$accountData = json_decode($result, true);
if ($accountData['status'] == false){
  Output(0, "Data tentang rekening $Account tidak ditemukan.");
}

$detailReport = $accountData['data']['laporanDetail'];
$detailAsText = "";
foreach ($detailReport as $report) {
  $date = $report['laporanDate'];
  $date = date('d-m-Y H:i', $date / 1000 );
  $tmp = "\n$date: ".$report['kategoriAduan']['deskripsi'];
  $tmp .= ": ".$report['status']['description'];
  $detailAsText = $tmp . $detailAsText;
}

$Text = "*Hasil Cek Rekening*";
$Text .= "\nRekening: $Account";
$Text .= "\n".$Data['bank_t'];
$Text .= "\n*".$accountData['message']."*";
$Text .= "\n";
$Text .= "\n*Riwayat Pelaporan*";
$Text .= "\nNomor rekening yang anda cari pernah dilaporkan dengan dugaan tindak penipuan.";
$Text .= "\n$detailAsText";
$Text .= "\n";
$Text .= "\nInformasi lebih lengkap silakan kunjungi [Cek Rekening](https://cekrekening.id/)";

//die($Text);
Output(0, $Text);

