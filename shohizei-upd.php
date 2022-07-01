<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>
<?php require('dbconnect.php'); ?>
<?php require('common.php'); ?>

<?php
echo '<div class="page"> </div>';
//戻るボタンを押された場合、shohizei-show.phpに戻る
if (h($_REQUEST['button']) == "rtn") {
	header('Location:shohizei-show.php');
}
//taxdate, tax情報をまずサニタイズ処理と整数確認
$_SESSION['shohizei'] = [];
$taxdate = filter_input(INPUT_POST,	'taxdate',	FILTER_SANITIZE_SPECIAL_CHARS,	FILTER_VALIDATE_INT);
$tax     = filter_input(INPUT_POST,	'tax',	FILTER_SANITIZE_SPECIAL_CHARS,	FILTER_VALIDATE_INT);
$updated_at    = filter_input(INPUT_POST, 'updated_at', FILTER_SANITIZE_SPECIAL_CHARS);
$updated_by_id = filter_input(INPUT_POST, 'updated_by_id', FILTER_SANITIZE_SPECIAL_CHARS);
echo $_SESSION['shohizei']['updated_at']    = $updated_at;
echo $_SESSION['shohizei']['updated_by_id'] = $updated_by_id;
//登録、更新の場合、入力チェックを行う
$err = [];
if (h($_REQUEST['button']) == "upd" || h($_REQUEST['button']) == "ins") {
	//日付が存在するかチェックし、NGの場合$err配列に入れる。
	$datecheck = (string)date("Ymd", strtotime($taxdate));
	if ($taxdate === "") {
		$err[0] = '日付が未入力です';
	} elseif ($taxdate < 19870101) {
		$err[0] = '日付が古過ぎです';
	} elseif ($taxdate > 21000101) {
		$err[0] = '日付が先過ぎです';
	} elseif ($datecheck !== $taxdate) {
		$err[0] = '日付が存在しません';
	} else {
		$err[0] = "";
	}
	//消費税率が適正な範囲かチェックし、NGの場合$err配列にコメントを入れる。
	//パーセントの値を入力するのが正解だが、0.05や0.10など小数で入力されることを防止するのが、主目的。
	if ($tax == "") {
		$err[1] = '消費税率が未入力です';
	} elseif ($tax < 0) {
		$err[1] = '消費税率がマイナスです';
	} else {
		$err[1] = "";
	}
	//セッションに、エラー内容、受け取った値を入れる
	$_SESSION['err'] = $err;
	$_SESSION['taxdate'] = $taxdate;
	$_SESSION['tax'] = $tax;
}


//入力チェックで問題がない場合
if (count(array_filter($err)) === 0) {

	// 管理者権限がrwなら、更新、登録、削除に進む 保険として設けておく
	if ($_SESSION['admin']['authority'] === 'rw') {
		$date = date('Ymd');

		//更新ボタンが押された場合
		if (h($_REQUEST['button']) == "upd") {

			$sql = $pdo->prepare('UPDATE tax
			SET taxdate=?, tax=?, updated_at=?, updated_by_id=? WHERE taxdate=?');
			$sql->bindParam(1, $taxdate, PDO::PARAM_INT);
			$sql->bindParam(2, $tax, PDO::PARAM_INT);
			$sql->bindParam(3, $date, PDO::PARAM_INT);
			$sql->bindParam(4, $_SESSION['admin']['id'], PDO::PARAM_INT);
			$sql->bindParam(5, $_SESSION['taxdate'], PDO::PARAM_INT);
			$sql->execute();
			echo '更新しました。';


			//登録ボタンが押された場合
		} elseif (h($_REQUEST['button']) == "ins") {
			$sql = $pdo->prepare('INSERT INTO tax
			SET taxdate=?, tax=?, updated_at=?, updated_by_id=?');
			$sql->bindParam(1, $taxdate, PDO::PARAM_INT);
			$sql->bindParam(2, $tax, PDO::PARAM_INT);
			$sql->bindParam(3, $date, PDO::PARAM_INT);
			$sql->bindParam(4,  $_SESSION['admin']['id'], PDO::PARAM_INT);
			$sql->execute();
			echo '登録しました。';

			//削除ボタンが押された場合
		} elseif (h($_REQUEST['button']) == "del") {
			$sql = $pdo->prepare('DELETE FROM tax WHERE taxdate=?');
			$sql->bindParam(1, $taxdate, PDO::PARAM_INT);
			$sql->execute();
			echo '削除しました。';
		}

		//使用したセッションを空にする。ここでunsetは使用しない。
		$_SESSION['err'] = "";
		$_SESSION['taxdate'] = "";
		$_SESSION['tax'] = "";
		//消費税テーブルに戻る
		// echo '<a href="shohizei-show.php">戻る</a>';
		header('location:shohizei-show.php');
	}
	//入力問題がある場合
} elseif (h($_REQUEST['button']) == "upd") {
	//更新テーブルに戻る
	// echo '<a href="shohizei-edit.php">戻る</a>';
	header('location:shohizei-upd.php');
} elseif (h($_REQUEST['button']) == "ins") {
	//登録テーブルに戻る
	// echo '<a href="shohizei-insert.php">戻る</a>';
	header('location:shohizei-insert.php');
}

?>