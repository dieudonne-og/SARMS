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
$sql="INSERT INTO  message(SubjectName,SubjectCode,type) VALUES(:subjectname,:subjectcode,:type)";
$query = $dbh->prepare($sql);
$query->bindParam(':subjectname',$subjectname,PDO::PARAM_STR);
$query->bindParam(':subjectcode',$subjectcode,PDO::PARAM_STR);
$query->bindParam(':type',$type,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Your message has been sucessfull published ";
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
        <title>Group messages</title>
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
      
        .announ{
            font-size: 14px;
            background-color: white;
            color: black;
            font-style: bold;
    border-radius: 10px 

            
        }

.section{
    height: 400px;
   overflow-y:auto; ;

    border-radius: 5px;
    background-color: white;

}
p{
border-color:#a1c0e4;
    border:1px solid;


   border-color:#a1c0e4;

    </style>
    <body class="top-navbar-fixed">
        <div class="main-wrapper"  style="
    
  ">
              <?php include('includes/topbar.php');?>
            <div class="content-wrapper">
                <div class="content-container">

                    <?php include('includes/leftbar1.php');?>

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-sm-6">
                           
                            
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->

                        </div>
                        <!-- /.container-fluid -->
<center>Group messages</center>
                        <section class="section" >
                            <div class="container-fluid" >
                               
                            <!-- /.container-fluid -->  
                                                       
                 <div class="announ">
                             <?php $sql = "SELECT id,SubjectName,SubjectCode,type, classid,Creationdate from message where SubjectCode=!1 order by id desc";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {   ?>
                                                                
  <p>                                                       <b>         

                                                                    <a href="#" style="color: skyblue;font-size: 16px;text-align: center;font-style: bold;" ><?php echo htmlentities($result->SubjectName); ?> :<?php echo htmlentities($result->SubjectCode); ?></a><br><?php echo htmlentities($result->type); ?><br><a href="#" style="color:#2c3e50;"><?php echo htmlentities($result->Creationdate); ?></a></b>
                                                                    <?php
                                                                }
                                                            }
                                                                ?>

                               
 <!--   <td>
<a href="post.php"><div class="announ">
                             <?php $sql = "SELECT id,SubjectName,SubjectCode,type, classid,Creationdate from message  where classid='' ORDER BY id DESC  ";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {   ?>
                                                                
                 <a href="post.php">                                                   
<div class="message">
                                                                    <P class="head"> <b><?php echo htmlentities($result->SubjectName); ?> </</b>
                                                                   <p class="text"><?php echo htmlentities($result->type); ?></p>
                                                                   <p class="writen"> <?php echo htmlentities($result->Creationdate); ?></</p>
                                                                    <?php
                                                                }
                                                            }
                                                                ?></a>
</P></div></td>-->
</tr>
<?php $cnt=$cnt+1; ?>
                                                   </p>
                                                                </div>
                  
                        </section>
                        <!-- /.section -->
                          <form class="form-horizontal" method="post">
                                                    <div class="form-group">
                                                       <div class="col-sm-10">
     <?php
    $sql = "SELECT classid from admin where UserName='".$_SESSION['alogin']."'  " ;
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>                               
                             <div class="col-sm-10">       <div class="col-sm-10">                            
               <input type="hidden"style="color: white;border: none;width: 0px;height: 0px;" name="subjectname" class="form-control" id="default" placeholder="Enter your names or your position" required="required" value="<?php echo htmlentities($result->classid);?>"><?php
}}?></div></div>
                                 <div class="col-sm-10">                         
  <div class="col-sm-10">                                            
 <input type="text" name="subjectcode" class="form-control" id="default" placeholder="Message title" required="required">
                                               </div></div>
                                                        <div class="col-sm-10">
    <div class="col-sm-10">
                                                   <textarea  name="type" class="form-control" id="default" placeholder="Type your message here!......" required="required" style=""></textarea><button type="submit" name="submit" class="btn btn-primary">Send</button>
                                                </div>
                                                    </div>

                                                </form>  

                    </div>
                    <!-- /.main-page -->


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
       
    </body>

    <div class="foot"><footer>

</footer> </div>

<style> .foot{text-align: center; */}</style>
</html>
<?php
}

?>
