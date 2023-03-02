<?php
session_start();
error_reporting(0);
$host='localhost';
$username='root';
$password='';
$conn=mysqli_connect($host,$username,$password,"srms");
if(!$conn){
 die('Could not Connect My Sql:' .mysql_error());
}


$stid=intval($_GET['StudentId']);

$sql = "DELETE FROM tblstudents WHERE StudentId='" . $_GET["StudentId"] . "'";
if (mysqli_query($conn, $sql)) {

    echo "<script>alert('Deleted');document.location = 'manage-students.php'; </script>";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
mysqli_close($conn);
?>