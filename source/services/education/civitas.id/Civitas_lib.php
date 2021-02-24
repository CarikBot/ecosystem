<?php
/**
 * USAGE
 *   $Civitas = new Civitas;
 *   
 *   $campuses = $Civitas->SearchKampus('nusa');
 * 
 * 
 * logo url:
 *   https://apicampusdir.civitas.id/images/colleges/logos/041020.png
 * 
 */

//namespace Carik\Civitas;

/**
 * Civitas Handler
 *
 * @author Luri Darmawan <luri@carik.id>
 */
class Civitas
{

  protected $version = '0.0.0';
  protected $cookiesFile;

  public $BaseURL = '';
  public $Key = '';
  public $Page = 1;
  public $PerPage = 10;
  public $FullSearch = true;
  public $TotalItems = 0;
  public $Count = 0;
  public $Data = [];

  public function __construct(){
    //$this->cookiesFile = sys_get_temp_dir( ).'/civitas-cookies.txt';
  }

  public function SearchKampus($AKeyword, $Args = []){
    $this->TotalItems = 0;
    $this->Count = 0;
    if (empty($this->BaseURL)) return false;
    if (empty($this->Key)) return false;

    $url = $this->BaseURL . 'college/all?page=1&perPage='.$this->PerPage;
    if ($this->FullSearch) $url .= '&full=true';
    $url .= '&search='. urlencode($AKeyword);

    $postData = [];
    $postData = http_build_query($postData);
      $opts = [
      "http" => [
          "method" => "GET",
          'header'=> "Content-Length: " . strlen($postData) . "\r\n"
            . "api-key: ".$this->Key."\r\n",
          'content' => $postData
      ]
    ];
    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);
    if (empty($result)) return false;
    $json = json_decode($result, true);

    $this->TotalItems = $json['meta']['totalItems'];
    $this->Count = count($json['data']);
    return $json['data'];
  }

  public function DetailByID($AID){
    if (empty($AID)) return [];

    $url = $this->BaseURL . 'college/' . $AID;
    $postData = [];
    $postData = http_build_query($postData);
      $opts = [
      "http" => [
          "method" => "GET",
          'header'=> "Content-Length: " . strlen($postData) . "\r\n"
            . "api-key: ".$this->Key."\r\n",
          'content' => $postData
      ]
    ];
    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);
    if (empty($result)) return false;
    $json = json_decode($result, true);
    if (empty($json)) {
      return [];
    }
    return $json[0];
  }

  public function StudyProgramByID($AID){
    $this->TotalItems = 0;
    $this->Count = 0;
    if (empty($AID)) return [];

    $url = $this->BaseURL . 'studyprogram/all?page=1&perPage=10&college_id=' . $AID;
    $postData = [];
    $postData = http_build_query($postData);
      $opts = [
      "http" => [
          "method" => "GET",
          'header'=> "Content-Length: " . strlen($postData) . "\r\n"
            . "api-key: ".$this->Key."\r\n",
          'content' => $postData
      ]
    ];
    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);
    if (empty($result)) return false;
    $json = json_decode($result, true);
    if (empty($json)) {
      return [];
    }
    $this->TotalItems = $json['meta']['totalItems'];
    $this->Count = count($json['data']);
    return $json['data'];
  }


}
