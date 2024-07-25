<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. POSTデータ取得
$name     = $_POST["name"] ?? '';      // 名前
$birthDay = $_POST["birthDay"] ?? '';  // 生年月日
$tel      = $_POST["tel"] ?? '';       // 電話番号
$email    = $_POST["email"] ?? '';     // メールアドレス
$jusho1   = $_POST["jusho1"] ?? '';    // 住所1（都道府県）
$jusho2   = $_POST["jusho2"] ?? '';    // 住所2（市区町村）
$jusho3   = $_POST["jusho3"] ?? '';    // 出身地1（都道府県）
$jusho4   = $_POST["jusho4"] ?? '';    // 出身地2（市区町村）
$kanshin1 = $_POST["kanshin1"] ?? '';  // お住まいの地域への興味・関心度合
$kanshin2 = $_POST["kanshin2"] ?? '';  // 出身地への興味・関心度合
$kanshin3 = $_POST["kanshin3"] ?? '';  // その他地域への興味・関心度合

// JSONデータを配列にデコード
$food     = json_decode($_POST["food"], true);
$travel   = json_decode($_POST["travel"], true);
$shumi    = json_decode($_POST["shumi"], true);
$action   = json_decode($_POST["action"], true);

// 配列データをカンマ区切りの文字列に変換
$food     = is_array($food) ? implode(", ", $food) : '';
$travel   = is_array($travel) ? implode(", ", $travel) : '';
$shumi    = is_array($shumi) ? implode(", ", $shumi) : '';
$action   = is_array($action) ? implode(", ", $action) : '';

// 本番環境データベース
$prod_db = "zouuu_zouuu_db";

// 本番環境ホスト
$prod_host = "mysql635.db.sakura.ne.jp";

// 本番環境ID
$prod_id = "zouuu";

// 本番環境PW
$prod_pw = "12345678qju";

// 2. DB接続します
try {
    // ID:'root', Password: xamppは 空白 ''
    $pdo = new PDO('mysql:dbname=' . $prod_db . ';charset=utf8;host=' . $prod_host, $prod_id, $prod_pw);
} catch (PDOException $e) {
    exit('DBConnectError:' . $e->getMessage());
}

// 3. データ登録SQL作成
$stmt = $pdo->prepare('INSERT INTO
    member_table(id, name, birthDay, tel, email, jusho1, jusho2, jusho3, jusho4, kanshin1, kanshin2, kanshin3, food, travel, shumi, action, datetime)
    VALUES(NULL, :name, :birthDay, :tel, :email, :jusho1, :jusho2, :jusho3, :jusho4, :kanshin1, :kanshin2, :kanshin3, :food, :travel, :shumi, :action, now() )');

// 4. バインド変数を用意
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':birthDay', $birthDay, PDO::PARAM_STR);
$stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':jusho1', $jusho1, PDO::PARAM_STR);
$stmt->bindValue(':jusho2', $jusho2, PDO::PARAM_STR);
$stmt->bindValue(':jusho3', $jusho3, PDO::PARAM_STR);
$stmt->bindValue(':jusho4', $jusho4, PDO::PARAM_STR);
$stmt->bindValue(':kanshin1', $kanshin1, PDO::PARAM_STR);
$stmt->bindValue(':kanshin2', $kanshin2, PDO::PARAM_STR);
$stmt->bindValue(':kanshin3', $kanshin3, PDO::PARAM_STR);
$stmt->bindValue(':food', $food, PDO::PARAM_STR);
$stmt->bindValue(':travel', $travel, PDO::PARAM_STR);
$stmt->bindValue(':shumi', $shumi, PDO::PARAM_STR);
$stmt->bindValue(':action', $action, PDO::PARAM_STR);

// 5. 実行
$status = $stmt->execute();

// 6. データ登録処理後
if ($status === false) {
    // SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('ErrorMessage:' . $error[2]);
} else {
    // 7. index.phpへリダイレクト
    header('Location: index.php');
    exit;
}
?>