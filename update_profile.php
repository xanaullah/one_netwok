<?php
include 'config.php'; 

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    $profile_image = $_FILES['profile_image'];
    $file_name = basename($profile_image['name']);
    $file_tmp = $profile_image['tmp_name'];
    $file_error = $profile_image['error'];
    $file_size = $profile_image['size'];

    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $conn->begin_transaction();
        try {
            $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ? WHERE id = ?");
            $hashed_password = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : NULL;
            $stmt->bind_param("ssssi", $first_name, $last_name, $email, $hashed_password, $user_id);
            $stmt->execute();
            $stmt->close();

            if ($file_error === 0) {
                if (in_array($file_ext, $allowed_extensions) && $file_size <= 2 * 1024 * 1024) {  // 2MB limit
                    $new_file_name = uniqid('', true) . '.' . $file_ext;
                    $file_destination = 'uploads/images/' . $new_file_name;

                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
                        $stmt->bind_param("si", $new_file_name, $user_id);
                        $stmt->execute();
                        $stmt->close();
                    } else {
                        throw new Exception("Failed to upload image.");
                    }
                } else {
                    throw new Exception("Invalid file type or size.");
                }
            }

            $conn->commit();
            $success = "Profile updated successfully.";
            header('Location: profile.php'); // Redirect to profile page
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            $error = $e->getMessage();
        }
    }
}

// Fetch user details
$stmt = $conn->prepare("SELECT username, email, first_name, last_name, profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $first_name, $last_name, $profile_image);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
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
<div class="container mt-4">
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Update Profile</h4>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($first_name) ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($last_name) ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">New Password (Leave empty to keep current)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="profile_image">Profile Image (Leave empty to keep current)</label>
                    <input type="file" class="form-control-file" id="profile_image" name="profile_image">
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
