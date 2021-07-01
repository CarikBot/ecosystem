<?php
/**
 * @date       19-07-2020 02:48
 * @category   AksiIDE
 * @package    Ecosystem Library
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */

// force post data from json request content
$RequestContent = file_get_contents('php://input');
if (!empty($RequestContent)){
  $RequestContentAsJson = json_decode($RequestContent, true);
  if ($RequestContentAsJson != false){
    foreach ($RequestContentAsJson['data'] as $key => $value) {
      $_POST[$key] = $value;
    }
  }
}

$UserId = urldecode(@$_POST['UserID']);
$ChatId = urldecode(@$_POST['ChatID']);
$GroupId = urldecode(@$_POST['GroupID']);
$ChannelId = @$_POST['ChannelId'];
$FullName = urldecode(@$_POST['FullName']);
$FirstName = @$_POST['FirstName'];
$LastName = @$_POST['LastName'];
if (empty($FirstName)) {
  $f = explode(' ', $FullName);
  $FirstName = $LastName = $f[0];
  if (count($f)>1) $LastName = $f[1];
}

function Output( $ACode, $AMessage, $AField = 'text', $AAction = null, $AActionType = 'button', $ASuffix = '', $AThumbail = '', $AButtonTitle = 'Tampilkan', $AAutoPrune = false){
    @header("Content-type:application/json");
    $array['code'] = $ACode;
    $array[$AField] = $AMessage;
    if (!is_null($AAction)){
        $array['type'] = 'action';
        $array['action']['type'] = $AActionType;
        $array['action']['button_title'] = $AButtonTitle;
        if (!empty($AThumbail)){
            $array['action']['imageDefault'] = $AThumbail; 
        }
        //$array['action']['mode'] = $AMode;
        $array['action']['data'] = $AAction;
    }
    if ($AAutoPrune) $array['prune'] = true;
    if (!empty($ASuffix)){
        $array['suffix'] = $ASuffix;
    }
    $output = json_encode($array, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
    die($output);
}

function OutputWithImage( $ACode, $AMessage, $AImageURL, $ACaption){
  @header("Content-type:application/json");
  $array['code'] = $ACode;
  $array['text'] = $AMessage;
  $array['image_caption'] = $ACaption;
  $array['image'] = $AImageURL;
  $output = json_encode($array, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
  die($output);
}

function isGroupChat(){
  $groupId = @$_POST['GroupID'];
  if (empty(($groupId))){
      return false;
  }else{
      return true;
  }
}

function isPrivateChat(){
  $groupId = @$_POST['GroupID'];
  if (empty(($groupId))){
      return true;
  }else{
      return false;
  }
}

function curl_get_file_contents($URL)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);

    if ($contents) return $contents;
    else return FALSE;
}

function rstrstr($haystack,$needle, $start=0){
  return substr($haystack, $start,strpos($haystack, $needle));
}

function grepStr( $AAfter, $ABefore, $AText){
  $text = strstr( $AText, $AAfter);
  $text = substr( $text, strlen($AAfter));
  $text = rstrstr( $text, $ABefore);
  $text = trim($text);
  return $text;
}

function isStringExist($needle, $AText)
{
  return strpos($AText, $needle) !== false;
}

function RemoveEmoji($string){
  // Match Enclosed Alphanumeric Supplement
  $regex_alphanumeric = '/[\x{1F100}-\x{1F1FF}]/u';
  $clear_string = preg_replace($regex_alphanumeric, '', $string);

  // Match Miscellaneous Symbols and Pictographs
  $regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
  $clear_string = preg_replace($regex_symbols, '', $clear_string);

  // Match Emoticons
  $regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
  $clear_string = preg_replace($regex_emoticons, '', $clear_string);

  // Match Transport And Map Symbols
  $regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
  $clear_string = preg_replace($regex_transport, '', $clear_string);

  // Match Supplemental Symbols and Pictographs
  $regex_supplemental = '/[\x{1F900}-\x{1F9FF}]/u';
  $clear_string = preg_replace($regex_supplemental, '', $clear_string);

  // Match Miscellaneous Symbols
  $regex_misc = '/[\x{2600}-\x{26FF}]/u';
  $clear_string = preg_replace($regex_misc, '', $clear_string);

  // Match Dingbats
  $regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
  $clear_string = preg_replace($regex_dingbats, '', $clear_string);

  return $clear_string;
}

