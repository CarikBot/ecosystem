<?php
/**
 * Brainmatics's Course
 * 
 * USAGE:
 *   curl -L "http://ecosystem.carik.test/services/partner/braindevs/course/"
 *
 * @date       01-10-2023 17:34
 * @category   Partner
 * @package    Braindevs
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
require_once "../../lib/simplehtmldom_2_0/simple_html_dom.php";

const BASE_URL = "https://brainmatics.com/";

$url = BASE_URL;
$html = file_get_html($url);
if (empty($html)){
  $Text = "Maaf, informasi kursus di Brainmatics belum bisa saya dapatkan.";
  $Text .= "Coba lagi nanti yaaa...";
  RichOutput(0, $Text);
}

$Text = "*10 LATEST SCHEDULE*";
$Text .= "\n";
foreach($html->find(".thim-course-list .lpr_course") as $row) {
  $title = strip_tags($row->find("h2")[0]->innertext);
  $url = strip_tags($row->find("h2 a")[0]->href);
  $description = trim(strip_tags($row->find(".course-description")[0]->innertext));
  $description = trim($description);
  $description = str_replace("  ", "", $description);

  $Text .= "\n*$title*";
  if (!empty($description)) $Text .= "\n$description";
  $table = $row->find("table.table-bm-center tr");
  if (count($table)>0){
    $inhouse = $table[count($table)-1]->children(0)->innertext;
    $info = $table[count($table)-1]->children(2)->innertext;
    $info = strip_tags($info);
    $Text .= "\n $inhouse, $info";
  }
  $Text .= "\n $url";
  $Text .= "\n";
}

//die($Text);
RichOutput(0, $Text);
