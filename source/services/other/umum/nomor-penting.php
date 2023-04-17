<?php
/**
 * Informasi nomor telpon penting/darurat Indonesia
 *
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_NONE);
require_once "../../lib/lib.php";


$Text = "Nomor telepon darurat yg perlu anda ketahui:
- Emergency Call: 112
- Ambulan: 118 atau 119
- Pemadam kebakaran: 113
- Polisi: 110
- SAR/BASARNAS: 115
- Posko bencana alam: 129
- PLN: 123

nomor-nomor lain yang perlu juga dicatat:
- KOMNAS HAM: 021-3925230
- KOMNAS Perempuan: 021-3903963
- KPAI: 021-319015";

$_ = date('YmdHis');
$buttons[] = AddButton("🌋 Info Gempa", "_=$_&action=query&text=info gempa");
$buttons[] = AddButton("🌦 Cuaca", "_=$_&action=query&text=cuaca hari ini");
$buttonList[] = $buttons;

$actions['button'] = $buttonList;
RichOutput(0, $Text, $actions);
