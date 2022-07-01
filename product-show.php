<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>
<?php
echo '<div class="page"> </div>';
$admin = $_SESSION['admin'] ?? '';
if ($admin != "") {
	if ($_SESSION['admin']['authority'] === 'rw' || $_SESSION['admin']['authority'] === 'r') {
require "product2.php";
	} else {
		echo 'このログイン名は、閲覧権限を有していません。';
	}
} else {
	echo '管理者ログインをお願いします。';
	echo 'ログインして下さい。';
	echo '<form action="login-output2.php" method="post">
    ログイン名<input type="text" name="login"><br>
    パスワード<input type="password" name="password"><br>
    <input type="submit" value="ログイン">
    </form>';
}
?>
<?php require 'footer.php'; ?>