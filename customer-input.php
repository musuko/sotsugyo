<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php

//変数を用意する
//$name1とname2を追加
$name1 = $name2 = $address = $login = $password = $furigana1 = $furigana2 = $postcode = $telno = $birthdate = $email = '';
echo '<div class="page"></div>';

if (isset($_SESSION['customer'])) {                      //ログインしている場合

    $id = $_SESSION['customer']['id'];
    $name1_1 = $_SESSION['customer']['name1'];
    $name2_2 = $_SESSION['customer']['name2'];
    $address1_c = $_SESSION['customer']['address1'];
    $address2_c = $_SESSION['customer']['address2'];
    $address4_c = $_SESSION['customer']['address4'];
    $login_c = $_SESSION['customer']['login'];
    $password_c = $_SESSION['customer']['password'];
    $furigana1_1_c = $_SESSION['customer']['furigana1'];
    $furigana2_2_c = $_SESSION['customer']['furigana2'];
    $postcode_cus = $_SESSION['customer']['postcode'];
    $telno_c = $_SESSION['customer']['telno'];
    $birthdate_c = $_SESSION['customer']['birthdate'];
    $email_c = $_SESSION['customer']['email'];
}

if (isset($_SESSION['form'])) {                          //フォームに入力がある場合
    //$name1とname2を追加
    $name1 = $_SESSION['form']['name1f'];
    $name2 = $_SESSION['form']['name2f'];
    $address1_1 = $_SESSION['form']['address1f'];
    $address2_2 = $_SESSION['form']['address2f'];
    $address4_4 = $_SESSION['form']['address4f'];
    $login = $_SESSION['form']['loginf'];
    $password = $_SESSION['form']['passwordf'];
    //フリガナの性と名を追加
    $furigana1 = $_SESSION['form']['furigana1f'];
    $furigana2 = $_SESSION['form']['furigana2f'];
    $postcode_1 = $_SESSION['form']['postcodef'];$_SESSION['form']['postcodef'];
    $telno = $_SESSION['form']['telnof'];
    $birthdate = $_SESSION['form']['birthdatef'];
    $email = $_SESSION['form']['emailf'];
}

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

echo' <div class=page>';
echo' </div>';

//郵便番号検索のコード
$postcode=$_POST['postcode'];                                      //郵便番号を変数に入れる
$url = "http://zipcloud.ibsnet.co.jp/api/search?zipcode=";        //郵便番号検索サイト
$url= $url . $postcode;    //検索条件追加
$json = file_get_contents($url);    //検索結果を$jsonに入れる
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');    //utf8にエンコード
$arr = json_decode($json, true);        //jsonをでコード
    echo '<pre>';
    echo '</pre>';
$arr_1 = $arr['results']['0'];
$address1 = $arr['results']['0']["address1"];
$address2 = $arr['results']['0']["address2"];
$address3 = $arr['results']['0']["address3"];
echo '<form action= "" method="post" id="seach">';

echo '</form>';

echo '<form action="customer-check.php" method="post" id="final">';
echo '</form>';

    echo '<div class=page>';
    echo '<table>';

        echo '<tr>
                <td>お名前</td>';
            echo'<td>' . '性' . '<input type="text" name= "name1" size="15" form="seach" value= "'.$name1_1.$name1. $_POST['name1']. '"></td>';
                //苗字が空欄の時のエラー
            echo '<td>' . $error_name1 . '</td>';

        echo '<tr><td></td>' . '<td>' . '名' . '<input type="text" name= "name2" size="15" form="seach" value= "',$name2,$name2_2,  $_REQUEST['name2'], '"></td>';
            //名前が空欄の時のエラー
            echo '<td>' . $error_name2. '</td>';
        echo '</td></tr>';

        echo '<tr><td>フリガナ</td><td>';
            echo 'セイ' . '<input type="text" name="furigana1" size="15" form="seach" value="',$furigana1,$furigana1_1_c,$_REQUEST['furigana1'], '"></td>';
            //カナ苗字が空欄の時のエラー
            echo '<td>' . $error_furigana1 . '</td>';
        echo '<tr><td></td><td>' . 'メイ' . '<input type="text" name="furigana2" size="15" form="seach" value="',$furigana2,$furigana2_2_c, $_REQUEST['furigana2'], '">';
            echo '</td>';
            //カナ苗字が空欄の時のエラー
            echo '<td>' . $error_furigana2 . '</td>
        </tr>';
        echo '<tr><td>電話番号</td><td>';
            echo '<input type="tel" name= "telno" form="seach" value= "', $telno,$telno_c,$_REQUEST['telno'] . '">';
             echo '</td>';
             echo '<td>' .$error_telno . '</td>
        </tr>';

         echo '<tr><td>生年月日</td><td>';
            //type="text" を"date"に変更しました。sudo
                echo '<input type="date" name= "birthdate" form="seach" value= "'.$birthdate. $_REQUEST['birthdate'] . '">';
             echo '</td>';
             echo '<td>' . $error_birthdate . '</td>
        </tr>';

        echo '<tr><td>メールアドレス</td><td>';
            echo '<input type="email" name= "email" form="seach" value= "'.$email.$email_c . $_REQUEST['email'] . '">';
            echo '</td>';
            echo '<td>' . $error_email . '</td>
        </tr>';

        echo '<tr><td>ログイン名</td><td>';
            echo '<input type="text" name= "login" form="seach" value= "',$login,$login_c,$_REQUEST['login']. '">';
            echo '</td>';
            echo '<td>' . $error_login . '</td>
        </tr>';
        echo '<tr><td>パスワード</td><td>';
            echo '<input type="password" name="password" form="seach" value= "',$password,$password_c,$_POST['password'], '">';
            echo '</td>';
        echo '<td>' . $error_password . '</td>
        </tr>';
        echo '<tr><td>郵便番号</td>';
            echo '<td><input type="text" name="postcode" form="seach" value="'.$postcode_1.$postcode.$postcode_cus.'"></td>';
            echo '</td>';
            echo '<td>' . $error_postcode . '</td></tr>';
        echo '<tr><td></td><td>';

            //検索ボタン
            echo '<button type="submit" name="seach" form="seach" value="seach">'.'検索'.'</button>';
        echo'</td></tr>';

        echo '<tr><td>ご住所</td></td>';
            echo '<td>'.'都道府県'.'<input type="text" name= "address1" form="seach" value= "',$address1_c,$address1,$address1_1, '">';
         echo '</td>';
            echo '<td>' . $error_address . '</td></tr>';
         echo '<tr><td></td><td>';
         $addressf=$address2_2;
         echo '市町村'.'<input type="text" name="address2" form="seach" value="',$address2_c,$address2_2,$address2,$address3, '"></td>';
            echo '<tr><td></td><td>'.
            '番地,アパート名'.'<input type="text" name="address4" form="seach" value="',$address4_c,$address4_4, '"></td>';
        echo'</tr>';

        //ログインされている時に未入力がある場合    customer-check.php  [Ln88～Ln93]2022/06/10 sudo
        $error_full =
            "<span style='color: #FF00FF;'>" . $_SESSION['error']['full'] . "</span>";
        echo '<tr><td></td><td>' . $error_full . '</td></tr>';

    echo '</table>';
    echo '</div><br>';

