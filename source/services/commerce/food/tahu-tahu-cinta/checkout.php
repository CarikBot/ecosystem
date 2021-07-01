<?php
/** #4 - tidak digunakan
 * 
 * USAGE
 *   curl http://localhost:8000/checkout.php -d "productId=1&amount=2&ProductName=nama+product"
 * 
 * 
 * @date       01-07-2021 01:35
 * @category   Commerce
 * @package    Tahu Tahu Cinta
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include_once "../../../config.php";
include_once "../../../lib/lib.php";
include_once "./config.php";

$ProductId = @$_POST['productId'] + 0;
$Amount = @$_POST['amount'] + 0;
$product = $LocalConfig['packages']['commerce']['food']['tahu_tahu_cinta']['products'][$ProductId-1];
$address = $LocalConfig['packages']['commerce']['food']['tahu_tahu_cinta']['address'];

$price = $product['price'];
$total = $Amount * $price;

$url = "{payment_api}";
$url .= "/Commerce/cart/?cmd=add&checkout=1&gateway=2&number=$Amount&price=$price&random=0&description=" . urlencode($product['name']);

die($url);
$result = curl_get_file_contents($url);
if ($result){
  Output(0, "Maaf, transaksi ke toko Tahu Tahu Cinta tidak berhasil, coba lagi nanti yaa");
}
die($result);
