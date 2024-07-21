<?php
include("header.php");
include("sidebar.php");

$sqlrec1= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Income' AND status='Active' AND (transdate BETWEEN '2020-03-01' AND '2020-03-31')";
$qsqlrec1 = mysqli_query($con,$sqlrec1);
$rsrec1 = mysqli_fetch_array($qsqlrec1);
$totrec1 = $rsrec1['totaincome'];


$sqlrec2= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Income' AND status='Active' AND (transdate BETWEEN '2020-04-01' AND '2020-04-31')";
$qsqlrec2 = mysqli_query($con,$sqlrec2);
$rsrec2 = mysqli_fetch_array($qsqlrec2);
$totrec2 = $rsrec2['totaincome'];


$sqlrec3= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Income' AND status='Active' AND (transdate BETWEEN '2020-05-01' AND '2020-05-31')";
$qsqlrec3 = mysqli_query($con,$sqlrec3);
$rsrec3 = mysqli_fetch_array($qsqlrec3);
$totrec3 = $rsrec3['totaincome'];


$sqlrec4= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Income' AND status='Active' AND (transdate BETWEEN '2020-06-01' AND '2020-06-31')";
$qsqlrec4 = mysqli_query($con,$sqlrec4);
$rsrec4 = mysqli_fetch_array($qsqlrec4);
$totrec4 = $rsrec4['totaincome'];


$sqlrec5= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Income' AND status='Active' AND (transdate BETWEEN '2020-07-01' AND '2020-07-31')";
$qsqlrec5 = mysqli_query($con,$sqlrec5);
$rsrec5 = mysqli_fetch_array($qsqlrec5);
$totrec5 = $rsrec5['totaincome'];


$sqlrec6= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Income' AND status='Active' AND (transdate BETWEEN '2020-08-01' AND '2020-08-31')";
$qsqlrec6 = mysqli_query($con,$sqlrec6);
$rsrec6 = mysqli_fetch_array($qsqlrec6);
$totrec6 = $rsrec6['totaincome'];


$sqlrec7= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Income' AND status='Active' AND (transdate BETWEEN '2020-09-01' AND '2020-09-31')";
$qsqlrec7 = mysqli_query($con,$sqlrec7);
$rsrec7 = mysqli_fetch_array($qsqlrec7);
$totrec7 = $rsrec7['totaincome'];

$sqlerec1= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Expense' AND status='Active' AND (transdate BETWEEN '2020-03-01' AND '2020-03-31')";
$qsqlerec1 = mysqli_query($con,$sqlerec1);
$rserec1 = mysqli_fetch_array($qsqlerec1);
$toterec1 = $rserec1['totaincome'];

$sqlrec2= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Expense' AND status='Active' AND (transdate BETWEEN '2020-04-01' AND '2020-04-31')";
$qsqlrec2 = mysqli_query($con,$sqlrec2);
$rsrec2 = mysqli_fetch_array($qsqlrec2);
$toterec2 = $rsrec2['totaincome'];

$sqlrec3= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Expense' AND status='Active' AND (transdate BETWEEN '2020-05-01' AND '2020-05-31')";
$qsqlrec3 = mysqli_query($con,$sqlrec3);
$rsrec3 = mysqli_fetch_array($qsqlrec3);
$toterec3 = $rsrec3['totaincome'];

$sqlrec4= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Expense' AND status='Active' AND (transdate BETWEEN '2020-06-01' AND '2020-06-31')";
$qsqlrec4 = mysqli_query($con,$sqlrec4);
$rsrec4 = mysqli_fetch_array($qsqlrec4);
$toterec4 = $rsrec4['totaincome'];

$sqlrec5= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Expense' AND status='Active' AND (transdate BETWEEN '2020-07-01' AND '2020-07-31')";
$qsqlrec5 = mysqli_query($con,$sqlrec5);
$rsrec5 = mysqli_fetch_array($qsqlrec5);
$toterec5 = $rsrec5['totaincome'];


$sqlrec6= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Expense' AND status='Active' AND (transdate BETWEEN '2020-08-01' AND '2020-08-31')";
$qsqlrec6 = mysqli_query($con,$sqlrec6);
$rsrec6 = mysqli_fetch_array($qsqlrec6);
$toterec6 = $rsrec6['totaincome'];


$sqlrec7= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Expense' AND status='Active' AND (transdate BETWEEN '2020-09-01' AND '2020-09-31')";
$qsqlrec7 = mysqli_query($con,$sqlrec7);
$rsrec7 = mysqli_fetch_array($qsqlrec7);
$toterec7 = $rsrec7['totaincome'];

 ?>
<input type="hidden" name="rec1" id="rec1" value="<?php echo $totrec1;  ?>" >
<input type="hidden" name="rec2" id="rec2" value="<?php echo $totrec2;  ?>" >
<input type="hidden" name="rec3" id="rec3" value="<?php echo $totrec3;  ?>" >
<input type="hidden" name="rec4" id="rec4" value="<?php echo $totrec4;  ?>" >
<input type="hidden" name="rec5" id="rec5" value="<?php echo $totrec5;  ?>" >
<input type="hidden" name="rec6" id="rec6" value="<?php echo $totrec6;  ?>" >
<input type="hidden" name="rec7" id="rec7" value="<?php echo $totrec7;  ?>" >

