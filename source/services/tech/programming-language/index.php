<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../../lib/Parser.php";
require_once "../../lib/lib.php";
require_once "config.php";


$Language = @$_GET['lang'];
$Keyword = @$_GET['keyword'];
if (empty($Keyword)){
  $Keyword = @$_POST['keyword'];
}
$Format = @$_GET['format'];
$Keyword = urldecode($Keyword);

if (empty($Keyword)){
  Output(404, "Informasi yang akan dicari tidak lengkap.\nCara penulisan:\n``` penggunaan [keyword] di Pascal```");
}

if ('js' == $Language) $Language = 'javascript';
$fileInclude = $Language . ".php";
if (!file_exists($fileInclude)){
  Output(404, 'Maaf, Carik belum menguasai bahasa pemrograman ini.');
}
require_once $fileInclude;

$Text = getContent($Keyword);
if (empty($Text)){
  Output(404, "Maaf nihh... informasi tentang $Keyword belum ditemukan. Atau mungkin salah penulisan?");
}

if (strlen($Text) > 4000){
  $Text = substr($Text,0,4000) . " ...";
}

//$Text = markupBold($Text);
//$Text = markupItalic($Text);
//$Text = markupCode($Text);

if ('text' == $Format) die($Text);
Output(0, $Text);
