<?php
/**
* File: config.php
* Configuration File
*
* @date       20-09-2017 22:33
* @category   AksiIDE
* @package    AksiIDE
* @subpackage
* @copyright  Copyright (c) 2013-endless AksiIDE
* @license
* @version
* @link       http://www.aksiide.com
* @since
*/

date_default_timezone_set('Asia/Jakarta');
$UserID = urldecode(@$_POST['UserID']);
$ChatID = urldecode(@$_POST['ChatID']);
$ChannelId = urldecode(@$_POST['ChannelId']);
$FullName = urldecode(@$_POST['FullName']);
$OriginalText = urldecode(@$_POST['OriginalText']);
$CurrentURL = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$Config = [
  "packages" => [
    "main" => [
      "CarikBot" => [
        "token" => "your_token"
      ]
    ],
    "tools" => [
      "echo" => [
        "token" => "your_token"
      ]
    ]
  ]
];

require_once "lib/ErrorTrapper_lib.php";
