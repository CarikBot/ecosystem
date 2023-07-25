<?php
/**
 * Gempa Terkini
 * 
 * USAGE
 *   curl http://localhost:8001/gempa-terkini.php
 * 
 * 
 * @date       28-06-2022 01:32
 * @category   Climate
 * @package    BMKG
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
require_once "../../config.php";
require_once "../../lib/lib.php";
require_once "emsc_lib.php";


$url = $Config['packages']['climate']['bmkg']['autogempa'];
$result = @file_get_contents($url);
$data = @json_decode($result, true);
if (!empty($data)){
  $potensi = @$data['Infogempa']['gempa']['Potensi'];
  $dirasakan = @$data['Infogempa']['gempa']['Dirasakan'];
  if ($dirasakan=='-') $dirasakan = '';
  $pos = strpos($potensi, 'Potensi tsunami');
  if (($pos!==false) && ($pos===0)) $potensi = 'Potensi tsunami';

  $imgUrl = "https://bmkg-content-inatews.storage.googleapis.com/".$data['Infogempa']['gempa']['Shakemap'];
  //$Text = "*Info Gempa*[.]($imgUrl)";
  $Text = "*Info Gempa*\n";
  $Text .= "\n".$data['Infogempa']['gempa']['Tanggal']. ' ' . $data['Infogempa']['gempa']['Jam'];
  $Text .= "\n".$data['Infogempa']['gempa']['Wilayah'];
  $Text .= "\nKedalaman: ".$data['Infogempa']['gempa']['Kedalaman'];
  $Text .= "\nMagnitude: ".$data['Infogempa']['gempa']['Magnitude'];
  $Text .= "\nLintang: ".$data['Infogempa']['gempa']['Lintang'];
  $Text .= "\nBujur: ".$data['Infogempa']['gempa']['Bujur'];
  $Text .= "\n".$potensi;
  $Text .= "\n".$dirasakan;
  $Text = trim($Text);
  $Text .= "\n\nUntuk info lebih akurat silakan cek di situs *BMKG*.";
}else{
  $Text = "Belum berhasil mendapatkan informasi gempa dari BMKG.";
}


$EMSC = new Carik\EMSC;
$quakeInfo = $EMSC->QuakeInfo('INDONESIA', 'risk', 5);
if ($quakeInfo !== false){
  if (count($quakeInfo)>0){
    $Text .= "\n\n*Info Gempa dari EMSC*\n";
    foreach ($quakeInfo as $quake) {
      $properties = $quake['properties'];
      $time = $properties['time']['time_epi_str'];
      $time = trim(str_replace('+0700', '', $time));
      $place = ucwords(strtolower($properties['place']['region']));
      foreach ($properties['place']['cities'] as $city) {
        $dist = $city['dist'];
        $dist = str_replace(' of ', ' dr ', $dist);
        $dist = str_replace(', Indonesia', '', $dist);
        $place .= "\n- " . $dist;
      }
      $Text .= "\n$time";
      $Text .= "\n".$place;
      $Text .= "\nKedalaman: ".$properties['depth']['depth_str'];
      $Text .= "\nMagnitude: ".$properties['magnitude']['mag'];
      $Text .= "\nLintang: ".$properties['location']['lat'];
      $Text .= "\nBujur: ".$properties['location']['lon'];
  
      if ($properties['tsunami']['type'] == 'NONE'){
        //$Text .= "\nTidak berpotensi tsunami";  
      }

      $Text .= "\n";
    }
  }
}

$button = [];
$button[] = AddButton("🌦 Cuaca", "text=info cuaca");
//$button[] = AddButton("🏜 Gempa", "text=info gempa");
$buttonList[] = $button;

$file['caption'] = 'Peta Guncangan';
$file['type'] = 'image';
$file['url'] = $imgUrl;
$files[] = $file;

$actions['button'] = $buttonList;
$actions['files'] = $files;

//die($Text);
RichOutput(0, $Text, $actions);
