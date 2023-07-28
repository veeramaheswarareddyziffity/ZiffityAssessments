<?php

class DBConnection {

    private static $host = 'localhost';
    private static $username = 'root';
    private static $password = 'Ziffity@123';
    private static $dbName = 'banking_details';
   

    

    public static function getConnection() {
        
        $conn = new mysqli(self::$host, self::$username, self::$password, self::$dbName);
        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        else
        {
            // echo "hello";


            // var_dump($conn);
            return $conn;
        }
        
    }
}

?>
