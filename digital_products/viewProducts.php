<?php 
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

$designerId = $_GET['designerId'] ?? null;

if (!$designerId) {
    header("Location: index.php");
    exit();
}

$designer = getDesignerById($pdo, $designerId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Designer Products</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="container">
        <a href="index.php" class="back-link">← Back to Designer List</a>
        <h1>Digital Products of <?php echo htmlspecialchars(($designer['first_name'] ?? '') . ' ' . ($designer['last_name'] ?? '')); ?></h1>

        <h2>Add New Digital Product</h2>
        <div class="card">
            <form action="core/handleForms.php?designerId=<?php echo $designerId; ?>" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="productName" placeholder="e.g. Canva Planner Template" required>
                    </div>
                    <div class="form-group">
                        <label>Product Type</label>
                        <input type="text" name="productType" placeholder="e.g. Template, Font, Preset" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Price ($)</label>
                        <input type="number" step="0.01" name="price" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label>Sale Price ($)</label>
                        <input type="number" step="0.01" name="salePrice" placeholder="0.00">
                    </div>
                </div>

                <input type="submit" name="insertProductBtn" value="Add Product" class="btn-submit">
            </form>
        </div>

        <h2>Product List</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Product Type</th>
                        <th>Price</th>
                        <th>Sale Price</th>
                        <th>Added By</th>
                        <th>Last Updated By</th>
                        <th>Last Updated</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $products = getProductsByDesigner($pdo, $designerId); ?>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $row): ?>
                        <tr>
                            <td><?php echo $row['digital_products_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['product_name'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['product_type'] ?? ''); ?></td>
                            <td>$<?php echo number_format($row['price'] ?? 0, 2); ?></td>
                            <td>$<?php echo !empty($row['sale_price']) ? number_format($row['sale_price'], 2) : '-'; ?></td>
                            <td><?php echo htmlspecialchars($row['added_by'] ?? 'System'); ?></td>
                            <td><?php echo htmlspecialchars($row['last_updated_by'] ?? '-'); ?></td>
                            <td>
                                <?php 
                                    echo !empty($row['last_updated']) 
                                        ? date('Y-m-d H:i', strtotime($row['last_updated'])) 
                                        : (!empty($row['order_created']) ? date('Y-m-d H:i', strtotime($row['order_created'])) : '-'); 
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <div class="action-links">
                                    <a href="editProduct.php?digitalProductId=<?php echo $row['digital_products_id']; ?>&designerId=<?php echo $designerId; ?>" class="link-edit">Edit</a>
                                    <button type="button" class="link-delete" onclick="openDeleteModal('<?php echo $row['digital_products_id']; ?>', '<?php echo htmlspecialchars(addslashes($row['product_name'])); ?>')">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" style="text-align: center; color: var(--text-muted);">No products found for this designer.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- CUSTOM DELETE CONFIRMATION MODAL -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-box">
            <h3>Delete Product</h3>
            <p>Are you sure you want to delete <strong id="modalProductName" style="color: var(--text-dark);"></strong>? This action cannot be undone.</p>
            
            <form id="deleteForm" action="" method="POST">
                <div class="modal-actions">
                    <button type="button" class="btn-modal-cancel" onclick="closeDeleteModal()">Cancel</button>
                    <button type="submit" name="deleteProductBtn" class="btn-modal-delete">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(productId, productName) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            const productNameSpan = document.getElementById('modalProductName');

            productNameSpan.textContent = productName;
            form.action = `core/handleForms.php?digitalProductId=${productId}&designerId=<?php echo $designerId; ?>`;
            
            modal.style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // Close modal when clicking outside the box
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                closeDeleteModal();
            }
        };
    </script>

</body>
</html>