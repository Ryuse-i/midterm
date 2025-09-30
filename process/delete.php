<?php
    session_start();
    require_once '../db.php';


    //check if user is logged in
    if(!isset($_SESSION['user'])){
        header('Location: ../pages/admin/loginForm.php');
        exit;
    }


    // Process the form submission
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // CSRF token validation
        if(!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            header('Location: ../pages/admin/dashboard.php?user=csrf_error');
            exit;
        }
        $id = $_POST['user_id'];

        // Delete user from the database
        try{
            $sql = 'DELETE FROM users WHERE id = :id';
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $rows = $statement->rowCount(); // checking if any rows are affected
            
        }catch(PDOException $error){
            header('Location: ../pages/admin/dashboard.php?action=update_failed');
            throw $error;
        }
    

        // Redirect based on the result of the delete operation
        if($rows > 0){ // If rows were affected (deleted)
            header('Location: ../pages/admin/dashboard.php?action=delete_success');
            exit;
        }
        elseif($rows === 0){ // If no rows were affected (no record found)
            header('Location: ../pages/admin/dashboard.php?action=no_record');
            exit;
        }else{ // Other errors
            header('Location: ../pages/admin/dashboard.php?action=update_failed');
            exit;
        }
    }else{
        header('Location: ../pages/admin/dashboard.php?action=no_record');
        exit;
    }
?>