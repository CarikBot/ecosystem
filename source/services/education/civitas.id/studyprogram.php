<?php
/**
 * USAGE
 *   curl "http://localhost/services/ecosystem/education/civitas.id/studyprogram/" -d "ID=a1e8c356-48ef-4871-af3e-85079443f952"
 *   curl "http://ecosystem.carik.id/services/education/civitas.id/studyprogram/" -d "ID=a1e8c356-48ef-4871-af3e-85079443f952"
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
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
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

$program = $Civitas->StudyProgramByID($ID);
if (count($program)==0){
  $Text = 'Detail informasi kampus tidak ditemukan';
  Output( 0, $Text);
}


$Text = "*Jurusan/Program Studi yang ditemukan*";
$suffix = (count($program)>10) ? "di antaranya" : "yaitu";
$Text .= "\nTerdapat ".$Civitas->TotalItems." program studi, $suffix:";
foreach ($program as $item) {
  $Text .= "\n- " . $item['name'];
}

//die($Text);
Output( 0, $Text);
