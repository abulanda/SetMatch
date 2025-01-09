<?php

class Database {
    private $host = 'db';
    private $dbName = 'db';
    private $username = 'docker';
    private $password = 'docker';

    public function connect() {
        try {
            $dsn = "pgsql:host={$this->host};dbname={$this->dbName}";
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
    }
}
