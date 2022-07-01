<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=shop;charset=utf8', 'staff', 'password');
    //'mysql:host=localhost;dbname=shop;charset=utf8', 'staff', 'password'
    //$pdo = new PDO('mysql:dbname=shop;host=127.0.0.1;charset=utf8', 'root', '');
} catch (PDOException $e) {
    echo 'DB接続エラー： ' . $e->getMessage();
}
?>