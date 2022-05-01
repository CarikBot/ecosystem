<?php
/**
 * Gregorian to Hijriah Converter
 * 
 * @date       29-04-2022 17:14
 * @category   example
 * @package    hijriah converter
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
require_once "../../lib/date_lib.php";

$hijri = HijriCalendar::GregorianToHijri(time());
$Text = $hijri[1] . ' ' . HijriCalendar::monthName($hijri[0]) . ' ' . $hijri[2] . ' H';

Output(0, $Text);
