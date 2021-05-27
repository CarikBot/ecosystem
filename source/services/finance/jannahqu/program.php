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

const JANNAHQU_API_BASEURL = "https://jannahqu.id/api/";
const JANNAHQU_PROGRAM_BASEURL = "https://jannahqu.id/program/";
const JANNAHQU_PROGRAM_COUNT = 5;


$programs = @file_get_contents(JANNAHQU_API_BASEURL . "programs?start=0&length=" . JANNAHQU_PROGRAM_COUNT);
$programs = json_decode($programs, true);
if (@$programs["status"]!="OK"){
  Output(200, "Maaf, informasi tidak bisa diakses.");
}

$Text = "*Informasi donasi sahabat saat ini:*\n";
foreach ($programs["values"] as $program) {
  $Text .= "\n*".$program["name"]."*";
  $Text .= "\n".$program["organizer"];
  $Text .= "\nkategori: ".$program["category"];
  $Text .= "\n".JANNAHQU_PROGRAM_BASEURL.$program["slug"];
  $Text .= "\n";
}
$Text .= "\n[Info Donasi selengkapnya](https://jannahqu.id/program)";

//die($Text);
Output(200, $Text);
