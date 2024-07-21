<?php
include("header.php");
include("sidebar.php");
if(isset($_POST['submit']))
{
	$file = rand(). $_FILES['img']['name'];
	move_uploaded_file($_FILES['img']['tmp_name'],"imgemployee/".$file);
	if(isset($_SESSION['employeeid']))
	{
		$sql ="UPDATE employee SET emptype='$_POST[emptype]',empname='$_POST[empname]'";
		if($_FILES['img']['name'] != "")
		{
		$sql = $sql . ",img='$file'";
		}
		$sql = $sql . ",empcode='$_POST[empcode]' WHERE employeeid='$_SESSION[employeeid]'";
		$qsql = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con) ==1)
		{
			echo "<script>alert('Employee Profile Updated successfully...');</script>";
			//echo "<script>window.location='employee.php';</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
}
if(isset($_SESSION['employeeid']))
{
	$sqledit = "SELECT * FROM employee where employeeid='$_SESSION[employeeid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
}
else
{
	echo "<script>window.location='index.php';</script>";
}
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
<form method="post" action="" enctype="multipart/form-data">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Employee Master</h3>
        </div>
        <div class="card-body">
		
<div class="row">
	<div class="col-md-3">Designation</div>
	<div class="col-md-5">
		<?php
		if($rs['emptype'] == "Administrator" || $rs['emptype'] == "Employee")
		{
		?>
		<select  class="form-control" name="emptype" id="emptype">
			<option value="">Select Employee Type</option>
			<?php
			$arr = array("Administrator","Employee");
			foreach($arr as $val)
			{
				if($val == $rsedit['emptype'])
				{
					echo "<option value='$val' selected>$val</option>";
				}
			}
			 ?>
		</select>
		<?php
		}
		else
		{
			echo "<input type='text' class='form-control' readonly name='emptype' id='emptype' value='$rsedit[emptype]' >";
		}
		?>
	</div>
	<div class="col-md-4"></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Employee Name</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="empname" id="empname" value="<?php echo $rsedit['empname'];  ?>">
	</div>
	<div class="col-md-4"></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Image</div>
	<div class="col-md-5">
		<input type="file"  class="form-control" name="img" id="img">
<?php
if(isset($_SESSION['employeeid']))
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
	<div class="col-md-4"></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Employee Code</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="empcode" id="empcode" value="<?php echo $rsedit['empcode'];  ?>">
	</div>
	<div class="col-md-4"></div>
</div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">

<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-5">
		<input class="form-control"  type="submit" name="submit" id="submit" value="Update Profile">
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
</body>
</html>
