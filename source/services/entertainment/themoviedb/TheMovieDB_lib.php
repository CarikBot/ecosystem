<?php
/**
 * USAGE
 *   $TheMovieDB = new TheMovieDB;
 *   $TheMovieDB->Key = '';
 *   
 *   $data = $TheMovieDB->SearchMovie('league');
 * 
 * @date       20-02-2020 21:28
 * @category   AksiIDE
 * @package    TheMovieDB
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */

//namespace Carik\TheMovieDB;
const THEMOVIEDB_BASE_IMAGE = 'https://www.themoviedb.org/t/p/w300_and_h450_bestv2/';

/**
 * TheMovieDB Handler
 *
 * @author Luri Darmawan <luri@carik.id>
 */
class TheMovieDB {
  const BASE_URL = 'https://api.themoviedb.org/3/';
  public $Key = '';

  public function __construct(){
    $this->Referer = @$_SERVER['HTTP_REFERER'];
  }

  public function Search($AKeyword){
    if (empty($this->Key)) return false;
    $url = self::BASE_URL . "search/movie?api_key=".$this->Key."&language=en-US&page=1&include_adult=false&query=".urlencode($AKeyword);
    $data = @file_get_contents($url);
    if (empty($data)) return [];
    $dataAsArray = json_decode($data, true);
    if (0==$dataAsArray['total_results']) return [];

    $movieList = $dataAsArray['results'];
    return $movieList;
  }

  public function Detail($AID){
    if (empty($this->Key)) return false;
    $url = self::BASE_URL . "movie/$AID?api_key=".$this->Key;
    $data = @file_get_contents($url);
    if (empty($data)) return false;
    $dataAsArray = json_decode($data, true);
    return $dataAsArray;
  }

}
