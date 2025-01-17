<?php
/**
 * @date       19-07-2020 02:48
 * @category   AksiIDE
 * @package    Ecosystem Library
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version    3.0.34
 * @link       http://www.aksiide.com
 * @since
 * @history
 *   - curl_get_file_contents: timeout
 *   - GetTimeUsage function
 *   - RichOutput: define default data field in action mode
 *   - OutputData: Default response field
 *   - AlphanumericOnly
 *   - Cache Path
 *   - Remove Markdown
 *   - RemoveItemsByFieldValue
 *   - get user id and phone
 *   - get client id from payload
 *   - send abort for array content
 *   - files in action
 *   - optional parameter di AddQuestion
 *   - cancelation keyword for form handler
 *   - add suffix/prefix in json question
 *   - Rate Limit with Redis
 *   - format cache file name
 *   - generate random string
 *   - Download file
 *   - RemoveTokenParameter
 *   - IsURL
 *   - IsIPAddress
 */

const OK = 'OK';
const CANCEL = 'CANCEL';
global $ProcessingStartTime;
global $Date;
global $DateAsInteger;
$ProcessingStartTime = microtime(true);
$Date = date("Y-m-d H:i:s");
$DateAsInteger = strtotime($Date);

// force post data from json request content
$RequestContentAsJson = [];
$RequestContent = file_get_contents('php://input');
if (!empty($RequestContent)){
  $RequestContentAsJson = json_decode($RequestContent, true);
  if (isset($RequestContentAsJson['data'])){
    foreach ($RequestContentAsJson['data'] as $key => $value) {
      $_POST[$key] = $value;
    }
  }
}

$Headers = [];
if (function_exists('apache_request_headers')){
  $Headers = @apache_request_headers();
}
$Token = @$Headers['Token'];
if (empty($Token)) $Token = @$Headers['token'];

$UserId = @urldecode(@$_POST['UserID']);
$ChatId = @urldecode(@$_POST['ChatID']);
$GroupId = @urldecode(@$_POST['GroupID']);
$ChannelId = @$_POST['ChannelId'];
$ClientId = @$_POST['client_id'];
$FullName = @urldecode(@$_POST['FullName']);
$FirstName = @$_POST['FirstName'];
$LastName = @$_POST['LastName'];
if (empty($FirstName)) {
  $f = explode(' ', $FullName);
  $FirstName = $LastName = $f[0];
  if (count($f)>1) $LastName = $f[1];
}
if (empty($UserId)) $UserId = @$RequestContentAsJson['data']['user_id'];
if (empty($ClientId)) $UserId = @$RequestContentAsJson['data']['client_id'];
$userInfo = @explode('-', $UserId);
$Phone = @$userInfo[1];

