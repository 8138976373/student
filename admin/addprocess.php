<?php
session_start();
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

	$sql = "INSERT INTO student (id,rollno,name, city, pcon, class,image) VALUES (NULL,'$ROLLNO','$NAME','$CITY','$PCON','$CLASS','$IMAGE')";

	$result = mysqli_query($db, $sql);   /*include two variable database($db) and query($sql) and finally store $result variable */
	if ($result == 1) {

		$_SESSION['success'] = "data inserted successfully";
		header('location:addstudent.php');
		exit();
	}
}
