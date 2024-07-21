<?php
include("header.php");
include("sidebar.php");
if(isset($_GET['deltransactionid']))
{
	$sqltransaction ="SELECT * FROM transaction WHERE transactionid='$_GET[deltransactionid]'";
	$qsqltransaction = mysqli_query($con,$sqltransaction);
	$rstransaction = mysqli_fetch_array($qsqltransaction);
	$accountidd= $rstransaction['accountid'];
	$sql ="DELETE FROM transaction where transactionid='$_GET[deltransactionid]'";
	$qsql = mysqli_query($con,$sql);
	$sql ="DELETE FROM incomeexpenserec where transactionid='$_GET[deltransactionid]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Transaction record deleted successfully...');</script>";
		echo "<script>window.location='viewietransaction.php?accountid=$accountidd';</script>";
	}
}
$sqlaccountlist ="SELECT * FROM account WHERE  accountid='$_GET[accountid]'";
$qsqlaccountlist = mysqli_query($con,$sqlaccountlist);
$rsaccountlist = mysqli_fetch_array($qsqlaccountlist);
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
          <h3 class="card-title">View Transaction Details - <b><?php echo $rsaccountlist['accounttype'];  ?></b></h3>
		   
<?php
if($rsaccountlist['accounttype'] != "STUDENT FEES")
{
?>
		  <input type="button" name="btnincome" id="btnincome" value="Add Expense" class="btn btn-primary"  style="float: right;"  data-toggle="modal" data-target="#myexpenseModal">
		  
		  <input type="button" name="btnincome" id="btnincome" value="Add Income" class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#myincomeModal">
<?php
}
?>		  
        </div>
        <div class="card-body">
<table id="myTable"  class="table table-striped table-bordered" >
	<thead>
		<tr>
		    <th style="width: 75px;">Transaction Type</th>
			<th style="width: 65px;">Transaction Date</th>
			<th>Transaction Detail</th>
			<th style="width: 65px;">Total Amount</th>
			<th style="width: 65px;">View </th>
		</tr>
	</thead>
	<tbody>
	<?php
	$gtotal = 0;
	$sql ="SELECT * FROM transaction WHERE accountid='$_GET[accountid]'";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		$sqlcategory ="SELECT categoryname  FROM category  WHERE categoryid='$rs[categoryid]'";
		$qsqlcategory = mysqli_query($con,$sqlcategory);
		$rscategory = mysqli_fetch_array($qsqlcategory);
		$sqlaccount ="SELECT accounttype  FROM account  WHERE accountid='$rs[accountid]'";
		$qsqlaccount = mysqli_query($con,$sqlaccount);
		$rsaccount = mysqli_fetch_array($qsqlaccount);
		$actype=$rsaccount['accounttype'];
		echo "<tr>
				<td>$rs[transtype]</td>
				<td>" . date("d-M-Y",strtotime($rs['transdate'])) . "</td>
				<td>" ;
if($rs['transtype'] == "Payroll")
{
	$arrtrans =  unserialize($rs['paymentdetail']);				
	echo "<b>Employee Code - </b>" . $arrtrans[4] . "<br>";
	echo "<b>Employee Name - </b>" . $arrtrans[3]. "<br>";
	echo "<b>Salary Month - </b>". date("M-Y",strtotime($arrtrans[1])) . "<br>";
}
else
{
	echo $rs['transdetails'];
}
				if($rscategory['categoryname'] != "")
				{
		echo "<br><b>Category:</b> $rscategory[categoryname]";
				}
		echo  "</td>
				<td style='text-align: right;'>₹$rs[totalamt]</td>
				<td style='text-align: right;' ><a href='' onclick='loadtransdetail($rs[0],`$rs[transtype]`,`$actype`)'  class='btn btn-dark'  data-toggle='modal' data-target='#myreportModal'>View</a></td>				
			</tr>";
			if($rs['transtype'] == "Income")
			{
			$gtotal = $gtotal + $rs['totalamt'];
			}
			if($rs['transtype'] == "Expense")
			{
			$gtotal = $gtotal - $rs['totalamt'];
			}
			if($rs['transtype'] == "Payroll")
			{
			$gtotal = $gtotal - $rs['totalamt'];
			}
	}
	 ?>
	</tbody>
	<tfoot>
			<tr>
			<th></th>
			<th></th>
			<th>Total Balance</th>
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

  <!-- Modal -->
  <div class="modal fade" id="myincomeModal" role="dialog" style="z-index: 1999;">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="width: 750px;margin: auto;">
        <div class="modal-header">
          <h4 class="modal-title">Income Entry - <b><?php echo $rsaccountlist['accounttype'];  ?></b></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" id="divincomerec"><?php
		  include("incomerec.php");
		   ?></div>
      </div>
      
    </div>
  </div>
  
