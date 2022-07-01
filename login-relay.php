<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'common.php'; ?>
<?php require('dbconnect.php'); ?>

<?php
//customer $_SESSION をunsetでリセット
unset($_SESSION['customer']);

//SQLを記述
$login = $_REQUEST['login'];
$password= $_REQUEST['password'];

$sql = $pdo ->prepare('SELECT * FROM customer where login = ? AND password = ?');
$sql->bindParam (1, htmlspecialchars($login), PDO::PARAM_INT);
$sql->bindParam (2, htmlspecialchars($password), PDO::PARAM_STR);
$sql->execute();

//foreach でSQLデータのデータを回す
foreach ($sql as $row) {
    $_SESSION['customer'] = [
        'id' => $row['id'],
        'name1' => $row['name1'],
        'name2' => $row['name2'],
        'address' => $row['address'],
        'login' => $row['login'],
        'password' => $row['password'],
        'postcode' => $row['postcode'],
        'furigana1' => $row['furigana1'],
        'furigana2' => $row['furigana2'],
        'telno' => $row['telno'],
        'birthdate' => $row['birthdate'],
        'enrollment_date' => $row['enrollment_date'],
        'withdrawal_date' => $row['withdrawal_date'],
        'email' => $row['email'],
    ];
}

//ログインできる場合
if (isset($_SESSION['customer']) && ((int)$_SESSION['customer']['withdrawal_date']) === 0) {

    header ('location: login-output.php');

//退会している場合
} elseif (isset($_SESSION['customer']) && ((int)$_SESSION['customer']['withdrawal_date']) > 0) {

    echo '<div class="page"> </div>
            <div class="left2"><br>退会されていますので、<br>
            再度会員登録をお願いします。<br><br>
            <a href="customer-input.php">会員登録</a></div>';

    unset($_SESSION['customer']);

//登録されていない場合
} else {

    echo '<div class=page> </div>';
    echo '<div class="left2"><p>ログイン名またはパスワードが違います。</p>';

    echo '<form action="login-relay.php" method="post">
    ログイン名<input type="text" name="login"><br>
    パスワード<input type="password" name="password"><br>';

    echo '<p><input type="submit" value="ログイン"></p>';

    echo '</form>';
    echo '</div>';

}

?>
<?php require 'footer.php'; ?>