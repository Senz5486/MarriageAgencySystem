<?php
// Created by 渡邊竜樹
// Password reset functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];

    // Simulate password reset (replace with actual DB update)
    echo "Password has been reset.";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>
<body>
    <h1>パスワードリセット</h1>
    <form method='post'>
        New Password: <input type='password' name='new_password' required><br>
        <input type='submit' value='Reset Password'>
    </form>
</body>
</html>
