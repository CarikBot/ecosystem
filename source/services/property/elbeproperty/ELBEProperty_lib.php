<?php
/**
 * USAGE
 *   $ELBEProperty = new ELBEProperty;
 *   $ELBEProperty->ClientId = '';
 *   
 *   $data = $ELBEProperty->Find('location', 'keyword');
 * 
 * @date       21-02-2021 22:33
 * @category   AksiIDE
 * @package    ELBEProperty
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */

//namespace Carik\ELBEProperty;

/**
 * ELBEProperty Handler
 *
 * @author Luri Darmawan <luri@carik.id>
 */
class ELBEProperty{
  const BASE_URL = 'https://lbpro.id/';

  public function __construct(){
  }

  public function Find($ALocation, $AKeyword, $AMin = '', $AMax = ''){
    
    //TODO: check location from location list

    $url = self::BASE_URL."?cat=0&s=$AKeyword";
    $html = @file_get_contents($url);
    if (empty($html)) return false;

    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    @$dom->loadHTML($html);

    $finder = new DomXPath($dom);
    $nodes = $finder->query('//div[contains(@class,"listpad")]');
    if (0==($nodes->length)) return false;

    $nodeList = [];
    foreach ($nodes as $node) {
      $e = $finder->query('div[contains(@class,"listdetail")]/a', $node);
      $title = trim(@$e->item(0)->textContent);
      $title = str_replace(' – ', ', ', $title);
      $title = str_replace(' - ', ', ', $title);
      $title = str_replace(' : ', ', ', $title);
      $title = str_replace(' ,', ', ', $title);
      $title = trim($title);
      $item['title'] = $title;
      $item['url'] = trim(@$e->item(0)->getAttribute("href"));
      $nodeList[] = $item;
    }

    return $nodeList;
  }

}