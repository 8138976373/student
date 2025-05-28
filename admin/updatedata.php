<?php
if (isset($_POST['Submit'])) {
	include('../dbconnect.php');
	$ROLLNO = $_POST['rollno'];
	$NAME = $_POST['name'];
	$CITY = $_POST['city'];
	$PCON = $_POST['pcon'];
	$CLASS = $_POST['class'];
	$ID = $_POST['id'];
	$IMAGE = $_FILES['image']['name']; //['name] means uploaded image name.//
	$tempname = $_FILES['image']['tmp_name'];
	$moveimage = move_uploaded_file($tempname, "../dataimg/$IMAGE"); //uploaded image move to store assigned folder.//


	$sql = ("UPDATE `student` SET  `name` = '$NAME',`rollno` = '$ROLLNO', `city` = '$CITY', `pcon` = '$PCON', `class` = '$CLASS', `image` = '$IMAGE' WHERE `student`.`id` = '$ID'");
	$result = mysqli_query($db, $sql);   /*include two variable database($db) and query($sql) and finally store $data variable */
	if ($result == 1) {
		echo "Data updated Successfully";
	} else {
		echo "error";
	}
}
