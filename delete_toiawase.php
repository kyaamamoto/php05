<?php
require_once('funcs.php');
session_start();

// ログインチェック
loginCheck();

// 管理者チェック
if ($_SESSION['kanri_flg'] != 1) {
    exit("アクセス権がありません。");
}

// GETデータ取得
$id = $_GET['id'] ?? null;

if ($id) {
    // データベース接続
    $pdo = db_conn();

    // データ削除SQL
    $stmt = $pdo->prepare("DELETE FROM toiawase_table WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();

    // エラー処理
    if ($status == false) {
        $error = $stmt->errorInfo();
        exit("QueryError: " . $error[2]);
    } else {
        header("Location: toiawase_table.php");
        exit();
    }
} else {
    exit("不正なアクセスです。");
}
?>