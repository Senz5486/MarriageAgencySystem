<?php
/**
 * ログイン処理
 * バージョン: 1.0.0.0a
 * 作成者: 渡邊 竜樹
 */

session_start();
require 'db.php'; // データベース接続ファイルをインクルード

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // バリデーション
    if (empty($email) || empty($password)) {
        echo "すべてのフィールドを入力してください。";
        exit;
    }

    // ユーザーを検索
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // ログイン成功
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo "ログイン成功！";
        header('Location: dashboard.php'); // ダッシュボードにリダイレクト
        exit;
    } else {
        echo "メールアドレスまたはパスワードが間違っています。";
    }
}
?>

<!-- ログインフォーム -->
<form method="POST" action="login.php">
    <label>メールアドレス</label><br>
    <input type="email" name="email" required><br>
    <label>パスワード</label><br>
    <input type="password" name="password" required><br>
    <button type="submit">ログイン</button>
</form>
