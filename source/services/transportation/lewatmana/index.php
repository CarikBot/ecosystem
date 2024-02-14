<?php
/**
* File: index.php
*
* @date       20-09-2017 22:33
* @category   AksiIDE
* @package    AksiIDE
* @subpackage
* @copyright  Copyright (c) 2013-endless AksiIDE
* @license
* @version
* @link       http://www.aksiide.com
* @since
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once "../../lib/lib.php";
require_once "config.php";

$keyword = @$_GET['keyword'];
if (empty($keyword)){
  RichOutput(0, "Maaf, informasi trafik belum tersedia");
}
$keyword = str_replace( 'hari ini', "", $keyword);
$keyword = str_replace( 'hariini', "", $keyword);
$keyword = str_replace( 'sekarang', "", $keyword);
$keyword = str_replace( 'kemaren', "", $keyword);
$keyword = str_replace( 'besok', "", $keyword);
$keyword = trim($keyword);


$url = $Config['lewatmana']['url'] . $keyword;
$html = @file_get_contents($url);
if (empty($html)){
  RichOutput(0, "Maaf, informasi trafik belum tersedia.");
}

$text = strstr( $html, '<div class="panel-search-result">');
$text = strstr( $html, '<ul class="media-list">');
$text = rstrstr( $text, '<div class="panel-footer cam-viewer-footer">');

$text = strip_tags( $text, "<span>");
$text = preg_replace('/\s+/', ' ',$text);
$text = str_replace( "<span", "\n<span", $text);
$text = trim($text);
$text = strip_tags( $text);
$text = str_replace( 'seconds', "detik", $text);
$text = str_replace( 'a minute ago', "baru saja", $text);
$text = str_replace( 'minutes', "menit", $text);
$text = str_replace( 'hours', "jam", $text);
$text = str_replace( 'days', "hari", $text);
$text = str_replace( 'weeks', "minggu", $text);
$text = str_replace( 'months', "bulan", $text);
$text = str_replace( 'second', "detik", $text);
$text = str_replace( 'minute', "menit", $text);
$text = str_replace( 'hour', "jam", $text);
$text = str_replace( 'day', "hari", $text);
$text = str_replace( 'week', "minggu", $text);
$text = str_replace( 'month', "bulan", $text);
$text = str_replace( 'ago', "lalu:", $text);
$text = str_replace( ' RT ', " ", $text);

$text = preg_replace('/#([\w-]+)/i', '', $text); // @someone
$text = preg_replace('/@([\w-]+)/i', '', $text); // #tag
$text = preg_replace('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', '', $text);

$text = str_replace( "pic.twitter.com/", "", $text);
$text = trim($text);
if (empty($text)){
  RichOutput(0, "Mohon maaf, informasi trafik tidak ditemukan.");
}

$a = preg_split("/((\r?\n)|(\r\n?))/", $text);

$i = 0;
$output = "*Info Trafik*";
$output .= "\n";
foreach ($a as $line) {
    $row = trim( $line);
    $pos = strpos($row, '&middot;');
    if ($pos !== false) {
        $i = $i + 1;
        if ($i > 5){
            break;
        }
        $row = str_replace( '&middot;', "\n- ", $row);
        $output .= "$row\n";
    }
    # code...
}
$output = trim($output);
$output = preg_replace('/\n\n/', "\n",$output);

// die($output);
RichOutput(0, $output);
