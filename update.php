<?php
    session_start();

    if(!isset($_SESSION['user'])){
        header('Location: loginForm.php');
        exit;
    }

    require_once 'db.php';

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
            header('Location: dashboard.php?action=update_failed');
            die("ERROR: " . $error->getMessage());
        }

        if($rows > 0){
            header('Location: dashboard.php?action=update_success');
            exit;
        }
        elseif($rows === 0){
            header('Location: dashboard.php?action=update_success');
            exit;
        }
    }
?>