
<?php

error_reporting(0);
include('includes/config.php');


?>
 <?php
  include('includes/config.php');
  $studentId = floatval($_GET["StudentId"]);
  function getStudentPosition($StudentId=0,$positionType="annual"){
    global $dbCon;
    if($StudentId>0 && !empty($positionType)){
      $posSql="";
      if($positionType=="annual"){
        $posSql="SELECT *, SUM(`marks`) AS 'totalMarks' FROM `tblresult` WHERE `academicYear`=(SELECT `academicYear` FROM `tblresult` WHERE `StudentId`=".$StudentId." LIMIT 1) AND `ClassId`=(SELECT `ClassId` FROM `tblresult` WHERE `StudentId`=".$StudentId." LIMIT 1) GROUP BY `StudentId` ORDER BY SUM(`marks`) DESC";
      }else if($positionType=="term1"){
        $posSql="SELECT *, SUM(`marks`) AS 'totalMarks' FROM `tblresult` WHERE `term`=1 AND `academicYear`=(SELECT `academicYear` FROM `tblresult` WHERE `StudentId`=".$StudentId." LIMIT 1) AND `ClassId`=(SELECT `ClassId` FROM `tblresult` WHERE `StudentId`=".$StudentId." LIMIT 1) GROUP BY `StudentId` ORDER BY SUM(`marks`) DESC";
      }else if($positionType=="term2"){
        $posSql="SELECT *, SUM(`marks`) AS 'totalMarks' FROM `tblresult` WHERE `term`=2 AND `academicYear`=(SELECT `academicYear` FROM `tblresult` WHERE `StudentId`=".$StudentId." LIMIT 1) AND `ClassId`=(SELECT `ClassId` FROM `tblresult` WHERE `StudentId`=".$StudentId." LIMIT 1) GROUP BY `StudentId` ORDER BY SUM(`marks`) DESC";
      }else if($positionType=="term3"){
          $posSql="SELECT *, SUM(`marks`) AS 'totalMarks' FROM `tblresult` WHERE `term`=3 AND `academicYear`=(SELECT `academicYear` FROM `tblresult` WHERE `StudentId`=".$StudentId." LIMIT 1) AND `ClassId`=(SELECT `ClassId` FROM `tblresult` WHERE `StudentId`=".$StudentId." LIMIT 1) GROUP BY `StudentId` ORDER BY SUM(`marks`) DESC";
      }else{
        return "N/A";
      }
      if($posSql!=""){
        if($qry=mysqli_query($dbCon,$posSql)){
          $studentsSql="SELECT COUNT(`StudentId`) AS 'totalNumStudents'  FROM `tblstudents` WHERE `yearr`=(SELECT `yearr` FROM `tblstudents` WHERE `StudentId`=".$StudentId.") AND `classId`=(SELECT `classId` FROM `tblstudents` WHERE `StudentId`=".$StudentId.")";
          $studentsQry=mysqli_query($dbCon,$studentsSql);
          $totalStudents=mysqli_fetch_assoc($studentsQry)["totalNumStudents"];
          //$totalStudents.=" >> ".$posSql;
          $studentPosition=0;
          while($row=mysqli_fetch_assoc($qry)){
            $studentPosition+=1;
            if($row["StudentId"]==$StudentId){
              if($studentPosition==1) return "1st out of ".$totalStudents;
              if($studentPosition==2) return "2nd out of ".$totalStudents;
              if($studentPosition==3) return "3rd out of ".$totalStudents;
              return $studentPosition."th out of ".$totalStudents;
              exit();
            }
          }
          if($studentPosition<=0){
            return "N/A";
          }
        }else{
          return "N/A";
        }
      }else{
        return "N/A";
      }
    }else{
      return "N/A";
    }
  }
  function getSubjectListAccordingToSubjectType($studentId = 0, $subjectType = 1)
  {
    global $dbCon;
    if ($studentId > 0) {
      $sql = "SELECT `tblsubjects`.* FROM `tblstudents`,`tblsubjectcombination`,`tblsubjects` WHERE `tblstudents`.`classId`=`tblsubjectcombination`.`ClassId` AND `tblsubjectcombination`.`SubjectId`=`tblsubjects`.`id` AND `tblsubjectcombination`.`status`=1 AND `tblsubjects`.`type`=" . $subjectType . " AND `tblstudents`.`StudentId`=" . $studentId . " ORDER BY `tblsubjects`.`SubjectCode`";
      if ($query = mysqli_query($dbCon, $sql)) {
        if (mysqli_num_rows($query) > 0) {
          return mysqli_fetch_all($query, MYSQLI_ASSOC);
        } else {
          return [];
        }
      }
    } else {
      return [];
    }
  }
  function getSubjectMarksBySubjectId($studentId = 0, $subjectId=0, $termId = 1, $assementType=1)
  {
    global $dbCon;
    if ($studentId > 0 && $subjectId>0) {
      $sql = "SELECT * FROM `tblresult` WHERE `StudentId`=".$studentId." AND `SubjectId`=".$subjectId." AND `term`=".$termId." AND `type`=".$assementType;
      if ($query = mysqli_query($dbCon, $sql)) {
        if (mysqli_num_rows($query) > 0) {
          return mysqli_fetch_assoc($query)["marks"];
        } else {
          return "";
        }
      }else{
        return "";
      }
    } else {
      return "";
    }
  }

  function getBehaviorMarks($studentId = 0, $term=1){
    global $dbCon;
    if ($studentId > 0 && $term>0) {
      $sql = "SELECT * FROM `tblbehavior` WHERE `StudentId`=".$studentId." AND `term`=".$term;
      if ($query = mysqli_query($dbCon, $sql)) {
        if (mysqli_num_rows($query) > 0) {
          return mysqli_fetch_assoc($query)["marks"];
        } else {
          return "";
        }
      }else{
        return "";
      }
    } else {
      return "";
    }
  }

  function getSubjectReAssesmentMarksBySubjectId($studentId = 0, $subjectId=0)
  {
    global $dbCon;
    if ($studentId > 0 && $subjectId>0) {
      $sql = "SELECT * FROM `tbl_reassessment_result` WHERE `StudentId`=".$studentId." AND `SubjectId`=".$subjectId;
      if ($query = mysqli_query($dbCon, $sql)) {
        if (mysqli_num_rows($query) > 0) {
          return mysqli_fetch_assoc($query)["marks"];
        } else {
          return "";
        }
      }else{
        return "";
      }
    } else {
      return "";
    }
  }
