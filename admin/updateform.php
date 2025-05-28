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
include('header.php');
include('titleheader.php');
?>

<?php

include('../dbconnect.php');
$ID = $_GET['id'];
$sql = "SELECT * FROM  student WHERE id= '$ID'";
$run = mysqli_query($db, $sql);
$result = mysqli_fetch_assoc($run);
$NAME = $result['name'];
$ROLLNO = $result['rollno'];
$CLASS = $result['class'];
$CITY = $result['city'];
$PCON = $result['pcon'];

?>
<form method="POST" action="updatedata.php" enctype="multipart/form-data">
	<table border="1" align="center" style="width:50%;font-size: 30px;">

		<tr>
			<th>Full Name</th>

			<td><input type="text" name="name" value="<?php echo $NAME; ?>" required></td>


		</tr>
		<tr>
			<th>Class</th>
			<td><input type="number" name="class" value="<?php if (isset($CLASS)) {
																echo $CLASS;
															} ?>" required></td>
		</tr>
		<tr>
			<th>Roll No</th>
			<td><input type="number" name="rollno" value="<?php if (isset($ROLLNO)) {
																echo $ROLLNO;
															} ?>" required></td>
		</tr>
		<tr>
			<th>City</th>
			<td><input type="text" name="city" value="<?php if (isset($CITY)) {
															echo $CITY;
														} ?>" required></td>
		</tr>
		<tr>
			<th>Parents Contact</th>
			<td><input type="text" name="pcon" value="<?php if (isset($PCON)) {
															echo $PCON;
														} ?>" required></td>
		</tr>

		<tr>
			<th>Image</th>
			<td> <input type="file" name="image" required></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type="text" name="id" value="<?php echo $ID; ?>" />
				<input height="30%" type="submit" name="Submit" value="Submit">
			</td>
		</tr>
	</table>
</form>