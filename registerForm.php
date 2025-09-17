<?php
session_start();

if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a CSRF token if not already set
}

$toastMessage = null;
$toastType = null;
if (isset($_GET['user'])) {
    switch ($_GET['user']) {
        case 'empty_fields':
            $toastMessage = "Please fill out all fields";
            $toastType = "error";
            break;
        case 'pass_short':
            $toastMessage = "Password must be at least 8 characters long";
            $toastType = "error";
            break;
        case 'no_uppercase':
            $toastMessage = "Password must contain at least one uppercase letter";
            $toastType = "error";
            break;
        case 'no_lowercase':
            $toastMessage = "Password must contain at least one lowercase letter";
            $toastType = "error";
            break;
        case 'no_digits':
            $toastMessage = "Password must contain at least one digit";
            $toastType = "error";
            break;
        case 'no_special_chars':
            $toastMessage = "Password must contain at least one special character";
            $toastType = "error";
            break;
        case 'invalid_email':
            $toastMessage = "Invalid email address";
            $toastType = "error";
            break;
        case 'already_exist':
            $toastMessage = "User with this email already exists";
            $toastType = "error";
            break;
        case 'csrf_error':
            $toastMessage = "There was a problem with your request. Please try again.";
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
    <link rel="stylesheet" href="style.css">
    <title>REGISTER FORM</title>
</head>
<body>
    <div id="Form-head">
        <h1>Register your account</h1>
        <p>Enter your details below to Register your account</p>
    </div>
    
    <!-- Register-Form with client-side input validation -->
    <form id="user-form" action="register.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> <!-- Hidden input to send csrf token -->
        <label for="name">Name</label> <br>
        <input type="text" name="name" placeholder="Full Name" required><br><br>
        <label for="email">Email</label> <br>
        <input type="email" name="email" placeholder="email@example.com" required><br><br>
        <label for="password">Password</label> <br>
        <input type="password" name="password" placeholder="Password" 
        required
        minlength="8" 
        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" 
        title="Password must be at least 8 characters and include uppercase, lowercase, number, and special character"
        ><br><br>
        <button type="submit" id="submit-form">Register</button> 
    </form>

    <!-- Toast Notification -->
    <div id="display-validation">
        <p id="display-validation_message"></p>
    </div>

    <script src="function.js"></script>
    <script>
        <?php if (isset($toastMessage) && $toastMessage): ?> // Check if there's a message to display
            document.addEventListener("DOMContentLoaded", () => {
                toasterDisplay("<?= $toastMessage ?>", "<?= $toastType ?>"); // Call the function to display the toast
            });
        <?php endif; ?>
    </script>

</body>
</html>

