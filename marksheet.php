<!DOCTYPE html>
<html>

<head>
	<title></title>
</head>

<body>
	<form method="GET">
		<ul>
			<li><input type="text" name="txteng" placeholder="English"></li>
			<li><input type="text" name="txtnep" placeholder="Nepali"></li>
			<li><input type="text" name="txtmth" placeholder="Math"></li>
			<li><input type="text" name="txtsci" placeholder="Science"></li>
			<li><input type="text" name="txtsoc" placeholder="Social "></li>
			<li><input type="Submit" value="Grade"></li>
		</ul>

	</form>
	<?php

	include('dbconnect.php');
	if (isset($_GET['Submit'])) {
		$eng = $_GET['txteng'];
		$nep = $_GET['txtnep'];
		$mth = $_GET['txtmth'];
		$sci = $_GET['txtsci'];
		$soc = $_GET['txtsoc'];
		$obtmarks = $eng + $nep + $mth + $sci + $soc;
		echo $obtmarks;
		$totalmarks = 500;
		$grade = ($obtmarks / $totalmarks) * 100;
		if ($grade >= 90) {
			$output = "Grade A";
		} else if ($grade >= 80) {
			$output = "Grade B";
		} else if ($grade >= 60) {
			$output = "Grade C";
		} else if ($grade >= 50) {
			$output = "Grade D";
		} else if ($grade >= 40) {
			$output = "Grade E";
		} else if ($grade >= 30) {
			$output = "Fail";
		}

	?>
		<table border="1" width="100%">
			<tr>
			<tr>
				<th>
					Subjects
				</th>
				<th>
					Marks
				</th>
			<tr>
				<td>English</td>
				<td><?php echo $eng; ?></td>
			<tr>
				<td>Nepali</td>
				<td><?php echo $nep; ?></td>
			</tr>
			<tr>
				<td>Math</td>
				<td><?php echo $mth; ?></td>
			</tr>
			<tr>
				<td>Science</td>
				<td><?php echo $sci; ?></td>
			</tr>
			<tr>
				<td>Social</td>
				<td><?php echo $soc; ?></td>
			</tr>
			<tr>
				<td>Obtain Marks</td>
				<td><strong><?php echo $obtmarks; ?></strong></td>
			</tr>
			<tr>
				<td>Grade</td>
				<td><strong><?php echo $output; ?></strong></td>
			</tr>
		<?php
	}
		?>

		</table>
</body>

</html>