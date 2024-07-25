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
  <title>ユーザー登録</title>
   <!-- ファビコン -->
   <link rel="icon" type="image/png" href="https://zouuu.sakura.ne.jp/zouuu/img/IDfavicon.ico">
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
    <img src="https://zouuu.sakura.ne.jp/zouuu/img/fIDLogo.png" alt="furusatoID">
    <h1>ユーザー登録</h1>
    <?php
    // エラーメッセージの表示
    if (isset($_SESSION['registration_error'])) {
        echo "<p class='error'>" . h($_SESSION['registration_error']) . "</p>";
        unset($_SESSION['registration_error']);
    }
    ?>
    <form method="post" action="holder_insert.php" onsubmit="return validateForm()">
      <div class="form-group">
        <label for="name">名前:</label>
        <input type="text" name="name" id="name" required>
      </div>
      <div class="form-group">
        <label for="lid">Login ID:</label>
        <input type="text" name="lid" id="lid" required>
      </div>
      <div class="form-group">
        <label for="lpw">Login PW:</label>
        <input type="password" name="lpw" id="lpw" required>
      </div>
      <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>">
      <button type="submit" class="btn">送信</button>
    </form>
    <div class="btn-register mt-3">
      <a href="login_holder.php">ログインはこちら</a>
    </div>
  </div>

  <script>
  function validateForm() {
      var name = document.forms[0]["name"].value;
      var lid = document.forms[0]["lid"].value;
      var lpw = document.forms[0]["lpw"].value;
      if (name == "" || lid == "" || lpw == "") {
          alert("全ての項目を入力してください");
          return false;
      }
      return true;
  }
  </script>
</body>
</html>