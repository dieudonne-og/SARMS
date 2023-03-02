
<?php
session_start();
error_reporting(0);
include('includes/config.php');

if($_SESSION['alogin']=''){
 
    header("Location: index.php"); 
    
}
if(isset($_POST['login']))
{
$uname=$_POST['username'];
$password=$_POST['password'];
$type=$_POST['type'];
$classid=$_POST['classid'];

$sql ="SELECT UserName,Password,type,classid FROM admin WHERE type=1 and UserName=:uname and Password=:password and classid=:classid";
$query= $dbh -> prepare($sql);

$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> bindParam(':classid', $classid, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$_SESSION['alogin']=$_POST['username'] ;
echo "<script type='text/javascript'> document.location = 'trainerdash.php'; </script>";
} 
else{
$sql ="SELECT classid,Password,type FROM admin WHERE type=0 and classid=:classid and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':classid', $classid, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$_SESSION['alogin']=$_POST['classid'] ;
echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
}
else{
$sql ="SELECT classid,Password,type FROM admin WHERE type=0 and classid=:classid and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':classid', $classid, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$_SESSION['alogin']=$_POST['classid'] ;
echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
}


else{

    echo "<script>alert('Invalid Details ');</script>";
   echo "<script>alert('Forget credentials -Contact your System Administrator');</script>";
}
}
}
}

?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>SARMS</title>
  <link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="slide navbar style.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form action="find-result.php" method="post">
					<label for="chk" aria-hidden="true">S A R M S</label>

					<input type="text" step="any" name="search" placeholder="Names" required="" maxlength="5" minlength="5" autofocus >
					
					<button type="submit" name="save">Search</button>
				</form>
			</div>

			<div class="login">
				<form class="form-horizontal" method="post">
					<label for="chk" aria-hidden="true">Login</label>
					<select name="username" class="form-control" id="default" >
                                                            <center><option  value="" style="font-size: 20px"  > &nbsp;&nbsp;     &nbsp;Class  </option></center>
                                                            <?php $sql = "SELECT * from tblclasses";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {   ?>
                                                                    <option style="font-size: 22 px" value="<?php echo htmlentities($result->id); ?>">

                                                                  <?php echo htmlentities($result->class); ?></option>
                                                            <?php }
                                                            } ?>
                                                        </select><input type="text" name="classid" class="form-control" id="inputEmail3" placeholder=" Username">
                                                    		     
                                                    			<input type="password" name="password" class="form-control" id="inputPassword3" placeholder=" Password" >
					<button type="submit" name="login" >Login</button>
				
				</form><center>
SARMS ©   <?php
                                $Today = date('y:m:d');
                                $new = date(' Y', strtotime($Today));
                                echo $new;
                                ?>.<small style="font-size: 8px;">All Rights Reserved |<a href="diolichat.com">  Diolichat </a> </small></center>
			</div>

	</div>

</body>
</html>
<!-- partial -->
  
</body>
</html>
