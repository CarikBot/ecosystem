<?php
/**
 * Request Donor Darah
 *
 * USAGE:
 *   curl "http://ecosystem.carik.test/services/health/rdd-semarang/request-donor/"
 *   curl "http://ecosystem.carik.test/services/health/rdd-semarang/request-donor/" -d "@payload/request-donor.json"
 *
 *
 * @date       20-11-2023 04:51
 * @category   Health
 * @package    RDD Semarang
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version    1.0.0
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

$GolonganDarah = [ "O-", "O+", "A-", "A+", "B-", "B+", "AB-", "AB+"];
$JenisDonor = ['Biasa', "Apheresis"];

if (CANCEL == @$RequestContentAsJson['data']['submit']){
  Output(0, "Request Donor telah dibatalkan.\nTerima kasih");
}

if (OK != @$RequestContentAsJson['data']['submit']){
  $text = "*Permintaan Donor Darah Pengganti*";
  $text .= "\nSilakan isi form berikut sesuai dengan kebutuhan.";
  $generalQuestion[] = AddQuestion('option', 'blood', "Golongan Darah", ["options" => $GolonganDarah]);
  $generalQuestion[] = AddQuestion('string', 'component', "Komponen darah yang diperlukan:\n_Tulis - jika tidak tahu._");
  $generalQuestion[] = AddQuestion('option', 'donor_type', "Jenis Donor", ["options" => $JenisDonor]);
  $generalQuestion[] = AddQuestion('numeric', 'amount', "Jumlah kantong darah");
  $generalQuestion[] = AddQuestion('string', 'patient_name', "Nama Pasien");
  $generalQuestion[] = AddQuestion('string', 'family_phone', "Nomor HP keluarga yang bisa dihubungi");
  $generalQuestion[] = AddQuestion('string', 'hospital', "Rumah Sakit (Kota)");
  $generalQuestion[] = AddQuestion('string', 'donor_place', "Calon pendonor harus hadir ke");
  $generalQuestion[] = AddQuestion('string', 'note', "Keterangan lain");
  $generalQuestion[] = AddQuestion('date', 'date', "Dibutuhkan pada tanggal berapa");
  $generalQuestion[] = AddQuestion('boolean', 'confirm', "Apakah isian form sudah benar? (Y/T)\n_jika tidak, anda bisa mengisi ulang lagi_");

  $questionData[] = $generalQuestion;
  $url = GetCurrentURL();
  OutputQuestion( $text, $questionData, $url, 'RequestDonor');
}

$Data = $RequestContentAsJson['data'];
$confirm = (@$Data['confirm'] == 'Y') ? true : false;

if (!$confirm){
  $text = "Maaf, anda bisa mengisi ulang form permintaan donor darah pengganti.\nTerima kasih.";
  RichOutput(0, $text);
}

AddToLog($RequestContent);

$text = "*Notifikasi Permintaan Donor Darah Pengganti*";
$text .= "\n";
$text .= "\n\nYth Bp/Ibu $Data[full_name], informasi permintaan donor darah pengganti untuk $Data[patient_name] telah kami teruskan ke CS yang bertugas.";
$text .= "\n";
$text .= "\nMohon ditunggu\nTerima kasih.";

RichOutput(0, $text);
die($text);
