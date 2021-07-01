<?php
/**
* File: config.php
* Configuration File
*
* @date       01-07-2021 14:40
* @category   LumpiaQueen
* @package    AksiIDE
* @subpackage
* @copyright  Copyright (c) 2013-endless AksiIDE
* @license
* @version
* @link       http://www.aksiide.com
* @since
*/

date_default_timezone_set('Asia/Jakarta');
$commerceCode = 'plqn';
$commerceName = 'lumpiaqueen';
$commerceCategory = 'food';
$LocalConfig = [
  "packages" => [
    "commerce" => [
      "food" => [
        "lumpiaqueen" => [
          "client_id" => 229,
          "address" => "Semarang",
          "description" => "*Mau pesan LumpiaQueen?*\nLUMPIA QUEEN SEMARANG\n🍴 Oleh-oleh Khas Semarang\n🍴 Halal MUI, Non MSG dan Pengawet[.](https://carik.id/files/commerce/lumpiaqueen/logo.png)",
          "products" => [
            [
              "name" => "🥰 Lumpia Rebung",
              "price" => 45000
            ]
          ]
        ]  
      ]
    ]
  ]
];
