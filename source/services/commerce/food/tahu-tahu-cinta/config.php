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
$commerceCode = 'ptth';
$commerceName = 'tahu_tahu_cinta';
$commerceCategory = 'food';
$LocalConfig = [
  "packages" => [
    "commerce" => [
      "food" => [
        "tahu_tahu_cinta" => [
          "client_id" => 229,
          "address" => "Tahu Tahu Cinta, Pondok Kacang, Tangerang.",
          "description" => "*Mau pesan Tahu Tahu Cinta?*\nSilakan pilih, ada Cinta Tulus, Cinta Monyet, Cinta Gila juga Cinta Buta.\nPaduan rasanya akan semakin membarakan cinta si dia[.](https://carik.id/files/commerce/tahu-tahu-cinta/logo.jpg)",
          "products" => [
            [
              "name" => "💛 Cinta Tulus",
              "price" => 16000
            ],
            [
              "name" => "🙊 Cinta Monyet",
              "price" => 30000
            ],
            [
              "name" => "🤪 Cinta Gila",
              "price" => 24000
            ],
            [
              "name" => "😎 Cinta Buta",
              "price" => 45000
            ],
            [
              "name" => "🤨 Cinta Palsu (Test)",
              "price" => 1500
            ]
          ]
        ]  
      ]
    ]
  ]
];
