<?php
/**
 * 汎用MySQLデータベース接続クラス（ローカル/サーバー対応）
 * バージョン: 1.0.0.0a
 * 作成者: 渡邊　竜樹
 * 
 * このクラスはローカル環境とサーバー環境の両方で使用可能で、
 * 環境に応じて自動的に接続設定を切り替えることができます。
 */

class Database {
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset = 'utf8mb4';
    private $pdo;

    /**
     * コンストラクタで環境に応じて接続設定を切り替える
     */
    public function __construct() {
        // サーバー名によってローカルか本番環境かを判断
        if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1') {
            // ローカル環境の設定
            $this->host = 'localhost';
            $this->db = 'local_database';
            $this->user = 'root';
            $this->pass = '';
        } else {
            // サーバー環境の設定
            $this->host = 'server_host';
            $this->db = 'server_database';
            $this->user = 'server_user';
            $this->pass = 'server_password';
        }

        $this->connect();
    }

    /**
     * データベースに接続するメソッド
     */
    private function connect() {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * 汎用クエリ実行メソッド（複数行取得）
     * @param string $query SQLクエリ
     * @param array $params プレースホルダー用のパラメータ
     * @return array クエリ結果
     */
    public function fetchAll($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo 'クエリエラー: ' . $e->getMessage();
            return [];
        }
    }

    /**
     * 単一行を取得するメソッド
     * @param string $query SQLクエリ
     * @param array $params プレースホルダー用のパラメータ
     * @return array クエリ結果（単一行）
     */
    public function fetchRow($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo 'クエリエラー: ' . $e->getMessage();
            return [];
        }
    }

    /**
     * データの挿入、更新、削除に使うメソッド
     * @param string $query SQLクエリ
     * @param array $params プレースホルダー用のパラメータ
     * @return bool 成功したかどうか
     */
    public function execute($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            echo 'クエリエラー: ' . $e->getMessage();
            return false;
        }
    }
}

// 使用例
$db = new Database();

// データ取得テスト
$testData = $db->fetchAll("SELECT * FROM test_table");
if ($testData) {
    echo "データ取得成功: <br>";
    foreach ($testData as $row) {
        echo $row['column_name'] . "<br>";
    }
} else {
    echo "データがありません。";
}
?>