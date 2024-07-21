<?php
include("header.php");
include("sidebar.php");
//#############################################################
$sqltransaction ="SELECT * FROM transaction WHERE accountid='3' AND transactionid='$_GET[transactionid]'";
$qsqltransaction = mysqli_query($con,$sqltransaction);
$rstransaction = mysqli_fetch_array($qsqltransaction);
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"  id="printme">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content" >
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">SALARY RECEIPT</h3>
        </div>
        <div class="card-body">
<form method="get" action="" >
	<table id="myTable1"  class="table table-striped table-bordered" >
		<tr>
		    <th style="width: 150px;">Salary Month</th><td><?php echo date("M-Y",strtotime($_GET['salarymonth']));	?></td><th style="width: 150px;">Payment Date</th><td><?php echo date("d-M-Y",strtotime($_GET['salarydate'])); ?></td>
		</tr>
	</table>
	<hr>
</form>
<?php
//if(isset($_GET['submitsalary']))
{
 ?>
<form method="POST" action="">
<input type="hidden" name="selectedsalarymonth" id="selectedsalarymonth" value="<?php echo $_GET['salarymonth'];  ?>" class="form-control" >
<input type="hidden" name="selectedsalarydate" id="selectedsalarydate" value="<?php echo $_GET['salarydate'];  ?>"  class="form-control" > 
	<table style="width: 100%;">
		<thead><tr><th></th></tr></thead>
		<tbody>
	<?php
	$sql ="SELECT * FROM employee WHERE emptype IN('Principal','Professor','HOD','Lecturer','Librarian','Computer Instructor','Lab Assistant','Office Peon','Security Man','Cleaner','Others') AND status='Active' AND employeeid='$rstransaction[employeeid]' ORDER BY employeeid";
		$qsql = mysqli_query($con,$sql);
		$j=0;
		while($rs = mysqli_fetch_array($qsql))
		{
				$sqlempsaldet = "SELECT * FROM transaction WHERE transdetails='$_GET[salarymonth]' AND employeeid='$rs[0]' ";
				$qsqlempsaldet = mysqli_query($con,$sqlempsaldet);
				$rsempsaldet = mysqli_fetch_array($qsqlempsaldet);
				$sqlpresaldet = "SELECT * FROM transaction WHERE transdetails='$_GET[salarymonth]' AND employeeid='$rs[0]' ";
				$qsqlpresaldet = mysqli_query($con,$sqlpresaldet);
				$rspresaldet = mysqli_fetch_array($qsqlpresaldet);
				$templatec = unserialize($rspresaldet['paymentdetail']);
	 ?>
			<tr>
				<td>
<input type="hidden" name="empid" id="empid" value="<?php echo $rs['employeeid'];  ?>"> 
<input type="hidden" name="employeeid[<?php echo $j;  ?>]" id="employeeid[<?php echo $rs['employeeid'];  ?>]" value="<?php echo $rs['employeeid'];  ?>">
<input type="hidden" name="transactionid[<?php echo $j;  ?>]" id="transactionid[<?php echo $rs['employeeid'];  ?>]" value="<?php echo $rsempsaldet['transactionid'];  ?>">
			<table id="myTable1"  style="width: 100%;" class="table table-striped table-bordered" >
			<tr>
				<th style="width: 150px;">Name</th><td><?php echo $rs['empname'];  ?></td><th style="width: 150px;">Employee Code</th><td><?php echo $rs['empcode'];  ?></td>
			</tr>
			<tr>
				<th>Designation</th><td><?php echo $rs['emptype'];  ?></td><th>PF No</th><td><?php echo $templatec[6]; ?></td>
			</tr>
			<tr>
				<th>Grade</th><td><?php echo $templatec[7]; ?></td><th>Bank A/c No</th><td><?php echo $templatec[8]; ?></td>
			</tr>
			<tr>
				<th>Department</th><td><?php echo $templatec[9]; ?></td><th>Date of Joining</th><td><?php echo $templatec[10]; ?></td>
			</tr>
			<tr>
				<th>Working days</th><td><?php echo $templatec[11]; ?></td><th>Days Payable</th><td><?php echo $templatec[12]; ?></td>
			</tr>
		</table>
		<hr>
		<table id="myTable1"  style="width: 100%;" class="table table-striped table-bordered" >
			<tbody>
				<tr>
					<th>Earnings</th><th style="width: 150px;text-align: right;">Amount</th><th>Deduction</th><th style="width: 150px;text-align: right;">Amount</th>
				</tr>
				<tr>
					<td>Basic</td><td  style="width: 150px;text-align: right;"><?php 
					if($templatec[21] != 0)
					{
					echo "₹" .  $templatec[21]; 
					}
					?></td>
					<td>LOP</td><td style="width: 150px;text-align: right;"><?php 
					if($templatec[37] != 0)
					{
					echo "₹" . $templatec[37]; 
					} ?></td>
				</tr>
				<?php
				if($templatec[22] != 0 || $templatec[38] != 0)
				{
				?>
				<tr>
					<td><?php echo $templatec[14]; ?></td><td  style="width: 150px;text-align: right;"><?php   
					if($templatec[22] != 0)
					{
					echo "₹" . $templatec[22]; 
					} ?></td>
					<td><?php echo $templatec[30]; ?></td><td style="width: 150px;text-align: right;"><?php   
					if($templatec[38] != 0)
					{
					echo "₹" . $templatec[38]; 
					} ?> </td>
				</tr>
				<?php
				}
				if($templatec[23] != 0 || $templatec[39] != 0)
				{
				?>
				<tr>
					<td><?php echo $templatec[15]; ?></td><td  style="width: 150px;text-align: right;"><?php   
					if($templatec[23] != 0)
					{
					echo "₹" . $templatec[23]; 
					} ?></td>
					<td><?php echo $templatec[31]; ?></td><td style="width: 150px;text-align: right;"><?php  
					if($templatec[39] != 0)
					{
					echo "₹" . $templatec[39]; 
					} ?></td>
				</tr>
				<?php
				}
				if($templatec[24] != 0 || $templatec[40] != 0)
				{
				?>
				<tr>
					<td><?php echo $templatec[16]; ?></td><td  style="width: 150px;text-align: right;"><?php  
					if($templatec[24] != 0)
					{
					echo "₹" . $templatec[24]; 
					} ?></td>
					<td><?php echo $templatec[32]; ?></td><td style="width: 150px;text-align: right;"><?php  
					if($templatec[40] != 0)
					{
					echo "₹" . $templatec[40]; 
					} ?></td>
				</tr>
				<?php
				}
				if($templatec[25] != 0 || $templatec[41] != 0)
				{
				?>
				<tr>
					<td><?php echo $templatec[17]; ?></td><td  style="width: 150px;text-align: right;"><?php  
					if($templatec[25] != 0)
					{
					echo "₹" . $templatec[25]; 
					} ?></td>
					<td><?php echo $templatec[33]; ?></td><td style="width: 150px;text-align: right;"><?php  
					if($templatec[41] != 0)
					{
					echo "₹" . $templatec[41]; 
					} ?></td>
				</tr>
				<?php
				}
				if($templatec[26] != 0 || $templatec[42] != 0)
				{
				?>
				<tr>
					<td><?php echo $templatec[18]; ?></td><td  style="width: 150px;text-align: right;"><?php  
					if($templatec[26] != 0)
					{
					echo "₹" . $templatec[26]; 
					} ?></td>
					<td><?php echo $templatec[34]; ?></td><td style="width: 150px;text-align: right;"><?php  
					if($templatec[42] != 0)
					{
					echo "₹" . $templatec[42]; 
					} ?></td>
				</tr>
				<?php
				}
				if($templatec[27] != 0 || $templatec[43] != 0)
				{
				?>
				<tr>
					<td><?php echo $templatec[19]; ?></td><td  style="width: 150px;text-align: right;"><?php  
					if($templatec[27] != 0)
					{
					echo "₹" . $templatec[27]; 
					} ?></td>
					<td><?php echo $templatec[35]; ?></td><td style="width: 150px;text-align: right;"><?php  
					if($templatec[43] != 0)
					{
					echo "₹" . $templatec[43]; 
					} ?></td>
				</tr>
				<?php
				}
				if($templatec[28] != 0 || $templatec[44] != 0)
				{
				?>
				<tr>
					<td><?php echo $templatec[20]; ?></td><td  style="width: 150px;text-align: right;"><?php  
					if($templatec[28] != 0)
					{
					echo "₹" . $templatec[28]; 
					} ?></td>
					<td><?php echo $templatec[36]; ?></td><td style="width: 150px;text-align: right;"><?php 
					if($templatec[44] != 0)
					{
					echo "₹" . $templatec[44]; 
					} ?></td>
				</tr>
				
				<?php
				}
				?>

				
				<tr style="background-color: #d4dee8;">
					<th  style="width: 150px;text-align: right;">Total Earnings</th><td  style="width: 150px;text-align: right;">₹<?php  
					if($templatec[45] != 0)
					{
					echo $templatec[45]; 
					} ?></td><th  style="width: 150px;text-align: right;">Total Deduction</th><td  style="width: 150px;text-align: right;">₹<?php  
					if($templatec[46] != 0)
					{
					echo $templatec[46]; 
					} ?></td>
				</tr>
				<tr>
					<th></th><th></th><th><center>Net Pay : </th><th   style="width: 150px;text-align: right;">₹<?php  
					if($templatec[47] != 0)
					{
					echo $templatec[47]; 
					} ?></center></th></td>
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
  
 <hr>
 <center><input type="button" class="btn btn-info" value="Print Salary Receipt"  onclick="PrintElem('printme')"></center>
 <hr>
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
		"pageLength": 1
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

<script>

function PrintElem(elem)
{
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();

    return true;
}

</script>