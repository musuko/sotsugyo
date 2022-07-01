<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require('dbconnect.php'); ?>

<?php
//ログインしている場合
if (isset($_SESSION['customer'])) {

	//顧客IDを変数に代入する
	$customer_id = $_SESSION['customer']['id'];

	//顧客IDに一致するお気に入りのデータを取り出す
	$sql = $pdo->prepare ('SELECT * FROM favorite WHERE customer_id=?');
	$sql->bindParam (1, htmlspecialchars($customer_id), PDO::PARAM_STR);
	$sql->execute();
	$favorite = $sql->fetchAll();

	//処理用の変数を用意する
	$sw = 0;

	foreach ($favorite as $row) {

		//登録したい商品IDと、既に登録されているIDが同じなら
		if ($row['product_id'] == $_REQUEST['id']) {
			$sw = 1;
		}

	}

	//お気に入り未登録の商品の場合
	if ($sw == 0) {

	//商品IDを変数に代入する
	$product_id = $_REQUEST['id'];
		$date = date('Ymd');

	$sql = $pdo->prepare('INSERT INTO favorite values(?,?,?)');	//favoriteテーブルに挿入
	$sql->bindParam (1, htmlspecialchars($customer_id), PDO::PARAM_STR);
	$sql->bindParam (2, htmlspecialchars($product_id), PDO::PARAM_STR);
	$sql->bindParam (3, htmlspecialchars($date), PDO::PARAM_INT);
	$sql->execute();

	echo '<div class="page"> </div>';
	echo '<div class="left2">';
	echo 'お気に入りに商品を追加しました。';
	echo '</div>';
	require 'favorite.php';

	//お気に入りに登録済の商品の場合
	} else {

	echo '<div class="page"> </div>';
	echo '<div class="left2">';
	echo '<br>既にお気に入りに登録されています。';
	echo '</div>';
	require 'favorite.php';
	}

//ログインしていない場合
} else {

	echo '<div class="page"> </div>';
	echo '<div class="left2">';
	echo '<br>お気に入りに商品を追加するには、ログインしてください。';
	echo '</div>';
}

?>
<?php require 'footer.php'; ?>