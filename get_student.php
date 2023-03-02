<?php
error_reporting(1);
include('includes/config.php');
if (isset($_POST["act"]) && $_POST["act"] == "getStudentsList") {
  $cid = intval($_POST['classId']);
  $academicYear = intval($_POST['batchYear']);
  if (!is_numeric($cid) || !is_numeric($academicYear)) {
    echo htmlentities("invalid Class");
    exit;
  } else {
    $stmt = $dbh->prepare("SELECT StudentName,StudentId,roolid FROM tblstudents WHERE ClassId= :id AND yearr= :academicYear order by StudentName asc");
    $stmt->execute(array(':id' => $cid, ':academicYear' => $academicYear));
    ?>

    <?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
     <?php echo htmlentities($row['roolid'] . " " . $row['StudentName'] ); ?><input width="30" type="number" step="any" name="marks[<?= $row['StudentId'] ?>]" value="" class="form-control" placeholder="Enter marks  " min="0"  autocomplete="off" required="Please enter marks from 0">
        
      <?php
    }


  }
}
//behavior list
if (isset($_POST["act"]) && $_POST["act"] == "getStudentsbehList") {
  $cid = intval($_POST['classId']);
  $academicYear = intval($_POST['batchYear']);
  if (!is_numeric($cid) || !is_numeric($academicYear)) {
    echo htmlentities("invalid Class");
    exit;
  } else {
    $stmt = $dbh->prepare("SELECT StudentName,StudentId,roolid FROM tblstudents WHERE ClassId= :id AND yearr= :academicYear order by StudentName asc");
    $stmt->execute(array(':id' => $cid, ':academicYear' => $academicYear));
    ?>

    <?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
     <?php echo htmlentities($row['roolid'] . " " . $row['StudentName'] ); ?><input width="30" type="number" step="any" name="marks[<?= $row['StudentId'] ?>]" value="" class="form-control" placeholder="Enter marks out of 100 " min="0" autocomplete="off" >
        
      <?php
    }


  }
}
// Code for getReAssesmentStudentsList
if (isset($_POST["act"]) && $_POST["act"] == "getReAssesmentStudentsList") {
  $cid = intval($_POST['classId']);
  $academicYear = intval($_POST['batchYear']);
  if (!is_numeric($cid) || !is_numeric($academicYear)) {
    echo htmlentities("invalid Class");
    exit;
  } else {
    $stmt = $dbh->prepare("SELECT StudentName,StudentId FROM tblstudents WHERE ClassId= :id AND yearr= :academicYear order by StudentName");
    $stmt->execute(array(':id' => $cid, ':academicYear' => $academicYear));
    ?>
List of Learners
    <?php
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
      <p> <?php echo htmlentities($row['StudentName'] . " (" . $row['roolid'] . ")"); ?><input type="number" step="any" name="marks[<?= $row['StudentId'] ?>]" value="" class="form-control" placeholder="Enter marks <?php echo htmlentities($row['weight']); ?> " min="0" max="100" autocomplete="off" >
        
    <?php
    }
  }
}
// Code for Subjects
if (isset($_POST["act"]) && $_POST["act"] == "getSubjectsList") {
  $cid1 = intval($_POST['classId']);
  if (!is_numeric($cid1)) {
    echo htmlentities("invalid Class");
    exit;
  } else {

    $status = 0;
   $stmt = $dbh->prepare("SELECT tblsubjects.SubjectName,tblsubjects.SubjectCode,tblsubjects.id FROM tblsubjectcombination join  tblsubjects on  tblsubjects.id=tblsubjectcombination.SubjectId WHERE tblsubjectcombination.ClassId=:cid and tblsubjectcombination.status!=:stts order by tblsubjects.id ");
$stmt->execute(array(':cid' => $cid1, ':stts' => $status));
    ?>
    <option value="">Select Module</option>
    <?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['SubjectCode']); ?>: <?php echo htmlentities($row['SubjectName']);  ?></option>
    <?php
    }
  }
}
//getting student prev marks
if (isset($_POST["act"]) && $_POST["act"] == "getStudentPrevMarksStatus") {
  $subjectId = $_POST["subjectId"];
  $academicYear = $_POST["academicYear"];
  $classId = $_POST["classId"];
  $termId = $_POST["termId"];
  $typeId = $_POST["typeId"];


  $query = $dbh->prepare("SELECT  SubjectId,StudentId,ClassId FROM tblresult WHERE SubjectId=:SubjectId and StudentId=:StudentId and academicYear=:academicYear and ClassId=:ClassId and term=:termId and type=:typeId");
  //$query= $dbh -> prepare($sql);
  $query->bindParam(':SubjectId', $subjectId, PDO::PARAM_STR);
   $query->bindParam(':StudentId', $studentId, PDO::PARAM_STR);
  $query->bindParam(':academicYear', $academicYear, PDO::PARAM_STR);
  $query->bindParam(':ClassId', $classId, PDO::PARAM_STR);
  $query->bindParam(':termId', $termId, PDO::PARAM_STR);
  $query->bindParam(':typeId', $typeId, PDO::PARAM_STR);
  $query->execute();
  if ($query->rowCount() > 0) {
    echo "<p><span style='color:red'> Result Already Declare for this Assessment.</span>";
    echo "<script>$('#submit').prop('disabled',true);</script></p>";
  } else {
    echo "<script>$('#submit').prop('disabled',false);</script></p>";
  }
}


if (isset($_POST["act"]) && $_POST["act"] == "getStudentPrevbehMarksStatus") {

  $academicYear = $_POST["academicYear"];
  $classId = $_POST["classId"];
  $termId = $_POST["termId"];
 

  $query = $dbh->prepare("SELECT ClassId FROM tblbehavior WHERE  academicYear=:academicYear and ClassId=:ClassId and term=:termId ");
  //$query= $dbh -> prepare($sql);
  $query->bindParam(':academicYear', $academicYear, PDO::PARAM_STR);
  $query->bindParam(':ClassId', $classId, PDO::PARAM_STR);
  $query->bindParam(':termId', $termId, PDO::PARAM_STR);
  $query->execute();
  if ($query->rowCount() > 0) {
    echo "<p><span style='color:red'> Result Already Declare for this Assessment.</span>";
    echo "<script>$('#submit').prop('disabled',true);</script></p>";
  } else {
    echo "<script>$('#submit').prop('disabled',false);</script></p>";
  }
}



//getting student prev re-assessment marks
if (isset($_POST["act"]) && $_POST["act"] == "getStudentPrevRe-assessmentMarksStatus") {
  $subjectId = $_POST["subjectId"];
  $academicYear = $_POST["academicYear"];
  $classId = $_POST["classId"];


  $query = $dbh->prepare("SELECT SubjectId,ClassId FROM tbl_reassessment_result WHERE SubjectId=:SubjectId and academicYear=:academicYear and ClassId=:ClassId");
  //$query= $dbh -> prepare($sql);
  $query->bindParam(':SubjectId', $subjectId, PDO::PARAM_STR);
  $query->bindParam(':academicYear', $academicYear, PDO::PARAM_STR);
  $query->bindParam(':ClassId', $classId, PDO::PARAM_STR);

  $query->execute();
  if ($query->rowCount() > 0) {
    echo "<p><span style='color:red'> Result Already Declare for this Assessment.</span>";
    echo "<script>$('#submit').prop('disabled',true);</script></p>";
  } else {
    echo "<script>$('#submit').prop('disabled',false);</script></p>";
  }
}
?>