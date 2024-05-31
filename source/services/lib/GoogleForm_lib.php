<?php
/**
 * USAGE:
 *   $GFA = new GoogleFormAutomation;
 *   $GFA->FormId = '______';
 *   $postData = [...];
 *   $GFA->Submit($postData);
 *
 * ref:
 *   https://gist.github.com/unforswearing/7b01591138c7d3ca27f1b50182573233
 */

require_once "simplehtmldom_2_0/simple_html_dom.php";

/**
 * Google Form Automation
 *
 * @author Luri Darmawan <luri@carik.id>
 */
class GoogleFormAutomation
{
  public $FormId = '';

  public function __construct(){
  }

  //https://docs.google.com/forms/d/e/1FAIpQLScJqX5YrRP8Q6sQsx3dCvTjwkv0byizdD2_IvJM5i2CAz-GPw/formResponse?&entry.244206211=35&submit=SUBMIT
  public function Submit($AData){
    $url = 'https://docs.google.com/forms/d/e/'.$this->FormId.'/formResponse?submit=SUBMIT&';// . http_build_query($AData);
    $postData = http_build_query($AData);

    //$headers[] = 'Content-Type:application/json';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    //curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($curl);
    curl_close($curl);

    if ($result==false){
      return false;
    }

    if (strpos($result, 'Halaman Tidak Ditemukan') !== false) return false;
    if (strpos($result, 'saat ini tidak dapat membuka file') !== false) return false;

    return true;
  }

  public function QuestionList(){
    if (empty($this->FormId)) return false;
    $url = "https://docs.google.com/forms/d/e/$this->FormId/viewform";
    $html = file_get_html($url);
    if (empty($html)) return false;

    $questions = array();
    foreach ($html->find('div[role=heading]') as $question) {
      $questions[] = $question->plaintext;
    }
    return $questions;
  }

}
