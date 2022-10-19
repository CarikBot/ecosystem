<?php
/**
 * Feedback Form
 * 
 * USAGE:
 *   curl "http://localhost:8001/feedback.php" -d "@body-feedback.json"
 *   curl "http://ecosystem.carik.test/services/main/CarikBot/feedback/"  -d "@body-feedback.json"
 *   
 *
 * @date       12-05-2022 23:52
 * @category   Main
 * @package    fedback form
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
require_once "../../lib/CarikAPI_lib.php";
require_once "../../config.php";
date_default_timezone_set('Asia/Jakarta');

const FORM_ID_FULLNAME = 'entry.260424763';
const FORM_ID_USERID = 'entry.363100674';
const FORM_ID_MODUL = 'entry.1946344226';
const FORM_ID_RATING = 'entry.891463682';
const FORM_ID_INTERACTION = 'entry.1812881260';
const FORM_ID_RECOMENDATION = 'entry.865760117';
const FORM_ID_NOTES = 'entry.922043659';
const FORM_ID_LOG = 'entry.1341416625';

$ClientId = @$RequestContentAsJson['client_id'];
$UserId = @$RequestContentAsJson['data']['user_id'];
$FullName = @$RequestContentAsJson['data']['FullName'];
if (empty($ClientId)) $ClientId = @$RequestContentAsJson['data']['client_id'];

if ('CANCEL' == @$RequestContentAsJson['data']['submit']){
  Output(0, "Pengisian form feedback telah dibatalkan.\nTerima kasih.");
}
if ('OK' != @$RequestContentAsJson['data']['submit']){
  // Build your question here
  $Text = "*Feedback Form*";
  $Text .= "\n";
  $Text .= "\nHi Kak $FullName yang tersayang.";
  $Text .= "\nTerima kasih menjadi teman setia Carik.";
  $Text .= "\nUntuk meningkatkan mutu layanan Carik, kami mohon bantuan untuk menjawab sedikit survei singkat ini. Masukan dari Anda akan sangat membantu dalam pengembangan Carik Bot Assistant kesayangan ini.";
  $Text .= "\nMohon bantuannya yaa 🙏🏼";
  $Text .= "\n";

  // general question
  $generalQuestion[] = AddQuestion('option', 'rating', "Menurut Anda, seberapa suka Anda dengan layanan Carik", ["options"=>['Suka Banget', 'Suka', 'Tidak Suka', 'Sangat tidak suka']]);
  $generalQuestion[] = AddQuestion('list', 'interaction', "Secara keseluruhan, seberapa mudah interaksi Anda melalui layanan chatbot Carik ini", ["options"=>['Wow, mudah banget', 'Cukup mudah', 'Sulit', 'Sangat sulit']]);
  $generalQuestion[] = AddQuestion('list', 'recommendation', "Seberapa mungkin, Anda ingin merekomendasikan Carik kepada keluarga, kerabat atau rekanan?\n1. Sangat tidak mungkin, 10: Sangat mungkin.", ["options"=>['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']]);
  $generalQuestion[] = AddQuestion('string', 'notes', "Ceritain dong tentang pengalaman menggunakan Carik. Atau boleh juga kritik dan saran Anda untuk Carik.\nMisal, layanan yang paling kamu suka, layanan yang perlu diadakan, apa yang perlu dikembangkan, dsb");

  $questionData[] = $generalQuestion;

  $url = GetBaseUrl() . '/services/main/CarikBot/feedback/';
  OutputQuestion( $Text, $questionData, $url, 'Feedback Form');
}

// Processing Data
$Data = $RequestContentAsJson['data'];
$FullName = strtoupper($FullName);
$Rating = strtoupper(@$Data['rating_t']);
$Interaction = strtoupper(@$Data['interaction_t']);
$Recomendation = strtoupper(@$Data['recommendation_t']);
$Notes = @$Data['notes'];

// Submit to system
$GFA = new GoogleFormAutomation;
$GFA->FormId = $Config['packages']['partner']['kioss']['feedback_form_id'];
$postData = [
  FORM_ID_FULLNAME => $FullName,
  FORM_ID_USERID => $UserId,
  FORM_ID_MODUL => '',
  FORM_ID_RATING => $Rating,
  FORM_ID_INTERACTION => $Interaction,
  FORM_ID_RECOMENDATION => $Recomendation,
  FORM_ID_NOTES => $Notes,
  FORM_ID_LOG => json_encode($Data, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE)
];
if (!$GFA->Submit($postData)){
  Output(400, 'Maaf. Terjadi kegagalan dalam penyimpanan data.');
};

// Send Notification
$userLink = '';
$userInfo = explode('-', $UserId);
if ($userInfo[0]==5) $userLink = "(wa.me/".$userInfo[1].')';

$Text = "*Feedback Notification*";
$Text .= "\nAda feedback masuk dari $FullName $userLink.";
$Text .= "\nRating: $Rating";
$Text .= "\nInteraction: $Interaction";
$Text .= "\nRecomendation: $Recomendation";
$Text .= "\nCatatan: $Notes";
$options['url'] = $Config['packages']['partner']['kioss']['dashboard_url'];
$options['token'] = $Config['packages']['partner']['kioss']['dashboard_token'];
$options['dashboard'] = 1;
//SendMessage(201, $Config['packages']['partner']['kioss']['recipient'], $Text, $options);

// Add Ticket & Send notification to cs
$API = new Carik\API;
$API->ClientId = $ClientId;
$API->BaseURL = $Config['packages']['partner']['kioss']['api_url'];
$API->Token = $Config['packages']['partner']['kioss']['token'];
$API->DeviceToken = $Config['packages']['partner']['kioss']['device_token'];
$recipient = explode('-', $Config['packages']['partner']['kioss']['recipient'])[1];
$recipientName = $Config['packages']['partner']['kioss']['recipient_name'];

$r = $API->AddTask($UserId, $FullName, '', 'Feedback', 'text', 'feedback');
if ($r !== false){
  $ticketCode = $r['data']['code'];
  $Text .= "\n\nTicket #$ticketCode";
}
$r = $API->SendMessage('whatsapp', $recipientName, $recipient, $Text, []);

// Thankyou
$Text = "Terima kasih yaa atas masukannya.\nCarik jadi makin bersemangat lagi.";
$buttons = [];
$buttons[] = AddButton("🌟 Mau Donasi?", "text=mau donasi");
$buttonList[] = $buttons;
Output( 0, $Text, 'text', $buttonList, 'button', '', 'https://carik.id/images/banner.jpg');
