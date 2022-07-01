<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require('dbconnect.php'); ?>

<?php

//購入を確定した場合
if (isset($_SESSION['customer']) && isset($_SESSION['product'])) {

    #購入テーブルに登録する
    //変数にログインした顧客情報を代入する
    $customer_id = $_SESSION['customer']['id'];

    //購入番号附番のため、件数データを取り出す
    $records = $pdo->prepare
    ('SELECT MAX(purchase_id) AS record_count FROM purchase');
    $records->execute();
    $record = $records->fetch();

    //2桁表示にする＆件数は1を足す
    $purchase_id = sprintf('%02d', $record['record_count'] + 1);

    //登録処理
    $sql = $pdo->prepare
    ('INSERT INTO purchase SET purchase_id=?, customer_id=?,
    purchase_date=?, tax=?, price=?');

    //登録するデータを変数に代入する
    $purchase_date = date('Ymd');
    $tax = $_SESSION['tax'];
    $price = $_SESSION['total'];

    $sql->bindParam (1, $purchase_id, PDO::PARAM_INT);
    $sql->bindParam (2, $customer_id, PDO::PARAM_INT);
    $sql->bindParam (3, $purchase_date, PDO::PARAM_INT);
    $sql->bindParam (4, $tax, PDO::PARAM_INT);
    $sql->bindParam (5, $price, PDO::PARAM_INT);
    $sql->execute();


    #購入詳細テーブルに登録する
    foreach ($_SESSION['product'] as $id=>$product) {

        //登録処理
        $sql = $pdo->prepare
        ('INSERT INTO purchase_detail SET purchase_id=?, product_id=?,
        count=?, price_at=?');

        $product_id = $id;
        $count = $product['count'];
        $price_at = $product['price'];

        $sql->bindParam (1, $purchase_id, PDO::PARAM_INT);
        $sql->bindParam (2, $product_id, PDO::PARAM_INT);
        $sql->bindParam (3, $count, PDO::PARAM_INT);
        $sql->bindParam (4, $price_at, PDO::PARAM_INT);
        $sql->execute();

    }

    echo '<div class="page">';
      echo '<p>購入が完了しました。以下の予約番号を控えておいてください。</p>';
      echo '<hr>';
      echo '<p>購入番号　', $purchase_id, '</p>';
      echo '<hr>';
      echo '<p>ご購入ありがとうございました。<br>
            またのご利用を心よりお待ちいたしております。</p>';
            echo '</div>';
    //セッションを初期化する
    unset($_SESSION['product']);
    unset($_SESSION['total']);
    unset($_SESSION['tax']);
}

?>



