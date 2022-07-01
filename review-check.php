<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'common.php'; ?>
<?php require 'dbconnect.php'; ?>

<?php
//フォームに入力されている場合
if ($_POST != '') {
    $_SESSION['review'] = $_POST;
}

$rating = $_POST['rating'];
$post_name = h($_POST['post_name']);
$post_title = h($_POST['post_title']);
$post_message = h($_POST['post_message']);

//エラーチェック
//評価
if (empty($post_name)){

    $_SESSION['error']['blank_rating']='評価が未選択です。';

}

//名前
if (empty($post_name)){

    $_SESSION['error']['blank_post_name']='お名前が未入力です。';

} else {

    if (mb_strlen($post_name) > 20) {

    $_SESSION['error']['over_post_name']='文字数がオーバーしています。';

    } elseif (preg_match("/^[ 　\t\r\n]+$/", $post_name)) {

    $_SESSION['error']['blank_post_name']='文字を入力してください。';

    }
}

//タイトル
if (empty($post_title)){

    $_SESSION['error']['blank_post_title']='タイトルが未入力です。';

} else {

    if (mb_strlen($post_title) > 20) {

    $_SESSION['error']['over_post_title']='文字数がオーバーしています。';

    } elseif (preg_match("/^[ 　\t\r\n]+$/", $post_title)) {

    $_SESSION['error']['blank_post_title']='文字を入力してください。';

    }
}

//本文
if (empty($post_message)){

    $_SESSION['error']['blank_post_message']='本文が未入力です。';

} else {

    if (mb_strlen($post_message) > 250) {

    $_SESSION['error']['over_post_message']='文字数がオーバーしています。';

    } elseif (preg_match("/^[ 　\t\r\n]+$/", $post_message)) {

    $_SESSION['error']['blank_post_message']='文字を入力してください。';

    }
}

header("Location:review-input.php");

//エラーがない場合
if ($_SESSION['error'] == '') {

    header("Location:review-confirm.php");
}

?>


























<?php require 'footer.php'; ?>