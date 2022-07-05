<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php
echo '<div class="page"> </div>';
//空の変数を用意する
$name1 = $name2 = $address1 = $address2 =$address3 =$address4 = $login = $password = $furigana1 = $furigana2 = $postcode = $telno = $birthdate = $email = '';
$error_name1 = $error_name2 = $error_address1 = $error_address2 = $error_address3 = $error_address4 = $error_login = $error_password = $error_furigana1 =
    $error_furigana2 = $error_postcode = $error_telno = $error_birthdate = $error_email =  $error_full = '';

//var_dump($_POST);
if (isset($_SESSION['customer'])) {                      //ログインしている場合
    $id = $_SESSION['customer']['id'];
    $name1 = $_SESSION['customer']['name1'];
    $name2 = $_SESSION['customer']['name2'];
    $address1 = $_SESSION['customer']['address1'];
    $address2 = $_SESSION['customer']['address2'];
    $address4 = $_SESSION['customer']['address4'];
    $login = $_SESSION['customer']['login'];
    $password = $_SESSION['customer']['password'];
    $furigana1 = $_SESSION['customer']['furigana1'];
    $furigana2 = $_SESSION['customer']['furigana2'];
    $postcode = $_SESSION['customer']['postcode'];
    $telno = $_SESSION['customer']['telno'];
    $birthdate = $_SESSION['customer']['birthdate'];
    $email = $_SESSION['customer']['email'];
}
if (isset($_SESSION['form'])) {                          //フォームに入力がある場合
    //$name1とname2を追加
    $name1 = $_SESSION['form']['name1'];
    $name2 = $_SESSION['form']['name2'];
    $address1 = $_SESSION['form']['address1'];
    $address2 = $_SESSION['form']['address2'];
    $address3 = $_SESSION['form']['address3'];
    $address4 = $_SESSION['form']['address4'];
    $login = $_SESSION['form']['login'];
    $password = $_SESSION['form']['password'];
    //フリガナの性と名を追加
    $furigana1 = $_SESSION['form']['furigana1'];
    $furigana2 = $_SESSION['form']['furigana2'];
    $postcode = $_SESSION['form']['postcode'];
    $telno = $_SESSION['form']['telno'];
    $birthdate = $_SESSION['form']['birthdate'];
    $email = $_SESSION['form']['email'];
}


if (isset($_SESSION['error'])) {                      //エラーが送り返された場合

    //未記入エラー
    $error_postcode =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['postcode'] . "</span>";
    $error_address =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['address'] . "</span>";
    $error_telno =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['telno'] . "</span>";
    $error_birthdate =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['birthdate'] . "</span>";
    $error_email =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['email'] . "</span>";
    $error_login =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['login'] . "</span>";
    $error_password =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['password'] . "</span>";
    //エラー内容を追記できます～

    //name1が苗字
    $error_name1 =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['name1'] . "</span>";
    //name2が名
    $error_name2 =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['name2'] . "</span>";
    //furigana1がカナ苗字
    $error_furigana1 =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['furigana1'] . "</span>";
    //furigana2がカナ名
    $error_furigana2 =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['furigana2'] . "</span>";
    // $error_full =
    //     "<span style='color: #FF00FF;'>" . $_SESSION['error']['full'] . "</span>";
}

//新しく追加
echo '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
echo '<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
<script src="postal_api.js"></script>';

echo '<form class="h-adr" method="post" action="customer-check.php" fit-content; margin: 0 auto">';
echo '<span class="p-country-name" style="display:none;">Japan</span>';

echo '<div class="left2">';
echo '<table class="table-customer">';

echo '<tr><td class="title-ask"><b>会員登録情報</b></td></tr>';
echo '<tr><th></th><tr>';
echo '<tr><th></th><tr>';
echo '<tr><th></th><tr>';


echo '<tr>
                <td>お名前</td>';
echo '<td>' . '姓 ' . '<input type="text" style="width:150px" class="name1" name="name1" size="15" id="name1" value= "', $name1, '"></td>';
//苗字が空欄の時のエラー
echo '<td>' . $error_name1 . '</td>';

echo '<tr><td></td>' . '<td>' . '名 ' . '<input type="text" style="width:150px" class="name2" name="name2" size="15" id="name2" value= "', $name2, '"></td>';
//名前が空欄の時のエラー
echo '<td>' . $error_name2 . '</td>';
echo '</td></tr>';

