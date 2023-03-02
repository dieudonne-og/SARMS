<?php
include('includes/config.php');
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

  $studentId=$_GET["studentId"];
  $totalNumberOfSubjects=0;
  $grandTotalAnnual=0;
  $totalTerm1Type1=0;
  echo "<pre>";
  foreach (getSubjectListAccordingToSubjectType($studentId, 1) as $subjectInfo) {
    print_r($subjectInfo);
    $term1type1=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],1,1);
    $term1type2=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],1,2);
    $term1type3=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],1,3);
    $term2type1=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],2,1);
    $term2type2=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],2,2);
    $term2type3=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],2,3);
    $term3type1=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],3,1);
    $term3type2=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],3,2);
    $term3type3=getSubjectMarksBySubjectId($studentId,$subjectInfo['id'],3,3);
    echo "<br>totalTerm1 :".$totalTerm1=intval($term1type1)+intval($term1type2)+intval($term1type3);
    echo "<br>totalTerm2 :".$totalTerm2=intval($term2type1)+intval($term2type2)+intval($term2type3);
    echo "<br>totalTerm3 :".$totalTerm3=intval($term3type1)+intval($term3type2)+intval($term3type3);
    echo "<br>totalAnnual :".$totalAnnual=$totalTerm1+$totalTerm2+$totalTerm3;
    echo "<br>totalAnnualPercentage :".$totalAnnualPercentage=number_format($totalAnnual/9,2);
    echo "<br>re_assessment :".$re_assessment=($totalAnnualPercentage>=70)?"":$totalAnnualPercentage."%";
    echo "<br>decision :".$decision=($totalAnnualPercentage>=70)?"Competent":"NYC";
    $totalNumberOfSubjects+=1;
    //echo "<br>".$grandTotalAnnual+=$totalAnnual;

  }
  echo "<br>";
  echo "</pre>";
?>