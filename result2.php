
<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
                                              <div class="panel-title">
<?php
/*

$qery = "SELECT   tblstudents.studentname,tblstudents.Roolid,tblstudents.RegDate,tblstudents.StudentId,tblstudents.Status,tblclasses.ClassName,tblclasses.Section from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId where tblstudents.roolid=:roolid and tblstudents.ClassId=:classid ";
$stmt = $dbh->prepare($qery);
$stmt->bindParam(':roolid',$roolid,PDO::PARAM_STR);
$stmt->bindParam(':classid',$classid,PDO::PARAM_STR);
$stmt->execute();
$resultss=$stmt->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($stmt->rowCount() > 0)
{
foreach($resultss as $row)
{   ?>
<?php }

    ?>
                                            </div>
                                         
<?php                                              
// Code for result

 $query ="select t.studentname,t.Roolid,t.ClassId,t.marks,SubjectId,tblsubjects.SubjectName from (select sts.studentname,sts.Roolid,sts.ClassId,tr.marks,SubjectId from tblstudents as sts join  tblresult as tr on tr.StudentId=sts.StudentId) as t join tblsubjects on tblsubjects.id=t.SubjectId where (t.roolid=:roolid and t.ClassId=:classid)";
$query= $dbh -> prepare($query);
$query->bindParam(':roolid',$roolid,PDO::PARAM_STR);
$query->bindParam(':classid',$classid,PDO::PARAM_STR);
$query-> execute();  
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($countrow=$query->rowCount()>0)
{ 

foreach($results as $result){

    ?>

                                                    <tr>
                                                <th scope="row"><?php echo htmlentities($cnt);?></th>
                                                      <td><?php echo htmlentities($result->SubjectName);?></td>
                                                      <td><?php echo htmlentities($totalmarks=$result->marks);?></td>
                                                    </tr>
<?php 
$totlcount+=$totalmarks;
$cnt++;}
?>
<tr>
                                                <th scope="row" colspan="2">Total Marks</th>
<td><b><?php echo htmlentities($totlcount); ?></b> out of <b><?php echo htmlentities($outof=($cnt-1)*100); ?></b></td>
                                                        </tr>
<tr>
                                                <th scope="row" colspan="2">Percntage</th>           
                                                            <td><b><?php echo  htmlentities($totlcount*(100)/$outof); ?> %</b></td>
                                                             </tr>
<tr>
                                                <th scope="row" colspan="2">Download Result</th>           
                                                            <td><b><a href="download-result.php">Download </a> </b></td>
                                                             </tr>

 <?php } else { ?>     
<div class="alert alert-warning left-icon-alert" role="alert">
                                            <strong>Notice!</strong> Your result not declare yet
 <?php }
?>
                                        </div>
 <?php 
 } else
 {?>



                                                  </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-md-6 -->

                                    <div class="form-group">
                                                           
                                                            <div class="col-sm-6">
                                                               <a href="index.php">Go Home </a>
                                                            </div>
                                                        </div>

                                </div>
                                <!-- /.row -->
  
                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.section -->

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
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function($) {

            });
        </script>

        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->

    </body>
</html>
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Learner Report</title>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style2 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }
.style5 {
	font-size: 12px;
	font-weight: bold;
}
.style6 {font-size: 12px}
.style7 {
	font-size: 14px;
	font-weight: bold;
}
#Layer1 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:1;
	left: 59px;
	top: 951px;
}
.style9 {font-size: 16px; font-weight: bold; }
.style10 {font-size: 12; }
-->
</style>
</head>

<body>
 
<table width="1169" height="914" border="1">
  <tr>
    <td height="0" colspan="20"><p align="left" class="style1">REPUBLIC OF RWANDA </p>
        <p><strong>MINISTRY OF EDUCATION</strong>
            <label></label>
        </p>
      <table width="252" border="0" align="right">
          <tr>
            <td><strong>ACADEMIC YEAR: </strong></td>
          </tr>
          <tr>
            <td><strong>CLASS:</strong></td>
          </tr>
          <tr>
            <td><strong>LEARNER NAME: </strong> <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "srms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$StudentId=$_SESSION['roolid'];

  $sql = "SELECT studentname FROM tblstudents where StudentId=roolid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "" . $row["studentname"].  "<br>";
  }
} else {
  echo "none";
}
?><p></p></td>
          </tr>
        </table>
      <p><strong>DISTRICT:</strong> </p>
      <p><strong>SCHOOL: ERM HOPE TVET SCHOOL</strong></p>
      <p><strong>EMAIL:</strong></p>
      <p><strong>TEL: </strong></p></td>
  </tr>
  <tr>
    <td colspan="20"><div align="center"><strong>LEARNER'S ASSESSMENT REPORT</strong></div></td>
  </tr>
  <tr>
    <td colspan="2" class="style2">SECTOR:</td>
    <td colspan="5">&nbsp;</td>
    <td colspan="13"><strong>QUALIFAICATION TITLE:</strong></td>
  </tr>
  <tr>
    <td colspan="2"><span class="style2">TRADE:</span></td>
    <td colspan="5">&nbsp;</td>
    <td colspan="13"><strong>RTQF LEVEL:</strong></td>
  </tr>
  <tr>
    <td colspan="2" rowspan="2"><span class="style2">BEHAVIOR:</span></td>
    <td width="41" height="32"><span class="style5">MAX</span></td>
    <td colspan="4"><div align="center"><strong>TERM 1 </strong></div></td>
    <td colspan="4"><div align="center"><strong>TERM 2 </strong></div></td>
    <td colspan="4"><div align="center"><strong>TERM 3 </strong></div></td>
    <td colspan="3"><div align="center"><strong>Annual Average(%) </strong></div></td>
    <td width="48">&nbsp;</td>
  </tr>
  <tr>
    <td>40</td>
    <td colspan="4">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <style>
  span.style6 {
  writing-mode: vertical-rl; 
}
</style>
    <td width="49" height="136"><span class="style7">Module Code</span> </td>
    <td width="59"><span class="style7">Module Title </span></td>
    <td valign="top"><span class="style6">Module weight </span>      </p></td>
    <td width="30" align="left" valign="baseline"><span class="style6"><p class="style6">Formative Assessment </p>
    </td>
    <td width="28" valign="top"><span class="style6">Integreted Assessment </span></td>
    <td width="30" valign="top"><span class="style6">Comprehensive Assessment </span></td>
    <td width="30" valign="top"><span class="style6">Total Marks</span> </td>
    <td width="30"><span class="style6">Formative Assessment</span></td>
    <td width="28"><span class="style6">Integreted Assessment</span></td>
    <td width="30"><span class="style6">Comprehensive Assessment </span></td>
    <td width="30"> <span class="style6">Total Marks</td>
    <td width="30"><span class="style6">Formative Assessmen</span></td>
    <td width="20"><span class="style6">Integreted Assessment</span></td>
    <td width="30"><span class="style6">Comprehensive Assessment </span></td>
    <td width="30"><span class="style6">Total Marks</span></td>
    <td width="30"><span class="style6">Total Annual </span></td>
    <td width="28"><span class="style6">Annual % </span></td>
    <td width="30"><span class="style6">Re-Assessment</span></td>
    <td><span class="style6">Decision</span></td>
  </tr>
  <tr>
    <td colspan="19"><strong>COMPLEMENTARY MODULES </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style5"><strong>N/A</strong></span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="19"><div align="center"><strong>CORE MODULES</strong></div></td>
  </tr>
  <tr>
    <td colspan="19"><strong>GENERAL MODULES </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>N/A</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="19"><strong>SPECIFIC MODULES </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="style7"><span class="style7"><strong>TOTAL</strong></span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><span class="style7"><strong>PERCENTAGE</strong></span></td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><span class="style7"><strong>POSITION</strong></span></td>
    <td colspan="5">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><span class="style5">Class Trainer's Comment &amp; Signature </span></td>
    <td colspan="5">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td height="23" colspan="9" rowspan="4" align="center"><div class="style9" id="Layer1">Deliberation</div>
        <table width="200" border="0" align="right">
          <tr>
            <td>Promoted at 1st setting </td>
          </tr>
          <tr>
            <td>Promoted after re-assessment </td>
          </tr>
          <tr>
            <td>Adviced to repeat </td>
          </tr>
          <tr>
            <td>Dissmissed</td>
          </tr>
      </table></td>
    <td>&nbsp;</td>
    <td colspan="9" rowspan="4"><span class="style6">
      <label> </label>
      </span>
        <label></label>
      <div align="center" class="style10"><strong>School Manager: </strong></div>
      <div align="center" class="style10"><strong>&nbsp;</strong></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
