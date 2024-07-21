<?php
session_start();
//error_reporting(0);
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
<div id="printarea">
<div class="row">
	<div class="col-md-6">
<table class="table table-striped table-bordered dataTable">	
	<tr>
		<th style="width: 170px;">Account </th><td><?php echo $rsaccountlist1['accounttype']; ?></td>
	</tr>
	<tr>
		<th>Transaction Type</th><td><?php echo $rstransaction['transtype']; ?></td>
	</tr>
</table>
	</div>
	<div class="col-md-6">
<table class="table table-striped table-bordered dataTable">

	<tr>
		<th>Transaction date</th><td style='text-align: right;'><?php echo date("d-M-Y",strtotime($rstransaction['transdate']));  ?></td>
	</tr>
	<tr>
		<th>Total Amount</th><td style='text-align: right;'>₹<?php echo $rstransaction['totalamt'];  ?></td>
	</tr>
</table>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-12">
	<b>Invoice Detail:</b>
		<table class="table table-striped table-bordered dataTable">
<?php
$sqlbilling_template ="SELECT * FROM billing_template WHERE studentid='$rstransaction[billno]'";
$qsqlbilling_template = mysqli_query($con,$sqlbilling_template);
$rsbilling_template = mysqli_fetch_array($qsqlbilling_template);
?>
<?php 
	$template = unserialize($rsbilling_template['template']);
	//echo count($template[0]);
	$sum=0;
	for($i=0; $i <count($template[0]); $i++)
	{
		echo "<tr><th>" . $template[0][$i] . "</th><td style='text-align: right;'>₹"  . $template[2][$i] . "</td></tr>";
		$sum = $sum + $template[2][$i];
	}
?>
		<tr style='background-color: #e6a0a7;'><th>Total Amount</th><th style='text-align: right;'>₹<?php echo $sum;  ?></th></tr>	
		</table>
</div>

	<div class="col-md-12">
<?php
if(isset($_SESSION['employeeid']))
{
?>
<hr>
<center><a href="viewinvoice.php?delid=<?php echo $_GET['transid']; ?>" class="btn btn-danger" onclick="return confirmtodelete()" >Delete Invoice</a> &nbsp;&nbsp;&nbsp;
<input type="button" class="btn btn-info" value="Print" onclick="PrintElem('printarea')">
</center>
<?php
}
else
{
?>
<hr>
<center>
 &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-info" value="Print" onclick="PrintElem('printarea')">
</center>
<?php
}
?>
	</div>
	</div>
</div>
</div>