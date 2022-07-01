<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>
<?php require 'common.php'; ?>
<?php require 'dbconnect.php'; ?>

<?php

try {

        //URLパラメータ'admin_id' From admin.php
        $admin_id = $_REQUEST['admin_id'];
        //SQLからデータを取り出す
        if (isset($admin_id) && is_numeric($admin_id)) {

                //商品データを取り出す
                $sql = $pdo->prepare('SELECT * FROM admin WHERE admin_id=?');
                $sql->bindParam(1, $admin_id, PDO::PARAM_INT);
                $sql->execute();
                $admin = $sql->fetch();
        }
} catch (PDOException $e) {
        echo ('エラーメッセージ：' . $e->getMessage());
}

//表示データ From DB
$name1 = $admin['admin_name1'];
$name2 = $admin['admin_name2'];

$furigana1 = $admin['admin_furigana1'];
$furigana2 = $admin['admin_furigana2'];

$office_id = $admin['office_id'];
$office_name = $admin['office_name'];

$department_id = $admin['department_id'];
$department_name = $admin['department_name'];

$telno = $admin['telno'];
$email = $admin['email'];

$birth_year = substr($admin['birthdate'], 0, 4);
$birth_month = substr($admin['birthdate'], 4, 2);
$birth_day = substr($admin['birthdate'], 6, 2);

$hire_year = substr($admin['hire_date'], 0, 4);
$hire_month = substr($admin['hire_date'], 4, 2);
$hire_day = substr($admin['hire_date'], 6, 2);

$authority = $admin['authority'];
$login = $admin['admin_login'];
$password = $admin['admin_password'];

$picture = $admin['picture'];

//フォーム From admin-check.php
if (isset($_SESSION['form'])) {

        $admin_id = $_SESSION['form']['admin_id'];

        $name1 = h($_SESSION['form']['name1']);
        $name2 = h($_SESSION['form']['name2']);

        $furigana1 = h($_SESSION['form']['furigana1']);
        $furigana2 = h($_SESSION['form']['furigana2']);

        $office_id = h(mb_convert_kana($_SESSION['form']['office_id'], 'n'));
        $office_name = h($_SESSION['form']['office_name']);

        $department_id = h(mb_convert_kana($_SESSION['form']['department_id'], 'n'));
        $department_name = h($_SESSION['form']['department_name']);

        $telno = h(mb_convert_kana($_SESSION['form']['telno'], 'n'));
        $email = h($_SESSION['form']['email']);

        $birth_year = h(mb_convert_kana($_SESSION['form']['birth_year'], 'n'));
        $birth_month = h(mb_convert_kana($_SESSION['form']['birth_month'], 'n'));
        $birth_day = h(mb_convert_kana($_SESSION['form']['birth_day'], 'n'));

        $hire_year = h(mb_convert_kana($_SESSION['form']['hire_year'], 'n'));
        $hire_month = h(mb_convert_kana($_SESSION['form']['hire_month'], 'n'));
        $hire_day = h(mb_convert_kana($_SESSION['form']['hire_day'], 'n'));

        $retire_year = h($_SESSION['form']['retire_year']);
        $retire_month = h($_SESSION['form']['retire_month']);
        $retire_day = h($_SESSION['form']['retire_day']);

        $authority = h($_SESSION['form']['authority']);
        $login = h($_SESSION['form']['login']);
        $password = h($_SESSION['form']['password']);

        $picture = h($_SESSION['form']['picture']);
}

//エラー
//未入力
$blank_name =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_name'] . "</span>";
$blank_furigana =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_furigana'] . "</span>";
$blank_office =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_office'] . "</span>";
$blank_department =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_department'] . "</span>";
$blank_telno =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_telno'] . "</span>";
$blank_email =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_email'] . "</span>";
$blank_birthdate =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_birthdate'] . "</span>";
$blank_hiredate =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_hiredate'] . "</span>";
$blank_authority =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_authority'] . "</span>";
$blank_login =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_login'] . "</span>";
$blank_password =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_password'] . "</span>";
$blank_picture =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_picture'] . "</span>";
//名前
$bite_name =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_name'] . "</span>";
$kana_furinaga =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['kana_furigana'] . "</span>";
//英数字記号
$num_office_id =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['num_office_id'] . "</span>";
$bite_office_name =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_office_name'] . "</span>";
$num_department_id =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['num_department_id'] . "</span>";
$bite_department_name =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_department_name'] . "</span>";
$bite_telno =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_telno'] . "</span>";
$hyphen_telno =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['hyphen_telno'] . "</span>";
$ng_telno =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_telno'] . "</span>";
$bite_email =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_email'] . "</span>";
$ng_email =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_email'] . "</span>";
//年月日
$bite_birthdate =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_birthdate'] . "</span>";
$ng_birthdate =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_birthdate'] . "</span>";
$bite_hiredate =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_hiredate'] . "</span>";
$ng_hiredate =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_hiredate'] . "</span>";
$bite_retiredate =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_retiredate'] . "</span>";
$ng_retiredate =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_retiredate'] . "</span>";
//ログイン
$bite_login =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_login'] . "</span>";
$ng_login =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_login'] . "</span>";
$used_login =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['used_login'] . "</span>";
//パスワード
$bite_password =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_password'] . "</span>";
$ng_password =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_password'] . "</span>";
$same_password =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['same_password'] . "</span>";
//写真
$bite_picture =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['bite_picture'] . "</span>";
$ng_picture =
        "<span style='color: #FF6666;'>" . $_SESSION['error']['ng_picture'] . "</span>";

