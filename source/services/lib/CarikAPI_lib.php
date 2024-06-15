<?php
/**
 * Carik API Handler
 *
 * USAGE
 *   [x] Send Message
 *     $API = new Carik\API;
 *     $API->BaseURL = 'http://your-api-url/endpoint';
 *     $API->DeviceToken = 'your token';
 *     $API->SendMessage('whatsapp', 'Full Name, 'userid', 'text', []);
 *
 *   [x] Add Task
 *     // $TaskType: 0: General, 1: Inquiry, 2: Complain, 3: Appointment, 4: Spam/Scam, 5:Other
 *     // const TaskType = [ 'General', 'Inquiry', 'Complain', 'Appointment', 'Billing', 'Spam/Scam', 'Other'];
 *     $r = $API->AddTask($UserId, $fullName, '', $Subject, $Description, 'appointment', '', true, $TaskType);
 *
 *   [x] Event Log
 *     $r = $API->AddEventLog('modulename', 'sourcename', 'eventname', $request, $result);
 *
 *   [x] Token Encoder
 *     $tokens  = $API->TokenEncoder->Encode('carik adalah asistent virtual yang keren');
 *     echo "\nnumber of token: ".count($tokens);
 *
 * @date       02-08-2020 12:47
 * @category   API
 * @package    Carik
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version    0.1.00
 * @link       http://www.aksiide.com
 * @since
 * @history
 *   - add url to eventlog
 *   - add eventlog to AddTask
 *   - Token Encoder
 */

namespace Carik;

class API
{
  private $DB = false;
  public $BaseURL = '';
  public $Token = '';
  public $DeviceToken = '';
  public $ClientId = '';
  public $Helpdesk;
  public $TokenEncoder;
  public $BranchId = 0;

  public function __construct(){
    $this->Helpdesk = new APIHelpdesk();
    $this->TokenEncoder = new TokenEncoder();
  }

  public function __get($property) {
    if (property_exists($this, $property)) return $this->$property;
  }

  public function __set($property, $value) {
    if (property_exists($this, $property)) $this->$property = $value;
    if ($property=='DB') {
      //$this->Cart->DB = $value;
    }
    if ($property=='Token'){
      $this->Helpdesk->Token = $value;
    }
    if ($property=='BaseURL'){
      $this->Helpdesk->BaseURL = $value;
    }
    if ($property=='ClientId'){
      $this->Helpdesk->ClientId = $value;
    }
    return $this;
  }

  private function isPermitted(){
    if (empty($this->BaseURL)) return false;
    if (empty($this->Token)) return false;
    return true;
  }

