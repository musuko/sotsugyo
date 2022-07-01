<nav class="topbar">
<ul>
<li><a href="product-show.php">商品</a></li>
<li><a href="shohizei-show.php">消費税</a></li>
<li><a href="admin-show.php">管理者</a></li>
<?php

if (isset($_SESSION['admin'])){

    echo '<li><a style="color:#FFCC33" href="logout-input2.php">ログアウト</a></li>';

}else{
    echo '<li><a style="color:#FFCC33" href="login-input2.php">ログイン</a></li>';
}

?>

</ul>


</nav>


