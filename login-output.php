<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require('dbconnect.php'); ?>

<?php
//ログイン
echo '<div class=page> </div>';
echo '<div class="left2"><p><b>いらっしゃいませ、',
$_SESSION['customer']['name1'],'さん。</b></p></div>';
require "top.php";
?>
<?php require 'footer.php'; ?>