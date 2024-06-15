<?php
// force post data from json request content
$RequestContent = file_get_contents('php://input');
if (!empty($RequestContent)){
  $RequestContentAsJson = json_decode($RequestContent, true);
  foreach ($RequestContentAsJson['data'] as $key => $value) {
    $_POST[$key] = $value;
  }
}

$headerList = array("cache-control", "User-Agent", "Accept", "Host", "accept-encoding", "content-type", "content-length", "Connection", "Content-Type", "Content-Length");

$output = "*JSON ECHO TESTER*";
$output .= " -- ⭐️🌟✨🔆🔅🕶👓⭕️🚫⛔️📛💤";
$output = $output . "\n";
$output = $output . "\n*GET:*";
foreach ($_GET as $key => $value) {
	$output = $output . "\n$key=$value";
}
$output = $output . "\n";
$output = $output . "\n*POST:*";
foreach ($_POST as $key => $value) {
	if ('pattern'==$key) continue;
	$value = urldecode( $value);
	$output = $output . "\n$key=$value";
}

$output = $output . "\n";
$output = $output . "\n*HEADER:*";
$headers = apache_request_headers();
foreach ($headers as $key => $value) {
	if (!in_array($key, $headerList))
		$output = $output . "\n$key=$value";
}
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$output .= "\n\nUserAgent: " . $userAgent;

// json code
$jsonAsString = json_encode($RequestContentAsJson, JSON_PRETTY_PRINT);
$output .= "\n\nRequest Content:\n";
$output .= "```$jsonAsString```";
$output .= "\n> Sebagian field mungkin sudah _deprecated_, silakan hubungi Tim Developer Carik";

$output = str_replace("_","\_", $output);
$RESULT['code'] = 0;
$RESULT['get'] = $_GET;
$RESULT['post'] = $_POST;
$RESULT['header'] = apache_request_headers();
$RESULT['text'] = $output;

$output = json_encode( $RESULT, JSON_UNESCAPED_UNICODE);
header('Content-Type: application/json');
echo $output;
