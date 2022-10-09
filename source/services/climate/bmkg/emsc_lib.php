<?php
/**
 * USAGE
 *   $emsc = new Carik\EMSC;
 * 
 */
namespace Carik;

require_once "../../lib/lib.php";

class EMSC
{
  const BASE_URL = 'https://m.emsc.eu/webapp/get_earthquakes_list.php?type=';

  public function __construct(){
  }

  public function __get($property) {
    if (property_exists($this, $property)) return $this->$property;
  }

  public function __set($property, $value) {
    if (property_exists($this, $property)) $this->$property = $value;
    return $this;
  }

  //ARisk: risk/full
  public function QuakeInfo($Country, $ARisk = 'risk'){
    $country = strtoupper($Country);
    $url = $this::BASE_URL . $ARisk;
    $result = @file_get_contents($url);
    if ($result == false) return false;
    $data = json_decode($result, true);
    if (!isset($data['features'])) return false;

    $quakes = [];
    foreach ($data['features'] as $quake) {
      $place = @$quake['properties']['place']['region'];
      if (!isStringExist($country, $place)) continue;
      $quakes[] = $quake;
    }
    return $quakes;
  }

}
