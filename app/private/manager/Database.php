<?php
require_once __PRIVATE . 'abstract/Singleton.php';

class DatabaseException extends Exception {}

class Database extends mysqli {
    private static string $DB_HOST;
    private static string $DB_USER;
    private static string $DB_PASS;
    private static string $DB_NAME;

    public function __construct() {
        if (!isset(self::$DB_NAME)) {
            self::$DB_HOST = $_ENV['DB_HOST'] ?? throw new DatabaseException('Missing environment variable DB_HOST');
            self::$DB_USER = $_ENV['DB_USER'] ?? throw new DatabaseException('Missing environment variable DB_USER');
            self::$DB_PASS = $_ENV['DB_PASS'] ?? throw new DatabaseException('Missing environment variable DB_PASS');
            self::$DB_NAME = $_ENV['DB_NAME'] ?? throw new DatabaseException('Missing environment variable DB_NAME');
        }

        parent::__construct(self::$DB_HOST, self::$DB_USER, self::$DB_PASS, self::$DB_NAME);

        if ($this->connect_error) throw new DatabaseException("Connection failed: $this->connect_error", $this->connect_errno);
    }
};

trait TDatabasePrepare {
    private function prepareQuery(string $types, string $sql, array $params): mysqli_stmt {
        $stmt = $this->getConnection()->prepare($sql);
        if (!$stmt) throw new DatabaseException("Prepare failed: $this->error", $this->errno);
        if (!$stmt->bind_param($types, ...$params)) throw new DatabaseException("Binding parameters failed: $stmt->error", $stmt->errno);
        return $stmt;
    }

    private function execQuery(string $types, string $sql, array $params): bool {
        return $this->prepareQuery($types, $sql, $params)->execute();
    }
}
