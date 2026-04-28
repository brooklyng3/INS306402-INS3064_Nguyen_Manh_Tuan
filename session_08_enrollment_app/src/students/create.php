<?php
// students/create.php
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/ValidationException.php'; // Require our new class

$errors = []; // Still needed to pass errors to the HTML form
$name   = '';
$email  = '';
$phone  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']  ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    try {
        $validationErrors = []; // Temporary array to collect errors

        // 1. Validate Input
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

        // 2. Check Database Business Logic (Duplicate Emails)
        $db = Database::getInstance();
        $existing = $db->fetch('SELECT id FROM students WHERE email = ?', [$email]);
        if ($existing) {
            $validationErrors['email'] = 'Email already exists.';
        }

        // 3. IF ANY ERRORS EXIST, THROW EXCEPTION BEFORE INSERTING
        if (!empty($validationErrors)) {
            throw new ValidationException($validationErrors);
        }

        // 4. Safe to Insert
        $db->insert('students', [
            'name'  => $name,
            'email' => $email,
            'phone' => $phone
        ]);
        
        header('Location: index.php?success=1');
        exit;

    } catch (ValidationException $e) {
        // Catch validation errors and pass them to the UI
        $errors = $e->getErrors();
        
    } catch (Exception $e) {
        // Catch raw database PDOExceptions
        // The DB class logs it internally, we just show the generic message
        $errors['general'] = 'Database error occurred. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h1>Add New Student</h1>

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
    
    <button type="submit">Save</button>
    <a href="index.php" class="btn btn-cancel">Cancel</a>
</form>
</body>
</html>