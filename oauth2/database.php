<?php

namespace AbhishekDutt\oauth2;

class Database {

    public $pdo;

    public function __construct($conn) {
        
		$dsn = $conn['driver'].':host='.$conn['host'].';dbname='.$conn['database'];
        
		try {
            $this->pdo = new \PDO( $dsn, $conn['username'], $conn['password'] );
        } catch (PDOException $e)
		{
            exit( $e->getMessage() );
        }

    }

}   // end class

