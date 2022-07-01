<?php
/**
 * Check Rekening
 * 
 * USAGE:
 *   curl "http://localhost:8001/account.php" -d "@body-check.json"
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
require_once "../../lib/simplehtmldom_2_0/simple_html_dom.php";
require_once "../../config.php";
date_default_timezone_set('Asia/Jakarta');

const BASE_URL = 'https://www.kredibel.co.id/account/';

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
  $Text = "*Info Kredibel*";
  $Text .= "\nAnda ingin bertransaksi online?\nIngin men-transfer sejumlah uang ke rekening yang anda baru kenal?\n*Cek dulu disini!*";
  $Text .= "\nMohon lengkapi pertanyaan berikut.";
  $Text .= "\n";

  $generalQuestion[] = AddQuestion('string', 'account', "Masukkan Nomor Rekening yang dicurigai");

  $questionData[] = $generalQuestion;

  $url = GetBaseUrl() . '/services/other/kredibel/account/';
  OutputQuestion( $Text, $questionData, $url, 'Info Kredibel');
}

// Processing
$Data = @$RequestContentAsJson['data'];
$fullName = strtoupper(@$Data['fullName']);
$Account = @$Data['account'];

$Account = '109101005696533';
$url = BASE_URL . $Account;
$html = file_get_html($url);
if ($html == false){
  Output(400, "Maaf, informasi belum bisa ditemukan.");
}

$Text = "*Info Kredibel*";
$Text .= "\nRekening: $Account";
foreach($html->find("p.mt-4") as $row) {
  $s = trim(strip_tags($row->innertext));
  $s = explode("\n", $s);
  $s = trim($s[0]);
  if (empty($s)) continue;
  $Text .= "\n*".$s."*";
}
$Text = trim($Text);
$Text .= "\n\n[Info Selengkapnya]($url)";
if (isStringExist('Bergabunglah bersama lebih dari 600 ribu pengguna terdaftar', $Text)){
  $Text = "Maaf, untuk sementara fitur tidak bisa diakses karena request yang melewati limit.\nSilakan coba lagi nanti yaa...";
}

$buttons[] = AddButtonURL("❗️ Laporkan Rekening", $url);
$buttonList[] = $buttons;

//die($Text);
//Output(0, $Text);
Output( 0, $Text, 'text', $buttonList, 'button', '', '', 'Tampilkan', true);
