<?php 
    // Database connection settings
    $host = "localhost";
    $dbname = "system_db";
    $username = "root";
    $password = "";

    define('APP_ROOT', __DIR__ . '/app_log.txt');

    echo APP_LOG;
    set_error_handler("logErrorMessage");
    set_exception_handler("logException");

    // Create a new PDO instance
    try{
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception
    } catch(PDOException $error){ // Handle connection error
        throw $error;
    }

    

    function logErrorMessage($errorType, $errorMessage, $errorFile, $errorLine) {
        //error log with timestamp
       $logMessage = "[" . date("Y-m-d H:i:s") . "]";
       $logMessage .= "Type: $errorType | Message: $errorMessage | ";
       $logMessage .= "File: $errorFile | Line: $errorLine" . PHP_EOL;
       
       error_log($logMessage, 3, APP_LOG); // Log to a file named error_log.txt in the current directory
    }

    function logException($exception){
        $logExceptionMessage = "[" . date("Y-m-d H:i:s") . "] ";
        $logExceptionMessage .= "Exception: " . $exception->getMessage();
        $logExceptionMessage .= " in " . $exception->getFile();
        $logExceptionMessage .= " on line " . $exception->getLine() . PHP_EOL;

        error_log($logExceptionMessage, 3, APP_LOG); // Log to a file named error_log.txt in the current directory
    }
    
