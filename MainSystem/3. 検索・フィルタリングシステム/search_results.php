<?php
/**
 * 検索結果の表示
 * バージョン: 1.0.0.0a
 * 作成者: 渡邊 竜樹
 */

session_start();
require 'DBUtility.php'; // DBUtilityを使う
$db = new DBUtility();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // ログインしていない場合はログインページにリダイレクト
    exit;
}

// クエリパラメータを取得
$username = isset($_GET['username']) ? trim($_GET['username']) : '';
$age_min = isset($_GET['age_min']) ? (int)$_GET['age_min'] : 0;
$age_max = isset($_GET['age_max']) ? (int)$_GET['age_max'] : 100;
$location = isset($_GET['location']) ? trim($_GET['location']) : '';
$hobby = isset($_GET['hobby']) ? trim($_GET['hobby']) : '';

// SQL文を動的に生成
$sql = "SELECT * FROM users WHERE 1=1";
$params = [];

if ($username !== '') {
    $sql .= " AND username LIKE ?";
    $params[] = '%' . $username . '%';
}

if ($age_min > 0) {
    $sql .= " AND age >= ?";
    $params[] = $age_min;
}

if ($age_max < 100) {
    $sql .= " AND age <= ?";
    $params[] = $age_max;
}

if ($location !== '') {
    $sql .= " AND location LIKE ?";
    $params[] = '%' . $location . '%';
}

if ($hobby !== '') {
    $sql .= " AND hobby LIKE ?";
    $params[] = '%' . $hobby . '%';
}

// 検索クエリ実行
$users = $db->query($sql, $params);

?>

<h1>検索結果</h1>

<?php if ($users): ?>
    <ul>
    <?php foreach ($users as $user): ?>
        <li>
            名前: <?php echo htmlspecialchars($user['username']); ?><br>
            年齢: <?php echo htmlspecialchars($user['age']); ?><br>
            居住地: <?php echo htmlspecialchars($user['location']); ?><br>
            趣味: <?php echo htmlspecialchars($user['hobby']); ?><br>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>該当するユーザーが見つかりませんでした。</p>
<?php endif; ?>