<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>
<?php require('dbconnect.php'); ?>
<?php require('common.php'); ?>



<?php
$taxdate = $_SESSION['taxdate'] ?? '';
$tax = $_SESSION['tax'] ?? '';
$err0 = $_SESSION['err'][0] ?? '';
$err1 = $_SESSION['err'][1] ?? '';

echo '<div class="page"> </div>';
//管理者権限rwの人のみ操作可能。
if ($_SESSION['admin']['authority'] === 'rw') {

	//入力フォーム作成。登録ボタンでupdに遷移し、入力チェック後、テーブルに追加。
	echo '<table>';
	echo '<form action = "shohizei-upd.php" method="post" id="id2">';
	echo '<tr>';
	echo '<th>新消費税率設定日: <br>ex. 20250101 </th><th>新消費税率: <br>ex. 10 </th>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><input type="text" name = "taxdate" value="' . $taxdate . '"
	form="id2"></td>
	<td><input type="number" name = "tax" value="' . $tax . '"
	form="id2"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><font color=red>' . $err0 . '</td><td><font color=red>' . $err1 . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><button type="submit" name = "button" value="ins" form="id2">登録</button></td>';
	echo '<td><button type="submit" name = "button" value="ins" form="id1">戻る</button></td>';
	echo '</tr>';
	echo '</form>';
	echo '<form action = "shohizei-show.php" method="post" id="id1">';
	echo '</form>';
	echo '</Stable>';
}
?>
<?php require 'footer.php'; ?>