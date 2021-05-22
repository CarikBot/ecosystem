<?php
/**
 * USAGE
 *   curl 'http://localhost/services/ecosystem/community/cafestartup/startuplist/'
 *
 * @date       25-03-2020 13:19
 * @category   community
 * @package    Cafestartup - startup list
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include_once "../../config.php";
include_once "../../lib/lib.php";

const JANNAHQU_API_BASEURL = "https://jannahqu.id/api/";
const JANNAHQU_NEWS_BASEURL = "https://jannahqu.id/program/";
const JANNAHQU_NEWS_COUNT = 5;


$news = @file_get_contents(JANNAHQU_API_BASEURL . "news?start=0&length=" . JANNAHQU_NEWS_COUNT);
$news = json_decode($news, true);
if (@$news["status"]!="OK"){
  Output(200, "Maaf, informasi tidak bisa diakses.");
}

$Text = "*Informasi Terkini Jannahqu*\n";
foreach ($news["values"]["data"] as $item) {
  $Text .= "\n".$item["title"];
  $Text .= "\n".JANNAHQU_NEWS_BASEURL.$item["slug"];
  $Text .= "\n";
}
$Text .= "\n[Berita selengkapnya](https://jannahqu.id/news)";

//die($Text);
Output(200, $Text);
