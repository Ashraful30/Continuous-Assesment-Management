<?php  

	error_reporting(0);
	session_start();
	include('db_connect.php');
	$flag = 0;$err = "";$msg = "";
	
	if (isset($_POST['submit'])) {

		$session = $_POST['session'];
		$department = $_POST['department'];
		$sql="SELECT id from student where session='$session' and dept_name='$department'";
		$res=mysqli_query($conn,$sql);
		if(mysqli_num_rows($res)>0){

			$row=mysqli_fetch_assoc($res);
			$id=$row['id'];
			$sql="SELECT student_id from attendance where student_id='$id'";
			$res=mysqli_query($conn,$sql);
			if(mysqli_num_rows($res)>0){

				$err="Attendance marks already inserted of session ".$session." of ".$department." Department";
				$flag=0;
			}
			else{
				$flag=1;
			}

		}
		else{
			$err="Student's information isn't added yet of session ".$session." of ".$department." Department";
			$flag=0;
		}	
	}

	if (isset($_POST['submit2'])) {
		
		$nos = $_POST['nos'];
		for ($i=0; $i < $nos ; $i++) { 

			$id=$_SESSION['id'][$i];
			$marks=$_POST[$i];
			
			$sql = "INSERT into attendance(student_id,attend_marks) values('$id','$marks')";
			$res = mysqli_query($conn,$sql);
			if ($res) {
				$msg="Information inserted successfully";
			}
			else{
				$err="Insertion unsuccessful";
			}
		}
		$flag=0;
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Add Attendance Marks</title>
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
				<li><a href="add_student.php">Add Student</a></li>
				<li><a href="add_ct_marks.php">Add CT/Assignment/Presentation Mark</a></li>
				<li><a style="background-color: #313131;color: #AAAAAA" href="add_attendance.php">Add Attendance Mark</a></li>
				<li><a href="display.php">Display Continuous Assesment</a></li>
			</ul>
		</div>

		<?php  

			if ($flag==0) {

				echo "<p style='text-align:center;margin-top: 50px;color:#D00000;font-size: 30px;'>".$err."</p>";
				echo "<p style='text-align:center;margin-top: 50px;color:#1C7F20;font-size: 30px;'>".$msg."</p>";
				echo "<p style='margin-top: 50px;font-size: 25px;text-align: center;color: white'>Select Session, Department of Student</p>";
				
				include('similar.php');
					
				echo'<tr><td colspan="2"><input id="fsubmit" type="submit" name="submit" value="Submit"></td></tr></table></form>';
			}
		?>


		<?php  

			if ($flag==1) {

				echo "<p style='margin-top: 50px;font-size: 25px;text-align: center;color: white'>Enter Attendance Marks of Each Student</p>";
				echo '<form action="" method="post"><table align="center" style="color:white">';
				echo '<tr><th>ID</th><th>Marks</th></tr>';
				$sql="SELECT id from student where session='$session' and dept_name='$department'";
				$res=mysqli_query($conn,$sql);
				$counter=0;$nos=0;$id=[];
				while($row=mysqli_fetch_assoc($res)){
					echo '<tr><td id="ff">'.$row['id'].'</td>';
					$id[$counter]=$row['id'];
					echo '<td>
						      <input id="fs" type="number" max="10" min="1" title="Only number allowed >=1 and <=10" name='.$counter.' placeholder="Enter Marks" required>
						  </td></tr>';
					$counter++;
					$nos++;
				}

				echo'<input type="hidden" name="nos" value='.$nos.'>';
				echo '<tr><td colspan="2"><input id="fsubmit" type="submit" name="submit2" value="Submit"></td></tr>';
				echo '</table></form>';
				$_SESSION['id']=$id;
			}

		?>
	</body>
</html>

