<html>
	<nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="img/rsz_admin.png" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">
                        <?php 
                        $sql = $sql = "Select Name from customer_master s";
						$sql .= " where Id=" .$_SESSION['UN'];
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
                <li>
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Request For Proposal</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="RFP.php">Request For Proposal</a></li>
                        <li><a href="RFP_list.php">Request For Proposal List</a></li>
             		</ul>
				</li>
 
        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
</html> 