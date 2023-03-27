<?php 

class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $database = 'ultimate_wfo';
    private $pdo;

    public function __construct() {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->database";
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            );
            $this->pdo = new PDO($dsn, $this->user, $this->password, $options);
        } catch(PDOException $e) {
            throw new Exception("Failed to connect to database: " . $e->getMessage());
        }
    }

    public function query($query, $params = array()) {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            throw new Exception("Error executing query: " . $e->getMessage());
        }
    }

    // public function quote($value) {
    //     return $this->pdo->quote($value);
    // }
}


?>