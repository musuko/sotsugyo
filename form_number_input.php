<?php session_start(); ?>
<?php
$_SESSION['name'] = "ココナッツ";
$_SESSION['price'] = 1100;
$_SESSION['count'] = 3;
$_SESSION['picmini1'] = 'aaa.png';
$id = 1;
$_SESSION['product'][$id] = [
    'name' => $_SESSION['name'],
    'price' => $_SESSION['price'],
    'count' => $_SESSION['count'],
    'picmini1' => $_SESSION['picmini1']   //変更した数値をセッションに入れる
];
if (isset($_REQUEST["count"])) {
$_SESSION['product'][$id]['count'] = $_REQUEST['count'];
}
// echo ($_SESSION['product'][$id]['count']); echo '<br>';
echo '<pre>';
var_dump($_SESSION['product']); echo '<br>';
echo '</pre>';

echo '<form method="post">';
echo '<input type="number" style="font-size:30px; width:50px; height:50px;" name="count" value="' . $_SESSION['product'][$id]['count'] . '" onchange="this.form.submit()">';
echo '</form>';
?>