
<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'common.php'; ?>
<?php require('dbconnect.php'); ?>
<?php

//URLパラメータ'id'を変数に代入する　From:product.php
$product_id = $_REQUEST['id'];

//DBに接続する
$sql=$pdo->prepare
//商品データを取り出す
('SELECT * FROM product WHERE id=?');
$sql->bindParam (1, $product_id, PDO::PARAM_INT);
$sql->execute();

//レビューデータを取り出す
$sql2=$pdo->prepare
('SELECT post_name, post_date, rating, post_title, post_message
FROM review WHERE product_id=?');
$sql2->bindParam (1, $product_id, PDO::PARAM_INT);
$sql2->execute();
$sql2 = $sql2->fetchAll();

//総合評価用のデータを取り出す
$sql3=$pdo->prepare
('SELECT SUM(rating) AS rating_sum, COUNT(rating) AS rating_count
FROM review WHERE product_id=?');
$sql3->bindParam (1, $product_id, PDO::PARAM_INT);
$sql3->execute();
$rating = $sql3->fetch();
//総合評価の計算をする
if ($rating['rating_sum'] > 0 || $rating['rating_count'] > 0) {
$rating_result = round($rating['rating_sum'] / $rating['rating_count'], 2);
}

//セール情報を確認する sale関数
sale();
$sale_price = $_SESSION['sale'][$product_id];
unset ($_SESSION['sale'][$product_id]);
// var_dump ($sale_price);

//取り出したデータを表示する
foreach ($sql as $row) {

    //イラストを表示する
    echo '<div class=detail_float>';
    echo '<ul>';
    for ($i=1;$i<=4;$i++){
        echo '<li>';
    echo '<img class="img-product" src="image/', $row[$i+2], '">';
    echo '</li>';
    }
    echo '</ul>';
    echo '</div>';

    //商品の詳細を表示する
    //カートに追加する
    echo '<div class=detail_text>';
    echo '<form action="cart-insert.php" method="post">';
    echo '<br><p><b>商品番号: </b>', $row['id'], '</p>';
    echo '<p><b>商品名: </b>', $row['name'], '</p>';
    $price = $row['price'];
    if ($sale_price === null) {
    echo '<p><b>価格: </b>', number_format($price), '</p>';
} else {
        echo '<p><b>価格: </b><del>', number_format( $row['price']), '</p>';
    echo '<p><font color=red>セール価格: ', number_format($sale_price), '</font></p>';
    $price = min($price, $sale_price);
}
    $introduction = mb_wordwrap($row['introduction'], 45, '</br>', true);
    echo '<p><b>商品詳細: </b><br>', $introduction, '</p>';

    echo '<p><b>個数: </b><select name="count">';
    for ($i=1; $i<=10; $i++) {
    echo '<option value="', $i, '">', $i, '</option>';
    }
    echo '</select></p>';

    //'hidden'で値を渡す To:cart-insert.php
    echo '<input type="hidden" name="id" value="', $row['id'], '">';
    echo '<input type="hidden" name="name" value="', $row['name'], '">';
    echo '<input type="hidden" name="price" value="', $price, '">';
    echo '<input type="hidden" name="picmini1" value="', $row['picmini1'], '">';

    echo '<p><button type="submit" value="カートに追加">カートに追加</button></p>';
    echo '<p><button type="submit" name="button" value="click1">1クリック購入</button></p>';
    echo '</form>';

    //URLパラメータ'id'を送る　To:favorite-insert.php
    echo '<a href="favorite-insert.php?id=', $row['id'],'">お気に入りに追加</a>';

    echo '</div>';
}

    //レビューを表示する
    echo '<div class="review">';
    echo '<p><b>この商品を購入された方のレビュー</b></p>';

    if (!empty($sql2)) {

    echo '<b>総合評価 </b>';
    echo '<div class="Stars" style="--rating:', $rating_result, '"
    aria-label="Rating of this product is', $rating_result, 'out of 5."></div>';
    echo '&ensp;<b>', $rating_result, '</b>';
    echo '<br><br>';

    foreach ($sql2 as $row) {
        echo $row['post_name'], ' さん<br>';

        echo '評価 ';
        $sw = 0;
        $rating = $row['rating'];
        for ($i=1; $i<=5; $i++) {

            if ($rating < $i) {
                $sw = 1;
            }
            if ($sw == 0) {
                echo "<span style='color: #fc0;'>★</span>";

            } elseif ($sw == 1) {
                echo "<span style='color: #e9eae3;'>★</span>";
            }
        }

        echo '&emsp;&emsp;&emsp;投稿日 ',
        mb_substr($row['post_date'], 0,4), '年', mb_substr($row['post_date'], 4,2), '月',
        mb_substr($row['post_date'], 6,2), '日';

        echo '<hr color=#FF6600>';

        echo '<b>',$row['post_title'], '</b>';
        echo '<p>',$row['post_message'], '</p>';

        echo '<br>';
    }

    } else {
        echo 'まだレビューが投稿されていません。';
    }

//セール情報関数 セール日の対象を検索する
function sale()
{
	require('dbconnect.php');
	//ここから、セール情報入手。セッションを空にする。
	$_SESSION['sale'] = [];
	//  '今日の日付を$todayに入れて、特売日かどうかを判断する';
	$today = date('Ymd');
	//sale_periodテーブルから、sale開始とsale終了の間となるものを選択する
	$sql_sale = $pdo->prepare('SELECT * FROM sale_period
		 WHERE start_date<=? AND end_date >= ? ORDER BY id ASC');
	$sql_sale->bindParam(1, $today, PDO::PARAM_INT);
	$sql_sale->bindParam(2, $today, PDO::PARAM_INT);
	$sql_sale->execute();
	//id に対する　sale_priceをセッションに入れる
	foreach ($sql_sale as $value) {

		// $_SESSION['sale']['id'] = $value['id'];
		$_SESSION['sale'][$value['product_id']] = $value['sale_price'];
		//  var_dump($_SESSION['sale']);
	}
	//ここまでセール情報
}

?>

<?php require 'footer.php'; ?>