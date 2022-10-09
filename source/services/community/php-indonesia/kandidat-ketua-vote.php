<?php
/**
 * Voting Ketua PHPID
 * 
 * USAGE:
 *   curl "http://localhost:8001/kandidat-ketua-vote.php" -d "{}"
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
require_once "../../lib/GoogleForm_lib.php";
require_once "../../lib/messaging_lib.php";
require_once "../../config.php";
date_default_timezone_set('Asia/Jakarta');

const KANDIDAT = ['', 'Nur Hidayat', 'Mizno Kruge', 'Luri Darmawan'];

const FORM_ID_FULLNAME = 'entry.1367380316';
const FORM_ID_PHONE = 'entry.1756747829';
const FORM_ID_CHOOSE = 'entry.108523294';
const VOTER_FILE = 'data/voter.json';
const RULE_FILE = 'voting-rule.txt';

$rule = readTextFile(RULE_FILE);

$UserId = @$RequestContentAsJson['data']['user_id'];
$FullName = @$RequestContentAsJson['data']['FullName'];
$Pilihan = @$RequestContentAsJson['data']['Pilihan'];
$UserId = str_replace('5-', '', $UserId);
$pilihan = @KANDIDAT[$Pilihan];

//TODO: Limit hanya 1x vote
$voterData = readTextFile(VOTER_FILE);
if (empty($voterData)) $voterData = '{}';
$voterDataAsJson = json_decode($voterData, true);
$isVote = @$voterDataAsJson[$UserId];
if (1 == $isVote){
  $Text = "Maaf, kamu sudah memilih. Pemilihan hanya boleh dilakukan 1 kali saja.\nTerima kasih.";
  $Text .= "\n";
  $Text .= "\n*Rule:*";
  $Text .= "\n".$rule;
  Output(0, $Text);
}
$voterDataAsJson[$UserId] = 1;

// Submit to system
$GFA = new GoogleFormAutomation;
$GFA->FormId = @$Config['packages']['community']['phpid']['voting_form_id'];
$postData = [
  FORM_ID_FULLNAME => $FullName,
  FORM_ID_PHONE => $UserId,
  FORM_ID_CHOOSE => $pilihan
];
if (!$GFA->Submit($postData)){
  Output(400, 'Maaf. Terjadi kegagalan dalam penyimpanan data.');
};

$voterData = json_encode($voterDataAsJson, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
writeTextFile(VOTER_FILE, $voterData);

$Text = "Hi Kak $FullName,";
$Text .= "\nKakak memilih: $pilihan";
$Text .= "\nTerima kasih atas partisipasinya yaa";
$Text .= "\n";
$Text .= "\n*Rule:*";
$Text .= "\n".$rule;

Output(0, $Text);
