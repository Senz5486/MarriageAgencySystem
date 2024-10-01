<?php
/**
 * プロフィール編集
 * バージョン: 1.0.0.0a
 * 作成者: 渡邊 竜樹
 */

session_start();
require 'DBUtility.php'; // DBUtilityを使う
$db = new DBUtility();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // ログインしていない場合はログインページにリダイレクト
    exit;
}

$user_id = $_SESSION['user_id'];

// 現在のプロフィール情報を取得
$sql = "SELECT username, email, bio FROM users WHERE id = ?";
$user = $db->queryOne($sql, [$user_id]);

if ($user):
?>
    <h1>プロフィール編集</h1>
    <form method="POST" action="update_profile.php">
        <label>ユーザー名</label><br>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>
        <label>メールアドレス</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
        <label>自己紹介</label><br>
        <textarea name="bio"><?php echo htmlspecialchars($user['bio']); ?></textarea><br>
        <button type="submit">更新する</button>
    </form>
<?php else: ?>
    <p>ユーザー情報が見つかりません。</p>
<?php endif; ?>
