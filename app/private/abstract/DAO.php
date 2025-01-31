<?php
trait TDao {
    use TSingleton;
    use TDatabasePrepare;
    private ?Database $conn = null;

    private function __construct(Database $conn = new Database) { $this->conn = $conn; }

    public function getConnection(): Database {
        $this->conn = $this->conn ?: new Database;
        return $this->conn;
    }
}
