<?php 
    // Database connection settings
    $host = "localhost";
    $dbname = "system_db";
    $username = "root";
    $password = "";

    // Create a new PDO instance
    try{
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception
    } catch(PDOException $error){ // Handle connection error
        die("ERROR: " . $error->getMessage());
    }
?>