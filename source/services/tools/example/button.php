<?php
/**
 * Button Example
 * 
 * @date       28-04-2022 12:23
 * @category   example
 * @package    button example
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

$Text = "*Button Example*";
$Text .= "\nIni adalah contoh pembuatan tombol di platform [Carik Chatbot Ecosystem](https://github.com/CarikBot/ecosystem/).";
$Text .= "\nInformasi tentang API dan struktur/format outputnya telah disediakan di [Dokumentasi API](https://github.com/CarikBot/ecosystem/blob/development/docs/api-structure.md)";

$buttons = [];
$buttons[] = AddButton("Jadwal Sholat", "text=jadwal sholat");
$buttons[] = AddButton("Test Edit", "mode=edit&text=test");
$buttons[] = AddButton("Update Covid", "text=update covid");
$buttonList[] = $buttons;

$buttons = [];
$buttons[] = AddButtonURL("🏡 Situs Official", "https://carik.id", "tall");
$buttons[] = AddButton("🥇 Donasi", "text=saya mau donasi");
$buttonList[] = $buttons;

Output( 0, $Text, 'text', $buttonList, 'button', '', 'https://carik.id/images/banner.jpg');
