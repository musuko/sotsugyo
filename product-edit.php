<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>
<?php require('dbconnect.php'); ?>
<?php require('common.php'); ?>

<?php
//閲覧権限チェック
echo '<div class="page"> </div>';
if ($_SESSION['admin']['authority'] === 'rw' || $_SESSION['admin']['authority'] === 'r') {
	$id = h(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS));
	//GETでidを送られてきた場合
	if ($id) {
		//DBに接続する
		//商品のデータを取り出す
		$sql = $pdo->prepare('SELECT * FROM product WHERE id=?');
		$sql->bindParam(1, $id, PDO::PARAM_INT);
		$sql->execute();
		$row = $sql->fetch();
		//変数に商品情報を入れる
		$name             = h($row['name']);
		$price            = h($row['price']);
		$pic1             = h($row['pic1']);
		$pic2             = h($row['pic2']);
		$pic3             = h($row['pic3']);
		$pic4             = h($row['pic4']);
		$picmini1         = h($row['picmini1']);
		$introduction     = h($row['introduction']);
		$updated_contents = h($row['updated_contents']);
		$recommend        = h($row['recommend']);
		$display        = h($row['display']);
		for ($i = 0; $i <= 10; $i++) {
			$_SESSION['err'][$i] = "";
		}
	} else {
		//変数に前回フォームで送信した内容を入れる
		$id               = h($_SESSION['product']['id']);
		$name             = h($_SESSION['product']['name']);
		$price            = h($_SESSION['product']['price']);
		$pic1             = h($_SESSION['product']['pic1']);
		$pic2             = h($_SESSION['product']['pic2']);
		$pic3             = h($_SESSION['product']['pic3']);
		$pic4             = h($_SESSION['product']['pic4']);
		$picmini1         = h($_SESSION['product']['picmini1']);
		$introduction     = h($_SESSION['product']['introduction']);
		$updated_contents = h($_SESSION['product']['updated_contents']);
		$recommend        = h($_SESSION['product']['recommend']);
		$display          = h($_SESSION['product']['display']);
	}
	// echo $name;

	//入力フォーム作成に現在の登録内容記述。登録ボタンでupdに遷移し、入力チェック後、テーブル更新。
	echo '<form action = "product-upd.php" method="post">';
	echo '<table>';
	echo '<input type="hidden" name = "id"  value="' . $id . '">';
	echo '<tr>';
	echo '<td>商品名: </td><td><input type="text" name = "name" value="' . $name . '">
	<font color=red>' . $_SESSION['err'][0] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>価格: </td><td><input type="text" name = "price" value="' . $price . '">
	<font color=red>' . $_SESSION['err'][1] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>写真1: </td><td><input type="text" name = "pic1" value="' . $pic1 . '">
	<font color=red>' . $_SESSION['err'][2] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>写真2: </td><td><input type="text" name = "pic2" value="' . $pic2 . '">
	<font color=red>' . $_SESSION['err'][3] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>写真3: </td><td><input type="text" name = "pic3" value="' . $pic3 . '">
	<font color=red>' . $_SESSION['err'][4] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>写真4: </td><td><input type="text" name = "pic4" value="' . $pic4 . '">
	<font color=red>' . $_SESSION['err'][5] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>小写真: </td><td><input type="text" name = "picmini1" value="' . $picmini1 . '">
	<font color=red>' . $_SESSION['err'][6] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>商品説明: </td><td><textarea name = "introduction" rows="20" cols="30">'
		. $introduction . 	'</textarea><font color=red>' . $_SESSION['err'][7] . '</td>';
	echo '</tr>';
	// echo '<tr>';
	// echo '<td>更新日: </td><td><input type="text" name = "updated_at"></td>';
	// echo '</tr>';
	// echo '<tr>';
	// echo '<td>更新id: </td><td><input type="text" name = "updated_by_id"></td>';
	// echo '</tr>';
	echo '<tr>';
	echo '<td>更新内容: </td><td><textarea name = "updated_contents" rows=8" cols="30">'
		. $updated_contents . '</textarea><font color=red>' . $_SESSION['err'][8] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>商品おすすめ: </td><td><input type="text" name = "recommend"  value="' . $recommend . '">
	おすすめの場合、1を入力</td>';
	echo '</tr>';
	// echo '<tr>';
	// echo '<td>売上ランキング(日): </td><td><input type="text" name = "daily_ranking"></td>';
	// echo '</tr>';
	// echo '<tr>';
	// echo '<td>売上ランキング(週): </td><td><input type="text" name = "weekly_ranking"></td>';
	// echo '</tr>';
	echo '<tr>';
	echo '<td>フラグ<br>非表示 :0 <br>表示 :1</td><td><input type="text" name = "display" value="' . $display . '">
	<font color=red>' . $_SESSION['err'][9] . '</td>';
	echo '</tr>';


	//閲覧権限rwの場合、削除、編集ボタン表示
	if ($_SESSION['admin']['authority'] === 'rw') {
		echo '<tr><td>';
		// echo '<button type="submit" name = "button" value="del">削除</button>';
		echo '<button type="submit" name = "button" value="upd">修正</button>';
		echo '<button type="submit" name = "button" value="rtn">戻る</button>';
		echo '</td></tr>';
		echo '</table>';
		echo '</form>';
		echo '<br>';
	}
} elseif ($_SESSION['admin']['authority'] === '-') {
	echo 'このログイン名は、閲覧権限を有していません。';
} else {
	echo 'ログインを行ってください。';
}

?>
<?php require 'footer.php'; ?>