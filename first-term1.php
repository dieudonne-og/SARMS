<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {

    $studentIdArray = json_decode($_GET['q']);

    function getBehaviorMarks($studentId = 0, $term = 1)
    {
        global $dbCon;
        if ($studentId > 0 && $term > 0) {
            $sql = "SELECT * FROM `tblbehavior` WHERE `StudentId`=" . $studentId . " AND `term`=" . $term;
            if ($query = mysqli_query($dbCon, $sql)) {
                if (mysqli_num_rows($query) > 0) {
                    return mysqli_fetch_assoc($query)["marks"];
                } else {
                    return "";
                }
            } else {
                return "";
            }
        } else {
            return "";
        }
    }


    function getStudentPosition($StudentId = 0, $positionType = "annual")
    {
        global $dbCon;
        if ($StudentId > 0 && !empty($positionType)) {
            $posSql = "";
            if ($positionType == "annual") {
                $posSql = "SELECT *, SUM(`marks`) AS 'totalMarks' FROM `tblresult` WHERE `academicYear`=(SELECT `academicYear` FROM `tblresult` WHERE `StudentId`=" . $StudentId . " LIMIT 1) AND `ClassId`=(SELECT `ClassId` FROM `tblresult` WHERE `StudentId`=" . $StudentId . " LIMIT 1) GROUP BY `StudentId` ORDER BY SUM(`marks`) DESC";
            } else if ($positionType == "term1") {
                $posSql = "SELECT *, SUM(`marks`) AS 'totalMarks' FROM `tblresult` WHERE `term`=1 AND `academicYear`=(SELECT `academicYear` FROM `tblresult` WHERE `StudentId`=" . $StudentId . " LIMIT 1) AND `ClassId`=(SELECT `ClassId` FROM `tblresult` WHERE `StudentId`=" . $StudentId . " LIMIT 1) GROUP BY `StudentId` ORDER BY SUM(`marks`) DESC";
            } else if ($positionType == "term2") {
                $posSql = "SELECT *, SUM(`marks`) AS 'totalMarks' FROM `tblresult` WHERE `term`=2 AND `academicYear`=(SELECT `academicYear` FROM `tblresult` WHERE `StudentId`=" . $StudentId . " LIMIT 1) AND `ClassId`=(SELECT `ClassId` FROM `tblresult` WHERE `StudentId`=" . $StudentId . " LIMIT 1) GROUP BY `StudentId` ORDER BY SUM(`marks`) DESC";
            } else if ($positionType == "term3") {
                $posSql = "SELECT *, SUM(`marks`) AS 'totalMarks' FROM `tblresult` WHERE `term`=3 AND `academicYear`=(SELECT `academicYear` FROM `tblresult` WHERE `StudentId`=" . $StudentId . " LIMIT 1) AND `ClassId`=(SELECT `ClassId` FROM `tblresult` WHERE `StudentId`=" . $StudentId . " LIMIT 1) GROUP BY `StudentId` ORDER BY SUM(`marks`) DESC";
            } else {
                return "N/A";
            }
            if ($posSql != "") {
                if ($qry = mysqli_query($dbCon, $posSql)) {
                    $studentsSql = "SELECT COUNT(`StudentId`) AS 'totalNumStudents'  FROM `tblstudents` WHERE `yearr`=(SELECT `yearr` FROM `tblstudents` WHERE `StudentId`=" . $StudentId . ") AND `classId`=(SELECT `classId` FROM `tblstudents` WHERE `StudentId`=" . $StudentId . ")";
                    $studentsQry = mysqli_query($dbCon, $studentsSql);
                    $totalStudents = mysqli_fetch_assoc($studentsQry)["totalNumStudents"];
                    //$totalStudents.=" >> ".$posSql;
                    $studentPosition = 0;
                    while ($row = mysqli_fetch_assoc($qry)) {
                        $studentPosition += 1;
                        if ($row["StudentId"] == $StudentId) {
                            if ($studentPosition == 1) return "1 / " . $totalStudents;
                            if ($studentPosition == 2) return "2 / " . $totalStudents;
                            if ($studentPosition == 3) return "3 / " . $totalStudents;
                            return $studentPosition . " / " . $totalStudents;
                            exit();
                        }
                    }
                    if ($studentPosition <= 0) {
                        return "N/A";
                    }
                } else {
                    return "N/A";
                }
            } else {
                return "N/A";
            }
        } else {
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
    function getSubjectMarksBySubjectId($studentId = 0, $subjectId = 0, $termId = 1, $assementType = 1)
    {
        global $dbCon;
        if ($studentId > 0 && $subjectId > 0) {
            $sql = "SELECT * FROM `tblresult` WHERE `StudentId`=" . $studentId . " AND `SubjectId`=" . $subjectId . " AND `term`=" . $termId . " AND `type`=" . $assementType;
            if ($query = mysqli_query($dbCon, $sql)) {
                if (mysqli_num_rows($query) > 0) {
                    return mysqli_fetch_assoc($query)["marks"];
                } else {
                    return "";
                }
            } else {
                return "";
            }
        } else {
            return "";
        }
    }
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>1st term Report</title>
        <style type="text/css">
            .style5 {
                font-size: 12px;
                font-weight: bold;
            }

            .style6 {
                font-size: 12px
            }

            .style7 {
                font-size: 14px;
                font-weight: bold;
            }

            #Layer1 {
                position: absolute;
                width: 171px;
                height: 27px;
                z-index: 1;
                left: 134px;
                top: 887px;
            }

            #Layer2 {
                position: absolute;
                width: 104px;
                height: 73px;
                z-index: 2;
                left: 297px;
                top: 25px;
            }

            #Layer3 {
                position: absolute;
                width: 246px;
                height: 107px;
                z-index: 3;
                left: 634px;
                top: 25px;
            }

            body,
            td,
            th {
                font-family: Times New Roman, Times, serif;
                font-size: 11px;
            }

            body {
                margin-top: 0cm;
            }

            .style13 {
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
            }

            .style14 {
                font-family: Verdana, Arial, Helvetica, sans-serif
            }

            .style15 {
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-weight: bold;
                font-size: 12px;
            }

            .style22 {
                font-size: 11px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }

            #Layer4 {
                position: absolute;
                left: 689px;
                top: 632px;
                width: 209px;
                height: 14px;
                z-index: 4;
            }

            .style24 {
                font-size: 9px;
                color: #666666;
            }
        </style>
    </head>


    <body>
        <?php
        foreach ($studentIdArray as $studentId) {
            $sql = "SELECT tblstudents.studentname,tblstudents.roolid,tblstudents.yearr,tblclasses.title,tblclasses.classname,tblclasses.classnamenumeric,tblclasses.section,tblclasses.class from tblstudents left join tblclasses on tblclasses.id=tblstudents.ClassId WHERE `tblstudents`.`StudentId`=" . $studentId . " AND `tblstudents`.`classId`=`tblclasses`.`id`";
            if ($query = mysqli_query($dbCon, $sql)) {
                if (mysqli_num_rows($query) == 1) {
                    $studentInfo = mysqli_fetch_assoc($query);
        ?>
                    <style>
                        table {
                            border-collapse: collapse;

                        }
                    </style>

                    <table width="888" height="612" border="2">
                        <tr>
                            <td height="99" colspan="20" class="style14">
                                <div id="Layer2"><img src="images/photo-1.jpg" alt="logo" width="75" height="85" align="right" margin="margin" /></div>
                                <p align="left"><strong>REPUBLIC OF RWANDA</strong> <br />
                                    <strong>MINISTRY OF EDUCATION</strong>
                                    <br />
                                    <strong>DISTRICT: Muhanga</strong><br />
                                    <strong>SCHOOL: ACODES MUSHISHIRO</strong><br>

                                    <strong>EMAIL: acodesmushishiro@gmail.com</strong><br />
                                    <strong>TEL: +250788412648</strong> <br />
                                </p>
                                <br>
                                <div class="style22" id="Layer3">
                                    <table width="400" border="0" align="right">
                                        <tr>
                                            <td><strong>ACADEMIC YEAR:</strong> <?php echo $studentInfo['yearr'];  ?> - <?php echo $studentInfo['yearr'] + 1;  ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>CLASS:</strong> <?php echo ucfirst($studentInfo['class']);  ?> </td>
                                        </tr>
                                        <tr>
                                            <td><strong>LEARNER NAME:</strong> <?php echo ucfirst($studentInfo['studentname']);  ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div align="left" class="style13">
                                    <div class="style14" id="layer"></div>
                                    <table width="252" border="0" align="right">
                                        <tr> </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="20">
                                <div align="center" class="style13"><strong>LEARNER'S ASSESSMENT REPORT</strong></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><span class="style13"><strong> SECTOR:</strong> <?php echo ucfirst($studentInfo['classname']);  ?></span></td>
                            <td colspan="5">&nbsp;</td>
                            <td colspan="13"><span class="style13"><strong>QUALIFICATION TITLE: </strong><?php echo ucfirst($studentInfo['title']);  ?></span></td>
                        </tr>
                        <tr>
                            <td colspan="2"><span class="style13"><strong> TRADE: </strong><?php echo ucfirst($studentInfo['classnamenumeric']);  ?> </span></span></td>
                            <td colspan="5">&nbsp;</td>
                            <td colspan="13"><span class="style13"><strong>RTQF LEVEL:</strong> <?php echo $studentInfo['section'];  ?></span></td>
                        </tr>
                        <tr>
                            <td colspan="2" rowspan="2"><span class="style15"> BEHAVIOR:</span></td>
                            <td width="49" height="19"><span class="style15">MAX</span></td>
                            <td colspan="16">
                                <div align="center" class="style13"><strong>TERM 1 </strong></div>
                                <div align="center" class="style13"></div>
                            </td>
                        </tr>
                        <tr>
                            <td height="18" class="style14">100</td>
                            <td colspan="16" class="style8"><span class="style14">
                                    <?= $beTerm1 = getBehaviorMarks($studentId, $term = 1) ?>
                                </span></td>
                        </tr>
                        <tr>
                            <style>
                                span.style6 {
                                    writing-mode: vertical-rl;
                                }
                            </style>
                            <td width="83" height="56"><span class="style15">Module Code</span></td>
                            <td width="223"><span class="style15">Module Title </span></td>
                            <td valign="top"><span class="style13">Module weight </span> </p>
                            </td>
                            <td width="80" align="left" valign="baseline"><span class="style13"><span class="style6">
                                    </span>
                                    <p class="style13">Formative<br />
                                        Assessment </p>
                            </td>
                            <td width="76" valign="top"><span class="style13">Integreted <br />
                                    Assessment</span></td>
                            <td width="98" valign="top"><span class="style13">Comprehensive<br />
                                    Assessment</span></td>
                            <td width="37" valign="top"><span class="style13">Total Marks</span></td>
                            <td width="85" valign="top"><span class="style13">Percentage%</span></td>

                            <td width="99"><span class="style13">Decision</span></td>
                        </tr>
                        <tr>
                            <td colspan="19"><span class="style13"><strong>COMPLEMENTARY MODULES</strong></span></td>
                        </tr>
                        <?php
                        $totalTerm1Type1 = 0;
                        $totalTerm1Type2 = 0;
                        $totalTerm1Type3 = 0;
                        $totalweight1 = 0;
                        $totalweight2 = 0;
                        $totalweight3 = 0;
                        $totalna = 0;
                        $totalNumberOfSubjects = 0;
                        $total3 = 0;
                        $total2 = 0;
                        $total1 = 0;
                        $grandTotalAnnual = 0;
                        $totalweight = 0;
                        foreach (getSubjectListAccordingToSubjectType($studentId, 1) as $subjectInfo) {
                            $term1type1 = getSubjectMarksBySubjectId($studentId, $subjectInfo['id'], 1, 1);
                            $na = 1;
                            $term1type3 = getSubjectMarksBySubjectId($studentId, $subjectInfo['id'], 1, 3);

                            $totalTerm1 = floatval($term1type1) + floatval($term1type3);
                            $weight = number_format($subjectInfo['weight']);
                            $totalAnnualPercentage = number_format(($totalTerm1) / number_format($weight) * 100, 2);
                            $total1 += $totalAnnualPercentage;
                            $re_assessment = ($totalAnnualPercentage >= $subjectInfo['passline']) ? "" : $totalAnnualPercentage . "%";
                            $decision = ($totalAnnualPercentage >= $subjectInfo['passline']) ? "Competent" : "NYC";
                            $totalNumberOfSubjects += 1;
                            $grandTotalAnnual = $totalAnnualPercentage;

                            $totalTerm1Type1 += floatval($term1type1);
                            $totalna += floatval($na);
                            $totalTerm1Type3 += floatval($term1type3);
                            $totalweight1 += floatval($weight);

                        ?>
                            <tr>
                                <td><span class="style13"><?php echo $subjectInfo['SubjectCode']; ?></span></td>
                                <td><span class="style13"><?php echo $subjectInfo['SubjectName']; ?></span></td>
                                <td><span class="style13"><?php echo $subjectInfo['weight']; ?></span></td>
                                <td><span class="style13">&nbsp;
                                        <?= $term1type1 ?>
                                    </span></td>
                                <td><span class="style13"><strong>N/A</strong></span></td>
                                <td><span class="style13">&nbsp;
                                        <?= $term1type3 ?>
                                    </span></td>
                                <td><span class="style13">&nbsp;
                                        <?= $totalTerm1 ?>
                                    </span></td>

                                <td><span class="style13">
                                        <?= $totalAnnualPercentage ?>
                                        %</span></td>

                                <td><span class="style13">
                                        <?= $decision ?>
                                    </span></td>
                            </tr>
                        <?php
                        }
                        ?>

                        <tr>
                            <td colspan="19">
                                <div align="center" class="style13"><strong>CORE MODULES</strong></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="19"><span class="style13"><strong>GENERAL MODULES </strong></span></td>
                        </tr>
                        <?php
                        foreach (getSubjectListAccordingToSubjectType($studentId, 2) as $subjectInfo) {
                            $term1type1 = getSubjectMarksBySubjectId($studentId, $subjectInfo['id'], 1, 1);
                            $na = 1;
                            $term1type3 = getSubjectMarksBySubjectId($studentId, $subjectInfo['id'], 1, 3);

                            $totalTerm1 = floatval($term1type1) + floatval($term1type3);
                            $weight = number_format($subjectInfo['weight']);
                            $totalAnnualPercentage = number_format(($totalTerm1) / number_format($weight) * 100, 2);
                            $total2 += $totalAnnualPercentage;
                            $re_assessment = ($totalAnnualPercentage >= $subjectInfo['passline']) ? "" : $totalAnnualPercentage . "%";
                            $decision = ($totalAnnualPercentage >= $subjectInfo['passline']) ? "Competent" : "NYC";
                            $totalNumberOfSubjects += 1;


                            $totalTerm1Type1 += floatval($term1type1);
                            $totalna += floatval($na);
                            $totalTerm1Type3 += floatval($term1type3);
                            $totalweight2 += floatval($weight);

                        ?>
                            <tr>
                                <td><span class="style13"><?php echo $subjectInfo['SubjectCode']; ?></span></td>
                                <td><span class="style13"><?php echo $subjectInfo['SubjectName']; ?></span></td>
                                <td><span class="style13"><?php echo $subjectInfo['weight']; ?></span></td>
                                <td><span class="style13">&nbsp;
                                        <?= $term1type1 ?>
                                    </span></td>
                                <td><span class="style13"><strong>N/A</strong></span></td>
                                <td><span class="style13">&nbsp;
                                        <?= $term1type3 ?>
                                    </span></td>
                                <td><span class="style13">&nbsp;
                                        <?= $totalTerm1 ?>
                                    </span></td>

                                <td><span class="style13">
                                        <?= $totalAnnualPercentage ?>
                                        %</span></td>

                                <td><span class="style13">
                                        <?= $decision ?>
                                    </span></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="19"><span class="style13"><strong>SPECIFIC MODULES </strong></span></td>
                        </tr>
                        <?php
                        foreach (getSubjectListAccordingToSubjectType($studentId, 3) as $subjectInfo) {
                            $term1type1 = getSubjectMarksBySubjectId($studentId, $subjectInfo['id'], 1, 1);
                            $term1type2 = getSubjectMarksBySubjectId($studentId, $subjectInfo['id'], 1, 2);
                            $term1type3 = getSubjectMarksBySubjectId($studentId, $subjectInfo['id'], 1, 3);

                            $totalTerm1 = floatval($term1type1) + floatval($term1type3);
                            $weight = number_format($subjectInfo['weight']);
                            $totalAnnualPercentage = number_format(($totalTerm1) / number_format($weight) * 100, 2);
                            $total3 += $totalAnnualPercentage;
                            $re_assessment = ($totalAnnualPercentage >= $subjectInfo['passline']) ? "" : $totalAnnualPercentage . "%";
                            $decision = ($totalAnnualPercentage >= $subjectInfo['passline']) ? "Competent" : "NYC";
                            $totalNumberOfSubjects += 1;

                            $totalTerm1Type1 += floatval($term1type1);
                            $totalTerm1Type2 += floatval($term1type2);
                            $totalTerm1Type3 += floatval($term1type3);
                            $totalweight3 += floatval($weight);
                            $totalweight = $totalweight1 + $totalweight2 + $totalweight3;

                        ?>
                            <tr>
                                <td><span class="style13"><?php echo $subjectInfo['SubjectCode']; ?></span></td>
                                <td><span class="style13"><?php echo $subjectInfo['SubjectName']; ?></span></td>
                                <td><span class="style13"><?php echo $subjectInfo['weight']; ?></span></td>
                                <td><span class="style13">&nbsp;
                                        <?= $term1type1 ?>
                                    </span></td>
                                <td><span class="style13">
                                        <b>N/A</b></span></td>
                                <td><span class="style13">&nbsp;
                                        <?= $term1type3 ?>
                                    </span></td>
                                <td><span class="style13">&nbsp;
                                        <?= $totalTerm1 ?>
                                    </span></td>

                                <td><span class="style13">
                                        <?= $totalAnnualPercentage ?>
                                        %</span></td>

                                <td><span class="style13">
                                        <?= $decision ?>
                                    </span></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td height="22" colspan="2" class="style7"><span class="style15"><strong>TOTAL</strong></span></td>
                            <td><span class="style13"><?= $totalweight1 + $totalweight2 + $totalweight3 ?></span></td>
                            <td><span class="style13">&nbsp;
                                    <?= $totalTerm1Type1 ?>
                                </span></td>
                            <td>&nbsp;</td>
                            <td><span class="style13">&nbsp;
                                    <?= $totalTerm1Type3 ?>
                                </span></td>
                            <td><span class="style13">&nbsp;
                                    <?= $totalTerm1Type1 + $totalTerm1Type3 ?>
                                </span></td>
                            <td>&nbsp;</td>

                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="22" colspan="2"><span class="style15"><strong>PERCENTAGE</strong></span></td>
                            <td><span class="style13">&nbsp;100%</span></td>
                            <td colspan="8"><span class="style13"><strong>
                                        <?= round(($totalTerm1Type1 + $totalTerm1Type3) * 100 / ($totalweight1 + $totalweight2 + $totalweight3), 2) ?>
                                        %</strong></span></td>
                        </tr>

                        <tr>
                            <td height="19" colspan="2"><span class="style15"><strong>POSITION</strong></span></td>
                            <td colspan="10">
                                <div align="center" class="style13"><strong><?= getStudentPosition($studentId, "term1"); ?></strong>&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td height="33" colspan="2"><span class="style5">Class Trainer's Comment &amp; Signature </span></td>
                            <td colspan="8">&nbsp;</td>
                        </tr>
                        <tr>


                            <td height="28" colspan="10" rowspan="4"><span class="style6">
                                    <label> </label>
                                </span>
                                <div align="center"><strong>SCHOOL MANAGER </strong>:</div>
                            </td>
                        </tr>
                    </table>
                    <p class="style24"> Generated by SARMS Product of DiolichatLtd </p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>

        <?php
                }
            }
        }
        ?>
    </body>

    </html>
<?php
}
?>