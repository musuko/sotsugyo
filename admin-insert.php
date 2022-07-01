<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>
<?php require 'common.php'; ?>

<?php

    //フォーム From admin-check.php
    if (isset($_SESSION['form'])) {

    $name1 = h($_SESSION['form']['name1']);
    $name2 = h($_SESSION['form']['name2']);

    $furigana1 = h($_SESSION['form']['furigana1']);
    $furigana2 = h($_SESSION['form']['furigana2']);

    $office_id = h($_SESSION['form']['office_id']);
    $office_name = h($_SESSION['form']['office_name']);

    $department_id = h($_SESSION['form']['department_id']);
    $department_name = h($_SESSION['form']['department_name']);

    $telno = h($_SESSION['form']['telno']);
    $email = h($_SESSION['form']['email']);

    $birth_year = h($_SESSION['form']['birth_year']);
    $birth_month = h($_SESSION['form']['birth_month']);
    $birth_day = h($_SESSION['form']['birth_day']);

    $hire_year = h($_SESSION['form']['hire_year']);
    $hire_month = h($_SESSION['form']['hire_month']);
    $hire_day = h($_SESSION['form']['hire_day']);

    $authority = h($_SESSION['form']['authority']);
    $login = h($_SESSION['form']['login']);
    $password = h($_SESSION['form']['password']);

    $picture = h($_SESSION['form']['picture']);

    }

    //エラー
    //未入力
    $blank_name =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_name'] ."</span>";
    $blank_furigana =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_furigana'] ."</span>";
    $blank_office =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_office'] ."</span>";
    $blank_department =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_department'] ."</span>";
    $blank_telno =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_telno'] ."</span>";
    $blank_email =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_email'] ."</span>";
    $blank_birthdate =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_birthdate'] ."</span>";
    $blank_hiredate =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_hiredate'] ."</span>";
    $blank_authority =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_authority'] ."</span>";
    $blank_login =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_login'] ."</span>";
    $blank_password =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_password'] ."</span>";
    $blank_picture =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_picture'] ."</span>";
    //名前
    $bite_name = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_name'] ."</span>";
    $kana_furinaga = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['kana_furigana'] ."</span>";
    //英数字記号
    $num_office_id = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['num_office_id'] ."</span>";
    $bite_office_name = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_office_name'] ."</span>";
    $num_department_id = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['num_department_id'] ."</span>";
    $bite_department_name = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_department_name'] ."</span>";
    $bite_telno = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_telno'] ."</span>";
    $hyphen_telno = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['hyphen_telno'] ."</span>";
    $ng_telno = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_telno'] ."</span>";
    $bite_email = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_email'] ."</span>";
    $ng_email = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_email'] ."</span>";
    //年月日
    $bite_birthdate = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_birthdate'] ."</span>";
    $ng_birthdate = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_birthdate'] ."</span>";
    $bite_hiredate = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_hiredate'] ."</span>";
    $ng_hiredate = 
    "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_hiredate'] ."</span>";
    //ログイン
    $bite_login =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_login'] ."</span>";
    $ng_login =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_login'] ."</span>";
    $used_login =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['used_login'] ."</span>";
    //パスワード
    $bite_password =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_password'] ."</span>";
    $ng_password =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_password'] ."</span>";
    $same_password =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['same_password'] ."</span>";
    //写真
    $bite_picture =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_picture'] ."</span>";
    $ng_picture =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_picture'] ."</span>";

//フォーム
echo '<form action = "admin-check.php" method= "post">';
echo '<div class=page>';
echo '<table>';
echo '<tr><td><b>社員登録</b></td><td class=form-td></td><td class=form-td></td></tr>';

echo '<tr><td>名前</td><td class=form-td>';
echo '姓 <input type="text" name= "name1" value="' . $name1 . '"> ';
echo '名 <input type="text" name= "name2" value="' . $name2 . '">';
echo '</td>';
echo '<td class=form-td>'.
        $blank_name.$bite_name.
        '</td></tr>';

echo '<tr><td>フリガナ</td><td class=form-td>';
echo '姓 <input type="text" name= "furigana1" value="' . $furigana1 . '"> ',
     '名 <input type="text" name= "furigana2" value="' . $furigana2 . '">';
echo '</td>';
echo '<td class=form-td>'.
        $blank_furigana.$kana_furinaga.
        '</td></tr>';

