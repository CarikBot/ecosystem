<?php
/**
 * PERSONALITY TEST
 *   MBTI
 *   DISC
 * 
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set("allow_url_fopen", 1);
require_once "../../lib/lib.php";

$Text = "*Personality Test*";
$Text .= "\n\nTes kepribadian adalah metode untuk menilai konstruksi kepribadian manusia. Kebanyakan instrumen penilaian kepribadian sebenarnya adalah langkah-langkah kuesioner laporan diri introspektif atau laporan dari catatan kehidupan seperti skala penilaian.";
$Text .= "\nMBTI dan DISC adalah dua instrumen psikometrik yang memungkinkan prediksi dan evaluasi seseorang. Kedua tes ini digunakan di banyak organisasi dan institusi di seluruh dunia, dan bisa digunakan sebagai alat untuk memahami diri kita lebih dalam.";
//$Text .= " DISC adalah instrumen yang mengukur perilaku dan proses perilaku seseorang.";
$Text .= "\n\n*Jika kamu ingin mengetahui skor kepribadianmu, coba ikuti test ini*.";
//$Text .= "\nSaat ini Carik baru menyediakan 2 test, yaitu MBTI dan DISC Test.";
$Text .= "\nTidak ada jawaban yang benar atau salah dalam test ini.";
$Text .= " Cukup luangkan waktu dan cari tempat yang kondusif agar kamu lebih fokus.";
$Text .= " Hasil tes bisa kamu dapatkan setelah mengisi semua pertanyaan dengan lengkap.";
$Text .= "\n";

if (isGroupChat()){
  $Text .= "\nTest ini hanya boleh dilakukan chat langsung ke Carik.";
  if ('telegram'==@$_POST['ChannelId']) {
    $buttons[] = AddButtonURL("🎖 Ikut Test", "https://t.me/CarikBot?start=personality_test");
    $buttonList[] = $buttons;
    Output( 0, $Text, 'text', $buttonList, 'button', '', '', 'Tampilkan', true);
  }
  if ('whatsapp'==@$_POST['ChannelId']) $Text .= "\n[Whatsapp](wa.me/6287887100878?text=personality+test)";
  Output(0, $Text);
}
$buttons = [];
$buttons[] = AddButton( '🎖 MBTI Test', 'text=mbti test');
$buttons[] = AddButton( '🏅 DISC Test', 'text=disc test');
$buttonList[] = $buttons;

//die($Text);
Output( 0, $Text, 'text', $buttonList, 'button', '', '', 'Tampilkan', false);
