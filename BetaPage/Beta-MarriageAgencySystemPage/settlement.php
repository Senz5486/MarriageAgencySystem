<?php
// Created by 渡邊竜樹
// Payment settlement processing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plan = $_POST['plan'];

    // Simulate payment processing (replace with actual payment gateway integration)
    echo "Processing payment for plan: $plan";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>決済処理</title>
</head>
<body>
    <h1>決済処理</h1>
    <form method='post'>
        Plan: 
        <select name='plan' required>
            <option value='bronze'>Bronze</option>
            <option value='platinum'>Platinum</option>
            <option value='diamond'>Diamond</option>
        </select><br>
        Credit Card Number: <input type='text' name='card_number' required><br>
        Expiry Date: <input type='text' name='expiry' required><br>
        CVV: <input type='text' name='cvv' required><br>
        <input type='submit' value='Pay'>
    </form>
</body>
</html>
