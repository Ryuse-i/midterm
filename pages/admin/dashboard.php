
<?php 
    session_start();    

    if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin"){
        header("Location: ../loginForm.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/style.css">
    <title>Dashboard</title>
</head>
<body>
    <button id="view-gallery" onclick="window.location.href='gallery.php'">Gallery</button>
    <button id="dashboard" onclick="window.location.href='viewUsers.php'">User table</button>
    <div id="user-profile">
        <div id="user-profile_info">
            <p class="text-info">NAME: <?php echo $_SESSION['user']['name'] ?></p>
            <p class="text-info">EMAIL: <?php echo $_SESSION['user']['email']?></p>
            <p class="text-info">ROLE: <?php echo $_SESSION['user']['role']?></p>
            <button id="update-profile" onclick="window.location.href='profileForm.php'">Update info</button>
        </div>
        <div id="user-profile_image">
            <?php if(isset($_SESSION['user']['profile_picture']) && !empty($_SESSION['user']['profile_picture'])): ?>
                <img class="image" src="../<?php echo $_SESSION['user']['profile_picture'] ?>" alt="Profile Picture">
            <?php else: ?>
                <img class="image" src="../../uploads/profile/default_profile.png" alt=""> 
            <?php endif ?>
            <br>
            <button id="upload-profile"
            onclick="window.location.href='uploadProfileForm.php'"
            >Change profile picture</button>
        </div>
    </div>
    <div id="account-actions">
        <button id="logout-account"
        onclick="if(confirm('Are you sure you want to logout?')){
            logout();
            window.location.href='../../process/logout.php';
        }"
        >Logout</button> <br>
        <form id="delete-account-form"action="../../process/deleteAccount.php" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="id" value="<?php echo $_SESSION['user']['id'] ?>">
            <button onclick="logout()" id="delete-account" type="submit">Delete Account</button>
        </form>
    </div>

    <script>
        function logout(){ //clears the storage after logout
            sessionStorage.clear();
        }
    </script>
</body>
</html>