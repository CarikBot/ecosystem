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
$stocks = $PMIJateng->Stock($Keyword);

if (0==count($stocks)) {
  $Text = "Untuk mencari Stok Darah PMI, silakan pilih kota dari pilihan berikut:";
  $menuData = [];
  foreach ($PMIJateng->Stocks as $udd) {
    $title = $udd['udd'];
    $title = str_replace('UDD PMI ', '', $title);
    $city = trim(str_replace('Kabupaten', 'Kab', $title));
    $menuData[] = AddButton($title, "text=pstk $city");
  }
  $buttonList[] = $menuData;
  Output( 0, $Text, 'text', $buttonList, 'list');
}

$Text = "Ditemukan stok darah sebagai berikut:\n";
foreach ($stocks as $udd) {
  $Text .= "\n*".$udd['udd']."* ";
  $Text .= "```";
  $Text .= "\n A : ".@number_format($udd['A'], 0,',','.');
  $Text .= "\n B : ".@number_format($udd['B'], 0,',','.');
  $Text .= "\n AB: ".@number_format($udd['AB'], 0,',','.');
  $Text .= "\n O : ".@number_format($udd['O'], 0,',','.');
  $Text .= "```";
  $Text .= "\n update ".$udd['updateDate'];
  $Text .= "\n";
}

//die($Text);
Output(200, $Text);
