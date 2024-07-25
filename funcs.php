<?php
//共通に使う関数を記述

// XSS対応（echoする場所で使用！それ以外はNG）
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// データベース接続関数
function db_conn() {
    // エラーレポートを有効にする
    error_reporting(E_ALL);
    ini_set('display_errors', 0); // 本番環境では0に設定
    ini_set('log_errors', 'On');
    ini_set('error_log', '/Applications/XAMPP/xamppfiles/logs/error.log'); // 適切なパスを指定

    // データベース接続情報
    $dsn = 'mysql:dbname=zouuu_zouuu_db;host=mysql635.db.sakura.ne.jp;charset=utf8mb4';
    $user = 'zouuu';
    $password = '12345678qju';

    try {
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        error_log("データベース接続失敗: " . $e->getMessage());
        exit("データベース接続エラーが発生しました。管理者にお問い合わせください。");
    }
}

// ログインチェック関数
function loginCheck() {
    if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] !== session_id()) {
        header("Location: login.php");
        exit();
    } else {
        session_regenerate_id(true);
        $_SESSION["chk_ssid"] = session_id();
    }
}

// CSRF対策用トークン生成関数
function generateToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// CSRF対策用トークン検証関数
function validateToken($token) {
    if (empty($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        exit("不正なリクエストです。");
    }
}

// 入力値のサニタイズ関数
function sanitize($input) {
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

// リダイレクト関数
function redirect($url) {
    header("Location: " . $url);
    exit();
}
?>