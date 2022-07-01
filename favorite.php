<?php require('dbconnect.php'); ?>

<?php	//P296

//カスタマーセッションが定義されていた場合。= ログインされている場合。
if (isset($_SESSION['customer'])) {

	/*favoriteテーブル(customer_id, product_id)、productテーブル(id,name,price)から、
	カスタマーIDの人、product_idのすべての情報を選択*/
	//customer_idがログインしている人、かつ、product_idがproductテーブルのidの条件で
	$sql = $pdo->prepare('SELECT * FROM favorite, product
			WHERE customer_id=? AND product_id=product.id
			ORDER BY date DESC');
	$sql->execute([$_SESSION['customer']['id']]);

	//取り出したデータを変数に代入する
	$favorite = $sql->fetchAll();

	//データが登録されている場合
	if (!empty($favorite)) {

		//お気に入りの一覧を表示する
		echo '<div class=page> </div>';
		echo '<table class="table-favorite">';
		echo '<th>登録日</th><th>商品</th><th>商品名</th><th>価格</th><th>個数</th><th>購入</th><th></th>';

		foreach ($favorite as $row) {

			$id = $row['id'];
			echo '<tr>';
			echo '<td>', $row['date'], '</td>';
			echo '<td><p><img src="image/' .$row['picmini1'].'" ></img></p></td>';
			echo '<td><a href="detail.php?id=' . $id . '">' . $row['name'] . '</a></td>';	//詳細へのリンク
			echo '<td>', number_format($row['price']), '</td>';
			echo '<form action="cart-insert.php" method="post">';
			echo '<input type="hidden" name="id" value="', $id, '">';
			echo '<input type="hidden" name="picmini1" value="', $row['picmini1'], '">';
			echo '<input type="hidden" name="name" value="', $row['name'], '">';
			echo '<input type="hidden" name="price" value="', $row['price'], '">';
			echo '<td><input type="number" name="count" value="', $product['count'],
			'" min="1" style ="font-size:20px; width:60px; height:30px";></td>';
			echo '<td><button type="submit" name="submit_f" value="'.$id.'">カートに入れる</button></td>';
			echo '</form>';
			echo '<td><a href="favorite-delete.php?id=', $id, '">削除</a></td>';	//削除ファイルへのリンク

			echo '</tr>';
		}
		echo '</table>';

	//データが登録されていない場合
	} else {

		echo '<div class="page"> </div>';
		echo '<div class="left2">お気に入りに商品が登録されていません。</div>';

	}

//ログインしていない場合
} else {

	echo '<div class=page> </div>';
	echo '<div class="left2">';
	echo '<p>お気に入りを表示するには、ログインしてください。<p/>';
	echo '<form action="login-relay.php" method="post">
    ログイン名<input type="text" name="login"><br>
    パスワード<input type="password" name="password"><br>
    <p><input type="submit" value="ログイン"></p>
    </form>';
	echo '</div>';

}