$sql = "SELECT tblstudents.studentname,tblstudents.roolid,tblstudents.yearr,tblclasses.title,tblclasses.classname,tblclasses.classnamenumeric,tblclasses.section,tblclasses.class from tblstudents left join tblclasses on tblclasses.id=tblstudents.ClassId WHERE `tblstudents`.`StudentId`=" . $studentId . " AND `tblstudents`.`classId`=`tblclasses`.`id`";
  if ($query = mysqli_query($dbCon, $sql)) {
    if (mysqli_num_rows($query) == 1) {
      $studentInfo = mysqli_fetch_assoc($query);
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title><?php echo ucfirst($studentInfo['studentname']);  ?> marks updates</title>
  <style type="text/css">
    <!--

    .style7 {
      font-size: 14px;
      font-weight: bold;
    }

    #Layer1 {
      position: absolute;
      width: 171px;
      height: 27px;
      z-index: 1;
      left: 243px;
      top: 808px;
    }
#Layer2 {
	position:absolute;
	width:135px;
	height:98px;
	z-index:2;
	left: 534px;
	top: 45px;
}
#Layer3 {
	position:absolute;
	width:441px;
	height:115px;
	z-index:3;
	left: 928px;
	top: 49px;
}
.style6 {color: #333333}
.style12 {
	color: #666666;
	font-size: 9px;
	font-weight: bold;
}
.style17 {font-size: 12px}
.style20 {
	font-size: 12px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style22 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style23 {
	font-size: 16px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style24 {font-size: 14px}
    -->
  </style>
</head>

<body>
 
  <style >
  table {
  border-collapse: collapse ;

}
</style>

      <table width="100%" height="100%" border="1" >
        <tr>
          <td colspan="20">
          <div align="center" class="style23"><?php echo ucfirst($studentInfo['studentname']);  ?> <span class="style24">ASSESSMENT RESULTS INFO o</span>n<?php
                                $Today = date('y:m:d'); 
                                $new = date('l, F d, Y', strtotime($Today));
                                echo $new;
                                ?> </div>          </td>
        </tr>
        <tr>
          <td colspan="2" ><span class="style22"><strong> SECTOR:</strong><?php echo $studentInfo['classname'];  ?></span></td>
          <td colspan="5"><strong>Academic year:</strong> <?php echo $studentInfo['yearr'];  ?> - <?php echo $studentInfo['yearr'] + 1;  ?> </td>
          <td colspan="13"><span class="style22"><strong>QUALIFICATION TITLE:</strong> <?php echo ucfirst($studentInfo['title']);  ?></span></td>
        </tr>
        <tr>
          <td colspan="2"><span class="style22"><strong> TRADE:</strong>  <?php echo ucfirst($studentInfo['classnamenumeric']);  ?></span></td>
          <td colspan="5">&nbsp;</td>
          <td colspan="13"><span class="style22"><strong>RTQF LEVEL: </strong><?php echo ucfirst($studentInfo['section']);  ?> </span></td>
        </tr>
        <tr>
          <td colspan="2" rowspan="2"><span class="style20">BEHAVIOR: </span></td>
          <td width="46" height="32"><span class="style20">MAX</span></td>
          <td colspan="4">
            <div align="center" class="style22"><strong>TERM 1 </strong></div>          </td>
          <td colspan="4">
            <div align="center" class="style22"><strong>TERM 2 </strong></div>          </td>
          <td colspan="4">
            <div align="center" class="style22"><strong>TERM 3 </strong></div>          </td>
          <td colspan="3">
            <div align="center" class="style22"><strong>Annual Average(%) </strong></div>          </td>
          <td width="55">&nbsp;</td>
        </tr>
        <tr>
          <td><span class="style22">40</span></td>
          <td colspan="4"><span class="style22">
          <?= $beTerm1=getBehaviorMarks($studentId, $term=1) ?>
          </span></td>
          <td colspan="4"><span class="style22">
          <?= $beTerm2=getBehaviorMarks($studentId, $term=2) ?>
          </span></td>
          <td colspan="4"><span class="style22">
          <?= $beTerm3=getBehaviorMarks($studentId, $term=3) ?>
          </span></td>
          <td colspan="3"><span class="style22">
          <?= number_format((floatval($beTerm1)+floatval($beTerm2)+floatval($beTerm3))/120*100,2) ?>
          %</span></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="style6">
          <style>
            span.style6 {
              writing-mode: vertical-rl;
            }
          </style>
          <td width="50" height="50"><span class="style20">Module Code</span></td>
          <td width="170"><span class="style20">Module Title </span></td>
         <td valign="top"><span class="style13">Module weight </span>
          <td width="30" align="left" valign="baseline"><p class="style22"><strong><span class="style6">Formative<br /> 
          Assessment </p>          </td>
          <td width="30" valign="top"><p class="style22"><span class="style6"><strong>Integreted<br /> 
          Assessment</strong></p></td>
          <td width="30" valign="top"><p class="style22"><span class="style6"><strong>Comprehensive<br /> 
          Assessment</strong></p></td>
          <td width="20" valign="top"><p class="style22"><span class="style6"><strong>Total Marks</strong></p></td>
          <td width="30" align="left" valign="baseline"><span class="style17"><span class="style22"><span class="style6"><strong>Formative<br />
          Assessment </strong></span></span></td>
          <td width="30" valign="top">            <p class="style22"><span class="style6"><strong>Integreted<br />
          Assessment</strong></p></td>
          <td width="30" valign="top">            <p class="style22"><span class="style6"><span class="style6"><strong>Comprehensive<br />
          Assessment</strong></p></td>
          <td width="20" valign="top">            <p class="style22"><span class="style6"><span class="style6"><strong>Total Marks</strong></p></td>
          <td width="30" align="left" valign="baseline"><p class="style22"><span class="style6"><span class="style6"><strong>Formative<br />
          Assessment </strong></p></td>
          <td width="30" valign="top">            <p class="style22"><span class="style6"><strong>Integreted<br />
          Assessment</strong></p></td>
          <td width="30" valign="top">            <p class="style22"><span class="style6"><span class="style6"><strong>Comprehensive<br />
          Assessment</strong></p></td>
          <td width="20" valign="top">            <p class="style22"><span class="style6"><strong>Total Marks</strong></p></td>
          <td width="20"><p class="style22"><span class="style6"><strong>Total Annual</strong></p></td>
          <td width="30"><p class="style22"><span class="style6"><strong>Annual %</strong></p></td>
          <td width="30"><p class="style22"><span class="style6"><strong>Re-Assessment</strong></p></td>
          <td><p class="style22"><span class="style6"><strong>Decision</strong></p></td>
        </tr>
        <tr>
          <td colspan="19"><span class="style22"><strong>COMPLEMENTARY MODULES</strong></span></td>
        </tr>
        <?php

        $totalTerm1Type1=0;
        $totalTerm1Type2=0;
        $totalTerm1Type3=0;
        $totalTerm2Type1=0;
        $totalTerm2Type2=0;
        $totalTerm2Type3=0;
        $totalTerm3Type1=0;
        $totalTerm3Type2=0;
        $totalTerm3Type3=0;
        $totalna=0;
        $totalnaterm1=0;
        $totalnaterm2=0;
        $totalnaterm3=0;
        $totalNumberOfSubjects=0;
        $grandTotalAnnualna=0;
        $grandTotalAnnual=0;

        $passPercentage=$subjectInfo['passline'];


        foreach (getSubjectListAccordingToSubjectType($studentId, 1) as $subjectInfo) {
          $term1type1=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],1,1);
        $na1type2 = 1;
          $term1type3=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],1,3);
          $term2type1=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],2,1);
          $na2type2 = 1;
          $term2type3=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],2,3);
          $term3type1=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],3,1);
          $na3type2 = 1;
          $term3type3=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],3,3);
          $totalna=floatval($na1type2)+floatval($na2type2)+floatval($na3type2);
          $totalTerm1=floatval($term1type1)+floatval($term1type3);
          $totalTerm2=floatval($term2type1)+floatval($term2type3);
          $totalTerm3=floatval($term3type1)+floatval($term3type3);
          $totalAnnual=$totalTerm1+$totalTerm2+$totalTerm3;
          $totalAnnualPercentage=number_format($totalAnnual/6,2);
          
          $passPercentage=$subjectInfo['passline'];
          $re_assessment="";
          $decision="Competent";
          if($totalAnnualPercentage<$passPercentage){
            $re_assessment=getSubjectReAssesmentMarksBySubjectId($studentId, $subjectInfo['id']);
            if($re_assessment=="" || $re_assessment<$passPercentage){
              $decision="NYC";
            }
          }
          
          $totalNumberOfSubjects+=1;
          $grandTotalAnnual+=$totalAnnual;
          $grandTotalAnnualna+=$totalna;
          $totalTerm1Type1+=floatval($term1type1);
         $totalnaterm1+=floatval($na1type2);
          $totalTerm1Type3+=floatval($term1type3);
          $totalTerm2Type1+=floatval($term2type1);
          $totalnaterm2+=floatval($na2type2);
          $totalTerm2Type3+=floatval($term2type3);
          $totalTerm3Type1+=floatval($term3type1);
          $totalnaterm3+=floatval($na3type2);
          $totalTerm3Type3+=floatval($term3type3);
        ?>
          <tr>
            <td><span class="style22"><?php echo $subjectInfo['SubjectCode']; ?></span></td>
            <td><span class="style22"><?php echo $subjectInfo['SubjectName']; ?></span></td>
            <td><span class="style22"><?php echo $subjectInfo['weight']; ?></span></td>
            <td><span class="style22">&nbsp;
            <?= $term1type1 ?>
            </span></td>
            <td><span class="style22"><strong>&nbsp;N/A</strong></span></td>
            <td><span class="style22">&nbsp;
            <?= $term1type3 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalTerm1 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $term2type1 ?>
            </span></td>
            <td><span class="style22">&nbsp;<strong>&nbsp;N/A</strong></span></td>
            <td><span class="style22">&nbsp;
            <?= $term2type3 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalTerm2 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $term3type1 ?>
            </span></td>
            <td><span class="style22"><strong>&nbsp;N/A</strong></span></td>
            <td><span class="style22">&nbsp;
            <?= $term3type3 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalTerm3 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalAnnual ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalAnnualPercentage ?></span></td>
            <td><span class="style22">&nbsp;
            <?= $re_assessment ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $decision ?>
            </span></td>
          </tr>
        <?php
        }
        ?>

        <tr>
          <td colspan="19">
            <div align="center" class="style22"><strong>CORE MODULES</strong></div>          </td>
        </tr>
        <tr>
          <td colspan="19"><span class="style20">GENERAL MODULES </span></td>
        </tr>
        <?php
        foreach (getSubjectListAccordingToSubjectType($studentId, 2) as $subjectInfo) {
          $term1type1=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],1,1);
         $na1type2 = 1;
          $term1type3=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],1,3);
          $term2type1=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],2,1);
          $na2type2 = 1;
          $term2type3=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],2,3);
          $term3type1=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],3,1);
          $na3type2 = 1;
          $term3type3=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],3,3);
         $totalna=floatval($na1type2)+floatval($na2type2)+floatval($na3type2);
          $totalTerm1=floatval($term1type1)+floatval($term1type3);
          $totalTerm2=floatval($term2type1)+floatval($term2type3);
          $totalTerm3=floatval($term3type1)+floatval($term3type3);
          $totalAnnual=$totalTerm1+$totalTerm2+$totalTerm3;
          $totalAnnualPercentage=number_format($totalAnnual/6,2);
          
          $passPercentage=$subjectInfo['passline'];
          $re_assessment="";
          $decision="Competent";
          if($totalAnnualPercentage<$passPercentage){
            $re_assessment=getSubjectReAssesmentMarksBySubjectId($studentId, $subjectInfo['id']);
            if($re_assessment=="" || $re_assessment<$passPercentage){
              $decision="NYC";
            }
          }


          $totalNumberOfSubjects+=1;
          $grandTotalAnnual+=$totalAnnual;
          $grandTotalAnnualna+=$totalna;
          
          $totalTerm1Type1+=floatval($term1type1);
          $totalnaterm1+=floatval($na1type2);
          $totalTerm1Type3+=floatval($term1type3);
          $totalTerm2Type1+=floatval($term2type1);
          $totalnaterm2+=floatval($na2type2);
          $totalTerm2Type3+=floatval($term2type3);
          $totalTerm3Type1+=floatval($term3type1);
         $totalnaterm3+=floatval($na3type2);
          $totalTerm3Type3+=floatval($term3type3);
        ?>
          <tr>
            <td><span class="style22"><?php echo $subjectInfo['SubjectCode']; ?></span></td>
            <td><span class="style22"><?php echo $subjectInfo['SubjectName']; ?></span></td>
            <td><span class="style22"><?php echo $subjectInfo['weight']; ?></span></td>
            <td><span class="style22">&nbsp;
            <?= $term1type1 ?>
            </span></td>
            <td><span class="style22">&nbsp;<strong>N/A</strong></span></td>
            <td><span class="style22">&nbsp;
            <?= $term1type3 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalTerm1 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $term2type1 ?>
            </span></td>
            <td><span class="style22">&nbsp;<strong>&nbsp;N/A</strong></span></td>
            <td><span class="style22">&nbsp;
            <?= $term2type3 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalTerm2 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $term3type1 ?>
            </span></td>
            <td><span class="style22"><strong>&nbsp;N/A</strong></span></td>
            <td><span class="style22">&nbsp;
            <?= $term3type3 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalTerm3 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalAnnual ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalAnnualPercentage ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $re_assessment ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $decision ?>
            </span></td>
          </tr>
        <?php
        }
        ?>
        <tr>
          <td colspan="19"><span class="style22"><strong>SPECIFIC MODULES </strong></span></td>
        </tr>
        <?php
        foreach (getSubjectListAccordingToSubjectType($studentId, 3) as $subjectInfo) {
          $term1type1=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],1,1);
         $term1type2=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],1,2);
          $term1type3=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],1,3);
          $term2type1=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],2,1);
          $term2type2=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],2,2);
          $term2type3=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],2,3);
          $term3type1=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],3,1);
          $term3type2=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],3,2);
          $term3type3=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],3,3);
          $totalTerm1=floatval($term1type1)+floatval($term1type2)+floatval($term1type3);
          $totalTerm2=floatval($term2type1)+floatval($term2type2)+floatval($term2type3);
          $totalTerm3=floatval($term3type1)+floatval($term3type2)+floatval($term3type3);
          $totalAnnual=$totalTerm1+$totalTerm2+$totalTerm3;
          $totalAnnualPercentage=number_format($totalAnnual/9,2);
          
          $passPercentage=$subjectInfo['passline'];
          $re_assessment="";
          $decision="Competent";
          if($totalAnnualPercentage<$passPercentage){
            $re_assessment=getSubjectReAssesmentMarksBySubjectId($studentId, $subjectInfo['id']);
            if($re_assessment=="" || $re_assessment<$passPercentage){
              $decision="NYC";
             
            }
          }

          $totalNumberOfSubjects+=1;
          $grandTotalAnnual+=$totalAnnual;
          
       
          $totalTerm1Type1+=floatval($term1type1);
         $totalTerm1Type2+=floatval($term1type2);
          $totalTerm1Type3+=floatval($term1type3);
          $totalTerm2Type1+=floatval($term2type1);
          $totalTerm2Type2+=floatval($term2type2);
          $totalTerm2Type3+=floatval($term2type3);
          $totalTerm3Type1+=floatval($term3type1);
          $totalTerm3Type2+=floatval($term3type2);
          $totalTerm3Type3+=floatval($term3type3);

        ?>
          <tr>
            <td><span class="style22"><?php echo $subjectInfo['SubjectCode']; ?></span></td>
            <td><span class="style22"><?php echo $subjectInfo['SubjectName']; ?></span></td>
           <td><span class="style22"><?php echo $subjectInfo['weight']; ?></span></td>
            <td><span class="style22">&nbsp;
            <?= $term1type1 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $term1type2 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $term1type3 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalTerm1 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $term2type1 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $term2type2 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $term2type3 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalTerm2 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $term3type1 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $term3type2 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $term3type3 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalTerm3 ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalAnnual ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $totalAnnualPercentage ?></span></td>
            <td><span class="style22">&nbsp;
            <?= $re_assessment ?>
            </span></td>
            <td><span class="style22">&nbsp;
            <?= $decision ?>
            </span></td>
          </tr>
        <?php
        }
        ?>
        <tr>
          <td colspan="2" class="style7"><span class="style20">TOTAL</span></td>
          <td><span class="style17"></span></td>
          <td><span class="style22">&nbsp;
          <?= $totalTerm1Type1 ?>
          </span></td>
          <td><span class="style22">&nbsp;
          <?= $totalTerm1Type2 ?>
          </span></td>
          <td><span class="style22">&nbsp;
          <?= $totalTerm1Type3 ?>
          </span></td>
          <td><span class="style22">&nbsp;
          <?= $totalTerm1Type1+$totalTerm1Type2+$totalTerm1Type3 ?>
          </span></td>
          <td><span class="style22">&nbsp;
          <?= $totalTerm2Type1 ?>
          </span></td>
          <td><span class="style22">&nbsp;
          <?= $totalTerm2Type2 ?>
          </span></td>
          <td><span class="style22">&nbsp;
          <?= $totalTerm2Type3 ?>
          </span></td>
          <td><span class="style22">&nbsp;
          <?= $totalTerm2Type1+$totalTerm2Type2+$totalTerm2Type3 ?>
          </span></td>
          <td><span class="style22">&nbsp;
          <?= $totalTerm3Type1 ?>
          </span></td>
          <td><span class="style22">&nbsp;
          <?= $totalTerm3Type2 ?>
          </span></td>
          <td><span class="style22">&nbsp;
          <?= $totalTerm3Type3 ?>
          </span></td>
          <td><span class="style22">&nbsp;
          <?= $totalTerm3Type1+$totalTerm3Type2+$totalTerm3Type3 ?>
          </span></td>
          <td><span class="style22">&nbsp;
          <?= $grandTotalAnnual ?>
          </span></td>
          <td><span class="style17"></span></td>
          <td><span class="style17"></span></td>
          <td><span class="style17"></span></td>
        </tr>
        <tr>
          <td colspan="2"><span class="style20"><strong>PERCENTAGE</strong></span></td>
          <td><span class="style22"><strong>100%</strong></span></td>
          <td colspan="4"><span class="style22">&nbsp;<strong> 
          <?= number_format(($totalTerm1Type1+$totalTerm1Type2+$totalTerm1Type3)/($totalNumberOfSubjects*3-$totalnaterm1),2) ?>
          %</strong></span></td>
          <td colspan="4"><span class="style22">&nbsp;<strong>
          <?= number_format(($totalTerm2Type1+$totalTerm2Type2+$totalTerm2Type3)/($totalNumberOfSubjects*3-$totalnaterm2),2) ?>
          %</strong></span></td>
          <td colspan="4"><span class="style22">&nbsp;<strong>
          <?= number_format(($totalTerm3Type1+$totalTerm3Type2+$totalTerm3Type3)/($totalNumberOfSubjects*3-$totalnaterm3),2) ?>
          %</strong></span></td>
          <td colspan="2"><strong><span class="style22">
          <?= number_format($grandTotalAnnual/($totalNumberOfSubjects*9-$grandTotalAnnualna),2) ?>
          %</strong></h4> <td><span class="style17"></span></td>
          <td><span class="style17"></span></td>
        </tr>
        <tr>
          <td colspan="2"><span class="style20"><strong>POSITION</strong></span></td>
          <td colspan="5"><span class="style22"><strong>
          <?= getStudentPosition($studentId,"term1"); ?>
          </strong></span></td>
          <td colspan="4"><span class="style22">
          <stong>
          <strong>
          <?= getStudentPosition($studentId,"term2"); ?>
          </strong></strong></span></td>
          <td colspan="4"><span class="style22"><strong>
          <?= getStudentPosition($studentId,"term3"); ?>
          </strong></span></td>
          <td colspan="3"><span class="style22"><strong>
          <?= getStudentPosition($studentId,"annual"); ?>
          </strong></span></td>
		  <td><span class="style17"></span></td>
        </tr>
</table>
  <?php
    }
  }
  ?>
<div>
  <div align="right">
    <div align="right" class="style6"></div>
  </div>
  <div align="right" class="style6"></div>
  <span class="style6"><em>
  
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">  </svg>
  </em></span>
  <div align="right" class="style6"><em>
    <!--<label></label> -->
    <span class="style12">Generated by SARMS |Product of Diolichat</span> </em></div>
</div>
</body>

</html>