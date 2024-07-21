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
<body>
<form method="post" action="" onsubmit="return validationform()">
<input type="hidden" name="transid" id="transid" value="<?php echo $_GET['transid'];  ?>" >
<div class="row">
	<div class="col-md-6">
<table class="table table-striped table-bordered dataTable">	
	<tr>
		<th style="width: 170px;">Account </th><td><?php echo $rsaccountlist1['accounttype'];  ?></td>
	</tr>
	<tr>
		<th>Transaction Type</th><td><?php echo $rstransaction['transtype'];  ?></td>
	</tr>
</table>
	</div>
	<div class="col-md-6">
<table class="table table-striped table-bordered dataTable">

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
	<b>Invoice Detail:</b>
		<table class="table table-striped table-bordered dataTable">
<?php
$sqlbilling_template ="SELECT * FROM billing_template WHERE studentid='$rstransaction[billno]'";
$qsqlbilling_template = mysqli_query($con,$sqlbilling_template);
$rsbilling_template = mysqli_fetch_array($qsqlbilling_template);
 ?>
<?php 
	$template = unserialize($rsbilling_template['template']); 
	$sum=0;
	for($i=0; $i <count($template[0]); $i++)
	{		
		echo "<tr><th>" . $template[0][$i] . "</th><td>₹"  . $template[2][$i] . "</td></tr>";
		$sum = $sum + $template[2][$i];
	}
	 ?>
		<tr style='background-color: #e6a0a7;'><th>Total Amount</th><th>₹<?php echo $sum;  ?></th></tr>
<?php
$vpaidamt=0;
$sqltransaction = "SELECT ifnull(SUM(totalamt),0) as totalamt FROM transaction where billno='$rsbilling_template[studentid]' AND transtype='Income' AND invoiceid='$_GET[transid]'";
$qsqltransaction = mysqli_query($con,$sqltransaction);
echo mysqli_error($con);
$rstransaction = mysqli_fetch_array($qsqltransaction);
$vpaidamt = $rstransaction['totalamt'];
 ?>				
		<tr style='background-color: #e610a7;'><th>Paid Amount</th><th>₹<?php echo $vpaidamt;  ?></th></tr>	
		<tr style='background-color: #e6a017;'><th>Balance Amount</th><th>₹<?php echo $balamts = $sum - $vpaidamt;  ?></th></tr>	
		</table>
	</div>
</div>
</div>

<hr>
	<div class="row"><div class="col-md-12"><h3>Payment Detail</h3></div></div>
	<div class="row">
		<div class="col-md-6" >
			Payment Type: <label class="errmsg flash" id="idpaymenttype"></label><select name="paymenttype" id="paymenttype" class="form-control">
				<option value="">Select</option>
	<?php
	$arr = array("Visa","Master card","Rupay");
	foreach($arr as $val)
	{
		echo "<option value='$val'>$val</option>";
	}
	 ?>
			</select>
		</div>
		<div class="col-md-6">
			Card holder: <label class="errmsg flash" id="idcardholder"></label><input type="text" name="cardholder" id="cardholder" class="form-control">
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			Card No: <label class="errmsg flash" id="idcardno"></label><input type="number" name="cardno" id="cardno" class="form-control" >
		</div>
		<div class="col-md-6">
			CVV No: <label class="errmsg flash" id="idcvrno"></label><input type="number" name="cvrno" id="cvrno" class="form-control" min="101" max="999">
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			Expiry date: <label class="errmsg flash" id="idexpirydate"></label><input type="month" min="<?php echo date("Y-m");  ?>" name="expirydate" id="expirydate" class="form-control">
		</div>
	</diV>
	<hr>
	<div class="row">
		<div class="col-md-6">
			Payment Amount: <label class="errmsg flash" id="idpaidamt"></label>
			<input type="number"  name="paidamt" id="paidamt" class="form-control" min="1" max="<?php echo $balamts; ?>" >
		</div>
		<div class="col-md-6"><br>
		<input type="submit" name="btnpayment" value="Make Payment" class="form-control">
		</div>
	</diV>
</form>