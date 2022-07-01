
<?php
//CSSできれいにする
echo '<form id="form" action="login-relay.php" method="post">';
echo '<ul class="ul">';
echo '<li><label for="input" id="label">ログイン名:</label>';
echo '<input type="text" id="input" name="login"></li>';
echo '<li> <label for="input2" id="label">パスワード:</label>';
echo '<input type="password"  id="input2" name="password"></li>';
echo ' <li class="button"><button type="submit">ログイン</button></li>';
echo '</ul>';
echo '</form>';
?>
