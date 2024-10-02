<?php
/**
 * メッセージ送信機能（ファイル添付・既読機能追加）
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
$recipient_id = isset($_POST['recipient_id']) ? (int)$_POST['recipient_id'] : 0;
$message = isset($_POST['message']) ? trim($_POST['message']) : '';
$file = $_FILES['file'] ?? null; // ファイルが添付されているか確認

// ファイルアップロードの処理
$uploaded_file_path = null;
if ($file && $file['error'] == 0) {
    $upload_dir = 'uploads/'; // アップロードディレクトリ
    $uploaded_file_path = $upload_dir . basename($file['name']);
    
    // ファイルをアップロード
    if (!move_uploaded_file($file['tmp_name'], $uploaded_file_path)) {
        $uploaded_file_path = null; // アップロード失敗時
    }
}

if ($recipient_id > 0 && (!empty($message) || $uploaded_file_path)) {
    // メッセージを挿入（ファイルパスも含む）
    $sql = "INSERT INTO messages (sender_id, recipient_id, message, file_path, created_at, is_read) 
            VALUES (?, ?, ?, ?, NOW(), 0)";
    $result = $db->query($sql, [$user_id, $recipient_id, $message, $uploaded_file_path]);

    if ($result) {
        echo "メッセージを送信しました。";
    } else {
        echo "メッセージの送信に失敗しました。";
    }
} else {
    echo "メッセージ、またはファイルを入力してください。";
}
?>