<?php
// courses/edit.php
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/ValidationException.php'; // Include the exception class

$db = Database::getInstance();
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$errors = [];

// 1. Fetch existing course data
try {
    $course = $db->fetch('SELECT * FROM courses WHERE id = ?', [$id]);
    if (!$course) {
        header('Location: index.php');
        exit;
    }
} catch (Exception $e) {
    die('Failed to retrieve course data.');
}

$title       = $course['title'];
$description = $course['description'];

// 2. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    try {
        $validationErrors = [];

        // Validation: Title must not be empty and must be >= 3 characters
        if ($title === '') {
            $validationErrors['title'] = 'Title is required.';
        } elseif (strlen($title) < 3) {
            $validationErrors['title'] = 'Title must be at least 3 characters long.';
        }

        // Throw exception if validation failed
        if (!empty($validationErrors)) {
            throw new ValidationException($validationErrors);
        }

        // Safe to Update
        $db->update('courses', [
            'title'       => $title,
            'description' => $description
        ], 'id = ?', [$id]);

        header('Location: index.php?updated=1');
        exit;

    } catch (ValidationException $e) {
        // Catch user input errors and pass them to the UI
        $errors = $e->getErrors();
        
    } catch (Exception $e) {
        // Catch raw database PDOExceptions securely
        error_log("Failed to update course ID {$id}: " . $e->getMessage());
        $errors['general'] = 'Failed to update the course. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h1>Edit Course</h1>

<?php if (!empty($errors['general'])): ?>
    <p style="color: red; font-weight: bold;"><?= htmlspecialchars($errors['general']) ?></p>
<?php endif; ?>

<form method="post">
    <div>
        <label>Title:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($title) ?>">
        <?php if (!empty($errors['title'])): ?>
            <span style="color: red;"><?= htmlspecialchars($errors['title']) ?></span>
        <?php endif; ?>
    </div>
    <br>
    
    <div>
        <label>Description:</label><br>
        <textarea name="description" rows="4" cols="50"><?= htmlspecialchars($description) ?></textarea>
    </div>
    <br>
    
    <button type="submit">Update Course</button>
    <a href="index.php" class="btn btn-cancel">Cancel</a>
</form>
</body>
</html>