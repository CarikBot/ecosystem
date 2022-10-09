<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set("allow_url_fopen", 1);
require_once "../../lib/lib.php";
require_once "config.php";

$url = $Config['bmkg']['autogempa'];

$result = file_get_contents($url);
$data = json_decode($result, true);

$potensi = @$data['Infogempa']['gempa']['Potensi'];
$dirasakan = @$data['Infogempa']['gempa']['Dirasakan'];
if ($dirasakan=='-') $dirasakan = '';
$pos = strpos($potensi, 'Potensi tsunami');
if (($pos!==false) && ($pos===0)) $potensi = 'Potensi tsunami';

$imgUrl = "https://bmkg-content-inatews.storage.googleapis.com/".$data['Infogempa']['gempa']['Shakemap'];
//$Text = "*Info Gempa*[.]($imgUrl)";
$Text = "*Info Gempa*";
$Text .= "\n".$data['Infogempa']['gempa']['Tanggal']. ' ' . $data['Infogempa']['gempa']['Jam'];
$Text .= "\n".$data['Infogempa']['gempa']['Wilayah'];
$Text .= "\nKedalaman: ".$data['Infogempa']['gempa']['Kedalaman'];
$Text .= "\nMagnitude: ".$data['Infogempa']['gempa']['Magnitude'];
$Text .= "\nLintang: ".$data['Infogempa']['gempa']['Lintang'];
$Text .= "\nBujur: ".$data['Infogempa']['gempa']['Bujur'];
$Text .= "\n".$potensi;
$Text .= "\n".$dirasakan;
$Text = trim($Text);

$Text .= "\n\nUntuk info lebih akurat silakan cek di situs BMKG";

$output['code'] = 0;
$output['text'] = $Text;
$output['image_caption'] = "Peta Guncangan";
$output['image_position'] = 'header';
$output['image'] = $imgUrl;
$output = json_encode($output);
header("Content-type:application/json");

die($output);
//die($Text);
//Output(0, $Text);
