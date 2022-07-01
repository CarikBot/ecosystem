<?php
/**
 * Donasi Solusi Peduli
 * 
 * USAGE:
 *   curl "http://localhost:8001/"
 *   
 *
 * @date       01-07-2022 15:15
 * @category   Other
 * @package    Solusi Peduli
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
require_once "../../lib/simplehtmldom_2_0/simple_html_dom.php";

const BASE_URL = 'https://solusipeduli.org/';

$html = file_get_html(BASE_URL);
if ($html == false){
  Output(400, "Maaf, informasi belum bisa ditemukan.");
}

$Text = "*Informasi Donasi Solusi Peduli*";
$Text .= "\n";
foreach($html->find("marquee label") as $row) {
    $s = trim(($row->innertext));
    $s = str_replace(' <strong>', ': ', $s);
    $s = str_replace('</strong>', '', $s);
    $Text .= "\n$s";
}

//die($Text);
Output(0, $Text);

