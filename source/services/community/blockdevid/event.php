<?php
/**
 * Event Komunitas Blockchain di Indonesia
 *
 * USAGE:
 *   curl -L "http://ecosystem.carik.test/services/community/blockdevid/event/"
 *
 * @date       06-08-2023 17:06
 * @category   Community
 * @package    BlockDevId
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

const BASE_URL = "https://blockdev.id/event";
$url = BASE_URL;
$html = file_get_html($url);
if (empty($html)){
  $Text = "Maaf, informasi event Blockdev.id belum bisa saya dapatkan.";
  $Text .= "Coba lagi nanti yaaa...";
  RichOutput(0, $Text);
}

$events = [];
foreach($html->find("div.col-lg-4") as $row) {
  $date = strip_tags($row->find("li")[0]->innertext);
  $title = strip_tags($row->find("h4")[0]->innertext);
  $url = "https://blockdev.id".($row->find("h4 a")[0]->href);

  $eventDate = DateTime::createFromFormat('d M Y', $date);
  $currentDate = new DateTime();
  $dateRange = $currentDate->sub(new DateInterval('P14D')); //14 days
  if ($eventDate < $dateRange) {
    continue;
  }
  $event['date'] = $date;
  $event['title'] = $title;
  $event['url'] = $url;
  $events[] = $event;

}

if (count($events)==0){
  $text = "Maaf, saat ini belum ada informasi event BlockDevid.";
  RichOutput(0, $text);
}

$Text = "*DAFTAR EVENT BLOCKDEVID*";
$Text .= "\n";
foreach ($events as $event) {
  $date = $event['date'];
  $Text .= "\n*$event[title]*";
  $Text .= "\n$date" ;
  $Text .= "\n$event[url]";
  $Text .= "\n";
}

RichOutput(0, $Text);
