<?php
session_start();
require_once 'funcs.php';
loginCheck(); // ログインチェック

// GETデータ取得
$id = $_GET['id'];

// データベース接続
$pdo = db_conn();

// データ削除SQL作成
$stmt = $pdo->prepare("DELETE FROM user_table WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// データ削除後の処理
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('user_table.php');
}
?>