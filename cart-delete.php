<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php

unset($_SESSION['product'][$_REQUEST['id']]);
echo '<div class="page"> </div>';
echo '<div class="left2">';
echo '<br>カートから商品を削除しました。';
echo '</div>';
require 'cart.php';

?>

<?php require 'footer.php'; ?>