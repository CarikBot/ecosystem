<?php
/**
 * USAGE
 *   curl 'http://localhost:8000/forecast.php' -d 'city=semarang'
 *
 * @date       25-03-2020 13:19
 * @category   community
 * @package    Cafestartup - startup list
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../../config.php";
include_once "../../../lib/lib.php";

const FORECAST_API_URL = 'http://api.openweathermap.org/data/2.5/forecast/daily';

$City = @$_POST['city'];
if (empty($City)) Output(0, "Maaf, informasi permintaan tidak lengkap. Format perintah:\n `prakiraan cuaca di [namakota]`");
$City .= ",id";

$parameters['appid'] = @$Config['packages']['climate']['openweathermap']['appid'];
$parameters['lang'] = "id";
$parameters['units'] = "metric";
$parameters['mode'] = "json";
$parameters['cnt'] = "7";
$parameters['q'] = "jakarta,id";
$parameters = http_build_query($parameters);
$url = FORECAST_API_URL.'?'.$parameters;

$result = @file_get_contents($url, false);
if (empty($result)) Output(200, "Maaf, informasi prakiraan cuaca belum bisa kami dapatkan.");

$data = json_decode($result, true);
$cityName = $data['city']['name'];
$lat = $data['city']['coord']['lat'];
$lon = $data['city']['coord']['lon'];
$forecastList = $data['list'];

$i = 0;
$Text = "*Prakiraan Cuaca $cityName*\n";
foreach ($forecastList as $day) {
  $date = date('d', strtotime("$i days", strtotime(date('Y-m-d'))));
  $description = $day['weather'][0]['description'];
  $description = str_replace('awan pecah', 'berawan', $description);
  $description = ucwords($description);
  $temp = $day['temp']['day'];
  $Text .= "\n$date: $description ($temp)";
  $i++;
}

$Text .= "\n\nTetap prokes dan jaga diri yaa.";
//die($Text);
Output(0, $Text);
