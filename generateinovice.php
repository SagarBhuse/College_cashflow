<?php
include("header.php");
include("sidebar.php");
if(isset($_POST['btnsubmit']))
{
	$sql ="SELECT service.*, course.programcode, course.course FROM service LEFT JOIN course ON service.courseid=course.courseid WHERE service.servicetype='Student Fees' AND service.courseid='$_GET[courseid]' AND service.status='Active' ORDER BY servicecost DESC";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	$i = 0;
	while($rs = mysqli_fetch_array($qsql))
	{
		$fee['servicetitle'][$i] = $rs['servicetitle'];
		$fee['servicedescription'][$i] = $rs['servicedescription'];
		$fee['servicecost'][$i] = $rs['servicecost'];
		$i++;
	}
	$arrfeeservice = serialize(array($fee['servicetitle'],$fee['servicedescription'],$fee['servicecost']));
	$sql ="SELECT student.*,course.course FROM student LEFT JOIN course ON student.courseid=course.courseid WHERE course.courseid='$_GET[courseid]' AND student.status='Active'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	while($rs = mysqli_fetch_array($qsql))
	{
		$sqltransaction ="SELECT * FROM transaction where billno='$rs[0]' AND transtype='Invoice' AND billingtype='Invoice'";
		$qsqltransaction = mysqli_query($con,$sqltransaction);
		if(mysqli_num_rows($qsqltransaction) == 0)
		{
			$studentid = $rs[0];
			$sqlinsert = "INSERT INTO transaction(categoryid,transtype,billingtype,billno,totalamt,transdate,accountid,transdetails,paymentdetail,status) VALUES('0','Invoice','Invoice','$studentid','$_POST[totamt]','$dt','1','Invoice','Invoice','Active')";
			$qsqlinsert = mysqli_query($con,$sqlinsert);
			$insid = mysqli_insert_id($con);
			$sqlbilling_template ="INSERT INTO billing_template(template_type,template_title,category_id,course_id,status,transactionid,studentid,template) values('Student Fees','Student Fees','0','0','Active','$insid','$studentid','$arrfeeservice')";
			$qsqlbilling_template = mysqli_query($con,$sqlbilling_template);
		}		
	}
	echo "<script>alert('Bill Invoice generated successfully...');</script>";
	echo "<script>window.location='viewinvoice.php';</script>";
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
<form method="get" action="">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Select Program to Generate Invoice</h3>
        </div>
        <div class="card-body">
		
<div class="row">
	<div class="col-md-6">Program
		<select  name="courseid" id="courseid" class="form-control">
		<option value=''>Select Program</option>
		<?php
		$sqlcourse = "SELECT * FROM course WHERE status='Active'";
		$qsqlcourse = mysqli_query($con,$sqlcourse);
		while($rscourse = mysqli_fetch_array($qsqlcourse))
		{
			if($rscourse['courseid'] == $_GET['courseid'])
			{
			echo "<option value='$rscourse[courseid]' selected>$rscourse[course]</option>";
			}
			else
			{
			echo "<option value='$rscourse[courseid]'>$rscourse[course]</option>";
			}
		}
		 ?>
		</select><span class="errmsg flash" id="errcourseid" style="color: red;"></span>
	</div>
	<div class="col-md-6"></div>
</div>
<br>

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

<?php
if(isset($_GET['courseid']))
{
 ?>
    <!-- Main content -->
    <section class="content">
	<hr>
	
<form method="post" action="">
<input type="hidden" name="courseid" id="courseid" value="<?php echo $_GET['courseid'];  ?>" >
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">View
<?php
$sqlcourse = "SELECT * FROM course WHERE status='Active' AND courseid='$_GET[courseid]'";
$qsqlcourse = mysqli_query($con,$sqlcourse);
$rscourse = mysqli_fetch_array($qsqlcourse);
echo $rscourse['course'] . "(" . $rscourse['programcode'] . ")";
 ?>
		  Student List</h3>
        </div>
        <div class="card-body">
<table id="myTable"  class="table table-striped table-bordered" >
	<thead>
		<tr>
		    <th>Student Name</th>
			<th>Registration<br>Number</th>
			<th>Class</th>
			<th>Contact Detail</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql ="SELECT student.*,course.course FROM student LEFT JOIN course ON student.courseid=course.courseid WHERE course.courseid='$_GET[courseid]' AND student.status='Active'";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		$sqltransaction ="SELECT * FROM transaction where billno='$rs[0]' AND transtype='Invoice' AND billingtype='Invoice'";
		$qsqltransaction = mysqli_query($con,$sqltransaction);
		if(mysqli_num_rows($qsqltransaction) == 0)
		{
			echo "<tr>
				<td>$rs[studentname]</td>
				<td>$rs[regno]</td>
				<td><b>Program:</b> $rs[course]<br>
				<b>Semester:</b> $rs[semester]</td>
				<td><b>Email-</b> $rs[email]<br><b>Ph. No.</b> $rs[contactno]</td>

			</tr>";
		}
	}
	 ?>
	</tbody>
</table>
        </div>
        <!-- /.card-body -->

      </div>
      <!-- /.card -->
	</section>
    <!-- /.content -->
    <!-- /.########################################## -->
	    <!-- Main content -->
    <section class="content">
	<hr>
	
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">View Fee List</h3>
        </div>
        <div class="card-body">
<table id="myTable"  class="table table-striped table-bordered" >
	<thead>
		<tr>
			<th>Service Title</th>
			<th>Service Description</th>
			<th style='text-align: right;width: 150px;'>Fee Amount</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$amt =0;
	$sql ="SELECT service.*, course.programcode, course.course FROM service LEFT JOIN course ON service.courseid=course.courseid WHERE service.servicetype='Student Fees' AND service.courseid='$_GET[courseid]' AND service.status='Active' ORDER BY servicecost DESC";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		echo "<tr>
				<td>$rs[servicetitle]</td>
				<td>$rs[servicedescription]</td>
				<td style='text-align: right;'>₹$rs[servicecost]</td>

			</tr>";
			$amt = $amt + $rs['servicecost'];
	}
	 ?>
	</tbody>
	<tfoot>
		<tr>
			<th></th>
			<th style='text-align: right;'>Total Amount</th>
			<th style='text-align: right;width: 150px;'>₹<?php echo $amt;  ?>
<input type="hidden" name="totamt" id="totamt" value="<?php echo $amt;  ?>" >
			</th>
		</tr>
	</tfoot>
</table>
        </div>
        <!-- /.card-body -->

      </div>
      <!-- /.card -->

	</section>
    <!-- /.content -->
    <!-- /.########################################## -->
	
	
	    <section class="content">
	<hr>
	
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Confirm to Generate Invoice</h3>
        </div>
        <div class="card-body">
			<center><input type="submit" name="btnsubmit" id="btnsubmit" value="Click here to Generate Invoice" class="btn btn-info" ></center>
        </div>
        <!-- /.card-body -->

      </div>
      <!-- /.card -->
</form>
    
	</section>
    <!-- /.content -->
    <!-- /.########################################## -->
<?php
}
 ?>	




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
<script src="js/jquery.dataTables.min.js"></script>
<script>
$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
<script>
function validatedel()
{
	if(confirm("Are you sure want to delete this record?") == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>