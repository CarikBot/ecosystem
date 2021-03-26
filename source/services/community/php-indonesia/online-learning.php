<?php
/**
 * USAGE
 *   curl "http://localhost/services/ecosystem/community/php-indonesia/online-learning/" -d "keyword=machine learning"
 * 
 * 
 * @date       20-02-2020 21:08
 * @category   community
 * @package    PHP Indonesia Event List
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../config.php";
include_once "../../lib/lib.php";
include_once "PHPID_lib.php";

$Text = "*PHPID Online Learning* adalah kegiatan belajar/diskusi/seminar/workshop online yang diselenggarakan oleh PHPID.

Untuk mencari informasi online learning yang pernah berlangsung, silakan ketik pesan dengan format:
``` phpid learning [keyword]```
misal:
``` phpid learning database```
";

$Keyword = urldecode(@$_GET['keyword']);
if (empty($Keyword)) $Keyword = urldecode(@$_POST['keyword']);
if (empty($Keyword)) Output(0, $Text);

$events = PHPID::OnlineLearningSearchByTag($Keyword);
if (!$events) Output(0, "Maaf, informasi online learning '$Keyword' belum tersedia.");

$Text = "ℙℍℙ𝕀𝔻 𝕆𝕟𝕝𝕚𝕟𝕖 𝕃𝕖𝕒𝕣𝕟𝕚𝕟𝕘:\n";
$Text .= "*PHPID Online Learning* adalah kegiatan belajar/diskusi/seminar/workshop online yang diselenggarakan oleh PHPID.\n";
foreach ($events as $key => $event) {
  $time = @$event['time'];
  $url = @$event['registrasi'];
  $videos = @$event['videos'];
  if (empty($videos)) $videos = [];
  $url = str_replace('[url event]','', $url);
  if ($url == 'empty') $url = '';

  if (!empty($url)){
    //$Text .= "\n[" . $event['topic'] . "]($url)";
    $Text .= "\n*" . $event['topic'] . "*";
  }else{
    $Text .= "\n*" . $event['topic'] . "*";
  }

  $Text .= "\noleh: " . $event['speaker'];
  $Text .= "\n" . $event['date'] . ' ' . $time;
  if (!empty($url)){
    $Text .= "\n[Lihat di sini](".$url.")";
    //$Text .= "\n".escapeMarkdown($url);
  }
  foreach ($videos as $video) {
    if (('empty'!==$video)) $Text .= "\n[video]($video)";
  }
  $Text .= "\n";
}

//die($Text);
Output(0, $Text);