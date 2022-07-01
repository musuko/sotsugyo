<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'common.php'; ?>
<?php require 'dbconnect.php'; ?>
<div class="page"> </div>
<?php
$date = date('Ymd');
//変数にチェック済みの入力内容を代入する
	$post_name   =$_SESSION['ask']["post_name"   ];
	$post_title  =$_SESSION['ask']["post_title"  ];
	$post_message=$_SESSION['ask']["post_message"];
	$customer_id = $_SESSION['customer']['id'];
$sql = $pdo->prepare('INSERT INTO ask SET post_name=?, post_title=?, post_message=?,
customer_id=?, date=?');
$sql->bindParam(1, $post_name, PDO::PARAM_STR );
$sql->bindParam(2, $post_title, PDO::PARAM_STR );
$sql->bindParam(3, $post_message, PDO::PARAM_STR );
$sql->bindParam(4, $customer_id, PDO::PARAM_INT );
$sql->bindParam(5, $date, PDO::PARAM_INT );
$sql->execute();
unset($_SESSION['ask']);

echo '<p>お問い合わせ内容を送信しました。</p';
?>