<?php
/**
 * Carik Super Search Handler
 *
 * USAGE
 *   [x] Search
 *     $SuperSearch = new Carik\SuperSearch;
 *     $SuperSearch->BaseURL = 'your carik search engine url';
 *     $SuperSearch->Token = 'your token';
 *     $result = $SuperSearch->Search('search keyword');
 *
 * @date       07-11-2022 20:21
 * @category   Library
 * @package    Super Search
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version    0.0.2
 * @link       http://www.aksiide.com
 * @since
 */

namespace Carik;

/**
 * Super Search Handler
 *
 * @author Luri Darmawan <luri@carik.id>
 */
class SuperSearch
{
  public $Token = '';
  public $BaseURL = '';
  public $ChannelId = '';

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

  // old version compatibility
  public function Find($AKeyword){
    return $this->Search($AKeyword);
  }

  public function Search($AKeyword){
    if (!$this->isPermitted()) return false;

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
    $url = $this->BaseURL . '?prefix=no&token='.$this->Token; //TODO: remove token from query string
    $result = @file_get_contents($url, false, $context);
    if (empty($result)) return false;
    $return = json_decode($result, true);
    return $return;
  }

}
