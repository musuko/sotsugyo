<?php
$postcode = 7300031;	//郵便番号
$url = "http://zipcloud.ibsnet.co.jp/api/search?zipcode=";		//郵便番号検索サイト
$url = $url.$postcode;	//検索条件追加
$json = file_get_contents($url);	//検索結果を$jsonに入れる
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');	//utf8にエンコード
$arr = json_decode($json,true);		//jsonをでコード
echo '<pre>';
var_dump($arr);		//全体表示
var_dump($arr['results']['0']);		//住所表示

echo '</pre>'
?>