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
    <title>Login - Digital Products System</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="container" style="max-width: 450px;">
        <h1>Login</h1>

        <?php if (isset($_GET['registration']) && $_GET['registration'] === 'success'): ?>
            <div class="msg-success">
                Registration successful! You can now log in below.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="msg-error">
                <?php 
                    if ($_GET['error'] === 'invalidcredentials') echo "Invalid Username or Password!";
                    elseif ($_GET['error'] === 'emptyinput') echo "Please fill in all fields.";
                    else echo "An error occurred. Please try again.";
                ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <form action="core/handleForms.php" method="POST">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Username</label>
                    <input type="text" name="userName" required>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <input type="submit" name="loginUserBtn" value="Login" class="btn-submit">
            </form>
            <p style="margin-top: 15px; text-align: center; font-size: 0.9rem;">
                Don't have an account? <a href="register.php">Register here</a>
            </p>
        </div>
    </div>

</body>
</html>