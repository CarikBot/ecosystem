<?php
/**
 * Informasi PSE
 * 
 * USAGE:
 *   curl "http://localhost:8001/pse.php" -d "@body-pse.json"
 *   
 *
 * @date       20-07-2022 15.50
 * @category   PSE
 * @package    governance
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
require_once "../../lib/messaging_lib.php";
require_once "../../config.php";
date_default_timezone_set('Asia/Jakarta');

const PSE_TERBIT_URL = 'https://pse.kominfo.go.id/api/v1/jsonapi/tdpse-terbit/';

$pseData = readCache('pse', 120); // 120 minutes cache
if (empty($pseData)){
  $pseData = @file_get_contents(PSE_TERBIT_URL);
  if (empty($pseData)) $pseData = file_get_contents('data/pse.json'); // base data
  writeCache('pse', $pseData);
}
$pseData = json_decode($pseData, true);
$pseData = $pseData['data'];

$Data = @$RequestContentAsJson['data'];

$Text = "
Pencarian informasi perusahaan yang sudah terdaftar di PSE Kominfo.
format penulisan:
 ``` INFO PSE [namaperusahaan]```
";
$Keyword = urldecode(@$Data['keyword']);
if (empty($Keyword)) Output(0, $Text);

$Text = "*Daftar Perusahaan yang sudah terdaftar PSE*";
$Text .= "\n";

$count = 0;
foreach ($pseData as $pse) {
  $pseName = trim($pse['attributes']['nama']);
  $pseName = strtolower($pseName);
  if (!isStringExist($Keyword, $pseName)) continue;

  $id = $pse['id'];
  $item = "\n*".$pse['attributes']['nama']."*";
  $item .= "\nwebsite: ".$pse['attributes']['website'];
  $item .= "\nSektor: ".$pse['attributes']['sektor'];
  $item .= "\nTanggal terbit: ".$pse['attributes']['tanggal_terbit'];
  $item .= "\nStatus: ".$pse['attributes']['status_id'];
  //$item .= "\n[Link](".$pse['attributes']['qr_code'].')';
  $item .= "\n[Link](https://pse.kominfo.go.id/tdpse-detail/$id)";
  $item .= "\n".$pse['attributes']['nomor_tanda_daftar'];
  $item .= "\n".$pse['attributes']['lokalitas'];
  $item .= "\n";
  $Text .= $item;
  $count++;
}
$fileDateTime = filemtime('cache/pse.txt');
$fileDateTime = date("d-m-Y H:i", $fileDateTime);
$Text .= "\nupdate: $fileDateTime";
$Text .= "\nsumber: pse.kominfo.go.id";

if (0==$count){
  $Text = "Maaf, informasi PSE untuk keyword '$Keyword' tidak ditemukan.";
}

$buttonList = [];
$button = [];
$button[] = AddButton("🗓 Daftar PSE", "text=daftar pse");
$buttonList[] = $button;

$actions['button'] = $buttonList;
RichOutput(0, $Text, $actions);
