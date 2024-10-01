<?php
/**
 * パスワードリセット処理
 * バージョン: 1.0.0.0a
 * 作成者: 渡邊 竜樹
 */

require 'db.php'; // データベース接続ファイルをインクルード

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // ユーザー確認
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // パスワードを新しく生成
        $new_password = bin2hex(random_bytes(4)); // ランダムな8文字のパスワード
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // パスワードを更新
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$hashed_password, $email]);

        // 新しいパスワードをメールで送信（ここは簡易な出力例）
        echo "新しいパスワード: " . $new_password;
    } else {
        echo "メールアドレスが見つかりません。";
    }
}
?>

<!-- パスワードリセットフォーム -->
<form method="POST" action="reset_password.php">
    <label>メールアドレス</label><br>
    <input type="email" name="email" required><br>
    <button type="submit">パスワードリセット</button>
</form>