<input type="hidden" name="reca1" id="reca1" value="<?php echo $toterec1;  ?>" >
<input type="hidden" name="reca2" id="reca2" value="<?php echo $toterec2;  ?>" >
<input type="hidden" name="reca3" id="reca3" value="<?php echo $toterec3;  ?>" >
<input type="hidden" name="reca4" id="reca4" value="<?php echo $toterec4;  ?>" >
<input type="hidden" name="reca5" id="reca5" value="<?php echo $toterec5;  ?>" >
<input type="hidden" name="reca6" id="reca6" value="<?php echo $toterec6;  ?>" >
<input type="hidden" name="reca7" id="reca7" value="<?php echo $toterec7;  ?>" >

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Staff Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
		

          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>₹<?php
	$sqltransincome1 ="SELECT sum(totalamt) as totaincome FROM transaction WHERE accountid='3'";
	$sqltransincome1 = $sqltransincome1 . " AND employeeid='$_SESSION[employeeid]'";
		$qsqltransincome1 = mysqli_query($con,$sqltransincome1);
		$rstranincome1 = mysqli_fetch_array($qsqltransincome1);
		echo $totincome1 = $rstranincome1['totaincome'];
		 ?>
				</h3>
                <p>Total Salary Received</p>
              </div>
              <div class="icon">
                <i class="ion ion-briefcase"></i>
              </div>
              <a href="viewsalaryreport.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
		  
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>₹<?php
	$sqltransincome1 ="SELECT totalamt as totaincome FROM transaction WHERE accountid='3'";
	$sqltransincome1 = $sqltransincome1 . " AND employeeid='$_SESSION[employeeid]' ORDER BY transactionid DESC limit 1";
		$qsqltransincome1 = mysqli_query($con,$sqltransincome1);
		$rstranincome1 = mysqli_fetch_array($qsqltransincome1);
		echo $totincome1 = $rstranincome1['totaincome'];
		 ?></h3>
                <p>Last Salary</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="viewsalaryreport.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		  
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">

<?php
/*
         <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Income Expense Graph Chart</h3>
                  <a href="viewtransaction.php">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">₹<?php echo $totincome1 - $tottransexpense1;  ?></span>
                    <span>Income Expense Balance</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i>
<?php
	$dt = date("Y-m-d");
	$sqltransincome1= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Income' AND status='Active' AND transdate='$dt'";
	$qsqltransincome1 = mysqli_query($con,$sqltransincome1);
	$rstranincome1 = mysqli_fetch_array($qsqltransincome1);
	$totincome1 = $rstranincome1['totaincome'];
	$sqltransexpense1= "SELECT SUM(totalamt) as totaincome FROM transaction where transtype='Expense' AND status='Active' AND transdate='$dt'";
	$qsqltransexpense1 = mysqli_query($con,$sqltransexpense1);
	$rstransexpense1 = mysqli_fetch_array($qsqltransexpense1);
	$tottransexpense1 = $rstransexpense1['totaincome'];
 ?>
₹<?php echo $totincome1 - $tottransexpense1;  ?>
                    </span>
                    <span class="text-muted">Todays IE Balance</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Income
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Expense
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

		</div>
          <!-- /.col-md-6 -->
*/
?>

          </section>
          <!-- /.Left col -->
<?php
/*
		  <hr>
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-12 " style="visibility: hidden; height: 1px;">

            <!-- Map card -->
            <div class="card bg-gradient-primary">
              <!-- /.card-body-->
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <div id="sparkline-1"></div>
                    <div class="text-white">Visitors</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-2"></div>
                    <div class="text-white">Online</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-3"></div>
                    <div class="text-white">Sales</div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.card -->

          </section>
          <!-- right col -->
*/
?>	  
        </div>
        <!-- /.row (main row) -->
<?php
/*
        <div class="row" style="min-height: 10px;">
		
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php 
				$sql ="SELECT * FROM account";
				$qsql = mysqli_query($con,$sql);
				echo mysqli_num_rows($qsql);
				 ?></h3>
                <p>Accounts</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		  
		   <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php 
				$sql ="SELECT * FROM billing_template";
				$qsql = mysqli_query($con,$sql);
				echo mysqli_num_rows($qsql);
				 ?></h3>
                <p>Billing Template</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		  
		  <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php 
				$sql ="SELECT * FROM category";
				$qsql = mysqli_query($con,$sql);
				echo mysqli_num_rows($qsql);
				 ?></h3>
                <p>Category</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> 
		  
		   <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php 
				$sql ="SELECT * FROM course";
				$qsql = mysqli_query($con,$sql);
				echo mysqli_num_rows($qsql);
				 ?></h3>
                <p>Program</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		   <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php 
				$sql ="SELECT * FROM employee";
				$qsql = mysqli_query($con,$sql);
				echo mysqli_num_rows($qsql);
				 ?></h3>
                <p>Employee</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		   <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php 
				$sql ="SELECT * FROM incomeexpenserec";
				$qsql = mysqli_query($con,$sql);
				echo mysqli_num_rows($qsql);
				 ?></h3>
                <p>Income Expense Record</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		   <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php 
				$sql ="SELECT * FROM service";
				$qsql = mysqli_query($con,$sql);
				echo mysqli_num_rows($qsql);
				 ?></h3>
                <p>Service</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		   <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php 
				$sql ="SELECT * FROM student";
				$qsql = mysqli_query($con,$sql);
				echo mysqli_num_rows($qsql);
				 ?></h3>
                <p>Student</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		   <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php 
				$sql ="SELECT * FROM transaction";
				$qsql = mysqli_query($con,$sql);
				echo mysqli_num_rows($qsql);
				 ?></h3>
                <p>Transaction</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
	  </div>
*/
?>  
	  </div><!-- /.container-fluid -->
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
