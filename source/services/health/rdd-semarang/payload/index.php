<?php
/**
 * Feedback Handler
 * 
 * USAGE:
 *   curl "http://api.carik.test/feedback/"
 *
 * @date       30-01-2023 11.25
 * @category   Feedback
 * @package    Default Feedback Handler
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
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include_once "../config.php";
include_once "../lib/lib.php";


Output(0, OK);
