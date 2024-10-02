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
const LANGUAGE = ['Indonesia', 'English'];

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
  $text = "*Resume Analyzer (Linkedin & Upwork)*";
  $text .= "\nCarik memerlukan url linkedin/upwork dan email kamu untuk melakukan proses analisis.";
  $text .= "\nURL profile harus ditulis lengkap, misal:";
  $text .= "\n- linkedin: https://www.linkedin.com/in/luridarmawan/";
  $text .= "\n- upwork: https://www.upwork.com/freelancers/~kodeuseranda";
  $text .= "\n.";
  if ($NoIntro != 1){
    $text = trim(file_get_contents("linkedin-analyzer.md"));
    $text = str_replace("\r\n", "\n", $text);
  }

  $generalQuestion[] = AddQuestion('url', 'url', "Ketikkan *URL Profile Linkedin/Upwork kamu*");
  $generalQuestion[] = AddQuestion('email', 'email', "*Email Anda:*\nHasil analisis akan dikirimkan ke email ini");
  $generalQuestion[] = AddQuestion('option', 'language', "Bahasa yang akan digunakan di dalam hasil analisis", ["options"=>LANGUAGE]);
  $generalQuestion[] = AddQuestion('string', 'voucher', "Kode Voucher\nKetik \"-\" jika tidak ada.");

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
$Voucher = strtolower(@$Data['voucher']);
$Voucher = strtolower(trim($Voucher));
$Email = @$Data['email'];
$Language = @$Data['language'];
if ((empty($ProfileURL)) or (empty($Email))){
  RichOutput(0, "Maaf, parameter untuk melakukan anilisis tidak lengkap.");
}

$Language = strtolower(LANGUAGE[$Language-1]);

$parsed_url = parse_url($ProfileURL);
$ProfileURL = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'];

if (!( (isStringExist('linkedin.com', $ProfileURL)) || (isStringExist('upwork.com', $ProfileURL)))){
  $text = "Maaf, URL profile harus ditulis lengkap, misal:";
  $text .= "\n https://www.linkedin.com/in/luridarmawan/";

  $buttons[] = AddButton("🌟 Coba lagi", "text=order linkedin analyzer");
  $buttonList[] = $buttons;
  $actions['button'] = $buttonList;
  $actions['suffix'] = 'Ketik *menu* untuk kembali ke menu utama.';
  RichOutput(0, $text, $actions);
}

$service = "";
if (preg_match("/^(?:https?:\/\/)?(?:www\.)?(?:[^\/:?#]+\.)?([^\/:?#]+)\.[a-z]{2,6}(?:[\/:?#]|$)/i", $ProfileURL, $matches)) {
  $service = @$matches[1];
}

$serviceName = ucwords($service);
if ($service == "linkedin"){
  preg_match('/linkedin\.com\/in\/([^\/]+)/', $ProfileURL, $matches);
  $serviceUserId = @$matches[1];
}
if ($service == "upwork"){
  preg_match('/upwork\.com\/freelancers\/~([^\/]+)/', $ProfileURL, $matches);
  $serviceUserId = @$matches[1];
}

// $transactionId = "PLA01.$serviceUserId.$DateAsInteger";
$transactionId = "PLA.01.$DateAsInteger".substr(trim(strtoupper($FullName)), 0,1);
$productName = urlencode("Resume Analyzer $serviceName");

$description = "$serviceName Analyzer: $serviceUserId";
$properties = [
  "request" => [
    "profile_url" => $ProfileURL,
    "email" => $Email,
    "language" => $Language,
    "service" => $service
  ]
];
$propertiesAsJson = json_encode($properties, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
$voucherAsText = ($Voucher == '-') ? '' : $Voucher;
$sql = "INSERT INTO `product_orders` (`client_id`, `user_id`, `product_id`, `trx_id`, `voucher`, `ref_id`, `date`, `description`, `properties`, `status_id`) ";
$sql .= "\nVALUES";
$sql .= "\n($ClientId, '$UserId', 0, '$transactionId', '$voucherAsText', '$Email', $DateAsInteger, '$description', '$propertiesAsJson', 2);";
$q = @$DB->query($sql);

// setup pricing
$productInfo = @$Config['packages']['main']['CarikBot']['product'][$service."_analyzer"];
$price = @$productInfo['price'];
$priceNet = @$productInfo['price_net'];
$voucherAmount = @$productInfo['voucher'][$Voucher] + 0;

$discount = $price * $voucherAmount / 100;
$price = $price - $discount - rand(1, 100);
if ($voucherAmount>0) $productName = "$productName ($Voucher)";

// Add to Cart
$url = ECOSYSTEM_BASEURL . "/Commerce/cart/";
$url .= "?cmd=add";
$url .= "&checkout=1";
$url .= "&gateway=2"; // force to PH
$url .= "&type=";

if ($Voucher == '-') $Voucher = '';
$postData = $RequestContentAsJson['data'];
$postData['number'] = 1;
$postData['price'] = $price;
$postData['price_net'] = $priceNet;
$postData['trx_id'] = $transactionId;
$postData['description'] = $productName;
$postData['duration'] = INVOICE_DURATION;
$postData['voucher'] = $Voucher;
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
