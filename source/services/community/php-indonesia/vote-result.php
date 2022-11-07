<?php
/**
 * Hasil Voting Ketua PHPID
 * 
 * USAGE:
 *   curl "http://localhost:8001/vote-result.php" -d "{}"
 *   
 *
 * @date       09-10-2022 20:21
 * @category   Community
 * @package    PHP Indonesia
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set("allow_url_fopen", 1);
require_once "../../lib/lib.php";
require_once "../../lib/CarikGoogleScript_lib.php";
require_once "../../config.php";
date_default_timezone_set('Asia/Jakarta');

const KANDIDAT = ['', 'Nur Hidayat', 'Mizno Kruge', 'Luri Darmawan'];

$DocId = @$Config['packages']['community']['phpid']['voting_sheet_id'];
$ScriptId = @$Config['packages']['community']['phpid']['script_id'];
$SheetName = @$Config['packages']['community']['phpid']['sheet_name'];

$GS = new GoogleScript;
$GS->DocId = $DocId;
$GS->ScriptId = $ScriptId;
$GS->SheetName = $SheetName;

$voteDatasheet = $GS->Get();

$votes = [];
$numberOfVote = 0;
foreach ($voteDatasheet as $item) {
  $numberOfVote++;
  $kandidat = $item['Pilih_kandidat_kamu'];
  $score = @$votes[$kandidat]['score'];
  if (empty($score)) $score = 0;
  $score++;
  $votes[$kandidat]['score'] = $score;
}

uasort($votes, function($a, $b) {
  return $b['score'] <=> $a['score'];
});

$Text = "*Perolehan Sementara*";
$Text .= "\nPemilihan Ketua PHPID";
$Text .= "\n";
$index = 1;
foreach ($votes as $key => $value) {
  $Text .= "\n$index. $key ($value[score])";
  $index++;
}
$Text .= "\n";
$Text .= "\nTerkumpul dari $numberOfVote suara.";

Output(0, $Text);


