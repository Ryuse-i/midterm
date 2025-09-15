<?php
    session_start();

    if(!isset($_SESSION['user'])){
        header('Location: loginForm.php');
        exit;
    }

    require_once 'db.php';

    if(isset($_GET['user_id'])){
        $id = $_GET['user_id'];

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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="update.php" method="POST">
        <input type="text" name="id" value="<?php echo htmlspecialchars($user['id']); ?>" hidden>
        <label for="name">Name</label> <br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br><br>
        <label for="email">Email</label> <br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>