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
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $rows = $statement->rowCount(); // checking if any rows are affected
            
        }catch(PDOException $error){
            die("ERROR: " . $error->getMessage());
        }

        if($rows > 0){
            header('Location: dashboard.php?action=delete_success');
        }
        elseif($rows === 0){
            header('Location: dashboard.php?action=no_record');
        }
    }
?>