//フォーム
if ($_SESSION['admin']['authority'] == 'rw') {
        echo '<form action = "admin-check.php" method= "post">';
        echo '<div class=page>';
        echo '<table>';
        echo '<tr><td><b>社員登録</b></td><td class=form-td><b>社員番号：', $admin_id, '</b></td><td class=form-td></td></tr>';

        //URLパラメータ'admin_id'を送る　To admin-upd.php
        echo '<input type="hidden" name="admin_id" value="', $admin_id, '">';

        echo '<tr><td>名前</td><td class=form-td>';
        echo '姓 <input type="text" name= "name1" value="' . $name1 . '"> ';
        echo '名 <input type="text" name= "name2" value="' . $name2 . '">';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_name . $bite_name .
                '</td></tr>';

        echo '<tr><td>フリガナ</td><td class=form-td>';
        echo '姓 <input type="text" name= "furigana1" value="' . $furigana1 . '"> ',
        '名 <input type="text" name= "furigana2" value="' . $furigana2 . '">';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_furigana . $kana_furinaga .
                '</td></tr>';

        echo '<tr><td>所属</td><td class=form-td>';
        echo '番号 <input class="form-input1" type="text" name= "office_id" value="' . $office_id . '"> ';
        echo '事業所名 <input class="form-input2" type="text" name= "office_name" value="' . $office_name . '">';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_office . $num_office_id . $bite_office_name .
                '</td></tr>';

        echo '<tr><td></td><td class=form-td>';
        echo '番号 <input class="form-input1" type="text" name= "department_id" value="' . $department_id . '"> ';
        echo '部課名&emsp; <input class="form-input2" type="text" name= "department_name" value="' . $department_name . '">';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_department . $num_department_id . $bite_department_name .
                '</td></tr>';

        echo '<tr><td>連絡先</td><td class=form-td>';
        echo '電話番号&emsp;&emsp;&emsp; <input class="form-input3" type="text" name= "telno" value="' . $telno . '">';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_telno . $bite_telno . $hyphen_telno . $ng_telno .
                '</td></tr>';

        echo '<tr><td></td><td class=form-td>';
        echo 'メールアドレス <input class="form-input3" type="text" name= "email" value="' . $email . '">';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_email . $bite_email . $ng_email;
        '</td></tr>';

        echo '<tr><td>生年月日</td><td class=form-td>';
        echo '<input class="form-input4" type="text" name= "birth_year"  value="' . $birth_year . '"> 年 ',
        '<input class="form-input4" type="text" name= "birth_month" value="' . $birth_month . '"> 月 ',
        '<input class="form-input4" type="text" name= "birth_day"  value="' . $birth_day . '"> 日 ';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_birthdate . $bite_birthdate . $ng_birthdate .
                '</td></tr>';

        echo '<tr><td>入社日</td><td class=form-td>';
        echo '<input class="form-input4" type="text" name= "hire_year"  value="' . $hire_year . '"> 年 ',
        '<input class="form-input4" type="text" name= "hire_month" value="' . $hire_month . '"> 月 ',
        '<input class="form-input4" type="text" name= "hire_day"  value="' . $hire_day . '"> 日 ';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_hiredate . $bite_hiredate . $ng_hiredate .
                '</td></tr>';

        echo '<tr><td>退社日</td><td class=form-td>';
        echo '<input class="form-input4" type="text" name= "retire_year"  value="' . $retire_year . '"> 年 ',
        '<input class="form-input4" type="text" name= "retire_month" value="' . $retire_month . '"> 月 ',
        '<input class="form-input4" type="text" name= "retire_day"  value="' . $retire_day . '"> 日 ';
        echo '</td>';
        echo '<td class=form-td>' .
                $bite_retiredate . $ng_retiredate .
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
        echo '<td class=form-td>' .
                $blank_authority . $blank_login . $bite_login . $ng_login . $used_login .
                '</td></tr>';

        echo '<tr><td></td><td class=form-td>';

        echo 'ログインパス&emsp; <input class="form-input3" type="text" name= "password" value="' . $password . '">';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_password . $bite_password . $ng_password . $same_password .
                '</td></tr>';

        echo '<tr><td>写真</td><td class=form-td>';
        echo 'ファイル名&emsp;&emsp; <input class="form-input3" type="text" name= "picture" value="' . $picture . '">';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_picture . $bite_picture . $ng_picture .
                '</td></tr>';

        echo '</table>';
        echo '</div><br>';

        echo '&emsp;&emsp;&emsp;&emsp;';
        echo '<button type="submit" name="action" value="update">更新</button> ';
        echo '</form>';
} else {

        echo '<div class=page>';
        echo '<table>';
        echo '<tr><td><b>社員登録</b></td><td class=form-td><b>社員番号：', $admin_id, '</b></td><td class=form-td></td></tr>';

        echo '<tr><td>名前</td><td class=form-td>';
        echo '姓 <input type="text" name= "name1" value="' . $name1 . '" readonly> ';
        echo '名 <input type="text" name= "name2" value="' . $name2 . '" readonly>';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_name . $bite_name .
                '</td></tr>';

        echo '<tr><td>フリガナ</td><td class=form-td>';
        echo '姓 <input type="text" name= "furigana1" value="' . $furigana1 . '" readonly> ',
        '名 <input type="text" name= "furigana2" value="' . $furigana2 . '" readonly>';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_furigana . $kana_furinaga .
                '</td></tr>';

        echo '<tr><td>所属</td><td class=form-td>';
        echo '番号 <input class="form-input1" type="text" name= "office_id" value="' . $office_id . '" readonly> ';
        echo '事業所名 <input class="form-input2" type="text" name= "office_name" value="' . $office_name . '" readonly>';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_office . $num_office_id . $bite_office_name .
                '</td></tr>';

        echo '<tr><td></td><td class=form-td>';
        echo '番号 <input class="form-input1" type="text" name= "department_id" value="' . $department_id . '" readonly> ';
        echo '部課名&emsp; <input class="form-input2" type="text" name= "department_name" value="' . $department_name . '" readonly>';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_department . $num_department_id . $bite_department_name .
                '</td></tr>';

        echo '<tr><td>連絡先</td><td class=form-td>';
        echo '電話番号&emsp;&emsp;&emsp; <input class="form-input3" type="text" name= "telno" value="' . $telno . '" readonly>';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_telno . $bite_telno . $hyphen_telno . $ng_telno .
                '</td></tr>';

        echo '<tr><td></td><td class=form-td>';
        echo 'メールアドレス <input class="form-input3" type="text" name= "email" value="' . $email . '" readonly>';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_email . $bite_email . $ng_email;
        '</td></tr>';

        echo '<tr><td>生年月日</td><td class=form-td>';
        echo '<input class="form-input4" type="text" name= "birth_year"  value="' . $birth_year . '" readonly> 年 ',
        '<input class="form-input4" type="text" name= "birth_month" value="' . $birth_month . '" readonly> 月 ',
        '<input class="form-input4" type="text" name= "birth_day"  value="' . $birth_day . '" readonly> 日 ';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_birthdate . $bite_birthdate . $ng_birthdate .
                '</td></tr>';

        echo '<tr><td>入社日</td><td class=form-td>';
        echo '<input class="form-input4" type="text" name= "hire_year"  value="' . $hire_year . '" readonly> 年 ',
        '<input class="form-input4" type="text" name= "hire_month" value="' . $hire_month . '" readonly> 月 ',
        '<input class="form-input4" type="text" name= "hire_day"  value="' . $hire_day . '" readonly> 日 ';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_hiredate . $bite_hiredate . $ng_hiredate .
                '</td></tr>';

        echo '<tr><td>退社日</td><td class=form-td>';
        echo '<input class="form-input4" type="text" name= "retire_year"  value="' . $retire_year . '" readonly> 年 ',
        '<input class="form-input4" type="text" name= "retire_month" value="' . $retire_month . '" readonly> 月 ',
        '<input class="form-input4" type="text" name= "retire_day"  value="' . $retire_day . '" readonly> 日 ';
        echo '</td>';
        echo '<td class=form-td>' .
                $bite_retiredate . $ng_retiredate .
                '</td></tr>';

        echo '<tr><td>管理情報</td><td class=form-td>';
        echo '権限 ';
        echo '<select class="form-input1" name="authority">';

        if ($authority == '-') {
                echo '<option value="-" selected>-</option>';
        } elseif ($authority == 'r') {
                echo '<option value="r" selected>r</option>';
        } elseif ($authority == 'rw') {
                echo '<option value="rw" selected>rw</option>';
        }

        echo '</select>';

        echo ' ログインID <input class="form-input5" type="text" name= "login" value="' . $login . '" readonly>';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_authority . $blank_login . $bite_login . $ng_login . $used_login .
                '</td></tr>';

        echo '<tr><td></td><td class=form-td>';

        echo 'ログインパス&emsp; <input class="form-input3" type="password" name= "password" value="' . $password . '" readonly>';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_password . $bite_password . $ng_password . $same_password .
                '</td></tr>';

        echo '<tr><td>写真</td><td class=form-td>';
        echo 'ファイル名&emsp;&emsp; <input class="form-input3" type="text" name= "picture" value="' . $picture . '" readonly>';
        echo '</td>';
        echo '<td class=form-td>' .
                $blank_picture . $bite_picture . $ng_picture .
                '</td></tr>';

        echo '</table>';
        echo '</div><br>';
}

echo '<p>&emsp;&emsp;&emsp;&emsp;<a href="admin-show.php">戻る</a></p>';

unset($_SESSION['form']);
unset($_SESSION['error']);

?>
<?php require 'footer.php'; ?>