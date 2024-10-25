<?php
// Created by 渡邊竜樹
// User's my page after login
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Please <a href='login.php'>login</a> to view this page.";
} else {
    echo "<h1>My Page</h1>";
    echo "Welcome to your personal MyPage!";
}
?>
