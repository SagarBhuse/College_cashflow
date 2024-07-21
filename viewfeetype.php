<?php
include("header.php");
include("sidebar.php");
if(isset($_GET['delid']))
{
	$sql ="DELETE FROM service where serviceid='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Service record deleted successfully...');</script>";
		echo "<script>window.location='viewfeetype.php?feetype=$_GET[feetype]';</script>";
	}
}
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
<form method="post" action="">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">View  Fee Types</h3>
        </div>
        <div class="card-body">
<form method="POST" action="">		
<table class="table table-striped table-bordered" >
	<tr>
		<th>Select Program</th>
		<td>
		<select  name="courseidsearch" id="courseidsearch" class="form-control">
			<option value=''>Select Program</option>
			<?php
			$sqlcourse = "SELECT * FROM course WHERE status='Active'";
			$qsqlcourse = mysqli_query($con,$sqlcourse);
			while($rscourse = mysqli_fetch_array($qsqlcourse))
			{
				if($rscourse['courseid'] == $_POST['courseidsearch'])
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
<hr>
<table id="myTable"  class="table table-striped table-bordered" >
	<thead>
		<tr>
		    <th>Program</th>
		    <th>Fee Type</th>
			<th>Service Title</th>
			<th>Service Description</th>
			<th style='text-align: right;'>Fee Amount</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql ="SELECT service.*, course.programcode, course.course FROM service LEFT JOIN course ON service.courseid=course.courseid WHERE service.servicetype='Student Fees'";
	if($_POST['courseidsearch'] != '')
	{
		$sql = $sql . " AND  service.courseid='$_POST[courseidsearch]'";
	}
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		echo "<tr>
				<td>$rs[course] ($rs[programcode])</td>
				<td>$rs[servicetype]</td>
				<td>$rs[servicetitle]</td>
				<td>$rs[servicedescription]</td>
				<td style='text-align: right;'>₹$rs[servicecost]</td>
				<td>$rs[status]</td>
				<td>
				<a href='feetype.php?editid=$rs[0]&feetype=$_GET[feetype]' class='btn btn-info' >Edit</a>
				| 
				<a href='viewfeetype.php?delid=$rs[0]&feetype=$_GET[feetype]' onclick='return validatedel()'  class='btn btn-danger' >Delete</a>
				
				</td>
			</tr>";
	}
	 ?>
	</tbody>
</table>
        </div>
        <!-- /.card-body -->

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