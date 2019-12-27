<?php
	session_start();
	if(!isset($_SESSION['UName']) || $_SESSION['UName'] == "")
	{
		header("Location:index.php");
	}
	include("config.php");
    $tid=0;
	$message="";
	if(isset($_POST['btnSubmit']))
	{
		
		$selecttask=($_POST['cmbtask']);
		$Remark=($_POST['txt_remark']);
		$status=($_POST['cmbstatus']);
		$dt=date('y-m-d');
		$sql = "INSERT INTO `task_status`(`Status_Id`, `Task_Master_Id`, `Remark`,Staff_Id,status_date) VALUES ('$status','$selecttask','$Remark'," . $_SESSION['UID'] . ",'$dt')";
		
		$resultset=mysqli_query($link,$sql);
		$sql = "INSERT INTO `notification`(`Description`, `Genrated_Page`, `Redirected_Page`, `Redirected_Field`, `Redirected_Value`, `From_Id`, `To_Id`, `IsShown`) VALUES(";
	//$sql .=" '". $_POST['cmbtask'] ." of ". $_POST['cmb_project']." Has been Completed.','task_status_update.php', 'Dashboard.php','tsurem','','".$_SESSION['UID']."', '".$emrow['Staff_Id']."', '0') ";
		mysqli_query($link,$sql);
		if($resultset)
		{
		$message = "Task status updated";
		}
		else 
		{
		$message = "Not successfull data insert.";
		}
	}

	if(isset($_GET['task_mst_id']))
	{
		$tid = $_GET['task_mst_id'];
		$sql = "update task_master set IsShown=true where Id=" . $tid;
        
		$tres = mysqli_query($link,$sql);
        $sql = "Select * from task_master where Id=" . $tid;
        $tres = mysqli_query($link,$sql);
        $trow = mysqli_fetch_array($tres);
	}
?>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Task status Update</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
<script >
function ComboClick() {

document.frmEntry.submit();

}
</script>
</head>

