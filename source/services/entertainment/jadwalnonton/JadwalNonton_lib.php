<?php
namespace Carik;

require_once "../../lib/simplehtmldom_2_0/simple_html_dom.php";

class JadwalNonton {
  const BASE_URL = 'https://jadwalnonton.com/bioskop/';
  public $Cache = false;

  public function __construct(){
    $this->Referer = @$_SERVER['HTTP_REFERER'];
  }

  public function GetStudioList($ACity){
    $city = strtolower(str_replace(' ', '-', $ACity));
    
    $url = self::BASE_URL . "di-" . $city . '/';
    $html = file_get_html($url);
    $s = strip_tags($html->find('h1 span', 0)->innertext);
    if (strtolower($s) <> strtolower(trim($ACity))) return [];

    $studios = [];
    foreach($html->find("div.theater") as $row) {
      $name = trim($row->find("span.judul", 0)->innertext);
      $url = trim($row->find("a", 0)->attr['href']);
      $item['name'] = $name;
      $item['url'] = $url;
      $studios[] = $item;
    }

    return $studios;
  }

  public function GetSchedule($AStudioList, $AIndex){
    if ($AIndex > count($AStudioList)) return [];
    $url = $AStudioList[$AIndex-1]['url'];
    $html = file_get_html($url);

    $schedules = [];
    foreach($html->find("div.thealist div.item") as $row) {
      $item['title'] = $row->find("h2 a", 0)->innertext;
      $item['rating'] = $row->find("span.rating", 0)->innertext;
      $item['description'] = $row->find("p", 0)->innertext;
      $item['price'] = $row->find("p.htm", 0)->innertext;
      $item['price'] = str_replace("Harga tiket masuk Rp ", "", $item['price']);

      $hours = [];
      foreach($row->find("ul.usch li") as $se) {
        $hours[] = $se->innertext;
      }
      $item['hours'] = $hours;

      $schedules[] = $item;
    }

    return $schedules;
  }
}
