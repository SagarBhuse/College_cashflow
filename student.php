<?php
include("header.php");
include("sidebar.php");
if(isset($_POST['submit']))
{
	$filename = rand() . $_FILES['img']['name'];
	move_uploaded_file($_FILES['img']['tmp_name'],"imgprofile/".$filename);	
	if(isset($_GET['editid']))
	{
		$sql ="UPDATE student SET studentname='$_POST[studentname]',regno='$_POST[regno]',password='$_POST[password]',courseid='$_POST[courseid]',semester='$_POST[semester]',email='$_POST[email]',contactno='$_POST[contactno]',status='$_POST[status]'";
		if($_FILES['img']['name'] != "")
		{
			$sql = $sql . " ,img='$filename' ";
		}
		$sql = $sql . " WHERE studentid='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) ==1)
		{
			echo "<script>alert('Student profile updated successfully...');</script>";
		}
	}
	else
	{
		$sql ="INSERT INTO student(studentname,regno,password,courseid,semester,email,contactno,status,img) values('$_POST[studentname]','$_POST[regno]','$_POST[password]','$_POST[courseid]','$_POST[semester]','$_POST[email]','$_POST[contactno]','$_POST[status]','$filename')";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) ==1)
		{
			echo "<script>alert('Student account added successfully...');</script>";
			echo "<script>window.location='student.php';</script>";
		}
	}
}
if(isset($_GET['editid']))
{
	//Step 2 : Select statement starts here
	$sqledit ="SELECT * FROM student WHERE studentid='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
	//Step 2 : Select statement ends here
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
<form method="post" action="" onsubmit="return confirmvalidation()" enctype="multipart/form-data">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Student Master</h3>
        </div>
        <div class="card-body">
		
<div class="row">
	<div class="col-md-3">Student Name</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="studentname" id="studentname" value="<?php echo $rsedit['studentname'];  ?>">
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errstudentname" style="color: red;"></span></div>
</div>
<br>		
<div class="row">
	<div class="col-md-3">Student Name</div>
	<div class="col-md-5">
			<input type="file"  class="form-control" name="img" id="img" >
			<?php
			if($rsedit['img'] == "")
			{
			?>
				<img src="images/defaultimg.png" STYLE="width: 125px;height: 125px;">
			<?php
			}
			else if(file_exists("imgprofile/" . $rsedit['img']))
			{
			?>
				<img src="imgprofile/<?php echo $rsedit['img'];  ?>" STYLE="width: 125px;height: 125px;">
			<?php
			}
			else
			{
			?>
				<img src="images/defaultimg.png" STYLE="width: 125px;height: 125px;">
			<?php
			}
			?>			
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errstudentname" style="color: red;"></span></div>
</div>
<br>


<div class="row">
	<div class="col-md-3">Register Number</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="regno" id="regno" value="<?php echo $rsedit['regno'];  ?>">
		</select>
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errregno" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Password</div>
	<div class="col-md-5">
		<input type="password"  class="form-control" name="password" id="password" value="<?php echo $rsedit['password'];  ?>">
		</select>
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errpassword" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Confirm Password</div>
	<div class="col-md-5">
		<input type="password"  class="form-control" name="cpassword" id="cpassword" value="<?php echo $rsedit['password'];  ?>">
		</select>
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errcpassword" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Program</div>
	<div class="col-md-5">
		<select  name="courseid" id="courseid" class="form-control">
		<option value=''>Select Program</option>
		<?php
		$sqlcourse = "SELECT * FROM course WHERE status='Active'";
		$qsqlcourse = mysqli_query($con,$sqlcourse);
		while($rscourse = mysqli_fetch_array($qsqlcourse))
		{
			if($rscourse['courseid'] == $rsedit['courseid'])
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
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errcourseid" style="color: red;"></span></div>
</div>
<br>	
<div class="row">
	<div class="col-md-3">Semester</div>
	<div class="col-md-5">
		<select class="form-control" name="semester" id="semester">
		<option value=''>Select Semester</option>
		<?php
		$arr  = array("1st Semester","2nd Semester","3rd Semester","4th Semester","5th Semester","6th Semester");
		foreach($arr as $val)
		{
			if($val == $rsedit['semester'])
			{
			echo "<option value='$val' selected>$val</option>";
			}
			else
			{
			echo "<option value='$val'>$val</option>";
			}
		}
		 ?>
		</select>
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errsemester" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Email</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="email" id="email" value="<?php echo $rsedit['email'];  ?>">
	</div>
	<div class="col-md-4"></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Contact Number</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="contactno" id="contactno" value="<?php echo $rsedit['contactno'];  ?>">
	</div>
	<div class="col-md-4"></div>
</div>
<br>

<div class="row">
	<div class="col-md-3">Status</div>
	<div class="col-md-5">
		<select class="form-control" name="status" id="status">
		<option value=''>Select status</option>
		<?php
		$arr  = array("Active","Inactive");
		foreach($arr as $val)
		{
		    if($rsedit['status'] == $val)
			{
			echo "<option value='$val' selected>$val</option>";
			}
			else
			{
			echo "<option value='$val'>$val</option>";
			}
		}
		 ?>
		</select>
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errstatus" style="color: red;"></span></div>
</div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">

<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-5">
		<input class="form-control"  type="submit" name="submit" id="submit" value="Submit">
	</div>
	<div class="col-md-4"></div>
</div>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
</form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
include("footer.php");
 ?>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="dist/js/pages/dashboard3.js"></script>
<script>
function confirmvalidation()
{
	var i = 0;
	$('.errmsg').html('');
	if(document.getElementById("studentname").value == "")
	{
		document.getElementById("errstudentname").innerHTML="Student Name should not be empty";
		i=1;
	}
	if(document.getElementById("regno").value == "")
	{
		document.getElementById("errregno").innerHTML="Register number should not be empty";
		i=1;
	}	
	if(document.getElementById("password").value.length < 6)
	{
		document.getElementById("errpassword").innerHTML="Password should contain more than 6 characters";
		i=1;
	}
	if(document.getElementById("password").value == "")
	{
		document.getElementById("errpassword").innerHTML="Password code should not be empty";
		i=1;
	}
	if(document.getElementById("cpassword").value != document.getElementById("password").value)
	{
		document.getElementById("errcpassword").innerHTML="Password and Confirm password not matching";
		i=1;
	}
	if(document.getElementById("cpassword").value == "")
	{
		document.getElementById("errcpassword").innerHTML="Confirm Password  should not be empty";
		i=1;
	}
	if(document.getElementById("courseid").value == "")
	{
		document.getElementById("errcourseid").innerHTML="Kindly Select Program id";
		i=1;
	}
	if(document.getElementById("semester").value == "")
	{
		document.getElementById("errsemester").innerHTML="Kindly Select semester";
		i=1;
	}
	if(document.getElementById("status").value == "")
	{
		document.getElementById("errstatus").innerHTML="Kindly select the status";
		i=1;
	}
	 
	if(i == 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>
</body>
</html>