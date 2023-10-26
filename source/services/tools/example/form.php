<?php
/**
 * Form Example
 * Ini adalah contoh implementasi form di dalam ecosystem Carik.
 *
 * @date       28-04-2022 16:48
 * @category   example
 * @package    form example
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
date_default_timezone_set("Asia/Jakarta");
require_once "../../lib/lib.php";
require_once "../../config.php";

const JENIS_KELAMIN = ['', 'Laki-laki', 'Perempuan'];

$UserId = @$RequestContentAsJson['data']['user_id'];
$FullName = @$RequestContentAsJson['data']['FullName'];
$Date = date("Y-m-d H:i:s");
$DateAsInteger = strtotime($Date);

if ('CANCEL' == @$RequestContentAsJson['data']['submit']){
  Output(0, "Pengisian form telah dibatalkan.\nTerima kasih.");
}

if ('OK' != @$RequestContentAsJson['data']['submit']){
  // Build your question here
  $Text = "*Contoh Form*";
  $Text .= "\nSilakan isi data berikut ini.\nIni adalah contoh pengisian form dengan media chat melalui Carik.";
  $Text .= "\n";

  // general question
  $generalQuestion[] = AddQuestion('string', 'fullName', "Siapa nama Lengkap Anda");
  $generalQuestion[] = AddQuestion('list', 'jenisKelamin', "Jenis Kelamin", ["options"=>['Laki-laki', 'perempuan']]);
  $generalQuestion[] = AddQuestion('string', 'email', "📧 Email Anda");
  $generalQuestion[] = AddQuestion('string', 'phone', "☎️ Nomor telepon/whatsapp\n(contoh: 08123456789)");
  $generalQuestion[] = AddQuestion('numeric', 'age', "Usia Anda");

  // other question
  $generalQuestion[] = AddQuestion('date', 'birthdate', "📅 Tanggal Lahir ");
  $generalQuestion[] = AddQuestion('boolean', 'married', "Apakah anda sudah menikah? (Y/T)");
  $generalQuestion[] = AddQuestion('boolean', 'confirm', "Apakah anda sudah yakin dengan informasi yang Anda sampaikan? (Y/T)");

  $questionData[] = $generalQuestion;

  //$url = GetBaseUrl() . '/services/tools/example/form/';
  $url = GetCurrentURL();
  OutputQuestion( $Text, $questionData, $url, 'Contoh Form');
}

// Processing Data
$Data = $RequestContentAsJson['data'];
$confirm = (@$Data['confirm'] == 'Y') ? true : false;
if (!$confirm){
  $text = "Isian form telah dibatalkan.";
  $buttons = [];
  $buttons[] = AddButton('Menu utama', "text=menu");
  $buttonList[] = $buttons;
  $actions['menu'] = $buttonList;
  $actions['suffix'] = 'Ketik *menu* untuk kembali ke menu utama.';
  RichOutput(0, $text, $actions);
}


$fullName = strtoupper($Data['fullName']);
$jenisKelamin = $Data['jenisKelamin'];
$married = ($Data['married'] == 'Y') ? "Menikah" : "Tidak Menikah";
$phone = $Data['phone'];
$phone = 'wa.me/62'.substr($phone,1);

$Text = "Selamat datang $FullName";
$Text .= "\nBerikut informasi yang telah anda kirimkan:";
$Text .= "\n";
$Text .= "\nNama : ".$fullName;
$Text .= "\nEmail: ".$Data['email'];
$Text .= "\nPhone: ".$phone;
$Text .= "\nLahir: ".$Data['birthdate'];
$Text .= "\nJenis kelamin: ".JENIS_KELAMIN[$jenisKelamin];
$Text .= "\nStatus pernikahan: ".$married;

Output(0, $Text);
