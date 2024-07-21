<?php
include("header.php");
include("sidebar.php");
if(isset($_POST['submit']))
{
	//Update statement starts here
	if(isset($_GET['editid']))
	{
		$sql ="UPDATE billing_template SET template_title='$_POST[template_title]',category_id='$_POST[category_id]',course_id='$_POST[course_id]',status='$_POST[status]' WHERE billing_template_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con) ==1)
		{
			echo "<script>alert('Account record updated successfully...');</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
	// Update statemetn ends here
	// Insert statement starts here
	else
	{
		$sql ="INSERT INTO billing_template(template_title,category_id,course_id,status) values('$_POST[template_title]','$_POST[category_id]','$_POST[course_id]','$_POST[status]')";
		$qsql = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con) ==1)
		{
			echo "<script>alert('Account record inserted successfully...');</script>";
			echo "<script>window.location='account.php';</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
	// Insert statement ends here
}
 ?>
<?php
if(isset($_GET['editid']))
{
	//Step 2 : Select statement starts here
	$sqledit ="SELECT * FROM billing_template WHERE billing_template_id='$_GET[editid]'";
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
<form method="post" action=""onsubmit="return confirmvalidation()">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Billing Template</h3>
        </div>
        <div class="card-body">
		
<div class="row">
	<div class="col-md-3">Template Title</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="template_title" id="template_title" value="<?php echo $rsedit['template_title'];  ?>" >
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errtemplate_title" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Category</div>
	<div class="col-md-5">
		<SELECT  class="form-control" name="category_id" id="category_id">
			<option value="">Select category</option>
			<?php
	$sql ="SELECT main.*,sub.categoryname as catname FROM category main LEFT JOIN category sub ON main.maincatid=sub.categoryid WHERE main.status='Active'";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		if($rs[0] == $rsedit['categoryid'])
		{
		echo "<option value='$rs[0]'>$rs[catname]</option>";
		}
		else
		{
		echo "<option value='$rs[0]'>$rs[catname]</option>";
		}
	}
			 ?>
		</SELECT>
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errcategory_id" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Program</div>
	<div class="col-md-5">
		<SELECT  class="form-control" name="course_id" id="course_id">
			<option value="">Select Program</option>
			<?php
	$sql ="SELECT * FROM course WHERE status='Active'";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		if($rs[0] == $rsedit['course_id'])
		{
		echo "<option value='$rs[0]'>$rs[course]</option>";
		}
		else
		{
		echo "<option value='$rs[0]'>$rs[course]</option>";
		}
	}
			 ?>
		</SELECT>
	</div>
	<div class="col-md-4"><span class="errmsg flash" id="errcourse_id" style="color: red;"></span></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Status</div>
	<div class="col-md-5">
		<select class="form-control" name="status" id="status"value="<?php echo $rsedit['status'];  ?>" >
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
	if(document.getElementById("template_title").value == "")
	{
		document.getElementById("errtemplate_title").innerHTML="Template Title should not be empty";
		i=1;
	}
	
	if(document.getElementById("category_id").value == "")
	{
		document.getElementById("errcategory_id").innerHTML="Kindly Select Category";
		i=1;
	}
	if(document.getElementById("course_id").value == "")
	{
		document.getElementById("errcourse_id").innerHTML="Kindly Select Program Id";
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