if (isset($_SESSION['customer'])) {
    echo '<form action = "customer-check.php" method="post" id="kakutei">';
    echo '<p style="display:inline;">';
    echo '<input type="hidden" name="name1f" form="final" value="',$_POST['name1'],'">';
    echo '<input type="hidden" name="name2f" form="final" value="',$_POST['name2'] ,'">';
    echo '<input type="hidden" name="furigana1f" form="final" value="',$_POST['furigana1'] ,'">';
    echo '<input type="hidden" name="furigana2f" form="final" value="',$_POST['furigana2'] ,'">';
    echo '<input type="hidden" name="telnof" form="final" value="',$_POST['telno'] ,'">';
    echo '<input type="hidden" name="birthdatef" form="final" value="',$_POST['birthdate'] ,'">';
    echo '<input type="hidden" name="emailf" form="final" value="',$_POST['email'] ,'">';
    echo '<input type="hidden" name="loginf" form="final" value="',$_POST['login'] ,'">';
    echo '<input type="hidden" name="passwordf" form="final" value="',$_POST['password'] ,'">';
    echo '<input type="hidden" name="postcodef" form="final" value="',$_POST['postcode'] ,'">';
    echo '<input type="hidden" name="address1f" form="final" value="',$address1 ,'">';
    echo '<input type="hidden" name="address2f" form="final" value="'. $address2.$address3 .'">';
    echo '<input type="hidden" name="address4f" form="final" value="'. $_POST['address4'] .'">';
    echo '<input type="submit" form="final" value="修正">';
    var_dump($_SESSION['customer']);
    echo '</form>';

    echo '<form action = "withdrawal-input.php" method= "post">';
    echo '<input type="submit" value="退会">';
    echo '</form>';
    echo '</p>';

}else{
    //↓追加

    echo '<form action = "customer-check.php" method="post" form="kakutei">';
    echo '<input type="hidden" name="name1f" form="final" value="',$_POST['name1'],'">';
    echo '<input type="hidden" name="name2f" form="final" value="',$_POST['name2'] ,'">';
    echo '<input type="hidden" name="furigana1f" form="final" value="',$_POST['furigana1'] ,'">';
    echo '<input type="hidden" name="furigana2f" form="final" value="',$_POST['furigana2'] ,'">';
    echo '<input type="hidden" name="telnof" form="final" value="',$_POST['telno'] ,'">';
    echo '<input type="hidden" name="birthdatef" form="final" value="',$_POST['birthdate'] ,'">';
    echo '<input type="hidden" name="emailf" form="final" value="',$_POST['email'] ,'">';
    echo '<input type="hidden" name="loginf" form="final" value="',$_POST['login'] ,'">';
    echo '<input type="hidden" name="passwordf" form="final" value="',$_POST['password'] ,'">';
    echo '<input type="hidden" name="postcodef" form="final" value="',$_POST['postcode'] ,'">';
    echo '<input type="hidden" name="address1f" form="final" value="',$address1 ,'">';
    echo '<input type="hidden" name="address2f" form="final" value="'. $address2.$address3 .'">';
    echo '<input type="hidden" name="address4f" form="final" value="'. $_POST['address4'] .'">';
    echo '<button type="submit" name="confirm" form="final" value="kakutei">'.'確定'.'</button>';
    echo '</form>';
}


//入力情報のセッションを初期化する
unset($_SESSION['form']);

//エラーのセッションを初期化する
unset($_SESSION['error']);


?>
<?php require 'footer.php'; ?>