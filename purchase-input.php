<?php if(!isset($_SESSION)){ session_start(); } ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php

if (isset($_SESSION['customer']) && !empty($_SESSION['product'])) {

//変数にログインした顧客情報を代入する
$name = $_SESSION['customer']['name1'] . $_SESSION['customer']['name2'];
$zip1 = substr($_SESSION['customer']['postcode'] ,0,3);
$zip2 = substr($_SESSION['customer']['postcode'] ,3,4);
$zipcode = $zip1 . "-" . $zip2;
$address = $_SESSION['customer']['address'];
echo '<div class="page"> </div>';
//このファイル名を$file_nameに入れる。curt.phpに送るため。
$path = __FILE__;
$filename = basename($path);
// $_SESSION['filename'] = basename($path);
echo '<div class="left2">';
echo 'お名前：', $name, ' 様';
echo '<br>';
echo 'ご住所：', $zipcode, ' ', $address;
echo '</div>';
require 'cart.php';

echo '<br>';
echo '<div class="left2">';
echo '<p>内容をご確認いただき、購入を確定してください。</p>';

echo '<br><a href="purchase-output.php">購入を確定する</a>';
echo '<br><br></div>';

} elseif (isset($_SESSION['customer']) && empty($_SESSION['product'])) {
    echo '<div class="page"> </div>';
    echo '<div class="left2">';
	echo '<span style="color: #FF6666;">商品をカートに入れてください。</span>';
    echo '</div>';

} else {
    echo '<div class="page"> </div>';
    echo '<div class="left2">';
	echo '<p>商品を購入するには、ログインしてください。</p>';
    $_SESSION['purchase_request'] = 'ON';
	echo '<form action="login-relay.php" method="post">
    ログイン名 <input type="text" name="login"><br>
    パスワード <input type="password" name="password"><br>
    <p><input type="submit" value="ログイン"></p>
    </form>';
    echo '</div>';
}

?>



