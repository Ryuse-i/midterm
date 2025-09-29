<?php 
    session_start();    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/style.css">
    <title>Dashboard</title>
</head>
<body>
    <div id="user-profile">
        <div id="user-profile_image">
            <img src="<?php echo $_SESSION['user']['profile_picture'] ?>" alt="Profile Picture">
        </div>
        <div id="user-profile_info">
            <h2><?php echo $_SESSION['user']['name'] ?></h2>
            <p><?php echo $_SESSION['user']['email']?></p>
        </div>
        <div id="logout-delete">
            <button>logout</button>
            <button>Delete account</button>
        </div>
    </div>
</body>
</html>