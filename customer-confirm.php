<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<div class=page>
    <p>登録内容をご確認後、<br>
    確認ボタンを押してください。</p>
</div>

<?php

//変数にチェック済みの入力内容を代入する

$name1 = $_SESSION['form']['name1f'];                        //漢字の性
$name2 = $_SESSION['form']['name2f'];                       //漢字の名
$furigana1 = $_SESSION['form']['furigana1f'];              //フリガナの性
$furigana2 = $_SESSION['form']['furigana2f'];             //フリガナの性
$postcode = $_SESSION['form']['postcodef'];
$address1 = $_SESSION['form']['address1f'];
$address2 = $_SESSION['form']['address2f'];
$address4 = $_SESSION['form']['address4f'];
$telno = $_SESSION['form']['telnof'];
$birthdate = $_SESSION['form']['birthdatef'];
$email = $_SESSION['form']['emailf'];
$login = $_SESSION['form']['loginf'];
$password = $_SESSION['form']['passwordf'];



echo '<form action="customer-output.php" method="post">';
echo '<table>';

echo '<tr><td align="center"><b>お名前</b></td><td>';
echo $name1.$name1_c;
echo '</td></tr><td></td><td>';
echo $name2 ,'</td></tr>';

echo '<tr><td align="center"><b>フリガナ</b></td><td>';
echo $furigana1;
echo '</td><tr><td></td><td>';
echo $furigana2.'</td></tr>';

echo '<tr><td align="center"><b>郵便番号</b></td><td>';
echo $postcode;
echo '</td></tr>';

echo '<tr><td align="center"><b>ご住所</b></td><td>';
echo $address1;
echo '</td></tr>';
echo '<tr><td></td><td>';
echo $address2.$address3.'</td><tr>';
echo '<tr><td></td><td>';
echo  $address4;
echo '</tr>';


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
echo '<a href="customer-input.php"><input type="button" value="前の画面に戻る"></a>';
echo '</form>';
echo '<br>';

?>

<?php require 'footer.php'; ?>
