<?php
/**
 * Stand Up Comedy Event
 * 
 * USAGE:
 *   curl "http://localhost:8001/phone.php" -d "@body-check.json"
 *   
 *
 * @date       21-09-2022 17.50
 * @category   Community
 * @package    Stand Up Comedy
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

$DocId = '1xkW4kE9owbPa0JHCb7jsvvUi9L00KeqbDXNkIwW-ULE';
$ScriptId = @$Config['packages']['community']['cafestartup']['script_id'];
$SheetName = 'openmic';

$GS = new GoogleScript;
$GS->DocId = $DocId;
$GS->ScriptId = $ScriptId;
$GS->SheetName = $SheetName;
$communityList = $GS->Get();

$Text = "*Jadwal Openmic Standupindo*";
$Text .= "\n";

foreach ($communityList as $item) {
    $venue = $item['tempat'];
    $venue = trim(str_replace('-','', $venue));
    $Text .= "\n*$item[komunitas]*";
    if (!(empty($tempat))) $Text .= "\n$venue";
    $Text .= "\n$item[hari], $item[jam]";
    $Text .= "\n$item[ig]";
    $Text .= "\n";    
}
$Text .= "\n";
$Text .= "\nstandupindo.id";

Output(0, $Text);
