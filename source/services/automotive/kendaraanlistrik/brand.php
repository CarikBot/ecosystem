<?php
/**
 * USAGE
 *   curl "http://localhost/services/ecosystem/automotive/kendaraanlistrik/merk/"
 *   curl "{ecosystem_baseurl}/services/automotive/kendaraanlistrik/merk/"
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
date_default_timezone_set('Asia/Jakarta');

$Text = "Informasi tentang produk-produk kendaraan listrik bisa Anda jumpai dari [tautan](https://kendaraanlistrik.net/Produk.html?carikbot) ini.";
Output(0, $Text);
