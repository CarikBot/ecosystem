<?php
/**
 * Pembelian Pulsa/Data/Voucher/Token
 * 
 * USAGE:
 *   curl "http://localhost:8001/komunitas-jabodetabek.php" -d "@payload\payload-form-komunitas.json"
 *   
 * 
 * @date       17-06-2021 02:41
 * @category   Main
 * @package    PPOB
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

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set("allow_url_fopen", 1);
//error_reporting(E_NONE);

require_once "../../config.php";
require_once "../../lib/lib.php";
require_once "../../lib/GoogleForm_lib.php";
require_once "../../lib/messaging_lib.php";

const ENDPOINT = '/services/community/fp2sti/komunitas-jabodetabek/';
const FORM_ID_COMMUNITY_NAME = 'entry.446097535';
const FORM_ID_NAME = 'entry.1099540073';
const FORM_ID_PHONE = 'entry.1660110551';
const FORM_ID_ADDRESS = 'entry.1067171785';
const FORM_ID_NOTES = 'entry.1036773146';

$FullName = @$RequestContentAsJson['data']['full_name'];

if ('CANCEL' == @$RequestContentAsJson['data']['submit']){
  Output(0, "Isian form pendataan komunitas silat telah dibatalkan.\nTerima kasih.");
}


if (('OK' != @$RequestContentAsJson['data']['submit'])and(empty($CustomerId))){
  $section01[] = AddQuestion('string', 'community_name', 'Tulis nama komunitas/perkumpulan silat anda');
  $section01[] = AddQuestion('string', 'name', 'Nama ketua/kontak yang bisa dihubungi');
  $section01[] = AddQuestion('string', 'phone', 'Tulis nomor handphone ketua di atas\nMisal: 08123456789');
  $section01[] = AddQuestion('string', 'address', 'Alamat komunitas');
  $section01[] = AddQuestion('string', 'notes', 'Catatan lain-lain\nTulis *-* jika tidak ada.');
  $questionData[] = $section01;

  $Text = "Hi $FullName.";
  $Text .= "\nMohon isikan data komunitas/perkumpulan silat Anda.";
  $Text .= "\n";
  
  $url = GetBaseUrl() . ENDPOINT;
  OutputQuestion( $Text, $questionData, $url);
}

$Data = @$RequestContentAsJson['data'];
$UserId = @$Data['user_id'];
$CommunityName = strtoupper($Data['community_name']);
$Name = strtoupper($Data['name']);
$Phone = $Data['phone'];
$Address = $Data['address'];
$Notes = $Data['notes'];
$Phone = str_replace('-', '', $Phone);
$Phone = str_replace(' ', '', $Phone);

// Submit to system
$GFA = new GoogleFormAutomation;
$GFA->FormId = $Config['packages']['community']['fp2sti']['community_form_id'];
$postData = [
  FORM_ID_COMMUNITY_NAME => $CommunityName,
  FORM_ID_NAME => $Name,
  FORM_ID_PHONE => $Phone,
  FORM_ID_ADDRESS => $Address,
  FORM_ID_NOTES => $Notes
];
if (!$GFA->Submit($postData)){
  Output(400, 'Maaf. Terjadi kegagalan dalam penyimpanan data.');
};

// Send Notification
$userLink = '';
$userInfo = explode('-', $UserId);
if ($userInfo[0]==5) $userLink = "(wa.me/".$userInfo[1].')';

$Text = "*Form Notification*";
$Text .= "\nAda data komunitas silat masuk dari $FullName $userLink.";
$Text .= "\n";
$Text .= "\n".$CommunityName;
$Text .= "\n".$Name;
$Text .= "\n".$Phone;
$options['url'] = $Config['packages']['community']['fp2sti']['dashboard_url'];
$options['token'] = $Config['packages']['community']['fp2sti']['dashboard_token'];
$options['dashboard'] = 1;
$recipients = $Config['packages']['community']['fp2sti']['recipient'];
foreach ($recipients as $recipient) {
  SendMessage(201, $recipient, $Text, $options); 
}


// Thankyou
$Text = "Informasi telah kami catat.\nTerima kasih.\nSalam Silat\n\nFP2STI - SilatIndonesia.com";
Output( 0, $Text);

