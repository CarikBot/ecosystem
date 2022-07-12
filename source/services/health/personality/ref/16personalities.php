<?php
/**
 * 16personalities data handler
 * 
 * post url: https://www.16personalities.com/id/hasil-tes
 */

const TARGET_URL = 'https://www.16personalities.com/id/tes-kepribadian';
const REGEX_EXPRESSION = '/(?<value>(?<=questions=")(.*)(?="))/';
require_once "../../../lib/lib.php";

//$content = file_get_contents(TARGET_URL);
$content = readTextFile("html.html");
//writeTextFile("html.html", $content);


preg_match(REGEX_EXPRESSION, $content, $matches);
$data = $matches['value'];
$data = html_entity_decode($data);
writeTextFile("mbti16.json", $data);
$dataAsArray = json_decode($data);
$dataAsJsonString = json_encode($dataAsArray, JSON_PRETTY_PRINT);
writeTextFile("mbti16.json", $dataAsJsonString);

die($dataAsJsonString);
