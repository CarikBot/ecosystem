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
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../config.php";
include_once "../../lib/lib.php";
include_once "../../lib/CarikGoogleScript_lib.php";
const AMOUNT_PER_PAGE = 20;

$DocId = @$Config['packages']['community']['cafestartup']['doc_id'];
$ScriptId = @$Config['packages']['community']['cafestartup']['script_id'];
$SheetName = @$Config['packages']['community']['cafestartup']['sheet_name'];
$CafestartupGroupId = @$Config['packages']['community']['cafestartup']['telegram_group_id'];

if ((empty($DocId))||(empty($ScriptId))||(empty($SheetName))){
  Output(200, 'Maaf, belum bisa akses ke daftar startup.');
}

$GroupID = @urldecode(@$_POST['GroupID_']);
$page = @$_POST['page'];
$format = @$_GET['format'];
if (empty($page)) $page = @$RequestContentAsJson['page'];
if (!is_numeric($page)) $page = '';

$GS = new GoogleScript;
$GS->DocId = $DocId;
$GS->ScriptId = $ScriptId;
$GS->SheetName = $SheetName;
$startupList = $GS->Get();
if (empty($startupList)){
  Output(200, 'Maaf, daftar startup di CafeStartup belum bisa kami akses.\nTunggu beberapa saat lagi yaa..');
}

//filter
$whiteList = [];
foreach ($startupList as $value) {
  $active = $value['Aktif'];
  if ($active=='no') continue;
  $name = $value['Nama_Startup'];
  $name = rtrim($name, '/');
  $name = str_replace('_', '\_', $name);
  $name = str_replace('www.', '', $name);
  $name = str_replace('http://', '', $name);
  $name = str_replace('https://', '', $name);
  $name = str_replace('play.google.com/store/apps/details?id=', '', $name);
  $name = str_replace('@', '', $name);
  $name = trim(strtolower($name));
  $value['Nama_Startup'] = $name;
  $username = $value['Username_Telegram'];
  $username = str_replace('https://t.me/', '', $username);
  $username = str_replace('http://', '', $username);
  $username = str_replace('https://', '', $username);
  $username = str_replace('www.', '', $username);
  $username = str_replace('@', '', $username);
  $username = str_replace(' ', '', $username);
  $value['Username_Telegram'] = $username;
  $bidangUsaha = $value['Bidang_Usaha_Startup_Anda'];
  $bidangUsaha = str_replace('_', '\_', $bidangUsaha);
  if (isCencored($name)) continue;
  if (isCencored($bidangUsaha)) continue;
  unset($value['Aktif']);
  unset($value['']);
  $whiteList[] = $value;
}
$startupList = $whiteList;

if ('json'==$format){
  $output['code'] = 0;
  $output['count'] = count($startupList);
  $output['data'] = $startupList;
  $json = json_encode($output, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
  @header("Content-type:application/json");
  die($json);
}

$n = $amountPerPage = AMOUNT_PER_PAGE;
$count = count($startupList);
$numberOfPage = round($count / $amountPerPage);
if (empty($page)) $page = $numberOfPage;
if ($page==$numberOfPage) $n += $count - ($numberOfPage*$amountPerPage);

$msg = ($n == $amountPerPage) ? "" : "\n $n data terakhir.";

$startupList = ArrayPagination($startupList, $page, $amountPerPage, true);

$i = (($page-1)*AMOUNT_PER_PAGE)+1;
$Text = "*List Startup Group CafeStartup #$page*";
$Text .= "\n Terdapat *$count startup*.";
$Text .= $msg;
foreach ($startupList as $value) {
  $name = $value['Nama_Startup'];
  $name = str_replace('_', '\_', $name);
  $name = str_replace('www.', '', $name);
  $name = str_replace('https://', '', $name);
  $name = str_replace('http://', '', $name);
  //TODO: if not domainname, dont lowercase
  $name = trim(strtolower($name));
  $username = $value['Username_Telegram'];
  $username = str_replace('_', '\_', $username);
  $bidangUsaha = $value['Bidang_Usaha_Startup_Anda'];
  $bidangUsaha = str_replace('_', '\_', $bidangUsaha);
  $location = $value['Lokasi'];
  $location = str_replace('_', '\_', $location);

  $Text .= "\n$i. $name, $username, $bidangUsaha, $location";
  $i++;
}

$buttons = [];
if ($page>1){
  $buttons[] = AddButton( '◀️◀️', 'text=slcf 1');
  $buttons[] = AddButton( '◀️ prev', 'text=slcf '.($page-1));
}
$command = 'text=slcf '.($page+1);
if (($page+1)==$numberOfPage) $command = 'text=daftar startup';
if ($page<$numberOfPage){
  $buttons[] = AddButton( 'next ▶️', $command);
}
$buttonList[] = $buttons;

$url = "https://t.me/Cafestartup";
if ($GroupID == $CafestartupGroupId){
  $url = "https://bit.ly/daftar-startup";
}

$buttons = [];
$buttons[] = AddButtonURL("🎖 Daftarkan Startup-mu", $url);
$buttonList[] = $buttons;

//die($Text);
Output( 0, $Text, 'text', $buttonList, 'button', '', '', 'Tampilkan', true);
