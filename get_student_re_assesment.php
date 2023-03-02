<?php
include('includes/config.php');
if (isset($_POST["act"]) && $_POST["act"] == "getStudentsList") {
  $cid = intval($_POST['classId']);
  $academicYear = intval($_POST['batchYear']);
  if (!is_numeric($cid) || !is_numeric($academicYear)) {
    echo htmlentities("invalid Class");
    exit;
  } else {
    $stmt = $dbh->prepare("SELECT StudentName,StudentId,roolid FROM tblstudents WHERE ClassId= :id AND yearr= :academicYear order by roolid asc");
    $stmt->execute(array(':id' => $cid, ':academicYear' => $academicYear));
    ?>
    <option value="">Select Learner</option>
    <?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <option value="<?php echo htmlentities($row['StudentId']); ?>"><?php echo htmlentities($row['roolid']); ?>: <?php echo htmlentities($row['StudentName']); ?></option>
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
    <option value="">Select Learner</option>
    <?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <option value="<?php echo htmlentities($row['StudentId']); ?>"><?php echo htmlentities($row['StudentName']); ?></option>
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
    $stmt = $dbh->prepare("SELECT tblsubjects.SubjectName,tblsubjects.SubjectCode,tblsubjects.id FROM tblsubjectcombination join  tblsubjects on  tblsubjects.id=tblsubjectcombination.SubjectId WHERE tblsubjectcombination.ClassId=:cid and tblsubjectcombination.status!=:stts order by tblsubjects.SubjectName");
    $stmt->execute(array(':cid' => $cid1, ':stts' => $status));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
      <p> <?php echo htmlentities($row['SubjectName'] . " (" . $row['SubjectCode'] . ")"); ?><input type="number" step="any" name="marks[<?= $row['id'] ?>]" value="" class="form-control" placeholder="Enter marks out of 100" min="0" max="100" autocomplete="off"></p> 
      <?php
    }


  }
}

//getting student prev marks
if (isset($_POST["act"]) && $_POST["act"] == "getStudentPrevMarksStatus") {
  $studentId = $_POST["studentId"];
  $academicYear = $_POST["academicYear"];
  $classId = $_POST["classId"];
  $termId = $_POST["termId"];
  $typeId = $_POST["typeId"];

  $query = $dbh->prepare("SELECT StudentId,ClassId FROM tblresult WHERE StudentId=:StudentId and academicYear=:academicYear and ClassId=:ClassId and term=:termId and type=:typeId");
  //$query= $dbh -> prepare($sql);
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


//getting student prev re-assessment marks
if (isset($_POST["act"]) && $_POST["act"] == "getStudentPrevRe-assessmentMarksStatus") {
  $studentId = $_POST["studentId"];
  $academicYear = $_POST["academicYear"];
  $classId = $_POST["classId"];
 

  $query = $dbh->prepare("SELECT StudentId,ClassId FROM tbl_reassessment_result WHERE StudentId=:StudentId and academicYear=:academicYear and ClassId=:ClassId");
  //$query= $dbh -> prepare($sql);
  $query->bindParam(':StudentId', $studentId, PDO::PARAM_STR);
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