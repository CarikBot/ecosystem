<?php
/**
 * LINKEDIN ANALYZER
 *
 * USAGE:
 *   curl "http://ecosystem.carik.test/services/partner/lapork3/lapor/"
 *
 *
 * @date       01-10-2024 01:00
 * @category   Partner
 * @package    LaporK3
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version    0.0.1
 * @link       http://www.aksiide.com
 * @since
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set("allow_url_fopen", 1);
//error_reporting(E_NONE);

const __USEDB__ = false;

require_once "../../lib/lib.php";
require_once "../../config.php";

$LocationList = ['Gedung Merah', 'Gedung Kuning', 'Gedung Hijau', 'Lapangan'];
$ReportType = ["Kebersihan", "Maintenance", "Keamanan"];


if (empty($UserId)) $UserId = @$RequestContentAsJson['data']['user_id'];
if (empty($FullName)) $FullName = @$RequestContentAsJson['full_name'];
if (empty($FullName)) $FullName = @$RequestContentAsJson['data']['full_name'];
$Date = date("Y-m-d H:i:s");
$DateAsInteger = strtotime($Date);
$userInfo = @explode('-', $UserId);
$phone = @$userInfo[1];

if ('CANCEL' == @$RequestContentAsJson['data']['submit']){
  RichOutput(0, "Pengisian form Lapor K3 telah dibatalkan.\nTerima kasih.");
}

if (OK != @$RequestContentAsJson['data']['submit']){
  $text = "*Lapor K3*";
  $text .= "\nSilakan isi form berikut untuk menyampaikan laporan.";
  $text .= "\n.";

  $generalQuestion[] = AddQuestion('option', 'type', "Jenis Laporan", ["options"=>$ReportType]);
  $generalQuestion[] = AddQuestion('option', 'location', "Lokasi", ["options"=>$LocationList]);
  $generalQuestion[] = AddQuestion('string', 'description', "Sampaikan laporan dengan jelas dan dalam satu chat saja.");

  $questionData[] = $generalQuestion;
  $url = GetCurrentURL();
  // $options['suffix'] = '> Pastikan sudah terisi dengan lengkap dan benar.';
  $options['prefix'] = '';
  OutputQuestion( $text, $questionData, $url, 'Lapor K3', 0, $options);
}

// Processing
// AddToLog($RequestContent);
$Data = $RequestContentAsJson['data'];
$Type = @$Data['type'];
$Location = @$Data['location'];
$Description = @$Data['description'];

// TODO: save to DB


// TODO: Send Notification to Petugas


//
$text = "*Notifikasi Laporan*";
$text .= "\nLaporan ".$ReportType[$Type-1]." di ".$LocationList[$Location-1]." telah kami terima.";
$text .= "\n Keterangan: _".$Description."_.";
$text .= "\n";
$text .= "\nKami teruskan informasi ke petugas piket.";


RichOutput(0, $text);
