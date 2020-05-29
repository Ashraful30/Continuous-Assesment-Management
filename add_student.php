<?php  

	error_reporting(0);
	include('db_connect.php');
	$flag = 0;$err = "";$msg = "";
	
	if (isset($_POST['submit'])) {

		$session = $_POST['session'];
		$department = $_POST['department'];
		$nos = $_POST['nos'];
		$flag = 1;
	}

	if (isset($_POST['submit2'])) {
		
		$session = $_POST['session'];
		$department = $_POST['department'];
		$nos = $_POST['nos'];
		$temp = 1;
		for ($i=0; $i < $nos ; $i++) { 

			$id=$_POST[$temp++];
			$name=$_POST[$temp++];
			
			$sql = "INSERT into student(id,name,dept_name,session) values('$id','$name','$department','$session')";
			$res = mysqli_query($conn,$sql);
			if ($res) {
				$msg="Information inserted successfully";
			}
			else{
				$err="Difficulty in Insertion";
			}
		}
		if (!empty($msg) && !empty($err)) {
			$err="";
			$msg="Some Information Inserted Successfully But Some Information Already Exist";
		}
		else if (empty($msg) && !empty($err)) {
			$err="Information Already Exist";
			$msg="";
		}
		$flag=0;
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Add New Student Information</title>
	<link rel="stylesheet" href="css/add_student.css">
	<link rel="stylesheet" href="css/style.css">
</head>
	<body>

		<div class="header">
			<h2>Continuous Assesment Management System</h2>
		</div>
		<div class="navm">
			<ul>
				<li><a href="home.php">Home</a></li>
				<li><a style="background-color: #313131;color: #AAAAAA" href="add_student.php">Add Student</a></li>
				<li><a href="add_ct_marks.php">Add CT/Assignment/Presentation Mark</a></li>
				<li><a href="add_attendance.php">Add Attendance Mark</a></li>
				<li><a href="display.php">Display Continuous Assesment</a></li>
			</ul>
		</div>

		<?php  

			if ($flag==0) {

				echo "<p style='text-align:center;margin-top: 50px;color:#D00000;font-size: 30px'>".$err."</p>";
				echo "<p style='text-align:center;margin-top: 50px;color:#1C7F20;font-size: 30px'>".$msg."</p>";
				echo "<p style='margin-top: 50px;font-size: 25px;text-align: center;color: white'>Select Session, Department & Enter Number of Student</p>";
				
				include('similar.php');
				
				echo '<tr><td id="ff">No of Student</td><td><input style="width: 161px;padding-top: 8px;padding-bottom: 8px" type="text" name="nos" placeholder="No of Student" required title="Only number allowed >0" pattern="[1-9][0-9]*" maxlength="3"></td></tr>';

				echo'<tr><td colspan="2"><input id="fsubmit" type="submit" name="submit" value="Submit"></td></tr></table></form>';
			}
		?>


		<?php  

			if ($flag==1) {

				echo "<p style='margin-top: 50px;font-size: 25px;text-align: center;color: white'>Enter ID & Name of Each Student</p>";
				echo '<form action="" method="post"><table align="center">';
				echo '<tr style="color:white"><th>ID</th><th>Name</th></tr>';
				$counter=1;
				for ($i=0; $i < $nos ; $i++) { 
					
					echo '<tr><td>
						      <input id="fs" type="text" name='.$counter.' placeholder="Enter ID" required title="Only number allowed >0" pattern="[1-9][0-9]*" maxlength="6">
						  </td>';
					$counter++;	  
					echo '<td>
						      <input id="fs" type="text" name='.$counter.' placeholder="Enter Name" required title="Only A-Z a-z and space and dot allowed" pattern="[A-Za-z]+[A-Za-z .]*" maxlength="20">
						  </td></tr>';
					$counter++;
				}

				echo'<input type="hidden" name="nos" value='.$nos.' >
				<input type="hidden" name="session" value='.$session.'>
					<input type="hidden" name="department" value='.$department.' >';
				echo '<tr><td colspan="2"><input id="fsubmit" type="submit" name="submit2" value="Submit"></td></tr>';
				echo '</table></form>';
			}
		?>
	</body>
</html>

