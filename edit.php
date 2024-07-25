<?php
require_once('funcs.php');

// 本番環境データベース
$prod_db = "zouuu_zouuu_db";

// 本番環境ホスト
$prod_host = "mysql635.db.sakura.ne.jp"; 

// 本番環境ID
$prod_id = "zouuu";

// 本番環境PW
$prod_pw = "12345678qju"; 

// DB接続
// DB接続
try {
    $pdo = new PDO('mysql:dbname=' . $prod_db . ';charset=utf8;host=' . $prod_host, $prod_id, $prod_pw);
} catch (PDOException $e) {
    exit('DBConnectError:' . $e->getMessage());
}

// GETパラメータからIDを取得
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id === null) {
    exit('IDが指定されていません');
}

// データ取得SQL作成
$sql = "SELECT * FROM member_table WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// データ取得
if ($status === false) {
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
} else {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        exit('指定されたIDのデータが見つかりません');
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>プロフィール編集</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="container">
        <img src="./img/ZOUUUbanner.jpg" alt="zouuu" class="img">
        <h1>プロフィール編集</h1>
        <form action="update.php" method="post" class="form">
            <input type="hidden" name="id" value="<?= h($result['id']) ?>">
            <div class="form-group">
                <label for="name">お名前: <span class="required">必須</span></label>
                <input type="text" id="name" name="name" value="<?= h($result['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="birthDay">生年月日: <span class="required">必須</span></label>
                <input type="date" id="birthDay" name="birthDay" value="<?= h($result['birthDay']) ?>" required>
            </div>
            <div class="form-group">
                <label for="tel">電話番号: <span class="required">必須</span></label>
                <input type="tel" id="tel" name="tel" value="<?= h($result['tel']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email: <span class="required">必須</span></label>
                <input type="email" id="email" name="email" value="<?= h($result['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="jusho1">お住まいの都道府県: <span class="required">必須</span></label>
                <select id="jusho1" name="jusho1" required>
                    <option value="">選択してください</option>
                    <!-- 都道府県リスト -->
                    <?php
                    $prefectures = ["北海道", "青森県", "岩手県", "宮城県", "秋田県", "山形県", "福島県", "茨城県", "栃木県", "群馬県", "埼玉県", "千葉県", "東京都", "神奈川県", "新潟県", "富山県", "石川県", "福井県", "岐阜県", "静岡県", "長野県", "愛知県", "山梨県", "三重県", "滋賀県", "京都府", "大阪府", "兵庫県", "奈良県", "和歌山県", "鳥取県", "島根県", "岡山県", "広島県", "山口県", "徳島県", "香川県", "愛媛県", "高知県", "福岡県", "佐賀県", "長崎県", "熊本県", "大分県", "宮崎県", "鹿児島県", "沖縄県"];
                    foreach ($prefectures as $prefecture) {
                        $selected = $result['jusho1'] == $prefecture ? 'selected' : '';
                        echo "<option value='$prefecture' $selected>$prefecture</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="jusho2">市区町村: <span class="required">必須</span></label>
                <input type="text" id="jusho2" name="jusho2" value="<?= h($result['jusho2']) ?>" required>
            </div>
            <div class="form-group">
                <label for="jusho3">ご出身の都道府県: <span class="required">必須</span></label>
                <select id="jusho3" name="jusho3" required>
                    <option value="">選択してください</option>
                    <!-- 都道府県リスト -->
                    <?php
                    foreach ($prefectures as $prefecture) {
                        $selected = $result['jusho3'] == $prefecture ? 'selected' : '';
                        echo "<option value='$prefecture' $selected>$prefecture</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="jusho4">市区町村: <span class="required">必須</span></label>
                <input type="text" id="jusho4" name="jusho4" value="<?= h($result['jusho4']) ?>" required>
            </div>

            <h1>あなたの興味・関心について教えてください。</h1>
            <div class="form-group">
                <h2>< 地域編 ></h2>
                <label for="kanshin1">現在のお住まいの地域についての興味・関心について教えてください。 <span class="required">必須</span></label>
                <select id="kanshin1" name="kanshin1" required>
                    <option value="">選択してください</option>
                    <option value="とても興味・関心がある" <?= h($result['kanshin1']) == 'とても興味・関心がある' ? 'selected' : '' ?>>とても興味・関心がある</option>
                    <option value="やや興味・関心がある" <?= h($result['kanshin1']) == 'やや興味・関心がある' ? 'selected' : '' ?>>やや興味・関心がある</option>
                    <option value="あまり興味・関心はない" <?= h($result['kanshin1']) == 'あまり興味・関心はない' ? 'selected' : '' ?>>あまり興味・関心はない</option>
                    <option value="まったく興味・関心はない" <?= h($result['kanshin1']) == 'まったく興味・関心はない' ? 'selected' : '' ?>>まったく興味・関心はない</option>
                </select><br>
            </div>
            <div class="form-group">
                <label for="kanshin2">出身地への興味・関心について教えてください。 <span class="required">必須</span></label>
                <select id="kanshin2" name="kanshin2" required>
                    <option value="">選択してください</option>
                    <option value="とても興味・関心がある" <?= h($result['kanshin2']) == 'とても興味・関心がある' ? 'selected' : '' ?>>とても興味・関心がある</option>
                    <option value="やや興味・関心がある" <?= h($result['kanshin2']) == 'やや興味・関心がある' ? 'selected' : '' ?>>やや興味・関心がある</option>
                    <option value="あまり興味・関心はない" <?= h($result['kanshin2']) == 'あまり興味・関心はない' ? 'selected' : '' ?>>あまり興味・関心はない</option>
                    <option value="まったく興味・関心はない" <?= h($result['kanshin2']) == 'まったく興味・関心はない' ? 'selected' : '' ?>>まったく興味・関心はない</option>
                </select><br>
            </div>
            <div class="form-group">
                <label for="kanshin3">（当市・当区・当町・当村）への興味・関心について教えてください。 <span class="required">必須</span></label>
                <select id="kanshin3" name="kanshin3" required>
                    <option value="">選択してください</option>
                    <option value="とても興味・関心がある" <?= h($result['kanshin3']) == 'とても興味・関心がある' ? 'selected' : '' ?>>とても興味・関心がある</option>
                    <option value="やや興味・関心がある" <?= h($result['kanshin3']) == 'やや興味・関心がある' ? 'selected' : '' ?>>やや興味・関心がある</option>
                    <option value="あまり興味・関心はない" <?= h($result['kanshin3']) == 'あまり興味・関心はない' ? 'selected' : '' ?>>あまり興味・関心はない</option>
                    <option value="まったく興味・関心はない" <?= h($result['kanshin3']) == 'まったく興味・関心はない' ? 'selected' : '' ?>>まったく興味・関心はない</option>
                </select>
            </div>

            <h2>< 食べ物編 ></h2>
            <div class="form-group">
                <label>地域の食べ物について興味のあるものにチェックしてください。（複数選択可） <span class="any">任意</span></label>
                <div class="checkbox-group">
                    <?php
                    $food_options = ["肉", "魚介", "野菜", "果物", "米", "飲料", "卵", "麺類", "調味料", "その他", "興味なし"];
                    $food_selected = explode(',', $result['food']);
                    foreach ($food_options as $food) {
                        $checked = in_array($food, $food_selected) ? 'checked' : '';
                        echo "<input type='checkbox' id='food_$food' name='food[]' value='$food' $checked><label for='food_$food'>$food</label>";
                    }
                    ?>
                </div>
            </div>

            <h2>< 旅行・観光編 ></h2>
            <div class="form-group">
                <label>旅行・観光について興味のあるものにチェックしてください。（複数選択可） <span class="any">任意</span></label>
                <div class="checkbox-group">
                    <?php
                    $travel_options = ["山・高原", "海", "川", "島", "神社・仏閣", "歴史的街並み", "博物館・美術館", "動物園・植物園・水族館", "産業観光", "温泉・サウナ", "スキー場", "キャンプ場", "公園", "伝統工芸", "商業施設・テーマパーク", "食・グルメ", "その他", "興味なし"];
                    $travel_selected = explode(',', $result['travel']);
                    foreach ($travel_options as $travel) {
                        $checked = in_array($travel, $travel_selected) ? 'checked' : '';
                        echo "<input type='checkbox' id='travel_$travel' name='travel[]' value='$travel' $checked><label for='travel_$travel'>$travel</label>";
                    }
                    ?>
                </div>
            </div>

            <h2>< 趣味・娯楽編 ></h2>
            <div class="form-group">
                <label>趣味・娯楽について興味のあるものにチェックしてください。（複数選択可） <span class="any">任意</span></label>
                <div class="checkbox-group">
                    <?php
                    $shumi_options = ["散歩・ウォーキング", "読書", "映画鑑賞", "料理", "温泉・サウナ", "ガーデニング", "旅", "飲食", "カメラ", "筋トレ・ストレッチ", "釣り", "ロードバイク・サイクリング", "ドライブ・ツーリング", "スポーツ（野球・ゴルフなど）", "ヨガ・ピラティス", "カフェ巡り", "キャンプ・グランピング", "サーフィン", "スキューバダイビング", "登山・トレッキング", "スノーボード・スキー", "美術鑑賞", "史跡巡り", "御朱印集め", "ドローン", "その他", "興味なし"];
                    $shumi_selected = explode(',', $result['shumi']);
                    foreach ($shumi_options as $shumi) {
                        $checked = in_array($shumi, $shumi_selected) ? 'checked' : '';
                        echo "<input type='checkbox' id='shumi_$shumi' name='shumi[]' value='$shumi' $checked><label for='shumi_$shumi'>$shumi</label>";
                    }
                    ?>
                </div>
            </div>

            <h2>< 地域活動編 ></h2>
            <div class="form-group">
                <label>地域での活動について興味のあるものにチェックしてください。（複数選択可） <span class="any">任意</span></label>
                <div class="checkbox-group">
                    <?php
                    $action_options = ["起業・転職・就職", "ボランティア", "事業承継", "住まい（空き家含む）", "教育・子育て", "医療・福祉", "防災", "交通", "その他", "興味なし"];
                    $action_selected = explode(',', $result['action']);
                    foreach ($action_options as $action) {
                        $checked = in_array($action, $action_selected) ? 'checked' : '';
                        echo "<input type='checkbox' id='action_$action' name='action[]' value='$action' $checked><label for='action_$action'>$action</label>";
                    }
                    ?>
                </div>
            </div>

            <div class="form-group center">
                <button type="submit" class="submit-btn">更新</button>
            </div>
        </form>
        <a href="select.php">戻る</a>
    </div>
</body>
</html>
