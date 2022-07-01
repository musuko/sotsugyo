<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>
<?php require('common.php'); ?>



<?php
echo '<div class="page"> </div>';
//管理者権限rwの人のみ操作可能。
if ($_SESSION['admin']['authority'] === 'rw') {
	$button =  filter_input(INPUT_POST, 'button', FILTER_SANITIZE_SPECIAL_CHARS);
	if ($button == 'add') {
		$_SESSION['product']['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['product']['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['product']['price'] = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['product']['pic1'] = filter_input(INPUT_POST, 'pic1', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['product']['pic2'] = filter_input(INPUT_POST, 'pic2', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['product']['pic3'] = filter_input(INPUT_POST, 'pic3', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['product']['pic4'] = filter_input(INPUT_POST, 'pic4', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['product']['picmini1'] = filter_input(INPUT_POST, 'picmini1', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['product']['introduction'] = filter_input(INPUT_POST, 'introduction', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['product']['updated_contents'] = filter_input(INPUT_POST, 'updated_contents', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['product']['recommend'] = filter_input(INPUT_POST, 'recommend', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['err'][0] = filter_input(INPUT_POST, '0', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['err'][1] = filter_input(INPUT_POST, '1', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['err'][2] = filter_input(INPUT_POST, '2', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['err'][3] = filter_input(INPUT_POST, '3', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['err'][4] = filter_input(INPUT_POST, '4', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['err'][5] = filter_input(INPUT_POST, '5', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['err'][6] = filter_input(INPUT_POST, '6', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['err'][7] = filter_input(INPUT_POST, '7', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['err'][8] = filter_input(INPUT_POST, '8', FILTER_SANITIZE_SPECIAL_CHARS);
		$_SESSION['err'][9] = filter_input(INPUT_POST, '9', FILTER_SANITIZE_SPECIAL_CHARS);
	}
	//入力フォーム作成。登録ボタンでupdに遷移し、入力チェック後、テーブルに追加。
	echo '<table>';
	echo '<form action = "product-upd.php" method="post" id="id2">';
	echo '<input type="hidden" name = "id" form="id2">';
	echo '<tr>';
	echo '<td>商品名: </td><td><input type="text" name = "name" value="' . $_SESSION['product']['name'] . '" form="id2"><font color=red>' . $_SESSION['err'][0] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>価格: </td><td><input type="numbers" name = "price" value="' . $_SESSION['product']['price'] . '" form="id2"><font color=red>' . $_SESSION['err'][1] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>写真1: </td><td><input type="text" name = "pic1" value="' . $_SESSION['product']['pic1'] . '" form="id2"><font color=red>' . $_SESSION['err'][2] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>写真2: </td><td><input type="text" name = "pic2" value="' . $_SESSION['product']['pic2'] . '" form="id2"><font color=red>' . $_SESSION['err'][3] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>写真3: </td><td><input type="text" name = "pic3" value="' . $_SESSION['product']['pic3'] . '" form="id2"><font color=red>' . $_SESSION['err'][4] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>写真4: </td><td><input type="text" name = "pic4" value="' . $_SESSION['product']['pic4'] . '" form="id2"><font color=red>' . $_SESSION['err'][5] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>小写真: </td><td><input type="text" name = "picmini1" value="' . $_SESSION['product']['picmini1'] . '" form="id2"><font color=red>' . $_SESSION['err'][6] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>商品説明: </td><td><textarea name = "introduction" form="id2" rows="20" cols="30">' . $_SESSION['product']['introduction'] . '</textarea><font color=red>' . $_SESSION['err'][7] . '</td>';
	echo '</tr>';
	echo '<tr>';
	// echo '<td>更新日: </td><td><input type="text" name = "updated_at" form="id2"></td>';
	// echo '</tr>';
	// echo '<tr>';
	// echo '<td>更新id: </td><td><input type="text" name = "updated_by_id" form="id2"></td>';
	// echo '</tr>';
	// echo '<tr>';
	echo '<td>登録内容: </td><td><textarea name = "updated_contents" form="id2" rows=8" cols="30">' . $_SESSION['product']['updated_contents'] . '</textarea><font color=red>' . $_SESSION['err'][8] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>商品おすすめ: </td><td><input type="text" name = "recommend" value="' . $_SESSION['product']['recommend'] . '" form="id2">おすすめの場合、1を入力</td>';
	echo '</tr>';
	// echo '<tr>';
	// echo '<td>売上ランキング(日): </td><td><input type="text" name = "daily_ranking" form="id2"></td>';
	// echo '</tr>';
	// echo '<tr>';
	// echo '<td>売上ランキング(週): </td><td><input type="text" name = "weekly_ranking" form="id2"></td>';
	// echo '</tr>';
	echo '<tr>';
	echo '<td></td><td><button type="submit" name = "button" value="ins" form="id2">登録</button></td>';
	echo '<td><button type="submit" name = "button" value="ins" form="id1">戻る</button></td>';
	echo '</tr>';
	echo '</form>';
	echo '<form action = "product-show.php" method="post" id="id1">';
	echo '</form>';
	echo '</table>';

}
?>
<?php require 'footer.php'; ?>