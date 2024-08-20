<?php
include 'config.php'; // Include your database or other configuration

session_start();
if (!isset($_SESSION['user_id'])) {
    die('Access denied.');
}

$file = isset($_GET['file']) ? basename($_GET['file']) : '';
$path = 'uploads/' . $file;

// Check if the file exists
if (file_exists($path)) {
    // Set headers to force download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($path) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($path));
    flush(); // Flush system output buffer
    readfile($path);
    exit;
} else {
    die('File not found.');
}
?>
