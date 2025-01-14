<?php
/**
 * USAGE
 *   $GoogleScript = new GoogleScript;
 *   $GoogleScript->DocId = '';
 *   $GoogleScript->ScriptId = '';
 *   $GoogleScript->SheetName = '';
 *
 *   $var = $GoogleScript->Get();
 *
 */
//namespace Carik\GoogleScript;
include_once "lib.php";

/**
 * GoogleScript Handler
 *
 * @author Luri Darmawan <luri@carik.id>
 */
class GoogleScript
{
  protected $version = '0.0.0';

  public $DocId = '';
  public $ScriptId = '';
  public $SheetName = '';
  public $Data = [];

  public function __construct(){

  }

  public function Get(){
    $return = [];
    $URL = 'https://script.google.com/macros/s/'.$this->ScriptId.'/exec?id='.$this->DocId;
    if (!empty($this->SheetName)){
      $URL .= '&sheet='. urlencode($this->SheetName);
    }
    $args['url'] = $URL;
    $result = $this->httpGET($args);

    return $result;
  }


  function findValue($AData,$Akey,$AValue,$IsRestrict = true){
    $return = [];
    foreach ($AData as $key => $item) {
      $value = strtolower($item[$Akey]);
      if ($IsRestrict){
        if ($value == strtolower($AValue) ){
          $return[] = $item;
        }
      }else{
        if (isStringExist(strtolower($AValue),strtolower($value))){
          $return[] = $item;
        }
      }
    }
    return $return;
  }

  private function httpGET($args){
    //$dummy = file_get_contents('./dummy.json');
    //$resultJson = json_decode($dummy,true);
    //$this->Data = $resultJson['data'];
    //return $resultJson['data'];

    $content = @file_get_contents($args['url']);
    if (empty($content)) return [];
    $resultJson = json_decode($content,true);
    if ($resultJson == false) return [];

    $this->Data = $resultJson['data'];
    return $resultJson['data'];
  }

}
