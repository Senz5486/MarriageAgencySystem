<?php
/**
 * ユーザーを「いいね！」する機能
 * バージョン: 1.0.0.0a
 * 作成者: 渡邊 竜樹
 */

session_start();
require 'DBUtility.php'; // DBUtilityを使う
$db = new DBUtility();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$liked_user_id = isset($_POST['liked_user_id']) ? (int)$_POST['liked_user_id'] : 0;

if ($liked_user_id > 0) {
    // 重複して「いいね！」しないようにチェック
    $sql = "SELECT * FROM likes WHERE user_id = ? AND liked_user_id = ?";
    $existing_like = $db->queryOne($sql, [$user_id, $liked_user_id]);

    if (!$existing_like) {
        // 新しい「いいね！」を挿入
        $sql = "INSERT INTO likes (user_id, liked_user_id) VALUES (?, ?)";
        $result = $db->query($sql, [$user_id, $liked_user_id]);

        if ($result) {
            echo "「いいね！」しました。";
        } else {
            echo "「いいね！」に失敗しました。";
        }
    } else {
        echo "既に「いいね！」しています。";
    }
}
?>