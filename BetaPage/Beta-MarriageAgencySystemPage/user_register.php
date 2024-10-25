<?php
// Created by 渡邊竜樹
// User registration functionality with simple validation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Simulate saving user to the database (replace with DB insert)
    echo "User $nickname registered with email: $email";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
</head>
<body>
    <h1>User Registration</h1>
    <form method='post'>
        Nickname: <input type='text' name='nickname' required><br>
        Email: <input type='email' name='email' required><br>
        Password: <input type='password' name='password' required><br>
        <input type='submit' value='Register'>
    </form>
</body>
</html>
