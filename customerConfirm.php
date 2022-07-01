<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<div class=page>
    <p>登録内容をご確認後、<br>
    確認ボタンを押してください。</p>
</div>

<?php

//変数にチェック済みの入力内容を代入する
$name = $_SESSION['form']['name'];
$furigana = $_SESSION['form']['furigana'];
$postcode = $_SESSION['form']['postcode'];
$address = $_SESSION['form']['address'];
$telno = $_SESSION['form']['telno'];
$birthdate = $_SESSION['form']['birthdate'];
$email = $_SESSION['form']['email'];
$login = $_SESSION['form']['login'];
$password = $_SESSION['form']['password'];

echo '<form action="customerFinish.php" method="post">';
echo '<table>';

echo '<tr><td align="center"><b>お名前</b></td><td>';
echo $name;
echo '</td></tr>';

echo '<tr><td align="center"><b>フリガナ</b></td><td>';
echo $furigana;
echo '</td></tr>';

echo '<tr><td align="center"><b>郵便番号</b></td><td>';
echo $name;
echo '</td></tr>';

echo '<tr><td align="center"><b>ご住所</b></td><td>';
echo $address;
echo '</td></tr>';

echo '<tr><td align="center"><b>電話番号</b></td><td>';
echo $telno;
echo '</td></tr>';

echo '<tr><td align="center"><b>生年月日</b></td><td>';
echo $birthdate;
echo '</td></tr>';

echo '<tr><td align="center"><b>メールアドレス</b></td><td>';
echo $email;
echo '</td></tr>';

echo '<tr><td align="center"><b>ログイン名</b></td><td>';
echo $login;
echo '</td></tr>';

echo '<tr><td align="center"><b>パスワード</b></td><td>';
echo $password;
echo '</td></tr>';

echo '</table>';
echo '<br>';

echo '<input type="submit" value="確定">';
echo ' ';
echo '<a href="customer.php"><input type="button" value="前の画面に戻る"></a>';
echo '</form>';
echo '<br>';

?>

<?php require 'footer.php'; ?>
