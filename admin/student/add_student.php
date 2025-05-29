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
// include('../include/link.html');
// include('../message/session.php');
include '../../includes/header.php';
// include('titleheader.php');
?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
	<div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
		<h3 class="text-center mb-4">Add Student</h3>

		<!-- Display error messages -->
		<!--<?php if (isset($_SESSION['login_error'])): ?>-->
		<!--    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['login_error']) ?></div>-->
		<!--    <?php unset($_SESSION['login_error']); ?>-->
		<!--<?php endif; ?>-->

		<!-- Login Form -->
		<form method="POST" action="addstudent.php" enctype="multipart/form-data">
			<div class="mb-3">
				<label for="username" class="form-label">Full Name</label>
				<input type="text" name="username" id="username" class="form-control" placeholder="Enter Full Name" required>
			</div>
			<div class="mb-3">
				<label for="username" class="form-label">Class</label>
				<input type="text" name="username" id="username" class="form-control" placeholder="Enter Class" required>
			</div>
			<div class="mb-3">
				<label for="username" class="form-label">Admission No</label>
				<input type="text" name="username" id="username" class="form-control" placeholder="Enter Admission No" required>
			</div>
			<div class="mb-3">
				<label for="username" class="form-label">Contact</label>
				<input type="text" name="username" id="username" class="form-control" placeholder="Enter Phone Number" required>
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Profile Image</label>
				<input type="file" name="image" id="image" class="form-control" placeholder="Select Profile Image" required>

			</div>
			<button type="submit" class="btn btn-primary w-100">Submit</button>
		</form>

		<!--<div class="mt-3 text-center">-->
		<!--    <a href="index.php" class="btn btn-link">Back</a>-->
		<!--    <a href="login_n.php" class="btn btn-link">Admin Login</a>-->
		<!--</div>-->
	</div>
</div>

<?php
if (isset($_POST['Submit'])) {
	include('../../dbconnect.php');
	$ROLLNO = $_POST['rollno'];
	$NAME = $_POST['name'];
	// $CITY = $_POST['city'];
	$PHNO = $_POST['PHNO'];
	$CLASS = $_POST['class'];
	$IMAGE = $_FILES['image']['name']; //['name] means uploaded image name.//
	$tempname = $_FILES['image']['tmp_name'];
	$moveimage = move_uploaded_file($tempname, "../dataimg/$IMAGE"); //uploaded image move to store assigned folder.//

	// $sql="INSERT INTO student (rollno,name, city, PHNO, class,image) VALUES ('$ROLLNO','$NAME','$CITY','$PHNO','$CLASS','$IMAGE')";

	$qry = "INSERT INTO `student`( `admission_no`, `name`, `phno`, `class`, `image`) VALUES ('$ROLLNO','$NAME','$PON','$CLASS','')";

	$run = mysqli_query($db, $qry);


	if ($run == true) {
?>
		<script type="text/javascript">
			alert('data inserted successfully');
		</script>
<?php
	} else {
		echo "error";
	}
}
?>




<!--<form method="POST" action="addstudent.php" enctype="multipart/form-data">-->
<!--	<table border="1" align="center" style="width:50%;font-size: 30px;">-->

<!--		<tr>-->
<!--			<th>Full Name</th>-->
<!--			<td><input type="text" name="name" placeholder="Enter Full Name" required></td>-->
<!--		</tr>-->
<!--		<tr>-->
<!--			<th>Class</th>-->
<!--			<td><input type="number" name=" class" placeholder="Enter Your Class" required></td>-->
<!--		</tr>-->
<!--		<tr>-->
<!--			<th>Admission No</th>-->
<!--			<td><input type="number" name="rollno" placeholder="Enter Admission No" required></td>-->
<!--		</tr>-->
<!-- <tr>
<!--			<th>City</th>-->
<!--			<td><input type="text" name="city" placeholder="Enter Your City" required></td>-->
<!--		</tr> -->-->
<!--		<tr>-->
<!--			<th>Parents Contact</th>-->
<!--			<td><input type="text" name="PHNO" placeholder="Enter Parents Mobile No" required></td>-->
<!--		</tr>-->

<!--		<tr>-->
<!--			<th>Image</th>-->
<!--			<td> <input type="file" name="image" required></td>-->
<!--		</tr>-->
<!--		<tr>-->
<!--			<td colspan="2" align="center">-->
<!--				<input height="20%" type="submit" name="Submit" value="Submit">-->
<!--			</td>-->
<!--		</tr>-->
<!--	</table>-->
<!--</form>-->