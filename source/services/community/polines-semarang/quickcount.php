<?php
/**
 * USAGE
 *   curl 'http://localhost/services/ecosystem/community/polines-semarang/quickcount/'
 *
 * @date       31-05-2024 09:02
 * @category   community
 * @package    Polines Semarang - Quick Count
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       https://carik.id
 * @since
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../config.php";
include_once "../../lib/lib.php";
include_once "../../lib/CarikGoogleScript_lib.php";
include_once "config.php";

$Text = "*Quickcount PEMIRA IKAE Elektro Polines 2024*";

$DocId = @$Config['packages']['community']['polines_semarang']['pemira_doc_id'];
$ScriptId = @$Config['packages']['community']['polines_semarang']['script_id'];
$SheetName = "Form Responses 2";

if ((empty($DocId))||(empty($ScriptId))||(empty($SheetName))){
  Output(200, 'Maaf, belum bisa akses ke hasil quickcount PEMIRA.');
}

$GS = new GoogleScript;
$GS->DocId = $DocId;
$GS->ScriptId = $ScriptId;
$GS->SheetName = $SheetName;
$votelist = $GS->Get();

// $GS->SheetName = 'validasi Nomor WA';
// $validVoterlist = $GS->Get();

$quickcount = [];
$quickcount['Narendra Bayu Putra'] = 0;
$quickcount['Febri Zuarto'] = 0;
$voterList = [];
foreach (array_reverse($votelist) as $vote) {
  $keys = array_keys($vote);
  $indexName = $keys[2];
  $indexPhone = $keys[3];
  $candidateName = @$vote[$indexName];
  $voterPhone = @$vote[$indexPhone];
  if (!isset($voterList[$voterPhone])){
    $quickcount[$candidateName] = @$quickcount[$candidateName] + 1;
    $voterList[$voterPhone] = 1;
  }
}

if (count($quickcount)==0){
  $Text .= "\nHasil quickcount belum tersedia.";
  Output(200, $Text);
}


foreach ($quickcount as $key => $value) {
  $Text .= "\n$key: $value";
}
$Text .= "\n\n_update: " . date("Y-m-d H:i:s") . "_";

// die($Text);
Output(200, $Text);
