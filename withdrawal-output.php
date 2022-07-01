<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require('dbconnect.php'); ?>

<?php

$withdrawal_date = date('Ymd');
$id = $_SESSION['customer']['id'];

$sql = $pdo->prepare
('UPDATE customer SET withdrawal_date=? WHERE id=?');
$sql->bindParam (1, $withdrawal_date, PDO::PARAM_INT);
$sql->bindParam (2, $id, PDO::PARAM_INT);
$sql->execute();

unset($_SESSION['customer']);
unset($_SESSION['product']);

echo '<div class=page>';
echo '退会が完了しました。<br>
ご利用ありがとうございました。';
echo '</div>';

?>
<?php require 'footer.php'; ?>