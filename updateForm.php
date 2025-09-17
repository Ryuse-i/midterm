<?php
    session_start();
    require_once 'db.php';

    if(!isset($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a CSRF token if not already set
    }

    if(isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        header('Location: dashboard.php?user=csrf_error');
        exit;
    }

    if(!isset($_SESSION['user'])){
        header('Location: loginForm.php');
        exit;
    }

    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['user_id'];

        try{
            $sql = 'SELECT * FROM users WHERE id = :id';
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            $user = $statement->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $error){
            die("ERROR: " . $error->getMessage());
        }
    }

    if(isset($_GET['action'])){
        $toastMessage = null;
        $toastType = null;
        switch($_GET['action']){
            case 'update_success':
                $toastMessage = "Update successful!";
                $toastType = "success";
                break;
            case 'update_failed':
                $toastMessage = "Update failed. Please try again.";
                $toastType = "error";
                break;
            case 'csrf_error':
                $toastMessage = "There was someting wrong with your request. Please try again.";
                $toastType = "error";
                break;
        }
        
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form id="user-form" action="update.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> <!-- Hidden input to send csrf token -->
        <input type="text" name="id" value="<?php echo htmlspecialchars($user['id']); ?>" hidden>
        <label for="name">Name</label> <br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br><br>
        <label for="email">Email</label> <br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>