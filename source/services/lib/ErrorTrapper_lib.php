<?php
/**
* File: ErrorTrapper_lib.php
* Error Trapper File
*
* @date       20-09-2017 22:33
* @category   AksiIDE
* @package    AksiIDE
* @subpackage
* @copyright  Copyright (c) 2013-endless AksiIDE
* @license
* @version
* @link       http://www.aksiide.com
* @since
*/

// Error Handler
function exceptions_error_handler($ASeverity, $AMessage, $AFilename, $ALineNo) {
  //if ($severity>E_WARNING) exit;
  $dir = dirname( dirname(__FILE__));
  $package = str_replace($dir,'',$AFilename);
  $packages = explode('/',$package);
  $category = $packages[1];
  $packageName = $packages[2];
  $output['code'] = 500;
  $output['text'] = "Maaf, informasi tidak ditemukan karena rantai ekosistem '$packageName' sedang terganggu.\nSilakan coba lagi nanti yaa";
  $output = json_encode($output, JSON_UNESCAPED_UNICODE);
  @header("Content-type:application/json");
  die($output);
  //throw new ErrorException($AMessage, 0, $ASeverity, $AFilename, $ALineNo);
}
set_error_handler('exceptions_error_handler',E_WARNING);

