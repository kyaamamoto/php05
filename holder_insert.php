<?php
session_start();
require_once 'funcs.php';

// CSRFトークンの検証
validateToken($_POST['csrf_token'] ?? '');

// POSTデータを取得し、サニタイズ
$name = sanitize($_POST["name"] ?? '');
$lid = sanitize($_POST["lid"] ?? '');
$lpw = $_POST["lpw"] ?? ''; // パスワードはサニタイズしない

// 入力値の検証
if (empty($name) || empty($lid) || empty($lpw)) {
    $_SESSION['registration_error'] = "全ての項目を入力してください。";
    redirect('mypage_entry.php');
}

try {
    $pdo = db_conn();
    
    // ユーザーIDの重複チェック
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM holder_table WHERE lid = :lid");
    $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
        $_SESSION['registration_error'] = "このログインIDは既に使用されています。";
        redirect('mypage_entry.php');
    }

    // データ登録SQL作成
    $sql = "INSERT INTO holder_table (name, lid, lpw, life_flg) VALUES (:name, :lid, :lpw, :life_flg)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
    $stmt->bindValue(':lpw', password_hash($lpw, PASSWORD_DEFAULT), PDO::PARAM_STR);
    $stmt->bindValue(':life_flg', 0, PDO::PARAM_INT); // life_flgにデフォルト値を設定

    $status = $stmt->execute();

    if ($status === false) {
        throw new PDOException($stmt->errorInfo()[2]);
    } else {
        $_SESSION['registration_success'] = true;
        redirect('login_holder.php');
    }
} catch (PDOException $e) {
    error_log("登録エラー: " . $e->getMessage());
    error_log("エラー詳細: " . var_export($stmt->errorInfo(), true)); // 詳細なエラー情報をログに記録
    $_SESSION['registration_error'] = "登録中にエラーが発生しました。管理者にお問い合わせください。";
    redirect('mypage_entry.php');
}
?>