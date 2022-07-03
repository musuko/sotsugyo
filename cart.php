<?php require('dbconnect.php'); ?>
<?php require('common.php'); ?>

<?php
echo '<div class="page"> </div>';
echo '<table class="table-cart">';
#カート内の商品一覧を表示する
//カートに商品が入っている場合
if (!empty($_SESSION['product'])) {
    echo '<th>日付</th><th>商品</th>';
    echo '<th>商品名</th><th>価格</th><th>個数</th><th>小計</th><th>金額</th><th></th>';

    //変数を用意する
    $total = 0;
    $subtotal = 0;

    //消費税率を求める
    //消費税率を求めるためのデータを取り出す
    $sql = $pdo->prepare('SELECT * FROM tax');
    $sql->execute();

    //変数を用意する
    //購入日
    $date = date('Ymd');
    //処理
    $sw = 0;
    //消費税率
    $rate = 0;
    //消費税率一旦格納
    $ratestock = 0;

    foreach ($sql as $key => $value) {

        //消費税率を求める
        //消費税率改訂日より以前が購入日の場合
        if ($date < $value['taxdate'] && $sw == 0) {
            //消費税率を代入する
            $rate = $ratestock;
            //$swの値を切り替える
            $sw = 1;
        }

        //消費税率改訂日以前の消費税率を格納する
        $ratestock = $value['tax'];

        //購入日が最新の税率を使用する場合
        if ($sw == 0) {
            $rate = $ratestock;
        }
    }
    //form出力 $_REQUEST['count']及び$_REQUEST['submit]を$count, $submit　とする
    $count = h(filter_input(INPUT_POST, 'count', FILTER_VALIDATE_INT));
    $submit = filter_input(INPUT_POST, 'submit', FILTER_VALIDATE_INT);

    // submitボタンが押された場合、セッションの個数にformで修正した値を入れる
    if ($submit) {
        $_SESSION['product'][$submit]['count'] = $count;    //個数のセッションを更新
    }
    //カート内の商品一覧を表示する
    foreach ($_SESSION['product'] as $id => $product) {
        echo '<tr>';
        echo '<td>', date('Y/m/d'), '</td>';
        // echo '<td>', $id, '</td>';商品番号を非表示にする
        echo '<td><p><img src="image/' . $product['picmini1'] . '" ></img></p></td>';
        //URLパラメータ'id'を送る　To:detail.php
        echo '<td><a href="detail.php?id=', $id, '">', $product['name'], '</a></td>';
        echo '<td>', number_format($product['price']), '</td>';
        //formで情報更新(個数)を行う。id、図ファイル名、名前、価格もhiddenで送る
        echo '<td><form  method="post">';
        echo '<input type="hidden" name="id" value="', $id, '">';
        echo '<input type="hidden" name="picmini1" value="', $product['picmini1'], '">';
        echo '<input type="hidden" name="name" value="', $product['name'], '">';
        echo '<input type="hidden" name="price" value="', $product['price'], '">';
        //個数をここで変更可能にする。styleはFormのサイズ、fontサイズ調整。minは数字の下限。
        echo '<input type="number" name="count" value="', $product['count'],
        '" min="1" style ="font-size:20px; width:60px; height:30px";>';
        //submitボタンにidの値を持たせる
        echo '<button type="submit" name="submit" value="', $id, '">update</button>';
        echo '</form></td>';

        //金額小計を変数'subtotal'に代入する
        $subtotal = $product['price'] * $product['count'];
        echo '<td>', number_format($subtotal), '</td>';

        //金額合計を変数'total'に代入する
        $total += $subtotal;

        //削除リンク表示。purchase-input.phpから、cart.phpがrequireされた場合、送り先を変える
        // var_dump(trim($_SESSION['filename']));echo '<br>';
        // var_dump("purchase-input.php");
        if (isset($filename)) { 
            if (trim($filename) == 'purchase-input.php') {
                //URLパラメータ'id'を送る　To:purchase-delete.php
                echo '<td><a href="purchase-delete.php?id=', $id, '">削除</a></td>';
            }
       } else {
            //URLパラメータ'id'を送る　To:cart-delete.php
            echo '<td><a href="cart-delete.php?id=', $id, '">削除</a></td>';
        }
        //金額小計の変数を0に戻す
        $subtotal = 0;
        echo '</tr>';
    }
    // $_SESSION['filename'] = "";
    echo '<tr><td>小計</td><td></td><td></td><td></td><td></td><td></td><td>',
    number_format($total), '</td><td></td></tr>';
    //セッションに格納する
    $_SESSION['total'] = $total;

    //金額合計の消費税求める
    $tax = round($total * ($rate * 0.01));
    echo '<tr><td>消費税</td><td></td><td></td><td></td><td></td><td></td><td>',
    number_format($tax), '</td><td></td></tr>';
    //セッションに格納する
    $_SESSION['tax'] = $tax;

    //金額総合計を求める
    $total = $tax + $total;
    echo '<tr><td>合計</td><td></td><td></td><td></td><td></td><td></td><td>',
    number_format($total), '</td><td></td></tr>';

    echo '</table>';
} else {
    echo '<div class="left2"><span style="color: #FF6666;">カートに商品がありません。</span></div>';
}

?>

<?php require 'footer.php'; ?>