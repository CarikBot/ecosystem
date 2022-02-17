<?php
require_once "../../lib/lib.php";

function getContent($AKeyword){
  $return = '';
  $keyword = trim($AKeyword);
  $keyword = str_replace(' ', '_', $keyword);
  $keyword = str_replace('&', '_', $keyword);
  $keyword = str_replace('___', '_', $keyword);
  $convertions = array(
    'array' => 'array_object',
    'boolean' => 'boolean_object',
    'case' => 'switch_case',
    'class' => 'classes',
    'coding_standar' => 'coding_standard',
    'constant' => 'constants',
    'cookie' => 'cookies',
    'condition' => 'decision_making',
    'conditions' => 'decision_making',
    'date_time' => 'date_object',
    'datetime' => 'date_object',
    'date' => 'date_object',
    'data_type' => 'data_types',
    'decision' => 'decision_making',
    'dom' => 'html_dom',
    'file' => 'files_handling',
    'files' => 'files_handling',
    'file_handling' => 'files_handling',
    'for' => 'for_loop',
    'function' => 'functions',
    'fungsi' => 'functions',
    'loop' => 'while_loop',
    'get' => 'get_post',
    'math' => 'math_object',
    'memori' => 'memory',
    'number' => 'number_objects',
    'object' => 'objects',
    'operator' => 'operators',
    'placement' => 'placement',
    'pointer' => 'pointers',
    'post' => 'get_post',
    'procedure' => 'procedures',
    'record' => 'records',
    'regex' => 'regexp_object',
    'regexp' => 'regexp_object',
    'sax' => 'sax_parser_example',
    'session' => 'sessions',
    'set' => 'sets',
    'string' => 'string_object',
    'structure' => 'program_structure',
    'switch' => 'switch_case',
    '-syntax' => 'syntax_overview',
    'tipe_data' => 'data_types',
    'unit' => 'units',
    'variant' => 'variants',
    'variabel' => 'variables',
    'variable' => 'variables',
    'variable_type' => 'variable_types',
    'while' => 'while_loop',
    'xml' => 'simple_xml',
  );
  $keyword = (!empty($convertions[$keyword])) ? $convertions[$keyword] : $keyword;
  $url = "https://www.tutorialspoint.com/javascript/javascript_$keyword.htm";

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
  //$html = rstrstr($html, '<h2>');
  $html = rstrstr($html, '</p>')."</p>";
  $html = trim(strip_tags($html));
  $html = html_entity_decode($html);
  if (empty($html)){
    $html = "Maaf nihh.. Saya tidak menemukan info tentang '$keyword' ini. Tapi coba lihat dari [url tutorial]($url) ini yaa.";
  }else{
    $html .= " ...\n\n[Info Lengkap]($url) di sini.";
  }
  return $html;
}
