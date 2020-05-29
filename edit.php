<?php  
	
	error_reporting(0);
	session_start();
	include('db_connect.php');
	$flag=0;$err="";$msg="";
	if (isset($_GET)) {
		
		$na=$_GET['na'];
		$nc=$_GET['nc'];
		$np=$_GET['np'];
		$id=$_GET['id'];
		$name=$_GET['name'];
		$attend_marks=$_GET['attend_marks'];
		$marks=$_GET['marks'];
		$cid=$_GET['cid'];
		$_SESSION['sid']=$id;
		$_SESSION['cid']=$cid;
		$flag=1;
	}

	if (isset($_POST['update'])) {
		
		for ($i=0; $i < count($_SESSION['cid']) ; $i++) { 
			$id=$_SESSION['cid'][$i];
			$sql="UPDATE ct set marks='$_POST[$i]' where id='$id'";
			$res=mysqli_query($conn,$sql);
			if ($res) {
				$msg="Information Updated Successfully";
			}
			else{
				$err="Fail to update";
			}
		}
		$temp=$_SESSION['sid'];
		$att=$_POST['attendance'];
		$sql="UPDATE attendance set attend_marks='$att' where student_id='$temp'";
		$res=mysqli_query($conn,$sql);
		if ($res) {
			$msg="Information Updated Successfully";
		}
		else{
			$err="Fail to update";
		}
		$flag=0;

	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Continuous Assesment Marks</title>
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
				<li><a href="add_attendance.php">Add Attendance Mark</a></li>
				<li><a href="display.php">Display</a></li>
			</ul>
		</div>

		<p style='text-align:center;margin-top: 50px;color:#D00000;font-size: 25px'><?php echo $err; ?></p>
		<p style='text-align:center;margin-top: 50px;color:#1C7F20;font-size: 30px'><?php echo $msg; ?></p>

		<?php  

			if ($flag==1) {

				echo "<p style='margin-top: 50px;font-size: 25px;text-align: center;color: white'>Enter marks to update (Put -1 if Absent)</p>";
				echo '<form method="post"><table align="center">';
				echo '<tr><td id="ff">Name</td><td id="ff">'.$name.'</td></tr>';
				echo '<tr><td id="ff">ID</td><td id="ff">'.$id.'</td></tr>';
				echo '<tr><td id="ff">Attendance Marks</td><td><input type="number" max="10" min="1" title="Only number allowed >=1 and <=10" style="width: 161px;padding-top: 8px;padding-bottom: 8px" name="attendance" value="'.$attend_marks.'"></td></tr>';
				$k=0;
				for ($i=0; $i < $na; $i++) { 
					echo '<tr><td id="ff">Assignment-'.($i+1).' Marks</td><td><input style="width: 161px;padding-top: 8px;padding-bottom: 8px" type="number" max="10" min="-1" title="Only number allowed >=-1 and <=10" name='.$k.' value="'.$marks[$k].'"></td></tr>';
					$k++;
				}
				for ($i=0; $i < $nc; $i++) { 
					echo '<tr><td id="ff">CT-'.($i+1).' Marks</td><td><input style="width: 161px;padding-top: 8px;padding-bottom: 8px" type="number" max="10" min="-1" title="Only number allowed >=-1 and <=10" name='.$k.' value="'.$marks[$k].'"></td></tr>';
					$k++;
				}
				for ($i=0; $i < $np; $i++) { 
					echo '<tr><td id="ff">Presentation-'.($i+1).' Marks</td><td><input type="number" max="10" min="-1" title="Only number allowed >=-1 and <=10" style="width: 161px;padding-top: 8px;padding-bottom: 8px" name='.$k.' value="'.$marks[$k].'"></td></tr>';
					$k++;
				}

				echo '<tr><td colsapn="2"><input id="fsubmit" type="submit" name="update" value="Update"></td></tr></table></form>';
			}

		?>

	</body>
</html>
