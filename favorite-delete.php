<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require('dbconnect.php'); ?>

<?php
if (isset($_SESSION['customer'])) {
	$sql = $pdo->prepare('DELETE FROM favorite WHERE customer_id=? AND product_id=?');	//favoriteテーブルから削除
	$sql->execute([$_SESSION['customer']['id'], $_REQUEST['id']]);	//カスタマーIDと（商品)ID
	echo '<div class="page"> </div>';
	echo '<div class="left2">';
	echo 'お気に入りから商品を削除しました。';
	echo '</div>';
}
require 'favorite.php';
?>
<?php require 'footer.php'; ?>
