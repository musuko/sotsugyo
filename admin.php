<?php require 'dbconnect.php'; ?>

<?php

if (isset($_SESSION['admin'])) {

echo '<div class="page">';

//閲覧権限なし
if ($_SESSION['admin']['authority'] == '-') {
    echo '<p>&emsp;&emsp;&emsp;&emsp;社員情報の閲覧が制限されています。</p>';

} else {
    //閲覧・修正権限あり
    if ($_SESSION['admin']['authority'] == 'rw') {
        echo '<p>&emsp;&emsp;&emsp;&emsp;<a href="admin-insert.php">登録する</a></p>';
    }

    //データを取り出す
    $sql = $pdo->prepare ('SELECT * FROM admin ORDER BY admin_id');
    $sql->execute();

    echo '<table>';
    echo '<th>社員番号</th><th>社員名</th><th>支社名</th><th>部課名</th>';

    //データを表示する
    while ($admin = $sql->fetch()) {

        if ($admin['retire_date'] == 0) {
            echo '<tr>';
            echo '<td>' . $admin['admin_id'] . '</td>';
            echo '<td>' . $admin['admin_name1'] . ' ' . $admin['admin_name2'] . '</td>';
            echo '<td>' . $admin['office_name'] . '</td>';
            echo '<td>' . $admin['department_name'] . '</td>';

            //閲覧・修正権限あり
            //URLパラメータ'admin_id'を送る To admin-edit.php
            if ($_SESSION['admin']['authority'] == 'rw') {
                echo '<td><a href="admin-edit.php?admin_id=' . $admin['admin_id'] . '">編集</a></td>';

            } elseif ($_SESSION['admin']['authority'] == 'r') {
                echo '<td><a href="admin-edit.php?admin_id=' . $admin['admin_id'] . '">詳細</a></td>';

            }
            echo '</tr>';
        }
    }

    echo '</table></div><br>';

}

} else {

    echo '<div class=page>';
	echo '<p>社員情報を表示するには、ログインが必要です。<p/>';
	echo '<form action="login-relay2.php" method="post">
            ログイン名<input type="text" name="login"><br>
            パスワード<input type="password" name="password"><br>
            <p><input type="submit" value="ログイン"></p>
            </form>';
	echo '</div>';

}
?>

</div>
</html>