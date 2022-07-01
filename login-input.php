<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php

if (isset($_SESSION['customer']['name1'])){

    echo '<div class=page><p>ログインされています。</p></div>';

}else{

    echo '<form action="login-relay.php" method="post">';
    echo '<div class="page"> </div>';

    echo '<div class="left2"><br>';
    echo'ログイン名'.'<input type="text" name="login"><br>';
    echo 'パスワード'.'<input type="password" name="password"><br><br>';
    echo '<input type="submit" value="ログイン">';

    echo '</div>';
    echo '</form>';
}
?>
<?php require 'footer.php'; ?>