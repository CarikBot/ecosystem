<?php
/**
 * Daftar Peserta INL
 *
 * USAGE:
 *   curl "http://ecosystem.carik.test/services/partner/ihasa/inl-participant/"
 *
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_NONE);
require_once "../../lib/lib.php";
require_once "../../config.php";

$sheet_url = $Config['packages']['partner']['ihasa']['inl_participant']['url'];
$sheet_name = $Config['packages']['partner']['ihasa']['inl_participant']['sheet_name'];
$sheet_url = urlencode($sheet_url);
$url = GOOGLESHEETREADER_BASEURL . "/?url=$sheet_url&sheet_name=$sheet_name";

$participants = @file_get_contents($url);
if (empty($participants)) RichOutput(0, "Maaf, informasi daftar peserta INL 2024 belum bisa saya peroleh. Coba lagi nanti yaa");

$participants = json_decode($participants, true);

// short by partner
$participantByPartner = [];
foreach ($participants as $participant) {
  $clubIndex = "Lainnya";
  $club = strtoupper(trim($participant['Nama Klub / Club Name']));
  if (isStringExist('KPBI', $club)) $clubIndex = 'KPBI';
  if (isStringExist('PERDANA', $club)) $clubIndex = 'PERDANA';
  if (isStringExist('BANDI', $club)) $clubIndex = 'PERDANA';
  $participantByPartner[$clubIndex][] = $participant;
}
ksort($participantByPartner);


$Text = "*Daftar Peserta INL 2024*";
$Text .= "\n";

foreach ($participantByPartner as $partner => $participants) {
  $Text .=  "\n| *$partner*";
  $index = 1;
  foreach ($participants as $participant) {
    $name = trim(strtoupper($participant['Nama Rider / Rider Name']));
    $club = trim($participant['Nama Klub / Club Name']);
    $paid = strtoupper(trim($participant['Lunas']));
    $Text .= "\n$index. $name, $club";
    if ($paid=='Y') $Text .= " ✅";
    $index++;
  }

  $Text .= "\n";
}

$Text .= "\n_Catatan:_";
$Text .= "\n ✅ Konfirm Lunas";

// die($Text);
RichOutput(0, $Text);

