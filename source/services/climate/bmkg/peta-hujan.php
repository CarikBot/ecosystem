<?php
/**
 * Peta Hujan BMKG
 * 
 * USAGE
 *   curl http://localhost:8001/peta-hujan.php
 * 
 * 
 * @date       28-06-2022 01:32
 * @category   Climate
 * @package    BMKG
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include_once "../../config.php";
include_once "../../lib/lib.php";

$citraRadarURL = 'https://inderaja.bmkg.go.id/Radar/Indonesia_ReflectivityQCComposite.png?id=80582sdk0nxz11losaghj0u';
$citraRadarURL = 'https://inderaja.bmkg.go.id/Radar/Indonesia_ReflectivityQCComposite.png';

$Text = "*Citra Radar*";
$Text .= "\n";
$Text .= "\n*Reflectivity*";
$Text .= "\nCitra radar cuaca menggambarkan *potensi intensitas curah hujan* yang dideteksi oleh radar cuaca. Pengukuran intensitas curah hujan (presipitasi) oleh radar cuaca berdasarkan seberapa besar pancaran energi radar yang dipantulkan kembali oleh butiran-butiran air di dalam awan dan digambarkan dengan produk Reflectivity yang memiliki besaran satuan dBZ (decibel). Makin besar energi pantul yang diterima radar maka makin besar juga nilai dBZ, dan semakin besar nilai dBZ reflectivity menunjukkan intensitas hujan yang terjadi semakin besar.";
$Text .= "\n\nJangkauan terjauh/maksimum produk Reflectivity dari radar BMKG adalah sekitar 240 km dari lokasi radar.";
$Text .= "\n\nSkala dBZ pada legenda berkisar 5 - 75 yang dinyatakan dengan gradasi warna biru langit hingga ungu muda. Jika gradasi warna semakin ke arah ungu maka semakin tinggi intensitas hujannya. Kisaran intensitas hujan berdasarkan skala warna dBZ dan mm/jam disajikan seperti dalam tabel berikut: Skala dBZ pada legenda berkisar 5 - 75 yang dinyatakan dengan gradasi warna biru langit hingga ungu muda. Jika gradasi warna semakin ke arah ungu maka semakin tinggi intensitas hujannya.";

$file['caption'] = 'Citra Radar';
$file['type'] = 'image';
$file['url'] = $citraRadarURL;
$files[] = $file;

$buttonList = [];
$button = [];
$button[] = AddButton("🌦 Cuaca", "text=info cuaca");
$button[] = AddButton("🏜 Gempa", "text=info gempa");
$buttonList[] = $button;

$actions['button'] = $buttonList;
$actions['files'] = $files;

RichOutput(0, $Text, $actions);
