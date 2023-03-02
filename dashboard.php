<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {
    header("Location: index.php");
    }
    else{
        if(strlen($_SESSION['alogin'])=="1")
     ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>| Dashboard</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen" >

        <link rel="stylesheet" href="css/icheck/skins/line/blue.css" >
        <link rel="stylesheet" href="css/icheck/skins/line/red.css" >
        <link rel="stylesheet" href="css/icheck/skins/line/green.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <style type="text/css">
       .number_counter {
            font-size: 50px;
            font-family: impact;

        }   
        .name{
            font-size: 16px;
            font-style: bold;

        }
        .head{
            font-size: 14px;
            background-color: #fff;
            color: skyblue;
            border-top:8px solid;border-color: #f2f2f2;
            font-style: bold;



        }
.text{
    background-color: #d9d9d9;
   

}
.writen{
      font-size: 12px;
            background-color: #d9d9d9;
            color: blue;


}
.message{background-color: #d9d9d9;
    width: 500px;
    height: auto;
    overflow-y: auto;
    word-wrap: break-word;
    text-align: center;
    align-content: relative;
}

    </style>
    <body class="top-navbar-fixed">
        <div class="main-wrapper"  style="

  ">
              <?php include('includes/topbar.php');?>
            <div class="content-wrapper">
                <div class="content-container">

                    <?php include('includes/leftbar.php');?>

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-sm-6">
                                    <h2 ">Head of Studies Dashboard  </h2>

                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->

                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <a class="dashboard-stat bg-primary" href="manage-students.php">
<?php
$sql1 ="SELECT StudentId from tblstudents ";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);
$totalstudents=$query1->rowCount();
?>


                                            <span class="number_counter"><?php echo htmlentities($totalstudents);?></span>
                                            <span class="name">Registered Learners</span>
                                            <span class="bg-icon"><i class="fa fa-users"></i></span>
                                        </a>
                                        <!-- /.dashboard-stat -->
                                    </div>
                                    <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <a class="dashboard-stat bg-warning" href="manage-subjects.php">
<?php
$sql ="SELECT id from  tblsubjects ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totalsubjects=$query->rowCount();
?>
                                            <span class="number_counter"><?php echo htmlentities($totalsubjects);?></span>
                                            <span class="name">Modules Listed</span>
                                            <span class="bg-icon"><i class="fa fa-ticket"></i></span>
                                        </a>
                                        <!-- /.dashboard-stat -->
                                    </div>
                                    <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <a class="dashboard-stat bg-danger" href="manage-classes.php">
                                        <?php
$sql2 ="SELECT id from  tblclasses ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$results2=$query2->fetchAll(PDO::FETCH_OBJ);
$totalclasses=$query2->rowCount();
?>
                                            <span class="number_counter"><?php echo htmlentities($totalclasses);?></span>
                                            <span class="name">Total classes listed</span>
                                            <span class="bg-icon"><i class="fa fa-bank"></i></span>
                                        </a>
                                        <!-- /.dashboard-stat -->
                                   </div>
                                    <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <a class="dashboard-stat bg-success" href="manage-results.php">
                                        <?php
$sql3="SELECT  distinct StudentId from  tblresult ";
$query3 = $dbh -> prepare($sql3);
$query3->execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);
$totalresults=$query3->rowCount();
?>

                                            <span class="number_counter"><?php echo htmlentities($totalresults);?></span>
                                            <span class="name">Results Declared</span>
                                            <span class="bg-icon"><i class="fa fa-file-text"></i></span>
                                        </a>

                                    </div>
                            <!-- /.container-fluid --> 

                               

                            
                        </div>
                        </section>
                        <!-- /.section -->
<table id="example" class="" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            
                                                            <th>Group Messages</th>
                                                            
                                                
                                                            <th>Personal Messages</th>
                                                                
                                                        </tr>
                                                    </thead>
                                                
                                                    <tbody>
<tr>
      <td>       <div class="announ">
                             <?php $sql = "SELECT id,SubjectName,SubjectCode,type, classid,Creationdate from message where SubjectCode=!1 order by id desc limit 1";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {   ?>
                                                                
                 <a href="post.php">                                                   
<div class="message">
                                                                    <P class="head"> <b><?php echo htmlentities($result->SubjectName); ?> :<?php echo htmlentities($result->SubjectCode); ?></</b>
                                                                   <p class="text"><?php echo htmlentities($result->type); ?></p>
                                                                   <p class="writen"> <?php echo htmlentities($result->Creationdate); ?></</p>
                                                                    <?php
                                                                }
                                                            }
                                                                ?>
</P></div>
                               </td></a>
    <td>
<a href="post.php"><div class="announ">
                             <?php $sql = "SELECT id,SubjectName,SubjectCode,type, classid,Creationdate from message   where classid='' and SubjectCode=1 ORDER BY id DESC limit 1  ";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {   ?>
                                                                
                 <a href="private.php">                                                   
<div class="message">
                                                                    <P class="head"> <b><?php echo htmlentities($result->SubjectName); ?> </</b>
                                                                   <p class="text"><?php echo htmlentities($result->type); ?></p>
                                                                   <p class="writen"> <?php echo htmlentities($result->Creationdate); ?></</p>
                                                                    <?php
                                                                }
                                                            }
                                                                ?>
</P></div></td></a>
</tr>
<?php $cnt=$cnt+1; ?>
                                                    </tbody>
                                                </table>
                    </div>
                    <!-- /.main-page -->

</div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /.main-wrapper -->
        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/waypoint/waypoints.min.js"></script>
        <script src="js/counterUp/jquery.counterup.min.js"></script>
        <script src="js/amcharts/amcharts.js"></script>
        <script src="js/amcharts/serial.js"></script>
        <script src="js/amcharts/plugins/export/export.min.js"></script>
        <link rel="stylesheet" href="js/amcharts/plugins/export/export.css" type="text/css" media="all" />
        <script src="js/amcharts/themes/light.js"></script>
        <script src="js/toastr/toastr.min.js"></script>
        <script src="js/icheck/icheck.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script src="js/production-chart.js"></script>
        <script src="js/traffic-chart.js"></script>
        <script src="js/task-list.js"></script>
        <script>
            $(function(){

                // Counter for dashboard stats
                $('.counter').counterUp({
                    delay: 10,
                    time: 1000
                });

                // Welcome notification
                toastr.options = {
                  "closeButton": true,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
                toastr["success"]( "Welcome to SARMS | ACODES MUSHISHIRO TVET SCHOOL");

            });
        </script>
    </body>

    <
    <div class="foot">

Copryight SARMS ©   <?php
                                $Today = date('y:m:d');
                                $new = date(' Y', strtotime($Today));
                                echo $new;
                                ?>.All Rights Reserved | Powered by Diolichat <footer>

</footer> </div>

<style> .foot{text-align: center; */}</style>
</html>
<?php } ?>
