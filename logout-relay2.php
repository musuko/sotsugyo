<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>

<?php
if (isset($_SESSION['admin'])) {

    unset($_SESSION['admin']);
    unset($_SESSION['product']);
    unset($_SESSION['err']);
    unset($_SESSION['taxdate']);
    unset($_SESSION['tax']);

    echo '<div class=page>';
    echo 'ログアウトしました。';
    echo '</div>';

}
header ('location: logout-output2.php');
?>
<?php require 'footer.php'; ?>