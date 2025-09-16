<?php 
    session_start();

    if(!isset($_SESSION['user'])){
        header('Location: loginForm.php');
        exit;
    }

    require_once 'db.php';

    try{
        $sql = 'SELECT * FROM users';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $error){
        die("ERROR" . $error->getMessage());
    }

    if(isset($_GET['action'])){
        $toastMessage = null;
        $toastType = null;
        switch($_GET['action']){
            case 'update_success':
                $toastMessage = "Update successful!";
                $toastType = "success";
                break;
            case 'update_failed':
                $toastMessage = "Update failed. Please try again.";
                $toastType = "error";
                break;
            case 'delete_success':
                $toastMessage = "Delete successful!";
                $toastType = "success";
                break;
            case 'no_record':
                $toastMessage = "No record found to delete.";
                $toastType = "warning";
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
    <title>Document</title>
</head>
<body>
    <div>
        <h2>USER MANAGEMENT</h2>
        <p>Manage all users in one place.Control access,Assign roles,and monitor activity across your platform.</p>
    </div>
    <button id="add-user" onclick="window.location.href='addUserForm.php'">+ Add User</button>
    
    <?php if($users): ?> <!-- if user array has values -->
        <table>
            <tr id="row-border">
                <th>ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>CREATED_AT</th>
                <th id="action-column" colspan="2">ACTIONS</th>
            </tr>
            <?php foreach($users as $user): ?> <!-- Iterate each user inside the array -->
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                    <td id="action-column_update">
                        <button id="update-user" onclick="window.location.href='updateForm.php?user_id=<?php echo $user['id'] ?>'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                        </button> <!-- Redirect to update.php-->
                    </td>
                    <td id="action-column_delete">
                        <button id="delete-user" onclick="if(confirm('Are you sure you want to delete this?')) //js if confirm dialog
                         {window.location.href='delete.php?user_id=<?php echo $user['id'] ?>';}"> <!-- Redirect to delete.php with user id using js-->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div id="display-validation">
        <p id="display-validation_message">hatdog</p>
    </div> 
    
    <script src="function.js"></script>
    <script>
        <?php if (isset($toastMessage) && $toastMessage): ?>
            document.addEventListener("DOMContentLoaded", () => {
                toasterDisplay("<?= $toastMessage ?>", "<?= $toastType ?>");
            });
        <?php endif; ?>
    </script>
</body>
</html>
