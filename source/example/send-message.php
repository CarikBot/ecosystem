<?php
date_default_timezone_set('Asia/Jakarta');

const CARIK_API_BASEURL = 'https://api.carik.id/';
const CARIK_API_TOKEN = ''; // YOUR CARIK TOKEN

$recipient = ""; // recipient phone number, format: 62.........
$message = "test: ".date("H:i:s"); // message

$postData = [
  "request" => [
    "platform]" => "whatsapp",
    "user_id" => $recipient,
    "text" => $message
  ]
];
$postData = json_encode($postData);

$curl = curl_init();
curl_setopt_array($curl, [
  CURLOPT_URL => CARIK_API_BASEURL."send-message/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 10,
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $postData,
  CURLOPT_HTTPHEADER => [
    "content-type: application/json",
    "token: ".CARIK_API_TOKEN
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
