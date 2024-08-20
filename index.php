<?php
// index.php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Authentication System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container">
        <a class="navbar-brand text-primary font-weight-bold" href="index.php">One Network</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link text-primary" href="login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link text-primary" href="register.php">Register</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link text-primary" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link text-primary" href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h1 class="h3 text-primary mb-4">Welcome to User Management System</h1>
                    <p class="text-muted">In this system, users can sign up, log in, and manage their profiles.</p>
                    <a class="btn btn-primary btn-block mt-3" href="login.php">Login</a>
                    <a class="btn btn-outline-primary btn-block mt-2" href="register.php">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="bg-white border-top mt-5 py-3">
    <div class="container text-center">
        <small class="text-muted">&copy; 2024 UserAuth. All rights reserved.</small>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
