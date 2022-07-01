<?php
echo '<div class="page"> </div>';

//最近の更新内容をリスト表示する
//お客様からのお問い合わせ
echo '<p>お客様からのお問い合わせ情報</p>';
$sql = $pdo->prepare('SELECT date, post_name, post_title, post_message
FROM ask ORDER BY date DESC LIMIT 5');
$sql->execute();
echo '<table>';
echo '<tr><th>投稿日</th><th>投稿者</th><th>タイトル</th><th>内容</th></tr>';
foreach ($sql as $row){
	echo '<tr>';
	echo '<td>'.h($row['date']).'</td>';
	echo '<td>'.h($row['post_name']).'</td>';
	echo '<td>'.h($row['post_title']).'</td>';
	echo '<td>'.h($row['post_message']).'</td>';
	echo '</tr>';
}
echo '</table>';

//最近の更新内容をリスト表示する
//adminの管理者テーブル更新、productの商品更新、sale_periodの特売情報
echo '<p>管理者更新情報</p>';
$sql = $pdo->prepare('SELECT updated_at, updated_by_id, admin_name1
FROM admin ORDER BY updated_at DESC LIMIT 5');
$sql->execute();
echo '<table>';
echo '<tr><th>更新日</th><th>管理者</th></tr>';
foreach ($sql as $row){
	echo '<tr>';
	echo '<td>'.h($row['updated_at']).'</td>';
	// echo '<td>'.$row['updated_by_id'].'</td>';
	echo '<td>'.h($row['admin_name1']).'</td>';
	echo '</tr>';
}
echo '</table>';

echo '<p>商品更新情報</p>';
$sql = $pdo->prepare('SELECT pr.updated_at, pr.updated_by_id, pr.updated_contents, a.admin_name1
FROM admin a, product pr WHERE pr.updated_by_id = a.admin_id ORDER BY pr.updated_at DESC LIMIT 5');
$sql->execute();
echo '<table>';
echo '<tr><th>更新日</th><th>管理者</th><th>更新内容</th></tr>';
foreach ($sql as $row){
	// print_r($row);
	echo '<tr>';
	echo '<td>'.h($row['updated_at']).'</td>';
	// echo '<td>'.$row['updated_by_id'].'</td>';
	echo '<td>'.h($row['admin_name1']).'</td>';
	echo '<td>'.h($row['updated_contents']).'</td>';
	echo '</tr>';
}
echo '</table>';

echo '<p>セール更新情報</p>';
$sql = $pdo->prepare('SELECT sp.updated_at, sp.updated_by_id, sp.updated_contents, a.admin_name1
FROM admin a, sale_period sp WHERE sp.updated_by_id = a.admin_id ORDER BY sp.updated_at DESC LIMIT 5');
$sql->execute();
echo '<table>';
echo '<tr><th>更新日</th><th>管理者</th><th>更新内容</th></tr>';
foreach ($sql as $row){
	// print_r($row);
	echo '<tr>';
	echo '<td>'.h($row['updated_at']).'</td>';
	// echo '<td>'.$row['updated_by_id'].'</td>';
	echo '<td>'.h($row['admin_name1']).'</td>';
	echo '<td>'.h($row['updated_contents']).'</td>';
	echo '</tr>';
}
echo '</table>';
