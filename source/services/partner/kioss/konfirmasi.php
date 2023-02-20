<?php
/**
 * Konfirmasi Pembayaran
 * 
 * USAGE:
 *   curl "http://localhost:8001/konfirmasi.php" -d "@body-konfirmasi.json"
 *   
 *
 * @date       20-04-2022 05:02
 * @category   Router
 * @package    router tools
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


const FORM_ID_FULLNAME = 'entry.1951588136';
const FORM_ID_EMAIL = 'entry.430329464';
const FORM_ID_PHONE = 'entry.1405372525';
const FORM_ID_PAYMENT_FOR = 'entry.1434055289';
const FORM_ID_PAYMENT_INVOICE = 'entry.43864263';
const FORM_ID_PAYMENT_BANK = 'entry.1559775497';
const FORM_ID_AMOUNT = 'entry.810623611';
const FORM_ID_DATE_DAY = 'entry.280061076_day';
const FORM_ID_DATE_MONTH = 'entry.280061076_month';
const FORM_ID_DATE_YEAR = 'entry.280061076_year';
const FORM_ID_NOTE = 'entry.1261926768';
const FORM_ID_LOG = 'entry.388930010';

const PAYMENT_FOR = [
  'Deposit Domain/Hosting', 'Pembayaran Invoice', 
  'Pembayaran Domain', 'Pembayaran Hosting',
  'Speech Processing',
  'Pembayaran Jasa', 'Lain-lain'
];
const PAYMENT_BANK = [
  'BCA (4620-313-586)', 'Mandiri (126-000-711-7509)'
];

$ClientId = @$RequestContentAsJson['client_id'];
$UserId = @$RequestContentAsJson['user_id'];
$FullName = @$RequestContentAsJson['full_name'];
if (empty($UserId)) $UserId = @$RequestContentAsJson['data']['user_id'];
if (empty($FullName)) $FullName = @$RequestContentAsJson['data']['FullName'];
$Date = date("Y-m-d H:i:s");
$DateAsInteger = strtotime($Date);

if ('CANCEL' == @$RequestContentAsJson['data']['submit']){
  Output(0, "Konfirmasi telah dibatalkan.\nTerima kasih");
}

if ('OK' != @$RequestContentAsJson['data']['submit']){
  //Build quetions  
  $Text = "*Konfirmasi Pembayaran*";
  $Text .= "\nAnda bisa melakukan konfirmasi pembayaran melalui layanan chat ini.";
  $Text .= "\nMohon lengkapi pertanyaan berikut.";
  $Text .= "\n";

  $generalQuestion[] = AddQuestion('string', 'fullName', "Nama Lengkap");
  $generalQuestion[] = AddQuestion('string', 'email', "📧 Email Anda");
  $generalQuestion[] = AddQuestion('string', 'phone', "☎️ Nomor telepon/whatsapp\n(contoh: 08123456789)");

  $paymentQuestion[] = AddQuestion('list', 'paymentFor', "Untuk pembayaran apa", ["options"=> PAYMENT_FOR]);
  $generalQuestion[] = AddQuestion('string', 'invoiceNo', "Nomor Invoice");
  $paymentQuestion[] = AddQuestion('list', 'paymentBank', "Bank tujuan pembayaran", ["options"=> PAYMENT_BANK]);
  $paymentQuestion[] = AddQuestion('number', 'amount', "Jumlah Pembayaran");
  $paymentQuestion[] = AddQuestion('date', 'date', "📅 Tanggal Pembayaran");
  $paymentQuestion[] = AddQuestion('string', 'note', "Keterangan pembayaran atau informasi lainnya");

  $questionData[] = $generalQuestion;
  $questionData[] = $paymentQuestion;

  $url = GetBaseUrl() . '/services/partner/kioss/konfirmasi/';
  OutputQuestion( $Text, $questionData, $url, 'Konfirmasi Pembayaran');
}

// Processing
$Data = $RequestContentAsJson['data'];
$fullName = strtoupper($Data['fullName']);

// Submit to system
$GFA = new GoogleFormAutomation;
$GFA->FormId = $Config['packages']['partner']['kioss']['form_id'];
$postData = [
  FORM_ID_FULLNAME => $fullName,
  FORM_ID_EMAIL => $Data['email'],
  FORM_ID_PHONE => $Data['phone'],
  FORM_ID_PAYMENT_FOR => $Data['paymentFor_t'],
  FORM_ID_PAYMENT_INVOICE => $Data['invoiceNo'],
  FORM_ID_PAYMENT_BANK => $Data['paymentBank_t'],
  FORM_ID_AMOUNT => $Data['amount'],
  FORM_ID_DATE_YEAR => substr($Data['date'], 6, 4),
  FORM_ID_DATE_MONTH => substr($Data['date'], 3, 2),
  FORM_ID_DATE_DAY => substr($Data['date'], 0, 2),
  FORM_ID_NOTE => $Data['note'],
  FORM_ID_LOG => json_encode($Data, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE)
];
if (!$GFA->Submit($postData)){
  Output(400, 'Gagal dalam penyimpanan data.');
};


// Notifikasi
$phone = $Data['phone'];
$phone = 'wa.me/62'.substr($phone,1);
$Text = "*Konfirmasi Pembayaran*";
$Text .= "\n".$Data['paymentFor_t'];
$Text .= "\nNama : ".$fullName;
$Text .= "\nEmail: ".$Data['email'];
$Text .= "\nPhone: ".$phone;

$Text .= "\nNomor Invoice: ".$Data['invoiceNo'];
$Text .= "\nPembayaran: ".$Data['paymentFor_t'];
$Text .= "\nSejumlah: Rp. ". number_format($Data['amount'], 0,',','.'); 
$Text .= "\nMelalui: ".$Data['paymentBank_t'];
$Text .= "\nTanggal: ".$Data['date'];
$Text .= "\nCatatan:\n ".$Data['note'];

// Add Ticket
$API = new Carik\API;
$API->ClientId = $ClientId;
$API->BaseURL = $Config['packages']['partner']['kioss']['api_url'];
$API->Token = $Config['packages']['partner']['kioss']['token'];
$API->DeviceToken = $Config['packages']['partner']['kioss']['device_token'];
$recipient = explode('-', $Config['packages']['partner']['kioss']['recipient'])[1];
$recipientName = $Config['packages']['partner']['kioss']['recipient_name'];

$ticketCode = '';
$r = $API->AddTask($UserId, $FullName, '', 'Pembayaran', $Text, 'payment');
if ($r !== false){
  $ticketCode = $r['data']['code'];
}
$Text .= "\n\nTicket #$ticketCode";

$options['url'] = $Config['packages']['partner']['kioss']['dashboard_url'];
$options['token'] = $Config['packages']['partner']['kioss']['dashboard_token'];
$options['dashboard'] = 1;
SendMessage(201, $Config['packages']['partner']['kioss']['recipient'], $Text, $options);

$Text = "*Konfirmasi Pembayaran*";
$Text .= "\nKami akan segera melakukan verifikasi dan memproses pembayaraan Anda dalam 1x24 jam.";
$Text .= "\nKesalahan pengisian dalam konfirmasi pembayaran dapat mengakibatkan tertundanya proses aktifasi/perpanjangan domain/hosting pesanan anda";
$Text .= "\n";
$Text .= "\nMohon ditunggu yaa...";
$Text .= "\nTerima kasih";
$Text .= "\n\nTicket #$ticketCode";

//die($Text);
Output(0, $Text);

