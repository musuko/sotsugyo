<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'common.php'; ?>
<?php require 'dbconnect.php'; ?>

<?php
//フォームに入力されている場合
if ($_POST != '') {
    $_SESSION['form'] = $_POST;
    //全角数字を半角数字にする。変数にしておく。
    $office_id      = mb_convert_kana($_POST['office_id'], 'n');
    $department_id  = mb_convert_kana($_POST['department_id'], 'n');
    $telno          = mb_convert_kana($_POST['telno'], 'n');
    $birth_yeer     = mb_convert_kana($_POST['birth_year'], 'n');
    $birth_month    = mb_convert_kana($_POST['birth_month'], 'n');
    $birth_day      = mb_convert_kana($_POST['birth_day'], 'n');
}

//エラーチェックをする
//名前
if (empty($_POST['name1']) || empty($_POST['name2'])){
    $_SESSION['error']['blank_name']='名前が未入力です。';
} else {
    if (!preg_match("/^[ぁ-んァ-ヶ一-龠々]+$/u", $_POST['name1']) ||
        !preg_match("/^[ぁ-んァ-ヶ一-龠々]+$/u", $_POST['name2'])) {
        $_SESSION['error']['bite_name']='名前は漢字か全角かなで入力してください。';
    }
}
//フリガナ
if (empty($_POST['furigana1']) || empty($_POST['furigana2'])){
    $_SESSION['error']['blank_furigana']='フリガナが未入力です。';
} else {
    if (!preg_match("/^[ァ-ヶ]+$/u", $_POST['furigana1']) ||
        !preg_match("/^[ァ-ヶ]+$/u", $_POST['furigana2'])) {
        $_SESSION['error']['kana_furigana']='フリガナは全角カナで入力してください。';
    }
}
//事業所
if (empty( $office_id) || empty($_POST['office_name'])){
    $_SESSION['error']['blank_office']='事業所情報が未入力です。';
} else {
    if (!preg_match("/^[0-9]+$/",  $office_id)) {
        $_SESSION['error']['num_office_id']='事業所番号は半角数字で入力してください。';

    } elseif (!preg_match("/^[ぁ-んァ-ヶ一-龠々A-Za-z0-9]+$/", $_POST['office_name'])) {
        $_SESSION['error']['bite_office_name']='事業所名は英数字を半角で入力してください。';
    }
}

