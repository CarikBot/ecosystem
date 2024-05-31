<?php
/**
 * USAGE
 *   curl 'http://localhost/services/ecosystem/community/cafestartup/startuplist/'
 *
 * @date       25-03-2020 13:19
 * @category   community
 * @package    Cafestartup - startup list
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
include_once "../../lib/CarikGoogleScript_lib.php";
include_once "config.php";

$Text = "*Quickcount PEMIRA IKAE Elektro Polines 2024*";

$DocId = @$Config['packages']['community']['polines_semarang']['pemira_doc_id'];
$ScriptId = @$Config['packages']['community']['polines_semarang']['script_id'];
$SheetName = "Form Responses 1";

if ((empty($DocId))||(empty($ScriptId))||(empty($SheetName))){
  Output(200, 'Maaf, belum bisa akses ke hasil quickcount PEMIRA.');
}

$GS = new GoogleScript;
$GS->DocId = $DocId;
$GS->ScriptId = $ScriptId;
$GS->SheetName = $SheetName;
$votelist = $GS->Get();

$quickcount = [];
foreach ($votelist as $vote) {
  $keys = array_keys($vote);
  $indexName = $keys[1];
  $candidateName = @$vote[$indexName];
  $quickcount[$candidateName] = @$quickcount[$candidateName] + 1;
}

$quickcount = [];
if (count($quickcount)==0){
  $Text .= "\nHasil quickcount belum tersedia.";
  Output(200, $Text);
}


foreach ($quickcount as $key => $value) {
  $Text .= "\n$key: $value";
}

Output(200, $Text);
