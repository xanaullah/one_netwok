<?php
session_start();
require 'config.php'; 

if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.0 403 Forbidden');
    exit();
}

$file = basename($_GET['file']); 
$filepath = 'uploads/images' . $file;

if (file_exists($filepath) && is_file($filepath)) {
    header('Content-Type: ' . mime_content_type($filepath));
    header('Content-Disposition: inline; filename="' . basename($filepath) . '"');
    readfile($filepath);
} else {
    header('HTTP/1.0 404 Not Found');
}
?>
