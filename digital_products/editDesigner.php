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
    <title>Edit Designer</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="container" style="max-width: 600px;">
        <a href="index.php" class="back-link">← Cancel</a>
        <h2>Edit Designer</h2>

        <div class="card">
            <form action="core/handleForms.php?designerId=<?php echo $_GET['designerId']; ?>" method="POST">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Username</label>
                    <input type="text" name="userName" value="<?php echo htmlspecialchars($designer['user_name']); ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="firstName" value="<?php echo htmlspecialchars($designer['first_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="lastName" value="<?php echo htmlspecialchars($designer['last_name']); ?>" required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Date of Birth</label>
                    <input type="date" name="dateOfBirth" value="<?php echo $designer['date_of_birth']; ?>">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Specialization</label>
                    <input type="text" name="specialization" value="<?php echo htmlspecialchars($designer['specialization']); ?>">
                </div>

                <input type="submit" name="editDesignerBtn" value="Save Changes" class="btn-submit">
            </form>
        </div>
    </div>

</body>
</html>