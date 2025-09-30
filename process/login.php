<?php 
    session_start();
    require_once "../db.php";


    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            header('Location: ../pages/loginForm.php?user=csrf_error');
            exit;
        }
    
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if(empty($email) || empty($password)){
            header('Location: ../pages/loginForm.php?user=empty_fields');
            exit;
        }
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header('Location: ../pages/loginForm.php?user=invalid_email');
            exit;
        }


        try{
            $sql = 'SELECT * FROM users WHERE email = :email';
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":email", $email, PDO::PARAM_STR);
            $statement->execute();

            $user = $statement->fetch(PDO::FETCH_ASSOC); 
        } catch(PDOException $error){
            throw $error;
        }

        if($user && password_verify($password, $user['password'])){
            session_regenerate_id(true);

            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['roles'],
                'login' => true,
                'register' => false
            ];

            header('Location: ../pages/' . $_SESSION['user']['role'] . '/dashboard.php');
            exit;
        }       
        else{
            header('Location: ../pages/loginForm.php?user=incorrect_credentials');
            exit;
        }
    }
?>