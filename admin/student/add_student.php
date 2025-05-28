<?php
session_start();
if (isset($_SESSION['username'])) /*for security purpose without username and password deny access to dashboard*/ {
	echo "";
} else {
	header('location:../login.php');
}
echo " welcome " . $_SESSION['username']
?>
<?php
// include('../include/link.html');
// include('../message/session.php');
include('header.php');
include('titleheader.php');
?>
<form method="POST" action="addstudent.php" enctype="multipart/form-data">
	<table border="1" align="center" style="width:50%;font-size: 30px;">

		<tr>
			<th>Full Name</th>
			<td><input type="text" name="name" placeholder="Enter Full Name" required></td>
		</tr>
		<tr>
			<th>Class</th>
			<td><input type="number" name=" class" placeholder="Enter Your Class" required></td>
		</tr>
		<tr>
			<th>Roll No</th>
			<td><input type="number" name="rollno" placeholder="Enter Roll No" required></td>
		</tr>
		<tr>
			<th>City</th>
			<td><input type="text" name="city" placeholder="Enter Your City" required></td>
		</tr>
		<tr>
			<th>Parents Contact</th>
			<td><input type="text" name="pcon" placeholder="Enter Parents Mobile No" required></td>
		</tr>

		<tr>
			<th>Image</th>
			<td> <input type="file" name="image" required></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input height="20%" type="submit" name="Submit" value="Submit">
			</td>
		</tr>
	</table>
</form>

<?php
if (isset($_POST['Submit'])) {
	include('../dbconnect.php');
	$ROLLNO = $_POST['rollno'];
	$NAME = $_POST['name'];
	$CITY = $_POST['city'];
	$PCON = $_POST['pcon'];
	$CLASS = $_POST['class'];
	$IMAGE = $_FILES['image']['name']; //['name] means uploaded image name.//
	$tempname = $_FILES['image']['tmp_name'];
	$moveimage = move_uploaded_file($tempname, "../dataimg/$IMAGE"); //uploaded image move to store assigned folder.//

	// $sql="INSERT INTO student (rollno,name, city, pcon, class,image) VALUES ('$ROLLNO','$NAME','$CITY','$PCON','$CLASS','$IMAGE')";

	$qry = "INSERT INTO `student`(`id`, `rollno`, `name`, `city`, `pcon`, `class`, `image`) VALUES ('null','$ROLLNO','$NAME','$CITY','$PCON','$CLASS','null')";

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