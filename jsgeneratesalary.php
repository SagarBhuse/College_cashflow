<?php
include("databaseconnection.php");
$template = serialize(array($_POST['employeeid'],$_POST['selectedsalarymonth'],$_POST['selectedsalarydate'],$_POST['empname'],$_POST['empcode'],$_POST['emptype'],$_POST['pfno'],$_POST['grade'],$_POST['bankacno'],$_POST['department'],$_POST['dateofjoining'],$_POST['workingdays'],$_POST['dayspayable'],$_POST['earning1amt'],$_POST['earning2amt'],$_POST['earning3amt'],$_POST['earning4amt'],$_POST['earning5amt'],$_POST['earning6amt'],$_POST['earning7amt'],$_POST['earning8amt'],$_POST['ival1'],$_POST['ival2'],$_POST['ival3'],$_POST['ival4'],$_POST['ival5'],$_POST['ival6'],$_POST['ival7'],$_POST['ival8'],$_POST['deduction1'],$_POST['deduction2'],$_POST['deduction3'],$_POST['deduction4'],$_POST['deduction5'],$_POST['deduction6'],$_POST['deduction7'],$_POST['deduction8'],$_POST['eval1'],$_POST['eval2'],$_POST['eval3'],$_POST['eval4'],$_POST['eval5'],$_POST['eval6'],$_POST['eval7'],$_POST['eval8'],$_POST['totalearnings'],$_POST['totaldeductions'],$_POST['netpay']));
//transaction
$sqltransaction ="UPDATE  transaction SET totalamt='$_POST[netpay]',paymentdetail='$template' WHERE transactionid='$_POST[transactionid]'";
$qsqltransaction = mysqli_query($con,$sqltransaction);
echo mysqli_error($con);
$insid = mysqli_insert_id($con);
//billing_template
$sqlinsertsal ="UPDATE billing_template SET template='$template' where transactionid='$_POST[transactionid]'";
$qsqlinsertsal = mysqli_query($con,$sqlinsertsal);
echo mysqli_error($con);
?>