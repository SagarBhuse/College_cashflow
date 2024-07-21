<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      <img src="dist/img/ietracker.png"
           alt="Income expense tracker"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">College CashFlow</span>
    </a>
<?php
if(isset($_SESSION['employeeid']))
{
 ?>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php 
		  if($rsprofile['img'] == "")
		  {
			  echo "images/defaultimg.png";
		  }
		  else if(file_exists("imgemployee/" . $rsprofile['img']))
		  {
			  echo "imgemployee/".$rsprofile['img'];
		  }
		  else
		  {
		  echo "images/defaultimg.png" ; 
		  }
		   ?>" class="img-circle elevation-2" alt="<?php echo $rsprofile['empname'];  ?>">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $rsprofile['empname'];  ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               <br /> with font-awesome or any other icon font library -->
<?php
if($rsprofile['emptype'] == "Administrator" || $rsprofile['emptype'] == "Employee")
{
?>			   
          <li class="nav-item has-treeview">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
		   
<li class="nav-header">INCOME EXPENSE REPORT</li>  
<li class="nav-item has-treeview">
	<a href="#" class="nav-link">
	  <i class="nav-icon fas fa-table"></i>
	  <p>
	 ACCOUNTS LIST
		<i class="fas fa-angle-left right"></i>
	  </p>
	</a>
	<ul class="nav nav-treeview">
	  <li class="nav-item">
		<a href="viewallaccounts.php" class="nav-link">
		  <i class="far fa-circle nav-icon"></i>
		  <?php
		 $sqltransincome1= "SELECT SUM(totalamt) FROM transaction where transtype='Income'";
		$qsqltransincome1 = mysqli_query($con,$sqltransincome1);
		$rstranincome1 = mysqli_fetch_array($qsqltransincome1);
		$totincome1 = $rstranincome1[0];
		$sqltransexpense1= "SELECT SUM(totalamt) FROM transaction where  transtype='Expense'";
		$qsqltransexpense1 = mysqli_query($con,$sqltransexpense1);
		$rstranexpense1 = mysqli_fetch_array($qsqltransexpense1);
		$totexpense1 = $rstranexpense1[0];
		$balincexp1 = $totincome1 - $totexpense1;
		   ?>
		  <p>All Accounts (₹<?php echo $balincexp1;  ?>)</p>
		</a>
	  </li>
<?php
	$sqlaccountlist ="SELECT * FROM account WHERE status='Active' ORDER BY accounttype";
	$qsqlaccountlist = mysqli_query($con,$sqlaccountlist);
	while($rsaccountlist = mysqli_fetch_array($qsqlaccountlist))
	{
		$sqltransincome= "SELECT SUM(totalamt) FROM transaction where accountid='$rsaccountlist[accountid]' AND transtype='Income'";
		$qsqltransincome = mysqli_query($con,$sqltransincome);
		$rstranincome = mysqli_fetch_array($qsqltransincome);
		$totincome = $rstranincome[0];
		$sqltransexpense= "SELECT SUM(totalamt) FROM transaction where accountid='$rsaccountlist[accountid]' AND transtype='Expense'";
		$qsqltransexpense = mysqli_query($con,$sqltransexpense);
		$rstranexpense = mysqli_fetch_array($qsqltransexpense);
		$totexpense = $rstranexpense[0];
		$sqlPayroll= "SELECT SUM(totalamt) FROM transaction where accountid='$rsaccountlist[accountid]' AND transtype='Payroll'";
		$qsqlPayroll = mysqli_query($con,$sqlPayroll);
		$rsPayroll = mysqli_fetch_array($qsqlPayroll);
		$totpayroll= $rsPayroll[0];
		$balincexp = $totincome - ($totexpense + $totpayroll);
 ?>		
	  <li class="nav-item">
		<a href="viewietransaction.php?accountid=<?php echo $rsaccountlist[0];  ?>" class="nav-link">
		  <i class="far fa-circle nav-icon"></i>
		  <p><?php echo $rsaccountlist['accounttype'];  ?> (₹<?php echo $balincexp;  ?>)</p>
		</a>
	  </li>
<?php
	}
 ?>	  
	</ul>
</li>

<li class="nav-item has-treeview">
	<a href="#" class="nav-link">
	  <i class="nav-icon fas fa-table"></i>
	  <p>
	Transaction
		<i class="fas fa-angle-left right"></i>
	  </p>
	</a>
	<ul class="nav nav-treeview">
	  <li class="nav-item">
		<a href="viewtransaction.php?transtype=Income" class="nav-link">
		  <i class="far fa-circle nav-icon"></i>
		  <p>Income Report</p>
		</a>
	  </li>
	  <li class="nav-item">
		<a href="viewtransaction.php?transtype=Expense" class="nav-link">
		  <i class="far fa-circle nav-icon"></i>
		  <p>Expense Report</p>
		</a>
	  </li>
	  <li class="nav-item">
		<a href="viewtransaction.php" class="nav-link">
		  <i class="far fa-circle nav-icon"></i>
		  <p>Cr-Dr Report</p>
		</a>
	  </li>
	</ul>
</li>
		  
		  
<li class="nav-header">PAYROLL</li> 

<li class="nav-item has-treeview">
	<a href="#" class="nav-link">
	  <i class="nav-icon fas fa-table"></i>
	  <p>
	   Salary Report
		<i class="fas fa-angle-left right"></i>
	  </p>
	</a>
	<ul class="nav nav-treeview">
	  <li class="nav-item">
		<a href="generatesalary.php" class="nav-link">
		  <i class="far fa-circle nav-icon"></i>
		  <p>Generate Monthly Salary</p>
		</a>
	  </li>
	  <li class="nav-item">
		<a href="viewsalaryreport.php" class="nav-link">
		  <i class="far fa-circle nav-icon"></i>
		  <p>View Monthly Salary</p>
		</a>
	  </li>
	</ul>
</li>
 
<li class="nav-item has-treeview">
	<a href="#" class="nav-link">
	  <i class="nav-icon fas fa-table"></i>
	  <p>
	   Employee
		<i class="fas fa-angle-left right"></i>
	  </p>
	</a>
	<ul class="nav nav-treeview">
	  <li class="nav-item">
		<a href="employee.php" class="nav-link">
		  <i class="far fa-circle nav-icon"></i>
		  <p>Add Employee</p>
		</a>
	  </li>
	  <li class="nav-item">
		<a href="viewemployee.php" class="nav-link">
		  <i class="far fa-circle nav-icon"></i>
		  <p>View Employee</p>
		</a>
	  </li>
	</ul>
</li>

		  
		  <li class="nav-header">STUDENT SETTINGS</li>
		  
		  <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
             GENERATE INVOICE
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="generateinovice.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Fee Invoice</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="viewinvoice.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Fee Invoice</p>
                </a>
              </li>
            </ul>
          </li>

		   <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
            STUDENT 
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="student.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add student</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="viewstudent.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View student</p>
                </a>
              </li>
            </ul>
          </li>



<li class="nav-header">ACCOUNTS SETTINGS</li>
<li class="nav-item has-treeview">
		<a href="#" class="nav-link">
		  <i class="nav-icon fas fa-table"></i>
		  <p>
			BANK ACCOUNT
			<i class="fas fa-angle-left right"></i>
		  </p>
		</a>
		<ul class="nav nav-treeview">
		  <li class="nav-item">
			<a href="account.php" class="nav-link">
			  <i class="far fa-circle nav-icon"></i>
			  <p>Add Account</p>
			</a>
		  </li>
		  <li class="nav-item">
			<a href="viewaccount.php" class="nav-link">
			  <i class="far fa-circle nav-icon"></i>
			  <p>View Account</p>
			</a>
		  </li>
		</ul>
 </li>
		  		  
		  
	<li class="nav-header">IE SETTINGS</li>
		  
	<li class="nav-item has-treeview">
	<a href="#" class="nav-link">
	  <i class="nav-icon fas fa-table"></i>
	  <p>
	   CATEGORY
		<i class="fas fa-angle-left right"></i>
	  </p>
	</a>
	<ul class="nav nav-treeview">
	  <li class="nav-item">
		<a href="category.php" class="nav-link">
		  <i class="far fa-circle nav-icon"></i>
		  <p>Add Category</p>
		</a>
	  </li>
	  <li class="nav-item">
		<a href="viewcategory.php?cattype=Income Category" class="nav-link">
		  <i class="far fa-circle nav-icon"></i>
		  <p>View Income Category</p>
		</a>
	  </li>
	  <li class="nav-item">
		<a href="viewcategory.php?cattype=Expense category" class="nav-link">
		  <i class="far fa-circle nav-icon"></i>
		  <p>View Expense Category</p>
		</a>
	  </li>
	</ul>
  </li>
		  
	  <li class="nav-item has-treeview">
		<a href="#" class="nav-link">
		  <i class="nav-icon fas fa-table"></i>
		  <p>
		  FEE SETTINGS
			<i class="fas fa-angle-left right"></i>
		  </p>
		</a>
		<ul class="nav nav-treeview">
		  <li class="nav-item">
			<a href="feetype.php?feetype=Student Fees" class="nav-link">
			  <i class="far fa-circle nav-icon"></i>
			  <p>Add Fee Type</p>
			</a>
		  </li>
		  <li class="nav-item">
			<a href="viewfeetype.php?feetype=Student Fees" class="nav-link">
			  <i class="far fa-circle nav-icon"></i>
			  <p>View Fee Type</p>
			</a>
		  </li>
		</ul>
	  </li>

		<li class="nav-header">MASTER</li>
		    <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
               PROGRAM
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="course.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add PROGRAM</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="viewcourse.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View PROGRAM</p>
                </a>
              </li>
            </ul>
          </li>

		
		<li class="nav-header">USER SETTINGS</li>
		 <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
              USER 
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="user.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add USER</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="viewuser.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View USER</p>
                </a>
              </li>
            </ul>
          </li>
<?php
}
else
{
?>
		  <li class="nav-item has-treeview">
            <a href="empdashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

<li class="nav-item has-treeview">
	<a href="#" class="nav-link">
	  <i class="nav-icon fas fa-table"></i>
	  <p>
	   Salary Report
		<i class="fas fa-angle-left right"></i>
	  </p>
	</a>
	<ul class="nav nav-treeview">
	  <li class="nav-item">
		<a href="viewsalaryreport.php" class="nav-link">
		  <i class="far fa-circle nav-icon"></i>
		  <p>View Monthly Salary</p>
		</a>
	  </li>
	</ul>
</li>
 		  
		   <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
             Employee Account
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="employeeprofile.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>My Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employeechangepassword.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
            </ul>
          </li>
<?php
}
?>
		  
		  </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
<?php
}
if(isset($_SESSION['studentid']))
{
 ?>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php 
		  if($rsstudent['img'] == "")
		  {
			  echo "images/defaultimg.png";
		  }
		  else if(!file_exists("imgprofile/" . $rsstudent['img']))
		  {
			  echo "images/defaultimg.png";
		  }
		  else
		  {
		  echo "imgprofile/" . $rsstudent['img']; 
		  }
		   ?>" class="img-circle elevation-2" alt="<?php echo $rsstudent['studentname'];  ?>" style="width: 200px;height: 200px;"><br>
		<center><a href="#" class="d-block"><?php echo $rsstudent['studentname'];  ?></a></center>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               <br /> with font-awesome or any other icon font library -->
			   
          <li class="nav-item has-treeview">
            <a href="studentaccount.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                My Account
              </p>
            </a>
          </li>
		  
			  
		   <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
            Invoice
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="viewinvoice.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Invoice</p>
                </a>
              </li>
            </ul>
          </li>
		  
		  	  
		   <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
            Transaction
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="viewstudentfeepayment.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View transaction</p>
                </a>
              </li>
            </ul>
          </li>
		  
		  
		   <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
             Student Account
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="studentprofile.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>My Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="studentchangepassword.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
            </ul>
          </li>
		
		  </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
<?php
}
 ?> 
  </aside>