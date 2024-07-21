<?php
include("header.php");
include("sidebar.php");
//#############################################################
if(isset($_GET['submitsalary']))
{
	$itrans=0;
	$sqltransaction = "SELECT * FROM transaction WHERE transtype='Payroll' AND status='Active' AND transdetails='$_GET[salarymonth]'";
	$qsqltransaction = mysqli_query($con,$sqltransaction);
	if(mysqli_num_rows($qsqltransaction) >= 1)
	{
		$itrans=1;
		echo "<script>alert('Salary Report Already Generated...');</script>";
	}
	else
	{
		/*
		//Delete Pending Record Starts here
		$sqldelete = "DELETE FROM transaction WHERE transtype='Payroll' AND status='Pending'";
		$qsqldelete = mysqli_query($con,$sqldelete);
		//Delete Pending Record Ends here
		//Delete Pending Record Starts here
		$sqldelete = "DELETE FROM billing_template WHERE status='Pending' AND template_type='Payroll'";
		$qsqldelete = mysqli_query($con,$sqldelete);
		//Delete Pending Record Ends here
		*/
		//##############################################################		
		$sql ="SELECT * FROM employee WHERE emptype IN('Principal','Professor','HOD','Lecturer','Librarian','Computer Instructor','Lab Assistant','Office Peon','Security Man','Cleaner','Others') AND status='Active' ORDER BY employeeid";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		$i=0;
		while($rs = mysqli_fetch_array($qsql))
		{
			$template = serialize(array($rs['employeeid'],$_GET['salarymonth'],$_GET['salarydate'],$rs['empname'],$rs['empcode'],$rs['emptype'],$_POST['pfno'][$i],$_POST['grade'][$i],$_POST['bankacno'][$i],$_POST['department'][$i],$_POST['dateofjoining'][$i],$_POST['workingdays'][$i],$_POST['dayspayable'][$i],$_POST['earning1'][$i],$_POST['earning2'][$i],$_POST['earning3'][$i],$_POST['earning4'][$i],$_POST['earning5'][$i],$_POST['earning6'][$i],$_POST['earning7'][$i],$_POST['earning1amt'][$i],$_POST['earning2amt'][$i],$_POST['earning3amt'][$i],$_POST['earning4amt'][$i],$_POST['earning5amt'][$i],$_POST['earning6amt'][$i],$_POST['earning7amt'][$i],$_POST['earning8amt'][$i],$_POST['deduction1'][$i],$_POST['deduction2'][$i],$_POST['deduction3'][$i],$_POST['deduction4'][$i],$_POST['deduction5'][$i],$_POST['deduction6'][$i],$_POST['deduction7'][$i],$_POST['deduction8'][$i],$_POST['deduction1amt'][$i],$_POST['deduction2amt'][$i],$_POST['deduction3amt'][$i],$_POST['deduction4amt'][$i],$_POST['deduction5amt'][$i],$_POST['deduction6amt'][$i],$_POST['deduction7amt'][$i],$_POST['deduction8amt'][$i],$_POST['totalearnings'][$i],$_POST['totaldeductions'][$i],$_POST['netpay'][$i]));
			$transdetails=$_GET['salarymonth'];
			//transaction
			$sqltransaction ="INSERT INTO transaction(transtype,billingtype,billno,totalamt,transdate,accountid,transdetails,paymentdetail,status,categoryid,employeeid) values('Payroll','General','0','$_POST[icost]','$_GET[salarydate]','3','$transdetails','$template','Active','0','$rs[employeeid]')";
			$qsqltransaction = mysqli_query($con,$sqltransaction);
			$insid = mysqli_insert_id($con);
			//billing_template
			$sqlinsertsal ="INSERT INTO billing_template(template_type,transactionid, employeeid, template_title, template, category_id, course_id, status) values('Payroll','$insid','$rs[employeeid]','$_GET[salarymonth]','$template','0','0','Pending')";
			$qsqlinsertsal = mysqli_query($con,$sqlinsertsal);
			echo mysqli_error($con);
			$i = $i + 1;
		}
			echo "<script>alert('Salary Report Loading completed...');</script>";
		//echo "<script>window.location='generatesalary.php?salarymonth=$_POST[salarymonth]';</script>";
		//##############################################################
	}
}
//#############################################################
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
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Generate Salary   </h3>
        </div>
        <div class="card-body">
