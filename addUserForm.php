<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
</head>
<body>
    <h1>Add User</h1>
    <form action="addUser.php" method="POST">
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
        <button type="submit" id="submit-form">Add User</button> 
    </form>
</body>
</html>