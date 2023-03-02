<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Manage Learners Results info</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .print {
                background-color: #1f4772;
                color: white;
                width: auto;
                height: auto;
            }
        </style>
        <script>
            function toggleSelection(globalToggle) {
                // Get checkboxes
                var checkBoxes = document.getElementsByName('selected[]');
                var checked = 0;

                checkBoxes.forEach(element => {
                    if (globalToggle.checked) {
                        element.checked = true;
                    } else {
                        element.checked = false;
                    }
                });
            }

            function printSelected() {
                var checkBoxes = document.getElementsByName('selected[]');
                console.log({
                    checkBoxes
                })
                var checked = [];

                checkBoxes.forEach(element => {
                    if (element.checked) {
                        checked.push(element.id);
                    }
                });

                window.location.assign('first-term1.php?q=' + JSON.stringify(checked))
            }
        </script>
    </head>

    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
            <?php include('includes/topbar.php'); ?>
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">
                    <?php include('includes/leftbar1.php'); ?>

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <?php $sql = "SELECT * from tblclasses where id='" . $_SESSION['alogin'] . "'";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {   ?>
                                            <h3 class="title">
                                                <?php echo htmlentities($result->class); ?>- Assessment Results</h3>

                                </div>

                                <!-- /.col-md-6 text-right -->
                            </div> <?php
                                        }
                                    }
                                    ?>
                    <!-- /.row -->
                    <div class="row breadcrumb-div">
                        <div class="col-md-6">
                            <ul class="breadcrumb">
                                <li><a href="trainerdash.php"><i class="fa fa-home"></i> Home</a></li>
                                <li> Results</li>
                                <li class="active">Manage Result</li>

                            </ul>
                        </div>

                    </div>
                    <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">

                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h5>
                                    </div>
                                </div>
                                <form class="form-horizontal" method="post" id="addNewResultForm">
                                    <button class="btn btn-primary" type="button" id="print-selected" onclick="printSelected()">Print selected</button>
                            </div>

                            <?php if ($msg) { ?>
                                <div class="alert alert-success left-icon-alert" role="alert">
                                    <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                </div><?php } else if ($error) { ?>
                                <div class="alert alert-danger left-icon-alert" role="alert">
                                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>

                                    <?php
                                        $sql = "SELECT admin.classid,admin.UserName, tblclasses.classname,tblclasses.section,tblclasses.classnamenumeric,tblclasses.class from tblstudents join tblclasses ON tblclasses.id=admin.classid ";

                                        // $sql= "SELECT studentname, roolid, marks FROM tblstudents, tblresults  WHERE studentid.id = 'studentId'";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {   ?>
                                            <?php echo htmlentities($result->UserName); ?>
                                <?php }
                                        }
                                    } ?>
                                <tbody>

                                    <div class="panel-body p-20">

                                        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="th-selected" onchange="toggleSelection(this)"></th>
                                                    <th>RegNo</th>
                                                    </th>
                                                    <th>Names</th>

                                                    <th>AcYear</th>
                                                    <th>Marks</th>
                                                    <th>Position</th>
                                                    <th>Re-Ass</th>
                                                    <th><a target="_blank" href="first-term1.php"> 1Print</a> </th>

                                                    <th><a target="_blank" href="second-term.php"> 2Print</a> </th>
                                                    <th><a target="_blank" href="second-term.php"> 3Print</a> </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                if ($_SESSION['alogin'] == true) {
                                                    //echo $_SESSION["UserName"];
                                                }
                                                    // $sql = "SELECT tblstudents.*, tblresults.* FROM tblstudents, tblresults WHERE tblstudents.StudentId = tblresults.StudentId;";
                                                    //$sql = "SELECT tblstudents.StudentId, tblstudents.studentname,tblstudents.roolid,tblstudents.yearr, tblclasses.classname,tblclasses.section,tblclasses.classnamenumeric,tblclasses.class from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId   where ClassId='".$_SESSION['alogin']."'";
                                                    //
                                                    //$sql1 = "SELECT tblstudents.StudentId, tblstudents.studentname,tblstudents.roolid,tblstudents.yearr, tblclasses.classname,tblclasses.section,tblclasses.classnamenumeric,tblclasses.class from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId   where ClassId='".$_SESSION['alogin']."'";
                                                    //$sql = "SELECT tblstudents.studentname,tblstudents.roolid,tblstudents.RegDate,tblstudents.StudentId,tblstudents.yearr, tblclasses.classname,tblclasses.section,tblclasses.classnamenumeric,tblclasses.class from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId  where ClassId='".$_SESSION['alogin']."' " ;
                                                ;
                                                // echo $sql;
                                                $sql = "SELECT tblstudents.studentname,tblstudents.roolid,tblstudents.RegDate,tblstudents.StudentId,tblstudents.yearr, tblclasses.classname,tblclasses.section,tblclasses.classnamenumeric,tblclasses.class, SUM(tblresult.marks) AS marks from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId LEFT JOIN tblresult ON tblresult.StudentId = tblstudents.StudentId where tblclasses.id='" . $_SESSION['alogin'] . "' GROUP BY tblstudents.StudentId ORDER BY marks DESC;";
                                                // echo $sql;
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $position => $result) { ?>
                                                        <tr>
                                                            <td><input type="checkbox" name="selected[]" id="<?php echo $result->StudentId ?>"></td>
                                                            <td><?php echo htmlentities($result->roolid); ?></td>
                                                            <td><?php echo htmlentities($result->studentname); ?></td>
                                                            <td><?php echo htmlentities($result->yearr); ?>-<?php echo htmlentities($result->yearr) + 1; ?></td>



                                                            <td><?php echo htmlentities($result->marks); ?></td>
                                                            <td><?php echo htmlentities($position + 1); ?></td>

                                                            <td>
                                                                <a href="edit-reassessment-result.php?StudentId=<?php echo htmlentities($result->StudentId); ?>"><i class="fa fa-edit" title="Edit Record"></i> </a>
                                                            <td><a href="edit-result1.php?StudentId=<?php echo htmlentities($result->StudentId); ?>"><i class="fa fa-edit " title="Edit Record  "></i> </a>&nbsp;<a target="_blank" href="first-term.php?StudentId=<?php echo htmlentities($result->StudentId); ?>"> <i class="fa fa-eye"></i></a>
                                                                <a href=""></a>
                                                            </td>

                                                            <td><a href="edit-result2.php?StudentId=<?php echo htmlentities($result->StudentId); ?>"><i class="fa fa-edit " title="Edit Record  "></i> </a>
                                                                &nbsp; <a target="_blank" href="second-term.php?StudentId=<?php echo htmlentities($result->StudentId); ?>"> <i class="fa fa-eye"></i></a>
                                                                <a href=""></a>
                                                            </td>
                                                            <td><a href="edit-result.php?StudentId=<?php echo htmlentities($result->StudentId); ?>"><i class="fa fa-edit" title="Edit Record"></i></a>&nbsp;
                                                                <a target="_blank" class="f1" href="result.php?StudentId=<?php echo htmlentities($result->StudentId); ?>"> <i class="fa fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                <?php $cnt = $cnt + 1;
                                                    }
                                                } ?>


                                            </tbody>
                                        </table>


                                        <!-- /.col-md-12 -->
                                    </div>
                                </div>
                    </div>
                    <!-- /.col-md-6 -->


                </div>
                <!-- /.col-md-12 -->
            </div>
        </div>
        <!-- /.panel -->
        </div>
        <!-- /.col-md-6 -->

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
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $('#example').DataTable({
                    order: [
                        [5, 'asc']
                    ],
                });

                $('#example2').DataTable({
                    "scrollY": "300px",
                    "scrollCollapse": true,
                    "paging": false
                });

                $('#example3').DataTable();
            });
        </script>
    </body>

    </html>
<?php }
?>