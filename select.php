<?php
// セッション開始
session_start();
require_once('funcs.php');
loginCheck(); // ログインチェック

// データベース接続
$pdo = db_conn();

// 会員情報取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM member_table");
$status = $stmt->execute();

// 追加.テーブルの開始タグとヘッダー行
$view = "<table border='1' style='border-collapse: collapse' class='responsive-table'>";
$view .= "<tr>
            <th>id</th>
            <th>name</th>
            <th>birthDay</th>
            <th>tel</th>
            <th>email</th>
            <th>address1</th>
            <th>address2</th>
            <th>Birthplace1</th>
            <th>Birthplace2</th>
            <th>addressInterest</th>
            <th>birthplaceInterest</th>
            <th>mytownInterest</th>
            <th>food</th>
            <th>travel</th>
            <th>hobby</th>
            <th>action</th>
            <th>datetime</th>";

// 管理者であれば編集、削除のヘッダーを追加
if ($_SESSION['kanri_flg'] == 1) {
    $view .= "<th>edit</th>
              <th>delete</th>";
}

$view .= "</tr>";

// データ表示
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("ErrorQuery: " . $error[2]);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= "<tr>";
        $view .= "<td>" . h($result['id']) . "</td>";
        $view .= "<td>" . h($result['name']) . "</td>";
        $view .= "<td>" . h($result['birthDay']) . "</td>";
        $view .= "<td>" . h($result['tel']) . "</td>";
        $view .= "<td>" . h($result['email']) . "</td>";
        $view .= "<td>" . h($result['jusho1']) . "</td>";
        $view .= "<td>" . h($result['jusho2']) . "</td>";
        $view .= "<td>" . h($result['jusho3']) . "</td>";
        $view .= "<td>" . h($result['jusho4']) . "</td>";
        $view .= "<td>" . h($result['kanshin1']) . "</td>";
        $view .= "<td>" . h($result['kanshin2']) . "</td>";
        $view .= "<td>" . h($result['kanshin3']) . "</td>";
        $view .= "<td>" . h($result['food']) . "</td>";
        $view .= "<td>" . h($result['travel']) . "</td>";
        $view .= "<td>" . h($result['shumi']) . "</td>";
        $view .= "<td>" . h($result['action']) . "</td>";
        $view .= "<td>" . h($result['datetime']) . "</td>";

        // 管理者であれば編集、削除ボタンを追加
        if ($_SESSION['kanri_flg'] == 1) {
            $view .= "<td><button class='btn btn-small' onclick='editRecord(" . $result['id'] . ")'>編集</button></td>";
            $view .= "<td><button class='btn btn-small' onclick='deleteRecord(" . $result['id'] . ")'>削除</button></td>";
        }

        $view .= "</tr>";
    }
    $view .= "</table>";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>会員情報一覧</title>
<link rel="stylesheet" href="./css/range.css">
<link href="./css/bootstrap.min.css" rel="stylesheet">
<link href="./css/style3.css" rel="stylesheet">
<link href="./css/style2.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>

<script>
function deleteRecord(id) {
    if (confirm('このレコードを削除してもよろしいですか？')) {
        window.location.href = `delete.php?id=${id}`;
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
<h1>会員情報一覧</h1>

<!-- Main[Start] -->
<div id="btnGroup">
    <button><a class="btn" href="cms.php">戻る</a></button>
    <button><a class="btn" href="analysis.php">会員情報分析</a></button>
    <button><a class="btn" href="download.php">ダウンロード</a></button> <!-- ダウンロードボタンのリンクを追加 -->
</div>

<div class="container table-responsive">
    <div class="jumbotron"><?= $view ?></div>
</div>
<!-- Main[End] -->

</body>
</html>