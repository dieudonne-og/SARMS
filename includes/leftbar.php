<style type="text/css">
     .title{
            color: white;
        }
        small{
            color: white;
        }

</style>
<div class="left-sidebar bg-secondary box-shadow " style="background-color: #1f4772;">
    <div class="sidebar-conten">
        <div class="user-info closed">
            <img src="images/photo-1.JPG" alt="diolichat ltd" width="81" height="74" class="img-circle profile-img">
            <h6 class="title" >ACODES MUSHISHIRO </h6>
            <small class="info">TVET SCHOOL</small>
</div>
        <!-- /.user-info -->

        <div class="sidebar-nav" >
            <ul class="side-nav color-gray">
                <li class="nav-header">
 
                    <span class=""></span>
                </li>
                <li>
                    <a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>

                </li>

                <li class="nav-header">
                                       <span class="">Main Category</span>
                </li>
                <li class="has-children">
                    <a href="#"><i class="fa fa-file-text"></i> <span> Classes</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav">
                        <li><a href="create-class.php"><i class="fa fa-bars"></i> <span>Create</span></a></li>
                        <li><a href="manage-classes.php"><i class="fa fa fa-server"></i> <span>List</span></a></li>

                    </ul>
                </li>
                 <li class="has-children">
                <a href="#"><i class="fa fa-users"></i> <span>Trainers</span> <i class="fa fa-angle-right arrow"></i></a>
                <ul class="child-nav">
                    <li><a href="add-trainer.php"><i class="fa fa-bars"></i> <span>New</span></a></li>
<li><a href="manage-trainer.php"><i class="fa fa fa-server"></i> <span>List</span></a></li>
                </ul>
            </li>
            <li class="has-children">
                    <a href="#"><i class="fa fa-file-text"></i> <span>Modules</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav">
                        <li><a href="create-subject.php"><i class="fa fa-bars"></i> <span>Create</span></a></li>
                        <li><a href="manage-subjects.php"><i class="fa fa fa-server"></i> <span>List</span></a></li>
                        <li><a href="add-subjectcombination.php"><i class="fa fa-newspaper-o"></i> <span>Combinations </span></a></li>
                        <a href="manage-subjectcombination.php"><i class="fa fa-newspaper-o"></i> <span>MyModule</span></a>
                </li>
            </ul>
            </li>
                  <li class="has-children">
                <a href="#"><i class="fa fa-users"></i> <span>Learners</span> <i class="fa fa-angle-right arrow"></i></a>
                <ul class="child-nav">
                    <li><a href="add-students.php"><i class="fa fa-bars"></i> <span>New</span></a></li>
                    <li><a href="manage-students.php"><i class="fa fa fa-server"></i> <span>List</span></a></li>

                </ul>
            </li>
                
          
            <li class="has-children">
                <a href="#"><i class="fa fa-info-circle"></i> <span>Results</span> <i class="fa fa-angle-right arrow"></i></a>
                <ul class="child-nav"><!--
                    <li><a href="#"><i class="fa fa-bars"></i> <span>Assessment Marks</span></a></li>
                    <li><a href="#"><i class="fa fa-bars"></i> <span>Re-Assesment Marks</span></a></li>
             
                    <li><a href="#"><i class="fa fa fa-server"></i> <span> Add Behavior Marks</span></a></li> -->
                           <li><a href="manage-results.php"><i class="fa fa fa-server"></i> <span>Result</span></a></li>
                </ul>
                

            </li>
                   <li class="has-children">
                <a href="#"><i class="fa fa fa-fa fa-file-text"></i> <span>Messages</span> <i class="fa fa-angle-right arrow"></i></a>
                <ul class="child-nav">
                    <li><a href="post.php"><i class="fa fa-bars"></i> <span>Group </span></a></li>
                    <li><a href="private.php"><i class="fa fa-bars"></i> <span> Personal </span></a></li></ul>

       <li><a href="change-password.php"><i class="fa fa fa-server"></i> <span>Password</span></a></li> 
                    <li><a href="logout.php" class="color-danger "><i class="fa fa-sign-out"></i> Logout</a></li> 
        </div>
        <!-- /.sidebar-nav -->
    </div>
    <!-- /.sidebar-content -->
    <li><font color="white">
                                <?php
                                $Today = date('y:m:d');
                                $new = date(' F d, Y', strtotime($Today));
                                echo $new;
                                ?></li>

            </li>
                

    
               </font> 
                </li>
</div>
