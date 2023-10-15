<?php
/**
 * Simple HTTP library
 * 
 * USAGE
 *   [x] Add Task
 *     $OMNI = new BrainDevs\QontakOmnichannel;
 *     $OMNI->Token = 'your_token';
 *     $OMNI = $Qontak->Ticket->Add('halo apa kabar?');
 *
 *
 *
 * @date       04-05-2019 02:28
 * @category   Library
 * @package    SimpleHTTP
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version    0.1.9
 * @link       https://carik.id
 * @since
 */


namespace Carik;

class SimpleHTTP
{
    protected $BaseURL = '';
    protected $Token = '';
    public $ResultText = '';
    public $ResultCode = -1;
    public $LastHttpStatus = 0;
    public $Message = '';
    public $ErrorCode = 0;
    public $ErrorMessage = '';
    public $IsExpired = false;

    public function GetData($ACommand, $Data = []){
        return $this->GetPostData($ACommand, $Data, 'GET');
    }

    public function PostData($ACommand, $Data = [], $IsJson = True){
        return $this->GetPostData($ACommand, $Data, 'POST', $IsJson);
    }

    private function GetPostData($Command, $Data = [], $Method = 'POST', $IsJson = True){
        if (empty($this->BaseURL)) return false;
        if (empty($Command)) return false;
        $url = $this->BaseURL . $Command;
        if (($Method == 'GET') && (!empty($Data))){
            $queryString = http_build_query($Data);
            $url .= "?$queryString";
        }
        $this->Message = '';
        $this->ErrorCode = -1;
        $this->ErrorMessage = '';
        $this->IsExpired = false;
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
        ]);

        if ($IsJson==true){
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Bearer ".$this->Token
              ]
            );
            if ("POST" == $Method){
                if (!empty($Data)) curl_setopt( $curl, CURLOPT_POSTFIELDS, $payloadAsJson );
            }
        }else{
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                "Content-Type: application/x-www-form-urlencoded",
              ]
            );
            $postData = http_build_query($Data);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        }// /IsJson
        
        $response = curl_exec($curl);
        //die($response);
        $this->ResultText = $response;
        $err = curl_error($curl);
        $this->ResultCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
    
        if ($err){
          //echo "cURL Error #:" . $err;
          return false;
        }
        if (empty($response)) return false;
        $responseAsJson = json_decode($response, true);
        if (empty($responseAsJson)){
            return false;
        }
        $this->Message = @$responseAsJson['meta']['message'];
        //if (!empty($this->ErrorCode)) return false;
        $response = isset($responseAsJson['response']) ? @$responseAsJson['response'] : $responseAsJson;
        $response = isset($responseAsJson['data']) ? @$responseAsJson['data'] : $responseAsJson;
        if (isset($responseAsJson['error'])){
            $this->ErrorCode = @$responseAsJson['error'];
            if (is_array($this->ErrorCode)) $this->ErrorCode = $this->ErrorCode['code'];
            $this->ErrorMessage = @$responseAsJson['error'];
            if (is_array($this->ErrorMessage)) $this->ErrorMessage = $this->ErrorMessage['messages'][0];
            if ($this->ErrorMessage == 'The access token expired') $this->IsExpired = true;
            return false;
        }
        if (isset($responseAsJson['time_usage'])){
          $response['time_usage'] = $responseAsJson['time_usage'];
        }
        return $response;
    }

}