<form method="get" action="" >
	<table id="myTable1"  class="table table-striped table-bordered" >
		<tr>
		    <th style="width: 150px;">Salary Month</th><td><input type="month" name="salarymonth" id="salarymonth" value="<?php 
			if(isset($_GET['salarymonth']))
			{
				echo $_GET['salarymonth'];
			}
			else
			{
				echo date("Y-m");  
			}
			?>" max="<?php 
			echo date("Y-m");
			?>" class="form-control" <?php
if(isset($_GET['submitsalary']))
{
	echo  " readonly ";
}
?> ></td><th style="width: 150px;">Payment Date</th><td><input type="date" name="salarydate" id="salarydate" value="<?php
			if(isset($_GET['salarydate']))
			{
				echo $_GET['salarydate'];
			}
			else
			{
				echo date("Y-m-d"); 
			}
			?>" max="<?php echo date("Y-m-d");  ?>" class="form-control" <?php
if(isset($_GET['submitsalary']))
{
	echo  " readonly ";
}
?> ></td>
		</tr>
<?php
if(!isset($_GET['submitsalary']))
{
?>
		<tr>
		    <th colspan="4"><center><input type="submit" id="submitsalary" name="submitsalary" class="btn btn-info" value="Load Salary Report"></center></th></td>
		</tr>
<?php
}
?>
	</table>
	<hr>
