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
 *   [x] Add Task
 *     // $TaskType: 0: General, 1: Inquiry, 2: Complain, 3: Appointment, 4: Spam/Scam, 5:Other
 *     // const TaskType = [ 'General', 'Inquiry', 'Complain', 'Appointment', 'Billing', 'Spam/Scam', 'Other'];
 *     $r = $API->AddTask($UserId, $fullName, '', $Subject, $Description, 'appointment', '', true, $TaskType);
 *
 *   [x] Event Log
 *     $r = $API->AddEventLog('modulename', 'sourcename', 'eventname', $request, $result);
 *
 * @date       02-08-2020 12:47
 * @category   API
 * @package    Carik
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version    0.0.12
 * @link       http://www.aksiide.com
 * @since
 * @history
 *   - add url to eventlog
 */

namespace Carik;

class API
{
  private $DB = false;
  public $BaseURL = '';
  public $Token = '';
  public $DeviceToken = '';
  public $ClientId = '';
  public $Helpdesk;
  public $BranchId = 0;

  public function __construct(){
    $this->Helpdesk = new APIHelpdesk();
  }

  public function __get($property) {
    if (property_exists($this, $property)) return $this->$property;
  }

  public function __set($property, $value) {
    if (property_exists($this, $property)) $this->$property = $value;
    if ($property=='DB') {
      //$this->Cart->DB = $value;
    }
    if ($property=='Token'){
      $this->Helpdesk->Token = $value;
    }
    if ($property=='BaseURL'){
      $this->Helpdesk->BaseURL = $value;
    }
    if ($property=='ClientId'){
      $this->Helpdesk->ClientId = $value;
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
    $data['full_name'] = $AFullName;//compatibility
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
      ],
      'ssl' => [
        "verify_peer" => false
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

  public function AddTask( $AUserId, $AFirstName, $ALastName, $ASubject, $ADescription, $AModule = '', $ACustomCode = '', $AIsRound = true, $ATaskType = 0){
    if (empty($this->ClientId)) return false;
    $payLoad['client_id'] = $this->ClientId;
    $payLoad['user_id'] = $AUserId;
    $payLoad['first_name'] = $AFirstName;
    $payLoad['last_name'] = $ALastName;
    $payLoad['subject'] = $ASubject;
    $payLoad['description'] = $ADescription;
    $payLoad['module'] = $AModule;
    $payLoad['type'] = $ATaskType;
    $payLoad['branch_id'] = $this->BranchId;
    $payLoad['round'] = ($AIsRound == true) ? 1 : 0;

    if (!empty($ACustomCode)) $payLoad['code'] = $ACustomCode;

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

  /**
   * EVENT LOG
   */

   public function AddEventLog( $AModulName, $ASource, $AEventName, $ARequest, $AResult, $ACustomDate = '', $AReferenceId = '', $ATimeUsage = 0, $AURL = ''){
    if (empty($this->ClientId)) return false;
    $payLoad['client_id'] = $this->ClientId;
    $payLoad['module'] = $AModulName;
    $payLoad['source'] = $ASource;
    $payLoad['event_name'] = $AEventName;
    $payLoad['request'] = $ARequest;
    $payLoad['result'] = $AResult;
    $payLoad['url'] = $AURL;
    if (!empty($ACustomDate)){
      $payLoad['custom_date'] = $ACustomDate;
    }
    if (!empty($AReferenceId)){
      $payLoad['ref_id'] = $AReferenceId;
    }
    $payLoad['time_usage'] = $ATimeUsage;

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
    $url = rtrim($this->BaseURL,'/\\').'/eventlog/track/'.$this->ClientId.'/';
    $result = @file_get_contents($url, false, $context);
    if (empty($result)) return false;
    $responseAsJson = @json_decode($result, true);
    return $responseAsJson;
  }

}

class APIHelpdesk
{
  public $DB = false;
  public $ClientId = 0;
  public $BaseURL = "";
  public $Token = '';

  public function __construct(){
  }

  public function GetClientTickets($AUserId){
    if (empty($AUserId)) return false;
    $user = explode('-', $AUserId);
    $url = rtrim($this->BaseURL,'/\\')."/task/?client_id=$this->ClientId&code=&user_id=$user[1]";
    $result = @file_get_contents($url);
    if (empty($result)) return false;
    $responseAsJson = @json_decode($result, true);
    if (@$responseAsJson['code'] != 0) return false;
    return @$responseAsJson['data']['tasks'];
  }

  public function AddNPS($AParameters = [], $AModule = ''){
    if (empty($AParameters)) return false;
    if (empty($this->ClientId)) return false;
    $date = date("Y-m-d H:i:s");
    $dateAsInteger = strtotime($date);


    $payloadAsJson = json_encode($AParameters, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
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
    $url = rtrim($this->BaseURL,'/\\').'/helpdesk/nps/' . $this->ClientId . "/?module=$AModule";
    $result = @file_get_contents($url, false, $context);
    if (empty($result)) return false;
    $responseAsJson = @json_decode($result, true);
    return $responseAsJson;
  }

}
