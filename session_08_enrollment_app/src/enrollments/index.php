<?php
// enrollments/index.php
require_once __DIR__ . '/../classes/Database.php';

$courses = [];
$enrollments = [];
$successMessage = '';
$errorMessage = '';

$filterCourseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;

// Pagination configuration
$limit = 10; // 10 records per page
$page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$totalPages = 0;
$totalRecords = 0;

try {
    $db = Database::getInstance();
    $courses = $db->fetchAll('SELECT id, title FROM courses ORDER BY title');

    // --- STEP 1: Get the Total Count for Pagination ---
    $countSql = 'SELECT COUNT(*) as total FROM enrollments e';
    $params = [];
    
    if ($filterCourseId > 0) {
        $countSql .= ' WHERE e.course_id = ?';
        $params[] = $filterCourseId;
    }
    
    $totalResult = $db->fetch($countSql, $params);
    $totalRecords = $totalResult['total'];
    $totalPages = ceil($totalRecords / $limit);

    // --- STEP 2: Fetch the Paginated Data ---
    $sql = 'SELECT e.id,
                   s.name  AS student_name,
                   s.email,
                   c.title AS course_title,
                   e.enrolled_at
            FROM enrollments e
            JOIN students s ON e.student_id = s.id
            JOIN courses  c ON e.course_id  = c.id';

    if ($filterCourseId > 0) {
        $sql .= ' WHERE e.course_id = ?';
        // Note: $params already contains $filterCourseId from the count query
    }

    $sql .= ' ORDER BY e.enrolled_at DESC';
    
    // Append LIMIT and OFFSET directly to the string. 
    // This avoids PDO strict-typing issues when emulate_prepares is false.
    $sql .= " LIMIT {$limit} OFFSET {$offset}";
    
    $enrollments = $db->fetchAll($sql, $params);

} catch (Exception $e) {
    $errorMessage = 'Failed to load enrollments. ' . $e->getMessage();
}

if (isset($_GET['success'])) {
    $successMessage = 'Enrollment successful!';
} elseif (isset($_GET['deleted'])) {
    $successMessage = 'Enrollment removed successfully!';
} elseif (isset($_GET['error']) && $_GET['error'] === 'delete_failed') {
    if (empty($errorMessage)) {
        $errorMessage = 'Failed to remove enrollment due to a system error.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Enrollments</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h1>Manage Enrollments</h1>

<?php if ($successMessage): ?>
    <p style="color: green; font-weight: bold;"><?= htmlspecialchars($successMessage) ?></p>
<?php endif; ?>
<?php if ($errorMessage): ?>
    <p style="color: red; font-weight: bold;"><?= htmlspecialchars($errorMessage) ?></p>
<?php endif; ?>

<p><a href="create.php" class="btn btn-primary">+ Add New Enrollment</a></p>

<form method="get" action="index.php" class="filter-form">
    <label for="course_id"><strong>Filter by Course:</strong></label>
    <select name="course_id" id="course_id" onchange="this.form.submit()">
        <option value="0">-- All Courses --</option>
        <?php foreach ($courses as $c): ?>
            <option value="<?= $c['id'] ?>" <?= ($filterCourseId === $c['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['title']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<p>Showing page <?= $page ?> of <?= max(1, $totalPages) ?> (<?= $totalRecords ?> total records)</p>

<table>
    <tr>
        <th>ID</th>
        <th>Student Name</th>
        <th>Email</th>
        <th>Course</th>
        <th>Enrollment Date</th>
        <th>Actions</th>
    </tr>
    <?php if (empty($enrollments)): ?>
        <tr><td colspan="6" style="text-align: center;">No enrollments found.</td></tr>
    <?php else: ?>
        <?php foreach ($enrollments as $enroll): ?>
            <tr>
                <td><?= $enroll['id'] ?></td>
                <td><?= htmlspecialchars($enroll['student_name']) ?></td>
                <td><?= htmlspecialchars($enroll['email']) ?></td>
                <td><?= htmlspecialchars($enroll['course_title']) ?></td>
                <td><?= $enroll['enrolled_at'] ?></td>
                <td>
                    <a href="delete.php?id=<?= $enroll['id'] ?>"  class="btn btn-delete"
                       onclick="return confirm('Are you sure you want to remove this enrollment?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php
        // Helper to keep the course_id in the URL if it's set
        $filterParam = ($filterCourseId > 0) ? "&course_id={$filterCourseId}" : "";
        ?>

        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?><?= $filterParam ?>">&laquo; Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i == $page): ?>
                <span class="active"><?= $i ?></span>
            <?php else: ?>
                <a href="?page=<?= $i ?><?= $filterParam ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?><?= $filterParam ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

</body>
</html>