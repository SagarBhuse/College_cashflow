<?php
session_start();
if(isset($_SESSION['employeeid']))
{
 echo "<script>window.location='dashboard.php';</script>";
}
if(isset($_SESSION['studentid']))
{
 echo "<script>window.location='studentaccount.php';</script>";
}
include("databaseconnection.php");
//###Default Data in Account table starts here
//$sql = "INSERT INTO account(accountid,accounttype,accountdes,status) VALUES('1','STUDENT FEES','Student Fees Record','Active')";
//$qsql = mysqli_query($con,$sql);
//###Default Data in Account table ends  here
//###Default Data in Account table starts here
//$sql = "INSERT INTO account(accountid,accounttype,accountdes,status) VALUES('2','CASH COUNTER','Student Fees Record','Active')";
//$qsql = mysqli_query($con,$sql);
//###Default Data in Account table ends  here
//###Default Data in Account table starts here
//$sql = "INSERT INTO account(accountid,accounttype,accountdes,status) VALUES('3','SALARY ACCOUNT','SALARY ACCOUNT Record','Active')";
//$qsql = mysqli_query($con,$sql);
//###Default Data in Account table ends  here
if(isset($_POST["btnlogin"]))
{
	$sql = "SELECT * FROM employee WHERE empcode='$_POST[loginid]' AND password='$_POST[password]' AND status='Active'";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_num_rows($qsql) == 1)
	{
		$rs = mysqli_fetch_array($qsql);
		$_SESSION['employeeid']  = $rs['employeeid'];
		$_SESSION['emptype']  = $rs['emptype'];
		if($rs['emptype'] == "Administrator" || $rs['emptype'] == "Employee")
		{
			echo "<script>window.location='dashboard.php';</script>";
		}
		else
		{
			echo "<script>window.location='empdashboard.php';</script>";
		}
	}
	else
	{
		echo "<script>alert('Entered Login credentials not valid..');</script>";
	}
}
if(isset($_POST["studentsubmit"]))
{ 
	$sql = "SELECT * FROM student WHERE regno='$_POST[studentrollno]' AND password='$_POST[studentpassword]' AND status='Active'";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_num_rows($qsql) == 1)
	{
		$rs = mysqli_fetch_array($qsql);
		$_SESSION['studentid']  = $rs['studentid'];
		echo "<script>window.location='studentaccount.php';</script>";
	}
	else
	{
		echo "<script>alert('Entered Login credentials not valid..');</script>";
	}
}
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>College_Cashflow</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page" style="background-image: url('images/cashflow.jpg');background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">

<div class="row">
	<div class="col-md-6">
	<br><br><br>
	<br><br><br>
	<br><br><br>
	<br><br><br>
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><b>STUDENT LOGIN WINDOW</b></p>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="studentrollno" id="studentrollno" class="form-control" placeholder="Enter Roll Number">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="studentpassword" id="studentpassword" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>


      <div class="social-auth-links text-center mb-3">
		<input type="submit" class="btn btn-block btn-primary"
        value=" Click here to Login " name="studentsubmit">
      </div>
      <!-- /.social-auth-links -->

      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>


	
	</div>
	<div class="col-md-6">
	<br><br><br>
	<br><br><br>
	<br><br><br>
	<br><br><br>
	


<div class="login-box">

  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><B>ADMIN & STAFF LOGIN WINDOW</B></p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="loginid" id="loginid" class="form-control" placeholder="Enter Login ID">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>


      <div class="social-auth-links text-center mb-3">
		<input type="submit" class="btn btn-block btn-primary"
        value=" Click here to Login " name="btnlogin">
      </div>
      <!-- /.social-auth-links -->

      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>


	
	
	</div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
