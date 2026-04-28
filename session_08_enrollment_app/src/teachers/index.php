<?php
// teachers/index.php

// 1. Load environment and database settings
require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../classes/Database.php';

$teachers = [];
$successMessage = '';
$errorMessage = '';

// 2. Fetch the records securely
try {
    $db = Database::getInstance();
    $teachers = $db->fetchAll('SELECT * FROM teachers ORDER BY created_at DESC');
} catch (Exception $e) {
    // Catch connection/query failures and show the generic message
    $errorMessage = $e->getMessage();
}

// 3. Handle UI Notifications
if (isset($_GET['success'])) {
    $successMessage = 'Teacher added successfully!';
} elseif (isset($_GET['updated'])) {
    $successMessage = 'Teacher updated successfully!';
} elseif (isset($_GET['deleted'])) {
    $successMessage = 'Teacher deleted successfully!';
} elseif (isset($_GET['error']) && $_GET['error'] === 'delete_failed') {
    if (empty($errorMessage)) {
        $errorMessage = 'Failed to delete teacher due to a system error.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Teachers</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h1>Manage Teachers</h1>

<?php if ($successMessage): ?>
    <p style="color: green; font-weight: bold;"><?= htmlspecialchars($successMessage) ?></p>
<?php endif; ?>
<?php if ($errorMessage): ?>
    <p style="color: red; font-weight: bold;"><?= htmlspecialchars($errorMessage) ?></p>
<?php endif; ?>

<p><a href="create.php" class="btn btn-primary">+ Add New Teacher</a></p>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php if (empty($teachers)): ?>
        <tr><td colspan="6" style="text-align: center;">No teachers found.</td></tr>
    <?php else: ?>
        <?php foreach ($teachers as $teacher): ?>
            <tr>
                <td><?= $teacher['id'] ?></td>
                <td><?= htmlspecialchars($teacher['name']) ?></td>
                <td><?= htmlspecialchars($teacher['email']) ?></td>
                <td><?= htmlspecialchars($teacher['phone'] ?? 'N/A') ?></td>
                <td><?= $teacher['created_at'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $teacher['id'] ?>" class="btn btn-edit">Edit</a>
                    <a href="delete.php?id=<?= $teacher['id'] ?>" class="btn btn-delete"
                       onclick="return confirm('Are you sure you want to delete this teacher?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
</body>
</html>