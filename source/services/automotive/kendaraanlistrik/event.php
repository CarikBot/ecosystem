<?php
/**
 * USAGE
 *   curl "http://localhost/services/ecosystem/automotive/kendaraanlistrik/event/"
 *   curl "{ecosystem_baseurl}/services/automotive/kendaraanlistrik/event/"
 * 
 * @date       28-04-2021 23:46
 * @category   Automotive
 * @package    Kendaraan Listrik Library
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_NONE);
include_once "../../config.php";
require_once "../../lib/lib.php";
//require_once "../../lib/simplehtmldom_2_0/simple_html_dom.php";
date_default_timezone_set('Asia/Jakarta');

const KENDARAANLISTRIK_EVENTURL = "http://kendaraanlistrik.net/contents/events.json";

$context = stream_context_create(
  array(
      'http' => array(
          'follow_location' => false
      ),
      'ssl' => array(
          "verify_peer"=>false,
          "verify_peer_name"=>false,
      ),
  )
);
$content = file_get_contents(KENDARAANLISTRIK_EVENTURL, false, $context);
if (empty($content)){
  Output(0, 'Maaf, informasi kegiatan Komunitas Kendaraan Listrik belum ditemukan.');
}
$contentAsArray = json_decode($content, true);

$Text = "*Daftar Acara Komunitas Kendaraan Listrik Indonesia*:\n";
foreach ($contentAsArray as $event) {
  if ('done'==$event['type']) continue;
  $Text .= "\n*$event[title]*";
  $Text .= "\n$event[date]";
  $Text .= "\n[$event[location]]($event[link])";
  $Text .= "\n";
}
$Text .= "\n\nUntuk informasi detail, hubungi instagram.com/KendaraanListrikDotNet \n";

//die($Text);
Output(0, $Text);

/*
foreach($html->find('div[aria-labelledby="headingOne"] div[class="card-body"] ul') as $row) {
  $s = $row->find('li',0)->innertext;
  $s = strip_tags($s);
  $s = trim(str_replace('Lokasi di google maps', '', $s));
  $Text .= "\n- $s";
}
*/