<body>
    <div id="wrapper">
   <?php include('sidebar.php')?>
       <?php include('header.php')?>
       
       <?php include('footer.php')?>
     <div id="right-sidebar">
            <div class="sidebar-container">
 				<?php include('rightsidetoolbar.php') ?>
		 </div>
		</div>
       <div class="wrapper wrapper-content animated fadeIn">

                <div class="p-w-md m-t-sm">
                      <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                       <form method="post" action="task_status_update.php" class="form-horizontal" id="frmEntry" name="frmEntry">
                        <div class="ibox-title">
							 <h5>Task Status Update</h5>
                              	 
                        <div class="ibox-content">
                           
                            <?php echo $message; ?>
                            	 <div class="form-group">		
							 <label class="col-md-2 col-md-offset-3 control-label"><strong>Project Name</strong></label>
						<div class="col-sm-4" ><select class="form-control m-b" name="cmb_project" id="cmb_project" onChange="ComboClick();">
					   	<option	 value="0">--- Select Project ---</option>
						   <?php

							$sql = "Select * from project_master";
							$sql .=" Where Company_Id=" . $_SESSION['CID'];
							$sql .=" order by Name";
							$dres = mysqli_query($link,$sql);
                            $selected=0;
							while($drow = mysqli_fetch_array($dres))
							{
								//echo '<Option value="' . $drow['Id'] . '" ';

								echo '<option value="' . $drow['Id'] . '" ';
								
                                if(isset($_REQUEST['cmb_project']) && $_REQUEST['cmb_project']==$drow['Id'])
                                {
                                    $selected=1;
                                    echo ' selected="Selected" ';
                                }
									
                                if($tid<>0 && $selected==0 && $trow['Project_Id']==$drow['Id'])
                                {
                                    echo ' selected="selected" ';
                                }
								echo '>' . $drow['Name'] . '</option>';

							}

							?>
							</select>	
								 </div></div>
                            <?php if(isset($_REQUEST['cmb_project']) || $tid<>0)
                            {
                            ?>
						  <div class="form-group"><label class="col-sm-2 col-lg-offset-3">Select Task</label>

                                    <div class="col-sm-3"><select class="form-control m-b" id="cmbtask" name="cmbtask" class="dropdown" onChange="ComboClick();">
									<option value="0">-----select Task-------</option>
							<?php
								$sql="Select tm.*, ttm.Task_Name from task_master tm ,task_type_master ttm";
								$sql .=" where tm.Task_Type_Id=ttm.Id";
								$sql .=" and tm.Company_Id=" . $_SESSION['CID'];
								$sql .= " And tm.Staff_Id=" . $_SESSION['UID'];
                                if(isset($_REQUEST['cmb_project']))
                                    $sql .= " and tm.Project_Id=" . $_REQUEST['cmb_project'];
                                else
                                    $sql .= " and tm.Project_Id=" . $trow['Project_Id'];
								$res1 = mysqli_query($link,$sql);
								$selected=0;
								while($row1 = mysqli_fetch_array($res1))
								{
								echo '<option value="' . $row1['Id'] . '" ';
								if(isset($_REQUEST['cmbtask']) && $_REQUEST['cmbtask']==$row1['Id'])
                                {
									echo ' selected="Selected" ';
                                    $selected=1;
                                }
                                if($tid<>0 && $selected==0 && $tid==$row1['Id'])
                                {
                                    echo ' selected="Selected" ';
                                }
								echo '>' . $row1['Task_Name'] . '</option>';
									//echo '<option value="' . $row1['Id'] . '" >' . $row1['Task_Name'] . '</option>';
								}
							?>
							</select>
								</div>
                              <?php } ?>
							</div>	
							   
							  <div class="form-group"><label class="col-sm-2 control-label">Remark</label>

                                    <div class="col-sm-10"><textarea class="form-control" id="txt_remark" name="txt_remark" placeholder="Enter Remark"  ></textarea></div>
                                	</div>
							   <div class="form-group"><label class="col-sm-2 control-label">status </label>
						
                                    <div class="col-sm-5"><select class="form-control m-b" id="cmbstatus" name="cmbstatus" class="dropdown">
									<option> -----Select Status-----</option>
							<?php
								if(isset($_REQUEST['cmbtask']))
								{
								$sql="Select * from status_master ";
                                $sql .= " order by Name";
								$res1 = mysqli_query($link,$sql);
								while($row1 = mysqli_fetch_array($res1))
								{
									echo '<option value="' . $row1['Id'] . '" >' . $row1['Name'] . '</option>';
								}
								}
							?>
							</select>
								</div>
							</div>	
   								<div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">

                                        <button class="btn btn-primary" type="submit" name="btnSubmit" id="btnSubmit">Save</button>
                                    </div>
                                </div>

                                
							 
                             	</form>
                                </div>
                           
                        </div>
						   
						   <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Task status</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            
                            <!--<a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>-->
                        </div>
                    </div>
                    <div class="ibox-content">
 						<table class="table table-striped">
							<thead>
							<tr> 
								<th>Status Date </th>
								<th>Status </th>
								<th>Staff Name</th>
								<th>Remark</th>
								</tr>
											
							</thead>
							<tbody>
								<?php 
                                        if(isset($_REQUEST['cmbtask']))
                                        {
										$sql= "Select s.*,st.Name as status,sf.Name as staff ";
										$sql .= " from task_status s, status_master st, staff_master sf";
										$sql .= " where s.Status_Id=st.Id ";
										$sql .= " and s.Staff_Id=sf.Id ";
										
										$sql .= " and s.Task_Master_Id=" . $_REQUEST['cmbtask'];
								
                                            $sql .= " and s.Staff_Id=" . $_SESSION['UID'];
                                    $xres = mysqli_query($link,$sql);
                                        }
                                        elseif($tid<>0)
                                        {
                                        $sql= "Select s.*,st.Name as status,sf.Name as staff ";
										$sql .= " from task_status s, status_master st, staff_master sf";
										$sql .= " where s.Status_Id=st.Id ";
										$sql .= " and s.Staff_Id=sf.Id ";
                                        $sql .= " and Task_Master_Id=" . $tid;
                                	
									        $sql .= " and s.Staff_Id=" . $_SESSION['UID'];
                                        $xres = mysqli_query($link,$sql);
										}
										if(isset($xres) && mysqli_num_rows($xres)>=1)
										{
										while($row = mysqli_fetch_array($xres))
										{
											echo '<tr>';
												echo '<td>'.$row['status_date'].'</td>';
												echo '<td>'.$row['status'].'</td>';
												echo '<td>'.$row['staff'].'</td>';
												echo '<td>' . $row['Remark'] . '</td>';
											echo '</tr>';
										}
										}
                                        
											?>
								
											
								
							</tbody>
						</table>
							 
                    </div>
                </div>
            </div>
                         </form>
                    </div>
                </div>
            </div>
        </div>
		   </div>
            </div>
   
    
    
    
    

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="js/plugins/flot/jquery.flot.time.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>


    <script>
        $(document).ready(function() {

            var sparklineCharts = function(){
                $("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 52], {
                    type: 'line',
                    width: '100%',
                    height: '50',
                    lineColor: '#1ab394',
                    fillColor: "transparent"
                });

                $("#sparkline2").sparkline([32, 11, 25, 37, 41, 32, 34, 42], {
                    type: 'line',
                    width: '100%',
                    height: '50',
                    lineColor: '#1ab394',
                    fillColor: "transparent"
                });

                $("#sparkline3").sparkline([34, 22, 24, 41, 10, 18, 16,8], {
                    type: 'line',
                    width: '100%',
                    height: '50',
                    lineColor: '#1C84C6',
                    fillColor: "transparent"
                });
            };

            var sparkResize;

            $(window).resize(function(e) {
                clearTimeout(sparkResize);
                sparkResize = setTimeout(sparklineCharts, 500);
            });

            sparklineCharts();




            var data1 = [
                [0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,20],[11,10],[12,13],[13,4],[14,7],[15,8],[16,12]
            ];
            var data2 = [
                [0,0],[1,2],[2,7],[3,4],[4,11],[5,4],[6,2],[7,5],[8,11],[9,5],[10,4],[11,1],[12,5],[13,2],[14,5],[15,2],[16,0]
            ];
            $("#flot-dashboard5-chart").length && $.plot($("#flot-dashboard5-chart"), [
                        data1,  data2
                    ],
                    {
                        series: {
                            lines: {
                                show: false,
                                fill: true
                            },
                            splines: {
                                show: true,
                                tension: 0.4,
                                lineWidth: 1,
                                fill: 0.4
                            },
                            points: {
                                radius: 0,
                                show: true
                            },
                            shadowSize: 2
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,

                            borderWidth: 2,
                            color: 'transparent'
                        },
                        colors: ["#1ab394", "#1C84C6"],
                        xaxis:{
                        },
                        yaxis: {
                        },
                        tooltip: false
                    }
            );

        });
    </script>
</body>

<!-- Mirrored from webapplayers.com/inspinia_admin-v2.7.1/dashboard_5.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2017 12:21:52 GMT -->
</html>
