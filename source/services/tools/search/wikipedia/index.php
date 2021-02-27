<?php
/**
 * USAGE
 *   curl "http://localhost/services/tools/search/wikipedia/" -d "Keyword=bumi"
 *   curl "https://ecosystem.carik.id/services/tools/search/wikipedia/" -d "Keyword=bumi"
 * 
 * @date       26-02-2021 06:45
 * @category   Wikipedia
 * @package    Wikipedia Library
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../../config.php";
include_once "../../../lib/lib.php";
include_once "Wikipedia_lib.php";

$Token = @$Config['packages']['tools']['search']['wikipedia']['token'];
$Keyword = trim(urldecode(@$_POST['Keyword']));

if (empty($Keyword)) Output( 404, 'Maaf, informasi pencarian tidak lengkap.');

$Wikipedia = new Wikipedia;
$Wikipedia->Token = $Token;
$pages = $Wikipedia->Find($Keyword);
if ($pages===false) Output(404, 'Maaf, informasi tidak ditemukan. Coba cek ulang informasi pencariannya yaa..');

$Text = "Ditemukan informasi ini:\n";
foreach ($pages as $key => $page) {
  $title = $page['title'];
  $content = @$page['extract'];
  $Text .= "\n*$title*\n$content";
}
$Text = trim($Text);
$Text .= "\n\nsumber: [wikipedia](https://id.wikipedia.org/)";

//die($Text);
Output(200, $Text);