  public function SendMessage($APlatform, $AFullName, $ATo, $AMessage, $AAction = []){
    if (empty($this->BaseURL)) return false;
    if (empty($this->DeviceToken)) return false;
    if ((empty($ATo) || empty($AMessage))) return false;

    $data['platform'] = $APlatform;
    $data['full_name'] = $AFullName;//compatibility
    $data['name'] = $AFullName;
    $data['user_id'] = $ATo;
    $data['text'] = $AMessage;
    if (@$AAction['label'] !== '') $data['label'] = @$AAction['label'];

    if (!is_null($AAction)){
      $data['type'] = 'action';
      foreach ($AAction as $key => $content) {
        if ('files' == $key){
          $data['action']['files'] = $content;
        }
        if ('button' == $key){
          $data['action']['type'] = 'button';
          $data['action']['button_title'] = 'Tampilkan';
          //if (!empty($AThumbail)){
          //    $data['action']['imageDefault'] = $AThumbail;
          //}
          $data['action']['data'] = $content;
        };
        if ('list' == $key){
          $data['action']['type'] = 'list';
          $data['action']['data'] = $content;
        };
        if ('menu' == $key){
          $data['action']['type'] = 'menu';
          $data['action']['data'] = $content;
        };

      }
    }

    $payLoad['request'] = $data;
    $payloadAsJson = json_encode($payLoad, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
    $opts = [
      "http" => [
          "method" => "POST",
          'header'=> "Content-Type: application/json\r\n"
            . "Content-Length: " . strlen($payloadAsJson) . "\r\n"
            . "token: ".$this->DeviceToken."\r\n",
          'content' => $payloadAsJson
      ],
      'ssl' => [
        "verify_peer" => false
      ]
    ];
    $context = stream_context_create($opts);
    $url = rtrim($this->BaseURL,'/\\').'/send-message/';
    $result = file_get_contents($url, false, $context);
    if (empty($result)) return false;
    $responseAsJson = @json_decode($result, true);
    return $responseAsJson;
  }

  public function AddButton( $ATitle, $AAction, $AImageURL = ''){
    $item['text'] = $ATitle;
    $item['callback_data'] = $AAction;
    if (!empty($AImageURL)){
        $item['image'] = $AImageURL;
    }
    return $item;
  }

  //size: compact, tall, full -> facebook
  public function AddButtonURL( $ATitle, $AURL, $Size = "full"){
    $item['text'] = $ATitle;
    $item['url'] = $AURL;
    $item['size'] = $Size;
    return $item;
  }

  /**
   * TASK
   */

  public function AddTask( $AUserId, $AFirstName, $ALastName, $ASubject, $ADescription, $AModule = '', $ACustomCode = '', $AIsRound = true, $ATaskType = 0){
    if (empty($this->ClientId)) return false;
    $payLoad['client_id'] = $this->ClientId;
    $payLoad['user_id'] = $AUserId;
    $payLoad['first_name'] = $AFirstName;
    $payLoad['last_name'] = $ALastName;
    $payLoad['subject'] = $ASubject;
    $payLoad['description'] = $ADescription;
    $payLoad['module'] = $AModule;
    $payLoad['type'] = $ATaskType;
    $payLoad['branch_id'] = $this->BranchId;
    $payLoad['round'] = ($AIsRound == true) ? 1 : 0;

    if (!empty($ACustomCode)) $payLoad['code'] = $ACustomCode;

    $payloadAsJson = json_encode($payLoad, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
    $opts = [
      "http" => [
          "method" => "POST",
          'header'=> "Content-Type: application/json\r\n"
            . "Content-Length: " . strlen($payloadAsJson) . "\r\n"
            . "token: ".$this->Token."\r\n",
          'content' => $payloadAsJson
      ]
    ];
    $context = stream_context_create($opts);
    $url = rtrim($this->BaseURL,'/\\').'/task/';
    $result = @file_get_contents($url, false, $context);
    @$this->AddEventLog('helpdesk', 'api', 'addtask', $payloadAsJson, $result, '', $AUserId);
    if (empty($result)) return false;
    $responseAsJson = @json_decode($result, true);
    return $responseAsJson;
  }

  /**
   * EVENT LOG
   */

   public function AddEventLog( $AModulName, $ASource, $AEventName, $ARequest, $AResult, $ACustomDate = '', $AReferenceId = '', $ATimeUsage = 0, $AURL = ''){
    if (empty($this->ClientId)) return false;
    $payLoad['client_id'] = $this->ClientId;
    $payLoad['module'] = $AModulName;
    $payLoad['source'] = $ASource;
    $payLoad['event_name'] = $AEventName;
    $payLoad['request'] = $ARequest;
    $payLoad['result'] = $AResult;
    $payLoad['url'] = $AURL;
    if (!empty($ACustomDate)){
      $payLoad['custom_date'] = $ACustomDate;
    }
    if (!empty($AReferenceId)){
      $payLoad['ref_id'] = $AReferenceId;
    }
    $payLoad['time_usage'] = $ATimeUsage;

    $payloadAsJson = json_encode($payLoad, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
    $opts = [
      "http" => [
          "method" => "POST",
          'header'=> "Content-Type: application/json\r\n"
            . "Content-Length: " . strlen($payloadAsJson) . "\r\n"
            . "token: ".$this->Token."\r\n",
          'content' => $payloadAsJson
      ]
    ];
    $context = stream_context_create($opts);
    $url = rtrim($this->BaseURL,'/\\').'/eventlog/track/'.$this->ClientId.'/';
    $result = @file_get_contents($url, false, $context);
    if (empty($result)) return false;
    $responseAsJson = @json_decode($result, true);
    return $responseAsJson;
  }

}

class TokenEncoder
{
  private bool $initialized = false;

  /** @var array<string> */
  private array $bpeCache = [];

  /** @var array<string> */
  private array $rawCharacters = [];

  /** @var array<string> */
  private array $encoder = [];

  /** @var array<array<int>> */
  private array $bpeRanks = [];

  private function initialize(): void
  {

    if ($this->initialized) {
      return;
    }
    $rawCharacters = file_get_contents(__DIR__.'/data/characters.json');
    if (false === $rawCharacters) {
      throw new \RuntimeException('Unable to load characters.json');
    }
    $this->rawCharacters = json_decode($rawCharacters, true, 512, JSON_THROW_ON_ERROR);

    $encoder = file_get_contents(__DIR__.'/data/encoder.json');
    if (false === $encoder) {
      throw new \RuntimeException('Unable to load encoder.json');
    }
    $this->encoder = json_decode($encoder, true, 512, JSON_THROW_ON_ERROR);

    $bpeDictionary = file_get_contents(__DIR__.'/data/vocab.bpe');
    if (false === $bpeDictionary) {
      throw new \RuntimeException('Unable to load vocab.bpe');
    }

    $lines = preg_split('#\r\n|\r|\n#', $bpeDictionary);
    if (false === $lines) {
      throw new \RuntimeException('Unable to split vocab.bpe');
    }

    $bpeMerges = [];
    $rawDictionaryLines = array_slice($lines, 1, count($lines), true);
    foreach ($rawDictionaryLines as $rawDictionaryLine) {
      $splitLine = preg_split('#(\s+)#', (string) $rawDictionaryLine);
      if (false === $splitLine) {
        continue;
      }
      $splitLine = array_filter($splitLine, $this->filterEmpty(...));
      if ([] !== $splitLine) {
        $bpeMerges[] = $splitLine;
      }
    }

    $this->bpeRanks = $this->buildBpeRanks($bpeMerges);
    $this->initialized = true;

  }

  /** @return array<string> */
  public function encode(string $text): array
  {
    if (empty($text)) {
      return [];
    }

    $this->initialize();

    preg_match_all("#'s|'t|'re|'ve|'m|'ll|'d| ?\p{L}+| ?\p{N}+| ?[^\s\p{L}\p{N}]+|\s+(?!\S)|\s+#u", $text, $matches);
    if (!isset($matches[0]) || 0 == (is_countable($matches[0]) ? count($matches[0]) : 0)) {
      return [];
    }

    $bpeTokens = [];
    foreach ($matches[0] as $token) {
      $token = mb_convert_encoding((string) $token, "UTF-8", "ISO-8859-1");
      $characters = mb_str_split($token, 1, 'UTF-8');

      $resultWord = '';
      foreach ($characters as $char) {
        if (!isset($this->rawCharacters[$this->characterToUnicode($char)])) {
          continue;
        }
        $resultWord .= $this->rawCharacters[$this->characterToUnicode($char)];
      }

      $newTokensBpe = $this->bpe($resultWord);
      $newTokensBpe = explode(' ', $newTokensBpe);
      foreach ($newTokensBpe as $newBpeToken) {
        $encoded = $this->encoder[$newBpeToken] ?? $newBpeToken;
        if (isset($bpeTokens[$newBpeToken])) {
          $bpeTokens[] = $encoded;
        } else {
          $bpeTokens[$newBpeToken] = $encoded;
        }
      }
    }

    return array_values($bpeTokens);
  }

  private function filterEmpty(mixed $var): bool
  {
    return null !== $var && false !== $var && '' !== $var;
  }

  private function characterToUnicode(string $characters): int
  {
    $firstCharacterCode = ord($characters[0]);

    if ($firstCharacterCode <= 127) {
      return $firstCharacterCode;
    }

    if ($firstCharacterCode >= 192 && $firstCharacterCode <= 223) {
      return ($firstCharacterCode - 192) * 64 + (ord($characters[1]) - 128);
    }

    if ($firstCharacterCode >= 224 && $firstCharacterCode <= 239) {
      return ($firstCharacterCode - 224) * 4096 + (ord($characters[1]) - 128) * 64 + (ord($characters[2]) - 128);
    }

    if ($firstCharacterCode >= 240 && $firstCharacterCode <= 247) {
      return ($firstCharacterCode - 240) * 262144 + (ord($characters[1]) - 128) * 4096 + (ord($characters[2]) - 128) * 64 + (ord($characters[3]) - 128);
    }

    if ($firstCharacterCode >= 248 && $firstCharacterCode <= 251) {
      return ($firstCharacterCode - 248) * 16_777_216 + (ord($characters[1]) - 128) * 262144 + (ord($characters[2]) - 128) * 4096 + (ord($characters[3]) - 128) * 64 + (ord($characters[4]) - 128);
    }

    if ($firstCharacterCode >= 252 && $firstCharacterCode <= 253) {
      return ($firstCharacterCode - 252) * 1_073_741_824 + (ord($characters[1]) - 128) * 16_777_216 + (ord($characters[2]) - 128) * 262144 + (ord($characters[3]) - 128) * 4096 + (ord($characters[4]) - 128) * 64 + (ord($characters[5]) - 128);
    }

    if ($firstCharacterCode >= 254) {
      return 0;
    }

    return 0;
  }

  /**
   * @param array<array<mixed>> $bpes
   *
   * @return array<array<int>>
   */
  private function buildBpeRanks(array $bpes): array
  {
    $result = [];
    $rank = 0;
    foreach ($bpes as $bpe) {
      if (!isset($bpe[1], $bpe[0])) {
        continue;
      }

      $result[$bpe[0]][$bpe[1]] = $rank;
      ++$rank;
    }

    return $result;
  }

  /**
   * Return set of symbol pairs in a word.
   * Word is represented as tuple of symbols (symbols being variable-length strings).
   *
   * @param array<int, string> $word
   *
   * @return mixed[]
   */
  private function buildSymbolPairs(array $word): array
  {
    $pairs = [];
    $previousPart = null;
    foreach ($word as $i => $part) {
      if ($i > 0) {
          $pairs[] = [$previousPart, $part];
      }

      $previousPart = $part;
    }

    return $pairs;
  }

  private function bpe(string $token): string
  {
    if (isset($this->bpeCache[$token])) {
      return $this->bpeCache[$token];
    }

    $word = mb_str_split($token, 1, 'UTF-8');
    $initialLength = count($word);
    $pairs = $this->buildSymbolPairs($word);
    if ([] === $pairs) {
      return $token;
    }

    while (true) {
      $minPairs = [];
      foreach ($pairs as $pair) {
        if (isset($this->bpeRanks[$pair[0]][$pair[1]])) {
          $rank = $this->bpeRanks[$pair[0]][$pair[1]];
          $minPairs[$rank] = $pair;
        } else {
          $minPairs[10e10] = $pair;
        }
      }

      $minPairsKeys = array_keys($minPairs);
      sort($minPairsKeys, SORT_NUMERIC);
      $minimumKey = $minPairsKeys[0] ?? null;

      $bigram = $minPairs[$minimumKey];
      if (!isset($this->bpeRanks[$bigram[0]][$bigram[1]])) {
        break;
      }

      $first = $bigram[0];
      $second = $bigram[1];
      $newWord = [];
      $i = 0;
      while ($i < count($word)) {
        $j = $this->indexOf($word, $first, $i);
        if (-1 === $j) {
          $newWord = [
            ...$newWord,
            ...array_slice($word, $i, null, true),
          ];
          break;
        }

        $slicer = $i > $j || 0 === $j ? [] : array_slice($word, $i, $j - $i, true);

        $newWord = [
          ...$newWord,
          ...$slicer,
        ];
        if (count($newWord) > $initialLength) {
          break;
        }

        $i = $j;
        if ($word[$i] === $first && $i < count($word) - 1 && $word[$i + 1] === $second) {
          $newWord[] = $first.$second;
          $i += 2;
        } else {
          $newWord[] = $word[$i];
          ++$i;
        }
      }

      if ($word === $newWord) {
        break;
      }

      $word = $newWord;
      if (1 === count($word)) {
        break;
      }

      $pairs = $this->buildSymbolPairs($word);
    }

    $word = implode(' ', $word);
    $this->bpeCache[$token] = $word;

    return $word;
  }

  /**
   * @param array<int, string> $array
   */
  private function indexOf(array $array, string $searchElement, int $fromIndex): int
  {
    $slicedArray = array_slice($array, $fromIndex, preserve_keys: true);
    $indexed = array_search($searchElement, $slicedArray);
    return false === $indexed ? -1 : $indexed;
  }

}

class APIHelpdesk
{
  public $DB = false;
  public $ClientId = 0;
  public $BaseURL = "";
  public $Token = '';

  public function __construct(){
  }

  public function GetClientTickets($AUserId){
    if (empty($AUserId)) return false;
    $user = explode('-', $AUserId);
    $url = rtrim($this->BaseURL,'/\\')."/task/?client_id=$this->ClientId&code=&user_id=$user[1]";
    $result = @file_get_contents($url);
    if (empty($result)) return false;
    $responseAsJson = @json_decode($result, true);
    if (@$responseAsJson['code'] != 0) return false;
    return @$responseAsJson['data']['tasks'];
  }

  public function AddNPS($AParameters = [], $AModule = ''){
    if (empty($AParameters)) return false;
    if (empty($this->ClientId)) return false;
    $date = date("Y-m-d H:i:s");
    $dateAsInteger = strtotime($date);


    $payloadAsJson = json_encode($AParameters, JSON_UNESCAPED_UNICODE+JSON_INVALID_UTF8_IGNORE);
    $opts = [
      "http" => [
          "method" => "POST",
          'header'=> "Content-Type: application/json\r\n"
            . "Content-Length: " . strlen($payloadAsJson) . "\r\n"
            . "token: ".$this->Token."\r\n",
          'content' => $payloadAsJson
      ]
    ];
    $context = stream_context_create($opts);
    $url = rtrim($this->BaseURL,'/\\').'/helpdesk/nps/' . $this->ClientId . "/?module=$AModule";
    $result = @file_get_contents($url, false, $context);
    if (empty($result)) return false;
    $responseAsJson = @json_decode($result, true);
    return $responseAsJson;
  }

}
