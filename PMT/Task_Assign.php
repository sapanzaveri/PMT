<?php
session_start();
	if(!isset($_SESSION['UName']) || $_SESSION['UName'] == "")
	{
		header("Location:index.php");
	}
	$message="";
	include("config.php");
	$Id=0;
	if(isset($_POST['btnsubmit']))
	{
		
		$pname=($_POST['cmb_project']);
		$TaskType=($_POST['cmbtasktype']);
		$staff=($_POST['cmbstaff']);
		$status=($_POST['cmbstatus']);
		$statusDate=($_POST['status_Date']);
		$startdate=($_POST['start_date']);
		$starttime=($_POST['start_Time']);
		$ApproximateDate=($_POST['Approx_date']);
		$ApproximateTime=($_POST['Approx_Time']);
		$DeadlineDate=($_POST['Deadline_Dt']);
		$DeadlineTime=($_POST['Deadline_time']);
		$Description=($_POST['txt_description']);
		$hdnId = $_POST['hdnId'];

		if($hdnId==0)
		{
		$sql = "INSERT INTO `task_master`(`Task_Start_Date`, `Task_Start_Time`, `Task_Due_Date`, `Task_Due_Time`, `Task_Complete_Date`, `Task_Description`, `Status_Id`, `Task_Type_Id`, `Project_Id`, `Staff_Id`, `status_date`, `Task_Complete_Time`,Assign_By, `Company_Id`) VALUES ('$statusDate','$starttime','$ApproximateDate','$ApproximateTime','$DeadlineDate','$Description','$status','$TaskType','$pname','$staff','$statusDate','$DeadlineTime','" . $_SESSION['UID'] . "','" . $_SESSION['CID'] . "' )";	
		}
		else
		{
			
			$sql="Update task_master set";
			$sql .= " Task_Start_Date='$startdate', ";
			$sql .= " Task_Start_Time='$starttime', ";
			$sql .= " Task_Due_Date='$ApproximateDate', ";
			$sql .= " Task_Due_Time='$ApproximateTime', ";
			$sql .= " Task_Complete_Date='$DeadlineDate',";
			$sql .= " Task_Description='$Description',";
			$sql .= "  Status_Id='$status',";
			$sql .= "  Task_Type_Id='$TaskType',";
			$sql .= "  Project_Id='$pname',";
			$sql .= "  status_date='$statusDate',";
			$sql .= "  Staff_Id='$staff',";
			$sql .= " Task_Complete_Time='$DeadlineTime', ";
			$sql .= " IsShown=false,";
			$sql .= " Company_Id='" . $_SESSION['CID'] . "' ,";
			$sql .= " Assign_By='" . $_SESSION['UID'] . "' ";
			$sql .= " Where Id=" . $hdnId;
			$redirect ="projectwisetasklist.php?cmb_project=$pname";
		}
		$resultset=mysqli_query($link,$sql);
		if($resultset)
		{
		?>
		<script type="text/javascript">
			alert("Task Saved Successfully");
			window.location.href="Task_Assign.php";
</script>
<?php	
		header('Location: '.$redirect);
		}
		else 
		{
		?>
		<script type="text/javascript">
			alert("Task  Already Assign");
			window.location.href="Task_Assign.php";
</script>
<?php	
			header('Location: '.$redirect);
			
		}
	}

	if(isset($_GET['cid']))
	{
		$Id = $_GET['cid'];
		$sql = "SElect * from task_master where Id=" . $Id;
		$res=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($res);
	
	}
?>
<!DOCTYPE html>

