<?php 
    session_start();
    require_once "db.php";

    if(!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        header('Location: loginForm.php?user=csrf_error');
        exit;
    }

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if(empty($name) || empty($email) || empty($password)){
            header('Location: loginForm.php?user=empty_fields');
            exit;
        }
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header('Location: loginForm.php?user=invalid_email');
            exit;
        }


        try{
            $sql = 'SELECT * FROM users WHERE name = :name AND email = :email';
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":name", $name, PDO::PARAM_STR);
            $statement->bindValue(":email", $email, PDO::PARAM_STR);
            $statement->execute();

            $user = $statement->fetch(PDO::FETCH_ASSOC); 
        } catch(PDOException $error){

            die("ERROR: " . $error->getMessage());
        }

        if($user && password_verify($password, $user['password'])){
            session_regenerate_id(true);

            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ];

            header('Location: dashboard.php');
            exit;
        }
        else{
            header('Location: loginForm.php?user=incorrect_credentials');
            exit;
        }
    }
?>