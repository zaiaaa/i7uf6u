<?php
    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $dbname = "mydb";
    define("SERVERNAME", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "");
    define("DBNAME", "mydb");

    function conecta() {
        $conn = new PDO("mysql:host=" . SERVERNAME .
		";dbname=" . DBNAME .";charset=utf8mb4",
		USERNAME, PASSWORD);
        // set the PDO error mode to exception
        //aqui a gnt seta os erros e suas exceções
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    // try {
    //     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    //     // set the PDO error mode to exception
    //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     echo "Connected successfully";
    // } catch(PDOException $e) {
    //     echo "Connection failed: " . $e->getMessage();
    // }
?> 