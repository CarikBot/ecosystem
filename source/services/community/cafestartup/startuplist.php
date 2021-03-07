<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../config.php";
include_once "../../lib/lib.php";
include_once "../../lib/CarikGoogleScript_lib.php";
const AMOUNT_PER_PAGE = 30;

$DocId = @$Config['packages']['community']['cafestartup']['doc_id'];
$ScriptId = @$Config['packages']['community']['cafestartup']['script_id'];
$SheetName = @$Config['packages']['community']['cafestartup']['sheet_name'];

if ((empty($DocId))||(empty($ScriptId))||(empty($SheetName))){
  Output(200, 'Maaf, belum bisa akses ke daftar startup.');
}

$page = @$_POST['Page'];
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
  $name = str_replace('_', '\_', $name);
  $name = str_replace('www.', '', $name);
  $name = trim(strtolower($name));
  $bidangUsaha = $value['Bidang_Usaha_Startup_Anda'];
  $bidangUsaha = str_replace('_', '\_', $bidangUsaha);
  if (isCencored($name)) continue;
  if (isCencored($bidangUsaha)) continue;
  $whiteList[] = $value;
}
$startupList = $whiteList;

$n = $amountPerPage = AMOUNT_PER_PAGE;
$count = count($startupList);
$numberOfPage = round($count / $amountPerPage);
if (empty($page)) $page = $numberOfPage;
if ($page==$numberOfPage) $n += $count - ($numberOfPage*$amountPerPage); 

$msg = ($n == $amountPerPage) ? "" : "\n $n data terakhir.";

$startupList = ArrayPagination($startupList, $page, $amountPerPage, true);

$i = (($page-1)*AMOUNT_PER_PAGE)+1;
$Text = "*List Startup Group CafeStartup*";
$Text .= "\n Terdapat $count startup.";
$Text .= $msg;
foreach ($startupList as $value) {
  $active = $value['Aktif'];
  if ($active=='no') continue;
  $name = $value['Nama_Startup'];
  $name = str_replace('_', '\_', $name);
  $name = str_replace('www.', '', $name);
  //TODO: if not domainname, dont lowercase
  $name = trim(strtolower($name));
  $username = $value['Username_Telegram'];
  $username = str_replace('_', '\_', $username);
  $username = str_replace('@', '', $username);
  $username = str_replace(' ', '', $username);
  $bidangUsaha = $value['Bidang_Usaha_Startup_Anda'];
  $bidangUsaha = str_replace('_', '\_', $bidangUsaha);
  $location = $value['Lokasi'];
  $location = str_replace('_', '\_', $location);

  $Text .= "\n$i. $name, $username, $bidangUsaha, $location";
  $i++;
}

$buttons = [];
if ($page>1){
  $buttons[] = AddButton( '◀️ prev', 'text=slcf '.($page-1));
}
if ($page<$numberOfPage){
  $buttons[] = AddButton( 'next ▶️', 'text=slcf '.($page+1));
}
$buttonList[] = $buttons;

$buttons = [];
$buttons[] = AddButtonURL("🎖 Daftarkan Startup-mu", "https://bit.ly/daftar-startup");
$buttonList[] = $buttons;

//die($Text);
Output( 0, $Text, 'text', $buttonList, 'button');
