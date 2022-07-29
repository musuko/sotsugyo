<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require('dbconnect.php'); ?>
<?php require 'common.php'; ?>

<?php
echo '<div class="page"></div>';
//変数にチェック済みの入力内容を代入する
if (isset($_SESSION['customer'])) {
    $id =        h($_SESSION['customer']['id']);
}
$name1 =     h($_SESSION['form']['name1']);
$name2 =     h($_SESSION['form']['name2']);
$furigana1 = h($_SESSION['form']['furigana1']);
$furigana2 = h($_SESSION['form']['furigana2']);
$postcode =  h($_SESSION['form']['postcode']);
$address =   h($_SESSION['form']['address1']) . h($_SESSION['form']['address2']) . h($_SESSION['form']['address3']) . h($_SESSION['form']['address4']);
$telno =     h($_SESSION['form']['telno']);
$birthdate = h($_SESSION['form']['birthdate']);
$email =     h($_SESSION['form']['email']);
$login =     h($_SESSION['form']['login']);
$password =  h($_SESSION['form']['password']);

//ログイン名の重複を確認する
if (isset($_SESSION['customer'])) {
    //ログインしている場合
    $sql = $pdo->prepare('SELECT * FROM customer WHERE id!=? and login=?'); //id != ? idが? "以外"の時･･･重要
    $sql->bindParam(1, $id, PDO::PARAM_INT);
    $sql->bindParam(2, $login, PDO::PARAM_STR);
    $sql->execute();
} else {
    //未ログインの場合
    $sql = $pdo->prepare('SELECT * FROM customer WHERE login=?');
    $sql->bindParam(1, $login, PDO::PARAM_STR);
    $sql->execute();
}


//ログイン名が重複しない場合
if (empty($sql->fetchAll())) {

    //更新
    if (isset($_SESSION['customer'])) {
        $birthdate = str_replace('-', '', $birthdate);
        $sql = $pdo->prepare('UPDATE customer SET name1=?, name2=?, address=?, login=?, password=?, postcode=?,
        furigana1=?, furigana2=?, telno=?, birthdate=?, email=? WHERE id=?');

        $sql->bindParam(1,  $name1, PDO::PARAM_STR);
        $sql->bindParam(2,  $name2, PDO::PARAM_STR);
        $sql->bindParam(3,  $address, PDO::PARAM_STR);
        $sql->bindParam(4,  $login, PDO::PARAM_STR);
        $sql->bindParam(5,  $password, PDO::PARAM_STR);
        $sql->bindParam(6,  $postcode, PDO::PARAM_INT);
        $sql->bindParam(7,  $furigana1, PDO::PARAM_STR);
        $sql->bindParam(8,  $furigana2, PDO::PARAM_STR);
        $sql->bindParam(9,  $telno, PDO::PARAM_INT);
        $sql->bindParam(10, $birthdate, PDO::PARAM_INT);
        $sql->bindParam(11, $email, PDO::PARAM_STR);
        $sql->bindParam(12, $id, PDO::PARAM_INT);

        $sql->execute();

        echo '<div class=page>お客様情報を更新しました。</div>';

        // 更新内容を$_SESSION['customer']に反映
        $_SESSION['customer']['name1'] =     h($_SESSION['form']['name1']);
        $_SESSION['customer']['name2'] =     h($_SESSION['form']['name2']);
        $_SESSION['customer']['furigana1'] = h($_SESSION['form']['furigana1']);
        $_SESSION['customer']['furigana2'] = h($_SESSION['form']['furigana2']);
        $_SESSION['customer']['postcode'] =  h($_SESSION['form']['postcode']);
        $_SESSION['customer']['address'] =   h($_SESSION['form']['address1']) . h($_SESSION['form']['address2']) . h($_SESSION['form']['address3']) . h($_SESSION['form']['address4']);
        $_SESSION['customer']['telno'] =     h($_SESSION['form']['telno']);
        $_SESSION['customer']['birthdate'] = h($_SESSION['form']['birthdate']);
        $_SESSION['customer']['email'] =     h($_SESSION['form']['email']);
        $_SESSION['customer']['login'] =     h($_SESSION['form']['login']);
        $_SESSION['customer']['password'] =  h($_SESSION['form']['password']);

        //入力情報のセッションを初期化する
        //var_dump($_SESSION['form']);
        unset($_SESSION['form']);


        //登録
    } else {

        $sql = $pdo->prepare('INSERT INTO customer SET name1=?, name2=?, address=?, login=?, password=?, postcode=?,
        furigana1=?, furigana2=?, telno=?, birthdate=?, email=?, enrollment_date=?');

        $enrollment_date = date('Ymd');
        //str_replace
        $birthdate_f = str_replace('-', '', $birthdate);

        $sql->bindParam(1, $name1, PDO::PARAM_STR);
        $sql->bindParam(2, $name2, PDO::PARAM_STR);
        $sql->bindParam(3, $address, PDO::PARAM_STR);
        $sql->bindParam(4, $login, PDO::PARAM_STR);
        $sql->bindParam(5, $password, PDO::PARAM_STR);
        $sql->bindParam(6, $postcode, PDO::PARAM_INT);
        $sql->bindParam(7, $furigana1, PDO::PARAM_STR);
        $sql->bindParam(8, $furigana2, PDO::PARAM_STR);
        $sql->bindParam(9, $telno, PDO::PARAM_INT);
        $sql->bindParam(10, $birthdate_f, PDO::PARAM_INT);
        $sql->bindParam(11, $email, PDO::PARAM_STR);
        $sql->bindParam(12, $enrollment_date, PDO::PARAM_INT);;
        $sql->execute();

        //新規登録idを確認
        $sql = $pdo->prepare('SELECT id from customer');// idを全て読み込む
        $sql->execute();
        $row = $sql -> fetchall();  //$rowの配列にする
        $id = end($row);            //不細工だが、$rowの最後の値(2つ)を選択
        $id = end($id);             //二つの値の最後を選択
        // echo $id;

        $_SESSION['customer'] = [
            'id' => $id,
            'name1' => $name1,
            'name2' => $name2,
            'address' => $address,
            'login' => $login,
            'password' => $password,
            'postcode' => $postcode,
            'furigana1' => $furigana1,
            'furigana2' => $furigana2,
            'telno' => $telno,
            'birthdate' => $birthdate,
            'email' => $email,
        ];
        echo '<div class=page>お客様情報を登録しました。</div>';

        //入力情報のセッションを初期化する
        unset($_SESSION['form']);
        unset($_SESSION['customer']);
        //var_dump($_SESSION['customer']);
    }
} else {

    echo '<div class=page>ログイン名がすでに使用されているので、変更してください。</div>';
}


?>
<?php require 'footer.php'; ?>