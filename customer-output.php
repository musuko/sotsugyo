<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require('dbconnect.php'); ?>

<?php
echo '<div class="page"></div>';
//変数にチェック済みの入力内容を代入する

$id = $_SESSION['customer']['id'];
$name1 = $_SESSION['form']['name1f'];
$name2 = $_SESSION['form']['name2f'];
$furigana1 = $_SESSION['form']['furigana1f'];
$furigana2 = $_SESSION['form']['furigana2f'];
$postcode = $_SESSION['form']['postcodef'];
$address = $_SESSION['form']['address1f'].$_SESSION['form']['address2f'].$_SESSION['form']['address4f'];
$telno = $_SESSION['form']['telnof'];
$birthdate = $_SESSION['form']['birthdatef'];
$email = $_SESSION['form']['emailf'];
$login = $_SESSION['form']['loginf'];
$password = $_SESSION['form']['passwordf'];

//ログイン名の重複を確認する
if (isset($_SESSION['customer'])) {

    $sql=$pdo->prepare('SELECT * FROM customer WHERE id!=? and login=?');
    $sql->bindParam (1, $id, PDO::PARAM_INT);
	$sql->bindParam (2, htmlspecialchars($login), PDO::PARAM_STR);
	$sql->execute();

} else {

    $sql=$pdo->prepare('SELECT * FROM customer WHERE login=?');
    $sql->bindParam (1, htmlspecialchars($login), PDO::PARAM_STR);
	$sql->execute();
}


//ログイン名が重複しない場合
if (empty($sql->fetchAll())){

    //更新
    if (isset($_SESSION['customer'])){
        $birthdate = str_replace('-','',$birthdate);
        $sql=$pdo->prepare
        ('UPDATE customer SET name1=?, name2=?, address=?, login=?, password=?, postcode=?,
        furigana1=?, furigana2=?, telno=?, birthdate=?, email=? WHERE id=?');

        $sql->bindParam (1, htmlspecialchars($name1), PDO::PARAM_STR);
        $sql->bindParam (2, htmlspecialchars($name2), PDO::PARAM_STR);
        $sql->bindParam (3, htmlspecialchars($address), PDO::PARAM_STR);
        $sql->bindParam (4, htmlspecialchars($login), PDO::PARAM_STR);
        $sql->bindParam (5, htmlspecialchars($password), PDO::PARAM_STR);
        $sql->bindParam (6, htmlspecialchars($postcode), PDO::PARAM_INT);
        $sql->bindParam (7, htmlspecialchars($furigana1), PDO::PARAM_STR);
        $sql->bindParam (8, htmlspecialchars($furigana2), PDO::PARAM_STR);
        $sql->bindParam (9, htmlspecialchars($telno), PDO::PARAM_INT);
        $sql->bindParam (10, htmlspecialchars($birthdate), PDO::PARAM_INT);
        $sql->bindParam (11, htmlspecialchars($email), PDO::PARAM_STR);
        $sql->bindParam (12, $id, PDO::PARAM_INT);

        $sql->execute();

        echo '<div class=page>お客様情報を更新しました。</div>';

        //入力情報のセッションを初期化する
        //var_dump($_SESSION['form']);
        unset($_SESSION['form']);
        

    //登録
    } else {

        $sql=$pdo->prepare
        ('INSERT INTO customer SET name1=?, name2=?, address=?, login=?, password=?, postcode=?,
        furigana1=?, furigana2=?, telno=?, birthdate=?, email=?, enrollment_date=?');

        $enrollment_date = date('Ymd');
        //str_replace
        $birthdate_f = str_replace('-','',$birthdate);

        $sql->bindParam (1, htmlspecialchars($name1), PDO::PARAM_STR);
        $sql->bindParam (2, htmlspecialchars($name2), PDO::PARAM_STR);
        $sql->bindParam (3, htmlspecialchars($address), PDO::PARAM_STR);
        $sql->bindParam (4, htmlspecialchars($login), PDO::PARAM_STR);
        $sql->bindParam (5, htmlspecialchars($password), PDO::PARAM_STR);
        $sql->bindParam (6, htmlspecialchars($postcode), PDO::PARAM_INT);
        $sql->bindParam (7, htmlspecialchars($furigana1), PDO::PARAM_STR);
        $sql->bindParam (8, htmlspecialchars($furigana2), PDO::PARAM_STR);
        $sql->bindParam (9, htmlspecialchars($telno), PDO::PARAM_INT);
        $sql->bindParam (10, htmlspecialchars($birthdate_f), PDO::PARAM_INT);
        $sql->bindParam (11, htmlspecialchars($email), PDO::PARAM_STR);
        $sql->bindParam (12, $enrollment_date, PDO::PARAM_INT);
        ;
        $sql->execute();
        $_SESSION['customer']=[
            'id'=>$id,
            'name1'=>$name1,
            'name2'=>$name2,
            'address'=>$address,
            'login'=>$login,
            'password'=>$password,
            'postcode'=>$postcode,
            'furigana1'=>$furigana1,
            'furigana2'=>$furigana2,
            'telno'=>$telno,
            'birthdate'=>$birthdate,
            'email'=>$email,
        ];
        echo '<div class=page>お客様情報を登録しました。</div>';
        
        //入力情報のセッションを初期化する
        unset($_SESSION['form']);
        unset($_SESSION['customer']);
        //var_dump($_SESSION['customer']);
    }

}else{

    echo '<div class=page>ログイン名がすでに使用されているので、変更してください。</div>';
}


?>
<?php require 'footer.php'; ?>