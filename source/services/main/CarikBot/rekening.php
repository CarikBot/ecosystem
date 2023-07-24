<?php
/**
 * Rekening Carik untuk Donasi
 * 
 * 
 * @date       28-06-2022 01:32
 * @category   main
 * @package    CarikBot
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version    0.0.2
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once "../../config.php";
require_once "../../lib/lib.php";

$Text = "Rekening a.n. Luri Darmawan[.](https://carik.id/files/qris.jpg)";
$Text .= "\nBCA 4620.313.586";
$Text .= "\nMandiri 126.000.711.7509";
$Text .= "\n\nJangan lupa melakukan konfirmasi setelah melakukan transfer dana.";
$Text .= "\n\nPembayaran juga bisa dilakukan melalui QRIS";

$button = [];
$button[] = AddButton("Konfirmasi Pembayaran", "text=konfirmasi pembayaran");
//$button[] = AddButton("🏜 Gempa", "text=info gempa");
$buttonList[] = $button;

$file['caption'] = 'Bayar via QRIS';
$file['type'] = 'image';
$file['url'] = 'https://carik.id/files/qris.jpg';
$files[] = $file;

$actions['button'] = $buttonList;
$actions['files'] = $files;

//die($Text);
RichOutput(0, $Text, $actions);