echo '<tr><td>所属</td><td class=form-td>';
echo '番号 <input class="form-input1" type="text" name= "office_id" value="' . $office_id . '"> ';
echo '事業所名 <input class="form-input2" type="text" name= "office_name" value="' . $office_name . '">';
echo '</td>';
echo '<td class=form-td>'.
        $blank_office.$num_office_id.$bite_office_name.
        '</td></tr>';

echo '<tr><td></td><td class=form-td>';
echo '番号 <input class="form-input1" type="text" name= "department_id" value="' . $department_id . '"> ';
echo '部課名&emsp; <input class="form-input2" type="text" name= "department_name" value="' . $department_name . '">';
echo '</td>';
echo '<td class=form-td>'.
        $blank_department.$num_department_id.$bite_department_name.
        '</td></tr>';

echo '<tr><td>連絡先</td><td class=form-td>';
echo '電話番号&emsp;&emsp;&emsp; <input class="form-input3" type="text" name= "telno" value="' . $telno . '">';
echo '</td>';
echo '<td class=form-td>'.
        $blank_telno.$bite_telno.$hyphen_telno.$ng_telno.
        '</td></tr>';

echo '<tr><td></td><td class=form-td>';
echo 'メールアドレス <input class="form-input3" type="text" name= "email" value="' . $email . '">';
echo '</td>';
echo '<td class=form-td>'.
        $blank_email.$bite_email.$ng_email;
        '</td></tr>';

echo '<tr><td>生年月日</td><td class=form-td>';
echo '<input class="form-input4" type="text" name= "birth_year"  value="' . $birth_year . '"> 年 ',
     '<input class="form-input4" type="text" name= "birth_month" value="' . $birth_month . '"> 月 ',
     '<input class="form-input4" type="text" name= "birth_day"  value="' . $birth_day . '"> 日 ';
echo '</td>';
echo '<td class=form-td>'.
        $blank_birthdate.$bite_birthdate.$ng_birthdate.
        '</td></tr>';

echo '<tr><td>入社日</td><td class=form-td>';
echo '<input class="form-input4" type="text" name= "hire_year"  value="' . $hire_year . '"> 年 ',
     '<input class="form-input4" type="text" name= "hire_month" value="' . $hire_month . '"> 月 ',
     '<input class="form-input4" type="text" name= "hire_day"  value="' . $hire_day . '"> 日 ';
echo '</td>';
echo '<td class=form-td>'.
        $blank_hiredate.$bite_hiredate.$ng_hiredate.
        '</td></tr>';

echo '<tr><td>管理情報</td><td class=form-td>';
echo '権限 ';
echo '<select class="form-input1" name="authority">';
echo '<option></option>';

if ($authority == '-') {
    echo '<option value="-" selected>-</option>';
} else {
    echo '<option value="-">-</option>';
}
if ($authority == 'r') {
    echo '<option value="r" selected>r</option>';
} else {
    echo '<option value="r">r</option>';
}
if ($authority == 'rw') {
    echo '<option value="rw" selected>rw</option>';
} else {
    echo '<option value="rw">rw</option>';
}

echo '</select>';

echo ' ログインID <input class="form-input5" type="text" name= "login" value="' . $login . '">';
echo '</td>';
echo '<td class=form-td>'.
        $blank_authority.$blank_login.$bite_login.$ng_login.$used_login.
        '</td></tr>';

echo '<tr><td></td><td class=form-td>';
echo 'ログインパス&emsp; <input class="form-input3" type="text" name= "password" value="' . $password . '">';
echo '</td>';
echo '<td class=form-td>'.
        $blank_password.$bite_password.$ng_password.$same_password.
        '</td></tr>';

echo '<tr><td>写真</td><td class=form-td>';
echo 'ファイル名&emsp;&emsp; <input class="form-input3" type="text" name= "picture" value="' . $picture . '">';
echo '</td>';
echo '<td class=form-td>'.
        $blank_picture.$bite_picture.$ng_picture.
        '</td></tr>';

echo '</table>';
echo '</div><br>';

echo '&emsp;&emsp;&emsp;&emsp;&emsp;<button type="submit" name="action" value="insert">登録</button>';
echo '</form>';
echo '<p>&emsp;&emsp;&emsp;&emsp;&emsp;<a href="admin-show.php">戻る</a></p>';

unset($_SESSION['form']);
unset($_SESSION['error']);

?>
<?php require 'footer.php'; ?>