<?php
/**
 * USAGE
 *   curl "http://localhost:4000/?city=semarang&studio=1"
 *   curl "{ecosystem_baseurl}/services/entertainment/jadwalnonton/" -d "id=434769"
 * 
 * @date       04-01-2021 01:35
 * @category   Entertainment
 * @package    Jadwal Bioskop
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_NONE);
include_once "../../config.php";
require_once "../../lib/lib.php";
require_once "./JadwalNonton_lib.php";
date_default_timezone_set('Asia/Jakarta');

$City = urldecode(@$_GET['city']);
$Studio = urldecode(@$_GET['studio']);
if ($City=='%City%') $City = '';

if (empty($City)){
  Output(200, "Maaf, informasi tidak lengkap. Silakan ketik\n `JADWAL BIOSKOP DI [NAMAKOTA]`\nmisal:\n `JADWAL BIOSKOP DI JAKARTA`");
}

if (empty($Studio)){
  $e = explode('-', $City);
  if (count($e)==2) {
    $City = $e[0];
    $Studio = $e[1];
  }
}

$cityList = @file_get_contents("city.txt");
$cityAsArray = explode("\n", strtolower($cityList));
if (!in_array($City, $cityAsArray)){
  $cityList = str_replace("\n", ", ", $cityList);
  $text = "Maaf, informasi bioskop di kota ".ucwords($City)." tidak ditemukan.";
  $text .= "\n\nSaat ini tersedia informasi bioskop untuk kota berikut ini: $cityList.";
  Output(200, $text);
}

$JadwalNonton = new Carik\JadwalNonton();
$studios = $JadwalNonton->GetStudioList($City);

// Show studios in the city
if (empty($Studio)){
  $text = "Silakan pilih bioskop yang diinginkan:";
  $menu = [];
  $index = 1;
  foreach ($studios as $studio) {
    $menu[] = AddButton( $studio['name'], "text=jdwlbskp $City-$index");
    $index++;
  }
  $buttonList[] = $menu;
  Output(0, $text, 'text', $buttonList, 'menu', '', '', 'Tampilkan', true);
}

$schedules = $JadwalNonton->GetSchedule($studios,$Studio);
$studioName = $studios[$Studio-1]['name'];
if (count($schedules)==0){
  Output(0, "Maaf, informasi jadwal bioskop $studioName belum tersedia.");
}

$text = "*Jadwal bioskop $studioName, ".ucwords($City)."*\n";
foreach ($schedules as $schedule) {
  $text .= "\n*".$schedule['title']."*";
  $text .= "\n".$schedule['rating'];
  $text .= ", ".$schedule['description'];
  $text .= "\n";
  foreach ($schedule['hours'] as $hour) {
    $text .= "$hour ";
  }
  $text .= "\nRp. ".$schedule['price'];
  $text .= "\n";
}

//die($text);
Output(0, $text);

