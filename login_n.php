<?php

include 'includes/header.php';
?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/login.css">
<div class="container mt-4">
    <!--<div class="row">-->
    <!--    <div class="col-12">-->
    <!--        <h2>Login</h2>-->
    <!--<p class="text-muted">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>-->
    <!--    </div>-->
    <!--</div>-->



    <div class="row" ,>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Login</h5>
                    <!--<p class="card-text">Register a new student in the system</p>-->
                    <!--        <div class="title">-->
                    <?php if (isset($_SESSION['login_error'])): ?>
                        <div class="error-message"><?= htmlspecialchars($_SESSION['login_error']) ?></div>
                        <?php unset($_SESSION['login_error']); ?>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <input type="text" name="username" placeholder="Username" required><br>
                        <input type="password" name="password" placeholder="Password" required><br>
                        <input type="submit" value="Submit"><br>
                    </form>
                </div>

                <!--<div class="button">    -->
                <!--    <a href="index.php" class="btn">Back</a>-->
                <!--    <a href="login.php" class="btn">Admin login</a>-->
                <!--</div>-->
            </div>
        </div>
    </div>




</div>

<?php include 'includes/footer.php'; ?>


<?php
session_start();
include('dbconnect.php');
if (isset($_POST['username']) && isset($_POST['password'])) {
    $Username = $_POST['username'];
    $Password = $_POST['password'];
    /*........... query for login.............*/
    $sql = "SELECT * FROM admin WHERE username = '$Username' and password = '$Password'";
    $data = mysqli_query($db, $sql);   /*include two variable database($db) and query($sql) and finally store $data variable */
    $result = mysqli_num_rows($data);/*data are feech then check how many data are feetch*/
    if ($result == 1) {
        $row = mysqli_fetch_assoc($data); // Fetch row as associative array
        $_SESSION['user_id'] = $row['id'];

        $_SESSION['username'] = $Username;
        header('location:admin/admindash.php'); /*redirect page whene you want*/
    } else {
        echo "failed";
    }
}
?>