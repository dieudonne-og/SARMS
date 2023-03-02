<?php
include('includes/config.php');
$searchErr = '';
$employee_details='';
$StudentId='';
if(isset($_POST['save']))
{
    if(!empty($_POST['search']))
    {
        $search = $_POST['search'];
        $stmt = $dbh->prepare("SELECT tblstudents.StudentId, tblstudents.studentname,tblstudents.roolid,tblstudents.yearr, tblclasses.classname,tblclasses.section,tblclasses.classnamenumeric,tblclasses.class from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId  where studentname like '%$search%' or roolid like '%$search%'");
        $stmt->execute();
        $employee_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $StudentId = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //print_r($employee_details);
         
    }
    else
    {
        $searchErr = "Please enter the information";
    }
    
}
 
?>
<html>
<head>
<title>Learners results info</title>
<link rel="stylesheet" href="bootstrap.css" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap-theme.css" crossorigin="anonymous">

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
<style>
.container{
    width:70%;
    height:30%;
    padding:20px;
}
</style>
</head>
 
<body>
    <div class="container">
    
    <form class="form-horizontal" action="find-result.php" method="post">
    <div class="row"><CENTER><h1>SARMS</h1></CENTER>
        <div class="form-group">
            <label class="control-label col-sm-4" for="email"><b>Check Assessments Information</b>:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="search" placeholder="Search by names or Reg-Number"  maxlength="20" minlength="6">
            </div>
            <div class="col-sm-2">
              <button type="submit" name="save" class="btn btn-success btn-sm">Search</button>
            </div>
        </div>
        <div class="form-group">
            <span class="error" style="color:red;">* <?php echo $searchErr;?></span>
        </div>
         
    </div>
    </form>
    
    <div class="table-responsive">          
      <table class="table">
        <thead>
          <tr>
            <th>N0</th>
            <th>Full Name</th>
            <th>Reg-Number</th>
            <th>Class</th>
            <th>Level</th>
            <th>Ac-Year</th>
            
          </tr>
        </thead>
        <tbody>
                <?php
                 if(!$employee_details)
                 {
                    echo '<tr>No data found</tr>';
                 }
                 else{
                    foreach($employee_details as $key=>$value)
                    {
                        ?>
                    <tr>
                        <td><?php echo $value['StudentId'];?></td>
                        <td><a  href="summary-report.php?StudentId=<?php echo $value['StudentId'];?>"><?php echo $value['studentname'];?></a></td>
                        <td><a  href="summary-report.php?StudentId=<?php echo $value['StudentId'];?>"><?php echo $value['roolid'];?></td></a>
                        <td><?php echo $value['class'];?></td>
                        <td><?php echo $value['section'];?></td>
                        <td><?php echo $value['yearr'];?>-<?php echo $value['yearr']+1;?>
                    </tr>
                         
                        <?php
                    }
                     
                 }
                ?>
             
         </tbody>
      </table>

        <small>SARMS ©   <?php
                                $Today = date('y:m:d');
                                $new = date(' Y', strtotime($Today));
                                echo $new;
                                ?>.All Rights Reserved |<a href="diolichat.com"> Developed by Diolichat </a> </small>
 
<script src="jquery-3.2.1.min.js"></script>
<script src="bootstrap.min.js"></script>
<script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $('#example').DataTable();

                $('#example2').DataTable({
                    "scrollY": "300px",
                    "scrollCollapse": true,
                    "paging": false
                });

                $('#example3').DataTable();
            });
        </script>


                                            </div>

</body>

</html>
