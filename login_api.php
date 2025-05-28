<?php
try {
    session_start();
    include('dbconnect.php');
    echo $_POST['password'];
    // Process login if form submitted. $_SERVER['REQUEST_METHOD'] == 'POST' &&
    if (isset($_POST['username'], $_POST['password'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = $_POST['password'];

        // Get stored hash from database
        $sql = "SELECT id, username, password FROM admin WHERE username = ?";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Verify password against stored hash
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                header('Location: admin/admindash.php');
                exit();
            }
        }

        // If we get here, login failed
        $_SESSION['login_error'] = 'Invalid username or password';
        header('Location: login.php');
        exit();
    }
} catch (Exception $e) {
    $_SESSION['login_error'] = 'A system error occurred. Please try again.';
    error_log('Login error: ' . $e->getMessage());
    header('Location: login.php');
    exit();
}
