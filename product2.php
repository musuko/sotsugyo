<?php require 'header.php'; ?>
<?php require 'menu2.php'; ?>
<?php require 'common.php'; ?>
<?php require 'dbconnect.php'; ?>

<div class="page"> </div>
<form method="post">
	商品検索:
	<input type="text" name="keyword">
	<input type="submit" value="検索">
</form>
<hr>


<?php
//ログイン及び権限チェック
if (isset($_SESSION['admin']['id'])) {
	$admin_authority =  $_SESSION['admin']['authority'] ?? '';
	if ($admin_authority === 'rw' || $admin_authority === 'r') {
		//権限がrwのみ登録、削除、編集及びsale情報ボタン表示
		if ($_SESSION['admin']['authority'] === 'rw') {
			echo '<table><tr>';
			echo '<td><button type="submit" name = "button" value="add" form="id1">商品追加</button></td>';
			echo '<form action = "product-insert.php" method="post" id="id1">';
			echo '</form>';
			echo '<td><button type="submit" name = "button" value="cv" form="id3">商品画面確認</button></td>';
			echo '<td><button type="submit" name = "button" value="sale" form="id2">sale情報</button></td>';
		}			echo '</tr></table>';

		echo '<form action = "product-sale.php" method="post" id="id2">';
		echo '</form>';
		echo '<form action = "product2-cstmr-view.php" method="post" id="id3">';
		echo '</form>';

		//商品検索欄に入力がある場合
		$count = "";
		if (isset($_REQUEST['keyword'])) {
			//商品検索入力文字をエスケープ処理し、前後に"%"を文字結合する
			$keyword = "%" . h($_REQUEST['keyword']) . "%";
			//DBに接続する
			$sql1 = $pdo->prepare
				//商品検索で入力した値のデータを取り出す
				('SELECT * FROM product WHERE name LIKE ? ORDER BY id ASC');
			$sql1->execute([$keyword]);
			//検索結果が0件の場合、$countを0とする。
			$sql = $sql1->fetchall();
			if (count($sql) == 0) {
				$count = 'zero';
			}
			//商品検索欄に入力がない場合
		} else {
			//並べ替えのセッションがある場合、変数に代入
			if (isset($_SESSION['direction'])) {
				$direction = $_SESSION['direction'];
			}
			//並べ替えの対象を変数に代入
			$order = filter_input(INPUT_GET, 'order');
			// 並べ替えの対象がない場合、idの昇順を基本とする.
			//それ以外は、対象があるので、昇順、降順を入れ替える。
			if ($order === null) {
				$order = 'id';
				$direction = 'ASC';
			} elseif ($order === "id" && $direction === "ASC") {
				$direction = 'DESC';
			} elseif ($order === "id" && $direction === "DESC") {
				$direction = 'ASC';
			} elseif ($order === "daily_ranking" && $direction === "ASC") {
				$direction = 'DESC';
			} elseif ($order === "daily_ranking" && $direction === "DESC") {
				$direction = 'ASC';
			} elseif ($order === "weekly_ranking" && $direction === "ASC") {
				$direction = 'DESC';
			} elseif ($order === "weekly_ranking" && $direction === "DESC") {
				$direction = 'ASC';
			}
			//昇順、降順をセッションに収める
			$_SESSION['direction'] = $direction;
			// var_dump($order);
			// var_dump($direction);
			$sql1 = 'SELECT * FROM product ORDER BY ' . $order . ' ' . $direction;
			//DBに接続する
			//商品のデータを取り出す
			$sql = $pdo->prepare($sql1);
			$sql->execute();
		}
		//データが存在する場合
		if ($count !== "zero") {
			#商品一覧をテキストボックスで表示
			echo '<table>';
			echo '<th><a href="product-show.php?order=id">商品id</a></th>
			<th>商品名</th><th>写真1</th><th>写真2</th>
		<th>写真3</th><th>写真4</th><th>写真5</th>
		<th>価格</th><th>商品紹介</th><th>おすすめ</th>
		<th><img src="image/sale.png" alt="saleアイコン"></img>セール価格</th>
		<th><a href="product-show.php?order=daily_ranking">昨日ランク</a></th>
		<th><a href="product-show.php?order=weekly_ranking">7日間ランク</a></th>
		<th>表示フラグ</th>';
			// sale関数を呼び、sale日の場合、その価格をセール価格に反映する。
			sale();
			// rank関数を呼び、1日、1週間のランキングを表示する。
			rank();

			//管理者権限がrの場合、編集を不可とする
			if ($_SESSION['admin']['authority'] === 'rw') {
				$ro = "";
			} else {
				$ro = "readonly";
			}
			//取り出したデータを1行ずつ表示する。
			//変更日、変更者は手入力修正不要と考えたので、表示のみとする。
			foreach ($sql as $row) {
				$sale_price = $_SESSION['sale'][$row['id']] ?? '';
				echo '<tr>';
				echo '<input type="hidden" value"' . $row['id'] . '">';
				echo '<td>' . $row['id'] . '</td>';
				echo '<td><a href="product-edit.php?id='  . $row['id'] . '">' . $row['name'] . '</a></td>';
				echo '<td><p size="10" >' . $row['pic1'] . '</p>';
				echo '<img width="100%" src="image/'  . $row["pic1"] . '" alt="写真1"></img></td>';
				echo '<td><p size="10" >' . $row['pic2'] . '</p>';
				echo '<img width="100%" src="image/'  . $row["pic2"] . '" alt="写真2"></img></td>';
				echo '<td><p size="10" >' . $row['pic3'] . '</p>';
				echo '<img width="100%" src="image/'  . $row["pic3"] . '" alt="写真3"></img></td>';
				echo '<td><p size="10" >' . $row['pic4'] . '</p>';
				echo '<img width="100%" src="image/'  . $row["pic4"] . '" alt="写真4"></img></td>';
				echo '<td><p size="10" >' . $row['picmini1'] . '</p>';
				echo '<img width="100%" src="image/'  . $row["picmini1"] . '" alt="写真5"></img></td>';
				echo '<td>';
				//セール情報がある場合、オリジナル価格に取り消し線を追加
				if ($sale_price == "") {
					echo $row['price'];
				} else {
					echo '<del>' . $row['price'];
				};
				echo '</td>';
				echo '<td><textarea value="' . $row['introduction'] . '" rows="15" cols="20" ' . $ro . '>' . $row['introduction'] . '</textarea></td>';
				//1の場合、リコメンドのアイコンを表示する
				echo '<td>';
				if ($row['recommend'] == 1) {
					echo '<img src="image/good.png" alt="バイヤーのおすすめ商品です"></img>';
				}
				echo '</td>';

				echo '<td><font color=red>' . $sale_price ?? '' . '</td>';
				if ($row['daily_ranking'] == 1) {
					echo '<td><img src="image/ranking1.png" alt="1位商品です"></img></td>';
				} elseif ($row['daily_ranking'] == 2) {
					echo '<td><img src="image/ranking2.png" alt="2位商品です"></img></td>';
				} elseif ($row['daily_ranking'] == 3) {
					echo '<td><img src="image/ranking3.png" alt="3位商品です"></img></td>';
				} else {
					echo '<td>' . $row['daily_ranking'] . '</td>';
				}
				if ($row['weekly_ranking'] == 1) {
					echo '<td><img src="image/ranking1.png" alt="1位商品です"></img></td>';
				} elseif ($row['weekly_ranking'] == 2) {
					echo '<td><img src="image/ranking2.png" alt="2位商品です"></img></td>';
				} elseif ($row['weekly_ranking'] == 3) {
					echo '<td><img src="image/ranking3.png" alt="3位商品です"></img></td>';
				} else {
					echo '<td>' . $row['weekly_ranking'] . '</td>';
				}
				echo '<td>' . $row['display'] . '</td>';
				echo '</tr>';
			}
			echo '</table>';
			//データが存在しない場合
		} else {
			echo "検索条件に一致する商品は見つかりませんでした。";
		}

		$_SESSION['product'] = [];
		$_SESSION['err'] = [];
	} else {
		echo 'このログイン名は、閲覧権限を有していません。';
	}
} else {
	echo 'ログインして下さい。';
	echo '<form action="login-relay2.php" method="post">
    ログイン名<input type="text" name="login"><br>
    パスワード<input type="password" name="password"><br>
    <input type="submit" value="ログイン">
    </form>';
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

//売上個数のランキング作成
//売上個数の読み込み
function rank()
{
	require('dbconnect.php');
	//ランキングカラム初期化 nullにする
	$sql = $pdo->prepare('UPDATE product SET daily_ranking="", weekly_ranking=""');
	$sql->execute();
	//初期条件
	$today = date('Ymd');
	$date_from[0] =  date('Ymd', strtotime($today - 1));
	$date_from[1] =  date('Ymd', strtotime($today - 7));
	$ranking[0] = 'daily_ranking';
	$ranking[1] = 'weekly_ranking';
	$display = 1;
	$blank = "";
	//売上テーブル読み込み
	//$i  0の場合、daily, 1の場合、weekly
	for ($i = 0; $i <= 1; $i++) {
		//商品別、売上個数のランキング読み込み
		$sql = $pdo->prepare('SELECT pd.product_id, SUM(pd.count) AS count,
		 DENSE_RANK() OVER(ORDER BY count DESC) AS rank
	FROM purchase pu, purchase_detail pd, product pr WHERE pu.purchase_id = pd.purchase_id
	AND pu.purchase_date <? AND pu.purchase_date >=? AND pd.product_id = pr.id AND pr.display = 1
	GROUP BY pd.product_id ORDER BY  SUM(pd.count) DESC, pd.product_id ASC');
		$sql->bindParam(1, $today, PDO::PARAM_INT);
		$sql->bindParam(2, $date_from[$i], PDO::PARAM_INT);
		// $sql->bindParam(3, $display, PDO::PARAM_INT); AND display=?
		$sql->execute();
		// $data = $sql -> fetchall(); var_dump($data);
		//売上テーブルランキング更新
		$count_rank[$i] = 0;
		$row['rank'] = 0;
		foreach ($sql as $row) {
			// print_r($row);
			// echo $i.'PIYO '. $row['product_id'] . ' ' . $row['count'] . ' ' . $row['rank'].'<br>';
			$sql1 = 'UPDATE product SET ' . $ranking[$i] . '=? WHERE id =?';
			// echo $sql1;
			$sql = $pdo->prepare($sql1);
			$sql->bindParam(1, $row['rank'], PDO::PARAM_INT);
			$sql->bindParam(2, $row['product_id'], PDO::PARAM_INT);
			$sql->execute();
			// $count_rank[$i] += 1;
		}
		//売上実績がある最下位の順位に、1を加える。
		$count_rank[$i] = $row['rank'] + 1;
	}
	//購入記録がなくランキングが出ない商品、0 またはnullの商品に、指定した値を入れる
	//$i  0の場合、daily, 1の場合、weekly
	for ($i = 0; $i <= 1; $i++) {
		//購入記録がない商品のランキング
		// echo $count_rank[$i];echo '<br>';
		$sql1 = 'UPDATE product SET  ' . $ranking[$i] . '=?  WHERE ' . $ranking[$i] . '=""';
		// echo $sql1;
		echo '<br>';
		$sql = $pdo->prepare($sql1);
		$sql->bindParam(1, $count_rank[$i], PDO::PARAM_STR);
		$sql->execute();
	}
}
?>
<?php require 'footer.php'; ?>