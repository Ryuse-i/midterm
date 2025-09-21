<?php
    session_start();
    require_once "db.php";

    // CSRF token validation
    if(!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        header('Location: registerForm.php?user=csrf_error');
        exit;
    }

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Server-side input validation 

        //Check for empty fields
        if(empty($name) || empty($email) || empty($password)){
            header('Location: loginForm.php?user=empty_fields');
            exit;
        }

        //Password validations
        // Check for minimum length
        if(strlen($password) < 8){
            header('Location: registerForm.php?user=pass_short');
            exit;
        }

        // Check for at least one uppercase letter
        if(!preg_match('/[A-Z]/', $password)){
            header('Location: registerForm.php?user=no_uppercase');
            exit;
        }

        // Check for at least one lowercase letter
        if(!preg_match('/[a-z]/', $password)){
            header('Location: registerForm.php?user=no_lowercase');
            exit;
        }

        // Check for at least one digit
        if(!preg_match('/\d/', $password)){
            header('Location: registerForm.php?user=no_digits');
            exit;
        }

        // Check for at least one special character
        if(!preg_match('/\W/', $password)){
            header('Location: registerForm.php?user=no_special_chars');
            exit;
        }

        // Validate email format
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header('Location: registerForm.php?user=invalid_email');
            exit;
        }

        // Sanitize inputs
        $cleanName = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
        $validEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if user already exists
        try{
            $sql = 'SELECT * FROM users WHERE email = :email';
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":email", $validEmail, PDO::PARAM_STR);
            $statement->execute();

            $user = $statement->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $error){
            die("ERROR: " . $error->getMessage());
        }

        // If user does not exist, insert new user
        if(!$user){
            try{
                $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
                $statement = $pdo->prepare($sql);
                $statement->bindValue(":name", $cleanName, PDO::PARAM_STR);
                $statement->bindValue(":email", $validEmail, PDO::PARAM_STR);
                $statement->bindValue(":password", $hashedPassword, PDO::PARAM_STR);
                $statement->execute();

                // Regenerate session ID to prevent session fixation attacks
                session_regenerate_id(true);

                $_SESSION['user'] = [
                    'id' => $cleanName,
                    'name' => $validEmail,
                    'email' => $hashedPassword
                ];

                header('Location: dashboard.php');
                exit;
            }catch(PDOException $error){
                die("ERROR: " . $error->getMessage());
            }
        }
        else{
            header('Location: registerForm.php?user=already_exist');
            exit;
        }
    }
