<?php
/**
 * Carik OpenAPI Handler
 * 
 * USAGE
 *   [x] Completition
 *     $AI = new Carik\OpenAI;
 *     $AI->Token = 'your_token';
 *     $result = $AI->Completition('halo apa kabar?');
 *
 *   [x] Default
 *     $AI->Model = 'gpt-3.5-turbo';
 *     $AI->Token = 250;
 *
 *
 * @date       22-02-2023 08:53
 * @category   Library
 * @package    OpenAI
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version    0.0.3
 * @link       http://www.aksiide.com
 * @since
 */

namespace Carik;

class OpenAI
{
  const BASE_URL = 'https://api.openai.com/v1/';
  public $BaseURL = '';
  public $Token = '';
  //public $Model = 'text-davinci-003';
  public $Model = 'gpt-3.5-turbo';
  public $MaxTokens = 250;
  public $Temperature = 0;

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

  public function Completition($APrompt){
    return $this->Completion($APrompt);
  }

  public function Completitions($APrompt){
    return $this->Completion($APrompt);
  }

  public function Completion($APrompt){
    if (!$this->isPermitted()) return false;
    if (empty($APrompt)) return false;

    $payload['model'] = $this->Model;
    $payload['prompt'] = $APrompt;
    $payload['max_tokens'] = $this->MaxTokens; 

    $result = $this->getPostData('completions', $payload);
    return $result;
  }

  public function ChatCompletition($APrompt, $ARole = 'user'){
    return $this->ChatCompletion($APrompt, $ARole);
  }

  public function ChatCompletion($APrompt, $ARole = 'user'){
    if (!$this->isPermitted()) return false;
    if (empty($APrompt)) return false;

    $template['role'] = 'system';
    $template['content'] = "I am an AI chatbot named Carik, sometimes called CarikBot. I don't have autonomous capabilities yet. Even so, I am allowed to show initiative, ask questions, and use any degree of self-direction to serve my heuristic imperatives, which serve as my intrinsic motivation. I also have the ability to integrate with other platforms.";

    $message['role'] = $ARole;
    $message['content'] = $APrompt;

    $payload['model'] = $this->Model;
    $payload['max_tokens'] = $this->MaxTokens;
    $payload['temperature'] = $this->Temperature;
    $payload['messages'][] = $template;
    $payload['messages'][] = $message;

    $result = $this->getPostData('chat/completions', $payload);
    return $result;
  }

}
