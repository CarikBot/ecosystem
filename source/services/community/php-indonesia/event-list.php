<?php
/**
 * USAGE
 *   curl "http://localhost/services/ecosystem/community/php-indonesia/event-list/"
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

$footer = "\nLihat juga rekaman sesi sebelumnya di [Channel Youtube PHPID](https://www.youtube.com/channel/UCLTH3NjDdbPLYbOby2YjxsA) atau cari infonya di [learning.byphp.id](https://learning.byphp.id/)";

$events = PHPID::PastEvent();
if (!$events) Output(0, 'Maaf, informasi online learning belum tersedia.'.$footer);

$Text = "𝕁𝕒𝕕𝕨𝕒𝕝 𝕆𝕟𝕝𝕚𝕟𝕖 𝕃𝕖𝕒𝕣𝕟𝕚𝕟𝕘 ℙℍℙ𝕀𝔻:\n";
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

$Text .= $footer;

//die($Text);
Output(0, $Text);