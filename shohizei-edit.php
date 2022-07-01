<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>
<?php require('dbconnect.php'); ?>
<?php require('common.php'); ?>

<?php
//閲覧権限チェック
echo '<div class="page"> </div>';
if ($_SESSION['admin']['authority'] === 'rw' || $_SESSION['admin']['authority'] === 'r') {
	$taxdate = h(filter_input(INPUT_GET, 'taxdate'));
		//GETでidを送られてきた場合
	if ($taxdate) {
		//DBに接続する
		//消費税のデータを取り出す
		$sql = $pdo->prepare('SELECT * FROM tax WHERE taxdate=?');
		$sql->bindParam(1, $taxdate, PDO::PARAM_INT);
		$sql->execute();
		$row = $sql->fetch();
				//変数に消費税情報を入れる
		$taxdate            = $row['taxdate'];
		$tax                = $row['tax'];
		$updated_at         = $row['updated_at'];
		$updated_by_id      = $row['updated_by_id'];
		$_SESSION['err'][0] = "";
		$_SESSION['err'][1] = "";
	} else {
		$tax           = $_SESSION['tax'];
		$taxdate       = $_SESSION['taxdate'];
		$updated_at    = $_SESSION['shohizei']['updated_at'];
		$updated_by_id = $_SESSION['shohizei']['updated_by_id'];
	}
	#消費税一覧をテキストボックスで表示
	echo '<table>';

	echo '<tr>';
	echo '<th>新消費税率開始日<br>ex. 20250101</th><th>消費税率<br>ex. 12</th><th>テーブル変更日</th><th>変更管理者ID</th>';
	echo '</tr>';

	//フォームで情報を表示する
	echo '<form action = "shohizei-upd.php" method="post">';
	//変更日、変更者は手入力修正不要と考えたので、表示のみとする。
	echo '<tr>';
	echo '<td><input type="text" name="taxdate" value="' . $taxdate . '"></td>';
	echo '<td><input type="number" name="tax" value="' . $tax . '"></td>';
	echo '<td><input type="text" name="updated_at" value="' . $updated_at    . '" readonly></td>';
	echo '<td><input type="text" name="updated_by_id" value="' . $updated_by_id . '" readonly></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><font color=red>' . $_SESSION['err'][0] . '</td><td><font color=red>' . $_SESSION['err'][1] . '</td>';
	echo '</tr>';
	echo '</table>';
	//SQLで消費税率設定日を更新時、WHERE用のtaxdateをセッションに入れて記憶させる
	$_SESSION['taxdate'] = $taxdate;
} else {
	echo 'このログイン名は、閲覧権限を有していません。';
}
//閲覧権限rwの場合、削除、編集ボタン表示
if ($_SESSION['admin']['authority'] === 'rw') {
	echo '<td><button type="submit" name = "button" value="del">削除</button>';
	echo '<button type="submit" name = "button" value="upd">修正</button>';
	echo '<button type="submit" name = "button" value="rtn">戻る</button></td>';
	echo '</form>';
	echo '<br>';
	echo '削除ボタンを押すとテーブルは元に戻りません。慎重に操作願います。';
	echo '<br>';
}
?>
<?php require 'footer.php'; ?>