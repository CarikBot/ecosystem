<?php
/**
 * USAGE
 *   $PMIJateng = new PMIJateng;
 *   $PMIJateng->ClientId = '';
 *   
 *   $data = $PMIJateng->Find('location', 'keyword');
 * 
 * @date       13-03-2021 20:52
 * @category   AksiIDE
 * @package    PMIJateng
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */

require_once "../../lib/lib.php";

//namespace Carik\PMIJateng;

/**
 * PMIJateng Handler
 *
 * @author Luri Darmawan <luri@carik.id>
 */
class PMIJateng{
  const BASE_URL = 'https://pmi-jateng.or.id/udd/';
  public $UDD = [];
  public $Schedules = [];
  public $Stocks = [];


  public function __construct(){
  }

  public function FindAddress($AKeyword){
    $data = @file_get_contents('address.json');
    $this->UDD = json_decode($data, true);
    $keyword = strtolower($AKeyword);
    $return = [];
    if (empty($AKeyword)) return [];
    foreach ($this->UDD as $item) {
      $city = $item['Kab/Kota'];
      if (!isStringExist($keyword, strtolower($city))) continue;
      $return[] = $item;
    }
    return $return;
  }

  public function Schedule($AKeyword){
    $html = @file_get_contents(self::BASE_URL);
    if (empty($html)) return [];
    $keyword = strtolower($AKeyword);

    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    @$dom->loadHTML($html);

    $finder = new DomXPath($dom);
    $nodes = $finder->query('//table[@id="tabeluser"]/tbody/tr');
    if (0==($nodes->length)) return false;

    $this->Schedules = [];
    foreach ($nodes as $key => $node) {
      $e = $finder->query('td', $node);
      $city = trim(@$e->item(1)->textContent);
      $location = trim(@$e->item(2)->textContent);
      $start = trim(@$e->item(3)->textContent);
      $finish = trim(@$e->item(4)->textContent);
      $note = trim(@$e->item(5)->textContent);
      $item['udd'] = $city;
      $item['location'] = $location;
      $item['start'] = $start;
      $item['finish'] = $finish;
      $item['note'] = $note;
      $this->Schedules[] = $item;
    }

    $return = [];
    if (empty($AKeyword)) return [];
    foreach ($this->Schedules as $item) {
      $udd = $item['udd'];
      if (!isStringExist($keyword, strtolower($udd))) continue;
      $return[] = $item;
    }

    return $return;
  }

  public function Stock($AKeyword){
    $html = @file_get_contents(self::BASE_URL);
    if (empty($html)) return [];
    $keyword = strtolower($AKeyword);

    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    @$dom->loadHTML($html);

    $finder = new DomXPath($dom);
    $nodes = $finder->query('//table[@id="tabeluser2"]');
    $nodes = $finder->query('tbody/tr', $nodes->item(0));
    if (0==($nodes->length)) return false;

    $this->Stocks = [];
    foreach ($nodes as $key => $node) {
      $e = $finder->query('td', $node);
      $city = trim(@$e->item(1)->textContent);
      $golA = trim(@$e->item(2)->textContent);
      $golB = trim(@$e->item(3)->textContent);
      $golAB = trim(@$e->item(4)->textContent);
      $golO = trim(@$e->item(5)->textContent);
      $updateDate = trim(@$e->item(6)->textContent);

      $item['udd'] = $city;
      $item['A'] = $golA;
      $item['B'] = $golB;
      $item['AB'] = $golAB;
      $item['O'] = $golO;
      $item['updateDate'] = $updateDate;
      $this->Stocks[] = $item;
    }

    $return = [];
    if (empty($AKeyword)) return [];
    foreach ($this->Stocks as $item) {
      $udd = $item['udd'];
      if (!isStringExist($keyword, strtolower($udd))) continue;
      $return[] = $item;
    }

    return $return;
  }

}