<!-- Modal -->
<div class="modal fade" id="myexpenseModal" role="dialog" style="z-index: 1999;">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content" style="width: 750px;margin: auto;">
		<div class="modal-header">
		  <h4 class="modal-title">Expense Entry - <b><?php echo $rsaccountlist['accounttype'];  ?></b></h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body" id="divexpenserec">
		  <?php
		  include("expenserec.php");
		   ?>
		</div>
	  </div>
	</div>
</div>

<!-- Transaction detail code starts here -->
<div class="modal fade" id="myreportModal" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content" style="width: 750px;margin: auto;">
		<div class="modal-header">
		  <h4 class="modal-title">Transaction detail</h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">
		  <p id="divtransdet"><img src="images/loading.gif" style="width: 100%;"></p>
		</div>
		<div class="modal-footer" id="divtransbuttons"></div>
	  </div>
	</div>
</div>

<script>
function loadtransdetail(transid,transtype,actype)
{
	if (transid == "") 
	{
        document.getElementById("divtransdet").innerHTML = "<img src='images/loading.gif' style='width: 100%'>";
        return;
    } 
	else 
	{
        if (window.XMLHttpRequest) 
		{
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
		else 
		{
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("divtransdet").innerHTML = this.responseText;
if(actype == "STUDENT FEES")
{
		document.getElementById("divtransbuttons").innerHTML = "<a target='_blank'  class='btn btn-warning' href='ajaxtransdet.php?transid=" + transid + "&action=print' >Print</a>";
}
else
{
	if(transtype == "Income")
	{
		document.getElementById("divtransbuttons").innerHTML = "<a class='btn btn-danger' style='color: white;' href='viewietransaction.php?deltransactionid=" + transid + "' onclick='return confirmtodelete()' >Delete</a><a class='btn btn-info' style='color: white;' onclick='edittransrec(" + transid + ",`" + transtype + "`)' data-toggle='modal' data-target='#myincomeModal'  >Edit</a><a target='_blank'  class='btn btn-warning' href='ajaxtransdet.php?transid=" + transid + "&action=print' >Print</a>";
	}
	if(transtype == "Expense")
	{
		document.getElementById("divtransbuttons").innerHTML = "<a class='btn btn-danger' style='color: white;' href='viewietransaction.php?deltransactionid=" + transid + "' onclick='return confirmtodelete()' >Delete</a><a class='btn btn-info' style='color: white;' data-toggle='modal' data-target='#myexpenseModal' onclick='edittransrec(" + transid + ",`" + transtype + "`)' >Edit</a><a target='_blank'  class='btn btn-warning' href='ajaxtransdet.php?transid=" + transid + "&action=print' >Print</a>";
	}
}
            }
        };
        xmlhttp.open("GET","ajaxtransdet.php?transid="+transid+"&transtype="+transtype,true);
        xmlhttp.send();
    }
}
</script>
<!-- Transaction detail code ends here -->
<script>
function confirmtodelete()
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
function edittransrec(transid,transtype)
{
	if (window.XMLHttpRequest) 
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
	else 
	{
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {				
			//alert(this.responseText);
			if(transtype == "Income")
			{
			document.getElementById("divincomerec").innerHTML = this.responseText;
			} 
			if(transtype == "Expense")
			{
			document.getElementById("divexpenserec").innerHTML = this.responseText;
			}
		}
	};
	if(transtype == "Income")
	{
        xmlhttp.open("GET","incomerec.php?transeditid="+transid+"&transtype="+transtype,true);
        xmlhttp.send();
	}
	if(transtype == "Expense")
	{
        xmlhttp.open("GET","expenserec.php?transeditid="+transid+"&transtype="+transtype,true);
        xmlhttp.send();
	}
}
</script>