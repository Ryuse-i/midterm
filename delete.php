<?php
    session_start();

     if(!isset($_SESSION['user'])){
        header('Location: loginForm.php');
    }

    require_once 'db.php';

    if(isset($_GET['user_id'])){
        $id = $_GET['user_id'];

        try{
            $sql = 'DELETE FROM users WHERE id = :id';
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':id', $id, PDO::PARAM_STR);
            $statement->execute();

            header('Location: dashboard.php?action=delete_success');
        }catch(PDOException $error){
            die("ERROR: " . $error->getMessage());
        }
    }
?>