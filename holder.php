<?php
session_start();

if (!isset($_SESSION['name'])) {
    header('Location: login_holder.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ふるさとID マイページ ダッシュボード</title>
      <!-- ファビコン -->
   <link rel="icon" type="image/png" href="https://zouuu.sakura.ne.jp/zouuu/img/IDfavicon.ico">
    <link rel="stylesheet" href="./css/styleholder.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var username = "<?php echo htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8'); ?>";
            document.getElementById('username').innerText = username;
        });
    </script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="https://zouuu.sakura.ne.jp/zouuu/img/fIDLogo.png" alt="ふるさとID ロゴ">
        </div>
        <nav>
            <ul>
                <li><a href="#">マイページ</a></li>
                <li><a href="matching.html">自治体マッチング</a></li>
                <li><a href="furusatoID_apply.php">ふるさとID申請</a></li>
                <li><a href="#">活動記録</a></li>
                <li><a href="logoutmypage.php">ログアウト</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="dashboard">
            <div class="welcome">
                <h1>ようこそ、<span id="username"></span>さん</h1>
            </div>

            <div class="status">
                <h2>ふるさとID 保有状況</h2>

                <div class="id_block">
                    <p>北海道当麻町ふるさとID</p>
                    <p>ランク: ゴールド</p>
                </div>

                <div class="id_block">
                    <p>青森県五所川原市ふるさとID</p>
                    <p>ランク: レギュラー</p>
                </div>

                <div class="id_block">
                    <p>高知県四万十町ふるさとID</p>
                    <p>ランク: ダイヤモンド</p>
                </div>

            </div>

            <div class="actions">
                <a href="matching.html"><button class="matching-btn">自治体マッチング</button></a>
                <a href="furusatoID_apply.php"><button>ふるさとID申請</button></a>
                <button>活動記録</button>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 ふるさとID. All rights reserved.</p>
    </footer>
</body>
</html>