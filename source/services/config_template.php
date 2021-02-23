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
