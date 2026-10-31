<?php
session_start();

require_once 'dbConfig.php';
require_once 'models.php';

// =========================================
// USER AUTHENTICATION HANDLERS
// =========================================

// User Registration
if (isset($_POST['registerUserBtn'])) {
    $userName  = trim($_POST['userName']);
    $firstName = trim($_POST['firstName']);
    $lastName  = trim($_POST['lastName']);
    $password  = $_POST['password'];

    if (!empty($userName) && !empty($firstName) && !empty($lastName) && !empty($password)) {
        $registerStatus = registerUser($pdo, $userName, $firstName, $lastName, $password);
        
        if ($registerStatus === true) {
            header("Location: ../login.php?registration=success");
            exit();
        } else if ($registerStatus === 'taken') {
            header("Location: ../register.php?error=usernametaken");
            exit();
        } else {
            header("Location: ../register.php?error=stmtfailed");
            exit();
        }
    } else {
        header("Location: ../register.php?error=emptyinput");
        exit();
    }
}

// User Login
if (isset($_POST['loginUserBtn'])) {
    $userName = trim($_POST['userName']);
    $password = $_POST['password'];

    if (!empty($userName) && !empty($password)) {
        if (loginUser($pdo, $userName, $password)) {
            $_SESSION['user_name'] = $userName;
            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../login.php?error=invalidcredentials");
            exit();
        }
    } else {
        header("Location: ../login.php?error=emptyinput");
        exit();
    }
}

// User Logout
if (isset($_GET['logoutUser'])) {
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}

// =========================================
// DESIGNER (PARENT) HANDLERS
// =========================================

if (isset($_POST['insertDesignerBtn'])) {
    $userName       = trim($_POST['userName']);
    $firstName      = trim($_POST['firstName']);
    $lastName       = trim($_POST['lastName']);
    $dateOfBirth    = $_POST['dateOfBirth'];
    $specialization = trim($_POST['specialization']);
    $addedBy        = $_SESSION['user_name'];

    if (!empty($userName) && !empty($firstName) && !empty($lastName)) {
        if (insertDesigner($pdo, $userName, $firstName, $lastName, $dateOfBirth, $specialization, $addedBy)) {
            header("Location: ../index.php");
            exit();
        }
    }
}

if (isset($_POST['editDesignerBtn'])) {
    $designerId     = $_GET['designerId'];
    $userName       = trim($_POST['userName']);
    $firstName      = trim($_POST['firstName']);
    $lastName       = trim($_POST['lastName']);
    $dateOfBirth    = $_POST['dateOfBirth'];
    $specialization = trim($_POST['specialization']);
    $lastUpdatedBy  = $_SESSION['user_name'];

    if (updateDesigner($pdo, $designerId, $userName, $firstName, $lastName, $dateOfBirth, $specialization, $lastUpdatedBy)) {
        header("Location: ../index.php");
        exit();
    }
}

if (isset($_POST['deleteDesignerBtn'])) {
    $designerId = $_GET['designerId'];
    if (deleteDesigner($pdo, $designerId)) {
        header("Location: ../index.php");
        exit();
    }
}

// =========================================
// PRODUCT (CHILD) HANDLERS
// =========================================

if (isset($_POST['insertProductBtn'])) {
    $designerId  = $_GET['designerId'];
    $productName = trim($_POST['productName']);
    $productType = trim($_POST['productType']);
    $price       = $_POST['price'];
    $salePrice   = !empty($_POST['salePrice']) ? $_POST['salePrice'] : NULL;
    $addedBy     = $_SESSION['user_name'];

    if (!empty($productName) && !empty($productType) && !empty($price)) {
        if (insertProduct($pdo, $designerId, $productName, $productType, $price, $salePrice, $addedBy)) {
            header("Location: ../viewProducts.php?designerId=" . $designerId);
            exit();
        }
    }
}

if (isset($_POST['editProductBtn'])) {
    $digitalProductId = $_GET['digitalProductId'];
    $designerId       = $_GET['designerId'];
    $productName      = trim($_POST['productName']);
    $productType      = trim($_POST['productType']);
    $price            = $_POST['price'];
    $salePrice        = !empty($_POST['salePrice']) ? $_POST['salePrice'] : NULL;
    $lastUpdatedBy    = $_SESSION['user_name'];

    if (updateProduct($pdo, $digitalProductId, $productName, $productType, $price, $salePrice, $lastUpdatedBy)) {
        header("Location: ../viewProducts.php?designerId=" . $designerId);
        exit();
    }
}

if (isset($_POST['deleteProductBtn'])) {
    $digitalProductId = $_GET['digitalProductId'];
    $designerId       = $_GET['designerId'];
    if (deleteProduct($pdo, $digitalProductId)) {
        header("Location: ../viewProducts.php?designerId=" . $designerId);
        exit();
    }
}
?>