<?php
/**
 * Share Link Message
 *
 * USAGE:
 *   curl "http://ecosystem.carik.test/services/main/CarikBot/sharelink/"  -d "@body-odoj.json"
 *
 *
 * @date       23-09-2022 09:51
 * @category   Main
 * @package    Carik Bot
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
require_once "../../config.php";
require_once "../../lib/lib.php";
date_default_timezone_set('Asia/Jakarta');

$ChannelId = @$RequestContentAsJson['data']['channel_id'];
$Keyword = @$RequestContentAsJson['data']['keyword'];
if (empty($Keyword)) Output(0, "Maaf, parameter tidak lengkap.");
$Keyword = urlencode($Keyword);

$carikLink = "*Carik Bot*";
$telegramKeyword = str_replace('+', '_', $Keyword);
if ($ChannelId=='telegram'){
  $carikLink = "[@CarikBot](t.me/CarikBot?start=$telegramKeyword)";
}
$Text = "Bisa dicoba lewat $carikLink";
$Text .= "\n";
$Text .= "\nWhatsapp";
$Text .= "\n wa.me/62811857001?text=$Keyword";
$Text .= "\nWhatsapp Official";
$Text .= "\n wa.me/6281807140209?text=$Keyword";


//die($Text);
Output(0, $Text);
