<?php
// students/edit.php
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

// 1. Fetch the existing student data to pre-fill the form
try {
    $student = $db->fetch('SELECT * FROM students WHERE id = ?', [$id]);
    if (!$student) {
        header('Location: index.php');
        exit;
    }
} catch (Exception $e) {
    die('Failed to load student data.');
}

// Pre-fill variables
$name  = $student['name'];
$email = $student['email'];
$phone = $student['phone'] ?? ''; // Use null coalescing in case it's null in DB

// 2. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']  ?? '');
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

        // Duplicate Check: MUST exclude current student's ID
        $existing = $db->fetch(
            'SELECT id FROM students WHERE email = ? AND id <> ?',
            [$email, $id]
        );

        if ($existing) {
            $validationErrors['email'] = 'Email taken by another student.';
        }

        // Throw exception if validation failed
        if (!empty($validationErrors)) {
            throw new ValidationException($validationErrors);
        }

        // Safe to Update
        $db->update('students', [
            'name'  => $name,
            'email' => $email,
            'phone' => $phone
        ], 'id = ?', [$id]);

        header('Location: index.php?updated=1');
        exit;

    } catch (ValidationException $e) {
        // Catch validation errors and pass them to the UI
        $errors = $e->getErrors();
        
    } catch (Exception $e) {
        // Catch raw database PDOExceptions securely
        error_log("Failed to update student ID {$id}: " . $e->getMessage());
        $errors['general'] = 'Failed to update. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h1>Edit Student</h1>

<?php if (!empty($errors['general'])): ?>
    <p style="color: red; font-weight: bold;"><?= htmlspecialchars($errors['general']) ?></p>
<?php endif; ?>

<form method="post">
    <div>
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
        <?php if (!empty($errors['name'])): ?>
            <span style="color: red;"><?= htmlspecialchars($errors['name']) ?></span>
        <?php endif; ?>
    </div>
    <br>
    
    <div>
        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">
        <?php if (!empty($errors['email'])): ?>
            <span style="color: red;"><?= htmlspecialchars($errors['email']) ?></span>
        <?php endif; ?>
    </div>
    <br>

    <div>
        <label>Phone:</label><br>
        <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>">
        <?php if (!empty($errors['phone'])): ?>
            <span style="color: red;"><?= htmlspecialchars($errors['phone']) ?></span>
        <?php endif; ?>
    </div>
    <br>
    
    <button type="submit">Update</button>
    <a href="index.php" class="btn btn-cancel">Cancel</a>
</form>
</body>
</html>