<?php 
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

$product = getProductById($pdo, $_GET['digitalProductId']);
$designerId = $_GET['designerId'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Digital Product</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="container" style="max-width: 600px;">
        <a href="viewProducts.php?designerId=<?php echo $designerId; ?>" class="back-link">← Cancel</a>
        <h2>Edit Digital Product</h2>

        <div class="card">
            <form action="core/handleForms.php?digitalProductId=<?php echo $_GET['digitalProductId']; ?>&designerId=<?php echo $designerId; ?>" method="POST">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Product Name</label>
                    <input type="text" name="productName" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Product Type</label>
                    <input type="text" name="productType" value="<?php echo htmlspecialchars($product['product_type']); ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Price ($)</label>
                        <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Sale Price ($)</label>
                        <input type="number" step="0.01" name="salePrice" value="<?php echo $product['sale_price']; ?>">
                    </div>
                </div>

                <input type="submit" name="editProductBtn" value="Save Changes" class="btn-submit">
            </form>
        </div>
    </div>

</body>
</html>