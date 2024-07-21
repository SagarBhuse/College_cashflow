<?php
error_reporting(0);
if(isset($_GET['action']))
{
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Income expense tracker</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link rel="stylesheet" href="css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  
</head>
<?php
}
 ?>
<?php
include("databaseconnection.php");
$sqltransaction = "SELECT * FROM  transaction where transactionid='$_GET[transid]'";
$qsqltransaction  = mysqli_query($con,$sqltransaction);
$rstransaction = mysqli_fetch_array($qsqltransaction);
$sqlaccountlist1 ="SELECT * FROM account WHERE  accountid='$rstransaction[accountid]'";
$qsqlaccountlist1 = mysqli_query($con,$sqlaccountlist1);
$rsaccountlist1 = mysqli_fetch_array($qsqlaccountlist1);
$sqlincomeexpenserec ="SELECT * FROM incomeexpenserec WHERE  transactionid='$_GET[transid]'";
$qsqlincomeexpenserec = mysqli_query($con,$sqlincomeexpenserec);
$rsincomeexpenserec = mysqli_fetch_array($qsqlincomeexpenserec);
$sqlcategory ="SELECT categoryname  FROM category  WHERE categoryid='$rstransaction[categoryid]'";
$qsqlcategory = mysqli_query($con,$sqlcategory);
$rscategory = mysqli_fetch_array($qsqlcategory);
 ?>
<body onafterprint="afterprint()">
<div class="row">
	<div class="col-md-5">
<table class="table table-striped table-bordered dataTable">	
	<tr>
		<th style="width: 170px;">Account </th><td><?php echo $rsaccountlist1['accounttype'];  ?></td>
	</tr>
	<tr>
		<th>Transaction Type</th><td><?php echo $rstransaction['transtype'];  ?></td>
	</tr>
	<tr>
		<th>Category</th><td><?php echo $rscategory['categoryname'];  ?></td>
	</tr>
</table>
	</div>
	<div class="col-md-5">
<table class="table table-striped table-bordered dataTable">

	<tr>
		<th style="width: 200px;">Transaction No.</th><td><?php echo $rstransaction['transactionid'];  ?></td>
	</tr>
	<tr>
		<th>Transaction date</th><td><?php echo date("d-M-Y",strtotime($rstransaction['transdate']));  ?></td>
	</tr>
	<tr>
		<th>Total Amount</th><td>₹<?php echo $rstransaction['totalamt'];  ?></td>
	</tr>
</table>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-12">
		<table class="table table-striped table-bordered dataTable">
			<tr>
				<th>Transaction detail</th>
				<th>Total Amount</th>
			</tr>
			<tr>
				<td><b><?php echo $rsincomeexpenserec['title'];  ?></b><br>
				<?php echo $rstransaction['transdetails'];  ?></td>
				<td>₹<?php echo $rstransaction['totalamt'];  ?></td>
			</tr>
		</table>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-12">
		<table class="table table-striped table-bordered dataTable">
			<tr>
				<th style="width: 200px;">Payment detail</th><td>
<?php

if($rsaccountlist1['accounttype'] == "STUDENT FEES")
{
	function ccMasking($number, $maskingCharacter = 'X')
	{
	return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
	}
	$arrpayment = unserialize($rstransaction['paymentdetail']);
	echo "Payment type: " . $arrpayment[0] . "<br>";
	echo "Card holder: " . $arrpayment[1] . "<br>";
	echo "Card number: " . ccMasking($arrpayment[2], $maskingCharacter = 'X');
}
else if($rsaccountlist1['accounttype'] == "SALARY ACCOUNT")
{
	function ccMasking($number, $maskingCharacter = 'X')
	{
	return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
	}
	$arrpayment = unserialize($rstransaction['paymentdetail']);
	echo "<b>Employee Code - </b>" . $arrpayment[4] . "<br>";
	echo "<b>Employee Name - </b>" . $arrpayment[3]. "<br>";
	echo "<b>Salary Month - </b>". date("M-Y",strtotime($arrpayment[1])) . "<br>";
}
else
{
	echo $rstransaction['paymentdetail'];
}
?>
				</td>
			</tr>
		</table>
	</div>
</div>
</div>
<?php
if(isset($_GET['action']))
{
?>
<script>
$(document).ready(function()
{
	window.print();
});
function afterprint()
{
	window.close();
}
</script>
<?php
}
 ?>