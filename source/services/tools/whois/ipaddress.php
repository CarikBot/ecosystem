<?php
/**
 * IP ADDRESS WHOIS
 *
 * USAGE:
 *   curl "http://ecosystem.carik.test/services/tools/whois/ipaddress/" -d "{....}"
 *
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_NONE);
require_once "../../lib/lib.php";

$IPAddress = @trim(@$_POST['ip_address']);
if (empty($IPAddress)) RichOutput(0, 'Parameter tidak lengkap.');
if (IsIPAddress($IPAddress) == false) RichOutput(0, 'Parameter tidak dikenalai sebagai IP Address');
$Output = "IP Address: $IPAddress";

$url = "https://ipwho.is/" . $IPAddress;
$result = @file_get_contents($url);
if (empty($result)) RichOutput(0, "Maaf, informasi IP address $IPAddress tidak bisa saya temukan.");
$ipInfo = json_decode($result, true);
if (@$ipInfo['success'] == false) RichOutput(0, "Maaf, informasi IP address $IPAddress tidak bisa saya temukan.");

$Output = "*Informasi IP $IPAddress*";
$Output .= "\nLokasi: $ipInfo[city], $ipInfo[region], $ipInfo[country]";
$Output .= "\nLatlon: $ipInfo[latitude],$ipInfo[longitude]";
if (isset($ipInfo['connection'])){
  $connectionFrom = $ipInfo['connection']['org'];
  $Output .= "\nConnection from: $connectionFrom";
}

//die($Output);
RichOutput(0, $Output);
