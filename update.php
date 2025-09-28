<?php
    session_start();
    require_once 'db.php';
    

    // Check if user is logged in
    if(!isset($_SESSION['user'])){
        header('Location: loginForm.php');
        exit;
    }

    // Process the form submission
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // CSRF token validation
        if(!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            header('Location: dashboard.php?user=csrf_error');
            exit;
        }

        $id = $_POST['id'];
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);

        // Server-side input validation for email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header('Location: dashboard.php?user=invalid_email');
        }

        // Sanitize inputs
        $cleanName =  filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
        $validEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

        //
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
            throw $error;
        }

        throw $error;

        // Redirect based on the result of the update operation
        if($rows > 0){ // If rows were affected (updated)
            header('Location: dashboard.php?action=update_success');
            exit;
        }
        elseif($rows === 0){ // If no rows were affected (no changes made)
            header('Location: dashboard.php?action=no_changes');
            exit;
        }
    }
?>