<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require('dbconnect.php'); ?>

<?php

if (isset($_SESSION['customer'])) {

	$sql = $pdo->prepare('SELECT pu.purchase_id, pr.id, pr.picmini1, pr.name,
	pd.price_at, pd.count, pu.price, pu.tax, pu.purchase_date
	FROM purchase pu, product pr, purchase_detail pd
	WHERE pu.purchase_id=pd.purchase_id AND pr.id=pd.product_id
	AND pu.customer_id=?
	ORDER BY pu.purchase_id DESC, pr.id');

	$sql->bindParam(1, $_SESSION['customer']['id'], PDO::PARAM_INT);
	$sql->execute();

	echo '<div class="page"> </div>';
	echo '<table class="table-history">';
	echo '<tr><th>購入番号</th><th>商品</th><th>商品名</th>
			<th>価格</th><th>個数</th><th>レビュー</th><th>小計</th></tr>';
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

			echo '<tr><td>小計</td><td></td><td></td><td></td><td></td><td></td>' .
				'<td>' . number_format($subtotal_stock) . '</td>';

			echo '<tr><td>消費税</td><td></td><td></td><td></td><td></td><td></td>' .
				'<td>' . number_format($tax) . '</td>';

			//合計をだす
			$total = $subtotal_stock + $tax;
			echo '<tr><td>合計</td><td></td><td></番号td><td></td><td></td><td></td><td>' .
				number_format($total) . '</td></tr>';

			echo '<tr><td>購入日</td><td></td><td></td>
					<td></td><td></td><td></td><td>' .
				date('Y/m/d', strtotime($purchase_date_stock)) . '
					</td></tr></td></tr>';

			echo '</table><table class="table-history">';

			echo '<tr><th>購入番号</th><th>商品</th><th>商品名</th>
					<th>価格</th><th>個数</th><th>レビュー</th><th>小計</th></tr>';

			$subtotal_stock = 0;
			$total = 0;

			$purchaseid_check = $value['purchase_id'];
		}

		//商品ごとの小計を出す
		$eachtotal = $value['price_at'] * $value['count'];

		echo '<tr><td>' . $value['purchase_id'] . '</td>
				<td><img src="image/' . $value['picmini1'] . '"></img></td>
				<td><a href="detail.php?id=' . $value['id'] . '">' . $value['name'] . '</a></td>
				<td>' . number_format($value['price_at']) . '</td>
				<td>' . $value['count'] . '</td>
				<td><a href="review-input.php?product_id=', $value['id'],
						'&purchase_id=', $value['purchase_id'], '">投稿</a></td>
				<td>' . number_format($eachtotal) . '</td></tr>';

		//データを変数に格納しておく
		//小計
		$subtotal_stock += $eachtotal;

		//消費税
		$tax = $value['tax'];

		//購入日
		$purchase_date_stock = $value['purchase_date'];
	}


	echo '<tr><td>小計</td><td></td><td></td><td></td><td></td><td></td>' .
		'<td>' . number_format($subtotal_stock) . '</td>';

	echo '<tr><td>消費税</td><td></td><td></td><td></td><td></td><td></td>' .
		'<td>' . number_format($value['tax']) . '</td>';

	//合計をだす
	$total = $subtotal_stock + $value['tax'];
	echo '<tr><td>合計</td><td></td><td></td><td></td><td></td><td></td><td>' .
		number_format($total) . '</td></tr>';

	echo '<tr><td>購入日</td><td></td><td></td>
			<td></td><td></td><td></td><td>' .
		date('Y/m/d', strtotime($value['purchase_date'])) . '</td></tr>';

	echo '</table>';
	echo '<br>';
	echo '</div>';

} else {
	echo '<div class="page"> </div>';
	echo '<div class="left2">';
	echo '<p>購入履歴を表示するには、ログインして下さい。</p>';
	echo '<form action="login-output.php" method="post">
    ログイン名<input type="text" name="login"><br>
    パスワード<input type="password" name="password"><br>
    <p><input type="submit" value="ログイン"></p>
    </form>';
	echo '</div>';
}

?>
<?php require 'footer.php'; ?>


