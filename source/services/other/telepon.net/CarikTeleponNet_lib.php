<?php
/**
 * Telepon.net handler
 * 
 * USAGE
 *   [x] Check Telepon
 *     $TN = new Carik\TeleponNet;
 *     $TN->Check('+6234567890');
 * 
 *
 * @date       09-08-2023 03:01
 * @category   Library
 * @package    TeleponNet
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version    0.0.1
 * @link       https://carik.id
 * @since
 */

namespace Carik;

require_once "../../lib/simplehtmldom_2_0/simple_html_dom.php";

class TeleponNet
{
  const BASE_URL = "https://telepon.net/nomortelepon/";

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

  public function Check($APhone){
    $phone = str_replace("+62", "", $APhone);
    $phone = preg_replace("/[^0-9]/", "", $phone);
    if (substr($phone, 0, 1) == "0") $phone = substr($phone, 1);
    $url = TeleponNet::BASE_URL . $phone . '/';
    //$html = file_get_contents("x.html");
    //$html = @file_get_contents($url);

    $html = @file_get_html($url);
    if (empty($html)) return false;
    if (isStringExist("That page can’t be found", $html)) return false;

    $estimation = $html->find("div.entry-predict");
    $estimation = trim(strip_tags(@$estimation[0]->innertext));
    $estimation = str_replace("  ", ": ", $estimation);
    $return['estimation'] = $estimation;

    $highlight = $html->find("div.post-highlight-circle");
    $rate = trim(strip_tags(@$highlight[0]->innertext));
    $report = trim(strip_tags(@$highlight[1]->innertext));
    $return['rate'] = $rate;
    $return['report'] = $report;
    return $return;
  }

}