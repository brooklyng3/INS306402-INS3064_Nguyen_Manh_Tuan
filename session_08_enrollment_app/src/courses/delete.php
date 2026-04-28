<?php
// courses/delete.php
require_once __DIR__ . '/../classes/Database.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

try {
    $db = Database::getInstance();
    $db->delete('courses', 'id = ?', [$id]);
    
    header('Location: index.php?deleted=1');
    exit;
} catch (Exception $e) {
    // Log detailed backend context securely
    error_log("Failed to delete course ID {$id}: " . $e->getMessage());
    
    // Redirect with a generic UI error flag
    header('Location: index.php?error=delete_failed');
    exit;
}