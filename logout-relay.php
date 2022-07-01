<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php
if (isset($_SESSION['customer'])) {

    unset($_SESSION['customer']);
    unset($_SESSION['product']);
    unset($_SESSION['review']);

}
header ('location: logout-output.php');
?>
<?php require 'footer.php'; ?>