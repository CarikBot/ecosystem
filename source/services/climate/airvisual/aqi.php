<?php
/**
 * Get Air Quality Index
 * 
 * USAGE:
 *   curl -L "http://ecosystem.carik.test/services/climate/airvisual/aqi/?city=semarang"
 *
 * @date       03-08-2023 15:22
 * @category   Climate
 * @package    Air Visual
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

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set("allow_url_fopen", 1);
//error_reporting(E_NONE);

require_once "../../config.php";
require_once "../../lib/lib.php";

const BASE_URL = "https://website-api.airvisual.com/v1/search?units.temperature=celsius&units.distance=kilometer&units.pressure=millibar&units.system=metric&AQI=US&language=id&q=";
$City = @strtolower(@$_GET['city']);
if (empty($City)) $City = @strtolower(@$_POST['city']);
if (empty($City)){
  $Text = "Mohon sekalian ditulis dengan nama kotanya yaa.";
  $Text .= "\nFormat: ``` kualitas udara [kota]```";
  $Text .= "\nMisal: ``` kualitas udara jakarta```";
  RichOutput(0, $Text);
}

$url = BASE_URL . $City;
$result = @file_get_contents($url);
if (empty($result)){
  $Text = "Maaf, informasi indeks kualitas udara kota $City belum bisa saya dapatkan.";
  $Text .= "Coba lagi nanti yaaa...";
  RichOutput(0, $Text);
}

$aqi = @json_decode($result, true);
if (empty($aqi)){
  //TODO: tampilkan error
}

$citiesAqi = $aqi['cities'];

$Text = "*Data Indeks Kualitas Udara*";
$Text .= "\n";
foreach ($citiesAqi as $city) {
  $aqi = $city["aqi"];
  $status = "Baik";
  if ($aqi>=51) $status = "Sedang";
  if ($aqi>=101) $status = "Tidak sehat untuk masyarakat rentan";
  if ($aqi>=151) $status = "Tidak sehat";
  if ($aqi>=201) $status = "Sangat tidak sehat";
  if ($aqi>=301) $status = "Berbahaya";
  $lat = $city["coordinates"]["latitude"];
  $lon = $city["coordinates"]["longitude"];
  $Text .= "\n$city[name], $city[state]";
  $Text .= "\nKoordinat: $lat, $lon";
  $Text .= "\nIndeks: $aqi ($status)";
  $Text .= "\n";
}
$Text .= "\nIndeks kualitas udara yang baik adalah antara 0-50.";
RichOutput(0, $Text);
