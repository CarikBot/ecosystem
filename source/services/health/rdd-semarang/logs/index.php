<?php
/**
 * Carik PUBLIC API
 *
 * @date       01-07-2022 11.29
 * @category   Tools
 * @package    router tools
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../lib/lib.php";

//$BaseURL = @$Config['packages']['health']['Covid19']['vaksin_info_url'];

Output(0, OK);