function readTextFile( $AFileName){
  $result = '';
  if (!file_exists($AFileName)){
      return '';
  }
  $file = fopen ($AFileName, 'r');
  if ($file) {
      $result = fread($file, filesize($AFileName));
      fclose($file);
  }
  return $result;
}

function writeTextFile( $AFileName, $AText){
  $file = fopen ($AFileName, 'w+');
  if ($file) {
      fwrite($file, $AText);
      fclose($file);
  }
}

function readCache( $AName, $AAgeInMinute = 30){
  $fileName = "cache/$AName.txt";
  if (!file_exists($fileName)){
      return '';
  }

  if (time()-filemtime($fileName) > ($AAgeInMinute * 60)) {
      return '';
  }

  return readTextFile( $fileName);
}
function writeCache( $AName, $AText){
  $fileName = "cache/$AName.txt";
  writeTextFile( $fileName, $AText);
}

function convertDateFromTimezone($date,$timezone,$timezone_to,$format){
  $date = new DateTime($date,new DateTimeZone($timezone));
  $date->setTimezone( new DateTimeZone($timezone_to) );
  return $date->format($format);
}

function dateDifferentFromDateString($ADate1, $ADate2){
  $t1 = strtotime($ADate1);
  $t2 = strtotime($ADate2);
  $dateDiff = $t1 - $t2;
  return $dateDiff;  
}

function getRequestBody(){
  return file_get_contents('php://input');
}

function getRequestBodyAsArray(){
  return json_decode(getRequestBody(),true);
}

function GetSavedKeyword($AKeyword, $ADefaultValue = '', $AMaxAgeInMinutes = 0){
  if (empty($AKeyword)) return '';
  $a = urldecode(@$_POST[$AKeyword]);
  $a = @explode('|', $a);
  $date = @$a[0];
  if ((!empty($date))and($AMaxAgeInMinutes>0)){
      $diff = dateDifferentFromDateString(date('Y-m-d H:i:s'), $date);
      $diff = ($diff / (60)); //menit
      if ($diff > $AMaxAgeInMinutes) return $ADefaultValue;
  }
  $value = @$a[1];
  if (empty($value)) $value = $ADefaultValue;
  return $value;
}

/**
 * $startupList = ArrayPagination($startupList, $page, $amountPerPage, true);
 */
function ArrayPagination($AArray, $APage, $AAMountPerPage, $AWithModulo = false){
  $count = count($AArray);
  $page = $APage;

  $numberOfPage = round($count / $AAMountPerPage);
  $modulo = $count % $AAMountPerPage;
  if ($page > $numberOfPage) $page = $numberOfPage;
  $offset = (($page-1) * $AAMountPerPage);
  if ($AWithModulo) if ($page==$numberOfPage) $AAMountPerPage += $modulo; // additional modulo
  return array_slice( $AArray, $offset, $AAMountPerPage );
}

function RenameArrKey($oldKey, $newKey, $arr){
  if(!isset($arr[$oldKey])) return $arr; // Failsafe
  $keys = array_keys($arr);
  $keys[array_search($oldKey, $keys)] = $newKey;
  $newArr = array_combine($keys, $arr);
  return $newArr;
}

/**
 * $array : The initial array i want to modify 
 * $insert : the new array i want to add, eg array('key' => 'value') or array('value')
 * $position : the position where the new array will be inserted into. Please mind that arrays start at 0
 */
function ArrayInsert( $array, $insert, $position ) {
  return array_slice($array, 0, $position, TRUE) + $insert + array_slice($array, $position, NULL, TRUE);
}


/**
 * CUSTOM ACTION
 * 
 */

function AddButton( $ATitle, $AAction, $AImageURL = ''){
  $item['text'] = $ATitle;
  $item['callback_data'] = $AAction;
  if (!empty($AImageURL)){
      $item['image'] = $AImageURL;
  }
  return $item;   
}
//size: compact, tall, full -> facebook
function AddButtonURL( $ATitle, $AURL, $Size = "full"){
  $item['text'] = $ATitle;
  $item['url'] = $AURL;
  $item['size'] = $Size;
  return $item;   
}
function AddButtonAction( $AArray, $AButtonList){
  $AArray['type'] = 'action';
  $AArray['action']['type'] = 'button';
  $AArray['action']['data'] = $AButtonList;
  return $AArray;
}

// Card
function AddCard($ATitle, $ADescription, $AImageURL, $AURL){
  $item['title'] = $ATitle;
  $item['sub_title'] = $ADescription;
  $item['image_url'] = $AImageURL;
  $item['url'] = $AURL;
  return $item;   
}
