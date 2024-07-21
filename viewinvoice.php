<?php
include("header.php");
include("sidebar.php");
if(isset($_GET['delid']))
{
	$sql ="DELETE FROM transaction where invoiceid='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	$sql ="DELETE FROM incomeexpenserec where transactionid='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	$sql ="DELETE FROM transaction where transactionid='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);	
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Invoice record deleted successfully...');</script>";
		echo "<script>window.location='viewinvoice.php';</script>";
	}
}
if(isset($_POST['btnpayment']))
{
	$arrpayment = serialize(array($_POST['paymenttype'],$_POST['cardholder'],$_POST['cardno'],$_POST['cvrno'],$_POST['expirydate']));
	$sqlinvoice = "INSERT INTO transaction(categoryid,transtype,billingtype,billno,totalamt,transdate,accountid,transdetails,paymentdetail,invoiceid,status) values('0','Income','General','$_SESSION[studentid]','$_POST[paidamt]','$dt','1','Student Fees payment','$arrpayment','$_POST[transid]','Active')";
	
		$insid = mysqli_insert_id($con);
	$sql ="INSERT INTO incomeexpenserec(transactionid, accountid, transtype, serviceid, qty, cost, trandate, status, title) values('$insid','1','Income','0','1','$_POST[paidamt]','$dt','Active','Student Fee payment')";
	$qsql = mysqli_query($con,$sql);
	
	 mysqli_query($con,$sqlinvoice);
	 echo "<script>alert('Fees Payment done successfully...');</script>";
	 echo "<script>window.location='viewinvoice.php';</script>";
}
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
          <h3 class="card-title">View Invoice</b></h3>
        </div>
        <div class="card-body">
<?php
if(isset($_SESSION['employeeid']))
{
?>
<form method="POST" action="">		
<table class="table table-striped table-bordered" >
	<tr>
		<th>Select Program</th>
		<td>
		<select  name="courseidsearch" id="courseidsearch" class="form-control" >
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
<?php
}
if($_POST['courseidsearch'] != "")
{
?>
<table id="myTable"  class="table table-striped table-bordered" >
	<thead>
		<tr>
			<th style="width: 15px;">Invoice No.</th>
			<th style="width: 85px;">Invoice Date</th>
			<th style="width: 125px;">Student</th>
			<th style="width: 85px;">Course &<br> Semester</th>
			<th style="width: 65px;">Total Amount</th>
			<th style="width: 65px;">Paid Amount</th>
			<th style="width: 65px;">Balance Amount</th>
			<th style="width: 65px;">View </th>
		</tr>
	</thead>
	<tbody>
	<?php
	$gtotal = 0;
	$sql ="SELECT * FROM transaction WHERE  transtype='Invoice' ";
	if(isset($_SESSION['studentid']))
	{
		$sql = $sql . " and billno='" . $_SESSION['studentid'] . "'";
	}
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
$sqlcategory ="SELECT categoryname  FROM category  WHERE categoryid='$rs[categoryid]'";
$qsqlcategory = mysqli_query($con,$sqlcategory);
$rscategory = mysqli_fetch_array($qsqlcategory);
$sqlstudent  = "SELECT * FROM student where studentid='$rs[billno]'";
$qsqlstudent = mysqli_query($con,$sqlstudent);
$rsstudent = mysqli_fetch_array($qsqlstudent);
$sqlcourse = "SELECT * FROM course WHERE courseid='$rsstudent[courseid]'";
$qsqlcourse = mysqli_query($con,$sqlcourse);
$rscourse = mysqli_fetch_array($qsqlcourse);
if($rsstudent['courseid'] == $_POST['courseidsearch'])
{
$sqltransaction = "SELECT ifnull(SUM(totalamt),0) FROM transaction where   transtype='Income' AND invoiceid='$rs[0]'";
$qsqltransaction = mysqli_query($con,$sqltransaction);
$rstransaction = mysqli_fetch_array($qsqltransaction);
$vpaidamt = $rstransaction[0];
$totalamt = $rs['totalamt'] - $vpaidamt;
		echo "<tr>
				<td>$rs[0]</td>
				<td>" . date("d-M-Y",strtotime($rs['transdate'])) . "</td>
				<td>$rsstudent[studentname] <br>(Roll No. $rsstudent[regno]) </td>
				<td>$rscourse[programcode] <br> $rsstudent[semester]</td>
				<td style='text-align: right;'>₹$rs[totalamt]</td>
				<td style='text-align: right;'>₹$vpaidamt</td>
				<td style='text-align: right;'>₹$totalamt</td>
				<td style='text-align: right;' >";
				
		echo "<a href='' onclick='loadtransdetail($rs[0],`$rs[transtype]`)'  class='btn btn-dark'  data-toggle='modal' data-target='#myreportModal' style='width: 100%;'>View</a><br>";
		if(isset($_SESSION['studentid']))
		{
			if($totalamt != 0)
			{
		echo "<a href='' onclick='loadpaymentdetail($rs[0],`$rs[transtype]`)'  class='btn btn-success'  data-toggle='modal' data-target='#myincomeModal' style='width: 100%;'>Make Payment</a>";
			}
		}			
			echo "</td></tr>";
			$totalamt = $rs['totalamt'];
			$paidamt = $rs['totalamt'];
			$balanceamt = $rs['totalamt'];
		$tot = $tot + $totalamt;
		$paid= $paid + $vpaidamt;
		$bal = $bal + $balanceamt;
	}
	}
	 ?>
	</tbody>
	<tfoot>
		<tr>
			<th></th>
			<th></th>
			<th colspan="2">Total Balance</th>
			<th style="text-align: right;">₹<?php echo $tot;  ?></th>
			<th style="text-align: right;">₹<?php echo $paid;  ?></th>
			<th style="text-align: right;">₹<?php echo $tot - $paid;  ?></th>
			<th></th>
		</tr>
	</tfoot>
