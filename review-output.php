<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'common.php'; ?>
<?php require('dbconnect.php'); ?>

<?php

//変数に登録する内容を代入する
$product_id = $_SESSION['review']['product_id'];
$purchase_id = $_SESSION['review']['purchase_id'];
$customer_id = $_SESSION['customer']['id'];
$post_name = h($_SESSION['review']['post_name']);
$post_date = date('Ymd');
$rating = $_SESSION['review']['rating'];
$post_title = h($_SESSION['review']['post_title']);
$post_message = h($_SESSION['review']['post_message']);


    if (isset($_SESSION['customer'])){

        //過去レビューのデータを取り出す
        $sql=$pdo->prepare
        ('SELECT * FROM review WHERE product_id=? AND customer_id=? AND purchase_id=?');
        $sql->bindParam (1, $product_id, PDO::PARAM_INT);
        $sql->bindParam (2, $customer_id, PDO::PARAM_INT);
        $sql->bindParam (3, $purchase_id, PDO::PARAM_INT);

        $sql->execute();
        $review = $sql->fetchAll();

        if (!empty($review)) {

            $sql=$pdo->prepare
            ('UPDATE review SET post_name=?, rating=?, post_title=?, 
            post_message=? WHERE product_id=? AND customer_id=? AND purchase_id=?');

            $sql->bindParam (1, $post_name, PDO::PARAM_STR);
            $sql->bindParam (2, $rating, PDO::PARAM_INT);
            $sql->bindParam (3, $post_title, PDO::PARAM_STR);
            $sql->bindParam (4, $post_message, PDO::PARAM_STR);
            $sql->bindParam (5, $product_id, PDO::PARAM_INT);
            $sql->bindParam (6, $customer_id, PDO::PARAM_INT);
            $sql->bindParam (7, $purchase_id, PDO::PARAM_INT);

            $sql->execute();

            echo '<div class=page>';
            echo '<p>レビューを更新しました。<br>
                    ご協力ありがとうございました。</p>';
            echo '<a href="history.php">戻る</a>';
            echo '</div>';

        } else {

            $sql=$pdo->prepare
            ('INSERT INTO review SET product_id=?, customer_id=?, post_name=?, 
            post_date=?, rating=?, post_title=?, post_message=?, purchase_id=?');

            $sql->bindParam (1, $product_id, PDO::PARAM_INT);
            $sql->bindParam (2, $customer_id, PDO::PARAM_INT);
            $sql->bindParam (3, $post_name, PDO::PARAM_STR);
            $sql->bindParam (4, $post_date, PDO::PARAM_INT);
            $sql->bindParam (5, $rating, PDO::PARAM_INT);
            $sql->bindParam (6, $post_title, PDO::PARAM_STR);
            $sql->bindParam (7, $post_message, PDO::PARAM_STR);
            $sql->bindParam (8, $purchase_id, PDO::PARAM_INT);

            $sql->execute();

            echo '<div class=page>レビューを投稿しました。<br>
                    ご協力ありがとうございました。</div>';

        }

    //入力情報のセッションを初期化する
    unset($_SESSION['review']);

    }

?>

<?php require 'footer.php'; ?>