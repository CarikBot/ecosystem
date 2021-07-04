<?php
/** #2
 * Number of Item to be ordered
 * 
 * USAGE
 *   curl http://localhost:8000/amount.php -d "productId=1"
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
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../../config.php";
include_once "../../../lib/lib.php";
include_once "./config.php";

$requestContent = getRequestBodyAsArray();
$requestData = @$RequestContentAsJson['data'];

$ProductId = @$requestData['productId'];
if (empty($ProductId)) Output(0, 'Maaf, pemesanan gagal. Parameter tidak lengkap.');
$product = $LocalConfig['packages']['commerce'][$commerceCategory][$commerceName]['products'][$ProductId-1];
$productName = trim(RemoveEmoji($product['name']));

$Text = "Kamu memesan *'$productName'*";
$Text .= "\nHarga: Rp. " . number_format($product['price'], 0,',','.');
$Text .= "\nMau pesen berapa?";


$buttons = [];
for ($i=1; $i <= 5; $i++) {
  $buttons[] = AddButton( $i, "text=$commerceCode $ProductId $i");
}
$buttonList[] = $buttons;
$buttons = [];
for ($i=6; $i <= 10; $i++) {
  $buttons[] = AddButton( $i, "text=$commerceCode $ProductId $i");
}
$buttonList[] = $buttons;
$buttons = [];
$buttons[] = AddButton( '✖️ Batal', 'text=batal');
//$buttons[] = AddButton( '🛒 Pilih yang lain', 'text=pesan tahu');
$buttonList[] = $buttons;

//die($Text);
Output( 0, $Text, 'text', $buttonList, 'button', '', @$product['image'], 'Tampilkan', false);

