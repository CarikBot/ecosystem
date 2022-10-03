<?php
/**
 * Button Example
 * 
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

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set("Asia/Jakarta");
require_once "../../lib/lib.php";

$Text = "*Button URL Example*";
$Text .= "\nIni adalah contoh pembuatan tombol yang berisi tautan.";

$buttons = [];
$buttons[] = AddButtonURL("Bayar", "https://carik.id");
$buttonList[] = $buttons;

$actions['button'] = $buttonList;
RichOutput(0, $Text, $actions);
