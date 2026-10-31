<?php 
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Products Management System</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>!</p>
            <a href="core/handleForms.php?logoutUser=1" class="link-delete" style="text-decoration: none; padding: 6px 12px; border-radius: 4px;">Logout</a>
        </div>

        <h1>Digital Products Management System</h1>

        <h2>Add New Designer</h2>
        <div class="card">
            <form action="core/handleForms.php" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="userName" placeholder="e.g. jdoe_design" required>
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="firstName" placeholder="e.g. Jane" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="lastName" placeholder="e.g. Doe" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" name="dateOfBirth">
                    </div>
                    <div class="form-group">
                        <label>Specialization</label>
                        <input type="text" name="specialization" placeholder="e.g. Graphic Design, UI/UX, 3D Assets">
                    </div>
                </div>

                <input type="submit" name="insertDesignerBtn" value="Add Designer" class="btn-submit">
            </form>
        </div>

        <h2>Designer List</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Specialization</th>
                        <th>Added By</th>
                        <th>Last Updated By</th>
                        <th>Last Updated</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $designers = getAllDesigners($pdo); ?>
                    <?php if (!empty($designers)): ?>
                        <?php foreach ($designers as $row): ?>
                        <tr>
                            <td><?php echo $row['designer_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['user_name'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? '')); ?></td>
                            <td><?php echo htmlspecialchars($row['specialization'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['added_by'] ?? 'System'); ?></td>
                            <td><?php echo htmlspecialchars($row['last_updated_by'] ?? '-'); ?></td>
                            <td>
                                <?php 
                                    echo !empty($row['last_updated']) 
                                        ? date('Y-m-d H:i', strtotime($row['last_updated'])) 
                                        : '-'; 
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <div class="action-links">
                                    <a href="viewProducts.php?designerId=<?php echo $row['designer_id']; ?>" class="link-view">View Products</a>
                                    <a href="editDesigner.php?designerId=<?php echo $row['designer_id']; ?>" class="link-edit">Edit</a>
                                    <a href="deleteDesigner.php?designerId=<?php echo $row['designer_id']; ?>" class="link-delete">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center; color: var(--text-muted);">No designers found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>