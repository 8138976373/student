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
<?php {
	include('../dbconnect.php');
	$ID = $_GET['id'];

	$sql = "DELETE FROM student WHERE id='$ID'";
	$result = mysqli_query($db, $sql);   /*include two variable database($db) and query($sql) and finally store $data variable */
	if ($result == 1) {
		echo "Data delete Successfully";
	} else {
		echo "error";
	}
}
?>

