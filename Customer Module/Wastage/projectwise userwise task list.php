<?php 
 include('config.php');
?>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Projectwise Userwise Task List </title>

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
                     
						    <form method="post" action="projectwise userwise task list.php" class="form-horizontal" id="frmEntry" name="frmEntry">
                        <div class="ibox-title">
							<h5> Projectwise Userwise Task List </h5>
							<div class="ibox-content">
							
							 <div class="form-group"><label class="col-sm-2 col-lg-offset-3">project name</label>

                                    <div class="col-sm-4"><select class="form-control m-b" id="cmb_project" name="cmb_project" class="dropdown" onChange="ComboClick();">
									<option	 value="0">--- Select Project ---</option>
							<?php
								
								$sql="Select * from project_master order by Name";
								$res1 = mysqli_query($link,$sql);
								while($row1 = mysqli_fetch_array($res1))
								{
									//echo '<option value="' . $row1['Id'] . '" >' . $row1['Name'] . '</option>';
									
									echo '<option value="' . $row1['Id'] . '" ';
								if(isset($_REQUEST['cmb_project']) && $_REQUEST['cmb_project']==$row1['Id'])
									echo ' selected="Selected" ';
								echo '>' . $row1['Name'] . '</option>';

								}
							?>
							</select>
								</div>
							</div>
								<?php if(isset($_REQUEST['cmb_project'])&& $_REQUEST['cmb_project']<>0)
								{
								?>
								<div class="form-group"><label class="col-sm-2 col-lg-offset-3">Staff:</label>

                                    <div class="col-sm-4"><select class="form-control m-b" id="cmbstaff" name="cmbstaff" class="dropdown" onChange="ComboClick();">
									<option	 value="0">--- Select Staff ---</option>
							<?php
							
								
								$sql="Select t.*,d.Name as Desi,s.Name as Stf from team t,staff_master s,designation_master d ";
								$sql .= " where t.Staff_Id=s.Id and d.Id=t.Designation_Id ";	
								if($_REQUEST['cmb_project'])
								{
									$sql .= " and t.Project_Id=" . $_REQUEST['cmb_project'];
								}
							  	else
									$sql .= " and t.Project_Id=0";
								$res4 = mysqli_query($link,$sql);
								while($row4 = mysqli_fetch_array($res4))
								{
									/*echo '<option value="' . $row4['Id'] . '" ';
								if(isset($_REQUEST['cmb_project']) && $_REQUEST['cmb_project']==$row4['Id'])
									echo ' selected="Selected" ';
								echo '>' . $row4['stf'] . '</option>';*/
									echo '<option value="' . $row4['Id'] . '" >' . $row4['Stf'] . ' - ' . $row4['Desi'] . '</option>';
								}
								
							?>
							</select></div>
                                </div>
							
							
							<?php 
								}
							?>
							
							
							 	</form>
                                </div>
                           
                        </div>
						   
						   <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Task List</h5>
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

								
								<tbody> 	
					<?php
									
					if(isset($_REQUEST['cmbstaff'])&& $_REQUEST['cmbstaff']<>0)
					{
						
						$sql = "Select tm.*,t.Task_Name from task_master tm, task_type_master t";
						//if(isset($_REQUEST['cmb_project'])) 
						$sql .= " where =tm.Staff_Id=" . $_REQUEST['cmbstaff'];
						echo $sql;
						$res = mysqli_query($link,$sql);	 
						while($row = mysqli_fetch_array($res))
						{
							echo '<tr>';
							echo '<td>' . $row['Task_Name'] . '</td>';
				//echo '<td> <a onClick="javascript:deleteconfigTL(' . $row['Staff_Id'] . ',' . $_REQUEST['cmb_project'] . ');" ><i class="fa fa-trash col-lg-offset-10" style=font-size:1.5em;color:red;>  </i></a></td>';
							echo '</tr>';
						}
					}
			
			?>
							</tbody>
							</table>
			</div>
                        
                    </div>
                </div>
               
	 
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
