<?php
/**
 * 
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../config.php";
include_once "../../lib/lib.php";
include_once "ELBEProperty_lib.php";

//$Token = $Config['packages']['tools']['elbeproperty']['token'];

$Keyword = @$_POST['Keyword'];
$Keyword = urldecode($Keyword);

$ELBEProperty = new ELBEProperty;
$properties = $ELBEProperty->Find('', $Keyword);
if (empty($properties)){
  Output(200, 'Maaf, informasi pencarian rumah tidak ditemukan.');
}

$Text = "*Pencarian Rumah*\n";
$Text .= "\nDitemukan rumah berikut:";
foreach ($properties as $property) {
  $Text .= "\n - [$property[title]]($property[url])";
}

$Text .= "\n\nMungkin anda tertarik juga dengan properti berikut?";
//TODO: find property recommendation

Output(200, $Text);
