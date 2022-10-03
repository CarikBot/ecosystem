<?php
/**
 * USAGE
 *   curl "http://localhost/services/ecosystem/education/madewgn/aksarajawa/" -d "Keyword=ini huruf jawa"
 *   curl "http://ecosystem/services/education/madewgn/aksarajawa/" -d "Keyword=ini huruf jawa"
 * 
 * @date       04-01-2021 01:35
 * @category   Education
 * @package    Konversi aksara jawa
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../config.php";
include_once "../../lib/lib.php";

$Keyword = @$_POST['Keyword'];
$Keyword = urldecode($Keyword);
if (empty($Keyword)){
  Output(200, 'Maaf, permintaan tidak lengkap.');
}

$parameter = urlencode($Keyword);
$url = "https://api.madewgn.my.id/jawa/latin?input=$parameter";
$result = curl_get_file_contents($url);
if ($result==false) Output(0, "Maaf, proses konversi ke aksara jawa belum berhasil.");
$json = json_decode($result, true);
$aksara = @$json['aksara'];
if (empty($aksara)){
  Output(0, "Maaf, tulisan belum bisa dikonversi ke aksara jawa.");
}
$Text = "Aksara jawa untuk '$Keyword' adalah:";
$Text .= "\n".$aksara;

//die($Text);
Output(0, $Text);

