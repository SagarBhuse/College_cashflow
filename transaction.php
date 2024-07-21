<?php
include("header.php");
include("sidebar.php");
if(isset($_POST['submit']))
{
	$sql ="INSERT INTO transaction(transtype,billingtype,billno,totalamt,transdate,accountid,transdetails,paymentdetail,status) values('$_POST[transtype]','$_POST[billingtype]','$_POST[billno]','$_POST[totalamt]','$_POST[transdate]','$_POST[accountid]','$_POST[transdetails]','$_POST[paymentdetail]','$_POST[status]')";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) ==1)
	{
		echo "<script>alert('Service record inserted successfully...');</script>";
		echo "<script>window.location='service.php';</script>";
	}
	else
	{
		echo mysqli_error($con);
	}
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
          <h3 class="card-title">Transaction Master</h3>
        </div>
        <div class="card-body">
		
<div class="row">
	<div class="col-md-3">Transaction Type</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="transtype" id="transtype">
	</div>
	<div class="col-md-4"></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Bill NO</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="billno" id="billno">
	</div>
	<div class="col-md-4"></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Total Amount</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="	totalamt" id="totalamt">
	</div>
	<div class="col-md-4"></div>
</div>
<br>	
<div class="row">
	<div class="col-md-3">Transaction Date</div>
	<div class="col-md-5">
		<input type="date"  class="form-control" name="transdate" id="transdate">
	</div>
	<div class="col-md-4"></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Account ID</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="accountid" id="accountid">
	</div>
	<div class="col-md-4"></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Transaction Details</div>
	<div class="col-md-5">
		<textarea class="form-control" name="	transdetails" id="transdetails"></textarea>
	</div>
	<div class="col-md-4"></div>
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
	<div class="col-md-4"></div>
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
