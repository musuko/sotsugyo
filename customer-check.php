<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'dbconnect.php'; ?>

<?php


//フォームに入力されている場合
$_SESSION['form']['name1f']=$_POST['name1f'];
$_SESSION['form']['name2f']=$_POST['name2f'];
$_SESSION['form']['postcodef']=$_POST['postcodef'];
$_SESSION['form']['address1f']=$_POST['address1f'];
$_SESSION['form']['address2f']=$_POST['address2f'];
$_SESSION['form']['address4f']=$_POST['address4f'];

$_SESSION['form']['furigana1f']=$_POST['furigana1f'];
$_SESSION['form']['furigana2f']=$_POST['furigana2f'];
$_SESSION['form']['telnof']=$_POST['telnof'];
$_SESSION['form']['birthdatef']=$_POST['birthdatef'];
$_SESSION['form']['emailf']=$_POST['emailf'];
$_SESSION['form']['loginf']=$_POST['loginf'];
$_SESSION['form']['passwordf']=$_POST['passwordf'];
//消す
echo '<div class="page">';
echo '</div>';
//エラーチェックをする
//未記入エラー
//ログインされていなかったら

if (!isset($_SESSION['customer'])){
    //name1が苗字
    if (empty($_POST['name1f'])){
        $_SESSION['error']['name1']='苗字が未入力です。';
    }
    //name2が名
    if (empty($_POST['name2f'])){
        $_SESSION['error']['name2']='名前が未入力です。';
    }
    //カタカナ欄 苗字
    if (empty($_POST['furigana1f'])){
     $_SESSION['error']['furigana1']='フリガナの欄が未入力です。';
    }else{
        //全角の平仮名のみカタカナに変換 ='C' 超入門p157
       $_SESSION['form']['furigana1f']=mb_convert_kana($_SESSION['form']['furigana1f'],'C');
       //フリガナ入力チェック
        if(!preg_match("/^[ァ-ヾ]+$/u",$_SESSION['form']['furigana1f'])){
            $_SESSION['error']['furigana1']='フリガナで入力してください。';
        }
    }//カタカナ欄 名
    if (empty($_POST['furigana2f'])){
        $_SESSION['error']['furigana2']='フリガナの欄が未入力です。';
       }else{
           //全角の平仮名のみカタカナに変換 ='C' 超入門p157furigana1
          $_SESSION['form']['furigana2f']=mb_convert_kana($_SESSION['form']['furigana2f'],'C');
          //フリガナ入力チェック
           if(!preg_match("/^[ァ-ヾ]+$/u",$_SESSION['form']['furigana2f'])){
               $_SESSION['error']['furigana2']='フリガナで入力してください。';
           }
       }
    if (empty($_POST['postcodef'])){
         $_SESSION['error']['postcode']='郵便番号が未入力です。';
        //エラー内容を追記
    //数字以外が入力されていた場合
    }elseif(!preg_match('/^[0-9]{7}$/',$_SESSION['form']['postcodef'])){
        $_SESSION['error']['postcode']='適切な郵便番号ではありません。';
    }else{ 
    //数字7桁以外の場合
        if (!preg_match('/^[0-9]{7}$/',$_POST['postcodef'])){
            $_SESSION['error']['postcode']='数字7文字で入力してください';
        }
    }
    if (empty($_POST['address1f'])||empty($_POST['address2f'])){
        $_SESSION['error']['address']='住所が未入力です。';
    }

    if (empty($_POST['telnof'])){
        $_SESSION['error']['telno']='電話番号が未入力です。';
       //アルファベットなどが入力さえていた場合
    }elseif(!is_numeric($_POST['telnof'])){
        $_SESSION['error']['telno']='そちらの電話番号は使用出来ません。';
    }else{ 
        //数字以外が入力されていた場合
        if (!preg_match('/[0-9]+/',$_POST['telnof'])){
            $_SESSION['error']['telno']='適切な電話番号ではありません。';
        }
    }
    if (empty($_POST['birthdatef'])){
        $_SESSION['error']['birthdate']='生年月日が未入力です。';
    }
    if (empty($_POST['emailf'])){
        $_SESSION['error']['email']='メールアドレス入力が未入力です。';
    }

    if (empty($_POST['loginf'])){
        $_SESSION['error']['login']='ログイン名が未入力です。';
        //エラー内容を追記  2022/06-10
        //IDの厳重チェック
    }elseif(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{4,}$/',$_POST['loginf'])){
        $_SESSION['error']['login']='4文字以上で英小字,英大字,数字,各1文字以上を含むこと';
    }else{
        //SQLで読み込み
        $IDmiss= $pdo->prepare('SELECT COUNT(*) as cut FROM customer WHERE login=?');
        $IDmiss->bindParam(1,$_POST['loginf'], PDO::PARAM_STR);
        $IDmiss->execute();
        $IDmiss_2 = $IDmiss->fetch();
        //IDの重複チェック
        if ($IDmiss_2['cut'] >0 ){
            $_SESSION['error']['login']='ログイン名がすでに使用されていますので、変更してください。';
        }
    }
    if (empty($_POST['passwordf'])){
        $_SESSION['error']['password']='パスワード未入力です。';
        //エラー内容を追記
        //パスワードの入力チェック☑
    }elseif(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8,}$/',$_POST['passwordf'])){
        $_SESSION['error']['password']='8文字以上で英小字,英大字,数字,各1文字以上を含むこと';
    }else{
        //IDとパスワードの重複チェック
        if ($_POST['loginf']== $_POST['passwordf']){
            $_SESSION['error']['password']='ログイン名と別々にしてください';
        }
    }
    //エラー内容を追記できます～2022/06/08sudo

