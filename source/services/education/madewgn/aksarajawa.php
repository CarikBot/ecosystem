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

$url = "https://api.madewgn.my.id/jawa/latin?input=$Keyword";
$postData = [];
$postData = http_build_query($postData);
$options = [
  "http" => [
      "method" => "GET",
      'header'=> "Content-Length: " . strlen($postData) . "\r\n",
      'content' => $postData
  ]
];
$context = stream_context_create($options);
$result = @file_get_contents($url, false, $context);
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

