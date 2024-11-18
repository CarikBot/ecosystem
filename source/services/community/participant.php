<?php
/**
 * Participant List
 *
 * USAGE:
 *   curl "http://ecosystem.carik.test/services/community/participant/"
 *   curl "http://ecosystem.carik.test/services/community/participant/?name=bot"
 *
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_NONE);
require_once "../lib/lib.php";
require_once "../config.php";
require_once "config.php";

$EventName = @$_GET["name"];
$EventName = str_replace('%eventName_value%', '', $EventName);

// mapping
if ($EventName == "bot") $EventName = "Pre Event BOT";
if ($EventName == "inl") $EventName = "INL 2";

if (empty($EventName)){
  $buttons = [];
  foreach ($Config['packages']['community']["event_list"] as $eventName => $event) {
    if (!$event['active']) continue;
    $title = $event['title'];
    $buttons[] = AddButton("$title", "text=daftar peserta $eventName");
  }
  $buttonList[] = $buttons;
  $Text = "Pilih event mana yang inginkan!";
  Output( 0, $Text, 'text', $buttonList, 'button', '', 'https://carik.id/images/banner.jpg');
}

$EventNameIndex = strtolower($EventName);
$sheet_name = @$Config['packages']['community']["event_list"][$EventNameIndex]["sheet_name"];
$sheet_url = @$Config['packages']['community']["event_list"][$EventNameIndex]["sheet_url"];
$useSheet = @$Config['packages']['community']["event_list"][$EventNameIndex]["use_sheet"];
$eventTitle = @$Config['packages']['community']["event_list"][$EventNameIndex]["title"];
if ((empty($sheet_name)) or (empty($sheet_url))){
  RichOutput(0, "Nama event '$EventName' tidak saya temukan.");
}

if ($useSheet){
  $url = GOOGLESHEETREADER_BASEURL . "?sheet_name=$sheet_name&url=$sheet_url";
}else{
  $url = $sheet_url;
}

$data = curl_get_file_contents($url);
if ($data == false){
  RichOutput(0, "Maaf, informasi daftar peserta '$EventName' belum bisa saya dapatkan.\nCoba lagi nanti yaa.");
}

$dataAsJson = json_decode($data, true);
if (@$dataAsJson['code'] !== 0){
  RichOutput(0, "Carik gagal mendapatkan daftar peserta '$EventName'. Silakan coba lagi nanti yaa.");
}

if (isset($dataAsJson["text"])){
  RichOutput(0, $dataAsJson["text"]);
}

$Text = "*Daftar Peserta $eventTitle*";
if ($EventNameIndex == "pre event bot") $Text .= ShowPreEventBotParticipant($dataAsJson);
if ($EventNameIndex == "inl 2") $Text .= ShowINL2Participant($dataAsJson);

// die($Text);
RichOutput(0, $Text);

// INL #2
function ShowINL2Participant($Data){
  $text = "";
  $groupByBranch = [];
  $data = $Data['data'];
  $groupIndex = "Nama Klub / Club Name";
  $participantNameIndex = "Nama Rider / Rider Name (Full Name)";

  // group by branch
  foreach ($data as $item) {
    if (!isset($item[$groupIndex])) continue;
    $branchName = trim(strtoupper($item[$groupIndex]));
    if (empty($branchName)) continue;
    $groupByBranch[$branchName][$item[$participantNameIndex]] = $item;
  }
  ksort($groupByBranch);

  $total = 0;
  foreach ($groupByBranch as $branchName => $participants) {
    $text .= "\n\n> *$branchName*";
    ksort($participants);
    $index = 1;
    foreach ($participants as $name => $participant) {
      $text .= "\n$index. $name";
      $index++;
      $total++;
    }
  }

  $prefix = ($total ==0)? "\nBelum ada peserta yang terdaftar." : "Total $total peserta.";
  $text = "$prefix.\n$text";
  return $text;
}

// Pre Event BOT
function ShowPreEventBotParticipant($Data){
  $text = "";
  $groupByBranch = [];
  $data = $Data['data'];

  // group by branch
  foreach ($data as $item) {
    $branchName = trim(strtoupper($item['KPBI Cabang']));
    if (empty($branchName)) continue;
    $groupByBranch[$branchName][$item['Nama Lengkap']] = $item;
  }
  ksort($groupByBranch);

  $total = 0;
  foreach ($groupByBranch as $branchName => $participants) {
    $text .= "\n\n> *$branchName*";
    ksort($participants);
    $index = 1;
    foreach ($participants as $name => $participant) {
      $text .= "\n$index. $name";
      $index++;
      $total++;
    }
  }

  $prefix = ($total ==0)? "Belum ada peserta yang terdaftar." : "Total $total peserta.";
  $text = "\n$prefix.$text";
  return $text;
}
