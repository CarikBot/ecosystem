<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../config.php";
include_once "../../lib/lib.php";
include_once "PMIJateng_lib.php";

$Token = @$Config['packages']['health']['pmijateng']['token'];

$Keyword = urldecode(@$_POST['Keyword']);

$PMIJateng = new PMIJateng;
$stocks = $PMIJateng->Stock($Keyword);

if (0==count($stocks)) {
  $Text = "Untuk mencari Stok Darah PMI, silakan pilih dari pilihan berikut:";
  $menuData = [];
  foreach ($PMIJateng->Stocks as $udd) {
    $title = $udd['udd'];
    $title = str_replace('UDD PMI ', '', $title);
    $city = str_replace('Kota', '', $title);
    $city = trim(str_replace('Kabupaten', '', $city));
    $menuData[] = AddButton($title, "text=pstk $city");
  }
  $buttonList[] = $menuData;
  Output( 0, $Text, 'text', $buttonList, 'menu');
}

$Text = "Ditemukan stok darah sebagai berikut:\n";
foreach ($stocks as $udd) {
  $Text .= "\n*".$udd['udd']."* ";
  $Text .= "\n A : ".$udd['A'];
  $Text .= "\n B : ".$udd['B'];
  $Text .= "\n AB: ".$udd['AB'];
  $Text .= "\n O : ".$udd['O'];
  $Text .= "\n update ".$udd['updateDate'];
  $Text .= "\n";
}

//die($Text);
Output(200, $Text);