function RichOutput($ACode, $AMessage, $AAction = null, $AReaction = '', $ASuffix = ''){
  @header("Content-type:application/json");
  $array['code'] = $ACode;
  $array['text'] = $AMessage;
  if (!empty($ASuffix)) $array['suffix'] = $ASuffix;
  if (!empty($AReaction)) $array['reaction'] = $AReaction;
  if (!is_null($AAction)){
    $array['type'] = 'action';
    foreach ($AAction as $key => $content) {
      if ('button' == $key){
        $array['action']['type'] = 'button';
        $array['action']['button_title'] = 'Tampilkan';
        //if (!empty($AThumbail)){
        //    $array['action']['imageDefault'] = $AThumbail;
        //}
        $array['action']['data'] = $content;
      };
      if ('list' == $key){
        $array['action']['type'] = 'list';
        $array['action']['data'] = $content;
      };
      if ('menu' == $key){
        $array['action']['type'] = 'menu';
        $array['action']['data'] = $content;
      };
      if ('files' == $key){
        $array['action']['files'] = $content;
        // $array['action']['data']['files'] = $content; // conflict with button list
      };
    }
    if (!isset($array['action']['data'])){
      $array['action']['data'] = [];
    }
    if (!empty(@$AAction['suffix'])) $array['action']['suffix'] = @$AAction['suffix'];

  }//if (!is_null($AAction))

  $output = json_encode($array, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
  die($output);
}

function Output( $ACode, $AMessage, $AField = 'text', $AAction = null, $AActionType = 'button', $ASuffix = '', $AThumbail = '', $AButtonTitle = 'Tampilkan', $AAutoPrune = false, $AWeight = 0, $AReaction = ''){
    @header("Content-type:application/json");
    $AMessage = str_replace("\r\n", '\n', $AMessage);
    $AMessage = str_replace("\r", '\n', $AMessage);
    $array['code'] = $ACode;
    $array[$AField] = $AMessage;
    if (!empty($AReaction)) $array['reaction'] = $AReaction;
    if ($AWeight>0) $array['weight'] = $AWeight;
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

function OutputWithReaction($ACode, $AMessage, $AReaction){
  Output( $ACode, $AMessage, 'text', null, '', '', '', '', false, 0, $AReaction);
}

function OutputQuestion($AText, $AACtion, $AURL, $AFormName = '', $AWeight = 0, $AOptions = []){
  @header("Content-type:application/json");
  $output['code'] = 0;
  $output['text'] = $AText;
  if ($AWeight>0) $array['weight'] = $AWeight;
  $output['type'] = 'action';
  $output['action']['type'] = 'form';
  if (!empty($AFormName)) $output['action']['name'] = $AFormName;
  $output['action']['platform'] = 'generic';
  $output['action']['url'] = $AURL;
  $output['action']['data'] = $AACtion;

  if (count($AOptions)>0){
    if (isset($AOptions['cancelation_keyword'])) $output['action']['cancelation_keyword'] = $AOptions['cancelation_keyword'];
    if (isset($AOptions['suffix'])) $output['suffix'] = $AOptions['suffix'];
    if (isset($AOptions['prefix'])) $output['prefix'] = $AOptions['prefix'];
  }

  $output = json_encode($output, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
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

function OutputData($ACode, $AData, $DataLabel = 'data'){
  @header("Content-type:application/json");
  $array['code'] = $ACode;
  $array['count'] = count($AData);
  $array[$DataLabel] = $AData;
  $output = json_encode($array, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
  die($output);
}

function GetBaseUrl(){
  $protocol = @strtolower(@$_SERVER['HTTPS']) === 'on' ? 'https' : 'http';
  $domainLink = $protocol . '://' . @$_SERVER['HTTP_HOST'];
  return $domainLink;
}

function GetCurrentURL(){
  $url = "http" . ((@$_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . @$_SERVER['HTTP_HOST'] . @$_SERVER['REQUEST_URI'];
  return $url;
}

function isURL($AText){
  return filter_var($AText, FILTER_VALIDATE_URL);
  //return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

function IsIPAddress($ip){
  $ipv4_regex = '/^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/';
  $ipv6_regex = '/^([0-9a-fA-F]{1,4}:){7}[0-9a-fA-F]{1,4}$/';
  $ip = trim($ip);

  // Periksa apakah IP adalah IPv4 atau IPv6
  if (preg_match($ipv4_regex, $ip)) {
      return 'IPv4';
  } elseif (preg_match($ipv6_regex, $ip)) {
      return 'IPv6';
  }

  return false;
}

function SendAndAbort($content){
  ignore_user_abort(true);
  set_time_limit(0);
  ob_start();
  if (is_array($content)) $content = json_encode($content, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
  echo $content;
  $buffer_size = ob_get_length();
  session_write_close();
  header("Content-Encoding: none\r\n");
  header("Content-Length: $buffer_size\r\n");
  header("Connection: close\r\n");
  ob_end_flush();
  if( ob_get_level() > 0 ) ob_flush();
  flush();
  if (function_exists('fastcgi_finish_request')) {
    fastcgi_finish_request();
  }
}

/**
 * Download file menggunakan cURL
 *
 * @param string $AURL URL file yang akan didownload
 * @param string $ATargetPath Path target penyimpanan file (opsional)
 * @return bool|string True jika sukses disimpan, string konten file jika tidak ada target path
 */
function DownloadFile($AURL, $ATargetPath = "") {
  // Inisialisasi cURL
  $ch = curl_init();

  // Konfigurasi cURL
  curl_setopt($ch, CURLOPT_URL, $AURL);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');

  // Eksekusi download
  $fileContents = curl_exec($ch);

  // Periksa error
  if (curl_errno($ch)) {
      curl_close($ch);
      return false;
  }

  // Dapatkan HTTP status code
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  // Periksa status code
  if ($httpCode !== 200) {
      return false;
  }

  // Jika path target disediakan, simpan file
  if (!empty($ATargetPath)) {
      // Pastikan direktori tersedia
      $directory = dirname($ATargetPath);
      if (!file_exists($directory)) {
          mkdir($directory, 0755, true);
      }

      // Simpan file
      $result = file_put_contents($ATargetPath, $fileContents);
      return $result !== false;
  }

  // Kembalikan konten file jika tidak ada path target
  return $fileContents;
}

/**
 * Menghapus parameter 'token' dari URL
 *
 * @param string $url URL yang akan diproses
 * @return string URL tanpa parameter token
 */
function RemoveTokenParameter($url, $AQuery) {
  // Pisahkan URL menjadi bagian path dan query string
  $urlParts = parse_url($url);

  // Jika tidak ada query string, kembalikan URL asli
  if (!isset($urlParts['query'])) {
      return $url;
  }

  // Parse query string menjadi array
  parse_str($urlParts['query'], $queryParams);

  // Hapus parameter
  unset($queryParams[$AQuery]);

  // Rebuild query string
  $newQuery = http_build_query($queryParams);

  // Rebuild URL
  $newUrl = '';

  // Tambahkan skema (http/https) jika ada
  if (isset($urlParts['scheme'])) {
      $newUrl .= $urlParts['scheme'] . '://';
  }

  // Tambahkan host
  if (isset($urlParts['host'])) {
      $newUrl .= $urlParts['host'];
  }

  // Tambahkan path
  if (isset($urlParts['path'])) {
      $newUrl .= $urlParts['path'];
  }

  // Tambahkan query string jika ada
  if (!empty($newQuery)) {
      $newUrl .= '?' . $newQuery;
  }

  return $newUrl;
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

function curl_get_file_contents($URL, $ATimeout= 0)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
    if ($ATimeout>0){
      if ($ATimeout > 10) $ATimeout = 3;
      //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); //wait indefinitely
      //curl_setopt($ch, CURLOPT_TIMEOUT_MS, $ATimeoutMiliSecond);
      curl_setopt($c, CURLOPT_TIMEOUT, $ATimeout);
    }
    $contents = curl_exec($c);
    if (curl_errno($c)) {
      $error_msg = curl_error($c);
      //die($error_msg);
    }
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

function isStringExist($needle, $AText){
  if (empty($needle)) return false;
  return strpos($AText, $needle) !== false;
}

function removeWhiteSpace($text){
  $text = preg_replace('/[\t\n\r\0\x0B]/', '', $text);
  $text = preg_replace('/([\s])\1+/', ' ', $text);
  $text = trim($text);
  return $text;
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

function StringCut($AText, $ALimit, $DoStripTags = false, $AddEllipsis = false){
  if ($AText){
    if (strlen($AText)<$ALimit) return $AText;
    $AText = ($DoStripTags ? strip_tags($AText) : $AText);
    $stringCut = substr($AText, 0, $ALimit);
    $endPoint = strrpos($stringCut, ' ');
    $AText = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
    if ($AddEllipsis) $AText .= "...";
  }
  return $AText;
}

function LimitTextWords($content = false, $limit = false, $stripTags = false, $ellipsis = false){
  if ($content && $limit) {
    $content = ($stripTags ? strip_tags($content) : $content);
    $content = explode(' ', $content, $limit+1);
    array_pop($content);
    if ($ellipsis) {
      array_push($content, '...');
    }
    $content = implode(' ', $content);
  }
  return $content;
}

function LimitTextChars($content = false, $limit = false, $stripTags = false, $ellipsis = false){
  if ($content && $limit) {
    $content  = ($stripTags ? strip_tags($content) : $content);
    $ellipsis = ($ellipsis ? "..." : $ellipsis);
    $content  = mb_strimwidth($content, 0, $limit, $ellipsis);
  }
  return $content;
}

function RemoveMarkdown($Text){
    // Hapus tag inline seperti *bold*, _italic_, `code`
    $Text = preg_replace('/(\*|_|\`)(.*?)\1/', '$2', $Text);

    // Hapus tag header seperti # Header
    $Text = preg_replace('/\#+\s+(.*)/', '$1', $Text);

    // Hapus tag list seperti * List item
    $Text = preg_replace('/(\*\s+|\-\s+)(.*)/', '$2', $Text);

    // Hapus tag link seperti [text](url)
    $Text = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '$1', $Text);

    return $Text;
}

function fixHtml($html) {
  $dom = new DOMDocument();
  @$dom->loadHTML( mb_convert_encoding( $html, 'HTML-ENTITIES', 'UTF-8' ) );
  $return = '';
  foreach ( $dom->getElementsByTagName( 'body' )->item(0)->childNodes as $v ) {
      $return .= $dom->saveHTML( $v );
  }
  return $return;
}

function TitleCase($string)
{
  return preg_replace_callback(
    '~[/.-]\p{Ll}~u',
    function ($m) {
        return mb_strtoupper($m[0], 'UTF-8');
    },
    mb_convert_case($string, MB_CASE_TITLE, 'UTF-8')
  );
}

function RandomString($length = 10) {
  return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

/**
 * Convert HTML tag OL to plain text numbering
 * USAGE:
 *   $text = TagOrderToNumber($text);
 *   $text = TagOrderToNumber($text, "ul");
 */
function TagOrderToNumber($html, $tag = "ol", $IsUseNumber = true)
{
  global $_useNumber;
  $_useNumber = $IsUseNumber;
  $pattern = "/<$tag>(.*?)<\/$tag>/s";
  $return = preg_replace_callback(
    $pattern,
    function ($m) {
      global $_useNumber;
      $liHtml = $m[1];
      $dom = new DOMDocument();
      $dom->loadHTML($liHtml);
      $items = $dom->getElementsByTagName("li");
      $replacementText = "";
      foreach ($items as $index => $item) {
        $caption = $item->nodeValue;
        $number = $index + 1;
        $prefix = ($_useNumber) ? "$number." : "-";
        $replacementText .= "$prefix $caption\n";
      }
      return $replacementText;
    },
    $html
  );
  unset($_useNumber);
  return $return;
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
  $file = @fopen ($AFileName, 'w+');
  if ($file) {
      fwrite($file, $AText);
      fclose($file);
  }
}

function AddToLog( $AText, $AFileLog = ""){
  if (empty($AFileLog)) $AFileLog = getcwd()."/logs/logs-" . Date("Ymd") . ".txt";
  $file = fopen($AFileLog, 'a');
  if ($file) {
    $date = date('YmdHis');
    $text = "$date: $AText";
    fwrite($file, $text.PHP_EOL);
    fclose($file);
    return true;
  }else{
    return false;
  }
}

function readCache( $AName, $AAgeInMinute = 30, $APath = 'cache', $AExtension = 'txt'){
  $AName = str_replace('https://', '', $AName);
  $AName = str_replace('/', '-', $AName);
  $fileName = "$APath/$AName.$AExtension";
  if (!file_exists($fileName)){
      return '';
  }

  if (time()-filemtime($fileName) > ($AAgeInMinute * 60)) {
      return '';
  }

  return readTextFile( $fileName);
}
function writeCache( $AName, $AText, $APath = 'cache', $AExtension = 'txt'){
  $AName = str_replace('https://', '', $AName);
  $AName = str_replace('/', '-', $AName);
  $fileName = "$APath/$AName.$AExtension";
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

function DateAdd($NumberOfDay){
  $numberOfDay = ($NumberOfDay > 0) ? "+$NumberOfDay" : "-$NumberOfDay";
  $date = date('Y-m-d', strtotime("$numberOfDay day"));
  return $date;

  //any date
  //date('Y-m-d', strtotime("+1 day", strtotime($date)));
}

function toHijriah($tanggal){
  $array_month = array("Muharram", "Safar", "Rabiul Awwal", "Rabiul Akhir", "Jumadil Awwal","Jumadil Akhir", "Rajab", "Sya'ban", "Ramadhan","Syawwal", "Zulqaidah", "Zulhijjah");

  $date = intval(substr($tanggal,8,2));
  $month = intval(substr($tanggal,5,2));
  $year = intval(substr($tanggal,0,4));

  if (($year>1582)||(($year == "1582") && ($month > 10))||(($year == "1582") && ($month=="10")&&($date >14))) {
      $jd = intval((1461*($year+4800+intval(($month-14)/12)))/4)+
      intval((367*($month-2-12*(intval(($month-14)/12))))/12)-
      intval( (3*(intval(($year+4900+intval(($month-14)/12))/100))) /4)+
      $date-32075;
  } else {
      $jd = 367*$year-intval((7*($year+5001+intval(($month-9)/7)))/4)+
      intval((275*$month)/9)+$date+1729777;
  }

  $wd = $jd % 7;
  $l  = $jd - 1948440 + 10632;
  $n  = intval(($l-1) / 10631);
  $l  = $l - 10631 * $n + 354;
  $z  = (intval((10985-$l)/5316))*(intval((50*$l)/17719))+(intval($l/5670))*(intval((43*$l)/15238));
  $l  = $l-(intval((30-$z)/15))*(intval((17719*$z)/50))-(intval($z/16))*(intval((15238*$z)/43))+29;
  $m  = intval((24*$l)/709);
  $d  = $l-intval((709*$m)/24);
  $y  = 30*$n+$z-30;
  $g  = $m-1;

  $hijriah = "$d $array_month[$g] $y H";

  return $hijriah;
}

function getRequestBody(){
  return file_get_contents('php://input');
}

function getRequestBodyAsArray(){
  return json_decode(getRequestBody(),true);
}

function GetSavedParameter($AKeyword, $ADefaultValue = '', $AMaxAgeInMinutes = 0){
  return GetSavedKeyword($AKeyword, $ADefaultValue, $AMaxAgeInMinutes);
}

function GetSavedKeyword($AKeyword, $ADefaultValue = '', $AMaxAgeInMinutes = 0){
  if (empty($AKeyword)) return '';
  if (!isStringExist('saved', $AKeyword)) $AKeyword = 'saved'.$AKeyword;
  $a = @urldecode(@$_POST[$AKeyword]);
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
 *
 */
function encrypt($AString, $AKey, $ARandom = true) {
  if ($ARandom){
    $iv = random_bytes(16);
  }else{
    $iv = 'Carik Ecosystem!';
  }
  $key = cryptGetKey($AKey);
  $result = cryptSign(openssl_encrypt($AString,'aes-256-ctr',$key,OPENSSL_RAW_DATA,$iv), $key);
  return bin2hex($iv).bin2hex($result);
}

function decrypt($ADecryptedString, $AKey) {
  $iv = hex2bin(substr($ADecryptedString, 0, 32));
  $data = hex2bin(substr($ADecryptedString, 32));
  $key = cryptGetKey($AKey);
  if (!cryptVerify($data, $key)) {
    return null;
  }
  return openssl_decrypt(mb_substr($data, 64, null, '8bit'),'aes-256-ctr',$key,OPENSSL_RAW_DATA,$iv);
}

  function cryptSign($message, $key) {
    return hash_hmac('sha256', $message, $key) . $message;
  }

  function cryptVerify($bundle, $key) {
    return hash_equals(
      hash_hmac('sha256', mb_substr($bundle, 64, null, '8bit'), $key),
      mb_substr($bundle, 0, 64, '8bit')
    );
  }
  function cryptGetKey($password, $keysize = 16) {
    return hash_pbkdf2('sha256',$password,'some_token',100000,$keysize,true);
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

function ShuffleArray($array) {
  $keys = array_keys($array);
  shuffle($keys);
  foreach($keys as $key) {
      $new[$key] = $array[$key];
  }
  return $new;
}

function IsExistInArray($AText, $AArrays, $AFieldName){
  if (!is_array($AArrays)) return false;
  foreach ($AArrays as $row) {
    $item = @$row[$AFieldName];
    if ($item==$AText){
      return $row;
    }
  }
  return false;
}

function RemoveItemsByFieldValue(&$array, $field, $valueToRemove) {
  foreach ($array as $key => $item) {
      if ($item[$field] == $valueToRemove) {
          unset($array[$key]);
      }
  }
}


/**
 * CUSTOM ACTION
 *
 */

function FeedBackAndDonation($AText, $AButtonList = []){
  $buttons = [];
  $buttons[] = AddButton("📝 Kritik & Saran", "text=mau kritik");
  $buttons[] = AddButton("🌟 Donasi", "text=mau donasi");
  $AButtonList[] = $buttons;

  Output( 0, $AText, 'text', $AButtonList, 'button', '', 'https://carik.id/images/banner.jpg');
}

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
function AddButtonAction( $AArray, $AButtonList, $AURL = ''){
  $AArray['type'] = 'action';
  $AArray['action']['type'] = 'button';
  if (!empty($AURL)) $AArray['action']['url'] = $AURL;
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

function AddQuestion( $AType, $AVariableName, $ATitle, $AData = []){
  $item['title'] = $ATitle;
  $item['name'] = $AVariableName;
  $item['type'] = $AType;
  if (('option' == $AType)||('list' == $AType)){
    $item['options'] = @$AData['options'];
    if (isset($AData['values'])){
      $item['values'] = @$AData['values'];
    }
  }else{
    foreach ($AData as $key => $value) {
      $item[$key] = $value;
    }
  }
  return $item;
}

function isJson($string) {
  json_decode($string);
  return json_last_error() === JSON_ERROR_NONE;
}

// if (IsDebug()) { //--// }
function IsDebug() {
  $debugFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".debug";
  if (file_exists($debugFile)) return true;
  return false;
}

// if (IsLocal()) { //--// }
function IsLocal() {
  $localFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".local";
  if (file_exists($localFile)) return true;
  return false;
}

function ReformatOptions($AOptions, $AFieldName = 'options'){
  $index = 0;
  foreach ($AOptions as $row) {
    $options = $row[$AFieldName];
    if (empty($options)) $options = '{}';
    $options = json_decode($options, true);
    $AOptions[$index][$AFieldName] = $options;
    $index++;
  }
  return $AOptions;
}

function FormatPhoneNumber($phone){
  $phone = preg_replace("/[\W_]+/u", '', $phone); //alphanumeric only
  if (substr($phone, 0, 1) == '0'){
    $phone = '62'.substr($phone, 1);
  }
  return $phone;
}

function AlphanumericOnly($AText){
  $AText = preg_replace("/[\W_]+/u", '', $AText); //alphanumeric only
  return $AText;
}

/**
 * Format Print
 * Example:
 *   formatPrint("Wohoo", ['blue', 'bold', 'italic','strikethrough']);
 *   formatPrintLn("I'm invicible", ['yellow', 'italic']);
 *   formatPrintLn("I'm invicible", ['yellow', 'bold']);
 */
function write(string $text = '', array $format=[]) {
  $codes=[
    'bold'=>1,
    'italic'=>3, 'underline'=>4, 'strikethrough'=>9,
    'black'=>30, 'red'=>31, 'green'=>32, 'yellow'=>33,'blue'=>34, 'magenta'=>35, 'cyan'=>36, 'white'=>37,
    'blackbg'=>40, 'redbg'=>41, 'greenbg'=>42, 'yellowbg'=>44,'bluebg'=>44, 'magentabg'=>45, 'cyanbg'=>46, 'lightgreybg'=>47
  ];
  $formatMap = array_map(function ($v) use ($codes) { return $codes[$v]; }, $format);
  echo "\e[".implode(';',$formatMap).'m'.$text."\e[0m";
}
function writeLn(string $text = '', array $format=[]) {
  write($text, $format); echo "\r\n";
}

function GetTimeUsage($AStartTime = 0){
  global $ProcessingStartTime;
  $timeStart = $ProcessingStartTime;
  if ($AStartTime > 0) $timeStart = $AStartTime;
  $timeStop = microtime(true);
  $timeUsage = round(($timeStop - $timeStart)*1000);
  return $timeUsage;
}

/**
 * ref:
 *   https://github.com/nikolaposa/rate-limit
 * parameter:
 *   limit: number of hit per time window
 *   timeWindow: in second
 * example:
 *   // limit 10 request per 1 second
 *   if (isRateLimited('abc', 100, 1)){
 *     // limited
 *   }
 */
function isRateLimited($key, $limit = 10, $timeWindow = 1, $options = []) {
  try {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
  } catch (\Throwable $th) {
    //throw $th;
    return true;
  }

  $currentTime = time();
  $key = "rate_limit:$key-$limit";
  $current = (int) $redis->get($key);
  if ($current >= $limit){
    return true;
  }

  // update counter
  $current = (int) $redis->incr($key);
  if ($current === 1){
    $redis->expire($key, $timeWindow);
  }

  return false;
}
