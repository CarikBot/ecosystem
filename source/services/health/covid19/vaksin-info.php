<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../config.php";
include_once "../../lib/lib.php";
include_once "../../lib/CarikSuperSearch_lib.php";

// disable feature
RichOutput(0, 'Maaf, informasi covid tidak tersedia.');

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
$i = 1;
foreach ($nodes as $key => $node) {
  $title = trim(@$node->textContent);
  $title = preg_replace('/\[(.*)\]/U', '${1},', $title);
  $url = trim(@$node->getAttribute('href'));
  $Text .= "\n- [$title]($url)";
  $i++;
  if (5==$i) break;
}
$Text .= "\n\nSumber: [Covid19.go.id](https://covid19.go.id/vaksin-covid19)";

$SuperSearch = new Carik\SuperSearch;
$SuperSearch->Token = $Config['packages']['tools']['GlobalSearch']['token'];
$SuperSearch->BaseURL = $Config['packages']['tools']['GlobalSearch']['base_url'];
$SuperSearch->ChannelId = 'telegram';
$result = $SuperSearch->Find('vaksin di indonesia');
if ($result !== false){
  if ($result['code']==0){
    $recommendation = $result['text'];
    $recommendation = str_replace("\n\n","\n",$recommendation);
    $Text .= "\n\n*Berita lainnya:*\n".$recommendation;
  }
}

Output(0, $Text);
