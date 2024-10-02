<?php
/**
 * メッセージ表示機能（既読・ファイル表示機能追加）
 * バージョン: 1.1.0.0a
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
$recipient_id = isset($_GET['recipient_id']) ? (int)$_GET['recipient_id'] : 0;

if ($recipient_id > 0) {
    // ログイン中のユーザーと指定されたユーザー間のメッセージを取得
    $sql = "SELECT id, sender_id, message, file_path, created_at, is_read 
            FROM messages 
            WHERE (sender_id = ? AND recipient_id = ?) 
               OR (sender_id = ? AND recipient_id = ?) 
            ORDER BY created_at ASC";
    $messages = $db->query($sql, [$user_id, $recipient_id, $recipient_id, $user_id]);

    // メッセージを表示し、既読に更新
    foreach ($messages as $message) {
        // 送信者によるメッセージ
        if ($message['sender_id'] == $user_id) {
            echo "<div style='text-align:right;'>あなた: " . htmlspecialchars($message['message']) . " (" . $message['created_at'] . ")<br>";
            if ($message['file_path']) {
                echo "<a href='" . htmlspecialchars($message['file_path']) . "'>ファイルをダウンロード</a>";
            }
            echo "</div>";
        } else {
            echo "<div style='text-align:left;'>相手: " . htmlspecialchars($message['message']) . " (" . $message['created_at'] . ")<br>";
            if ($message['file_path']) {
                echo "<a href='" . htmlspecialchars($message['file_path']) . "'>ファイルをダウンロード</a>";
            }
            echo "</div>";

            // メッセージを既読に更新
            $update_sql = "UPDATE messages SET is_read = 1 WHERE id = ?";
            $db->query($update_sql, [$message['id']]);
        }

        // 既読・未読の表示
        if ($message['sender_id'] == $user_id && $message['is_read']) {
            echo "<span style='color: green;'>既読</span>";
        } elseif ($message['sender_id'] == $user_id) {
            echo "<span style='color: red;'>未読</span>";
        }
    }
} else {
    echo "相手を選んでください。";
}
?>