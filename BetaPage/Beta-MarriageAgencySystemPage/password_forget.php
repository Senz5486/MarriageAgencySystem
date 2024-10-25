<?php
// Created by 渡邊竜樹
// Password forget functionality with simple email validation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Simulate email send (replace with actual email sending logic)
    echo "Password reset email sent to: $email";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>
<body>
    <h1>パスワードを忘れた方</h1>
    <form method='post'>
        Email: <input type='email' name='email' required><br>
        <input type='submit' value='Send Reset Link'>
    </form>
</body>
</html>
