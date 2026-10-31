<?php 
session_start();
if (isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Digital Products System</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="container" style="max-width: 500px;">
        <h1>User Registration</h1>

        <?php if (isset($_GET['error'])): ?>
            <div class="msg-error">
                <?php 
                    if ($_GET['error'] === 'usernametaken') echo "Username is already taken. Try another.";
                    elseif ($_GET['error'] === 'emptyinput') echo "Please fill in all fields.";
                    else echo "Registration failed. Please try again.";
                ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <form action="core/handleForms.php" method="POST">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Username</label>
                    <input type="text" name="userName" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="firstName" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="lastName" required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <input type="submit" name="registerUserBtn" value="Register Account" class="btn-submit">
            </form>
            <p style="margin-top: 15px; text-align: center; font-size: 0.9rem;">
                Already registered? <a href="login.php">Login here</a>
            </p>
        </div>
    </div>

</body>
</html>