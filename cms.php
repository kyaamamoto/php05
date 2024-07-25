<?php
session_start();
require_once 'funcs.php';
loginCheck(); // セッションが有効かどうかを確認する関数を呼び出します
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZOUUU Platform</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .navbar-custom {
            background-color: #0c344e;
        }
        .navbar-custom .nav-link, .navbar-custom .navbar-brand {
            color: white;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <a class="navbar-brand" href="#">
        <img src="./img/ZOUUU.png" alt="ZOUUU Logo" class="d-inline-block align-top" height="30">
        ZOUUU Platform
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link">ようこそ <?php echo htmlspecialchars($_SESSION['name']); ?> さん</span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">ログアウト</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0">ふるさとID</h5>
                </div>
                <div class="card-body">
                    <h6 class="card-title">会員情報一覧</h6>
                    <p class="card-text">ふるさとID会員の一覧を確認できます。</p>
                    <a href="select.php" class="btn btn-primary">会員情報を確認</a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0">お問い合わせ</h5>
                </div>
                <div class="card-body">
                    <h6 class="card-title">お問い合わせ一覧</h6>
                    <p class="card-text">HP経由のお問い合わせ内容を確認できます。</p>
                    <a href="toiawase_table.php" class="btn btn-primary">お問い合わせを確認</a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0">管理システムユーザー</h5>
                </div>
                <div class="card-body">
                    <h6 class="card-title">ユーザー情報</h6>
                    <p class="card-text">管理システムユーザーの一覧を確認できます。</p>
                    <a href="user_table.php" class="btn btn-primary">ユーザー情報を確認</a>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer bg-light text-center py-3 mt-4">
    <div class="container">
        <span class="text-muted">Copyright &copy; 2019-2024 <a href="#">ZOUUU</a>. All rights reserved.</span>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>