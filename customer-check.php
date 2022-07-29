<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'dbconnect.php'; ?>
<?php require 'common.php'; ?>

<?php
echo '<div class="page">';
echo '</div>';
$_SESSION['form'] = [];
$_SESSION['error']['name1'] = $_SESSION['error']['name2'] = $_SESSION['error']['postcode'] =
    $_SESSION['error']['address'] = $_SESSION['error']['furigana1']  = $_SESSION['error']['furigana2']
    = $_SESSION['error']['telno'] = $_SESSION['error']['birthdate'] = $_SESSION['error']['email']
    = $_SESSION['error']['login'] = $_SESSION['error']['password'] =  "";

//フォームで送られた情報をフィルターをかけて変数にする。
$name1     = trim(filter_input(INPUT_POST, "name1"));
$name2     = trim(filter_input(INPUT_POST, "name2"));
$postcode  = trim(filter_input(INPUT_POST, "postcode"));
$address1  = trim(filter_input(INPUT_POST, "address1"));
$address2  = trim(filter_input(INPUT_POST, "address2"));
$address3  = trim(filter_input(INPUT_POST, "address3"));
$address4  = trim(filter_input(INPUT_POST, "address4"));
$furigana1 = trim(filter_input(INPUT_POST, "furigana1"));
$furigana2 = trim(filter_input(INPUT_POST, "furigana2"));
$telno     = trim(filter_input(INPUT_POST, "telno"));
$birthdate = trim(filter_input(INPUT_POST, "birthdate"));
$email     = trim(filter_input(INPUT_POST, "email"));
$login     = trim(filter_input(INPUT_POST, "login"));
$password  = trim(filter_input(INPUT_POST, "password"));
//全角半角を整える
$postcode  = mb_convert_kana($postcode, 'n');  //n: 全角数字を半角に。
$furigana1 = mb_convert_kana($furigana1, 'C'); //C: ひらがなをカタカナに。
$furigana1 = mb_convert_kana($furigana1, 'K'); //C: 半角カタカナを全角カタカナに。
$furigana2 = mb_convert_kana($furigana2, 'C'); //C: ひらがなをカタカナに。
$furigana2 = mb_convert_kana($furigana2, 'K'); //C: 半角カタカナを全角カタカナに。
$telno = mb_convert_kana($telno, 'n');  //n: 全角数字を半角に。

//フォームで送られた内容を入れた変数をセッションに収め、OKならcustomer-confirm.phpへ送る。
$_SESSION['form']['name1'] = $name1;
$_SESSION['form']['name2'] = $name2;
$_SESSION['form']['postcode'] = $postcode;
$_SESSION['form']['address1'] = $address1;
$_SESSION['form']['address2'] = $address2;
$_SESSION['form']['address3'] = $address3;
$_SESSION['form']['address4'] = $address4;

$_SESSION['form']['furigana1'] = $furigana1;
$_SESSION['form']['furigana2'] = $furigana2;
$_SESSION['form']['telno'] = $telno;
$_SESSION['form']['birthdate'] = $birthdate;
$_SESSION['form']['email'] = $email;
$_SESSION['form']['login'] = $login;
$_SESSION['form']['password'] = $password;
//消す

