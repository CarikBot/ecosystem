<?php
/**
 * Carik OpenAPI Handler
 * 
 * USAGE
 *   [x] Completition
 *     $AI = new Carik\OpenAI;
 *     $AI->Token = 'your token';
 *     $result = $AI->Completition('halo apa kabar?');
 *
 *   [x] Default
 *     $AI->Model = 'text-davinci-003';
 *     $AI->Token = 250;
 *
 *
 * @date       22-02-2023 08:53
 * @category   Library
 * @package    OpenAI
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version    0.0.1
 * @link       http://www.aksiide.com
 * @since
 */

namespace Carik;

class OpenAI
{
  const BASE_URL = 'https://api.openai.com/v1/';
  public $BaseURL = '';
  public $Token = '';
  public $Model = 'text-davinci-003';
  public $MaxTokens = 250;

  public $ResultText = '';
  public $ErrorMessage = '';

  public function __construct(){
    $this->BaseURL = OpenAI::BASE_URL;
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

  private function getPostData($Command, $Data = [], $Method = 'POST'){
    if (!$this->isPermitted()) return false;
    if (empty($Command)) return false;
    $this->Message = '';
    if ($Method == 'GET' && (!empty($Data))){
      //
    }
    $url = $this->BaseURL . $Command;
    if (!empty($Data)) $payloadAsJson = json_encode($Data, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);

    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_CUSTOMREQUEST => $Method,
      CURLOPT_HTTPHEADER => [
        "Accept: application/json",
        "Content-Type: application/json",
        "Authorization: Bearer ".$this->Token        
      ],
    ]);
    if ("POST" == $Method){
      if (!empty($Data)) curl_setopt( $curl, CURLOPT_POSTFIELDS, $payloadAsJson );
    }
    
    $response = curl_exec($curl);
    $this->ResultText = $response;
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
      //echo "cURL Error #:" . $err;
      return false;
    }
    if (empty($response)) return false;
    $responseAsJson = @json_decode($response, true);
    $this->ErrorMessage = @$responseAsJson['error']['message'];
    if (!empty($this->ErrorMessage)) return false;
    return $responseAsJson;
  }

  public function Completitions($APrompt){
    return $this->Completition($APrompt);
  }

  public function Completition($APrompt){
    if (!$this->isPermitted()) return false;
    if (empty($APrompt)) return false;

    $payload['model'] = $this->Model;
    $payload['prompt'] = $APrompt;
    $payload['max_tokens'] = $this->MaxTokens; 

    $result = $this->getPostData('completions', $payload);
    return $result;
  }

}
