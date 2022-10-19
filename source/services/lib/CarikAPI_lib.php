<?php
/**
 * Carik API Handler
 * 
 * USAGE
 *   [x] Send Message
 *     $API = new Carik\API;
 *     $API->BaseURL = 'http://your-api-url/endpoint';
 *     $API->DeviceToken = 'your token';
 *     $API->SendMessage('whatsapp', 'Full Name, 'userid', 'text', []);
 * 
 * @date       02-08-2020 12:47
 * @category   API
 * @package    Carik
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version    0.0.2
 * @link       http://www.aksiide.com
 * @since
 */

namespace Carik;

class API
{
  public $BaseURL = '';
  public $Token = '';
  public $DeviceToken = '';
  public $ClientId = '';

  public function __construct(){
  }

  public function __get($property) {
    if (property_exists($this, $property)) return $this->$property;
  }

  public function __set($property, $value) {
    if (property_exists($this, $property)) $this->$property = $value;
    if ($property=='DB') {
      //$this->Cart->DB = $value;
    }
    return $this;
  }

  private function isPermitted(){
    if (empty($this->BaseURL)) return false;
    if (empty($this->Token)) return false;
    return true;
  }

  public function SendMessage($APlatform, $AFullName, $ATo, $AMessage, $AAction = []){
    if (empty($this->BaseURL)) return false;
    if (empty($this->DeviceToken)) return false;
    if ((empty($ATo) || empty($AMessage))) return false;

    $data['platform'] = $APlatform;
    $data['name'] = $AFullName;
    $data['user_id'] = $ATo;
    $data['text'] = $AMessage;
    if (@$AAction['label'] !== '') $data['label'] = @$AAction['label'];

    if (!is_null($AAction)){
      $data['type'] = 'action';
      foreach ($AAction as $key => $content) {
        if ('files' == $key){
          $data['action']['files'] = $content;
        }
        if ('button' == $key){
          $data['action']['type'] = 'button';
          $data['action']['button_title'] = 'Tampilkan';
          //if (!empty($AThumbail)){
          //    $data['action']['imageDefault'] = $AThumbail;
          //}
          $data['action']['data'] = $content;
        };
        if ('list' == $key){
          $data['action']['type'] = 'list';
          $data['action']['data'] = $content;
        };
        if ('menu' == $key){
          $data['action']['type'] = 'menu';
          $data['action']['data'] = $content;
        };

      }
    }

    $payLoad['request'] = $data;
    $payloadAsJson = json_encode($payLoad, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
    $opts = [
      "http" => [
          "method" => "POST",
          'header'=> "Content-Type: application/json\r\n"
            . "Content-Length: " . strlen($payloadAsJson) . "\r\n"
            . "token: ".$this->DeviceToken."\r\n",
          'content' => $payloadAsJson
      ]
    ];
    $context = stream_context_create($opts);
    $url = rtrim($this->BaseURL,'/\\').'/send-message/';
    $result = file_get_contents($url, false, $context);
    if (empty($result)) return false;
    $responseAsJson = @json_decode($result, true);
    return $responseAsJson;
  }

  public function AddButton( $ATitle, $AAction, $AImageURL = ''){
    $item['text'] = $ATitle;
    $item['callback_data'] = $AAction;
    if (!empty($AImageURL)){
        $item['image'] = $AImageURL;
    }
    return $item;
  }

  //size: compact, tall, full -> facebook
  public function AddButtonURL( $ATitle, $AURL, $Size = "full"){
    $item['text'] = $ATitle;
    $item['url'] = $AURL;
    $item['size'] = $Size;
    return $item;
  }

  /**
   * TASK
   */
  public function AddTask( $AUserId, $AFirstName, $ALastName, $ASubject, $ADescription, $AModule = ''){
    if (empty($this->ClientId)) return false;
    $payLoad['client_id'] = $this->ClientId;
    $payLoad['user_id'] = $AUserId;
    $payLoad['first_name'] = $AFirstName;
    $payLoad['last_name'] = $ALastName;
    $payLoad['subject'] = $ASubject;
    $payLoad['description'] = $ADescription;
    $payLoad['module'] = $AModule;

    $payloadAsJson = json_encode($payLoad, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
    $opts = [
      "http" => [
          "method" => "POST",
          'header'=> "Content-Type: application/json\r\n"
            . "Content-Length: " . strlen($payloadAsJson) . "\r\n"
            . "token: ".$this->Token."\r\n",
          'content' => $payloadAsJson
      ]
    ];
    $context = stream_context_create($opts);
    $url = rtrim($this->BaseURL,'/\\').'/task/';
    $result = @file_get_contents($url, false, $context);
    if (empty($result)) return false;
    $responseAsJson = @json_decode($result, true);
    return $responseAsJson;
  }

}
