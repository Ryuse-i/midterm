<?php
    session_start();
    require_once 'db.php';

    if(!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        header('Location: updateForm.php?user=csrf_error');
        exit;
    }

    if(!isset($_SESSION['user'])){
        header('Location: loginForm.php');
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header('Location: updateForm.php?user=invalid_email');
        }

        $cleanName =  filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
        $validEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

        try{    
            $sql = 'UPDATE users SET name = :name, email = :email WHERE id = :id';
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':name', $cleanName, PDO::PARAM_STR);
            $statement->bindValue(':email', $validEmail, PDO::PARAM_STR);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            $rows = $statement->rowCount();
        }catch(PDOException $error){
            header('Location: updateForm.php?action=update_failed');
            die("ERROR: " . $error->getMessage());
        }

        if($rows > 0){
            header('Location: updateForm.php?action=update_success');
            exit;
        }
        elseif($rows === 0){
            header('Location: updateForm.php?action=update_success');
            exit;
        }
    }
?>