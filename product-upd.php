<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>
<?php require 'dbconnect.php'; ?>
<?php require 'common.php'; ?>

<?php
echo '<div class="page"> </div>';
$_SESSION['err'] = [];
$_SESSION['product'] = [];
$button               = $_SESSION['product']['button'] = filter_input(INPUT_POST, 'button', FILTER_SANITIZE_SPECIAL_CHARS);
//戻るボタンを押された場合、product-show.phpに戻る
if (h($button) == "rtn") {
	// echo '<a href="product-show.php">戻る</a>';
	header('Location:product-show.php');
}
//受け取った情報をまずサニタイズ処理と整数確認
// echo
$id               = $_SESSION['product']['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
// echo
$name             = $_SESSION['product']['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
// echo
$price            = $_SESSION['product']['price'] = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS);
// echo
$pic1             = $_SESSION['product']['pic1'] = filter_input(INPUT_POST, 'pic1', FILTER_SANITIZE_SPECIAL_CHARS);
// echo
$pic2             = $_SESSION['product']['pic2'] = filter_input(INPUT_POST, 'pic2', FILTER_SANITIZE_SPECIAL_CHARS);
// echo
$pic3             = $_SESSION['product']['pic3'] = filter_input(INPUT_POST, 'pic3', FILTER_SANITIZE_SPECIAL_CHARS);
// echo
$pic4             = $_SESSION['product']['pic4'] = filter_input(INPUT_POST, 'pic4', FILTER_SANITIZE_SPECIAL_CHARS);
// echo
$picmini1         = $_SESSION['product']['picmini1'] = filter_input(INPUT_POST, 'picmini1', FILTER_SANITIZE_SPECIAL_CHARS);
// echo
$introduction     = $_SESSION['product']['introduction'] = filter_input(INPUT_POST, 'introduction', FILTER_SANITIZE_SPECIAL_CHARS);
// echo
$updated_contents = $_SESSION['product']['updated_contents'] = filter_input(INPUT_POST, 'updated_contents', FILTER_SANITIZE_SPECIAL_CHARS);
// echo $updated_at       = $_SESSION['product']['updated_at'] = filter_input(INPUT_POST, 'updated_at', FILTER_SANITIZE_SPECIAL_CHARS);
// echo $updated_by_id    = $_SESSION['product']['updated_by_id'] = filter_input(INPUT_POST, 'updated_by_id', FILTER_SANITIZE_SPECIAL_CHARS);
/*echo*/
$recommend        = $_SESSION['product']['recommend'] = filter_input(INPUT_POST, 'recommend', FILTER_SANITIZE_SPECIAL_CHARS);
// echo $daily_ranking    = $_SESSION['product']['daily_ranking'] = filter_input(INPUT_POST, 'daily_ranking', FILTER_SANITIZE_SPECIAL_CHARS);
// echo $weekly_ranking   = $_SESSION['product']['weekly_ranking'] = filter_input(INPUT_POST, 'weekly_ranking', FILTER_SANITIZE_SPECIAL_CHARS);
$display		  = $_SESSION['product']['display'] = filter_input(INPUT_POST, 'display', FILTER_SANITIZE_SPECIAL_CHARS);

if ($name             == "") {
	$_SESSION['err'][0] = '未入力です';
} else {
	$_SESSION['err'][0] = "";
}
if ($price            == "") {
	$_SESSION['err'][1] = '未入力です';
} else {
	$_SESSION['err'][1] = "";
}
if ($pic1             == "") {
	$_SESSION['err'][2] = '未入力です';
} else {
	$_SESSION['err'][2] = "";
}
if ($pic2             == "") {
	$_SESSION['err'][3] = '未入力です';
} else {
	$_SESSION['err'][3] = "";
}
if ($pic3             == "") {
	$_SESSION['err'][4] = '未入力です';
} else {
	$_SESSION['err'][4] = "";
}
if ($pic4             == "") {
	$_SESSION['err'][5] = '未入力です';
} else {
	$_SESSION['err'][5] = "";
}
if ($picmini1         == "") {
	$_SESSION['err'][6] = '未入力です';
} else {
	$_SESSION['err'][6] = "";
}
if ($introduction     == "") {
	$_SESSION['err'][7] = '未入力です';
} else {
	$_SESSION['err'][7] = "";
}
if ($updated_contents == "") {
	$_SESSION['err'][8] = '未入力です';
} else {
	$_SESSION['err'][8] = "";
}
if ($display == "") {
	$_SESSION['err'][9] = '未入力です';
} else {
	$_SESSION['err'][9] = "";
}
var_dump($_SESSION['err']);

//入力チェックで問題がない場合
if (count(array_filter($_SESSION['err'])) === 0) {



	// 管理者権限がrwなら、更新、登録、削除に進む 保険として設けておく
	if ($_SESSION['admin']['authority'] === 'rw') {
		$date = date('Ymd');

		//更新ボタンが押された場合
		if (h($button) == "upd") {

			$sql = $pdo->prepare('UPDATE product
			SET name=?, price=?, pic1=?, pic2=? , pic3=?, pic4=?, picmini1=?
			, introduction=?, updated_at=?, updated_by_id=?, updated_contents=?,
			recommend=?, display=? WHERE id=?');
			$sql->bindParam(1, $name, PDO::PARAM_STR);
			$sql->bindParam(2, $price, PDO::PARAM_INT);
			$sql->bindParam(3, $pic1, PDO::PARAM_STR);
			$sql->bindParam(4, $pic2, PDO::PARAM_STR);
			$sql->bindParam(5, $pic3, PDO::PARAM_STR);
			$sql->bindParam(6, $pic4, PDO::PARAM_STR);
			$sql->bindParam(7, $picmini1, PDO::PARAM_STR);
			$sql->bindParam(8, $introduction, PDO::PARAM_STR);
			$sql->bindParam(9, $date, PDO::PARAM_INT);
			$sql->bindParam(10, $_SESSION['admin']['id'], PDO::PARAM_INT);
			$sql->bindParam(11, $updated_contents, PDO::PARAM_STR);
			$sql->bindParam(12, $recommend, PDO::PARAM_STR);
			$sql->bindParam(13, $display, PDO::PARAM_INT);
			$sql->bindParam(14, $id, PDO::PARAM_INT);
			$sql->execute();
			echo '更新しました。';

			//登録ボタンが押された場合
		} elseif (h($button) == "ins") {
			$sql = $pdo->prepare('INSERT INTO product
			SET name=?, price=?, pic1=?, pic2=? , pic3=?, pic4=?, picmini1=?,
			 introduction=?, updated_at=?, updated_by_id=?, updated_contents=?,
			 recommend=?, display=?');
			$sql->bindParam(1, $name, PDO::PARAM_STR);
			$sql->bindParam(2, $price, PDO::PARAM_INT);
			$sql->bindParam(3, $pic1, PDO::PARAM_STR);
			$sql->bindParam(4, $pic2, PDO::PARAM_STR);
			$sql->bindParam(5, $pic3, PDO::PARAM_STR);
			$sql->bindParam(6, $pic4, PDO::PARAM_STR);
			$sql->bindParam(7, $picmini1, PDO::PARAM_STR);
			$sql->bindParam(8, $introduction, PDO::PARAM_STR);
			$sql->bindParam(9, $date, PDO::PARAM_INT);
			$sql->bindParam(10, $_SESSION['admin']['id'], PDO::PARAM_INT);
			$sql->bindParam(11, $updated_contents, PDO::PARAM_STR);
			$sql->bindParam(12, $recommend, PDO::PARAM_STR);
			$sql->bindParam(13, $display, PDO::PARAM_INT);
			$sql->execute();
			$sql->execute();
			echo  $name . ' を登録しました。';

			//削除ボタンが押された場合
			//データは削除せず、displayを0にする
		// } elseif (h($button) == "del") {
		// 	$sql = $pdo->prepare('UPDATE product SET display=0 WHERE id=?');
		// 	$sql->bindParam(1, $id, PDO::PARAM_INT);
		// 	$sql->execute();
		// 	echo '削除しました。';
		}
		//使用したセッションを空にする。ここでunsetは使用しない。
		$_SESSION['err'] = "";
		$_SESSION['product'] = "";
		//商品管理テーブルに戻る
		header('location:product-show.php');
		// echo '<a href="product-show.php">戻る</a>';
	}
	//入力問題がある場合
} else {
	if (h($button) == "upd") {
		//更新テーブルに戻る
		// echo '<a href="product-edit.php">戻る</a>';
		header('location:product-edit.php');
	} elseif (h($button) == "ins") {
		//登録テーブルに戻る
		// echo '<a href="product-insert.php">戻る</a>';
		header('location:product-insert.php');
	}
}
?>
<?php require 'footer.php'; ?>


