<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'common.php'; ?>
<?php require 'dbconnect.php'; ?>

<?php
echo '<div class=page> </div>';
//おすすめ商品をランダムで選ぶ
echo '<div class="top">';
echo '<p class="title-top"><br>おすすめ商品</p>';
$sql = $pdo->prepare('SELECT COUNT(*) AS count FROM product WHERE recommend = 1');
$sql->execute();
$row = $sql->fetch();
if ($row['count'] !== 0) {
    $num = rand(1, $row['count']) - 1;
    $sql = $pdo->prepare('SELECT * FROM product WHERE recommend = 1');
    $sql->execute();
    // echo $num;
    $row = $sql->fetchall();
   echo  '<img src = "image/'.$row[$num]['picmini1'].'" alt="商品写真"></img>';
   echo '<br>';
   echo '<p><a href="detail.php?id=', $row[$num]['id'], '">', $row[$num]['name'], '</a></p>';
} else {
    echo '<p>準備中です</p>';
}
echo '</div>';

//セール商品をランダムで選ぶ
echo '<div class="top">';
echo '<p class="title-top"><br>セール商品</p>';
	//  '今日の日付を$todayに入れて、特売日かどうかを判断する';
	$today = date('Ymd');
$sql = $pdo->prepare('SELECT COUNT(*) AS count FROM product pr, sale_period s
WHERE pr.id=s.product_id AND s.start_date <=? AND s.end_date >=?');
$sql->bindParam(1, $today, PDO::PARAM_INT);
$sql->bindParam(2, $today, PDO::PARAM_INT);
$sql->execute();
$row = $sql->fetch();
if ($row['count'] !== 0) {
    $num = rand(1, $row['count']) - 1;
    $sql = $pdo->prepare('SELECT pr.id, pr.name, pr.picmini1 FROM product pr, sale_period s
    WHERE pr.id=s.product_id AND s.start_date <=? AND s.end_date >=?');
    $sql->bindParam(1, $today, PDO::PARAM_INT);
    $sql->bindParam(2, $today, PDO::PARAM_INT);
    $sql->execute();
    // echo $num;
    $row = $sql->fetchall();
    // print_r($row);
   echo  '<img src = "image/'.$row[$num]['picmini1'].'" alt="商品写真"></img>';
   echo '<p><a href="detail.php?id=', $row[$num]['id'], '">', $row[$num]['name'], '</a></p>';
} else {
    echo '<p>準備中です</p>';
}
echo '</div>';

//dailyランキング商品をランダムで選ぶ
echo '<div class="top">';
echo '<p class="title-top">昨日の<br>トップセール商品</p>';
$sql = $pdo->prepare('SELECT COUNT(*) AS count FROM product WHERE daily_ranking = 1');
$sql->execute();
$row = $sql->fetch();
if ($row['count'] !== 0) {
    $num = rand(1, $row['count']) - 1;
    $sql = $pdo->prepare('SELECT * FROM product WHERE daily_ranking = 1');
    $sql->execute();
    // echo $num;
    $row = $sql->fetchall();
   echo  '<img src = "image/'.$row[$num]['picmini1'].'" alt="商品写真"></img>';
   echo '<p><a href="detail.php?id=', $row[$num]['id'], '">', $row[$num]['name'], '</a></p>';
} else {
    echo '<p>準備中です</p>';
}
echo '</div>';

//weeklyランキング商品をランダムで選ぶ
echo '<div class="top">';
echo '<p class="title-top">過去7日間の<br>トップセール商品</p>';
$sql = $pdo->prepare('SELECT COUNT(*) AS count FROM product WHERE weekly_ranking = 1');
$sql->execute();
$row = $sql->fetch();
if ($row['count'] !== 0) {
    $num = rand(1, $row['count']) - 1;
    $sql = $pdo->prepare('SELECT * FROM product WHERE weekly_ranking = 1');
    $sql->execute();
    // echo $num;
    $row = $sql->fetchall();
   echo  '<img src = "image/'.$row[$num]['picmini1'].'" alt="商品写真"></img>';
   echo '<p><a href="detail.php?id=', $row[$num]['id'], '">', $row[$num]['name'], '</a></p>';
} else {
    echo '<p>準備中です</p>';
}
echo '</div>';
?>