<?php
/**
 * Contoh handler sederhana untuk Carik oTTo
 * 
 * @date       20-05-2021 03:40
 * @category   AksiIDE
 * @package    oTTo Handler
 * @subpackage 
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */

 ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

$Body = file_get_contents('php://input');
if (empty($Body)) SendResponse(['Parameter tidak sesuai.']);
$bodyAsJson = json_decode($Body, true);
if (count($bodyAsJson)==0) SendResponse(['Parameter tidak sesuai.']);

$fromId = $bodyAsJson['message']['from']['id'];
$fromName = $bodyAsJson['message']['from']['name'];
$message = $bodyAsJson['message']['text'];

$replyAsArray[] = processMessage($message, $fromId, $fromName);
SendResponse($replyAsArray);

function processMessage($AMessage, $AFromId, $AFromName){
  $result = "";
  if (preg_match('(ping|pung)', $AMessage)) return "pong ".$AFromName;
  if (preg_match('(halo|hai|pagi|siang|malam)', $AMessage)) return "Halo juga.";
  if (preg_match('(promo)', $AMessage)) {
    $result .= "Promo Lebaran:";
    $result .= "\nDiscount 40% untuk semua pembelian di Toko Kami, untuk minimal pembelian Rp. 100.000.";
    return $result;
  }
  
  
  // Your code here



  return $result;
}

function SendResponse( $AMessage, $ACode=0){
  @header("Content-type:application/json");
  $array['code'] = $ACode;
  $array['response']['text'] = $AMessage;
  $output = json_encode($array, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
  die($output);
}


