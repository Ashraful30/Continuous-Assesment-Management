<style>
	#ff {
		color: #ececec;
		font-size: 17px;
		font-family: tahoma;
		padding-right: 10px;
	}

	#fs {
		width: 165px;
		padding-top: 8px;
		padding-bottom: 8px;
	}
</style>


<?php  

	echo '<form action="" method="post">';

	echo '<table align="center"><tr><td id="ff">Session</td><td><select id="fs" name="session">
			<option value="2013-14">2013-14</option>
			<option selected="selected" value="2014-15">2014-15</option>
			<option value="2015-16">2015-16</option>
			<option value="2016-17">2016-17</option>
		</select></td></tr>';	

	echo '<tr><td id="ff">Department</td><td><select id="fs" name="department">
			<option selected="selected" value="CSE">CSE</option>
			<option value="EEE">EEE</option>
			<option value="ICE">ICE</option>
			<option value="ETE">ETE</option>
		</select></td></tr>';

?>