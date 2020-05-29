<?php  

	error_reporting(0);
	session_start();
	include('db_connect.php');


	$flag = 0;$err = "";$msg = "";$num=1;$nos=0;
	
	if (isset($_POST['submit'])) {

		$session = $_POST['session'];
		$department = $_POST['department'];
		$sql="SELECT id from student where session='$session' and dept_name='$department'";
		$res=mysqli_query($conn,$sql);


		if (mysqli_num_rows($res)>0) {

			$row=mysqli_fetch_assoc($res);
			$temp_id=$row['id'];
			$sql = "SELECT student_id from ct where student_id=".$temp_id."";
			$res= mysqli_query($conn,$sql);


			if (mysqli_num_rows($res)>0) {
				$flag=1;
			}
			else{
				$err="No CT or Assignmnt or Presentation taken yet of session ".$session." of ".$department." Department";
				$flag = 0;
			}


		}
		else{
			$err="Student's information isn't added yet of session ".$session." of ".$department." Department ";
			$flag = 0;
		}	
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Display Continuous Assesment Marks</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/display.css">
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
				<li><a href="add_attendance.php">Add Attendance Mark</a></li>
				<li><a style="background-color: #313131;color: #AAAAAA" href="display.php">Display Continuous Assesment</a></li>
			</ul>
		</div> 

		<?php

			if ($flag==0) {

				echo "<p style='text-align:center;margin-top: 50px;color:#D00000;font-size: 25px;'>".$err."</p>";
				echo "<p style='text-align:center;margin-top: 50px;color:#1C7F20;font-size: 30px;'>".$msg."</p>";
				echo "<p style='margin-top: 50px;font-size: 25px;text-align: center;color: white'>Select Session & Department To Display Result</p>";
				
				include('similar.php');

				echo'<tr><td colspan="2"><input id="fsubmit" type="submit" name="submit" value="Submit"></td></tr></table></form>';
			}
		?>


		<?php  

			if ($flag==1) {

				echo "<p style='text-align:center;margin-top: 50px;font-size: 35px;color: #fff'>Continuous Assesment of Session ".$session." of ".$department." Department</p>";

				echo '<table class="display" align="center"
				style="color:#fff;text-align:center;border-collapse:collapse;margin-bottom:50px"><tr><th id="p">ID</th><th id="p">Name</th>';

				$sql="SELECT type,count(type) AS 'num' from ct where student_id='$temp_id' GROUP BY type ORDER BY type";
				$na=0;$nc=0;$np=0;
				$res=mysqli_query($conn,$sql);
				if (mysqli_num_rows($res)>0) {

					while ($row=mysqli_fetch_assoc($res)) {
						
						if($row['type']=="assignment")
							$na=$row['num'];
						else if($row['type']=="ct")
							$nc=$row['num'];
						else
							$np=$row['num'];
					}
				}


				for ($i=1; $i <= $na ; $i++) { 
					echo '<th id="p">Assignment-'.$i.'</th>';
				}
				for ($i=1; $i <= $nc ; $i++) { 
					echo '<th id="p">CT-'.$i.'</th>';
				}
				for ($i=1; $i <= $np ; $i++) { 
					echo '<th id="p">Presentation-'.$i.'</th>';
				}
				echo '<th id="p">Best 2</th><th id="p">Attendance</th><th id="p">Total</th><th id="p">Action</th>';
				echo '</tr>';
				
				$max=$na+$nc+$np;

				$sql="SELECT student.id,student.name,ct.marks,attendance.attend_marks,ct.id as ct_id,ct.type,ct.num from student inner join ct on student.id=ct.student_id inner join attendance on ct.student_id=attendance.student_id where student.session='$session' and student.dept_name='$department' order by student.id,ct.type";
				$ct_id=[];
				$marks=[];
				$attend_marks=0;
				$res=mysqli_query($conn,$sql);
				if (mysqli_num_rows($res)>0) {
					$i=0;
					while ($row=mysqli_fetch_assoc($res)) {
						$ct_id[$i]=$row['ct_id'];
						$marks[$i]=$row['marks'];
						$i++;
						if ($i==$max) {

							$temp_marks=[];
							echo '<tr><td>'.$row['id'].'</td><td>'.$row['name'].'</td>';
							for ($j=0; $j <$max ; $j++) { 

								if ($marks[$j]==-1) {
									echo '<td>Absent</td>';
									$temp_marks[$j]=0;
								}
								else{
									echo '<td>'.$marks[$j].'</td>';
									$temp_marks[$j]=$marks[$j];
								}
							}
							rsort($temp_marks);
							
							if ($max==1) {
								echo '<td>'.$temp_marks[0].'</td>';
							}
							else{
								echo '<td>'.($temp_marks[0]+$temp_marks[1]).'</td>';
							}
							
							echo '<td>'.$row['attend_marks'].'</td>';
							$attend_marks=$row['attend_marks'];
							if ($max==1) {
								echo '<td>'.$temp_marks[0]+$attend_marks.'</td>';
							}
							else{
								echo '<td>'.($temp_marks[0]+$temp_marks[1]+$attend_marks).'</td>';
							}
							$i=0;
							$url="edit.php?id=".$row['id']."&attend_marks=".$attend_marks."&name=".$row['name'];
							for ($j=0; $j < $max; $j++) { 
								$url=$url."&marks[]=".$marks[$j];
							}
							for ($j=0; $j < $max; $j++) { 
								$url=$url."&cid[]=".$ct_id[$j];
							}
							$url=$url."&na=".$na."&nc=".$nc."&np=".$np;
							echo '<td><a id="edit" href="'.$url.'"target="_blank">Edit</a></td></tr>';
						}
					
					}
				
				}
				echo '</table>';
			}
		?>
	</body>
</html>

