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
        <button id="back-dashboard" onclick="window.location.href='dashboard.php'">Back to profile</button>
    </div>


    <div id="Form-head">
        <h1>Update Profile</h1>
       <p>Enter details below to update your information</p>
    </div>

    <!-- User form with user details -->
    <form id="user-form" action="../../process/updateProfile.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> <!-- Hidden input to send csrf token -->
        <input type="text" name="id" value="<?php echo htmlspecialchars($_SESSION['user']['id']); ?>" hidden>
        <label for="name">Name</label> <br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($_SESSION['user']['name']); ?>" required><br><br>
        <label for="email">Email</label> <br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user']['email']); ?>" required><br><br>
        <button onclick="return confirm('Are you sure you want to update your info?')" id="submit-form" type="submit">Submit</button>
    </form>

    <!-- Toast message -->
    <div id="display-validation">
        <p id="display-validation_message">hatdog</p>
    </div>
    
    <script src="../resources/js/function.js"></script>
    <script>
        <?php if (isset($toastMessage) && $toastMessage): ?> // Check if there's a message to display
            document.addEventListener("DOMContentLoaded", () => { // Wait for the DOM to load
                toasterDisplay("<?= $toastMessage ?>", "<?= $toastType ?>"); // Call the function to display the toast
            });
        <?php endif; ?>
    </script>
</body>
</html>