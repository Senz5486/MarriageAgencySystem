<?php
// Created by 渡邊竜樹
// Login functionality with session management
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Simulate user lookup (replace with DB validation)
    $stored_password = password_hash("password123", PASSWORD_DEFAULT); // For testing

    if (password_verify($password, $stored_password)) {
        $_SESSION['user_id'] = $email; // Simulate user ID
        header("Location: mypage.php");
        exit();
    } else {
        echo "Invalid login credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method='post'>
        Email: <input type='email' name='email' required><br>
        Password: <input type='password' name='password' required><br>
        <input type='submit' value='Login'>
    </form>
    <p><a href='password_forget.php'>パスワードを忘れた方</a></p>
</body>
</html>
