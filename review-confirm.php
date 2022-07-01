<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'common.php'; ?>
<?php require('dbconnect.php'); ?>

<?php

echo '<div class=page>';
echo '<p><b>投稿内容をご確認後、<br>
        確定ボタンを押してください。</b></p>';


//変数にチェック済みの入力内容を代入する
$rating = $_SESSION['review']['rating'];
$post_name = h($_SESSION['review']['post_name']);
$post_title = h($_SESSION['review']['post_title']);
$post_message = h($_SESSION['review']['post_message']);

//レビューする商品のデータを取り出す
$product_id = $_SESSION['review']['id'];

$sql=$pdo->prepare
('SELECT id, name, picmini1 FROM product WHERE id=?');
$sql->bindParam (1, $product_id, PDO::PARAM_STR);
$sql->execute();

#商品を表示
echo '<table>';

foreach ($sql as $row) {

echo '<tr>';
echo '<td>', $row['name'], '</td>';
echo '</tr>';

echo '<tr>';
echo '<td><img src="image/' .$row['picmini1'].'" ></img></td>';
echo '</tr>';

echo '<form action="review-output.php" method="post">';

}

echo '<form action="review-output.php" method="post">';
echo '<table>';

echo '<tr><td align="center"><b>評価</b></td>';

echo '<td class=review_table>';
echo '<div class="rate-form">';

if ($rating == 5) {
    echo '<input id="star5" type="radio" name="rating" value="5" checked="checked">';
}
echo '<label for="star5">★</label>';

if ($rating == 4) {
    echo '<input id="star4" type="radio" name="rating" value="4" checked="checked">';
}
echo '<label for="star4">★</label>';

if ($rating == 3) {
    echo '<input id="star3" type="radio" name="rating" value="3" checked="checked">';
}
echo '<label for="star3">★</label>';

if ($rating == 2) {
    echo '<input id="star2" type="radio" name="rating" value="2" checked="checked">';
}
echo '<label for="star2">★</label>';

if ($rating == 1) {
    echo '<input id="star1" type="radio" name="rating" value="1" checked="checked">';
}
echo '<label for="star1">★</label>';

echo '</td></tr>';
echo '</div>';

echo '<tr><td align="center"><b>お名前</b></td><td>';
echo $post_name;
echo '</td></tr>';

echo '<tr><td align="center"><b>タイトル</b></td><td>';
echo $post_title;
echo '</td></tr>';

echo '<tr><td align="center"><b>本文</b></td><td>';
echo $post_message;
echo '</td></tr>';

echo '</table>';
echo '<br>';

echo '<input type="submit" value="確定">';
echo ' ';
$return = 'return';
echo '<a href="review-input.php?command=', $return,'">
        前の画面に戻る</a>';
echo '</form>';
echo '<br></div>';

?>

<?php require 'footer.php'; ?>
