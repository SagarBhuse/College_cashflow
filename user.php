<?php
include("header.php");
include("sidebar.php");
if(isset($_POST['submit']))
{
	$file = rand(). $_FILES['img']['name'];
	move_uploaded_file($_FILES['img']['tmp_name'],"imgemployee/".$file);
	if(isset($_GET['editid']))
	{
		$sql ="UPDATE employee SET emptype='$_POST[emptype]',empname='$_POST[empname]',img='$file',empcode='$_POST[empcode]',password='$_POST[password]',status='$_POST[status]' WHERE employeeid='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) ==1)
		{
			echo "<script>alert('Employee record Updated successfully...');</script>";
			echo "<script>window.location='user.php';</script>";
		}
	}
	else
	{
		$sql ="INSERT INTO employee(emptype,empname,img,empcode,password,status) values('$_POST[emptype]','$_POST[empname]','$file','$_POST[empcode]','$_POST[password]','$_POST[status]')";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) ==1)
		{
			echo "<script>alert('Employee record inserted successfully...');</script>";
			echo "<script>window.location='user.php';</script>";
		}
	}
}
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM employee where employeeid='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
}
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
<form method="post" action="" enctype="multipart/form-data"onsubmit="return confirmvalidation()">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">User Master</h3>
        </div>
        <div class="card-body">
		
<div class="row">
	<div class="col-md-3">User Type</div>
	<div class="col-md-5">
		<select  class="form-control" name="emptype" id="emptype">
			<option value="">Select User Type</option>
			<?php
			$arr = array("Administrator","Employee");
			foreach($arr as $val)
			{
				if($val == $rsedit['emptype'])
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
	<div class="col-md-4"><span class="errmsg flash" id="erremptype" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Employee Name</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="empname" id="empname" value="<?php echo $rsedit['empname'];  ?>">
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errempname" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Image</div>
	<div class="col-md-5">
		<input type="file"  class="form-control" name="img" id="img">
<?php
if(isset($_GET['editid']))
{
	if($rsedit['img'] == "")
	{
		echo "<img src='images/defaultimg.png' style='width: 100px; height: 100px'>";
	}
	else if(file_exists("imgemployee/".$rsedit['img']))
	{
		echo "<img src='imgemployee/$rsedit[img]' class='img' style='width: 100px; height: 100px'>";
	}
	else
	{
		echo "<img src='images/defaultimg.png' style='width: 100px; height: 100px'>";
	}
}
 ?>		
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errimg" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Employee Code</div>
	<div class="col-md-5">
		<input type="number"  class="form-control" name="empcode" id="empcode" value="<?php echo $rsedit['empcode'];  ?>">
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errempcode" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Password</div>
	<div class="col-md-5">
		<input type="Password"  class="form-control" name="password" id="password" value="<?php echo $rsedit['password'];  ?>">
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errpassword" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Confirm Password</div>
	<div class="col-md-5">
		<input type="Password"  class="form-control" name="cpassword" id="cpassword" value="<?php echo $rsedit['password'];  ?>">
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errcpassword" style="color: red;"></span></div>
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
	if(document.getElementById("emptype").value == "")
	{
		document.getElementById("erremptype").innerHTML="Kindly Select User Type";
		i=1;
	}
	if(document.getElementById("empname").value == "")
	{
		document.getElementById("errempname").innerHTML="Employee Name should not be empty";
		i=1;
	}
	
	if(document.getElementById("img").value == "")
	{
		document.getElementById("errimg").innerHTML="Kindly Upload an image";
		i=1;
	}
	
	if(document.getElementById("empcode").value == "")
	{
		document.getElementById("errempcode").innerHTML="Employee Code should not be empty";
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
