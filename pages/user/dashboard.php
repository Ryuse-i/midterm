<?php 
    session_start();    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/style.css">
    <title>Dashboard</title>
</head>
<body id="user-body">
    <div id="user-profile">
        <div id="user-profile_info">
            <p class="text-info"><?php echo $_SESSION['user']['name'] ?></p>
            <p class="text-info"><?php echo $_SESSION['user']['email']?></p>
        </div>
        <div id="user-profile_image">
            <?php if(isset($_SESSION['user']['profile_picture']) && !empty($_SESSION['user']['profile_picture'])): ?>
                <img class="image" src="<?php echo $_SESSION['user']['profile_picture'] ?>" alt="Profile Picture">
            <?php else: ?>
                <img class="image" src="../../uploads/default_profile.png" alt="">
            <?php endif ?>
        </div>
        
    </div>
</body>
</html>