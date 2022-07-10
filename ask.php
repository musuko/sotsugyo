<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'common.php'; ?>
<?php require 'dbconnect.php'; ?>
<?php
echo '<div class="page"> </div>';
//送られてきた値を変数に入れる
$post_name = $post_title = $post_message = "";
$post_name_err = $post_title_err = $post_message_err = "";

if (isset($_SESSION['ask'])) {
	$post_name   = $_SESSION['ask']["post_name"];
	$post_title  = $_SESSION['ask']["post_title"];
	$post_message = $_SESSION['ask']["post_message"];
}
if (isset($_SESSION['er'])) {
	$post_name_err   = $_SESSION['er']["post_name"];
	$post_title_err  = $_SESSION['er']["post_title"];
	$post_message_err = $_SESSION['er']["post_message"];
}

//入力データを記入する

echo '<div class="left2">';
echo '<table class="table-ask">';
echo '<tr><th class="title-ask"><b>お問い合わせをする</b></th></tr>';
echo '<tr><th></th><tr>';
echo '<tr><th></th><tr>';

echo '<form action="ask_check.php" method="post">';
echo '<tr>';
echo '<th>お名前</th>';
echo '<td><input type="text" name="post_name" value="' . $post_name . '">' . $post_name_err . '</td>';
echo '</tr>'; //
echo '<tr>';
echo '<th>タイトル</th>';
echo '<td><input type="text" name="post_title" value="' . $post_title . '">' . $post_title_err . '</td>';
echo '</tr>';
echo '<tr>';
echo '<th>本文</th>';
echo '<td><textarea name="post_message" rows="5" cols="35">' . $post_message . '</textarea>' . $post_message_err . '</td>';
echo '</tr>';
echo '<tr>';
echo '<th><input type="submit" value="確認画面に進む"></th>';
echo '</tr>';
echo '</form>';
echo '</table>';
echo '</div>';
unset($_SESSION['ask']);
unset($_SESSION['er']);

?>
<?php require 'footer.php'; ?>