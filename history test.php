<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require('dbconnect.php'); ?>

<?php

if (isset($_SESSION['customer'])) {

	$sql = $pdo->prepare('SELECT pu.purchase_id, pr.picmini1, pd.tax, pr.picmini1, pr.id, pr.name, pd.price_at, pd.count , pd.tax, pd.date
FROM purchase_detail pd, purchase pu, product pr
WHERE pd.purchase_id = pu.purchase_id AND pd.product_id = pr.id
AND pu.customer_id = 1 ORDER BY pu.purchase_id, pr.id');
	$sql->bindParam(1, $_SESSION['customer']['id'], PDO::PARAM_INT);
	$sql->execute();
	echo '<table>';
	echo '<tr><th>購入番号</th><th>商品番号</th><th>商品</th><th>商品名</th>
<th>価格</th><th>個数</th><th>消費税</th><th>小計</th></tr>';

	//変数を準備する
	//初期処理
	$sw = 0;
	//合計
	$total = 0;

	foreach ($sql as $key => $value) {
		//初期処理をする
		if ($sw === 0) {
			//比較用の変数に値をセットする
			$purchaseid_check = $value['purchase_id'];
			//$swの値を切り替える
			$sw = 1;
		}

		if ($purchaseid_check != $value['purchase_id']) {
			echo '<tr><td>合計</td><td></td><td></td><td></td><td></td><td></td><td></td><td>' . number_format($total) . '</td></tr>';
			echo '<tr><td>購入日</td><td></td><td></td><td></td><td></td><td></td><td></td><td>' . date('Y/m/d',strtotime($value['date'])). '</td></tr>';
			echo '</table><hr><table>';
			echo '<tr><th>購入番号</th><th>商品番号</th><th>商品</th><th>商品名</th>
				<th>価格</th><th>個数</th><th>消費税</th><th>小計</th></tr>';

			$total = 0;
			$purchaseid_check = $value['purchase_id'];
		}
		echo	'<tr><td>' . $value['purchase_id'] . '</td><td>' . $value['id'] . '</td>
			<td><img src="image/' . $value['picmini1'] . '"></img></td><td><a href="detail.php?id='.$value['id'].'">' . $value['name'] . '</a></td>
			<td>' . number_format($value['price_at']) . '</td><td>' . $value['count'] . '</td><td>' . number_format($value['tax']) . '</td>
			<td>' . number_format(($value['price_at'] * $value['count'] + $value['tax'])). '</td></tr>';

		$total += $value['price_at'] * $value['count'] + $value['tax'];
	}

	echo '<tr><td>合計</td><td></td><td></td><td></td><td></td><td></td><td></td><td>' . number_format($total) . '</td></tr>';
	echo '<tr><td>購入日</td><td></td><td></td><td></td><td></td><td></td><td></td><td>' . date('Y/m/d',strtotime($value['date'])). '</td></tr>';
	echo '</table>';
	echo '<hr>';
} else {
	echo '購入履歴を確認するためには、ログインして下さい。';
}
?>
<?php require 'footer.php'; ?>


