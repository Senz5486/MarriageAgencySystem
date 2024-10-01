<?php
/**
 * プロフィール表示
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

// ユーザー情報を取得
$sql = "SELECT username, email, bio FROM users WHERE id = ?";
$user = $db->queryOne($sql, [$user_id]);

if ($user):
?>
    <h1>プロフィール情報</h1>
    <p>ユーザー名: <?php echo htmlspecialchars($user['username']); ?></p>
    <p>メールアドレス: <?php echo htmlspecialchars($user['email']); ?></p>
    <p>自己紹介: <?php echo htmlspecialchars($user['bio']); ?></p>
    <a href="edit_profile.php">プロフィールを編集する</a>
<?php else: ?>
    <p>ユーザー情報が見つかりません。</p>
<?php endif; ?>