</table>
<?php
}
else
{
?>
<table id="myTable"  class="table table-striped table-bordered" >
	<thead>
		<tr>
			<th style="width: 15px;">Invoice No.</th>
			<th style="width: 85px;">Invoice Date</th>
			<th style="width: 125px;">Student</th>
			<th style="width: 85px;">Course &<br> Semester</th>
			<th style="width: 65px;">Total Amount</th>
			<th style="width: 65px;">Paid Amount</th>
			<th style="width: 65px;">Balance Amount</th>
			<th style="width: 65px;">View </th>
		</tr>
	</thead>
	<tbody>
	<?php
	$gtotal = 0;
	$sql ="SELECT * FROM transaction WHERE  transtype='Invoice' ";
	if(isset($_SESSION['studentid']))
	{
		$sql = $sql . " and billno='" . $_SESSION['studentid'] . "'";
	}
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
$sqlcategory ="SELECT categoryname  FROM category  WHERE categoryid='$rs[categoryid]'";
$qsqlcategory = mysqli_query($con,$sqlcategory);
$rscategory = mysqli_fetch_array($qsqlcategory);
$sqlstudent  = "SELECT * FROM student where studentid='$rs[billno]'";
$qsqlstudent = mysqli_query($con,$sqlstudent);
$rsstudent = mysqli_fetch_array($qsqlstudent);
$sqlcourse = "SELECT * FROM course WHERE courseid='$rsstudent[courseid]'";
$qsqlcourse = mysqli_query($con,$sqlcourse);
$rscourse = mysqli_fetch_array($qsqlcourse);
$sqltransaction = "SELECT ifnull(SUM(totalamt),0) FROM transaction where   transtype='Income' AND invoiceid='$rs[0]'";
$qsqltransaction = mysqli_query($con,$sqltransaction);
$rstransaction = mysqli_fetch_array($qsqltransaction);
$vpaidamt = $rstransaction[0];

$totalamt = $rs['totalamt'] - $vpaidamt;
		echo "<tr>
				<td>$rs[0]</td>
				<td>" . date("d-M-Y",strtotime($rs['transdate'])) . "</td>
				<td>$rsstudent[studentname] <br>(Roll No. $rsstudent[regno]) </td>
				<td>$rscourse[programcode] <br> $rsstudent[semester]</td>
				<td style='text-align: right;'>₹$rs[totalamt]</td>
				<td style='text-align: right;'>₹$vpaidamt</td>
				<td style='text-align: right;'>₹$totalamt</td>
				<td style='text-align: right;' >";
				
		echo "<a href='' onclick='loadtransdetail($rs[0],`$rs[transtype]`)'  class='btn btn-dark'  data-toggle='modal' data-target='#myreportModal' style='width: 100%;'>View</a><br>";
		if(isset($_SESSION['studentid']))
		{
			if($totalamt != 0)
			{
		echo "<a href='' onclick='loadpaymentdetail($rs[0],`$rs[transtype]`)'  class='btn btn-success'  data-toggle='modal' data-target='#myincomeModal' style='width: 100%;'>Make Payment</a>";
			}
		}			
			echo "</td></tr>";
			$totalamt = $rs['totalamt'];
			$paidamt = $rs['totalamt'];
			$balanceamt = $rs['totalamt'];
		$tot = $tot + $totalamt;
		$paid= $paid + $vpaidamt;
		$bal = $bal + $balanceamt;
	}
	 ?>
	</tbody>
	<tfoot>
		<tr>
			<th></th>
			<th></th>
			<th colspan="2">Total Balance</th>
			<th style="text-align: right;">₹<?php echo $tot;  ?></th>
			<th style="text-align: right;">₹<?php echo $paid;  ?></th>
			<th style="text-align: right;">₹<?php echo $tot - $paid;  ?></th>
			<th></th>
		</tr>
	</tfoot>
