<?php
session_start();
require_once 'funcs.php';

// エラーハンドリングのためのtry-catchブロック
try {
    loginCheck(); // ログインチェック

    // データベース接続
    $pdo = db_conn();

    // データ取得SQL作成（created_at と updated_at を削除）
    $stmt = $pdo->prepare("SELECT id, name, lid, kanri_flg FROM user_table");
    $status = $stmt->execute();

    // データ表示用変数
    $view = "<table border='1' style='border-collapse: collapse; width: 100%;' class='responsive-table'>";
    $view .= "<tr>
                <th>ID</th>
                <th>Name</th>
                <th>Login ID</th>
                <th>管理FLG</th>";

    // 管理者であれば削除のヘッダーを追加
    if ($_SESSION['kanri_flg'] == 1) {
        $view .= "<th style='width: 80px;'>Delete</th>";
        // $view .= "<th>Edit</th>"; // 編集ボタンをコメントアウト
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
            $view .= "<td>" . h($result['name']) . "</td>";
            $view .= "<td>" . h($result['lid']) . "</td>";
            $view .= "<td>" . h($result['kanri_flg']) . "</td>";

            // 管理者であれば削除ボタンを追加
            if ($_SESSION['kanri_flg'] == 1) {
                $view .= "<td style='text-align: center;'><button class='btn btn-small' onclick='deleteRecord(" . $result['id'] . ")'>削除</button></td>";
                // $view .= "<td><button class='btn btn-small' onclick='editRecord(" . $result['id'] . ")'>編集</button></td>"; // 編集ボタンをコメントアウト
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
<title>ユーザー情報一覧</title>
<link rel="stylesheet" href="./css/range.css">
<link href="./css/bootstrap.min.css" rel="stylesheet">
<link href="./css/style3.css" rel="stylesheet">
<link href="./css/style2.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>

<script>
function deleteRecord(id) {
    if (confirm('このレコードを削除してもよろしいですか？')) {
        window.location.href = `user_delete.php?id=${id}`;
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
<h1>ユーザー情報一覧</h1>

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