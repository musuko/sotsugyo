<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'common.php'; ?>
<?php require 'dbconnect.php'; ?>
<?php
echo '<div class="page"> </div>';
//送られてきた値を変数に入れる


if (isset($_SESSION['ask'])){
	$post_name   =$_SESSION['ask']["post_name"   ];
	$post_title  =$_SESSION['ask']["post_title"  ];
	$post_message=$_SESSION['ask']["post_message"];
} else {
	$_SESSION['ask']="";
}
if (!isset($_SESSION['er'])) {
	$_SESSION['er'] ="";
}else{
	$post_name_err   =$_SESSION['er']["post_name"   ];
	$post_title_err  =$_SESSION['er']["post_title"  ];
	$post_message_err=$_SESSION['er']["post_message"];
}

//入力データを記入する

echo '<table>';
echo '<tr><td><b>お問い合わせ内容</b></td></tr>';

echo '<form action="ask_check.php" method="post">';
echo '<tr>';
echo '<td>お名前</td>';
echo '<td><input type="text" name="post_name" value="'.$_SESSION['ask']['post_name'].'">'.$_SESSION['er']['post_name'].'</td>';
echo '</tr>';//
echo '<tr>';
echo '<td>タイトル</td>';
echo '<td><input type="text" name="post_title" value="'.$_SESSION['ask']['post_title'].'">'.$_SESSION['er']['post_title'].'</td>';
echo '</tr>';
echo '<tr>';
echo '<td>本文</td>';
echo '<td><textarea name="post_message" rows="5" cols="35">'.$_SESSION['ask']['post_message'].'</textarea>'.$_SESSION['er']['post_message'].'</td>';
echo '</tr>';
echo '<tr>';
echo '<td><input type="submit" value="確認画面に進む"></td>';
echo '</tr>';
echo '</form>';
echo '</table>';




?>
<?php require 'footer.php'; ?>