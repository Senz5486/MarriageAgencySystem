<?php
/**
 * ユーザー検索フォーム
 * バージョン: 1.0.0.0a
 * 作成者: 渡邊 竜樹
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // ログインしていない場合はログインページにリダイレクト
    exit;
}
?>

<h1>ユーザー検索</h1>
<form method="GET" action="search_results.php">
    <label>名前:</label><br>
    <input type="text" name="username"><br>
    
    <label>年齢:</label><br>
    <input type="number" name="age_min" placeholder="最低年齢">
    <input type="number" name="age_max" placeholder="最高年齢"><br>
    
    <label>居住地:</label><br>
    <input type="text" name="location"><br>

    <label>趣味:</label><br>
    <input type="text" name="hobby"><br>
    
    <button type="submit">検索</button>
</form>