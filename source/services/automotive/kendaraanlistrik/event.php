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
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_NONE);
include_once "../../config.php";
require_once "../../lib/lib.php";

//const KL_URL = "https://www.kendaraanlistrik.net/p/daftar-acara-kendaraan-listrik.html";
const KL_URL = "./html.html";
$html = @file_get_contents(KL_URL);

$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
@$dom->loadHTML($html);

$finder = new DomXPath($dom);
$nodes = $finder->query('//div[contains(@aria-labelledby,"headingOne")]/div/ul/li');
if (0==($nodes->length)) Output(0, 'Maaf, saat ini belum ada informasi kegiatan kendaraan listrik.');

$Text = "*Daftar Acara Komunitas Kendaraan Listrik Indonesia*:\n";
foreach ($nodes as $node) {
  $title = trim(@$node->textContent);
  $title = strip_tags($title);
  $Text .= "\n- $title";
}
$Text .= "\n\nUntuk informasi detail, hubungi instagram.com/KendaraanListrikDotNet \n";

//die($Text);
Output( 0, $Text);
