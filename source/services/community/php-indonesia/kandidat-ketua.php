<?php
/**
 * Voting Ketua PHPID
 * 
 * USAGE:
 *   curl "http://localhost:8001/feedback.php" -d "@body-feedback.json"
 *   curl "http://ecosystem.carik.test/services/community/php-indonesia/kandidat-ketua/"  -d "{}"
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

const RULE_FILE = 'voting-rule.txt';

$UserId = @$RequestContentAsJson['data']['user_id'];
$FullName = @$RequestContentAsJson['data']['FullName'];

$rule = readTextFile(RULE_FILE);

$Text = "*Voting Pemilihan Ketua PHPID*";
$Text .= "\nAmbil napas yang dalam, tenangkan pikiran, bersihkan hati lalu tentukan pilihanmu";
$Text .= "\n";
$Text .= "\n*Rule:*";
$Text .= "\n".$rule;

$button = [];
$button[] = AddButton("Nur Hidayat", "text=ketuaphpid 1");
$button[] = AddButton("Mizno Kruge", "text=ketuaphpid 2");
$button[] = AddButton("Luri Darmawan", "text=ketuaphpid 3");
$buttonList[] = $button;

$actions['button'] = $buttonList;
RichOutput(0, $Text, $actions);
