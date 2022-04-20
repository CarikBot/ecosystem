<?php
/**
 * [x] USAGE
 *   $options['url'] = 'http://_______';
 *   $options['token'] = 'the_token';
 *   $options['dashboard'] = 1; //1: direct to dashboard
 *   if (SendMessage(201, '5-6281......','test wow keren sekali', $options)){
 *     ...
 *   }
 * 
 * @date       30-01-2021 22:55
 * @category   AksiIDE
 * @package    Messaging Library
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */

function SendMessage($AClientId, $ATo, $AMessage, $AOptions = []){
  if (($AClientId==0) || (empty($AClientId)) || (empty($ATo) || empty($AMessage))) return false;
  if ((empty($AOptions['url']) || (empty($AOptions['token'])))) return false;
  $to = explode('-', $ATo);
  if (empty($to[1])) $to[1] = '-'.@$to[2];
  if (count($to) < 2) return false;
  $platform = '';
  if ($to[0] == 'tl') $platform = 'telegram';
  if ($to[0] == 'tg') $platform = 'telegram';
  if ($to[0] == '5') $platform = 'whatsapp';
  if ($to[0] == 'wa') $platform = 'whatsapp';
  if ($to[0] == 'fb') $platform = 'facebook';

  $payload['clientId'] = $AClientId;
  $payload['to'] = $to[1];
  $payload['name'] = $to[1];
  $payload['message'] = $AMessage;
  //print_r($payload);die;
  $payloadAsJson = json_encode($payload, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);

  $opts = [
    "http" => [
        "method" => "POST",
        'header'=> "Content-Type: application/json\r\n"
          . "Content-Length: " . strlen($payloadAsJson) . "\r\n"
          . "Token: ".$AOptions['token']."\r\n",
        'content' => $payloadAsJson
    ]
  ];
  $context = stream_context_create($opts);
  $url = $AOptions['url'] . "messaging/$platform/sendmessage/";
  $result = file_get_contents($url, false, $context);
  if (empty($result)) return false;
  $responseAsJson = @json_decode($result, true);
  if (count($responseAsJson)==0) return false;
  if (@$responseAsJson['code']!=0) return false; 

  return true;
}