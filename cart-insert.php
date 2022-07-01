<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php
echo '<div class="page"> </div>';
//変数にidの値を代入する　idFrom:detail.php
$id = $_REQUEST['id'];
#カートに追加する商品をセッション変数に格納する
//Ex：$_SESSION['product']['id']=>['name'],['price']...

/*セッション変数が未定義（＝ショッピング開始時）の場合、
空の配列を設定（＝カートが空の状態）する*/
if (!isset($_SESSION['product'])) {
    $_SESSION['product'] = [];
}

//1click対応
$click1 = filter_input(INPUT_POST, "button");
// var_dump($click1);
if ($click1 === "click1") {
    $_SESSION['product'] = [];
    //カートに商品を登録する
    $_SESSION['product'][$id] = [
        'name' => $_REQUEST['name'],
        'price' => $_REQUEST['price'],
        'count' => $count + $_REQUEST['count'],
        'picmini1' => $_REQUEST['picmini1']
    ];
    var_dump($_SESSION['product']);
    // echo '<a href="purchase-input.php">進む</a>';
    header("location: purchase-input.php");
} else {

    //商品の個数を表す変数'$count'を用意する
    $count = 0;

    /*既にカートに入っている商品と、同じ商品をカートに入れた場合、
商品の個数を合計するため、既にカートに入っている個数を取得する*/
    if (isset($_SESSION['product'][$id])) {
        //既にカートに入っている個数を変数'count'に代入する
        $count = $_SESSION['product'][$id]['count'];
    }

    //カートに商品を登録する
    $_SESSION['product'][$id] = [
        'name' => $_REQUEST['name'],
        'price' => $_REQUEST['price'],
        'count' => $count + $_REQUEST['count'],
        'picmini1' => $_REQUEST['picmini1']
    ];

    echo '<div class="left2"><br>カートに商品を追加しました。</div>';

    require 'cart.php';
    echo '<div class="left2"><p><a href="purchase-input.php">購入画面に進む</a></p></div>';
}
?>

<?php require 'footer.php'; ?>