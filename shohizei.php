<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>
<?php require('dbconnect.php'); ?>

<?php
echo '<div class="page"> </div>';
$admin_autority = $_SESSION['admin']['authority'] ?? '';
if ($admin_autority === 'rw' || $admin_autority === 'r') {
  //登録、削除、編集ボタン表示
  if ($_SESSION['admin']['authority'] === 'rw') {
    echo '<form action = "shohizei-insert.php" method="post">';
    echo '<button type="submit" name = "button" value="add">追加</button>';
    echo '</form>';
  }
  //DBに接続する
  $sql = $pdo->prepare
    //消費税のデータを取り出す
    ('SELECT * FROM tax ORDER BY taxdate ASC');
  $sql->execute();

  #消費税一覧をテキストボックスで表示
  echo '<p>消費税情報編集追加画面</p>';
  echo '<table>';
  echo '<tr><th>新消費税率開始日</th><th>消費税率</th><th>テーブル変更日</th><th>変更管理者ID</th></tr>';

  //取り出したデータを1行ずつ表示する。
  //変更日、変更者は手入力修正不要と考えたので、表示のみとする。

  foreach ($sql as $row) {
    echo '<tr>';
    //管理者権限がrのとき、リンクが見えないようにする方法を準備する。
    // if ($_SESSION['admin']['authority'] === 'rw') {
      echo '<td><a href="shohizei-edit.php?taxdate=' . $row['taxdate'] . '">' . $row['taxdate'] . '</a></td>';
    // } elseif ($_SESSION['admin']['authority'] === 'r') {
    //   echo '<td>' . $row['taxdate'] . '</td>';
    // }
    echo '<td>' . $row['tax'] . '</td>';
    echo '<td>' . $row['updated_at'] . '</td>';
    echo '<td>' . $row['updated_by_id'] . '</td>';
    echo '</tr>';
  }
  echo '</table>';
} else {
  echo 'このログイン名は、閲覧権限を有していません。';
}

?>
<?php require 'footer.php'; ?>
