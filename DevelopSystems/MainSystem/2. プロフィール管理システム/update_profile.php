<?php
/**
 * プロフィール更新処理
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $bio = trim($_POST['bio']);

    // バリデーション
    if (empty($username) || empty($email)) {
        echo "ユーザー名とメールアドレスは必須です。";
        exit;
    }

    // プロフィール情報を更新
    $sql = "UPDATE users SET username = ?, email = ?, bio = ? WHERE id = ?";
    $result = $db->query($sql, [$username, $email, $bio, $user_id]);

    if ($result) {
        echo "プロフィールが更新されました。";
        header('Location: profile.php'); // プロフィールページにリダイレクト
        exit;
    } else {
        echo "プロフィールの更新に失敗しました。";
    }
}
?>