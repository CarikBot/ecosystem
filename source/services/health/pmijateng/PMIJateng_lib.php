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
  public $APIBaseURL = '';
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
    if (empty($this->APIBaseURL)) return $this->stockFromWeb($AKeyword);
    $keyword = urlencode(strtolower($AKeyword));
    $jsonAsString = @file_get_contents($this->APIBaseURL.'jadwaldonor.php?keyword='.$keyword);
    if (empty($jsonAsString)) return $this->stockFromWeb($AKeyword);
    $schedules = json_decode($jsonAsString, true);
    $schedules = $schedules['result'];

    $this->Schedules = [];
    foreach ($schedules as $node) {
      $item['udd'] = $node['nama'];
      $item['location'] = $node['instansi'];
      $item['date'] = $node['tgl_mu'];
      $item['start'] = $node['jam_mulai'];
      $item['finish'] = $node['jam_selesai'];
      $item['note'] = $node['peruntukan'];
      $this->Schedules[] = $item;
    }

    $keyword = strtolower($AKeyword);
    $keyword = str_replace('kab ', 'kabupaten ', $keyword);
    $return = [];
    foreach ($this->Schedules as $item) {
      $name = $item['udd'];
      if (!isStringExist($keyword, strtolower($name))) continue;
      $return[] = $item;
    }
    return $return;    
  }

  public function scheduleFromWeb($AKeyword){
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
      $item['date'] = '';
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
    if (empty($this->APIBaseURL)) return $this->stockFromWeb($AKeyword);
    $keyword = urlencode(strtolower($AKeyword));
    $jsonAsString = @file_get_contents($this->APIBaseURL.'stokdarah.php?keyword='.$keyword);
    if (empty($jsonAsString)) return $this->stockFromWeb($AKeyword);
    $stockList = json_decode($jsonAsString, true);
    $stockList = $stockList['result'];

    $this->Stocks = [];
    foreach ($stockList as $node) {
      $name = $node['nama'];
      $item['udd'] = $name;
      $item['A'] = $node['golda_a'];
      $item['B'] = $node['golda_b'];
      $item['AB'] = $node['golda_ab'];
      $item['O'] = $node['golda_o'];
      $item['updateDate'] = $node['tgl_update'];
      $this->Stocks[] = $item;
    }

    $keyword = strtolower($AKeyword);
    $keyword = str_replace('kabupaten ', 'kab ', $keyword);
    $return = [];
    foreach ($this->Stocks as $item) {
      $name = $item['udd'];
      if (!isStringExist($keyword, strtolower($name))) continue;
      $return[] = $item;
    }
    return $return;
  }

  private function stockFromWeb($AKeyword){
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