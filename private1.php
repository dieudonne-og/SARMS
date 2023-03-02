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
    $classid=$_POST['classid'];
$subjectname=$_POST['subjectname'];
$ongoing=$_POST['ongoing'];
$subjectcode=$_POST['subjectcode'];
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
$sql="INSERT INTO  message(SubjectName,classid,ongoing,SubjectCode,type) VALUES(:subjectname,:classid,:ongoing,:subjectcode,:type)";
$query = $dbh->prepare($sql);
$query->bindParam(':subjectname',$subjectname,PDO::PARAM_STR);
$query->bindParam(':classid',$classid,PDO::PARAM_STR);

$query->bindParam(':ongoing',$ongoing,PDO::PARAM_STR);
$query->bindParam(':subjectcode',$subjectcode,PDO::PARAM_STR);
$query->bindParam(':type',$type,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Message Sent";
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
        <title>Personal Messages</title>
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
<style type="text/css">
    
        .announ{
            font-size: 14px;
            background-color: white;
            color: black;
            font-style: bold;
    border-radius: 10px 
margin:5px;
            
        }

.section{
    height: 350px;
   overflow-y:auto; ;
margin: 5px;
    border-radius: 5px;
    background-color: white;

}
p{
border-color:#a1c0e4;
    border: 1px solid;
margin: 10px;

   border-color:#a1c0e4;

</style>

            <!-- ========== TOP NAVBAR ========== -->
  <?php include('includes/topbar.php');?> 
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                   <?php include('includes/leftbar1.php');?>  
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                     <div class="container-fluid">
                         
                              
                                
                                <!-- /.col-md-6 text-right -->
                          
                            <!-- /.row -->
                            
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">
                           
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Personal Messages</h5>
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
                                        <?php } ?>                 <section class="section" >
                            <div class="container-fluid" >
                                        <div class="announ">
               
<?php $sql = "SELECT message.ongoing,message.SubjectName,message.type,message.Creationdate,message.classid, admin.classid,admin.UserName from message join admin on admin.UserName=message.classid  where message.classid='".$_SESSION['alogin']."' OR ongoing='".$_SESSION['alogin']."' ORDER BY message.id DESC";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
<tr>
                                                            <?php 
                                                        ?>
                                                                  
<p>
                                                                        <a href="#" style="color: skyblue;font-size: 16px;text-align: center;font-style: bold;" > <?php echo htmlentities($result->SubjectName); ?>  -> <?php echo htmlentities($result->classid); ?></a><br><?php echo htmlentities($result->type); ?><br><a href="#" style="color:#2c3e50;"><?php echo htmlentities($result->Creationdate); ?></a></b>
                                                                    <?php
                                                                }
                                                            }
                                                                ?>
</P></div>
<?php $cnt=$cnt+1; ?>
                                                   </p>
                           </section>
                    </div>
                                                <form class="form-horizontal" method="post">
                                                    
     <?php
    $sql = "SELECT classid,UserName from admin where UserName='".$_SESSION['alogin']."'  " ;
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>                                                         

                                                      <input type="hidden"style="color: white;border: none;width: 0px;height:0px;" name="subjectname" class="form-control" id="default" placeholder="Enter your names or your position" required="required" value="<?php echo htmlentities($result->classid);?>">
<input type="hidden"style="color: white;border: none;width: 0px;height:0px;" name="ongoing" class="form-control" id="default" placeholder="Enter your names or your position" required="required" value="<?php echo htmlentities($result->UserName);?>">
                                                        <?php
}}?>
                                                    <label for="default" class="col-sm-2 control-label">Send to</label>
                                                    <div class="col-sm-10">
                                                        <select name="classid" class="form-control" id="default" >
                                                            <option value="">Choose Recepient</option>
                                                            <?php $sql = "SELECT * from admin";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {   ?>
                                                                    <option value="<?php echo htmlentities($result->UserName); ?>"><?php echo htmlentities($result->classid); ?></option>
                                                            <?php }
                                                            } ?>
                                                      
                                                    </div>
                                                </div>

 <input type="field" name="subjectcode"   style="border:none;width: 0px;height: 0px; "hidden value="1">
                                                
                                        
<br>                                <textarea  name="type" class="form-control" id="default" placeholder="Type your message here!......" required="required" style=""></textarea><button type="submit" name="submit" class="btn btn-primary">Send</button>
                                                </div>
                                                    
</div>
                                                  
                                                </form>

                                            </div>                                     </div>
                  
                      
                        <!-- /.section -->  

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
