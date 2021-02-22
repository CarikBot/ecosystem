<?php
include_once "../../lib/lib.php";


$FullName = @$_POST['FullName'];
$OriginalText = urldecode(@$_POST['Keyword']);
$OriginalText = trim(str_replace('echo ', '', $OriginalText));


$Text = "*Contoh*

Contoh Mind Flow dan kode API untuk ecosystem sudah disertakan di dalam [repositori](https://github.com/CarikBot/ecosystem/).
Misal kode untuk *echo* ini.
Silakan kirim pesan:
`echo kalimat yang mau diecho`
";

if (!empty($OriginalText)){
  $Text = "Hi $FullName";
  $Text .= "\nAnda menuliskan: '$OriginalText'";
}

Output(200, $Text);
