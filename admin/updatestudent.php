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
  <form action="updatestudent.php" method="POST">
  	<table align="center">
  		<tr>
  			<th>Full Name</th>
  			<td><input type="text" name="name" placeholder="Enter Full Name" required></td>

  			<th>class</th>
  			<td><input type="number" name=" class" placeholder="Enter class" required></td>
  			<td><input type="Submit" name="Submit" value="Search"></td>
  		</tr>
  	</table>

  </form>

  <table align="center" width="80%" border="1" style="margin-top: 10px" ;>
  	<tr style="background-color: #000;color: #fff; ">
  		<th>SN</th>
  		<th>Image</th>
  		<th>Name</th>
  		<th>Roll NO</th>
  		<th>Edit</th>
  	</tr>

  	<?php
		if (isset($_POST['Submit'])) {
			include('../dbconnect.php');
			$NAME = $_POST['name'];
			$CLASS = $_POST['class'];
			$sql = "SELECT * FROM student WHERE class='$CLASS' and name LIKE '%$NAME%'";
			$run = mysqli_query($db, $sql);   /*include two variable database($db) and query($sql) and finally store $data variable */
			if (mysqli_num_rows($run) < 1) {
				echo ("No record is Found");
			} else {
				$count = 0;
				while ($result = mysqli_fetch_assoc($run)) {
					$count++;
		?>
  				<tr align="center">
  					<td><?php echo $result['id']; ?></td>
  					<td><img src="../dataimg/<?php echo $result['image']; ?>" style="max-width: 100px;max-height: 100px;" /></td>
  					<td><?php echo $result['name']; ?></td>
  					<td><?php echo $result['rollno']; ?></td>
  					<td><a href="updateform.php?id=<?php echo $result['id']; ?> ">Edit</a></td>
  				</tr>
  	<?php

				}
			}
		}
		?>
  </table>