<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>
<?php require 'common.php'; ?>
<?php require('dbconnect.php'); ?>

<?php
echo '<div class="page"> </div>';
//admin $_SESSION をunsetでリセット
unset($_SESSION['admin']);

//SQLを記述
$login = h($_REQUEST['login']);
$password =h( $_REQUEST['password']);

$sql = $pdo->prepare('SELECT * FROM admin WHERE admin_login = ? AND admin_password = ?');
$sql->bindParam(1, $login, PDO::PARAM_STR);
$sql->bindParam(2, $password, PDO::PARAM_STR);
$sql->execute();

//foreach でSQLデータのデータを回す
foreach ($sql as $row) {
    $_SESSION['admin'] = [
        'id' => $row['admin_id'],
        'name1' => $row['admin_name1'],
        'name2' => $row['admin_name2'],
        'login' => $row['admin_login'],
        'password' => $row['admin_password'],
        'furigana1' => $row['admin_furigana1'],
        'furigana2' => $row['admin_furigana2'],
        'hire_date' => $row['hire_date'],
        'retire_date' => $row['retire_date'],
        'authority' => $row['authority'],
        'picture' => $row['picture'],
        'office_id' => $row['office_id'],
        'office_name' => $row['office_name'],
        'department_id' => $row['department_id'],
        'department_name' => $row['department_name'],
        'telno' => $row['telno'],
        'email' => $row['email'],
        'birthdate' => $row['birthdate'],
        'updated_at' => $row['updated_at'],
        'updated_by_id' => $row['updated_by_id'],
    ];
}

//ログインできる場合
if (isset($_SESSION['admin']) && ((int)$_SESSION['admin']['retire_date']) === 0) {

    header ('location: login-output2.php');

//退職している場合
} elseif (isset($_SESSION['admin']) && ((int)$_SESSION['admin']['retire_date']) > 0) {

    echo 'このログイン名ユーザーは退職したため、<br>
            ログインできません。';

    unset($_SESSION['admin']);

//登録されていない場合
} else {

    echo 'ログイン名またはパスワードが違います。<br>';
    unset($_SESSION['admin']);
    echo '<form action="login-relay2.php" method="post">
    ログイン名<input type="text" name="login"><br>
    パスワード<input type="password" name="password"><br><br>';

    echo '<input type="submit" value="ログイン">';

    echo '</form>';
}

?>
<?php require 'footer.php'; ?>