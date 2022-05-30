<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../config.php";
include_once "../../lib/lib.php";
include_once "PMIJateng_lib.php";

$BaseURL = @$Config['packages']['health']['PMIJateng']['base_url'];

$Keyword = urldecode(@$_POST['Keyword']);

$PMIJateng = new PMIJateng;
$PMIJateng->APIBaseURL = $BaseURL;
$schedules = $PMIJateng->Schedule($Keyword);

if (0==count($schedules)) {
  $Text = "Jadwal MU untuk sementara belum tersedia.";
  Output(0, $Text);
  $Text = "Untuk mencari Jadwal MU PMI, silakan pilih dari pilihan berikut:";
  $menuData = [];
  $cityTemp = [];
  foreach ($PMIJateng->Schedules as $udd) {
    $title = $udd['udd'];
    $title = str_replace('Kabupaten ', 'Kab ', $title);
    $city = str_replace('  ', ' ', $title);
    $city = str_replace('PMI ', '', $city);
    $title = str_replace('UDD PMI ', '', $title);
    $title = str_replace('PMI ', '', $title);
    if (!@$cityTemp[$city]){
      $cityTemp[$city] = true;
      $menuData[] = AddButton($title, "text=pjwd $city");
    }
  }
  $buttonList[] = $menuData;
  Output( 0, $Text, 'text', $buttonList, 'menu');
}

$Text = "Ditemukan jadwal MU sebagai berikut:\n";
foreach ($schedules as $udd) {
  $Text .= "\n*".$udd['udd']."* " . $udd['note'];
  $Text .= "\nTempat: ".$udd['location'];
  $Text .= "\nTanggal: ".$udd['date'];
  $Text .= "\nMulai : ".substr($udd['start'],0,5);
  $Text .= "\nSelesai: ".substr($udd['finish'],0,5);
  $Text .= "\n";
}

//die($Text);
Output(200, $Text);


