<?php 
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

$designer = getDesignerById($pdo, $_GET['designerId']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Designer</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="container" style="max-width: 500px;">
        <h2>Are you sure you want to delete this designer?</h2>
        
        <div class="delete-card">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($designer['user_name']); ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($designer['first_name'] . ' ' . $designer['last_name']); ?></p>
            <p><strong>Specialization:</strong> <?php echo htmlspecialchars($designer['specialization']); ?></p>
        </div>

        <form action="core/handleForms.php?designerId=<?php echo $_GET['designerId']; ?>" method="POST" style="background:none; border:none; box-shadow:none; padding:0;">
            <input type="submit" name="deleteDesignerBtn" value="Confirm Delete" class="btn-submit btn-delete-confirm">
        </form>
        
        <div style="margin-top: 15px; text-align: center;">
            <a href="index.php" class="back-link">Cancel</a>
        </div>
    </div>

</body>
</html>