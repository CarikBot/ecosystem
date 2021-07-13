<?php
/** #1
 * Preview Product List
 * Example with internal configuration. Using API integration is highly recommended
 * 
 * USAGE
 *   curl http://localhost:8000/product.php -d ""
 * 
 * 
 * @date       01-07-2021 01:35
 * @category   Commerce
 * @package    LumpiaQueen
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

// Get Product List
// Example with internal configuration. Using API integration is highly recommended
$products = $LocalConfig['packages']['commerce'][$commerceCategory][$commerceName]['products'];

$Text = "";
$Text .= $LocalConfig['packages']['commerce'][$commerceCategory][$commerceName]['description'];
$Text .= "\nHarga:\n";
$Text .= "```";
foreach ($products as $item) {
  $name = trim(RemoveEmoji($item['name']));
  $price = $item['price'];
  $Text .= "\n- $name: ". number_format($price, 0,',','.');
}
$Text .= "```";

// generate button/menu - automatic
$buttons = [];
$buttonList = [];
foreach ($products as $key => $item) {
  $name = $item['name'];
  $name = preg_replace('/[\(\)\[\]]+/', '-', $name);
  $buttons[] = AddButton( $name, "text=$commerceCode ".($key+1));
  if ($key % 2 != 0){
    $buttonList[] = $buttons;
    $buttons = [];
  }
}
if (count($buttons)>0){
  $buttonList[] = $buttons;
}

// generate button/menu - manual
/*
$buttons = [];
$buttons[] = AddButton( '💛 Cinta Tulus', 'text=ptth 1');
$buttons[] = AddButton( '🙊 Cinta Monyet', 'text=ptth 2');
$buttonList[] = $buttons;
$buttons = [];
$buttons[] = AddButton( '🤪 Cinta Gila', 'text=ptth 3');
$buttons[] = AddButton( '😎 Cinta Buta', 'text=ptth 4');
$buttonList[] = $buttons;
$buttons = [];
$buttons[] = AddButton( '😎 Cinta Palsu', 'text=ptth 5');
$buttonList[] = $buttons;
*/

//die($Text);
Output( 0, $Text, 'text', $buttonList, 'button', '', '', 'Tampilkan', false);

