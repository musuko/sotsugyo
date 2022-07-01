<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>
<?php require 'common.php'; ?>
<?php require('dbconnect.php'); ?>


<?php
echo '<div class="page"> </div>';
//閲覧権限確認
if ($_SESSION['admin']['authority'] === 'rw' || $_SESSION['admin']['authority'] === 'r') {
	//入力部分フィルター
	$id               = filter_input(INPUT_POST, 'id');
	$product_id       = filter_input(INPUT_POST, 'product_id');
	$sale_price       = filter_input(INPUT_POST, 'sale_price');
	$start_date       = filter_input(INPUT_POST, 'start_date');
	$end_date         = filter_input(INPUT_POST, 'end_date');
	$updated_at       = filter_input(INPUT_POST, 'updated_at');
	$updated_by_id    = filter_input(INPUT_POST, 'updated_by_id');
	$updated_contents = filter_input(INPUT_POST, 'updated_contents');
	$button           = filter_input(INPUT_POST, 'button');
	$date             = date('Ymd');

	//追加ボタンの場合
	if ($button === "ins") {
		$sql = $pdo->prepare('INSERT INTO sale_period
 SET product_id=?, sale_price=?, start_date=?, end_date=?,
  updated_at=?, updated_by_id=?, updated_contents=?');
		$sql->bindParam(1, $product_id, PDO::PARAM_INT);
		$sql->bindParam(2, $sale_price, PDO::PARAM_INT);
		$sql->bindParam(3, $start_date, PDO::PARAM_INT);
		$sql->bindParam(4, $end_date, PDO::PARAM_INT);
		$sql->bindParam(5, $date, PDO::PARAM_INT);
		$sql->bindParam(6, $_SESSION['admin']['id'], PDO::PARAM_INT);
		$sql->bindParam(7, $updated_contents, PDO::PARAM_STR);
		$sql->execute();

		//更新ボタンの場合
	} elseif ($button === "upd") {
		$sql = $pdo->prepare('UPDATE sale_period
	SET product_id=?, sale_price=?, start_date=?, end_date=?,
	 updated_at=?, updated_by_id=?, updated_contents=?
	 WHERE id=?');
		$sql->bindParam(1, $product_id, PDO::PARAM_INT);
		$sql->bindParam(2, $sale_price, PDO::PARAM_INT);
		$sql->bindParam(3, $start_date, PDO::PARAM_INT);
		$sql->bindParam(4, $end_date, PDO::PARAM_INT);
		$sql->bindParam(5, $date, PDO::PARAM_INT);
		$sql->bindParam(6, $_SESSION['admin']['id'], PDO::PARAM_INT);
		$sql->bindParam(7, $updated_contents, PDO::PARAM_STR);
		$sql->bindParam(8, $id, PDO::PARAM_INT);
		$sql->execute();
		//更新ボタンの場合
	} elseif ($button === "del") {
		$sql = $pdo->prepare('DELETE FROM sale_period WHERE id=?');
		$sql->bindParam(1, $id, PDO::PARAM_INT);
		$sql->execute();
	}


	//特売情報操作確認
	//権限がrwの場合、追加フォーム表示
	if ($_SESSION['admin']['authority'] === 'rw') {
		echo '<table  class="table">';
		echo "<p>特売情報操作確認画面</p>";
		//追加フォーム
		echo '<form action="" method="post">';
		echo '<tr></tr><tr><td>特売情報入力フォーム</td></tr>';
		//テーブル項目
		echo '<tr><th>商品番号</th><th>特売価格</th><th>開始日</th>
	<th>終了日</th><th>更新内容</th></tr>';
		echo '<tr>';
		echo '<td><input type="number" name="product_id"></td>';
		echo '<td><input type="number" name="sale_price"></td>';
		echo '<td><input type="number" name="start_date"></td>';
		echo '<td><input type="number" name="end_date"  ></td>';
		// echo '<td></td><td></td>';
		echo '<td><textarea name="updated_contents" rows="10" cols="25"></textarea></td>';
		echo '</tr>';
		echo '<tr><td><button type="submit" name="button" value="ins">確定</button></td>';
		echo '<td><a href="product-show.php">戻る</a></td></tr>';
		echo '</form>';
	}
	echo '</table>';



	echo '<table  class="table">';
	//編集フォーム
	if ($_SESSION['admin']['authority'] === 'rw') {
		echo "<p><tr><td>特売情報表示、編集 (終了分除く)確認フォーム</td></tr></p>";
	} else {
		echo "<p><tr><td>特売情報表示確認フォーム</td></tr></p>";
	}
	//テーブル項目
	echo '<tr><th>商品番号</th><th>特売価格</th><th>開始日</th>
<th>終了日</th><th>更新日</th><th>更新者id</th><th>更新内容</th></tr>';
	$sql = $pdo->prepare('SELECT * FROM sale_period ORDER BY end_date DESC LIMIT 20');
	$sql->execute();
	//管理者権限がrの場合、更新を不可とする
	if ($_SESSION['admin']['authority'] === 'rw') {
		$ro = "";
	} else {
		$ro = "readonly";
	}
	foreach ($sql as $row) {
		echo '<form action="" method="post">';
		echo '<input type="hidden" name="id"                   value="' . $row["id"] .               '"' . $ro . '>';
		echo '<tr>';
		echo '<td><input type="number" name="product_id"       value="' . $row["product_id"] .       '"' . $ro . '></td>';
		echo '<td><input type="number" name="sale_price"       value="' . $row["sale_price"] .       '"' . $ro . '></td>';
		echo '<td><input type="number" name="start_date"       value="' . $row["start_date"] .       '"' . $ro . '></td>';
		echo '<td><input type="number" name="end_date"         value="' . $row["end_date"] .         '"' . $ro . '></td>';
		echo '<td><input type="number" name="updated_at"       value="' . $row["updated_at"] .       '"' . $ro . '></td>';
		echo '<td><input type="number" name="updated_by_id"    value="' . $row["updated_by_id"] .    '"' . $ro . '></td>';
		echo '<td><textarea name="updated_contents" rows="6" cols="25"' . $ro . '>' . $row["updated_contents"] . '</textarea></td>';
		//管理者権限がrの場合、削除を不可とする
		if ($row["end_date"] >= $date && $_SESSION['admin']['authority'] === 'rw') {	//特売終了後は編集禁止。記録を残すため。管理者権限がrw。
			echo '<td><button type="submit" name="button" value="upd">編集確定</button></td>';
			echo '</form>';
			echo '<form action="" method="post">';
			echo '<input type="hidden" name="id"               value="' . $row["id"] .               '"' . $ro . '>';
			echo '<td><button type="submit" name="button" value="del">削除</button></td>';
			echo '</form>';
		}
	}

	echo '</tr>';
	echo '</table>';
} else {
	echo 'このログイン名は、閲覧権限を有していません。';
}
?>
<?php require 'footer.php'; ?>
