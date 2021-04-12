<?php
/**
* File: CarikSuperSearch_lib.php
* Carik Super Search
*
* @date       10-10-2017 19:20
* @category   AksiIDE
* @package    AksiIDE
* @subpackage
* @copyright  Copyright (c) 2013-endless AksiIDE
* @license
* @version
* @link       http://www.aksiide.com
* @since
*/

//namespace Carik\CarikSuperSearch;

/**
 * Super Search Handler
 *
 * @author Luri Darmawan <luri@carik.id>
 */
class CarikSuperSearch
{
  public $Token = '';
  public $BaseURL = '';
  public $ChannelId = '';

  public function __construct(){
  }

  public function Find($AKeyword){
    if (empty($this->Token)) return false;
    if (empty($this->BaseURL)) return false;

    $postData['keyword'] = $AKeyword;
    $postData['ChannelId'] = 'telegram';
    $postData = http_build_query($postData);
    $opts = [
      "http" => [
          "method" => "POST",
          'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
            . "Content-Length: " . strlen($postData) . "\r\n"
            . "token: ".$this->Token."\r\n",
          'content' => $postData
      ]
    ];
    $context = stream_context_create($opts);
    $url = $this->BaseURL . '?prefix=no&token='.$this->Token;
    $result = @file_get_contents($url, false, $context);
    if (empty($result)) return false;
    $return = json_decode($result, true);
    return $return;
  }

}
