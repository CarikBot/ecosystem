<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../config.php";
include_once "../../lib/lib.php";
include_once "PMIJateng_lib.php";

$Token = @$Config['packages']['health']['pmijateng']['token'];

$Keyword = urldecode(@$_POST['Keyword']);
$Keyword = str_replace('Kab ', 'Kabupaten ', $Keyword);

$PMIJateng = new PMIJateng;
$addresses = $PMIJateng->FindAddress($Keyword);
if (0==count($addresses)) {
  $Text = "Untuk mencari alamat PMI, silakan ketik\n `alamat pmi di [namakota]`\nmisal:\n `alamat pmi di Semarang`\nAtau pilih dari pilihan berikut:";
  $menuData = [];
  foreach ($PMIJateng->UDD as $udd) {
    $title = $udd['Kab/Kota'];
    $title = str_replace('UDD PMI ', '', $title);
    $city = trim(str_replace('Kabupaten', 'Kab', $title));
    $menuData[] = AddButton($title, "text=padd $city");
  }
  $buttonList[] = $menuData;
  Output( 0, $Text, 'text', $buttonList, 'menu');
}

$Text = "";
foreach ($addresses as $udd) {
  $Text .= "\n*".$udd['Kab/Kota']."*";
  $Text .= "\n".$udd['Alamat'];
  $Text .= "\n".$udd['No Telepon'];
  $Text .= "\n";
}

//die($Text);
Output(200, $Text);


