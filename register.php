<?php
include 'config.php';  // Replace with your actual configuration path

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));

    if (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password, first_name, last_name) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $hashed_password, $first_name, $last_name);

        try {
            $stmt->execute();
            header('Location: login.php?success=Registration successful. Please login.');
            exit();
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) { // Error code for duplicate entry
                $error = "Username or email already exists.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - User Authentication System</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        .register-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .register-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Home</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<div class="container register-container">
    <h1>Register</h1>
    <form method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control <?= isset($error) ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= htmlspecialchars($username ?? '') ?>" required>
            <?php if (isset($error) && strpos($error, 'Username') !== false): ?>
                <div class="invalid-feedback"><?= $error ?></div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($first_name ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($last_name ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Register</button>
        <?php if (isset($error) && strpos($error, 'Username') === false): ?>
            <div class="alert alert-danger mt-3"><?= $error ?></div>
        <?php endif; ?>
    </form>
</div>
<!-- Bootstrap JS and dependencies CDN -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
