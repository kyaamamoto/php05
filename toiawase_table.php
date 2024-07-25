<?php
session_start();
require_once 'funcs.php';

// エラーハンドリングのためのtry-catchブロック
try {
    loginCheck(); // ログインチェック

    // データベース接続
    $pdo = db_conn();

    // テーブル作成SQL（テーブルが存在しない場合のみ作成）
    $sql = "
    CREATE TABLE IF NOT EXISTS toiawase_table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        division VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        tel VARCHAR(50) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // データ取得SQL作成
    $stmt = $pdo->prepare("SELECT * FROM toiawase_table ORDER BY created_at DESC");
    $status = $stmt->execute();

    // データ表示用変数
    $view = "<table border='1' style='border-collapse: collapse; width: 100%;' class='responsive-table'>";
    $view .= "<tr>
                <th>ID</th>
                <th>会社名・部署名</th>
                <th>ご担当者名</th>
                <th>メールアドレス</th>
                <th>電話番号</th>
                <th>お問い合わせ内容</th>
                <th>作成日</th>";

    // 管理者であれば削除のヘッダーを追加
    if ($_SESSION['kanri_flg'] == 1) {
        $view .= "<th style='width: 80px;'>削除</th>";
    }

    $view .= "</tr>";

    // データ表示
    if ($status == false) {
        $error = $stmt->errorInfo();
        throw new Exception("ErrorQuery: " . $error[2]);
    } else {
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $view .= "<tr>";
            $view .= "<td>" . h($result['id']) . "</td>";
            $view .= "<td>" . h($result['division']) . "</td>";
            $view .= "<td>" . h($result['name']) . "</td>";
            $view .= "<td>" . h($result['email']) . "</td>";
            $view .= "<td>" . h($result['tel']) . "</td>";
            $view .= "<td>" . h($result['message']) . "</td>";
            $view .= "<td>" . h($result['created_at']) . "</td>";

            // 管理者であれば削除ボタンを追加
            if ($_SESSION['kanri_flg'] == 1) {
                $view .= "<td style='text-align: center;'><button class='btn btn-small' onclick='deleteRecord(" . $result['id'] . ")'>削除</button></td>";
            }

            $view .= "</tr>";
        }
        $view .= "</table>";
    }
} catch (Exception $e) {
    // エラーメッセージを表示
    echo "エラーが発生しました: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>お問い合わせ一覧</title>
<link rel="stylesheet" href="./css/range.css">
<link href="./css/bootstrap.min.css" rel="stylesheet">
<link href="./css/style3.css" rel="stylesheet">
<link href="./css/style2.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>

<script>
function deleteRecord(id) {
    if (confirm('このレコードを削除してもよろしいですか？')) {
        window.location.href = `delete_toiawase.php?id=${id}`;
    }
}

function editRecord(id) {
    window.location.href = `edit.php?id=${id}`;
}
</script>

</head>
<body id="main">
<!-- Head[Start] -->
<header>
<img src="./img/ZOUUUbanner.jpg" alt="zouuu" class="img">
</header>
<!-- Head[End] -->
<h1>お問い合わせ一覧</h1>

<!-- Main[Start] -->
<div id="btnGroup">
    <button><a class="btn" href="cms.php">戻る</a></button>
</div>

<div class="container table-responsive">
    <div class="jumbotron"><?= $view ?></div>
</div>
<!-- Main[End] -->

</body>
</html>