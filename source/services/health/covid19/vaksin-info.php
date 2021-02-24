<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../config.php";
include_once "../../lib/lib.php";

$BaseURL = @$Config['packages']['health']['Covid19']['vaksin_info_url'];
if (empty($BaseURL)) Output(500, 'Maaf, informasi vaksin covid-19 gagal diperoleh.');

$html = file_get_contents($BaseURL);
if (empty($html)) Output(500, 'Maaf, sumber informasi vaksin covid-19 tidak bisa ditemukan, silakan coba lagi nanti yaa.');

$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
@$dom->loadHTML($html);

$finder = new DomXPath($dom);
$nodes = $finder->query('//h5/a');

$Text = "*Info Vaksinasi COVID-19*\n";
foreach ($nodes as $key => $node) {
  $title = trim(@$node->textContent);
  $url = trim(@$node->getAttribute('href'));
  $Text .= "\n- [$title]($url)";
}
$Text .= "\n\nSumber: [Covid19.go.id](https://covid19.go.id/vaksin-covid19)";

//die($Text);
Output(0, $Text);
