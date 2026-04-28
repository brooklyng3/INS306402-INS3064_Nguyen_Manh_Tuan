<?php
// courses/create.php
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/ValidationException.php'; // Bring in the new exception class

$errors = [];
$title  = '';
$description = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    try {
        $validationErrors = [];

        // 1. Validate Input
        if ($title === '') {
            $validationErrors['title'] = 'Title is required.';
        } elseif (strlen($title) < 3) {
            $validationErrors['title'] = 'Title must be at least 3 characters long.';
        }

        // 2. Throw exception if validation fails
        if (!empty($validationErrors)) {
            throw new ValidationException($validationErrors);
        }

        // 3. Safe to Insert
        $db = Database::getInstance();
        $db->insert('courses', [
            'title'       => $title,
            'description' => $description
        ]);
        
        header('Location: index.php?success=1');
        exit;

    } catch (ValidationException $e) {
        // Catch user input errors and pass them to the UI
        $errors = $e->getErrors();
        
    } catch (Exception $e) {
        // Catch raw database PDOExceptions securely
        error_log("Failed to create course: " . $e->getMessage());
        $errors['general'] = 'Something went wrong while saving the course. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Course</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h1>Add New Course</h1>

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
    
    <button type="submit">Save Course</button>
    <a href="index.php" class="btn btn-cancel">Cancel</a>
</form>
</body>
</html>