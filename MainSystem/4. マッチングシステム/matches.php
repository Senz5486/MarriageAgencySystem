<?php
/**
 * マッチングしたユーザーの一覧表示（スコアベース）
 * バージョン: 1.0.0.0a
 * 作成者: 渡邊 竜樹
 */

session_start();
require 'DBUtility.php'; // DBUtilityを使う
$db = new DBUtility();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// ログイン中のユーザーのプロフィールを取得
$sql = "SELECT age, location, hobby FROM users WHERE id = ?";
$currentUser = $db->queryOne($sql, [$user_id]);

// マッチングしたユーザーを取得（相互「いいね！」のユーザーのみ）
$sql = "SELECT u.id, u.username, u.age, u.location, u.hobby 
        FROM users u
        INNER JOIN likes l1 ON l1.liked_user_id = u.id
        INNER JOIN likes l2 ON l2.user_id = u.id AND l2.liked_user_id = l1.user_id
        WHERE l1.user_id = ?";
$matchedUsers = $db->query($sql, [$user_id]);

$matches = [];

// マッチングスコアの計算
foreach ($matchedUsers as $otherUser) {
    $score = 0;

    // 年齢差を考慮したスコア計算
    $ageDiff = abs($currentUser['age'] - $otherUser['age']);
    if ($ageDiff <= 5) {
        $score += 3; // 年齢差が5歳以内ならスコア+3
    } elseif ($ageDiff <= 10) {
        $score += 2; // 10歳以内ならスコア+2
    }

    // 居住地が同じならスコア+5
    if ($currentUser['location'] === $otherUser['location']) {
        $score += 5;
    }

    // 趣味が一致していたらスコア+4
    if ($currentUser['hobby'] === $otherUser['hobby']) {
        $score += 4;
    }

    // スコアが6以上のユーザーだけをマッチング候補にする
    if ($score >= 6) {
        $matches[] = [
            'user_id' => $otherUser['id'],
            'username' => $otherUser['username'],
            'score' => $score
        ];
    }
}

// スコア順にソート
usort($matches, function($a, $b) {
    return $b['score'] - $a['score'];
});
?>

<h1>マッチングしたユーザー</h1>

<?php if ($matches): ?>
    <ul>
    <?php foreach ($matches as $match): ?>
        <li>
            名前: <?php echo htmlspecialchars($match['username']); ?><br>
            スコア: <?php echo htmlspecialchars($match['score']); ?><br>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>マッチングしたユーザーはいません。</p>
<?php endif; ?>
