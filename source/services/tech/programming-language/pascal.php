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
    'constant' => 'constants',
    'condition' => 'decision_making',
    'conditions' => 'decision_making',
    'date & time' => 'date_time',
    'datetime' => 'date_time',
    'date' => 'date_time',
    'data_type' => 'data_types',
    'decision' => 'decision_making',
    'file' => 'files_handling',
    'files' => 'files_handling',
    'file_handling' => 'files_handling',
    'function' => 'functions',
    'fungsi' => 'functions',
    'loop' => 'loops',
    'looping' => 'loops',
    'memori' => 'memory',
    'object' => 'object_oriented',
    'operator' => 'operators',
    'pointer' => 'pointers',
    'procedure' => 'procedures',
    'record' => 'records',
    'set' => 'sets',
    'string' => 'strings',
    'structure' => 'program_structure',
    'syntax' => 'basic_syntax',
    'time' => 'data_types',
    'tipe_data' => 'data_types',
    'unit' => 'units',
    'variant' => 'variants',
    'variabel' => 'variable_types',
    'variable' => 'variable_types',
    'variable_type' => 'variable_types',
  );
  $keyword = (!empty($convertions[$keyword])) ? $convertions[$keyword] : $keyword;
  $url = "https://www.tutorialspoint.com/pascal/pascal_$keyword.htm";
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
  return trim($html);
}
