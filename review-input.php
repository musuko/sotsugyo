<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'common.php'; ?>
<?php require('dbconnect.php'); ?>


<?php

/*受け取ったパラメータ From history.php もしくは、
セッション['review']['product_id']を変数に代入する*/
if ($_REQUEST['product_id'] != '') {
    $product_id = $_REQUEST['product_id'];

} elseif ($_SESSION['review']['product_id'] != '') {
    $product_id = $_SESSION['review']['product_id'];

}

/*受け取ったパラメータ From history.php もしくは、
セッション['review']['purchase_id']を変数に代入する*/
if ($_REQUEST['purchase_id'] != '') {
    $purchase_id = $_REQUEST['purchase_id'];

} elseif ($_SESSION['review']['purchase_id'] != '') {
    $purchase_id = $_SESSION['review']['purchase_id'];

}

//顧客'id'を変数に代入する
$customer_id = $_SESSION['customer']['id'];

#チェック中のレビュー
//チェックから受け取ったセッションデータを変数に代入する
if (isset($_SESSION['review'])) {

    $rating = $_SESSION['review']['rating'];
    $post_name = h($_SESSION['review']['post_name']);
    $post_title = h($_SESSION['review']['post_title']);
    $post_message = h($_SESSION['review']['post_message']);

} else {

    #過去レビュー
    //過去レビューのデータを取り出す
    $sql=$pdo->prepare
    ('SELECT * FROM review WHERE product_id=? AND customer_id=? AND purchase_id=?');
    $sql->bindParam (1, $product_id, PDO::PARAM_INT);
    $sql->bindParam (2, $customer_id, PDO::PARAM_INT);
    $sql->bindParam (3, $purchase_id, PDO::PARAM_INT);
    $sql->execute();
    $review = $sql->fetchAll();

    //投稿歴があれば、データを変数に代入する
    if (!empty($review)) {

        foreach ($review as $row) {

        $date = $row['post_date'];
        $rating = $row['rating'];
        $post_name = $row['post_name'];
        $post_title = $row['post_title'];
        $post_message = $row['post_message'];

        }
    }
}

#エラー
//チェックから受け取ったエラーデータを変数に代入する
if (isset($_SESSION['error'])) {

    $blank_rating =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_rating'] ."</span>";

    $blank_post_name =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_post_name'] ."</span>";
    $over_post_name =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['over_post_name'] ."</span>";

    $blank_post_title =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_post_title'] ."</span>";
    $over_post_title =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['over_post_title'] ."</span>";

    $blank_post_message =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['blank_post_message'] ."</span>";
    $over_post_message =
    "<span style='color: #FF6666;'>" . $_SESSION['error']['over_post_message'] ."</span>";

}

//レビュー投稿フォームを表示する
echo '<div class=page>';

echo '<table>';
echo '<tr><td><b>商品のレビューを書く</b></td><tr>';

//レビューする商品のデータを取り出す
$sql=$pdo->prepare
('SELECT id, name, picmini1 FROM product WHERE id=?');
$sql->bindParam (1, $product_id, PDO::PARAM_STR);
$sql->execute();

#商品内容を表示
foreach ($sql as $row) {

echo '<tr>';
echo '<td>', $row['name'], '</td>';

echo '<tr>';
echo '<td><img src="image/' .$row['picmini1'].'" ></img></td>';

//投稿歴があれば日付を表示する
if (!empty($review)) {
    echo '<td class=review_table>', 
            mb_substr($date, 0,4), '年', mb_substr($date, 4,2), '月',
            mb_substr($date, 6,2), '日', 'の投稿</td>';
    echo '</tr>';
}

echo '</tr>';
}

echo '<form action="review-check.php" method="post">';

//'product_id'をhiddenで渡す　To review-check.php
echo '<input type="hidden" name="product_id" value="', $product_id, '">';

//'purchase_id'をhiddenで渡す　To review-check.php
echo '<input type="hidden" name="purchase_id" value="', $purchase_id, '">';

    echo '<tr>';
    echo '<td>評価</td>';
    echo '<td class=review_table>';
    echo '<div class="rate-form">';

    if ($rating == 5) {
        echo '<input id="star5" type="radio" name="rating" value="5" checked="checked">';
    } else {
        echo '<input id="star5" type="radio" name="rating" value="5">';
    }
    echo '<label for="star5">★</label>';
    
    if ($rating == 4) {
        echo '<input id="star4" type="radio" name="rating" value="4" checked="checked">';
    } else {
        echo '<input id="star4" type="radio" name="rating" value="4">';
    }
    echo '<label for="star4">★</label>';
    
    if ($rating == 3) {
        echo '<input id="star3" type="radio" name="rating" value="3" checked="checked">';
    } else {
        echo '<input id="star3" type="radio" name="rating" value="3">';
    }
    echo '<label for="star3">★</label>';
    
    if ($rating == 2) {
        echo '<input id="star2" type="radio" name="rating" value="2" checked="checked">';
    } else {
        echo '<input id="star2" type="radio" name="rating" value="2">';
    }
    echo '<label for="star2">★</label>';
    
    if ($rating == 1) {
        echo '<input id="star1" type="radio" name="rating" value="1" checked="checked">';
    } else {
        echo '<input id="star1" type="radio" name="rating" value="1">';
    }
    echo '<label for="star1">★</label>';

    echo '</div>';
    echo '</td>';

    echo '<td>', $blank_rating, '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>お名前</td>';
    echo '<td class=review_table><input type="text" name="post_name" 
            value="', $post_name, '"></td>';

    echo '<td>', $blank_post_name, $over_post_name, '</td>';
    echo '</tr>';

    echo '<td>タイトル</td>';
    echo '<td class=review_table><input type="text" name="post_title" 
            value="', $post_title, '"></td>';

    echo '<td>', $blank_post_title, $over_post_title, '</td>';
    echo '</tr>';

    echo '<td>本文</td>';

    if ($_REQUEST['command'] == 'return' || $post_message == '') {
        echo '<td class=review_table><textarea name="post_message" rows="5" cols="35" >',
        $post_message, '</textarea></td>';
    } else {
        echo '<td class=review_table><textarea name="post_message" rows="5" cols="35" >',
        $post_message, '&#13;', date('Y年m月d日') , '追記：</textarea></td>';
    }

    echo '<td>', $blank_post_message, '</td>';
    echo '<td>', $over_post_message, '</td>';
    echo '</tr>';
    echo '</table>';

    if (!empty($review)) {
        echo '<input type="submit" value="更新">';

    } else {
        echo '<input type="submit" value="投稿">';
    }

    echo '</form>';
    echo '</div><br>';


//セッションを初期化する
unset($_SESSION['review']);
unset($_SESSION['error']);

?>

<?php require 'footer.php'; ?>