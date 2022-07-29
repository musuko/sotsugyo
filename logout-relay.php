<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php
if (isset($_SESSION['customer'])) {
    unset($_SESSION['customer']);
}
if (isset($_SESSION['product'])) {
    unset($_SESSION['product']);
}
if (isset($_SESSION['review'])) {
    unset($_SESSION['review']);
}
if (isset($_SESSION['sale'])) {
    unset($_SESSION['sale']);
}
header ('location: logout-output.php');
?>
<?php require 'footer.php'; ?>