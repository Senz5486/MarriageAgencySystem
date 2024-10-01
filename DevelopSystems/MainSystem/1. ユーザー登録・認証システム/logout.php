<?php
/**
 * ログアウト処理
 * バージョン: 1.0.0.0a
 * 作成者: 渡邊 竜樹
 */

session_start();
session_unset();
session_destroy();
header('Location: login.php'); // ログインページにリダイレクト
exit;
?>