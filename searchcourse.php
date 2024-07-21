<?php
include("databaseconnection.php");
?>
<form method="GET" action="">	
<table class="table table-striped table-bordered" >
	<tr>
		<th>Select Program</th>
		<td>
		<select  name="courseidsearch" id="courseidsearch" class="form-control" required>
			<option value=''>Select Program</option>
			<?php
			$sqlcourse = "SELECT * FROM course WHERE status='Active'";
			$qsqlcourse = mysqli_query($con,$sqlcourse);
			while($rscourse = mysqli_fetch_array($qsqlcourse))
			{
				if($rscourse['courseid'] == $_GET['courseidsearch'])
				{
					echo "<option value='$rscourse[courseid]' selected>$rscourse[course]</option>";
				}
				else
				{
					echo "<option value='$rscourse[courseid]'>$rscourse[course]</option>";
				}
			}
			?>
		</select>
		</td>
		<td><input type="submit" name="btnselectcoursesearch" id="btnselectcoursesearch" value="Search" class="btn btn-info" ></td>
	</tr>
</table>
</form>