<?php
session_start();
require_once 'funcs.php';

// CSRFトークンの生成
$csrf_token = generateToken();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="./css/style4.css">
    <style>
        .message {
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }
        .error {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="img/ZOUUUbanner.jpg" alt="ZOUUU Banner">
        <h1>ログイン</h1>
        <?php
        // 登録成功メッセージの表示
        if (isset($_SESSION['registration_success'])) {
            echo "<p class='message'>ユーザー登録が完了しました。ログインしてください。</p>";
            unset($_SESSION['registration_success']);
        }
        ?>
        <form name="form1" action="auth.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="lid">ID:</label>
                <input type="text" name="lid" id="lid" required>
            </div>
            <div class="form-group">
                <label for="lpw">PW:</label>
                <input type="password" name="lpw" id="lpw" required>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>">
            <button type="submit" class="btn">ログイン</button>
        </form>
        <div class="btn-register mt-3">
            <a href="cmslogin.php">ユーザー登録はこちら</a>
        </div>
        <?php
        // ログインエラーメッセージの表示
        if (isset($_SESSION['login_error'])) {
            echo "<p class='error'>" . h($_SESSION['login_error']) . "</p>";
            unset($_SESSION['login_error']);
        }
        ?>
    </div>
    <?php
    // ログインID重複エラーメッセージの表示
    if (isset($_SESSION['registration_error'])) {
        echo "<p class='error' style='text-align: center;'>" . h($_SESSION['registration_error']) . "</p>";
        unset($_SESSION['registration_error']);
    }
    ?>

    <script>
    function validateForm() {
        var lid = document.forms["form1"]["lid"].value;
        var lpw = document.forms["form1"]["lpw"].value;
        if (lid == "" || lpw == "") {
            alert("IDとパスワードを入力してください");
            return false;
        }
        return true;
    }
    </script>
</body>
</html>