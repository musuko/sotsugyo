<nav class="topbar">

<div class="logo"><a href="index.php">
    <img src="image/logo.png" alt="logo" class="img-logo"></img></a></div>

<ul>
<li><a href="product.php">商品</a></li>
<li><a href="favorite-show.php">お気に入り</a></li>
<li><a href="history.php">購入履歴</a></li>
<li><a href="cart-show.php">カート</a></li>
<li><a href="purchase-input.php">購入</a></li>
<?php if (!isset($_SESSION['customer'])): ?>
<li><a href="login-input.php">ログイン</a></li>
<?php endif; ?>
<?php if (isset($_SESSION['customer'])): ?>
<li><a href="logout-input.php">ログアウト</a></li>
<?php endif; ?>

<?php
if (isset($_SESSION['customer'])){

    echo '<li><a href="customer-input.php">会員情報</a></li>';
    echo '<li><a href="ask.php">お問い合わせ</a></li>';
    echo '<li><a href="overview.php">会社概要</a></li>';
    echo '<li><a style="color:#FFCC33">'.'ようこそ、'.
            $_SESSION['customer']['name1'].'さん'.'</a></li>';

}else{

    echo '<li><a href="customer-input.php">会員登録</a></li>';
    echo '<li><a href="ask.php">お問い合わせ</a></li>';
    echo '<li><a href="overview.php">会社概要</a></li>';
    echo'<li><a style="color:#FFCC33">ようこそ、ゲストさん</a></li>';
}
?>

</ul>
</nav>