echo '<tr><td>フリガナ</td><td>';
echo 'セイ ' . '<input type="text" class="furigana1" name="furigana1" size="15" id="furigana1" value="', $furigana1, '"></td>';
//カナ苗字が空欄の時のエラー
echo '<td>' . $error_furigana1 . '</td>';
echo '<tr><td></td><td>' . 'メイ ' . '<input type="text" class="furigana2" name="furigana2" size="15" id="furigana2" value="', $furigana2, '">';
echo '</td>';
//カナ苗字が空欄の時のエラー
echo '<td>' . $error_furigana2 . '</td>
        </tr>';
echo '<tr><td>電話番号</td><td>';
echo '<input type="tel" class="telno" name= "telno" id="telno" value= "', $telno, '">';
echo '</td>';
echo '<td>' . $error_telno . '</td>
        </tr>';

echo '<tr><td>生年月日</td><td>';
//type="text" を"date"に変更しました。sudo
if (!isset($_SESSION['customer'])) {
    echo '<input type="date"class="birthdate" name= "birthdate" id="birthdate" value= "' . $birthdate . '">';
    echo '</td>';
    echo '<td>' . $error_birthdate . '</td>
        </tr>';
} else {
    //substr_replace
    //$birthdate =  substr_replace($birthdate,'/',4,0);
    //$birthdate =  substr_replace($birthdate,'/',7,0);
    echo '<input type="text" name="birthdate" readonly value="', $birthdate, '">';
}


echo '<tr><td>メールアドレス</td><td>';
echo '<input type="email" class="email" name= "email" id="email" value= "' . $email . '">';
echo '</td>';
echo '<td>' . $error_email . '</td>
        </tr>';

echo '<tr><td>ログイン名</td><td>';
echo '<input type="text" class="login" name= "login" id="login" value= "',  $login . '">';
echo '</td>';
echo '<td>' . $error_login . '</td>
        </tr>';
echo '<tr><td>パスワード</td><td>';
echo '<input type="password" class="password" name="password" id="password" value= "', $password, '">';
echo '</td>';
echo '<td>' . $error_password . '</td>
        </tr>';
echo '<tr><td>郵便番号</td>';
echo '<td><input type="text" class="p-postal-code" name="postcode" style="width:100px" id="postcode" value="' . $postcode . '"></td>';
echo '</td>';
echo '<td>' . $error_postcode . '</td></tr>';

echo '<tr><td>ご住所</td></td>';
echo '<td>' . '<input type="text" style="width:200px" class="p-region" name= "address1" id="address1" id="postcode" value= "', $address1, '">';
echo '</td>';
echo '<td>' . $error_address . '</td></tr>';
echo '<tr><td></td><td>';
//$addressf=$address2_2;
echo '' . '<input type="text" style="width:200px" class="p-locality" name="address2" id="address1" id="postcode" value="', $address2, '"></td>';
echo '<tr><td></td><td>' .

    '' . '<input type="text" style="width:200px" class="p-street-address p-extended-address" name="address3" id="address1" id="postcode"
     value="', $address3, '"></td>';
echo '</tr>';

echo '<tr><td>その他、マンション名等 ';
echo '</td>';
echo '<td>' . '<input type="text" style="width:200px" class="address4" name="address4" id="address4" value="', $address4, '"></td></tr>';
//ログインされている時に未入力がある場合    customer-check.php  [Ln88～Ln93]2022/06/10 sudo

// echo '<tr><td></td><td></td></tr>';

echo '</table>';
echo '</div><br>';

//ログインしていない場合、確認に進む。ログインしている場合、修正に進む（退会もある）。どちらもcustomer-check.php
if (!isset($_SESSION['customer'])) {

    echo '<div class="left3">';
    echo '<button type="submit" name="confirm" style="background-color:#77FFFF;" value="kakutei">' . '確認' . '</button>';
    echo '</form></div>';
    echo '<br><br>';
} else {

    echo '<table class="left3">';
    echo '<td><input type="submit" style="color: white;background-color:#FF82B2;border-color:#9932CC;" value="修正"></td>';
    echo '</form>';
    echo '<form action = "withdrawal-input.php" method= "post">';
    echo '<td><input type="submit" style="color: white;background-color:#9999FF;border-color: #CC0033;" value="退会"></td>';
    echo '</form>';
    echo '</table>';
    echo '<br><br>';
}

//入力情報のセッションを初期化する
unset($_SESSION['form']);

//エラーのセッションを初期化する
unset($_SESSION['error']);


?>
<?php require 'footer.php'; ?>