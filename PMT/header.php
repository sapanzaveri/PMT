<?php
$ABId=0;
if(isset($_GET['norem']))
{
	$ABId = $_GET['norem'];
	$sql = "Update notification set";
		$sql .=" IsShown=0 ";
		$sql .=" Where Id=" .$ABId;
		
		$bires = mysqli_query($link,$sql);
}
?>
            <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="http://webapplayers.com/inspinia_admin-v2.7.1/search_results.html">
               <!-- <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div> -->
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome to project management tool</span>
                </li>
                <!--<li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                 
                      <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a7.jpg">
                                </a>
                                <div>
                                    <small class="pull-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a4.jpg">
                                </a>
                                <div>
                                    <small class="pull-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/profile.jpg">
                                </a>
                                <div>
                                    <small class="pull-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>-->
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                    <?php
						$sql = "Select * from task_master where IsShown=false ";
						$sql .= " and Staff_Id=" . $_SESSION['UID'];
						$nres = mysqli_query($link,$sql);
						$no = 0;
					if($nrow=mysqli_fetch_array($nres)>=1)
					{
						
							echo '<li>
                            <a href="task_status_update.php?task_mst_id=' . $nrow['Id'] . '">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i>' . $nrow['Task_Description'] . '   
								</div>
                            </a>
                        </li>';
							
						$no=1;
						} 
					
					
						$sql = "Select * from notification where To_Id=" . $_SESSION['UID'];
						$sql .=" and IsShown=1";
						
						$noRes = mysqli_query($link,$sql);
						while($noRow=mysqli_fetch_array($noRes))
						{
							echo '<li>
							 <a href="'.$noRow['Redirected_Page'] .'?'.$noRow['Redirected_Field'].'=' . $noRow['Id'] . '">
									 
									 
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i>' . $noRow['Description'] . '
								</div>
                            		 
                            	</a>	
                        </li>';
							$no=1;
						}
						
						if($no==0) 
							echo '<p> No notification </p>';
						
						
						?> 
                       <!-- <li>
                            <a href="mailbox.html">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.html">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="grid_options.html">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li> -->
                    </ul>
                </li>

				
                <li>
                    <a href="logout.php">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
                <li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
            </ul>

        </nav>
        </div>