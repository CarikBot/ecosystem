<?php
/**
 * Daftar Peserta INL
 *
 * USAGE:
 *   curl "http://ecosystem.carik.test/services/partner/ihasa/inl3-participant/"
 *
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_NONE);
require_once "../../lib/lib.php";
require_once "../../config.php";
EnableCORS();

$url = $Config['packages']['partner']['ihasa']['inl3']['participant'];

$participants = @file_get_contents($url);
if (empty($participants)) RichOutput(404, "Maaf, informasi daftar peserta INL 2024 belum bisa saya peroleh. Coba lagi nanti yaa");
$participants = json_decode($participants, true);

$data['senior'] = @$participants['Senior (Above 16 YO)'];
$data['junior'] = @$participants['Junior (Under 16 YO)'];
OutputData(0, $data);
