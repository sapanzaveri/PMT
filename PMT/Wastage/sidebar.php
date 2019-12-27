<?php
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('Role_Prev.php');
    include('config.php');
    //$sql = "Select * from staff_master where Id=" . $_SESSION['UID'];
    $sql = "Select distinct(Designation_Id) as Designation from team where Staff_Id=" . $_SESSION['UID'];
    $res = mysqli_query($link,$sql);
    if(mysqli_num_rows($res)>1)
    {
        $Designation="";
        $i=1;
        while($row1 = mysqli_fetch_array($res))
        {
            if($i==1)
                $Designation = $Designation . $row1['Designation']; 
            else
                $Designation = $Designation . ',' . $row1['Designation']; 
            $i=$i+1;
        }
    }
    elseif(mysqli_num_rows($res)==1){
    $lRow = mysqli_fetch_array($res);    
    $Designation = $lRow['Designation'];
        //$sql = "select * from "
    }
    else
    {
        $sql = "Select Designation_Id from staff_master where Id=" . $_SESSION['UID'];
        //echo $sql;
        $lres = mysqli_query($link,$sql);
        $lRow = mysqli_fetch_array($lres);
        $Designation=$lRow['Designation_Id'];
    }
    
//    echo "des:" . $Designation;

?>
<html>
	<nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                           <?php
							$sql ="select Image from staff_master";
							$sql .=" Where Id=" .$_SESSION['UID'];
							$sql .=" and Company_Id=" .$_SESSION['CID'];
							
							$img1 = mysqli_query($link,$sql);
							$img = mysqli_fetch_array($img1)
							
							?>
                            <img alt="image" class="img-circle" src="<?php echo $img['Image'] ?>" height="48px" width="48px"/>
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">
                                <?php 
                        $sql = $sql = "Select Name from staff_master s";
						$sql .= " where Id=" .$_SESSION['UID'];
						$sql .=" and Company_Id=" .$_SESSION['CID'];
                        $res3 = mysqli_query($link,$sql);
						while($row3 = mysqli_fetch_array($res3))
                        {
                            echo $row3['Name'];
                        }
                        ?></strong>
                             </span> <span class="text-muted text-xs block">Profile Details <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                         	<li><a href="profile.php">Profile</a></li>
                            <li><a href="change_password.php">Change Password</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        
                    </div>
                </li>
                <li class="active">
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="Dashboard.php">Dashboard</a></li>
             		</ul>
				</li>
                <?php
                
                    if($FLG_CUSTOMER_ADD == 1 || $FLG_CUSTOMER_VIEW == 1)
                    {
                        echo '<li>
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Customer  Management</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">';
                    if( $FLG_CUSTOMER_ADD == 1)
                        echo '<li><a href="Customer_Entry.php">Customer Entry</a></li>';
					if( $FLG_CUSTOMER_VIEW == 1)
                    	echo '<li><a href="customer_list.php">  Customer list </a></li>';
             		echo'</ul>
				</li>';
                    }
              
                    if($FLG_Staff_ADD==1 || $FLG_Staff_VIEW == 1)
                    {
                        echo '<li>
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Staff Management</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">';
                        if($FLG_Staff_ADD == 1)
                        echo '<li><a href="staff_entry.php">Staff Entry</a></li>';
                        if($FLG_Staff_VIEW == 1)
						echo '<li><a href="Staff_list.php">  Staff Entry list </a></li>';
             		echo '</ul>
				</li>'; 
                    }
            
                    if($FLG_Technology_Add==1 || $FLG_Technology_View == 1)
                    {
                        echo '<li>
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Technology Management</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">';
                         if($FLG_Technology_Add==1 )
                        echo '<li><a href="Technologies.php">Set Technologies</a></li>';
                         if($FLG_Technology_View==1 )
						echo '<li><a href="Technologies_list.php">  Technology list </a></li>';
             		echo '</ul>
				</li>';
                    }
                    if($FLG_Designation_Add==1 || $FLG_Designation_View == 1)
                    {
                        echo '<li>
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Designation Management</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">';
                        if($FLG_Designation_Add==1 )
                       echo '<li><a href="Designation.php"> Set Designation</a></li>';
                        if($FLG_Designation_View==1 )
						echo '<li><a href="Designation_list.php">  Designation list </a></li>';
             		echo '</ul>
				</li>';
                    }
                    if($FLG_Project_Add==1 || $FLG_Project_View == 1 || $FLG_ProjectType_Add==1 || $FLG_ProjectType_View==1)
                    {
                        echo '<li>
                    
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Project Management</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">';
                            if($FLG_ProjectType_Add==1 )
						 echo '<li><a href="Project Type.php">Set Project Type</a></li>';
                            if($FLG_ProjectType_View==1 )
						echo '<li><a href="Project_Type_list.php">  Project Type list </a></li>';
                        
                        if($FLG_Project_Add==1 )
						echo '<li><a href="project_Entry.php"> Set Project</a></li>';
                        if($FLG_Project_View==1 )
						echo '<li><a href="project list.php">  Project list </a></li>';
						 
                       echo '</ul>
				</li> ';
                    }
                
                    if($FLG_Status_Add==1 || $FLG_Status_View == 1)
                    {
                        echo '<li>
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Status Management</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">';
                        if($FLG_Status_Add==1 )
                      echo  '<li><a href="Status_Entry.php">Set Status </a></li>';
                        if($FLG_Status_View==1 )
						echo ' <li><a href="Status_list.php">  Status list </a></li>';
             		echo '</ul>
				</li>';
                    }
                    if($FLG_Task_Add==1 || $FLG_Task_View == 1)
                    {
                        echo '<li>
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Task Management</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">';
                        if($FLG_Task_Add==1 )
                       echo '<li><a href="Task_Entry.php">Set Task </a></li>';
                        if($FLG_Task_View==1 )
						echo '<li><a href="task_list.php">Task list </a></li>';
             		echo '</ul>
				</li>';
                    }
                if($FLG_TEAMLEADER_ADD==1 || $FLG_TEAM_MEMBER_ADD == 1 || $FLG_TEAM_GENERATION_VIEW=1 || $FLG_TEAM_GENERATION_MODIFY=1)
                {
                    echo '<li>
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Team Generation</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">';
                         if($FLG_TEAM_GENERATION_VIEW==1 )
						echo  '<li><a href="Generate_Team.php">Generate Team </a></li>';
						

                      echo  '</ul>
				</li>';
                }
                ?>
                 <li>
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Meeting</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="Mom.php">MOM </a></li>
						<li><a href="pre_metting_mom.php">Pre Meeting </a></li>
						<li><a href="Mom_view.php">Meeting </a></li>
						
            				
             		</ul>
				</li>
                <li>
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Role Allocation</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="Role_Allocation.php">Role Allocation</a></li>
             		</ul>
				</li>
				        <li>
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Report</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
						<li><a href="projectteamreport.php">Project Team Report</a></li>
						<li><a href="projectwise_staff_list.php">Project Wise Staff List </a></li>
						<li><a href="projectwisetasklist.php">Project Wise Task List </a></li>
            			<li><a href="projectwiseuserwisetasklist.php">User Wise Project Wise Task List</a></li>

                        </ul>
				</li>
 
     			 <li>
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Task Assign</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        
						<li><a href="task_status_update.php">Task status update </a></li>
						<li><a href="Task_Assign.php">Task Assign</a></li>
						
						
                      			
             		</ul>
				</li>
                
 
        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
</html> 