</table>
<?php
}
?>
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
        <div class="modal-body" id="divincomerec"></div>
      </div>
      
    </div>
  </div>
  
<!-- Modal -->
<div class="modal fade" id="mypaymentmodal" role="dialog" style="z-index: 1999;">
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
		  <h4 class="modal-title">Invoice detail</h4>
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
function loadpaymentdetail(transid,transtype)
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
                document.getElementById("divincomerec").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxinvoicepayment.php?transid="+transid+"&transtype="+transtype,true);
        xmlhttp.send();
    }
}
</script>
<script>
function loadtransdetail(transid,transtype)
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
            }
        };
        xmlhttp.open("GET","ajaxinvoicedet.php?transid="+transid+"&transtype="+transtype,true);
        xmlhttp.send();
    }
}
</script>
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
</script>
<script>
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
<script>
function validationform()
{
	var numericExp = /^[0-9]+$/;
	var alphaExp = /^[a-zA-Z]+$/;
	var alphaSpaceExp = /^[a-zA-Z\s]+$/;
	var alphaNumericExp = /^[0-9a-zA-Z]+$/;
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,5}$/;
//###################
	var i = 0;	
	$('.errmsg').html('');
//###################
	if(document.getElementById("paymenttype").value == "")
	{
		document.getElementById("idpaymenttype").innerHTML = "Please select the payment type...";
		i=1;
	}
	if(!document.getElementById("cardholder").value.match(alphaSpaceExp))
	{
		document.getElementById("idcardholder").innerHTML = "Entered Card holder is not valid....";
		i=1;
	}
	if(document.getElementById("cardholder").value == "")
	{
		document.getElementById("idcardholder").innerHTML = "Please enter the card holder name...";
		i=1;
	}
	if(document.getElementById("cardno").value.length != 16)
	{
		document.getElementById("idcardno").innerHTML = "Kindly enter 16 digit card Number...";
		i=1;
	}
	if(document.getElementById("cardno").value == "")
	{
		document.getElementById("idcardno").innerHTML = "Please enter the correct  number...";
		i=1;
	}
	if(document.getElementById("expirydate").value == "")
	{
		document.getElementById("idexpirydate").innerHTML = "Please select the date...";
		i=1;
	}
	if(document.getElementById("cvrno").value.length != 3)
	{
		document.getElementById("idcvrno").innerHTML = "Kindly enter 3 digit cvv Number...";
		i=1;
	}
	if(document.getElementById("cvrno").value == "")
	{
		document.getElementById("idcvrno").innerHTML = "Please enter the correct cvv number...";
		i=1;
	}
	if(document.getElementById("paidamt").value == "")
	{
		document.getElementById("idpaidamt").innerHTML = "Payment amount should not be empty..";
		i=1;
	}
	if(i == 0)
	{
		return true
	}
	else
	{
		return false;
	}
//###################
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