//エラーチェックをする
//ログインされていない場合
if (!isset($_SESSION['customer'])) {
    //name1が苗字
    if (empty($name1)) {
        $_SESSION['error']['name1'] = '苗字が未入力です。';
    }
    //name2が名
    if (empty($name2)) {
        $_SESSION['error']['name2'] = '名前が未入力です。';
    }
    //カタカナ欄 苗字
    if (empty($furigana1)) {
        $_SESSION['error']['furigana1'] = 'フリガナ苗字の欄が未入力です。';
    } elseif (!preg_match("/^[ァ-ヾ]+$/u", $furigana1)) {
        $_SESSION['error']['furigana1'] = 'カタカナで入力してください。';
    }
    //カタカナ欄 名
    if (empty($furigana2)) {
        $_SESSION['error']['furigana2'] = 'フリガナ名前の欄が未入力です。';
        //フリガナ入力チェック
    } elseif (!preg_match("/^[ァ-ヾ]+$/u", $furigana2)) {
        $_SESSION['error']['furigana2'] = 'カタカナで入力してください。';
    }

    if (empty($postcode)) {
        $_SESSION['error']['postcode'] = '郵便番号が未入力です。';
        //エラー内容を追記
        //数字以外が入力されていた場合
    } elseif (!preg_match('/^[0-9]{7}$/', $postcode)) {
        $_SESSION['error']['postcode'] = '適切な郵便番号ではありません。';
        //数字7桁以外の場合
    } elseif (!preg_match('/^[0-9]{7}$/', $postcode)) {
        $_SESSION['error']['postcode'] = '数字7文字で入力してください';
    }

    if (empty($address1) || empty($address2) || empty($address3) || empty($address4)) {
        $_SESSION['error']['address'] = '住所が未入力です。';
    }

    if (empty($telno)) {
        $_SESSION['error']['telno'] = '電話番号が未入力です。';
        //アルファベットなどが入力さえていた場合
    } elseif (!is_numeric($telno)) {
        $_SESSION['error']['telno'] = 'その電話番号は使用出来ません。';
    } else {
        //数字以外が入力されていた場合
        if (!preg_match('/[0-9]+/', $telno)) {
            $_SESSION['error']['telno'] = '適切な電話番号ではありません。';
        }
    }
    if (empty($birthdate)) {
        $_SESSION['error']['birthdate'] = '生年月日が未入力です。';
    }
    if (empty($email)) {
        $_SESSION['error']['email'] = 'メールアドレス入力が未入力です。';
    }

    if (empty($login)) {
        $_SESSION['error']['login'] = 'ログイン名が未入力です。';
        //エラー内容を追記  2022/06-10
        //IDの厳重チェック
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{4,}$/', $login)) {
        $_SESSION['error']['login'] = '4文字以上で英小字,英大字,数字,各1文字以上を含むこと';
        //重複チェック
    } else {
        //SQLで同じログインidの個数をカウント
        $IDmiss = $pdo->prepare('SELECT COUNT(*) as cut FROM customer WHERE login=?');
        $IDmiss->bindParam(1, $login, PDO::PARAM_STR);
        $IDmiss->execute();
        $IDmiss_2 = $IDmiss->fetch();
        //IDの重複チェック。0個より大きい場合、ログインidを受け付けない。
        if ($IDmiss_2['cut'] > 0) {
            $_SESSION['error']['login'] = 'ログイン名がすでに使用されていますので、変更してください。';
        }
    }
    if (empty($password)) {
        $_SESSION['error']['password'] = 'パスワード未入力です。';
        //エラー内容を追記
        //パスワードの入力チェック☑
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8,}$/', $password)) {
        $_SESSION['error']['password'] = '8文字以上で英小字,英大字,数字,各1文字以上を含むこと';
        //IDとパスワードの重複チェック
    } elseif ($login === $password) {
        $_SESSION['error']['password'] = 'ログイン名とパスワードは別々にしてください';
    }

    //エラー内容を追記できます～2022/06/08sudo

    //ログインされている状態でのチェック☑
    //未入力チェック☑
} elseif (empty($name1)) {
    $_SESSION['error']['name1'] = '未入力の欄があります。';
    var_dump($_SESSION['form']);
} //郵便番号編
elseif (!is_numeric($postcode)) {
    $_SESSION['error']['postcode'] = '適切な郵便番号ではありません。';
} elseif (!preg_match('/^[0-9]{7}$/', $postcode)) {
    $_SESSION['error']['postcode'] = '数字7文字で入力してください';
    //電話番号編
} elseif (!is_numeric($telno)) {
    $_SESSION['error']['telno'] = 'その電話番号は使用出来ません。';
} elseif (!preg_match('/[0-9]+/', $telno)) {
    $_SESSION['error']['telno'] = '適切な電話番号ではありません。';
    //IDとパスワードの重複チェック
} elseif ($login === $password) {
    $_SESSION['error']['password'] = 'ログイン名と別々にしてください';
    //パスワード設定
} elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8,}$/', $password)) {
    $_SESSION['error']['password'] = '8文字以上で英小字,英大字,数字,各1文字以上を含むこと';
    //ID設定
} elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{4,}$/', $login)) {
    $_SESSION['error']['login'] = '4文字以上で英小字,英大字,数字,各1文字以上を含むこと';
}


if (count(array_filter($_SESSION['error']) ) !== 0) {
    //エラーがある場合
    header("Location:customer-input.php");
    // echo '<a href="customer-input.php">戻る</a>';
} else {
    //エラーがない場合
    header("Location:customer-confirm.php");
    // echo '<a href="customer-confirm.php">進む</a>';
}

// var_dump($_SESSION['form']);echo '<br>';
var_dump($_SESSION['error']);
?>


























<?php require 'footer.php'; ?>