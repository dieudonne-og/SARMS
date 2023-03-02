<?php
session_start();
error_reporting(1);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['addStudentResultSubmitBtn'])) {
        $marks = array();
        $classId = $_POST['class'];
        $studentId = $_POST['studentid'];
        $subjectId = $_POST['subjectid'];
        $academicYear = $_POST['academicYear'];
        $marksArr = $_POST['marks'];
        $term = $_POST['term'];
        $type = $_POST['type'];

        //checking pprevious marks
        $query = $dbh->prepare("SELECT SubjectId,ClassId,term,type FROM tblresult WHERE SubjectId=:subjectid and academicYear=:academicYear and ClassId=:class and term=:term and type=:type  ");
         $query->bindParam(':subjectid', $subjectId, PDO::PARAM_STR);
        $query->bindParam(':academicYear', $academicYear, PDO::PARAM_STR);
        $query->bindParam(':class', $classId, PDO::PARAM_STR);
        $query->bindParam(':term', $term, PDO::PARAM_STR);
        $query->bindParam(':type', $type, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $error= "Marks already recorded for this assesssment ";
        } else {
            foreach ($marksArr as $studentId => $subjectMarks) {
                $sql = "INSERT INTO  tblresult(StudentId,academicYear,ClassId,SubjectId,marks,term,type) VALUES(:studentid,:academicYear,:class,:subjectid,:marks,:term,:type)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':studentid', $studentId, PDO::PARAM_STR);
                $query->bindParam(':academicYear', $academicYear, PDO::PARAM_STR);
                $query->bindParam(':class', $classId, PDO::PARAM_STR);
                $query->bindParam(':subjectid', $subjectId, PDO::PARAM_STR);
                $query->bindParam(':marks', $subjectMarks, PDO::PARAM_STR);
                $query->bindParam(':term', $term, PDO::PARAM_STR);
                $query->bindParam(':type', $type, PDO::PARAM_STR);
                $query->execute();
                $lastInsertId = $dbh->lastInsertId();
                if ($lastInsertId) {
                    $msg = "Marks  successfully Saved";
                } else {
                    $error = "Something went wrong. Please try again";
                }
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
        <title> Add Assessment Marks </title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/prism/prism.css" media="screen">
        <link rel="stylesheet" href="css/select2/select2.min.css">
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>

    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
            <?php include('includes/topbar.php'); ?>
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                    <?php include('includes/leftbar1.php'); ?>
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Declare Assessment Marks </h2>

                                </div>

                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="trainerdash.php"><i class="fa fa-home"></i> Home</a></li>
<li class="active">Results</li>
                                        <li class="active"> Assessment marks</li>
                                    </ul>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">

                                        <div class="panel-body">
                                            <?php if ($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                                </div><?php } else if ($error) { ?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <strong>Failed!</strong> <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } ?>
                                            <form class="form-horizontal" method="post" id="addNewResultForm">
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Year</label>
                                                    <div class="col-sm-10">
                                                        <select name="academicYear" class="form-control clid" id="academicYear" required="required">
                                                            <?php $sql = "SELECT DISTINCT `yearr` FROM `tblstudents` ORDER BY `yearr`";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {   ?>
                             <option value="<?php echo htmlentities($result->yearr); ?>"><?php echo htmlentities($result->yearr);       ?>-<?php echo htmlentities($result->yearr)+1; ?>
                                                                    </option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Class</label>
                                                    <div class="col-sm-10">
                                                        <select name="class" class="form-control clid" id="classid" required="required">
   <option value="">Class</option>
      <?php $sql = "SELECT * from tblclasses  where id='".$_SESSION['alogin']."'";
          $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {   ?>
   <option value="<?php echo htmlentities($result->id); ?>">
  <?php echo htmlentities($result->class); ?>                                                                   

                                                                    </option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="date" class="col-sm-2 control-label ">Term</label>
                                                    <div class="col-sm-10">
                                                        <select name="term" id="selectTerm" class="form-control stid" required="required">
                                                            <option value="">Select Term</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="form-group">
                                                    <label for="date" class="col-sm-2 control-label ">Type</label>
                                                    <div class="col-sm-10">
                                                        <select name="type" id="assessmentType" class="form-control stid" required="required">
                                                            <option value="">Select Assessment Type</option>
                                                        </select>
                                                    </div>

                                                </div>
         
<div class="form-group">
                                                        <label for="date" class="col-sm-2 control-label ">Module</label>
                                                        <div class="col-sm-10">
                                                    <select name="subjectid" class="form-control stid" id="subject" required="required">
                                                    </select>
                                                        </div>
                                                    </div>
                                                <div class="form-group">

                                                    <div class="col-sm-10">
                                                        <div id="reslt">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Students List</label>
                                                    <div class="col-sm-10">
                                                        <div id="studentid" maxlength="100" onChange="getresult(this.value);">
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" name="addStudentResultSubmitBtn" id="submit" class="btn btn-primary">Save marks <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
  <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
</svg></button>

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

                $(document).ready(function() {
                    $(document).on("change", "#academicYear", function() {
                        $('#classid').prop('selectedIndex', 0);
                        $("#subject").html("");
                        $("#studentid").html(`<option value="">Select Module</option>`);
                        $("#selectTerm").html(`<option value="">Select Term</option>`);
                        $("#assessmentType").html(`<option value="">Select Assessment Type</option>`);
                        $("#reslt").html("");
                    });
                    $(document).on("change", "#classid", function() {
                        let classId = $("#classid").val();
                        if (classId > 0) {
                            $("#selectTerm").html(`<option value="">Select Term</option>
                                                    <option value="1">Term 1</option>
                                                    <option value="2">Term 2</option>
                                                    <option value="3">Term 3</option>`);
                            $("#assessmentType").html(`<option value="">Select Assessment Type</option>`);
                        } else {
                            $("#selectTerm").html(`<option value="">Select Term</option>`);
                            $("#assessmentType").html(`<option value="">Select Assessment Type</option>`);
                        }
                        $("#reslt").html("");
                    });
                    $(document).on("change", "#selectTerm", function() {
                        let selectTermId = $("#selectTerm").val();
                        if (selectTermId > 0) {
                            $("#assessmentType").html(`<option value="">Select Assessment Type</option>
                                                        <option value="1">Formative Assessment</option>
                                                        
                                                        <option value="3">Comprehensive Assessment</option>
                                                        `);
                        } else {
                            $("#assessmentType").html(`<option value="">Select Assessment Type</option>`);
                        }
                        $("#reslt").html("");
                    });
                    $(document).on("change", "#assessmentType", function() {
                        let batchYear = $("#academicYear").val();
                        let classId = $("#classid").val();
                        getStudent(batchYear, classId);
                        //$("#reslt").html("");
                    });

                    function getStudent(batchYear, classId) {
                        //console.log(`Hello getstudent with ${batchYear} - ${classId}`);
                        if (batchYear == "" || classId == "") {
                            alert("Please select academic year and class");
                            return false;
                        } else {
                            //getting student list
                            $.ajax({
                                type: "POST",
                                url: "get_student.php",
                                data: {
                                    act: 'getStudentsList',
                                    classId: classId,
                                    batchYear: batchYear
                                },
                                success: function(data) {
                                    $("#studentid").html(data);
                                }
                            });

                            //getting class all subjects
                            $.ajax({
                                type: "POST",
                                url: "get_student.php",
                                data: {
                                    act: 'getSubjectsList',
                                    classId: classId
                                },
                                success: function(data) {
                                    $("#subject").html(data);
                                }
                            });
                        }
                    }

                    function resetAddNewResultForm() {
                        $("#addNewResultForm")[0].reset();
                        $("#studentid").html("");
                        $("#subject").html(`<option value="">Select module</option>`);
                    }

                    //getting student previous result
                    $(document).on("change", "#studentid", function() {
                        console.log("Getting student previous marks...!");
                        let subjectId = $("#subjectid").val();
                        let academicYear = $("#academicYear").val();
                        let classId = $("#classid").val();
                        let termId = $("#selectTerm").val();
                        let typeId = $("#assessmentType").val();

                        $.ajax({
                            type: "POST",
                            url: "get_student.php",
                            data: {
                                act: 'getStudentPrevMarksStatus',
                                subjectId,
                                academicYear,
                                classId,
                                termId,
                                typeId
                            },
                            success: function(data) {
                                $("#reslt").html(data);
                            }
                        });
                    });


                });
            </script>
    </body>

    </html>
<?PHP } ?>