<?php
/**
 * USAGE
 *   curl "http://localhost/services/ecosystem/entertainment/themoviedb/search/" -d "keyword=major league"
 *   curl "{ecosystem_baseurl}/services/entertainment/themoviedb/search/" -d "keyword=major league"
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

$Key = $Config['packages']['entertainment']['themoviedb']['key'];
if (empty($Key)) Output(200, 'Maaf, belum bisa akses ke pusat info perfilman.');

$Text = "
Cari info tentang film yang lagi viral bisa di sini lhoo...
Cukup ketikkan format ini:
` info film [keyword]`
contoh
` info film justice league`
";
$Keyword = urldecode(@$_GET['keyword']);
if (empty($Keyword)) $Keyword = urldecode(@$_POST['keyword']);
if (empty($Keyword)) Output(0, $Text);

$Text = "*Info Film*\n";

$TheMovieDB = new TheMovieDB;
$TheMovieDB->Key = $Key;
$movies = $TheMovieDB->Search($Keyword);
$count = count($movies);
if (0==$count) Output(0, "Maaf, info film '$Keyword' tidak ditemukan.");
if (1==$count){
  $id = $movies[0]['id'];
  $movie = $TheMovieDB->Detail($id);
  $IMDBid = @$movie['imdb_id'];
  $posterPath = @$movie['poster_path'];
  $image = (!empty($posterPath)) ? THEMOVIEDB_BASE_IMAGE . $posterPath : '';

  $Text = "*Info Film*";
  $Text .= "\n*$movie[title]*";
  $Text .= "\nGenre: ";
  foreach ($movie['genres'] as $genre) {
    $Text .= $genre['name']. ',';
  }
  $Text = rtrim($Text, ',');
  $Text .= "\nRelease: ".substr($movie['release_date'], 0, 4);
  $Text .= "\n_$movie[overview]_";
  if (!empty($image)) $Text .= "[.]($image)";
  if (!empty($IMDBid)) $Text .= "\n[IMDB](https://www.imdb.com/title/$IMDBid)";
  if (!empty($image)){
    if ($ChannelId=='whatsapp'){
      Output( 0, $Text);
    }else{
      OutputWithImage(0, "tunggu sebentar..", $image, $Text);
    }
  }
        
  //die($Text);
  Output( 0, $Text);
}

$Text .= "Ditemukan ada $count film yang mirip.";
$menuData = [];
foreach ($movies as $movie) {
  $id = $movie['id'];
  $title = $movie['title'];
  $title = str_replace('`', '', $title);
  $title = str_replace('_', '', $title);
  $title = str_replace('*', '', $title);
  $releaseDate = $movie['release_date'];
  if (!empty($releaseDate)) $releaseDate = " (".substr($releaseDate, 0, 4).")";
  $title = $title.$releaseDate;
  $menuData[] = AddButton($title, "text=movie detail $id");
}
$buttonList[] = $menuData;
Output( 0, $Text, 'text', $buttonList, 'menu');
