
    <style type="text/css">
        
        input{
            background-color: black;

        }
        h6{
            color: white;
        }
        small{
            color: white;
        }
    </style>
                                                           
<div class="left-sidebar bg-black-500 box-shadow " style="background-color: #1f4772;">
    <div class="sidebar-conten">
        <div class="user-info closed">
            <img src="images/photo-1.JPG" alt="diolichat ltd" width="81" height="74" class="img-circle profile-img">
            <h6 class="title"> ACODES MUSHISHIRO</h6>
            <small class="info">TVET SCHOOL</small>
</div>
        <!-- /.user-info -->

        <div class="sidebar-nav" >
            <ul class="side-nav color-gray">
                <li class="nav-header">
                <span class=""> <strong></strong></span>
                </li>
                <li>
                <li>
                    <a href="trainerdash.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>

                </li>

                 
                <li class="nav-header">
                                       <span class="">Main Category</span>
                </li>
               
                  <li>
               <a href="manage-students1.php"> <i class="fa fa-users"></i></i> <span>Learners</span></a> </a></li>

    <li>
                  <a href="manage-subjectcombination1.php"> <i class="fa fa-newspaper-o"></i>  <span>Modules </span></a>
                    
              </li>        
                        

           
          
            <li class="has-children">
                <a href="#"><i class="fa fa-info-circle"></i> <span>Marks Results</span> <i class="fa fa-angle-right arrow"></i></a>
                <ul class="child-nav">
                    <li><a href="add-result.php"><i class="fa fa-bars"></i> <span> Assessment </span></a></li>
                    <li><a href="add-re-assesment-result.php"><i class="fa fa-bars"></i> <span>Re-Assesment </span></a></li>
             
                    <li><a href="behavior.php"><i class="fa fa fa-server"></i> <span> Behavior </span></a></li>
                           <li><a href="manage-results1.php"><i class="fa fa fa-server"></i> <span>Results</span></a></li>
                </ul>
                

            </li>
            <li class="has-children">
                <a href="#"><i class="fa fa fa-fa fa-file-text"></i> <span>Messages</span> <i class="fa fa-angle-right arrow"></i></a>
                <ul class="child-nav">
                    <li><a href="post1.php"><i class="fa fa-bars"></i> <span>Group </span></a></li>
                    <li><a href="private1.php"><i class="fa fa-bars"></i> <span> Personal</span></a></li></ul>
       <li><a href="change-password1.php"><i class="fa fa fa-server"></i> <span>Password</span></a></li> 

            </li>
    <li><a href="logout.php" class="color-danger "><i class="fa fa-sign-out"></i> Logout</a></li> 
</span>
                </li>
        </div>
        <!-- /.sidebar-nav -->
    </div>
    <!-- /.sidebar-content -->
    <i class="icon-calendar icon-large"></i>
                                <?php
                                $Today = date('y:m:d');
                                $new = date(' F d, Y', strtotime($Today));
                                echo $new;
                                ?>
   
               </font> 
                </li>
</div>