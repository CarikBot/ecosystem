<?php
/**
 * Form Template Test
 *   curl "http://localhost:8001/form-test.php" -d "@body-test.json"
 *   
 *
 * @date       19-04-2022 11:17
 * @category   personality test
 * @package    health
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
date_default_timezone_set('Asia/Jakarta');

$UserId = @$RequestContentAsJson['user_id'];
$FullName = @$RequestContentAsJson['full_name'];
if (empty($UserId)) $UserId = @$RequestContentAsJson['data']['user_id'];
if (empty($FullName)) $FullName = @$RequestContentAsJson['data']['FullName'];
$Date = date("Y-m-d H:i:s");
$DateAsInteger = strtotime($Date);

if ('CANCEL' == @$RequestContentAsJson['data']['submit']){
  Output(0, 'Pengisian form telah dibatalkan');
}

// Generate question
if ('OK' != @$RequestContentAsJson['data']['submit']){
  $questionsInCategory1[] = AddQuestion('string', 'city', 'Kamu tinggal di mana');
  $questionData[] = $questionsInCategory1;

  $Text = "Hi $FullName.";
  $Text .= "\nIni adalah contoh/template untuk membuat form.";

  $url = GetBaseUrl() . '/services/health/personality/form-test/'; // endpoint yang akan mengolah post data
  OutputQuestion( $Text, $questionData, $url, 'Form Test');
}

// Post Data Processing
$City = $RequestContentAsJson['data']['city'];
$City = ucwords(strtolower($City));


$Text = "Hai $FullName, Carik mendapatkan info bahwa kamu tinggal di $City.";

// Output with text only
//Output(0, $Text);

// Output with button/menu
$buttons = [];
$buttons[] = AddButton( '💛 Saya suka', 'text=saya suka');
$buttons[] = AddButton( '🏅 Donasi', 'text=donasi');
$buttonList[] = $buttons;
Output( 0, $Text, 'text', $buttonList, 'button', '', '', 'Tampilkan', false, 2);

