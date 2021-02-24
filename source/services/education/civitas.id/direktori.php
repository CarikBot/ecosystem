<?php
/**
 * USAGE
 *   curl "http://localhost/services/ecosystem/education/civitas.id/direktori/" -d "Keyword=bumi"
 *   curl "http://ecosystem.carik.id/services/education/civitas.id/direktori/" -d "Keyword=bumi"
 * 
 * @date       04-01-2021 01:35
 * @category   Education
 * @package    Civitas Directory Library
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
require_once "Civitas_lib.php";

$Keyword = @$_POST['Keyword'];
$Keyword = urldecode($Keyword);
if (empty($Keyword)){
  Output(200, 'Maaf, permintaan tidak lengkap.');
}

$BaseURL = @$Config['packages']['education']['civitas']['base_url'];
$Key = @$Config['packages']['education']['civitas']['key'];

if ((empty($BaseURL))or(empty($Key))) Output(500, 'Maaf, informasi direktori kampus gagal diperoleh.');

$Civitas = new Civitas;
$Civitas->BaseURL = $BaseURL;
$Civitas->Key = $Key;
$campusList = $Civitas->SearchKampus($Keyword);
if (!$campusList) Output(404, 'Informasi kampus tidak ditemukan ...');

$Text = "*Info Kampus Jabar dan Banten*\n";
if ($Civitas->Count==0){
  Output(404, 'Informasi kampus tidak ditemukan');
}

if ($Civitas->Count==1){
  $campus = $campusList[0];
  $id = $campus['id'];
  $Text .= "\n*".$campus['name']."*[.](".API_PATH.$campus['logo'].")";
  $Text .= "\n".$campus['education_form'] . ' ' . $campus['education_type'];
  $Text .= "\n".$campus['campuses'][0]['address'];
  $Text .= "\n".$campus['campuses'][0]['city'] . ' - ' . $campus['campuses'][0]['post_code'];
  $Text .= "\n".$campus['campuses'][0]['province'];
  $Text .= "\n".$campus['phone'];
  $Text .= "\n".$campus['website'];

  $menuData = [];
  $menuData[] = AddButton('Jurusan', "text=ik1j $id");
  $menuData[] = AddButton('Beasiswa', "text=ik1b $id");
  $buttonList[] = $menuData;
  Output( 0, $Text, 'text', $buttonList, 'button');
}

if ($Civitas->Count>1) $Text .= "\nDitemukan setidaknya ada ".$Civitas->TotalItems." kampus yang mungkin serupa.";

$campusListAsText = '';
$menuData = [];
foreach ($campusList as $key => $value) {
  $id = $value['id'];
  $name = $value['name'];
  $menuData[] = AddButton($name, "text=ik1d $id");
  $campusListAsText .= "\n- $name";
}

$buttonList[] = $menuData;
Output( 0, $Text, 'text', $buttonList, 'menu');
