<?php
    session_start();

    if(!isset($_SESSION['user'])){
        header('Location: loginForm.php');
        exit;
    }

    require_once 'db.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        

        try{
            $sql = 'INSERT INTO users (name, email) VALUES (:name, :email)';
            $statement = $pdo->prepare($sql);
            $statement->execute(['name' => $name, 'email' => $email]);

            header('Location: dashboard.php?action=add_success');
            exit;
        }catch(PDOException $error){
            die("ERROR" . $error->getMessage());
        }
    }