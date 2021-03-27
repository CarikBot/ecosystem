<?php
/**
 * USAGE
 *   curl "http://localhost/services/ecosystem/entertainment/themoviedb/detail/" -d "id=434769"
 *   curl "{ecosystem_baseurl}/services/entertainment/themoviedb/detail/" -d "id=434769"
 * 
 * @date       04-01-2021 01:35
 * @category   Education
 * @package    Civitas Directory Library
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_NONE);
include_once "../../config.php";
require_once "../../lib/lib.php";
require_once "./TheMovieDB_lib.php";
const BASE_IMAGE = 'https://www.themoviedb.org/t/p/w300_and_h450_bestv2/';

$Key = $Config['packages']['entertainment']['themoviedb']['key'];
if (empty($Key)) Output(200, 'Maaf, belum bisa akses ke pusat info perfilman.');

$ID = urldecode(@$_GET['id']);
if (empty($ID)) $ID = urldecode(@$_POST['id']);
if (empty($ID)) Output(0, 'Maaf, pencarian info film tidak lengkap.');

$Text = "*Info Film*\n";

$TheMovieDB = new TheMovieDB;
$TheMovieDB->Key = $Key;
$movie = $TheMovieDB->Detail($ID);

if (!$movie) Output(0, "Maaf, informasi lengkap tentang film tersebut tidak kami temukan.");

$IMDBid = $movie['imdb_id'];
$posterPath = @$movie['poster_path'];
$image = (!empty($posterPath)) ? BASE_IMAGE . $posterPath : '';
$Text .= "\n*$movie[title]*";

$Text .= "\nGenre: ";
foreach ($movie['genres'] as $genre) {
  $Text .= $genre['name']. ',';
}
$Text = rtrim($Text, ',');
$Text .= "\nRelease: ".substr($movie['release_date'], 0, 4);
$Text .= "\n_$movie[overview]_";
if (!empty($image)) $Text .= "[.]($image)";
$Text .= "\n[IMDB](https://www.imdb.com/title/$IMDBid)";

//die($Text);
Output( 0, $Text);
