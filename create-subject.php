<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{
if(isset($_POST['submit']))
{
$subjectname=$_POST['subjectname'];
$subjectcode=$_POST['subjectcode'];
$weight=$_POST['weight'];
$passline=$_POST['passline'];
$type=$_POST['type']; 
 //checking pprevious class
        $query = $dbh->prepare("SELECT subjectname,subjectcode,type FROM tblsubjects WHERE subjectname=:subjectname and subjectcode=:subjectcode and type=:type ");
        $query->bindParam(':subjectname', $subjectname, PDO::PARAM_STR);
        $query->bindParam(':subjectcode', $subjectcode, PDO::PARAM_STR);
        $query->bindParam(':type', $type, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            echo "<script>alert('Module Already Exist');</script></p>";
            } else {
$sql="INSERT INTO  tblsubjects(SubjectName,SubjectCode,weight,passline,type) VALUES(:subjectname,:subjectcode,:weight,:passline,:type)";
$query = $dbh->prepare($sql);
$query->bindParam(':subjectname',$subjectname,PDO::PARAM_STR);
$query->bindParam(':subjectcode',$subjectcode,PDO::PARAM_STR);
$query->bindParam(':weight',$weight,PDO::PARAM_STR);
$query->bindParam(':passline',$passline,PDO::PARAM_STR);
$query->bindParam(':type',$type,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Module Created successfully";
}
else 
{
$error="Something went wrong. Please try again";
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Admin Module Creation </title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
  <?php include('includes/topbar.php');?> 
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                   <?php include('includes/leftbar.php');?>  
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                     <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 >Module Creation</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Module</li>
                                        <li class="active">Create a New Module</li>
                                    </ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">
                           
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Create New Module</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                                <form class="form-horizontal" method="post">
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Title</label>
                                                        <div class="col-sm-10">
 <input type="text" name="subjectname" class="form-control" id="default" placeholder="Module Title" required="required">
                                                        </div>
                                                    </div>
<div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Code</label>
                                                        <div class="col-sm-10">
 <input type="text" name="subjectcode" class="form-control" id="default" placeholder="Module Code" >
                                                        </div>
                                                    </div>

<div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Weight</label>
                                                        <div class="col-sm-10">
 <input type="number" name="weight" class="form-control" id="default" placeholder="Module Weight" required="required" min="0" max="300">
                                                        </div>
                                                    </div>      

<div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Passing Line</label>
                                                        <div class="col-sm-10">
 <input type="number" name="passline" class="form-control" id="default" placeholder="Passing Line" required="required"min="0" max="100 ">
                                                        </div>
                                                    </div>                                                                                               
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Competences</label>
                                                        <div class="col-sm-10">
    <div class="col-sm-10">
                                                    <select name="type" class="form-control stid" required="required" >
                                                          <option value="">Select </option>
                                                <option value="1">COMPLEMENTARY MODULES</option>
                                                <option value="2">GENERAL MODULES</option>
                                                <option value="3">SPECIFIC MODULES</option>
                                                
                                                    </select>
                                                </div>
                                                        </div>
                                                    </div>

                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-12 -->
                                </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $(".js-states").select2();
                $(".js-states-limit").select2({
                    maximumSelectionLength: 2
                });
                $(".js-states-hide").select2({
                    minimumResultsForSearch: Infinity
                });
            });
        </script>
    </body>
</html>
<?PHP } ?>
