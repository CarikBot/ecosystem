<?php
date_default_timezone_set('Asia/Jakarta');
const USER_ID = '5-test';
const FULL_NAME = 'Nama Lengkap';

$arr['post_date'] = date('y-m-d H:i:s');// '2022-04-17 13:01:47';
$arr['user_id'] = USER_ID;
$arr['full_name'] = FULL_NAME;
$arr['client_id'] = '0';
$arr['FullName'] = FULL_NAME; // old compatibility
$arr['ClientID'] = '0';

$data['jenisKelamin_t'] = 'Laki-laki';
$data['jenisKelamin'] = '1';
$data['institution'] = 'testcli';
$data['submit'] = 'OK';

//a1_t a1
$i = random_int ( 1, 7 );

$content = file_get_contents('mbti16.json');
$dataTest = json_decode($content, true);
$index = 1;
foreach ($dataTest as $item) {
  $data["a$index"."_t"] = $item['text'];
  $data["a$index"] = random_int ( 1, 7 );
  $index++;
}


$arr['data'] = $data;

$dataAsJsonString = json_encode($arr, JSON_PRETTY_PRINT);
die($dataAsJsonString);