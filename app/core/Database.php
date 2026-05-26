<?php
// app/core/Database.php

class Database
{
    private $host = 'localhost';
    private $dbname = 'qlsv_db';
    private $username = 'root';
    private $password = '';
    private $conn;
    
    public function __construct()
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die('Lỗi kết nối database: ' . $e->getMessage());
        }
    }
    
    public function getConnection()
    {
        return $this->conn;
    }
    
    public function query($sql)
    {
        return $this->conn->prepare($sql);
    }
    
    public function execute($sql, $params = [])
    {
        $stmt = $this->query($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function fetchOne($sql, $params = [])
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>