<?php
    session_start();

    if(isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        header('Location: dashboard.php?user=csrf_error');
        exit;
    }

    if(!isset($_SESSION['user'])){
        header('Location: loginForm.php');
        exit;
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
            header('Location: dashboard.php?action=update_failed');
            die("ERROR: " . $error->getMessage());
        }

        if($rows > 0){
            header('Location: dashboard.php?action=delete_success');
            exit;
        }
        elseif($rows === 0){
            header('Location: dashboard.php?action=no_record');
            exit;
        }
    }
?>