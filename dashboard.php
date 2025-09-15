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
    <?php if($users): ?> <!-- if user array has values -->
        <table>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th colspan="2">ACTIONS</th>
            </tr>
            <?php foreach($users as $user): ?> <!-- Iterate each user inside the array -->
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <button onclick="window.location.href='updateForm.php?user_id=<?php echo $user['id'] ?>'">Update</button> <!-- Redirect to update.php-->
                    </td>
                    <td>
                        <button onclick="if(confirm('Are you sure you want to delete this?')) //js if confirm dialog
                         {window.location.href='delete.php?user_id=<?php echo $user['id'] ?>';}"> <!-- Redirect to delete.php with user id using js-->
                         Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

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
