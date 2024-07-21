<?php
include("header.php");
include("sidebar.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql ="UPDATE  service SET servicetype='$_POST[servicetype]',servicetitle='$_POST[servicetitle]',servicedescription='$_POST[servicedescription]',servicecost='$_POST[servicecost]',status='$_POST[status]' WHERE serviceid='$_GET[editid]' ";
		$qsql = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con) ==1)
		{
			echo "<script>alert('Service record updated successfully...');</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
	else
	{
		$sql ="INSERT INTO service(servicetype,servicetitle,servicedescription,servicecost,status,courseid) values('Student Fees','$_POST[servicetitle]','$_POST[servicedescription]','$_POST[servicecost]','$_POST[status]','$_POST[courseid]')";
		$qsql = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con) ==1)
		{
			echo "<script>alert('Fee type inserted successfully...');</script>";
			//echo "<script>window.location='feetype.php';</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
}
 ?>
<?php
if(isset($_GET['editid']))
{
	//Step 2 : Select statement starts here
	$sqledit ="SELECT * FROM service WHERE serviceid='$_GET[editid]'";
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

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Fee Types</h3>
        </div>
        <div class="card-body">
<form method="post" action=""onsubmit="return confirmvalidation()">		
<input  type="hidden" name="servicetype" id="servicetype" value="<?php echo $rsedit['servicetype'];  ?>" >


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
	<div class="col-md-3">Fee Type</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="servicetitle" id="servicetitle" value="<?php echo $rsedit['servicetitle'];  ?>">
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errservicetitle" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Detail about Fee</div>
	<div class="col-md-5">
		<textarea class="form-control" name="servicedescription" id="servicedescription"><?php echo $rsedit['servicedescription'];  ?></textarea>
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errservicedescription" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Fee Amount</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="servicecost" id="servicecost" value="<?php echo $rsedit['servicecost'];  ?>">
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errservicecost" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Status</div>
	<div class="col-md-5">
		<select class="form-control" name="status" id="status" >
		<option value=''>Select status</option>
		<?php
		$arr  = array("Active","Inactive");
		foreach($arr as $val)
		{
			
			if($val == $rsedit['status'])
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
</form>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

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
	if(document.getElementById("servicetype").value == "")
	{
		document.getElementById("errservicetype").innerHTML="Kindly Select Service type";
		i=1;
	}
	
	if(document.getElementById("servicetitle").value == "")
	{
		document.getElementById("errservicetitle").innerHTML="Service Title should not be empty";
		i=1;
	}
	

	if(document.getElementById("servicedescription").value == "")
	{
		document.getElementById("errservicedescription").innerHTML="Service Description should not be empty";
		i=1;
	}
	if(document.getElementById("servicecost").value == "")
	{
		document.getElementById("errservicecost").innerHTML="Service Cost should not be empty";
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
