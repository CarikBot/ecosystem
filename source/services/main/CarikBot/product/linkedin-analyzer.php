<?php
/**
 * LINKEDIN ANALYZER
 *
 * USAGE:
 *   curl "http://ecosystem.carik.test/services/main/CarikBot/product/linkedin-analyzer/" -d "@payload/linkedin-analyzer.json"
 *
 *
 * @date       25-09-2024 01:00
 * @category   Main
 * @package    CarikBot
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

const __USEDB__ = true;
const INVOICE_DURATION = 15*60; // 15 minutes

require_once "../../../lib/lib.php";
require_once "../../../config.php";

$NoIntro = @$_GET['nointro'];
if (empty($UserId)) $UserId = @$RequestContentAsJson['data']['user_id'];
if (empty($FullName)) $FullName = @$RequestContentAsJson['full_name'];
if (empty($FullName)) $FullName = @$RequestContentAsJson['data']['full_name'];
$Date = date("Y-m-d H:i:s");
$DateAsInteger = strtotime($Date);
$userInfo = @explode('-', $UserId);
$phone = @$userInfo[1];

if ('CANCEL' == @$RequestContentAsJson['data']['submit']){
  RichOutput(0, "Pengisian form Linkedin Analyzer telah dibatalkan.\nTerima kasih.");
}

if (OK != @$RequestContentAsJson['data']['submit']){
  $text = "*Linkedin Analyzer*";
  $text .= "\nCarik memerlukan url linkedin dan email kamu untuk melakukan proses analisis.";
  $text .= "\nURL profile harus ditulis lengkap, misal:";
  $text .= "\n https://www.linkedin.com/in/luridarmawan/";
  $text .= "\n.";
  if ($NoIntro != 1){
    $text = trim(file_get_contents("linkedin-analyzer.md"));
    $text = str_replace("\r\n", "\n", $text);
  }

  $generalQuestion[] = AddQuestion('url', 'url', "Ketikkan *URL Profile Linkedin kamu*");
  $generalQuestion[] = AddQuestion('email', 'email', "Email Anda");

  $questionData[] = $generalQuestion;
  $url = GetCurrentURL();
  $options['suffix'] = '> Carik akan menggunakan profile linkedin yang terupdate 30 hari terakhir..';
  $options['prefix'] = '';
  OutputQuestion( $text, $questionData, $url, 'LinkedIn Analyzer', 0, $options);
}

// Processing
AddToLog($RequestContent);
$Data = $RequestContentAsJson['data'];
$ProfileURL = strtolower(@$Data['url']);
$Email = @$Data['email'];
if ((empty($ProfileURL)) or (empty($Email))){
  RichOutput(0, "Maaf, parameter untuk melakukan anilisis linkedin tidak lengkap.");
}

$parsed_url = parse_url($ProfileURL);
$ProfileURL = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'];

if (!isStringExist('linkedin.com', $ProfileURL)){
  $text = "Maaf, URL profile harus ditulis lengkap, misal:";
  $text .= "\n https://www.linkedin.com/in/luridarmawan/";

  $buttons[] = AddButton("🌟 Coba lagi", "text=order linkedin analyzer");
  $buttonList[] = $buttons;
  $actions['button'] = $buttonList;
  $actions['suffix'] = 'Ketik *menu* untuk kembali ke menu utama.';
  RichOutput(0, $text, $actions);
}

preg_match('/linkedin\.com\/in\/([^\/]+)/', $ProfileURL, $matches);
$LinkedInUserId = $matches[1];
// $transactionId = "PLA01.$LinkedInUserId.$DateAsInteger";
$transactionId = "PLA.01.$DateAsInteger".substr(trim(strtoupper($FullName)), 0,1);
$productName = urlencode('Linkedin Analyzer');

$description = "Linkedin Analyzer: $LinkedInUserId";
$properties = [
  "request" => [
    "profile_url" => $ProfileURL,
    "email" => $Email,
  ]
];
$propertiesAsJson = json_encode($properties, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
$sql = "INSERT INTO `product_orders` (`client_id`, `user_id`, `product_id`, `trx_id`, `ref_id`, `date`, `description`, `properties`, `status_id`) ";
$sql .= "\nVALUES";
$sql .= "\n($ClientId, '$UserId', 0, '$transactionId', '$Email', $DateAsInteger, '$description', '$propertiesAsJson', 2);";
$q = @$DB->query($sql);

// Add to Cart
$url = ECOSYSTEM_BASEURL . "/Commerce/cart/";
$url .= "?cmd=add";
$url .= "&checkout=1";
$url .= "&gateway=2"; // force to PH
$url .= "&type=";

$postData = $RequestContentAsJson['data'];
$postData['number'] = 1;
$postData['price'] = 1500 - rand(0, 100);
$postData['price_net'] = 1000;
$postData['trx_id'] = $transactionId;
$postData['description'] = $productName;
$postData['duration'] = INVOICE_DURATION;
$formatedPostData['data'] = $postData;
$postData = json_encode($formatedPostData, true);
$options = [
  "http" => [
    'ignore_errors' => true,
    "method" => "POST",
    'header'=> "Content-Length: " . strlen($postData) . "\r\n"
      . "Content-Type: application/json\r\n",
    'content' => $postData
  ]
];
$context = stream_context_create($options);
$result = @file_get_contents($url, false, $context);
if ($result == false) {
  $error = error_get_last();
  $msg = $error['message'];
  Output(400, "Maaf, gagal memproses pembayaran.\nCoba lagi nanti yaaa..\n- $msg");
}

@header("Content-type:application/json");
echo $result;
