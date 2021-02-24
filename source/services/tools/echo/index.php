<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../config.php";
include_once "../../lib/lib.php";

$Token = $Config['packages']['tools']['echo']['token'];

$FullName = urldecode(@$_POST['FullName']);
$OriginalText = urldecode(@$_POST['Keyword']);
$OriginalText = trim(str_replace('echo ', '', $OriginalText));
$imgUrl = 'https://raw.githubusercontent.com/CarikBot/ecosystem/development/source/services/tools/echo/echo-menu.png';

$Text = "*Contoh Integrasi Sistem Anda*

Ini adalah *Contoh API Echo* jika anda akan menghubungkan API Anda kepada Ecosytem.[.]($imgUrl)
Contoh desain Mind Flow dan kode API juga sudah disertakan di dalam [repositori](https://github.com/CarikBot/ecosystem/).

Silakan coba kirim pesan:
`echo kalimat yang mau diecho`
";

if (!empty($OriginalText)){
  $Text = "Hi $FullName";
  $Text .= "\nAnda menuliskan: '$OriginalText'";
}

Output(200, $Text);
