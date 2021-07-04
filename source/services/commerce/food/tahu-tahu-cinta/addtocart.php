<?php
/** #3
 * Add to Cart
 * 
 * USAGE
 *   curl http://localhost:8000/addtocart.php -d "productId=1&amount=2"
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

$requestContent = getRequestBodyAsArray();
$requestData = @$RequestContentAsJson['data'];

$ProductId = @$requestData['productId'];
$Amount = @$requestData['amount'];
if (empty($ProductId)) Output(0, 'Maaf, pemesanan gagal. Parameter tidak lengkap.');
if (empty($Amount)) Output(0, 'Maaf, pemesanan gagal. Parameter tidak lengkap.');

$product = $LocalConfig['packages']['commerce'][$commerceCategory][$commerceName]['products'][$ProductId-1];
$address = $LocalConfig['packages']['commerce'][$commerceCategory][$commerceName]['address'];
$productName = trim(RemoveEmoji($product['name']));
$price = $product['price'];
$total = $Amount * $price;

$Text = "Kamu memesan *'$product[name]'*";
$Text .= "\nsejumlah *$Amount porsi/paket*";
$Text .= "\nHarga per paket: Rp. " . number_format($price, 0,',','.');
$Text .= "\nTotal belanja: Rp. " . number_format($total, 0,',','.');
$Text .= "\n";
$Text .= "\nPesanan akan disiapkan setelah pembayaran terkonfirmasi.";
$Text .= "\n*Pesanan bisa diambil di:*";
$Text .= "\n$address";
$Text .= "\n\nJaga kesehatan dan Tetap Prokes.";

$buttons = [];
$buttons[] = AddButton( '💶 Ya, pesan', "text=$commerceCode $ProductId $Amount $price $productName");
$buttons[] = AddButton( '✖️ Batal', 'text=batal');
$buttonList[] = $buttons;

//die($Text);
Output( 0, $Text, 'text', $buttonList, 'button', '', @$product['image'], 'Tampilkan', false);

