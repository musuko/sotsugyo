<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'common.php'; ?>
<?php require 'dbconnect.php'; ?>
<div class="page"> </div>
<p>記入内容をご確認後、<br>
確認ボタンを押してください。</p>
<?php
//変数にチェック済みの入力内容を代入する
	$post_name   =$_SESSION['ask']["post_name"   ];
	$post_title  =$_SESSION['ask']["post_title"  ];
	$post_message=$_SESSION['ask']["post_message"];

	echo '<form action="ask_finish.php" method="post">';
echo '<table>';

echo '<tr><td align="center"><b>お名前</b></td><td>';
echo h($post_name);
echo '</td></tr>';

echo '<tr><td align="center"><b>タイトル</b></td><td>';
echo h($post_title);
echo '</td></tr>';

echo '<tr><td align="center"><b>本文</b></td><td>';
echo h($post_message);
echo '</td></tr>';
echo '</table>';
echo '<input type="submit" value="確定">';
echo ' ';
echo '<a href="ask.php"><input type="button" value="前の画面に戻る"></a>';
echo '</form>';
echo '<br>';
unset($_SESSION['er']);
?>
<?php require 'footer.php'; ?>