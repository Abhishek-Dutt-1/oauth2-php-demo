<?php

class Database {

    public $pdo;

    private $conn = array(
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'oauth2demo',
        'username' => 'root',
        'password' => 'root'
    );

    public function __construct() {
        $dsn = $this->conn['driver'].':host='.$this->conn['host'].';dbname='.$this->conn['database'];
        try {
            $this->pdo = new PDO( $dsn, $this->conn['username'], $this->conn['password'] );
        } catch (PDOException $e) {
            exit( $e->getMessage() );
        }
    }

}   // end class

