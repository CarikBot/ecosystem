<?php
/**
 * USAGE
 *   $Wikipedia = new Wikipedia;
 *   $Wikipedia->Token = '';
 *   
 *   $data = $Wikipedia->Find('keyword');
 * 
 * @date       26-02-2021 06:39
 * @category   AksiIDE
 * @package    Wikipedia
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */

//namespace Carik\Wikipedia;

/**
 * Wikipedia Handler
 *
 * @author Luri Darmawan <luri@carik.id>
 */
class Wikipedia{
  const WIKI_EXTRACT_API = 'https://id.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro&explaintext&redirects=1&titles=';
  const WIKI_PARSE_API = 'https://id.wikipedia.org/w/api.php?format=json&action=parse&page=';
  const CARIK_USER_AGENT = 'CarikBot/0.0.1 (https://carik.id/)';

  public $Referer;
  public $Token;

  public function __construct(){
    $this->Referer = @$_SERVER['HTTP_REFERER'];
  }

  public function Find($AKeyword){
    $url = self::WIKI_EXTRACT_API.urlencode($AKeyword);
    $options = [
      "http" => [
        "method" => "GET",
        'user_agent' => self::CARIK_USER_AGENT,
      ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $json = json_decode($result, true);
    $redirectTarget = @$json['query']['redirects'][0]['to'];
    $pages = $json['query']['pages'];
    if (isset($pages[-1])){
      return false;
    }
    return $pages;
  }

}
