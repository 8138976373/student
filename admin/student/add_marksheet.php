<!-- <?php
		session_start();
		if (isset($_SESSION['username'])) /*for security purpose without username and password deny access to dashboard*/ {
			echo "";
		} else {
			header('location:../login.php');
		}
		echo " welcome " . $_SESSION['username']
		?> -->
<?php

include '../../includes/header.php';
?>
<!--include('../message/session.php');-->
<!--include('titleheader.php');-->
<link rel="stylesheet" href="/student/assets/style.css">

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
	<div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
		<h3 class="text-center mb-4">Add Marksheet</h3>

		<!-- Login Form -->
		<form method="POST" action="">
			<div class="mb-3">
				<label for="name" class="form-label">Exam Name</label>
				<input type="text" name="name" id="name" class="form-control" placeholder="Enter Exam Name" required>
			</div>
			<div class="mb-3">
				<label for="english" class="form-label">English</label>
				<input type="number" name="english" id="english" class="form-control" placeholder="Enter Mark" required>
			</div>
			<div class="mb-3">
				<label for="seclanguage" class="form-label">II Launguage</label>
				<input type="number" name="seclanguage" id="seclanguage" class="form-control" placeholder="Enter Mark" required>
			</div>
			<div class="mb-3">
				<label for="maths" class="form-label">Maths</label>
				<input type="number" name="maths" id="maths" class="form-control"  placeholder="Enter Mark" required>
			</div>
			<div class="mb-3">
				<label for="php" class="form-label">PHP</label>
				<input type="number" name="php" id="php" class="form-control"  placeholder="Enter Mark" required>
			</div>
			<div class="mb-3">
				<label for="java" class="form-label">Java</label>
				<input type="number" name="java" id="java" class="form-control"  placeholder="Enter Mark" required>
			</div>
			<div class="mb-3">
				<label for="dbms" class="form-label">DBMS</label>
				<input type="number" name="dbms" id="dbms" class="form-control"  placeholder="Enter Mark" required>
			</div>
			<!-- <div class="mb-3">
				<label for="image" class="form-label">PHP</label>
				<input type="file" name="image" id="image" class="form-control" placeholder="Select Profile Image" required>

			</div> -->
			<button type="submit" name="submit" class="btn btn-primary w-100">Submit</button>
		</form>

		<!--<div class="mt-3 text-center">-->
		<!--    <a href="index.php" class="btn btn-link">Back</a>-->
		<!--    <a href="login_n.php" class="btn btn-link">Admin Login</a>-->
		<!--</div>-->
	</div>
</div>

<?php
if (isset($_POST['submit'])) {
	include('../../dbconnect.php');

	$ROLLNO = $_POST['rollno'];
	$NAME = $_POST['name'];
	$PHNO = $_POST['phno'];
	$CLASS = $_POST['class'];
	$RAW_IMAGE = $_FILES['image']['name'];
	$SANITIZED_IMAGE = time() . '_' . preg_replace('/[^A-Za-z0-9.\-_]/', '_', $RAW_IMAGE);
	$tempname = $_FILES['image']['tmp_name'];
	$folder = "../../dataimg/" . $SANITIZED_IMAGE;

	if (!is_dir("../../dataimg")) {
		mkdir("../../dataimg", 0777, true);
	}

	if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
		echo "<script>alert('Upload error: " . $_FILES['image']['error'] . "');</script>";
	}

	if (move_uploaded_file($tempname, $folder)) {
		$qry = "INSERT INTO `marks` (`admission_no`, `name`, `phno`, `class`, `image`) 
		        VALUES ('$ROLLNO', '$NAME', '$PHNO', '$CLASS', '$SANITIZED_IMAGE')";
		
		$run = mysqli_query($db, $qry);

		if ($run === true) {
			echo "<script>alert('Data inserted successfully');</script>";
		} else {
			echo "<script>alert('Database insert failed');</script>";
		}
	} else {
		echo "<script>alert('Image upload failed');</script>";
	}
}


?>
	
