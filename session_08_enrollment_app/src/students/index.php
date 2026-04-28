<?php
// students/index.php
require_once __DIR__ . '/../classes/Database.php';

$students = []; // Initialize as an empty array so the HTML table doesn't break
$successMessage = '';
$errorMessage = '';

// Catch database connection or query failures gracefully
try {
    $db = Database::getInstance();
    $students = $db->fetchAll('SELECT * FROM students ORDER BY created_at DESC');
} catch (Exception $e) {
    // The Database class has already logged the raw error internally.
    // We catch the generic exception here and pass it to the UI.
    $errorMessage = $e->getMessage(); 
}

if (isset($_GET['success'])) {
    $successMessage = 'Student added successfully!';
} elseif (isset($_GET['updated'])) {
    $successMessage = 'Student updated successfully!';
} elseif (isset($_GET['deleted'])) {
    $successMessage = 'Student deleted successfully!';
} elseif (isset($_GET['error'])) {
    $errorMessage = 'An error occurred processing your request.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Students</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h1>Manage Students</h1>

<?php if ($successMessage): ?>
    <p style="color: green; font-weight: bold;"><?= htmlspecialchars($successMessage) ?></p>
<?php endif; ?>
<?php if ($errorMessage): ?>
    <p style="color: red; font-weight: bold;"><?= htmlspecialchars($errorMessage) ?></p>
<?php endif; ?>

<p><a href="create.php" class="btn btn-primary">+ Add Student</a></p>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($students as $student): ?>
        <tr>
            <td><?= $student['id'] ?></td>
            <td><?= htmlspecialchars($student['name']) ?></td>
            <td><?= htmlspecialchars($student['email']) ?></td>
            <td><?= htmlspecialchars($student['phone'] ?? 'N/A') ?></td>
            <td><?= $student['created_at'] ?></td>
            <td>
                <a href="edit.php?id=<?= $student['id'] ?>" class="btn btn-edit">Edit</a>
                <a href="delete.php?id=<?= $student['id'] ?>" class="btn btn-delete"
                   onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>