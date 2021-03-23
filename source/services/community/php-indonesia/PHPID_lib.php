<?php
/**
 * USAGE
 *   $PHPID = new PHPID;
 *   $PHPID->Token = '';
 *   
 *   $data = $PHPID->PastEvent();
 * 
 * @date       20-02-2020 21:28
 * @category   AksiIDE
 * @package    Wikipedia
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */

//namespace Carik\PHPID;

/**
 * PHPID Handler
 *
 * @author Luri Darmawan <luri@carik.id>
 */
class PHPID{
  const PHP_EVENT_LIST_URL = 'https://raw.githubusercontent.com/phpid-jakarta/phpid-online-learning-2020/master/data.json';
  const PHP_AJARI_URL = 'https://raw.githubusercontent.com/phpid-jakarta/ajari-koding/master/data.json';
  const INDONESIAN_MONTH_LIST = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
  
  public function __construct(){
    $this->Referer = @$_SERVER['HTTP_REFERER'];
  }

  public static function PastEvent(){
    $data = @file_get_contents(self::PHP_EVENT_LIST_URL);
    if (empty($data)) return [];
    $dataAsArray = json_decode($data, true);
    $events = [];
    foreach ($dataAsArray['data'] as $key => $item) {
      $a = explode(',', trim($item['date']));
      $a = trim($a[1]);
      $b = explode(' ', $a);
      $b[1] = array_search($b[1], self::INDONESIAN_MONTH_LIST)+1;
      $date = $b[2] . '-' . $b[1] . '-' . $b[0];
    
      $t1 = strtotime($date);
      $t2 = strtotime(date('Y-m-d'));
      $dateDiff = $t1 - $t2;
    
      if ($dateDiff<0){
        continue;
      }
    
      $event = $item;
      $events[] = $event;
    }
    if (count($events)==0) return false;

    uasort($events, ['PHPID','compareEventDate']);
    return $events;
  }

  public static function AjariSearchByTag($ATags){
    if (empty($ATags)) return [];
    $tags = explode(' ', $ATags);
    $data = @file_get_contents(self::PHP_AJARI_URL);
    if (empty($data)) return [];
    $dataAsArray = json_decode($data, true);
    $dataAsArray = $dataAsArray['awesome_list'];

    $lists = [];
    foreach ($dataAsArray as $item) {
      $topicTags = $item['topic_tags'];
      if (!PHPID::searchTags( $tags, $topicTags)) continue;
      $lists[] = $item;      
    }
    return $lists;
  }

  private static function searchTags( $ATags, $ATopicTags){
    $state = false;
    foreach ($ATags as $tag) {
      if (in_array($tag, $ATopicTags)) return true;
    }
    return $state;
  }

  public static function toRealDate($AString){
    global $IndonesianMonthList;
    $x = explode(',', trim($AString));
    $x = trim($x[1]);
    $y = explode(' ', $x);
    $y[1] = array_search($y[1], self::INDONESIAN_MONTH_LIST)+1;
    $date = $y[2] . '-' . $y[1] . '-' . $y[0];
    return $date;
  }

  public static function compareEventDate($a, $b) {
    $d1 = PHPID::ToRealDate($a['date']);
    $d2 = PHPID::ToRealDate($b['date']);
    $d1 = strtotime($d1);
    $d2 = strtotime($d2);
    if ($d1 == $d2) return 0;
    return ($d1 < $d2) ? -1 : 1;
  }
  
}

