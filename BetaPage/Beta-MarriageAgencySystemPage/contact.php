<?php
// Created by 渡邊竜樹
// Contact page functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];

    // Simulate sending message (replace with actual email or DB save)
    echo "Your message has been sent: $message";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
</head>
<body>
    <h1>お問い合わせ</h1>
    <form method='post'>
        Message: <textarea name='message' required></textarea><br>
        <input type='submit' value='Send'>
    </form>
</body>
</html>
