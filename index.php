<?php
session_start();
error_reporting(0);
include('includes/config.php');

if($_SESSION['alogin']=''){
 
    header("Location: index.php"); 
    
}
if(isset($_POST['login']))
{
$uname=$_POST['username'];
$password=$_POST['password'];
$type=$_POST['type'];
$classid=$_POST['classid'];
$sql ="SELECT classid,Password,type FROM admin WHERE type=0 and classid=:classid and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':classid', $classid, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$_SESSION['alogin']=$_POST['classid'] ;
echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
}
else{
$sql ="SELECT UserName,Password,type,classid FROM admin WHERE type=1 and UserName=:uname and Password=:password and classid=:classid";
$query= $dbh -> prepare($sql);

$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> bindParam(':classid', $classid, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$_SESSION['alogin']=$_POST['username'] ;
echo "<script type='text/javascript'> document.location = 'trainerdash.php'; </script>";
} 



else{

    echo "<script>alert('Invalid Details ');</script>";
   echo "<script>alert('Forget credentials /Contact your Administrator');</script>";
}
}
}

?>

<!DOCTYPE html> <html lang="en"> <head> <meta charset="utf-8"> <meta
http-equiv="X-UA-Compatible" content="IE=edge"> <meta name="viewport"
content="width=device-width, initial-scale=1"> <title>SARMS|  Login</title>
<link rel="stylesheet" href="css/bootstrap.min.css" media="screen" > <link
rel="stylesheet" href="css/font-awesome.min.css" media="screen" > <link
rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" > <link
rel="stylesheet" href="css/prism/prism.css" media="screen" > <!-- USED FOR
DEMO HELP - YOU CAN REMOVE IT --> <link rel="stylesheet" href="css/main.css"
media="screen" > <script src="js/modernizr/modernizr.min.js"></script> <style
type="text/css"> <!-- .style1 {font-size: small} .style3 {font-size: x-large}
--> a:hover { background-color:none; color:blue; text-decoration:none;
        
        font-color:#081d62;
        }
         option{
            background-color: #2c3e50;
            color: white;
            font-size: 14px;
         }
         select{

         }
         h4{
            color: blue;
         }
         input{
            height: 120px;
            font-size: 20px;
           border:none;
         }
         p{
            height:77px;
      background-color: #2c3e50;
            color: white;
            font-size: 16px;
            border-radius: 5px;
         }
.h5{
    color: #2c3e50;
}
        </style>
</head>
    <body class="" style=" background-image: url('images/bgimage.jpg');
    height: 100%;"><center>
        <div class="main-wrapper" style="
    
    align-content: center;

  ">
<!--
            <div class="">
                <div class="row">
 <h1 align="center" bac>   </h1>
                    <div class="col-lg-3 visible-lg-block" >

<section class="section"> 
                            <div class="row mt-30">
                                <div class="col-md-11 col-md-offset-4 pt-50">
<a href="#"> 
                                    <div class="row mt-30 ">
                                        <div class="col-md-11">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                                   <span class="bg-black-600">    </a>                                
                                                 
                                                        <h4>Enter Learner number and get Report </h4>
                                                    </div>
                                                </div>
                                                <div class="panel-body p-20">

                                                    <div class="section-title">
                                                        <p class="sub-title"></p>
                                                    </div>

                                             <form action="result.php" method="post">
                                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-6 control-label">Search your result</label>
                                                            <div class="col-sm-6">
                                                               <a href="find-result.php">click here</a>
</div>

    
                                    <div class="form-group mt-20">
                                        <div class="">
                                      
                                           
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                </form>

                                <hr>




                                                </div>
                                            </div>
                                            <!-- /.panel -->
                                                  </span> </div>
                                        <!-- /.col-md-11 -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                            <!-- /.row -->
                        </section>
                    </div> 
                    <div class="col-lg-8">
                        <section class="section">
                            <div class="row mt-3">
                                <div class="col-md-7 col-md-offset-7 pt-50">

 
                                    <div class="row mt-10 " >
                                        <div class="col-md-10" style="background-color: white;>
                                            <div class="panel" style="background-color:white;"><p style="background-color: white;">
 <img src="images/user-icn..jpg" height="98" width="100"></p><H5 class="h5" ><B> LOGIN </B></H5>
                                                <div class="panel-body p-7" style="background-color: white;">

<div class="form-group">
                                                    <form class="form-horizontal" method="post">
                                                        
                                                            
                                                        <div class="form-group"> 
                                                       <select style="border: none; background-color: white;" name="username" class="form-control" id="default" >
                                                            <option  value="">   <h1>Trainer |&nbsp;&nbsp;&nbsp;   Select Class   and Sign in to start</h1></option>
                                                            <?php $sql = "SELECT * from tblclasses";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {   ?>
                                                                    <option value="<?php echo htmlentities($result->id); ?>">

                                                                   <?php echo htmlentities($result->class); ?></option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                            </div>
                                                        </div>
                                                    	<div class="form-group">
                                                    
                                                    		<div class="col-sm-10">
                                                    			<input style="border-bottom: 2px solid; border-bottom-color: #081d62; height: 45px; ;background-color:white;" type="text" name="classid" class="form-control" id="inputEmail3" placeholder="Enter Username">
                                                    		</div>
                                                    	</div><div></div>
                                                    	<div class="form-group">
                                               
                                                    		<div class="col-sm-10">     
                                                    			<input style="border-bottom: 2px solid; border-bottom-color: #081d62; height: 45px; ;background-color:white;" type="password" name="password" class="form-control" id="inputPassword3" placeholder="Enter Password" >
                                                    		</div>
                                                    	</div>

                                                        <div class="form-group mt-30">
                                                    		<div class="col-sm-offset-3 col-sm-5">

                                                    			<button type="submit" name="login" class="btn btn-primary btn-labeled pull-right">Sign in<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                                                
                                                    		</div>
                                                    	</div>
                                                    </form>




                                                </div><small>SARMS ©   <?php
                                $Today = date('y:m:d');
                                $new = date(' Y', strtotime($Today));
                                echo $new;
                                ?>.All Rights Reserved |<a href="diolichat.com"> Developed by Diolichat </a> </small>
                                            </div>
                                            <!-- /.panel -->
                                        </div>
                                        <!-- /.col-md-11 -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                            <!-- /.row -->
                        </section>

                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /. -->

        </div></center>
        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function(){

            });
        </script>

        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
    </body>
</html>
