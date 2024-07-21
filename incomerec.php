<?php
error_reporting(0);
$_GET['transtype'] = "Income";
include_once("databaseconnection.php");
if(isset($_POST['isubmit'])) 
{
	if(isset($_POST['transeditid']))
	{
		$sql ="UPDATE transaction SET transtype='Income',billingtype='General',billno='0',totalamt='$_POST[icost]',transdate='$_POST[itrandate]',accountid='$_POST[iaccountid]',transdetails='$_POST[idescr]',paymentdetail='$_POST[ipaytype]',status='Active',categoryid='$_POST[icategoryid]' WHERE transactionid='$_POST[transeditid]'";
		$qsql = mysqli_query($con,$sql);
		
		$sql ="UPDATE incomeexpenserec SET accountid='$_POST[iaccountid]', transtype='Income', serviceid='0', qty='1', cost='$_POST[icost]', trandate='$_POST[itrandate]', status='Active', title='$_POST[ititle]' WHERE transactionid='$_POST[transeditid]'";
		$qsql = mysqli_query($con,$sql);
		
		echo "<script>alert('Income record Updated successfully...');</script>";
		echo "<script>window.location='viewietransaction.php?accountid=$_POST[iaccountid]';</script>";
	}
	else
	{
		$sql ="INSERT INTO transaction(transtype,billingtype,billno,totalamt,transdate,accountid,transdetails,paymentdetail,status,categoryid) values('Income','General','0','$_POST[icost]','$_POST[itrandate]','$_POST[iaccountid]','$_POST[idescr]','$_POST[ipaytype]','Active','$_POST[icategoryid]')";
		$qsql = mysqli_query($con,$sql);
		$insid = mysqli_insert_id($con);
		
		$sql ="INSERT INTO incomeexpenserec(transactionid, accountid, transtype, serviceid, qty, cost, trandate, status, title) values('$insid','$_POST[iaccountid]','Income','0','1','$_POST[icost]','$_POST[itrandate]','Active','$_POST[ititle]')";
		$qsql = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con) ==1)
		{
			echo "<script>alert('Income Entry done successfully...');</script>";
			echo "<script>window.location='viewietransaction.php?accountid=$_POST[iaccountid]';</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
}
 ?>
<?php
if(isset($_GET['transeditid']))
{
	$sqledit = "SELECT * FROM incomeexpenserec WHERE transactionid='$_GET[transeditid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	echo mysqli_error($con);
	$rsedit = mysqli_fetch_array($qsqledit);
	$sqltransaction ="SELECT * FROM transaction WHERE transactionid='$_GET[transeditid]'";
	$qsqltransaction = mysqli_query($con,$sqltransaction);
	echo mysqli_error($con);
	$rstransaction = mysqli_fetch_array($qsqltransaction);
	$_GET['accountid']= $rstransaction['accountid'];
	//echo $rstransaction[categoryid];
}
 ?>
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
<form method="post" action="">
      <!-- Default box -->
      <div class="card">
        <div class="card-body">
<?php
if(isset($_GET['transeditid']))
{
 ?>
<input type="hidden" name="transeditid" id="transeditid" value="<?php echo $_GET['transeditid'];  ?>" >
<?php
}
 ?>
<input type="hidden" name="itranstype" id="itranstype" value="<?php echo $_GET['transtype'];  ?>" >
<input type="hidden" name="iaccountid" id="iaccountid" value="<?php echo $_GET['accountid'];  ?>" >

<div class="row">
	<div class="col-md-3">Category </div>
	<div class="col-md-5">
	<select  name="icategoryid" id="icategoryid" class="form-control">
		<option value="">Select category</option>
		<?php
		if($_GET['transtype'] == "Income")
		{
			$categorytype = "Income Category";
		}
		else if($_GET['transtype'] == "Expense")
		{
			$categorytype = "Expense category";
		}
		$sqlcategory = "SELECT * FROM category WHERE status='Active' AND categorytype='$categorytype'";
		$qsqlcategory = mysqli_query($con,$sqlcategory);
		while($rscategory = mysqli_fetch_array($qsqlcategory))
		{
			if($rscategory['categoryid'] == $rstransaction['categoryid'])
			{
				echo "<option value='$rscategory[categoryid]' selected>$rscategory[categoryname]</option>";
			}
			else
			{
				echo "<option value='$rscategory[categoryid]'>$rscategory[categoryname]</option>";
			}
		}
		 ?>
		</select>
	</div>
	<div class="col-md-4"></div>
</div>
<br>	
<div class="row">
	<div class="col-md-3">Title</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="ititle" id="ititle" value="<?php echo  $rsedit['title'];  ?>">
	</div>
	<div class="col-md-4"></div>
</div>
<br>

<div class="row">
	<div class="col-md-3">Transaction Date</div>
	<div class="col-md-5">
		<input type="Date" class="form-control" name="itrandate" id="itrandate" value="<?php echo  $rstransaction['transdate'];  ?>">
	</div>
	<div class="col-md-4"></div>
</div>
<br>
<div class="row">
	<div class="col-md-3">Total Cost</div>
	<div class="col-md-5">
		<input type="text"  class="form-control" name="icost" id="icost"  value="<?php echo  $rstransaction['totalamt'];  ?>">
	</div>
	<div class="col-md-4"></div>
</div>
<br>

<div class="row">
	<div class="col-md-3">Payment Type</div>
	<div class="col-md-5">		
		<select class="form-control" name="ipaytype" id="ipaytype" > 
			<option value="">Select Payment Type</option>
			<?php
			$arr = array("Cash","Cheque","Bank Transfer","Others");
			foreach($arr as $val)
			{
				if($val == $rstransaction['paymentdetail'])
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
<br>
<div class="row">
	<div class="col-md-3">Transaction Description</div>
	<div class="col-md-5">
		<textarea class="form-control" name="idescr" id="idescr" placeholder="Enter transaction detail.."><?php echo $rstransaction['transdetails'];  ?></textarea>
	</div>
	<div class="col-md-4"></div>
</div>
<br>

</div>
        <!-- /.card-body -->
        <div class="card-footer">

<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-5">
		<input class="form-control"  type="submit" name="isubmit" id="isubmit" value="Submit">
	</div>
	<div class="col-md-4"></div>
</div>
</form>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->



  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->