<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Task Assign</title>

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
                       <form method="post" action="Task_Assign.php" class="form-horizontal" id="frmEntry" name="frmEntry">
						   
						<?php echo $message; ?>
						   <input type="hidden" name="hdnId" id="hdnId" value="<?php echo $Id; ?>">
                        <div class="ibox-title">
							 <h5>Task Assign</h5>
                              	 
                        <div class="ibox-content">
                           <!--<form method="post" action="Task.php">-->
                            
							 <div class="form-group"><label class="col-sm-2 col-lg-offset-3">project name</label>

                                    <div class="col-sm-3"><select class="form-control m-b" id="cmb_project" name="cmb_project" class="dropdown" onChange="ComboClick();" value="<?php if($Id<>0) echo $row['Project_Id']; ?>">
									<option	 value="0">--- Select Project ---</option>
							<?php
								$sql="Select Id,Name from project_master";
								$sql .= " Where Company_Id=" .$_SESSION['CID'];
								$sql .=" order by Name";
								
								$res1 = mysqli_query($link,$sql);
										$selected = 0;
								while($row1 = mysqli_fetch_array($res1))
								{
									//echo '<option value="' . $row1['Id'] . '" >' . $row1['Name'] . '</option>';
									
									echo '<option value="' . $row1['Id'] . '" ';
									
									if(isset($_REQUEST['cmb_project']) && $_REQUEST['cmb_project']==$row1['Id'])
									{
										echo ' selected="Selected" ';
										$selected=1;
									}
									if($Id<>0 && $row1['Id'] == $row['Project_Id'] && $selected==0)
										echo ' selected ="Selected" ';
								echo '>' . $row1['Name'] . '</option>';
										
								}
										
										
									
											
										
										
										
							?>
							</select>
								</div>
							</div>
							
							 <div class="form-group"><label class="col-sm-2 control-label">Task type</label>

                                    <div class="col-sm-5"><select class="form-control m-b" id="cmbtasktype" name="cmbtasktype" class="dropdown" value="<?php if($Id<>0) echo $row['Task_Type_Id']; ?>">
							<?php
								$sql="Select Id,Task_Name from task_type_master ";
								$sql .=" where Company_Id=" .$_SESSION['CID'];
								$sql .= " order by Task_Name";
								$res2 = mysqli_query($link,$sql);
								while($row2 = mysqli_fetch_array($res2))
								{
									echo '<Option value="' . $row2['Id'] . '" ';
											if($Id <>0 && $row['Task_Type_Id'] == $row2['Id'])
											echo " Selected=selected ";
											echo ' >' . $row2['Task_Name'] . '</option>';
									//echo '<option value="' . $row2['Id'] . '" >' . $row2['Task_Name'] . '</option>';
								}
							?>
							</select></div>
                                </div>
 <!-------------------------------Staff Selection --------------------------------------------------->
							<div class="form-group"><label class="col-sm-2 control-label">Staff:</label>

                                    <div class="col-sm-5"><select class="form-control m-b" id="cmbstaff" name="cmbstaff" class="dropdown">
									<option	 value="0">--- Select Staff ---</option>
							<?php
							
								
								$sql="Select *,d.Name as Desi,s.Name as Stf, s.Id as sid from team t,staff_master s,designation_master d ";
								$sql .= " where t.Staff_Id=s.Id and d.Id=t.Designation_Id ";
								$sql .= " and t.Company_Id=".$_SESSION['CID'];
								if($_REQUEST['cmb_project'])
								{
									$sql .= " and t.Project_Id=" . $_REQUEST['cmb_project'];
								}
							  	elseif($Id<>0)
									$sql .= " and t.Project_Id=" . $row['Project_Id'];
								else
									$sql .= " and t.Project_Id=0";
								echo $sql;
								$res4 = mysqli_query($link,$sql);
								while($row4 = mysqli_fetch_array($res4))
								{
									echo '<option value="' . $row4['sid'] . '"';
									if($Id<>0 && $row['Staff_Id']==$row4['sid'])
										echo ' Selected="Selected" ';
									echo ' >' . $row4['Stf'] . ' - ' . $row4['Desi'] . '</option>';
								}
								
							?>
							</select></div>
                                </div>
 <!---------------------------------Satuts------------------------------------------------------------->
                                <div class="form-group"><label class="col-sm-2 control-label">Status:</label>

                                    <div class="col-sm-5"><select class="form-control m-b" id="cmbstatus" name="cmbstatus" class="dropdown" value="<?php if($Id<>0) echo $row['Status_Id']; ?>">
							<?php
								
								$sql="Select Id,Name from status_master order by Name";
								$res3 = mysqli_query($link,$sql);
								while($row3 = mysqli_fetch_array($res3))
								{
									echo '<Option value="' . $row3['Id'] . '" ';
											if($Id <>0 && $row['Status_Id'] == $row3['Id'])
												echo " Selected=selected ";
											echo ' >' . $row3['Name'] . '</option>';
									//echo '<option value="' . $row3['Id'] . '" >' . $row3['Name'] . '</option>';
								}
							?>		
							</select></div>
                                </div>
                                
                                    <div class="form-group"><label class="col-sm-2 control-label">Task Description</label>

                                    <div class="col-sm-5"><Textarea class="form-control" id="txt_description" name="txt_description" placeholder="Enter Description" required oninvalid="this.setCustomValidity('Enter Task Remark)"  onchange="this.setCustomValidity('')" ><?php if($Id<>0) echo $row['Task_Description']; ?></textarea></div>
                                	</div>
   
     
							
                                <div class="form-group"><label class="col-sm-2 control-label">Status Date:</label>

                                    <div class="col-sm-5"><input type="Date" class="form-control" id="status_Date" name="status_Date" required oninvalid="this.setCustomValidity('Enter Status Date  ')"  onchange="this.setCustomValidity('')" value="<?php if($Id<>0) echo $row['status_date']; ?>" ></div>
                                </div>
							<div class="form-group"><label class="col-sm-2 control-label">Start Date:</label>

                                    <div class="col-sm-5"><input type="Date" class="form-control" id="start_date" name="start_date" required oninvalid="this.setCustomValidity('Enter Start Date  ')"  onchange="this.setCustomValidity('')" onBlur="compare();" value="<?php if($Id<>0) echo $row['Task_Start_Date']; ?>"></div>
                                </div>
                                 <div class="form-group"><label class="col-sm-2 control-label">Start Time:</label>

                                    <div class="col-sm-5"><input type="Time" class="form-control" id="start_Time" name="start_Time"   required oninvalid="this.setCustomValidity('Enter Start Time  ')"  onchange="this.setCustomValidity('')" value="<?php if($Id<>0) echo $row['Task_Start_Time']; ?>"></div>
                                </div> 
                                 <div class="form-group"><label class="col-sm-2 control-label">Esstimated Date:</label>

                                    <div class="col-sm-5"><input type="Date" class="form-control" id="Approx_date" name="Approx_date"  required oninvalid="this.setCustomValidity('Enter Esstimated Date  ')"  onchange="this.setCustomValidity('')" onBlur="compare();" value="<?php if($Id<>0) echo $row['Task_Due_Date']; ?>"></div>
                                </div>
                                 <div class="form-group"><label class="col-sm-2 control-label">Esstimated Time:</label>

                                    <div class="col-sm-5"><input type="Time" class="form-control" id="Approx_Time" name="Approx_Time"  required oninvalid="this.setCustomValidity('Enter Esstimated Time  ')"  onchange="this.setCustomValidity('')"  value="<?php if($Id<>0) echo $row['Task_Due_Time']; ?>"></div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Deadline Date</label>

                                    <div class="col-sm-5"><input type="date" class="form-control" id="Deadline_Dt" name="Deadline_Dt"    required oninvalid="this.setCustomValidity('Enter Deadline Date/Time ')"  onchange="this.setCustomValidity('')" onBlur="compare();" value="<?php if($Id<>0) echo $row['Task_Complete_Date']; ?>"></div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Deadline Time</label>

                                    <div class="col-sm-5"><input type="time" class="form-control" id="Deadline_time" name="Deadline_time"    required oninvalid="this.setCustomValidity('Enter Deadline Time ')"  onchange="this.setCustomValidity('')"  value="<?php if($Id<>0) echo $row['Task_Complete_Time']; ?>"></div>
                                </div>
                                
								 
                                <div class="hr-line-dashed"></div>
                               <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white" type="reset">Clear</button>
                                        <button class="btn btn-primary" type="submit" name="btnsubmit">Save</button>
                                    </div>
                                </div>
							   <!--</form>-->
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
     <script type="text/javascript">
		function compare()
{	
	if (document.getElementById("status_Date").value)
		{
			
   
	var statusdt = document.getElementById("status_Date").value;		
    var startDt = document.getElementById("start_date").value;
	var approx = document.getElementById("Approx_date").value;
	var deadline = document.getElementById("Deadline_Dt").value;
	
    if( (new Date(statusdt) > new Date(startDt)))
			
    {
		//var form = document.getElementById("txt_ddate");
		//for.reset();
		
		alert("Status date should not be less than Start Date");
		document.getElementById("start_date").value='';
    }
			else
				{
					
				}
	if( (new Date(statusdt) > new Date(approx)))
			
    {
		//var form = document.getElementById("txt_ddate");
		//for.reset();
		
		alert("Status date should not be less than Estimated Date");
		document.getElementById("Approx_date").value='';
    }
			else
				{
					
				}
	if( (new Date(statusdt) > new Date(deadline)))
			
    {
		//var form = document.getElementById("txt_ddate");
		//for.reset();
		
		alert("Status date should not be less than Deadline Date");
		document.getElementById("Deadline_Dt").value='';
    }
			else
				{
					
				}
		}
}
			</script>
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
