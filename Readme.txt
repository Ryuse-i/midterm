Project Title:
Basic PHP CRUD System with MySQL (Users Management)

-----------------------------------------
1. REQUIREMENTS
-----------------------------------------
- XAMPP installed on your computer
- Web browser (Chrome, Firefox, etc.)
- PHPMyAdmin (included with XAMPP)

-----------------------------------------
2. HOW TO SET UP THE SYSTEM
-----------------------------------------
Step 1: Run XAMPP
- Open the XAMPP Control Panel.
- Start the "Apache" and "MySQL" modules.

Step 2: Create the Database
- Go to: http://localhost/phpmyadmin
- Create a new database named: system_db

Step 3: Create the "users" Table
- Open the SQL tab in phpMyAdmin inside the "system_db" database.
- Copy and run the following SQL script:

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  roles ENUM("admin", "user"),
  profile_picture VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-----------------------------------------
3. SYSTEM FILES
-----------------------------------------
The project folder contains the following PHP scripts:


1. register.php and registerForm.php
   - Displays a registration form.
   - Allows adding new users to the database.
   - Passwords are securely hashed before saving.

2. login.php and loginForm.php
    - Displays a login form.
    - Allows loging in to the system

3. viewUsers.php
   - Displays all users stored in the database in a simple table format.

4. updateUsers.php and updateForm.php
   - Provides a form to update an existing user's name and email by ID.

5. delete.php and deleteForm.php
   - Provides a form to delete a user by ID.

6. addUser.php and addUserForm.php
    - Provides a form to add another user in the system.

7. uploadFileForm.php and uploadFile.php
    - for uploading images in the gallery.

8. profileForm.php and updateProfile.php 
    - to Update yout personal account information

9. uploadProfileForm.php and uploadProfile.php 
    - Provides a form to update your profile picture

10. style.css
    - Contains the page styling.

11. function.js
    - Contains a few DOM manipulations


-----------------------------------------
4. BASIC FUNCTIONALITY
-----------------------------------------
- Add User (Create): Fill out the add user form to add new users.
- View Users (Read): Open dashboard.php to see a list of all registered users.
- Update User (Update): Edit a user's name and email using update.php. You can also update your account information
- Delete User (Delete): Remove a user by clicking the button to pass their ID in delete.php.
- Upload images (File): Upload an image that you can see in the gallery, and you can also change your profile picture
- Logout and Delete your personal account
-----------------------------------------
5. TESTING THE SYSTEM
-----------------------------------------
1. Open a web browser and go to: http://localhost/[your_project_folder]/pages/registerForm.php to register an admin or user account
2. Use loginForm.php if you are already registered.
3. Use addUserForm.php to add new users.
4. Open viewUsers.php to check if the users are displayed correctly.
5. Use updateForm.php to change a user's details.
6. Use deleteForm.php to remove a user from the database.
7. Check dashboard.php to confirm changes in the "users" table.
9. Go to dashboard.php to check your profile.
10. Under profile would be gallery which you can upload images, profile picture which you can change, and your information that can be updated.
11. A logout and delete account functionality 
END
