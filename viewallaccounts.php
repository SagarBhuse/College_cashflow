<?php
include("header.php");
include("sidebar.php");
if(isset($_GET['delid']))
{
	$sql ="DELETE FROM account where accountid='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Account record deleted successfully...');</script>";
		echo "<script>window.location='viewaccount.php';</script>";
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
<form method="post" action="">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">View  Account Details</h3>
        </div>
        <div class="card-body">
<table id="myTable"  class="table table-striped table-bordered" >
	<thead>
		<tr>
			<th>Account type</th>
			<th style='text-align: right;'>Income</th>
			<th style='text-align: right;'>Expense</th>
			<th style='text-align: right;'>Balance</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sumincome = 0;
	$sumexpense = 0;
	$sql ="SELECT * FROM account";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		$totincome =0; $totexpense=0;$balincexp=0;
		$sqltransincome= "SELECT ifnull(SUM(totalamt),0) FROM transaction where accountid='$rs[accountid]' AND transtype='Income'";
		$qsqltransincome = mysqli_query($con,$sqltransincome);
		$rstranincome = mysqli_fetch_array($qsqltransincome);
		$totincome = $rstranincome[0];
		$sqltransexpense= "SELECT ifnull(SUM(totalamt),0) FROM transaction where accountid='$rs[accountid]' AND transtype='Expense'";
		$qsqltransexpense = mysqli_query($con,$sqltransexpense);
		$rstranexpense = mysqli_fetch_array($qsqltransexpense);
		$totexpense = $rstranexpense[0];
		$sqlPayroll= "SELECT SUM(totalamt) FROM transaction where accountid='$rs[accountid]' AND transtype='Payroll'";
		$qsqlPayroll = mysqli_query($con,$sqlPayroll);
		$rsPayroll = mysqli_fetch_array($qsqlPayroll);
		$totpayroll= $rsPayroll[0];
		$balincexp = $totincome - ($totexpense + $totpayroll);
		echo "<tr>
				<td>$rs[accounttype]</td>
				<td style='text-align: right;'>₹$totincome</td>
				<td style='text-align: right;'>₹$totexpense</td>
				<td style='text-align: right;'>₹$balincexp</td>
				<td style='width: 120px;text-align: right;'><a href='viewietransaction.php?accountid=$rs[0]' class='btn btn-info'>View More</a>";
		echo "</td></tr>";
		$gtotal = $gtotal + $balincexp;
		$sumincome  =$sumincome + $totincome;
		$sumexpense = $sumexpense + $totexpense;
	}
	 ?>
	</tbody>
	<tfoot>
			<tr>
			<th>Total Balance</th>
			<th style="text-align: right;">₹<?php echo $sumincome;  ?></th>
			<th style="text-align: right;">₹<?php echo $sumexpense;  ?></th>
			<th style="text-align: right;">₹<?php echo $gtotal;  ?></th>
			<th></th>
		</tr>
	</tfoot>
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