//部課
if (empty($department_id) || empty($_POST['department_name'])){
    $_SESSION['error']['blank_department']='部課情報が未入力です。';
} else {
    if (!preg_match("/^[0-9]+$/", $department_id)) {
        $_SESSION['error']['num_department_id']='部課番号は半角数字で入力してください。';

    } elseif (!preg_match("/^[ぁ-んァ-ヶ一-龠々A-Za-z0-9]+$/", $_POST['department_name'])) {
        $_SESSION['error']['bite_department_name']='部課名は英数字を半角で入力してください。';
    }
}
//電話番号
if (empty( $telno)){
    $_SESSION['error']['blank_telno']='電話番号が未入力です。';
} else {
    if (preg_match("/^[０-９]+$/",  $telno)) {
        $_SESSION['error']['bite_telno']='電話番号は半角数字で入力してください。';

    } elseif (preg_match("/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/",  $telno)){
        $_SESSION['error']['hyphen_telno']='電話番号はハイフンなしで入力してください。';

    } elseif (!preg_match("/^[0-9]{10,11}$/",  $telno)) {
        $_SESSION['error']['ng_telno']='電話番号が適切ではありません。';
    }
}
//メールアドレス
if (empty($_POST['email'])){
    $_SESSION['error']['blank_email']='メールアドレスが未入力です。';
} else {
    if (preg_match("/^[ぁ-んァ-ヶ一-龠々０-９Ａ-Ｚａ-ｚ]+$/", $_POST['email'])) {
        $_SESSION['error']['bite_email']='メールアドレスは半角で入力してください。';

    } elseif (!preg_match("/^[^@]+@[^@]+$/", $_POST['email'])) {
        $_SESSION['error']['ng_email']='メールアドレスが適切ではありません。';
    }
}
//生年月日
if (empty( $birth_yeer) || empty( $birth_month) || empty( $birth_day)){
    $_SESSION['error']['blank_birthdate']='生年月日が未入力です。';
} else {
    if (preg_match("/^[ぁ-んァ-ヶ一-龠々０-９Ａ-Ｚａ-ｚ]+$/",  $birth_yeer) ||
        preg_match("/^[ぁ-んァ-ヶ一-龠々０-９Ａ-Ｚａ-ｚ]+$/",  $birth_month) ||
        preg_match("/^[ぁ-んァ-ヶ一-龠々０-９Ａ-Ｚａ-ｚ]+$/",  $birth_day)) {
        $_SESSION['error']['bite_birthdate']='生年月日は半角数字で入力してください。';

    } elseif (checkdate( $birth_month,  $birth_day,  $birth_yeer) ||
              isLeapYear( $birth_yeer)) {
    } else {
        $_SESSION['error']['ng_birthdate']='生年月日が適切ではありません。';
    }
}
//入社日
if (empty($_POST['hire_year']) || empty($_POST['hire_month']) || empty($_POST['hire_day'])){
    $_SESSION['error']['blank_hiredate']='入社日が未入力です。';
} else {
    if (preg_match("/^[ぁ-んァ-ヶ一-龠々０-９Ａ-Ｚａ-ｚ]+$/", $_POST['hire_year']) ||
        preg_match("/^[ぁ-んァ-ヶ一-龠々０-９Ａ-Ｚａ-ｚ]+$/", $_POST['hire_month']) ||
        preg_match("/^[ぁ-んァ-ヶ一-龠々０-９Ａ-Ｚａ-ｚ]+$/", $_POST['hire_day'])) {
        $_SESSION['error']['bite_hiredate']='入社日は半角数字で入力してください。';

    } elseif (checkdate($_POST['hire_month'], $_POST['hire_day'], $_POST['hire_year']) ||
              isLeapYear($_POST['hire_year'])) {
    } else {
        $_SESSION['error']['ng_hiredate']='入社日が適切ではありません。';
    }
}
//退社日
if (!empty($_POST['retire_year']) || !empty($_POST['retire_month']) || !empty($_POST['retire_day'])){

    if (preg_match("/^[ぁ-んァ-ヶ一-龠々０-９Ａ-Ｚａ-ｚ]+$/", $_POST['retire_year']) ||
        preg_match("/^[ぁ-んァ-ヶ一-龠々０-９Ａ-Ｚａ-ｚ]+$/", $_POST['retire_month']) ||
        preg_match("/^[ぁ-んァ-ヶ一-龠々０-９Ａ-Ｚａ-ｚ]+$/", $_POST['retire_day'])) {
        $_SESSION['error']['bite_retiredate']='退社日は半角数字で入力してください。';

    } elseif (checkdate($_POST['retire_month'], $_POST['retire_day'], $_POST['retire_year']) ||
              isLeapYear($_POST['retire_year'])) {
    } else {
        $_SESSION['error']['ng_retiredate']='退社日が適切ではありません。';
    }
}
//権限
if (empty($_POST['authority'])){
    $_SESSION['error']['blank_authority']='権限が未選択です。';
}
//ログインID
if (empty($_POST['login'])){
    $_SESSION['error']['blank_login']='ログインIDが未入力です。';
} else {
    if (preg_match("/^[ぁ-んァ-ヶ一-龠々０-９Ａ-Ｚａ-ｚ]+$/", $_POST['login'])) {
        $_SESSION['error']['bite_login']='ログインIDは半角英数字で入力してください。';

    } elseif (!preg_match("/^[0-9A-Za-z]{8,}$/", $_POST['login'])) {
        $_SESSION['error']['ng_login']='ログインIDは8文字以上で入力してください。';

    } else {

        if ($_POST['action'] == 'update') {

        $sql= $pdo->prepare('SELECT admin_login FROM admin WHERE admin_id!=? AND admin_login=?');
        $sql->bindParam(1, $_POST['admin_id'], PDO::PARAM_INT);
        $sql->bindParam(2, $_POST['login'], PDO::PARAM_STR);
        $sql->execute();
        $login = $sql->fetch();

        } elseif ($_POST['action'] == 'insert') {

        $sql= $pdo->prepare('SELECT admin_login FROM admin WHERE admin_login=?');
        $sql->bindParam(1, $_POST['login'], PDO::PARAM_STR);
        $sql->execute();
        $login = $sql->fetch();
        }

        if ($login != '') {
                $_SESSION['error']['used_login']='このログインIDは使用されています。';
        }
    }
}
//パスワード
if (empty($_POST['password'])){
    $_SESSION['error']['blank_password']='パスワードが未入力です。';
} else {
    if (preg_match("/^[ぁ-んァ-ヶ一-龠々０-９Ａ-Ｚａ-ｚ]+$/", $_POST['password'])) {
        $_SESSION['error']['bite_password']='パスワードは半角英数字で入力してください。';

    } elseif (!preg_match("/^[0-9A-Za-z]{8,}$/", $_POST['password'])) {
        $_SESSION['error']['ng_password']='パスワードは8文字以上で入力してください。';

    } elseif ($_POST['password'] == $_POST['login']) {
        $_SESSION['error']['same_password']='ログインIDと同じ値は使用できません。';
    }
}
//写真
if (empty($_POST['picture'])){
    $_SESSION['error']['blank_picture']='ファイル名が未入力です。';
} else {
    if (preg_match("/^[ぁ-んァ-ヶ一-龠々０-９Ａ-Ｚａ-ｚ]+$/", $_POST['picture'])) {
        $_SESSION['error']['bite_picture']='ファイル名は半角英数字で入力してください。';

    } elseif (!preg_match("/\.gif$|\.png$|\.jpg$|\.jpeg$|\.bmp$/i", $_POST['picture'])) {
        $_SESSION['error']['ng_picture']='拡張子が適切ではありません。';
    }
}

//ボタン情報を変数に代入する
$button = ($_SESSION['form']['action']);

if ($button == 'insert') {
    header("Location:admin-insert.php");

} elseif ($button == 'update') {
    header("Location:admin-edit.php");
}

//エラーがない場合
if ($_SESSION['error'] == '') {

    header("Location:admin-upd.php");

}

?>
<?php require 'footer.php'; ?>