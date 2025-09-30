<?php
    session_start();
    require_once '../../db.php';

    // Generate CSRF token if not already set
    if(!isset($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a CSRF token if not already set
    }

    // Check if user is logged in
    if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin"){
        header('Location: ../loginForm.php');
        exit;
    }

    // Fetch user details if user_id is provided
   if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // CSRF token validation
        if(!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            header('Location: dashboard.php?user=csrf_error');
            exit;
        }
        $id = $_POST['user_id'];

        // Fetch user details from the database
        try{
            $sql = 'SELECT * FROM users WHERE id = :id';
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            $user = $statement->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $error){
            header('Location: dashboard.php?action=update_failed');
            throw $error;
            throw $error;
        }
    }
    else{
        header('Location: dashboard.php?action=no_record');
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/style.css">
    <title>Document</title>
</head>
<body>
    <div>
        <button id="back-dashboard" onclick="window.location.href='viewUsers.php'">Back to User table</button>
    </div>
    <div id="Form-head">
        <h1>Delete User</h1>
        <p>Are you sure you want to delete this user?</p>
    </div>

    <!-- Ureadonlyser form with user details readonly-->
    <form id="user-form" action="../../process/delete.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> <!-- Hidden input to send csrf token -->
        <label for="id">ID</label> <br>
        <input type="text" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>" readonly> <br><br>
        <label for="name">Name</label> <br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" readonly><br><br>
        <label for="email">Email</label> <br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly><br><br>
        <button onclick="return confirm('Are you sure you want to delete this user?')" id="submit-form" type="submit">Delete</button>
    </form>
</body>
</html>