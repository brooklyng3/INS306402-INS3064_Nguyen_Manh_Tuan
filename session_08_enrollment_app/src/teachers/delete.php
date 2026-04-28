<?php
// teachers/delete.php

// 1. Load dependencies
require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../classes/Database.php';

// 2. Capture and validate the ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    // If the ID is invalid or missing, quietly redirect back to the list
    header('Location: index.php');
    exit;
}

try {
    // 3. Execute the deletion
    $db = Database::getInstance();
    
    // Assuming your Database class has a delete method similar to insert/update.
    // If not, you can replace this with: $db->query('DELETE FROM teachers WHERE id = ?', [$id]);
    $db->delete('teachers', 'id = ?', [$id]);

    // 4. Redirect on Success
    header('Location: index.php?deleted=1');
    exit;

} catch (Exception $e) {
    // 5. Secure Error Handling
    // Log the actual system or constraint error safely out of user view
    error_log("Failed to delete teacher ID {$id}: " . $e->getMessage());
    
    // Redirect back with a generic error flag
    header('Location: index.php?error=delete_failed');
    exit;
}