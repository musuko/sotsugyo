<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>

<?php
// if (isset($_SESSION['admin'])) {

//     unset($_SESSION['admin']);
//     unset($_SESSION['product']);
//     unset($_SESSION['err']);
//     unset($_SESSION['taxdate']);
//     unset($_SESSION['tax']);

    echo '<div class=page>';
    echo 'ログアウトしました。';
    echo '</div>';

// } else {
//     echo '<div class=page>';
//     echo "すでにログアウトしています。";
//     echo '</div>';
// }
?>
<?php require 'footer.php'; ?>