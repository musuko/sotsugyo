<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php

unset($_SESSION['product'][$_REQUEST['id']]);
echo '<div class="page">';
echo 'カートから商品を削除しました。';
// echo '<hr>';
echo '</div>';
require 'purchase-input.php';

?>

<?php require 'footer.php'; ?>