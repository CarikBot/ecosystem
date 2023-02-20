<?php
/**
 * SIMULASI DEPOSITO HANDLER
 * 
 * USAGE:
 *   curl "http://ecosystem.carik.test/services/main/CarikBot/donasi.php" -d "@body-donasi.json"
 *   
 *
 * @date       12-07-2021 23:24
 * @category   Main
 * @package    Donasi
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
//error_reporting(E_NONE);

require_once "../../config.php";
require_once "../../lib/lib.php";

if ('CANCEL' == @$RequestContentAsJson['data']['submit']){
  Output(0, "Pengisian form donasi telah dibatalkan.\nTerima kasih.");
}

$ClientId = @$RequestContentAsJson['client_id'];
$UserId = @$RequestContentAsJson['user_id'];
$FullName = @$RequestContentAsJson['full_name'];
if (empty($UserId)) $UserId = @$RequestContentAsJson['data']['user_id'];
if (empty($FullName)) $FullName = @$RequestContentAsJson['data']['FullName'];

if ('OK' == @$RequestContentAsJson['data']['submit']){
  $Data = $RequestContentAsJson['data'];
  $nominal = str_replace(',', '',@$Data['nominal']);
  $nominal = str_replace('.', '', $nominal)+0;

  $url = ECOSYSTEM_BASEURL."/Commerce/cart/?cmd=add&checkout=1&gateway=2&number=1&price=$nominal&description=Kustom+Donasi+$nominal";
  $postData["UserID"] = $UserId;
  $postData["FullName"] = urldecode($FullName);
  $postData = http_build_query($postData);

  $options = [
    "http" => [
        "method" => "POST",
        'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
          . "Content-Length: " . strlen($postData) . "\r\n",
        'content' => $postData
    ]
  ];
  $context = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  if (empty($result)){
    Output(0, "Maaf, gagal melakukan inisiasi donasi. Coba lagi nanti yaa...");
  }
  AddToLog($result);
  @header("Content-type:application/json");
  //$output = json_encode($result, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
  die($result);
}


// Generate Form Question
$section01[] = AddQuestion('numeric', 'nominal', 'Tulis besar nominal yang akan Anda donasikan (dalam Rupiah)');
$questionData[] = $section01;

$Text = "Hi $FullName.";
$Text .= "\nDi sini Anda bisa bebas memberikan donasi sesuai keinginan Anda lhoo.";
$Text .= "\n";

$url = GetBaseUrl() . '/services/main/CarikBot/donasi/';
OutputQuestion( $Text, $questionData, $url);
