<?php
/**
 * USAGE
 *   curl "http://localhost/services/ecosystem/automotive/kendaraanlistrik/event/"
 *   curl "{ecosystem_baseurl}/services/automotive/kendaraanlistrik/event/"
 * 
 * @date       28-04-2021 23:46
 * @category   Automotive
 * @package    Kendaraan Listrik Library
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_NONE);
include_once "../../config.php";
require_once "../../lib/lib.php";
//require_once "../../lib/simplehtmldom_2_0/simple_html_dom.php";
date_default_timezone_set('Asia/Jakarta');

$Text = "Daftar Lengkap Acara Komunitas Kendaraan Listrik bisa anda lihat melalui [tautan](https://kendaraanlistrik.net/Acara.html?carikbot) ini.";
Output(0, $Text);