</form>
<?php
if(isset($_GET['submitsalary']))
{
 ?>
<form method="POST" action="">
<input type="hidden" name="selectedsalarymonth" id="selectedsalarymonth" value="<?php echo $_GET['salarymonth'];  ?>" class="form-control" >
<input type="hidden" name="selectedsalarydate" id="selectedsalarydate" value="<?php echo $_GET['salarydate'];  ?>"  class="form-control" > 
	<table id="myTable" >
		<thead><tr><th></th></tr></thead>
		<tbody>
	<?php
	$sql ="SELECT * FROM employee WHERE emptype IN('Principal','Professor','HOD','Lecturer','Librarian','Computer Instructor','Lab Assistant','Office Peon','Security Man','Cleaner','Others') AND status='Active' ORDER BY employeeid";
		$qsql = mysqli_query($con,$sql);
		$j=0;
		while($rs = mysqli_fetch_array($qsql))
		{
				$sqlempsaldet = "SELECT * FROM transaction WHERE transdetails='$_GET[salarymonth]' AND employeeid='$rs[0]' ";
				$qsqlempsaldet = mysqli_query($con,$sqlempsaldet);
				$rsempsaldet = mysqli_fetch_array($qsqlempsaldet);
			if($itrans == 1)
			{
				$sqlpresaldet = "SELECT * FROM transaction WHERE transdetails='$_GET[salarymonth]' AND employeeid='$rs[0]' ";
				$qsqlpresaldet = mysqli_query($con,$sqlpresaldet);
				$rspresaldet = mysqli_fetch_array($qsqlpresaldet);
				$templatec = unserialize($rspresaldet['paymentdetail']);
			}
			else
			{
			}
	 ?>
			<tr>
				<td>
<input type="hidden" name="empid" id="empid" value="<?php echo $rs['employeeid'];  ?>"> 
<input type="hidden" name="employeeid[<?php echo $j;  ?>]" id="employeeid[<?php echo $rs['employeeid'];  ?>]" value="<?php echo $rs['employeeid'];  ?>">
<input type="hidden" name="transactionid[<?php echo $j;  ?>]" id="transactionid[<?php echo $rs['employeeid'];  ?>]" value="<?php echo $rsempsaldet['transactionid'];  ?>">
			<table id="myTable1"  style="width: 100%;" class="table table-striped table-bordered" >
			<tr>
				<th style="width: 150px;">Name</th><td><input type="text" name="empname[<?php echo $j;  ?>]" id="empname[<?php echo $rs['employeeid'];  ?>]" value="<?php echo $rs['empname'];  ?>" class="form-control" readonly ></td><th style="width: 150px;">Employee Code</th><td><input type="text" name="empcode[<?php echo $j;  ?>]" id="empcode[<?php echo $rs['employeeid'];  ?>]" value="<?php echo $rs['empcode'];  ?>" class="form-control" readonly ></td>
			</tr>
			<tr>
				<th>Designation</th><td><input type="text" name="emptype[<?php echo $j;  ?>]" id="emptype[<?php echo $rs['employeeid'];  ?>]" value="<?php echo $rs['emptype'];  ?>" class="form-control" readonly ></td><th>PF No</th><td><input type="text" name="pfno[<?php echo $j;  ?>]" id="pfno[<?php echo $rs['employeeid'];  ?>]" value="<?php echo $templatec[6]; ?>" class="form-control" onkeyup="funupdatedb()" ></td>
			</tr>
			<tr>
				<th>Grade</th><td><input type="text" name="grade[<?php echo $j;  ?>]" id="grade[<?php echo $rs['employeeid'];  ?>]" class="form-control"  value="<?php echo $templatec[7]; ?>" ></td><th>Bank A/c No</th><td><input type="text" name="bankacno[<?php echo $j;  ?>]" id="bankacno[<?php echo $rs['employeeid'];  ?>]"  value="<?php echo $templatec[8]; ?>" class="form-control"  onkeyup="funupdatedb()" ></td>
			</tr>
			<tr>
				<th>Department</th><td><input type="text" name="department[<?php echo $j;  ?>]" id="department[<?php echo $rs['employeeid'];  ?>]" value="<?php echo $templatec[9]; ?>"  class="form-control" ></td><th>Date of Joining</th><td><input type="date" name="dateofjoining[<?php echo $j;  ?>]" id="dateofjoining[<?php echo $rs['employeeid'];  ?>]"  value="<?php echo $templatec[10]; ?>"  class="form-control"  onkeyup="funupdatedb()" ></td>
			</tr>
			<tr>
				<th>Working days</th><td><input type="number" name="workingdays[<?php echo $j;  ?>]" id="workingdays[<?php echo $rs['employeeid'];  ?>]"  value="<?php echo $templatec[11]; ?>"  class="form-control" ></td><th>Days Payable</th><td><input type="number" name="dayspayable[<?php echo $j;  ?>]" id="dayspayable[<?php echo $rs['employeeid'];  ?>]"  value="<?php echo $templatec[12]; ?>"  class="form-control" onkeyup="funupdatedb()"  ></td>
			</tr>
		</table>
		<hr>
		<table id="myTable1"  style="width: 100%;" class="table table-striped table-bordered" >
			<tbody>
				<tr>
					<th>Earnings</th><th style="width: 150px;text-align: right;">Amount</th><th>Deduction</th><th style="width: 150px;text-align: right;">Amount</th>
				</tr>
				<tr>
					<td><input type="text" name="earning1[<?php echo $j;  ?>]" id="earning1[<?php echo $rs['employeeid'];  ?>]" value="Basic" class="form-control" readonly></td><td  style="width: 150px;text-align: right;"><input type="text" name="earning1amt[<?php echo $j;  ?>]" id="earning1amt[<?php echo $rs['employeeid'];  ?>]" class="form-control" onchange="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"  value="<?php echo $templatec[21]; ?>"  ></td>
					<td><input type="text" name="deduction1[<?php echo $j;  ?>]" id="deduction1[<?php echo $rs['employeeid'];  ?>]" value="LOP" class="form-control" readonly   value="<?php echo $templatec[29]; ?>" ></td><td style="width: 150px;text-align: right;"><input type="text" name="deduction1amt[<?php echo $j;  ?>]" id="deduction1amt[<?php echo $rs['employeeid'];  ?>]" class="form-control" onchange="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"   value="<?php echo $templatec[37]; ?>" ></td>
				</tr>
				<tr>
					<td><input type="text" name="earning2[<?php echo $j;  ?>]" id="earning2[<?php echo $rs['employeeid'];  ?>]" class="form-control" onkeyup="funupdatedb()"   value="<?php echo $templatec[14]; ?>" ></td><td  style="width: 150px;text-align: right;"><input type="text" name="earning2amt[<?php echo $j;  ?>]" id="earning2amt[<?php echo $rs['employeeid'];  ?>]" class="form-control"  onchange="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"   value="<?php echo $templatec[22]; ?>" ></td>
					<td><input type="text" name="deduction2[<?php echo $j;  ?>]" id="deduction2[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onkeyup="funupdatedb()"   value="<?php echo $templatec[30]; ?>" ></td><td style="width: 150px;text-align: right;"><input type="text" name="deduction2amt[<?php echo $j;  ?>]" id="deduction2amt[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onchange="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"  value="<?php echo $templatec[38]; ?>"  ></td>
				</tr>
				<tr>
					<td><input type="text" name="earning3[<?php echo $j;  ?>]" id="earning3[<?php echo $rs['employeeid'];  ?>]"  class="form-control" onkeyup="funupdatedb()"   value="<?php echo $templatec[15]; ?>"  ></td><td  style="width: 150px;text-align: right;"><input type="text" name="earning3amt[<?php echo $j;  ?>]" id="earning3amt[<?php echo $rs['employeeid'];  ?>]"  class="form-control" onchange="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"    value="<?php echo $templatec[23]; ?>" ></td>
					<td><input type="text" name="deduction3[<?php echo $j;  ?>]" id="deduction3[<?php echo $rs['employeeid'];  ?>]"  class="form-control" onkeyup="funupdatedb()"   value="<?php echo $templatec[31]; ?>"  ></td><td style="width: 150px;text-align: right;"><input type="text" name="deduction3amt[<?php echo $j;  ?>]" id="deduction3amt[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onchange="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"  value="<?php echo $templatec[39]; ?>"  ></td>
				</tr>
				<tr>
					<td><input type="text" name="earning4[<?php echo $j;  ?>]" id="earning4[<?php echo $rs['employeeid'];  ?>]"  class="form-control" onkeyup="funupdatedb()" value="<?php echo $templatec[16]; ?>"   ></td><td  style="width: 150px;text-align: right;"><input type="text" name="earning4amt[<?php echo $j;  ?>]" id="earning4amt[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onchange="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"   value="<?php echo $templatec[24]; ?>" ></td>
					<td><input type="text" name="deduction4[<?php echo $j;  ?>]" id="deduction4[<?php echo $rs['employeeid'];  ?>]"  class="form-control" onkeyup="funupdatedb()"   value="<?php echo $templatec[32]; ?>"  ></td><td style="width: 150px;text-align: right;"><input type="text" name="deduction4amt[<?php echo $j;  ?>]" id="deduction4amt[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onchange="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"   value="<?php echo $templatec[40]; ?>" ></td>
				</tr>
				<tr>
					<td><input type="text" name="earning5[<?php echo $j;  ?>]" id="earning5[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onkeyup="funupdatedb()" value="<?php echo $templatec[17]; ?>"  ></td><td  style="width: 150px;text-align: right;"><input type="text" name="earning5amt[<?php echo $j;  ?>]" id="earning5amt[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onchange="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"   value="<?php echo $templatec[25]; ?>" ></td>
					<td><input type="text" name="deduction5[<?php echo $j;  ?>]" id="deduction5[<?php echo $rs['employeeid'];  ?>]"  class="form-control" onkeyup="funupdatedb()"   value="<?php echo $templatec[33]; ?>"  ></td><td style="width: 150px;text-align: right;"><input type="text" name="deduction5amt[<?php echo $j;  ?>]" id="deduction5amt[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onchange="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"   value="<?php echo $templatec[41]; ?>" ></td>
				</tr>
				<tr>
					<td><input type="text" name="earning6[<?php echo $j;  ?>]" id="earning6[<?php echo $rs['employeeid'];  ?>]"  class="form-control" onkeyup="funupdatedb()"  value="<?php echo $templatec[18]; ?>"  ></td><td  style="width: 150px;text-align: right;"><input type="text" name="earning6amt[<?php echo $j;  ?>]" id="earning6amt[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onchange="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"  value="<?php echo $templatec[26]; ?>"  ></td>
					<td><input type="text" name="deduction6[<?php echo $j;  ?>]" id="deduction6[<?php echo $rs['employeeid'];  ?>]"  class="form-control" onkeyup="funupdatedb()"   value="<?php echo $templatec[34]; ?>"  ></td><td style="width: 150px;text-align: right;"><input type="text" name="deduction6amt[<?php echo $j;  ?>]" id="deduction6amt[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onchange="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"   value="<?php echo $templatec[42]; ?>" ></td>
				</tr>
				<tr>
					<td><input type="text" name="earning7[<?php echo $j;  ?>]" id="earning7[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onkeyup="funupdatedb()"  value="<?php echo $templatec[19]; ?>" ></td><td  style="width: 150px;text-align: right;"><input type="text" name="earning7amt[<?php echo $j;  ?>]" id="earning7amt[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onchange="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"   value="<?php echo $templatec[27]; ?>" ></td>
					<td><input type="text" name="deduction7[<?php echo $j;  ?>]" id="deduction7[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onkeyup="funupdatedb()"   value="<?php echo $templatec[35]; ?>"  ></td><td style="width: 150px;text-align: right;"><input type="text" name="deduction7amt[<?php echo $j;  ?>]" id="deduction7amt[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onchange="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"   value="<?php echo $templatec[43]; ?>" ></td>
				</tr>
				<tr>
					<td><input type="text" name="earning8[<?php echo $j;  ?>]" id="earning8[<?php echo $rs['employeeid'];  ?>]"  class="form-control" onkeyup="funupdatedb()" value="<?php echo $templatec[20]; ?>"   ></td><td  style="width: 150px;text-align: right;"><input type="text" name="earning8amt[<?php echo $j;  ?>]" id="earning8amt[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onchange="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotalearnings(<?php echo $rs['employeeid'];  ?>)"   value="<?php echo $templatec[28]; ?>" ></td>
					<td><input type="text" name="deduction8[<?php echo $j;  ?>]" id="deduction8[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onkeyup="funupdatedb()"   value="<?php echo $templatec[36]; ?>" ></td><td style="width: 150px;text-align: right;"><input type="text" name="deduction8amt[<?php echo $j;  ?>]" id="deduction8amt[<?php echo $rs['employeeid'];  ?>]"  class="form-control"  onchange="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"  onkeyup="calculatetotaldeductions(<?php echo $rs['employeeid'];  ?>)"   value="<?php echo $templatec[44]; ?>" ></td>
				</tr>
				

				
				<tr style="background-color: #d4dee8;">
					<th>Total Earnings</th><td><input type="text" name="totalearnings[<?php echo $j;  ?>]" id="totalearnings[<?php echo $rs['employeeid'];  ?>]" class="form-control" readonly onchange="funupdatedb()"   value="<?php echo $templatec[45]; ?>"  ></td><th>Total Deduction</th><td><input type="text" name="totaldeductions[<?php echo $j;  ?>]" id="totaldeductions[<?php echo $rs['employeeid'];  ?>]" class="form-control" readonly onchange="funupdatedb()"   value="<?php echo $templatec[46]; ?>"  ></td>
				</tr>
				<tr>
					<th></th><th></th><th><center>Net Pay : <span id="idnetpay[<?php echo $rs['employeeid'];  ?>]"></span></th><th ><input type="text" name="netpay[<?php echo $j;  ?>]" id="netpay[<?php echo $rs['employeeid'];  ?>]" readonly class="form-control"  onchange="funupdatedb()"   value="<?php echo $templatec[47]; ?>" ></center></th></td>
				</tr>
			</tbody>
		</table>
	</td>
	</tr>
	<?php
	$j = $j +1;
		}
	 ?>
		</table>

</form>
<?php
}
 ?>
</div>
        <!-- /.card-body -->

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
<script src="js/jquery.dataTables.min.js"></script>

<script>
$(document).ready( function () {
    $('#myTable').DataTable( {
		"bLengthChange" : false,
		"pageLength": 1,
		"searching": false,
		 "dom" : "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-5'i><'col-sm-7'p>>",
	});
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
<script>
function calculatetotalearnings(employeeid)
{
	val1 = 0;
	val2 = 0;
	val3 = 0;
	val4 = 0;
	val5 = 0;
	val6 = 0;
	val7 = 0;
	val8 = 0;
	if(parseFloat(document.getElementById("earning1amt[" + employeeid + "]").value) >=1)
	{
		val1 = parseFloat(document.getElementById("earning1amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("earning2amt[" + employeeid + "]").value)  >=1)
	{
		val2 = parseFloat(document.getElementById("earning2amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("earning3amt[" + employeeid + "]").value ) >=1)
	{
		val3 = parseFloat(document.getElementById("earning3amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("earning4amt[" + employeeid + "]").value ) >=1)
	{
		
		val4 = parseFloat(document.getElementById("earning4amt[" + employeeid + "]").value);
	}	
	if(parseFloat(document.getElementById("earning5amt[" + employeeid + "]").value)  >=1)
	{
		val5 = parseFloat(document.getElementById("earning5amt[" + employeeid + "]").value);
	}	
	if(parseFloat(document.getElementById("earning6amt[" + employeeid + "]").value ) >=1)
	{
		val6 = parseFloat(document.getElementById("earning6amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("earning7amt[" + employeeid + "]").value) >=1)
	{
		val7 = parseFloat(document.getElementById("earning7amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("earning8amt[" + employeeid + "]").value)>=1)
	{
		val8 = parseFloat(document.getElementById("earning8amt[" + employeeid + "]").value);
	}
	document.getElementById("totalearnings[" + employeeid + "]").value =  val1 + val2 + val3 + val4 + val5 + val6 + val7 + val8;
	calculatenetsalary(employeeid);
}
</script>
<script>
function calculatetotaldeductions(employeeid)
{
	//deduction1amt
	val1 = 0;
	val2 = 0;
	val3 = 0;
	val4 = 0;
	val5 = 0;
	val6 = 0;
	val7 = 0;
	val8 = 0;
	if(parseFloat(document.getElementById("deduction1amt[" + employeeid + "]").value) >=1)
	{
		val1 = parseFloat(document.getElementById("deduction1amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("deduction2amt[" + employeeid + "]").value)  >=1)
	{
		val2 = parseFloat(document.getElementById("deduction2amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("deduction3amt[" + employeeid + "]").value ) >=1)
	{
		val3 = parseFloat(document.getElementById("deduction3amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("deduction4amt[" + employeeid + "]").value ) >=1)
	{
		
		val4 = parseFloat(document.getElementById("deduction4amt[" + employeeid + "]").value);
	}	
	if(parseFloat(document.getElementById("deduction5amt[" + employeeid + "]").value)  >=1)
	{
		val5 = parseFloat(document.getElementById("deduction5amt[" + employeeid + "]").value);
	}	
	if(parseFloat(document.getElementById("deduction6amt[" + employeeid + "]").value ) >=1)
	{
		val6 = parseFloat(document.getElementById("deduction6amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("deduction7amt[" + employeeid + "]").value) >=1)
	{
		val7 = parseFloat(document.getElementById("deduction7amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("deduction8amt[" + employeeid + "]").value)>=1)
	{
		val8 = parseFloat(document.getElementById("deduction8amt[" + employeeid + "]").value);
	}
	document.getElementById("totaldeductions[" + employeeid + "]").value =  val1 + val2 + val3 + val4 + val5 + val6 + val7 + val8;
	calculatenetsalary(employeeid);
}
function calculatenetsalary(employeeid)
{
		document.getElementById("idnetpay[" + employeeid + "]").innerHTML = document.getElementById("totalearnings[" + employeeid + "]").value - document.getElementById("totaldeductions[" + employeeid + "]").value;  
		document.getElementById("netpay[" + employeeid + "]").value = document.getElementById("totalearnings[" + employeeid + "]").value - document.getElementById("totaldeductions[" + employeeid + "]").value;
		funupdatedb();
}
</script>
<script>
function funupdatedb()
{
	var onlycharacter = /^[a-zA-Z\s]*$/;
	//#################
	var selectedsalarymonth = $('#selectedsalarymonth').val();
	var selectedsalarydate = $('#selectedsalarydate').val();
	var employeeid = $('#empid').val();
	//#################
	transactionid = document.getElementById("transactionid[" + employeeid + "]").value;
	empname = document.getElementById("empname[" + employeeid + "]").value;
	empcode = document.getElementById("empcode[" + employeeid + "]").value;
	emptype = document.getElementById("emptype[" + employeeid + "]").value;
	pfno = document.getElementById("pfno[" + employeeid + "]").value;
	grade = document.getElementById("grade[" + employeeid + "]").value;
	bankacno = document.getElementById("bankacno[" + employeeid + "]").value;
	department = document.getElementById("department[" + employeeid + "]").value;
	dateofjoining = document.getElementById("dateofjoining[" + employeeid + "]").value;
	workingdays = document.getElementById("workingdays[" + employeeid + "]").value;
	dayspayable = document.getElementById("dayspayable[" + employeeid + "]").value;
	//#################
	earning1amt = "";
	earning2amt = "";
	earning3amt = "";
	earning4amt = "";
	earning5amt = "";
	earning6amt = "";
	earning7amt = "";
	earning8amt = "";
	ival1 = 0;
	ival2 = 0;
	ival3 = 0;
	ival4 = 0;
	ival5 = 0;
	ival6 = 0;
	ival7 = 0;
	ival8 = 0;
	if(parseFloat(document.getElementById("earning1amt[" + employeeid + "]").value) >=1)
	{
		earning1amt = document.getElementById("earning1[" + employeeid + "]").value;
		ival1 = parseFloat(document.getElementById("earning1amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("earning2amt[" + employeeid + "]").value)  >=1)
	{
		earning2amt = document.getElementById("earning2[" + employeeid + "]").value;
		ival2 = parseFloat(document.getElementById("earning2amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("earning3amt[" + employeeid + "]").value ) >=1)
	{
		earning3amt = document.getElementById("earning3[" + employeeid + "]").value;
		ival3 = parseFloat(document.getElementById("earning3amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("earning4amt[" + employeeid + "]").value ) >=1)
	{
		
		earning4amt = document.getElementById("earning4[" + employeeid + "]").value;
		ival4 = parseFloat(document.getElementById("earning4amt[" + employeeid + "]").value);
	}	
	if(parseFloat(document.getElementById("earning5amt[" + employeeid + "]").value)  >=1)
	{
		earning5amt = document.getElementById("earning5[" + employeeid + "]").value;
		ival5 = parseFloat(document.getElementById("earning5amt[" + employeeid + "]").value);
	}	
	if(parseFloat(document.getElementById("earning6amt[" + employeeid + "]").value ) >=1)
	{
		earning6amt = document.getElementById("earning6[" + employeeid + "]").value;
		ival6 = parseFloat(document.getElementById("earning6amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("earning7amt[" + employeeid + "]").value) >=1)
	{
		earning7amt = document.getElementById("earning7[" + employeeid + "]").value;
		ival7 = parseFloat(document.getElementById("earning7amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("earning8amt[" + employeeid + "]").value)>=1)
	{
		earning8amt = document.getElementById("earning8[" + employeeid + "]").value;
		ival8 = parseFloat(document.getElementById("earning8amt[" + employeeid + "]").value);
	}
	deduction1="";
	deduction2="";
	deduction3="";
	deduction4="";
	deduction5="";
	deduction6="";
	deduction7="";
	deduction8="";
	eval1 = 0;
	eval2 = 0;
	eval3 = 0;
	eval4 = 0;
	eval5 = 0;
	eval6 = 0;
	eval7 = 0;
	eval8 = 0;
	if(parseFloat(document.getElementById("deduction1amt[" + employeeid + "]").value) >=1)
	{
		deduction1 = document.getElementById("deduction1[" + employeeid + "]").value;
		eval1 = parseFloat(document.getElementById("deduction1amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("deduction2amt[" + employeeid + "]").value)  >=1)
	{
		deduction2 = document.getElementById("deduction2[" + employeeid + "]").value;
		eval2 = parseFloat(document.getElementById("deduction2amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("deduction3amt[" + employeeid + "]").value ) >=1)
	{
		deduction3 = document.getElementById("deduction3[" + employeeid + "]").value;
		eval3 = parseFloat(document.getElementById("deduction3amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("deduction4amt[" + employeeid + "]").value ) >=1)
	{
		deduction4 = document.getElementById("deduction4[" + employeeid + "]").value;
		eval4 = parseFloat(document.getElementById("deduction4amt[" + employeeid + "]").value);
	}	
	if(parseFloat(document.getElementById("deduction5amt[" + employeeid + "]").value)  >=1)
	{
		deduction5 = document.getElementById("deduction5[" + employeeid + "]").value;
		eval5 = parseFloat(document.getElementById("deduction5amt[" + employeeid + "]").value);
	}	
	if(parseFloat(document.getElementById("deduction6amt[" + employeeid + "]").value ) >=1)
	{
		deduction6 = document.getElementById("deduction6[" + employeeid + "]").value;
		eval6 = parseFloat(document.getElementById("deduction6amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("deduction7amt[" + employeeid + "]").value) >=1)
	{
		deduction7 = document.getElementById("deduction7[" + employeeid + "]").value;
		eval7 = parseFloat(document.getElementById("deduction7amt[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("deduction8amt[" + employeeid + "]").value)>=1)
	{
		deduction8 = document.getElementById("deduction8[" + employeeid + "]").value;
		eval8 = parseFloat(document.getElementById("deduction8amt[" + employeeid + "]").value);
	}
	//#################
	totalearnings =0;
	totaldeductions =0;
	netpay=0;
	if(parseFloat(document.getElementById("totalearnings[" + employeeid + "]").value)>=1)
	{
		totalearnings = parseFloat(document.getElementById("totalearnings[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("totaldeductions[" + employeeid + "]").value)>=1)
	{
		totaldeductions = parseFloat(document.getElementById("totaldeductions[" + employeeid + "]").value);
	}
	if(parseFloat(document.getElementById("netpay[" + employeeid + "]").value)>=1)
	{
		netpay = parseFloat(document.getElementById("netpay[" + employeeid + "]").value);
	}
	//#################
		$.post("jsgeneratesalary.php",
		{
			'selectedsalarymonth': selectedsalarymonth,
			'selectedsalarydate': selectedsalarydate,
			'employeeid': employeeid,
			'transactionid': transactionid,
			'empname': empname,
			'empcode': empcode,
			'emptype':emptype,
			'pfno': pfno,
			'grade': grade,
			'bankacno': bankacno,
			'department': department,
			'dateofjoining':dateofjoining,
			'workingdays':workingdays,
			'dayspayable':dayspayable,
			'earning1amt':earning1amt,
			'earning2amt':earning2amt,
			'earning3amt':earning3amt,
			'earning4amt':earning4amt,
			'earning5amt':earning5amt,
			'earning6amt':earning6amt,
			'earning7amt':earning7amt,
			'earning8amt':earning8amt,
			'ival1':ival1,
			'ival2':ival2,
			'ival3':ival3,
			'ival4':ival4,
			'ival5':ival5,
			'ival6':ival6,
			'ival7':ival7,
			'ival8':ival8,
			'deduction1':deduction1,
			'deduction2':deduction2,
			'deduction3':deduction3,
			'deduction4':deduction4,
			'deduction5':deduction5,
			'deduction6':deduction6,
			'deduction7':deduction7,
			'deduction8':deduction8,
			'eval1':eval1,
			'eval2':eval2,
			'eval3':eval3,
			'eval4':eval4,
			'eval5':eval5,
			'eval6':eval6,
			'eval7':eval7,
			'eval8':eval8,
			'totalearnings':totalearnings,
			'totaldeductions':totaldeductions,
			'netpay':netpay,
			'btncabbooking': "btnsubmit"
		},
		function(data, status){
			//alert("Salary Report Generated successfully...");
			//window.location='cabbookingreceipt.php?paymentid='+data;
		});
}
</script>