<?php
/**
 * USAGE
 *   curl "http://localhost/services/ecosystem/community/php-indonesia/ajari/" -d "keyword=bot"
 * 
 * 
 * @date       23-03-2020 13:19
 * @category   community
 * @package    PHP Indonesia Ajari Koding
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include_once "../../config.php";
include_once "../../lib/lib.php";
include_once "PHPID_lib.php";

$Text = "*Ajari Koding* merupakan kumpulan berbagai sumber daya untuk belajar koding dari hasil karya para kreator lokal yang terpercaya dan telah dikurasi oleh komunitas PHPID.

Untuk mencari informasi ajari, silakan ketik pesan dengan format:
```ajari koding [keyword]```
misal:
```ajari koding android flutter```
";

$keyword = @$_POST['keyword'];
if (empty($keyword)) Output(0, $Text);

$results = PHPID::AjariSearchByTag($keyword);
if (!$results) Output(0, 'Maaf, informasi Ajari Koding tidak ditemukan.');

$Text = "Sumber daya untuk belajar koding dari hasil karya para kreator lokal yang terpercaya dan telah dikurasi oleh komunitas PHPID.\n";
foreach ($results as $key => $item) {
  $title = $item['title'];
  $creator = $item['creator'];
  $url = $item['url'];
  $description = $item['description'];
  $business_model = $item['business_model'];
  $tipe = $item['tipe'];
  $rating = $item['rating'];

  $Text .= "\n[$title]($url)";
  $Text .= "\n$description";
  $Text .= "\n";
}

$Text .= "\nSumber: [Ajaro Koding](https://github.com/phpid-jakarta/ajari-koding)";

//die($Text);
Output(0, $Text);
