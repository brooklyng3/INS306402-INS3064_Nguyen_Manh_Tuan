<?php
// teachers/edit.php

// 1. Load dependencies
require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/ValidationException.php';

$db = Database::getInstance();
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Redirect if ID is invalid
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$errors = [];

// 2. Fetch existing teacher data
try {
    $teacher = $db->fetch('SELECT * FROM teachers WHERE id = ?', [$id]);
    if (!$teacher) {
        header('Location: index.php');
        exit;
    }
} catch (Exception $e) {
    // If DB fails during initial load, halt execution safely
    error_log("Failed to load teacher ID {$id}: " . $e->getMessage());
    die('Failed to retrieve teacher data.');
}

// Pre-fill variables for the form
$name  = $teacher['name'];
$email = $teacher['email'];
$phone = $teacher['phone'] ?? '';

// 3. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    try {
        $validationErrors = [];

        // Validation Checks
        if ($name === '') {
            $validationErrors['name'] = 'Name is required.';
        }

        if ($email === '') {
            $validationErrors['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $validationErrors['email'] = 'Invalid email format.';
        }

        if ($phone !== '') {
            if (!preg_match('/^(03|05|07|08|09)\d{8}$/', $phone)) {
                $validationErrors['phone'] = 'Invalid Vietnamese mobile number format.';
            }
        }

        // Duplicate Email Check (Excluding current teacher)
        $existing = $db->fetch(
            'SELECT id FROM teachers WHERE email = ? AND id <> ?',
            [$email, $id]
        );

        if ($existing) {
            $validationErrors['email'] = 'This email is already registered to another teacher.';
        }

        // Throw exception if validation failed
        if (!empty($validationErrors)) {
            throw new ValidationException($validationErrors);
        }

        // 4. Safe to Update
        $db->update('teachers', [
            'name'  => $name,
            'email' => $email,
            'phone' => $phone !== '' ? $phone : null
        ], 'id = ?', [$id]);

        header('Location: index.php?updated=1');
        exit;

    } catch (ValidationException $e) {
        // Catch user input errors and display them
        $errors = $e->getErrors();
        
    } catch (Exception $e) {
        // Securely log DB crashes and show generic error
        error_log("Failed to update teacher ID {$id}: " . $e->getMessage());
        $errors['general'] = 'An error occurred while updating. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Teacher</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h1>Edit Teacher</h1>

<?php if (!empty($errors['general'])): ?>
    <p style="color: red; font-weight: bold;"><?= htmlspecialchars($errors['general']) ?></p>
<?php endif; ?>

<form method="post">
    <div class="form-group">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
        <?php if (!empty($errors['name'])): ?>
            <span class="error-msg"><?= htmlspecialchars($errors['name']) ?></span>
        <?php endif; ?>
    </div>
    
    <div class="form-group">
        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">
        <?php if (!empty($errors['email'])): ?>
            <span class="error-msg"><?= htmlspecialchars($errors['email']) ?></span>
        <?php endif; ?>
    </div>
    
    <div class="form-group">
        <label>Phone (Optional):</label><br>
        <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>">
        <?php if (!empty($errors['phone'])): ?>
            <span class="error-msg"><?= htmlspecialchars($errors['phone']) ?></span>
        <?php endif; ?>
    </div>
    
    <button type="submit">Update Teacher</button>
    <a href="index.php" class="btn btn-cancel">Cancel</a>
</form>
</body>
</html>