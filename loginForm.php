<?php
$toastMessage = null;
$toastType = null;
if (isset($_GET['user'])) {
    switch ($_GET['user']) {
        case 'empty_fields':
            $toastMessage = "Please fill out all fields";
            $toastType = "error";
            break;
        case 'invalid_email':
            $toastMessage = "Invalid email address";
            $toastType = "error";
            break;
        case 'incorrect_credentials':
            $toastMessage = "Incorrect username, email, or password";
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
    <title>LOGIN FORM</title>
</head>
<body>
    <script src="toaster.js"></script>
    <script>
        <?php if (isset($toastMessage) && $toastMessage): ?>
            document.addEventListener("DOMContentLoaded", () => {
                toasterDisplay("<?= $toastMessage ?>", "<?= $toastType ?>");
            });
        <?php endif; ?>
    </script>
    <div id="Form-head">
        <h1>Login your account</h1>
        <p>Enter your details below to login your account</p>
    </div>
    <!-- Login-Form with client-side input validation -->
    <form action="login.php" method="POST">
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
        <button type="submit" id="submit-form">Log In</button> 
    </form>

    <div id="display-validation">
        <p id="display-validation_message">hatdog</p>
    </div>

</body>
</html>