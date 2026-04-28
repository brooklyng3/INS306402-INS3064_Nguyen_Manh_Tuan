<?php
// courses/index.php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();
$courses = $db->fetchAll('SELECT * FROM courses ORDER BY created_at DESC');

$successMessage = '';
$errorMessage = '';

if (isset($_GET['success'])) {
    $successMessage = 'Course created successfully!';
} elseif (isset($_GET['updated'])) {
    $successMessage = 'Course updated successfully!';
} elseif (isset($_GET['deleted'])) {
    $successMessage = 'Course deleted successfully!';
} elseif (isset($_GET['error']) && $_GET['error'] === 'delete_failed') {
    $errorMessage = 'Failed to delete the course due to an unexpected server error.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Courses</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h1>Manage Courses</h1>

<?php if ($successMessage): ?>
    <p style="color: green;"><?= htmlspecialchars($successMessage) ?></p>
<?php endif; ?>
<?php if ($errorMessage): ?>
    <p style="color: red;"><?= htmlspecialchars($errorMessage) ?></p>
<?php endif; ?>

<p><a href="create.php" class="btn btn-primary">+ Add New Course</a></p>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($courses as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= htmlspecialchars($c['title']) ?></td>
            <td><?= htmlspecialchars($c['description']) ?></td>
            <td><?= $c['created_at'] ?></td>
            <td>
                <a href="edit.php?id=<?= $c['id'] ?>"class="btn btn-edit">Edit</a>
                <a href="delete.php?id=<?= $c['id'] ?>" class="btn btn-delete"
                   onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>