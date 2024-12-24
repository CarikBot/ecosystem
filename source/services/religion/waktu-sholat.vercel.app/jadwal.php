<?php
/**
 * Jadwal Sholat melalui waktu-sholat.vercel.app
 * referensi:
 *   - https://github.com/renomureza/waktu-sholat
 *
 * USAGE:
 *   curl "http://ecosystem.carik.test/services/religion/waktu-sholat.vercel.app/jadwal/"
 *
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_NONE);
require_once "../../lib/lib.php";

const CITY_DEFAULT = 'jakarta';

$hijriah = toHijriah(date('Y-m-d'));
$City = @urldecode(@$_GET['city']);
$City = strtolower($City);
$City = str_replace( '%kota%', '', $City);
if (empty($City)){
  $City = GetSavedKeyword('kota', 'jakarta', 60*24*3); // 3 hari
}

if (empty($City)){
  $Output['code'] = 0;
  $Output['text'] = "Informasi tidak lengkap, silakan diulangi lagi.";
  $output = json_encode($Output);
  echo $output;
  die;
}

if ($City==='solo'){$City='surakarta';}
if ($City==='jogja'){$City='yogyakarta';}
if ($City==='yogya'){$City='yogyakarta';}
if ($City==='pekanbaru'){$City='pekan baru';}

$Text = "*Jadwal Sholat*";
$Text .= "\n$hijriah";

$cityInfo = searchCity($City);
$prefix = "";
if ($cityInfo==false){
  $cityInfo = searchCity(CITY_DEFAULT);
  $prefix = "Jadwal sholat kota '".ucwords($City)."' belum tersedia.\n";
  $Text .= "\n$prefix";
}
$lat = '';
$lon = '';
if (count($cityInfo) == 1){
  $cityName = $cityInfo[0]['name'];
  $lat = $cityInfo[0]['coordinate']['latitude'];
  $lon = $cityInfo[0]['coordinate']['longitude'];
}else{
  $Text .= "\nDitemukan wilayah:";
  $cityName = "";
  foreach ($cityInfo as $city) {
    $Text .= "\n - $city[name]";
    if (isStringExist('Kota ', $city['name'])){
      $cityName = $city['name'];
      $lat = $city['coordinate']['latitude'];
      $lon = $city['coordinate']['longitude'];
    }
    if (empty($cityName)){
      // TODO: daerah default
    }
  }
}

$prayInfo = prayInfo($lat, $lon);
if ($prayInfo == false){
  $Text = "Maaf, informasi jadwal sholat belum bisa diakses, ada gangguan.\nCoba lagi nanti yaa.";
  RichOutput(0, $Text);
}

$Text .= "\nJadwal Sholat $cityName:";
// unset($prayInfo['imsak']); // hapus imsak
$Text .= "\n```";
foreach ($prayInfo as $key => $value) {
  $Text .= "\n". str_pad(ucwords($key), 8, ' ', STR_PAD_LEFT) . ": $value";
}
$Text .= "```\n";

if ((empty($prefix))and(CITY_DEFAULT == $City)){
  $Text .= "\nUntuk kota lain, ketikkan\n 𝙹𝙰𝙳𝚆𝙰𝙻 𝚂𝙷𝙾𝙻𝙰𝚃 [𝚔𝚘𝚝𝚊]";
}
$Text .= "\nSemoga sehat selalu, sukses dan barokah.";

// setup output
$buttons = [];
$_ = date('YmdHis');
$buttons[] = AddButton("Ayat", "_=$_&mode=&text=ayat quran");
$buttons[] = AddButton("Doa Harian", "_=$_&mode=&text=doa harian");
$buttonList[] = $buttons;

// die($Text);
Output(0, $Text, 'text', $buttonList);

function searchCity($ACity){
  if (empty($ACity)) return false;
  $ACity = strtolower($ACity);
  $cityList = [];
  $provinces = file_get_contents('provinces.json');
  $provinces = json_decode($provinces, true);
  foreach ($provinces as $province) {
    $provinceId = $province['id'];
    $provinceName = $province['name'];
    $cities = $province['cities'];
    foreach ($cities as $city) {
      $cityName = strtolower($city['name']);
      if (isStringExist($ACity, $cityName)){
        $cityList[] = $city;
      }
    }
  }
  return $cityList;
}

function prayInfo($ALatitude, $ALongitude){
  $currentDate = date("d") - 1;
  $url = "https://waktu-sholat.vercel.app/prayer?latitude=$ALatitude&longitude=$ALongitude";
  // $url = 'https://waktu-sholat.vercel.app/prayer?latitude='.$ALatitude.'&longitude='.$ALongitude;
  // die("\n$url");

  $prayInfo = @curl_get_file_contents($url);
  if ($prayInfo == false) return false;
  $prayInfoAsJson = @json_decode($prayInfo, true);
  if ($prayInfoAsJson == false) return false;
  $currentPrayInfo = $prayInfoAsJson['prayers'][$currentDate];
  return $currentPrayInfo['time'];
}

$Prefix = '';
$Suffix = '';
$INI = parse_ini_file("city.ini");
if (isset($INI[$City])){
  $CityID = $INI[$City];
}else{
  $Prefix = "Jadwal sholat kota ".ucwords($City)." belum tersedia.\n\n";
  $City = CITY_DEFAULT;
  $CityID = $INI[$City];
}
if ((empty($Prefix))and(CITY_DEFAULT == $City)){
  $Suffix = "\n\nUntuk kota lain, ketikkan\n 𝙹𝙰𝙳𝚆𝙰𝙻 𝚂𝙷𝙾𝙻𝙰𝚃 [𝚔𝚘𝚝𝚊]";
}

// setup output
$buttons = [];
$_ = date('YmdHis');
$buttons[] = AddButton("Ayat", "_=$_&mode=&text=ayat quran");
$buttons[] = AddButton("Doa Harian", "_=$_&mode=&text=doa harian");
$buttonList[] = $buttons;

// check cache
$cacheName = "$City-$CityID";
$cache = readCache($cacheName, 120); // 2 hours
if (!empty($cache)){
  $cache .= "\n_Semoga sehat selalu, sukses dan barokah._";
  Output(0, $cache, 'text', $buttonList);
}

$url = $BASEURL . $CityID;
$content = curl_get_file_contents($url, 3000);
if (empty($content)){
  $cache = readCache($cacheName, 360); // 6 hours
  if (!empty($cache)){
    $cache .= "\n_Semoga sehat selalu, sukses dan barokah (c)._";
    Output(0, $cache, 'text', $buttonList);
  }

  Output(0, "Maaf, belum ada informasi jadwal sholat.\nSedang gangguan, coba lagi nanti yaa...");
}

if (isStringExist('Cloudflare', $content)){
  Output(0, "Maaf, belum ada informasi jadwal sholat.\nSedang gangguan, coba lagi nanti yaa...\n_(cf)_");
}

$hijriah = toHijriah(date('Y-m-d'));

$content = str_replace('</b></td><td>','</b>: </td><td>',$content);
$content = strip_tags( $content);
$content = str_replace('hari ini&nbsp;','',$content);
$content = str_replace('kemarinbesok',"$hijriah\n",$content);
$content = str_replace('&nbsp;','',$content);
$content = str_replace('[Perbulan & Cetak]©','',$content);

$content = str_replace('Shubuh:',"``` Shubuh:",$content);
$content = str_replace('Dzuhur:',' Dzuhur:',$content);
$content = str_replace('Ashr:','   Ashr:',$content);
$content = str_replace('Isya:','   Isya:',$content);
$content = trim($content)."```";

$Text = $Prefix . "*Jadwal Sholat di " . ucwords($City) . ".*\n";
$Text .= $content;
$Text .= $Suffix;
writeCache($cacheName, $Text);

if (!empty($mode)){
    echo $Text."\n";
    die;
}

//die($Text);
Output(0, $Text, 'text', $buttonList);
