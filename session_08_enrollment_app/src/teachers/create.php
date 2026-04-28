<?php
// teachers/create.php

require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/ValidationException.php';

$errors = [];
$name   = '';
$email  = '';
$phone  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    try {
        $validationErrors = [];

        // 1. Input Validation
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

        // 2. Business Logic: Check for duplicate email
        $db = Database::getInstance();
        $existing = $db->fetch('SELECT id FROM teachers WHERE email = ?', [$email]);
        if ($existing) {
            $validationErrors['email'] = 'This email is already registered to another teacher.';
        }

        // 3. Throw Exception if any validation rules failed
        if (!empty($validationErrors)) {
            throw new ValidationException($validationErrors);
        }

        // 4. Safe to Insert
        $db->insert('teachers', [
            'name'  => $name,
            'email' => $email,
            // If phone is empty, insert NULL instead of an empty string
            'phone' => $phone !== '' ? $phone : null 
        ]);

        // 5. Redirect on success
        header('Location: index.php?success=1');
        exit;

    } catch (ValidationException $e) {
        // Catch user input errors and display them
        $errors = $e->getErrors();
        
    } catch (Exception $e) {
        // Securely log DB crashes and show generic error
        error_log("Failed to create teacher: " . $e->getMessage());
        $errors['general'] = 'An error occurred while saving. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Teacher</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h1>Add New Teacher</h1>

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
    
    <button type="submit">Save Teacher</button>
    <a href="index.php" class="btn btn-cancel">Cancel</a>
</form>
</body>
</html>