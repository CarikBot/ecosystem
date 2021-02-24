<?php
/**
 * USAGE
 *   curl "http://localhost/services/ecosystem/education/civitas.id/detail/" -d "ID=904c5b0a-e967-49d7-83a8-1aad9232c9a9"
 *   curl "http://ecosystem.carik.id/services/education/civitas.id/detail/" -d "ID=904c5b0a-e967-49d7-83a8-1aad9232c9a9"
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
define("API_PATH","https://apicampusdir.civitas.id");

$ID = @$_POST['ID'];
$ID = urldecode($ID);
if (empty($ID)){
  Output(200, 'Maaf, permintaan tidak lengkap.');
}

$BaseURL = @$Config['packages']['education']['civitas']['base_url'];
$Key = @$Config['packages']['education']['civitas']['key'];

if ((empty($BaseURL))or(empty($Key))) Output(500, 'Maaf, informasi direktori kampus gagal diperoleh.');

$Civitas = new Civitas;
$Civitas->BaseURL = $BaseURL;
$Civitas->Key = $Key;

$campus = $Civitas->DetailByID($ID);
if (count($campus)==0){
  $Text = 'Detail informasi kampus tidak ditemukan';
  Output( 0, $Text);
}
$Text = "*Info Kampus Jabar dan Banten*\n";
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
