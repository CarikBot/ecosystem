<?php
/**
 * Check nomor telepon
 * 
 * USAGE
 *   curl "http://ecosystem.carik.test/services/other/telepon.net/check/" -d "{yourpayload}"
 * 
 * @date       09-08-2024 01:05
 * @category   other
 * @package    telepon.net
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version    0.0.1
 * @link       http://www.aksiide.com
 * @since
 */

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
date_default_timezone_set("Asia/Jakarta");
require_once "../../lib/lib.php";
require_once "../../config.php";
require_once "CarikTeleponNet_lib.php";

const JENIS_KELAMIN = ['', 'Laki-laki', 'Perempuan'];

$UserId = @$RequestContentAsJson['data']['user_id'];
$FullName = @$RequestContentAsJson['data']['FullName'];
$Phone = @$RequestContentAsJson['data']['phone'];
$Date = date("Y-m-d H:i:s");
$DateAsInteger = strtotime($Date);

function findPhoneInfo($APhone){
  $TN = new Carik\TeleponNet;
  $result = $TN->Check($APhone);
  if ($result==false) return "Maaf, informasi nomor *$APhone* tidak ditemukan.";
  $text = "Ditemukan informasi tentang *$APhone* berikut:";
  $text .= "\n*$result[estimation]*";
  $text .= "\nPenilaian: $result[rate]";
  $text .= "\nJumlah laporan: $result[report]";
  return $text;
}

if (!empty($Phone)){
  $Text = findPhoneInfo($Phone);
  RichOutput(0, $Text);
}


if ('CANCEL' == @$RequestContentAsJson['data']['submit']){
  Output(0, "Pengisian form telah dibatalkan.\nTerima kasih.");
}

if ('OK' != @$RequestContentAsJson['data']['submit']){
  // Build your question here
  $Text = "*Cek nomor telepon*";
  $Text .= "\nLayanan ini untuk mencari informasi apakah nomor yang telp kamu termasuk scammer/penipu atau bukan.";
  $Text .= "\n";

  // general question
  $generalQuestion[] = AddQuestion('string', 'phone', "Nomor telepon");
  
  $questionData[] = $generalQuestion;

  $url = GetCurrentURL();
  OutputQuestion( $Text, $questionData, $url, 'Phone Chek Form');
}

// Processing Data
$Data = $RequestContentAsJson['data'];
$Phone = strtoupper($Data['phone']);
$Text = findPhoneInfo($Phone);
RichOutput(0, $Text);
