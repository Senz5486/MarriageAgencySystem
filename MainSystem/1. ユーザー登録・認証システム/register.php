<?php
/**
 * ユーザー登録処理
 * バージョン: 1.0.0.0a
 * 作成者: 渡邊 竜樹
 */

require 'db.php'; // データベース接続ファイルをインクルード

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // バリデーション
    if (empty($username) || empty($email) || empty($password)) {
        echo "すべてのフィールドを入力してください。";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "パスワードが一致しません。";
        exit;
    }

    // パスワードをハッシュ化
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // データベースにユーザーを挿入
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$username, $email, $hashed_password]);

    if ($result) {
        echo "登録が完了しました！";
    } else {
        echo "登録に失敗しました。";
    }
}
?>

<!-- 登録フォーム -->
<form method="POST" action="register.php">
    <label>ユーザー名</label><br>
    <input type="text" name="username" required><br>
    <label>メールアドレス</label><br>
    <input type="email" name="email" required><br>
    <label>パスワード</label><br>
    <input type="password" name="password" required><br>
    <label>パスワード確認</label><br>
    <input type="password" name="confirm_password" required><br>
    <button type="submit">登録</button>
</form>
