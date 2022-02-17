<?php
require_once "../../lib/lib.php";

function getContent($AKeyword){
  $return = '';
  $keyword = trim($AKeyword);
  $keyword = str_replace(' ', '_', $keyword);
  $keyword = str_replace('&', '_', $keyword);
  $keyword = str_replace('___', '_', $keyword);
  $convertions = array(
    'array' => 'arrays',
    'boolean' => 'booleans',
    'class' => 'classes',
    'coding_standar' => 'coding_standard',
    'constant' => 'constants',
    'cookie' => 'cookies',
    'condition' => 'decision_making',
    'conditions' => 'decision_making',
    'date_time' => 'date_and_time',
    'datetime' => 'date_and_time',
    'date' => 'date_and_time',
    'data_type' => 'data_types',
    'decision' => 'decision_making',
    'dom' => 'dom_parser_example',
    'file' => 'files_handling',
    'files' => 'files_handling',
    'file_handling' => 'files_handling',
    'function' => 'functions',
    'fungsi' => 'functions',
    'loop' => 'loops',
    'get' => 'get_post',
    'memori' => 'memory',
    'object' => 'object_oriented',
    'operator' => 'operator_types',
    'pointer' => 'pointers',
    'post' => 'get_post',
    'procedure' => 'procedures',
    'record' => 'records',
    'regex' => 'regular_expression',
    'sax' => 'sax_parser_example',
    'session' => 'sessions',
    'set' => 'sets',
    'string' => 'strings',
    'structure' => 'program_structure',
    'syntax' => 'syntax_overview',
    'tipe_data' => 'data_types',
    'unit' => 'units',
    'variant' => 'variants',
    'variable' => 'variable_types',
    'variable_type' => 'variable_types',
    'xml' => 'simple_xml',
  );
  $keyword = (!empty($convertions[$keyword])) ? $convertions[$keyword] : $keyword;
  $url = "https://www.tutorialspoint.com/php/php_$keyword.htm";
  //return $url;

  $parser = new Parser();
  $args['url'] = $url;
  $args[ "data"] = array(
  );
  $result = $parser->httpGet( $args);
  if ($result['err'] !== 0){
    return '';
  }
  $content = $result['content'];

  $html = strstr($content, '<div class="clearer"></div>');
  $html = rstrstr($html, '<h2>');
  $html = strip_tags($html);
  $html .= " ...\n\n[Info Lengkap]($url) di sini.";
  return $html;

  // bypass here
  $dom = new DOMDocument();
  $dom->preserveWhiteSpace = false;
  @$dom->loadHTML($content);
  $finder = new DomXPath($dom);

  $className="tutorial-content";
  //$node = $finder->query("//div[contains(@class, '$className')]/div");
  $node = $finder->query('//div[contains(@class,"'.$className.'")]');
  if ($node->length==0){
    return '';
  }

  $html = $dom->saveHTML(@$node->item(0));
  $html = str_replace('<div class="google-bottom-ads">','', $html);
  $html = str_replace('<div>Advertisements</div>','', $html);
  $html = str_replace('<li>','- ', $html);
  $html = str_replace('</li>','', $html);

  $html = preg_replace('#<div([^>]*)(class\\s*=\\s*["\']top-ad-heading["\'])([^>]*)>(.*?)</div>#is', '', $html);
  $html = preg_replace('#<div([^>]*)(class\\s*=\\s*["\']pre-btn["\'])([^>]*)>(.*?)</div>#is', '', $html);
  $html = preg_replace('#<div([^>]*)(class\\s*=\\s*["\']nxt-btn["\'])([^>]*)>(.*?)</div>#is', '', $html);
  
  $html = preg_replace('#<h1(.*?)>(.*?)</h1>#is', '*$2*', $html);
  //$html = preg_replace('#<h2(.*?)>(.*?)</h2>#is', '*$2*', $html);
  $html = preg_replace('#<h2(.*?)>(.*?)</h2>#is', '-------*$2*', $html);
  $html = preg_replace('#<b(.*?)>(.*?)</b>#is', '*$2*', $html);
  $html = preg_replace('#<pre(.*?)>(.*?)</pre>#is', '```$2```'."\n", $html);
  
  $html = str_replace("<td>\n","<td>", $html);
  $html = str_replace("\n</td>","</td>", $html);
  $html = trim(strip_tags($html));
  //$html = html_entity_decode( $html); <-- jadi hang
  $html = str_replace('&amp;','&', $html);
  $html = str_replace('&lt;','', $html); //'«'
  $html = str_replace('&gt;','>', $html);
  $html = str_replace('−', '-', $html);
  $html = str_replace("\n\n\n\n","\n", $html);
  $html = str_replace("\n\n\n","\n", $html);
  $html = str_replace("_","", $html);
  $html = str_replace("   ","  ", $html);
  $html = str_replace('[','\[', $html);
  $html = str_replace(']','\]', $html);

  $a =explode('-------', $html);
  $html = trim($a[0]);
  $html .= " ...\n\n[Info Lengkap]($url) di sini.";

  if (strlen($html) > 3900){
    $html = substr($html,0,3900);
    $i = substr_count($html, '```');
    if($i % 2 == 0){
    }else{
      $html .= '```';
    }
    $html .= " ...\n\n[Info Lengkap]($url) di sini.";
  }
  
  return trim($html);
}