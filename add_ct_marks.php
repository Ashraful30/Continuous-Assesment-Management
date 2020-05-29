<?php  

	error_reporting(0);
	session_start();
	include('db_connect.php');


	$flag = 0;$err = "";$msg = "";$num=1;$nos=0;

	if (isset($_POST['submit'])) {
		
		$session = $_POST['session'];
		$department = $_POST['department'];
		$type = $_POST['type'];
		$id=[];
		$sql = "SELECT id from student where session='$session' and dept_name='$department' ";

		$res= mysqli_query($conn,$sql);

		if (mysqli_num_rows($res)>0) {
			
			$i=0;
			while ($row=mysqli_fetch_assoc($res)) {
		
				$id[$i]=$row['id'];
				$i++;
				$nos++;
			}
			$sql2="SELECT max(num) as 'max' from ct where type='$type' and student_id='$id[0]'";
			$res2=mysqli_query($conn,$sql2);
			if (mysqli_num_rows($res2)>0) {
				$row=mysqli_fetch_assoc($res2);
				if (is_null($row['max'])) {
					$num=1;
				}
				else{
					$num=$row['max'] + 1;
				}
				$flag=1;
			}
		}
		else{
			$err="Student's information isn't added yet of session ".$session." of ".$department." Department";
			$flag = 0;
		}
	}

	if (isset($_POST['submit2'])) {

		$id = $_SESSION['id'];
		$nos = $_POST['nos'];
		$num = $_POST['num'];
		$type = $_POST['type'];

		for ($i=0; $i < $nos ; $i++) { 
			
			$marks = $_POST[$i+1];
			$sql = "INSERT into ct(student_id,num,marks,type) values('$id[$i]','$num','$marks','$type')";
			$res = mysqli_query($conn,$sql);
			if ($res) {
				$msg="Information inserted successfully";
			}
			else{
				$err="Difficulty in Insertion";
			}
		}
		$flag=0;
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Add CT/Attendance/Presentation Marks</title>
	<link rel="stylesheet" href="css/add_ct_marks.css">
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
				<li><a style="background-color: #313131;color: #AAAAAA" href="add_ct_marks.php">Add CT/Assignment/Presentation Mark</a></li>
				<li><a href="add_attendance.php">Add Attendance Mark</a></li>
				<li><a href="display.php">Display Continuous Assesment</a></li>
			</ul>
		</div>
		
		<?php  

			if ($flag==0) {

				echo "<p style='text-align:center;margin-top: 50px;color:#D00000;font-size: 30px;'>".$err."</p>";
				echo "<p style='text-align:center;margin-top: 50px;color:#1C7F20;font-size: 30px;'>".$msg."</p>";
				echo "<p style='margin-top: 50px;font-size: 25px;text-align: center;color: white'>Select Session, Department & Type</p>";

				include('similar.php');
				
				echo '<tr><td id="ff">Type</td><td><select id="fs" name="type">
						<option selected="selected" value="ct">CT</option>
						<option value="assignment">Assignment</option>
						<option value="presentation">Presentation</option>
					</select></td></tr>';

				echo'<tr><td colspan="2"><input id="fsubmit" type="submit" name="submit" value="Submit"></td></tr></table></form>';
			}
		?>


		<?php  

			if ($flag==1) {

				echo "<p style='margin-top: 50px;font-size: 25px;text-align: center;color: white'>Enter ";
				if($type=='ct'){
					echo strtoupper($type);
				}
				else{
					echo ucfirst($type);
				}
				
				echo " Mark of Each Student(Put -1 if Absent)</p>";
				echo '<form action="" method="post"><table align="center" style="color:white;text-align:center">';
				echo '<tr><th id="ff">ID</th><th id="ff">';
				if($type=='ct'){
					echo strtoupper($type);
				}
				else{
					echo ucfirst($type);
				}
				echo '-'.$num.' Mark</th></tr>';
				$counter=1;
				for ($i=0; $i < $nos ; $i++) { 
					 
					echo '<tr><td id="ff">'.$id[$i].'</td>';
					echo '<td>
						      <input id="fs" type="number" max="10" min="-1" title="Only number allowed >=-1 and <=10" type="text" name='.$counter.' placeholder="Enter Mark" required >
						  </td></tr>';
					$counter++;
				}

				echo'<input type="hidden" name="nos" value='.$nos.' >
					 <input type="hidden" name="type" value='.$type.' >
					 <input type="hidden" name="num" value='.$num.' >';
				echo '<tr ><td colspan="2"><input id="fsubmit" type="submit" name="submit2" value="Submit"></td></tr>';
				echo '</table></form>';
				$_SESSION['id']=$id;
			}
		?>
	</body>
</html>

