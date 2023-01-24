<?php
/**
 * Pencarian Resep Masakan
 * copied from old service
 *
 * USAGE
 *  curl "";
 *
 * @date       27-06-2019 16:55
 * @category   FnB
 * @package    Resep Masakan
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
//error_reporting(E_NONE);

const RESEPMASAKAN_BASE_URL = 'https://resepmasakan.id/';
const MODE = 'live';

require_once "../../lib/http_lib.php";
require_once "../../lib/CarikSuperSearch_lib.php";
require_once "../../lib/lib.php";
require_once "../../config.php";

$Query = @$_GET['q'];
if (empty($Query)) $Query = @$_POST['keyword'];
if (MODE == 'test') {
  $Query = 'bakso';
}
$Query = urldecode($Query);
if (empty($Query)) Output(0, "Maaf, parameter pencarian resep tidak lengkap.");

$Text = '';
$Resep = [];


// disable resepmasakan.id
/*
$parser = new HTTPClient();
$args['url'] = RESEPMASAKAN_BASE_URL . '?s=' . $Query;
$result = $parser->httpGet( $args);
$content = $result['content'];

$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
@$dom->loadHTML($content);

$finder = new DomXPath($dom);
$classname="type-post";
//$articles = $finder->query("//article[contains(@class, '$classname')]/div");
$articles = $finder->query("//article[contains(@class, '$classname')]");

foreach ($articles as $item) {
  $a = array();
  $node = $finder->query("div/div/header/h2/a", $item);
  $a['title'] = trim(@$node->item(0)->textContent);
  $a['url'] = trim(@$node->item(0)->getAttribute('href'));

  $node = $finder->query("div/div/a/img", $item);
  $a['image_url'] = trim(@$node->item(0)->getAttribute('src'));

  $Resep[] = $a;
}
*/

if (count($Resep)>0){
  $Text = "*Info Resep yang ditemukan:*\n\n";
  foreach ($Resep as $item) {
    $Text .= $item['title'] . "\n[Info Lengkap](" . $item['url'] . ")\n\n";
  }
}else{
  $Text = "Maaf ... info resep '".@$_GET['q']."' belum tersedia...";

  $SuperSearch = new Carik\SuperSearch;
  $SuperSearch->BaseURL = $Config['services']['supersearch']['baseurl'];
  $SuperSearch->Token = $Config['services']['supersearch']['token'];
  $result = $SuperSearch->Search("cari resep $Query");
  if ($result !== false){
    if ($result['text'] != ''){
      $Text = $result['text'];
    }
  }
}

//die($Text);
Output(0, $Text);