//ログインされている状態でのチェック☑
        //未入力チェック☑
}elseif(empty($_POST['name1f'])){
    $_SESSION['error']['full']='未入力の欄があります。';
    var_dump($_SESSION['form']);
}//郵便番号編
elseif(!is_numeric($_POST['postcodef'])) {
    $_SESSION['error']['postcode']='適切な郵便番号ではありません。';
}elseif(!preg_match('/^[0-9]{7}$/',$_POST['postcode'])){
    $_SESSION['error']['postcode']='数字7文字で入力してください';
    //電話番号編
}elseif(!is_numeric($_POST['telnof'])){
    $_SESSION['error']['telno']='そちらの電話番号は使用出来ません。';
}elseif(!preg_match('/[0-9]+/',$_POST['telnof'])){
    $_SESSION['error']['telno']='適切な電話番号ではありません。';
    //IDとパスワードの重複チェック
}elseif($_POST['login']== $_POST['passwordf']){
    $_SESSION['error']['password']='ログイン名と別々にしてください';
    //パスワード設定
}elseif(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8,}$/',$_POST['passwordf'])){
    $_SESSION['error']['password']='8文字以上で英小字,英大字,数字,各1文字以上を含むこと';
    //ID設定
}elseif(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{4,}$/',$_POST['loginf'])){
    $_SESSION['error']['login']='4文字以上で英小字,英大字,数字,各1文字以上を含むこと';
}

    header("Location:customer-input.php");

//エラーがない場合
if ($_SESSION['error'] == '') {
    header("Location:customer-confirm.php");
}
echo $_POST['address4'];
echo $_SESSION['form']['postcodef'] .'aaa';echo '<br>';
echo $_POST['postcodef'] .'a';echo '<br>';
echo $_SESSION['form']['address1f'] .'bbb';echo '<br>';
echo $_SESSION['form']['address2f'] .'ccc';echo '<br>';
echo $_SESSION['form']['address4f'] .'e-girls';echo '<br>';
var_dump($_SESSION['customer']);
echo '<a href="customer-input.php">戻る</a>';
echo '<a href="customer-confirm.php">進む</a>';




?>


























<?php require 'footer.php'; ?>