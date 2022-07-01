<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>
<?php require 'dbconnect.php'; ?>

<?php
echo '<div class="page"> </div>';
if (isset($_SESSION['admin']['id'])) {
    echo '<p>ログインされています。</p>';
} else {
    require 'login-form2.php';
    // echo '<form action="login-relay2.php" method="post">';
    // echo 'ログイン名' . '<input type="text" name="login"><br>';
    // echo 'パスワード' . '<input type="password" name="password"><br><br>';
    // echo '<input type="submit" value="ログイン">';
    // echo '</form>';
}
?>
<?php require 'footer.php'; ?>