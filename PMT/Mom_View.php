<?php
session_start();
	if(!isset($_SESSION['UName']) || $_SESSION['UName'] == "")
	{
		header("Location:index.php");
	}
                                  

	?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mom</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
<script language="javascript" type="text/javascript">
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
                        <div class="ibox-title">
                            <h5>Meeting Information</h5>
                            
                        <div class="ibox-content">
                            <form method="post" id="frmEntry" name="frmEntry" class="form-horizontal" action="Mom_View.php">
                             
                                 <div class="form-group"><label class="col-sm-2 control-label">Select Project</label>

                    <div class="col-sm-4" >
                    <select class="form-control m-b" name="cmb_project" id="cmb_project" onChange="ComboClick();" required>
					   	<option	 value="">--- Select Project ---</option>
						   <?php

							$sql = "Select * from project_master";
							$sql .=" Where Company_Id=" . $_SESSION['CID'];
							$sql .=" order by Name";
							$dres = mysqli_query($link,$sql);
							while($drow = mysqli_fetch_array($dres))
							{
								//echo '<Option value="' . $drow['Id'] . '" ';

								echo '<option value="' . $drow['Id'] . '" ';
								if(isset($_REQUEST['cmb_project']) && $_REQUEST['cmb_project']==$drow['Id'])
									echo ' selected="Selected" ';
								echo '>' . $drow['Name'] . '</option>';

							}

							?>
							</select>	
								 </div></div>
                            <?php if(isset($_REQUEST['cmb_project']) && $_REQUEST['cmb_project']<>0)
						{ ?>
                             <div class="form-group"><label class="col-sm-2 control-label">Meeting Title</label>

                    <div class="col-sm-4" >
                        <select class="form-control m-b" name="cmb_Meeting" id="cmb_Meeting" onChange="ComboClick();" required>
					   	<option	 value="">--- Select Meeting ---</option>
						   <?php

							$sql = "Select * from meeting_master";
                            $sql .= " Where Project_Id=" . $_REQUEST['cmb_project'];
							$sql .=" and Company_Id=" . $_SESSION['CID'];
                            $sql .= " order by Name";
							$dres1 = mysqli_query($link,$sql);
							while($drow1 = mysqli_fetch_array($dres1))
							{
								

								echo '<option value="' . $drow1['Id'] . '" ';
								if(isset($_REQUEST['cmb_Meeting']) && $_REQUEST['cmb_Meeting']==$drow1['Id'])
									echo ' selected="Selected" ';
								echo '>' . $drow1['Name'] . '</option>';

							}

							?>
							</select>	
								 </div></div>
                                </div>
                                 <div class="table-responsive">
                            <?php    
                                }
                                if(isset($_REQUEST['cmb_Meeting']) && $_REQUEST['cmb_Meeting']<>0)
                                {
									$sql ="select m.*, sm.Name as sn from mom m, staff_master sm ";
									$sql .=" Where Meeting_Id=" .$_REQUEST['cmb_Meeting'];
									$sql .= " and m.Company_Id=" . $_SESSION['CID'];
									$sql .=" and m.Staff_Id=sm.Id";
									
									$res=mysqli_query($link,$sql);
								   $row=mysqli_fetch_array($res);
                               
                            
                            echo '<table class="table table-bordered table-hover dataTables-example table-striped">
									    <thead>
										<tr>
									     	<td colspan="2" align="center"> Meeting Information  </td>
									     
									     </tr>                 
										 <tr>
									     	<td> Meeting Date/Time:- '.$row['Date']. '/'.$row['Time'].  '</td>
									     	<td> Meeting Location:- '.$row['Location'].'</td> 
									     </tr>                 
										 <tr>
											<td> Called By:- '.$row['Orgainzed_By'].'</td>';
									
										$sql = " Select md.Meeting_Id as mid, md.Staff_Id as sid from meeting_detail md";
										$sql .= " Where Meeting_Id=" . $_REQUEST['cmb_Meeting'];
										$mdres=mysqli_query($link,$sql);
								   		echo '<td align="center"> Attendence';
										
										echo '</td>';
										 echo '</tr>
										 <tr>
										 <td> Facilitator:- '.$row['Facilitator'].'</td>
										 <td rowspan="2">'; 
										 while($mdrow = mysqli_fetch_array($mdres))
											{
											   if(!is_null($mdrow))
											   		{                 
											echo  $mdrow['sid'] .","; 
											}
                            }
										 echo '</tr>
										 <tr>
										 <td> Note Taker:- '.$row['Staff_Id'].' </td>
										 </tr>
										 <tr>
										 <td colspan="2" align="center"> Meeting, Objective, Topics, Discussion and Decisions  </td>
										 </tr>	
										 </thead>
										 <tbody>
										 
										 <tr>
										 <td colspan="2" align="center"> Objective </td>
										 </tr>
										 <tr>
										 <td colspan="2">  '.$row['Objective'].' </td>
										 </tr>
										 <tr>
										 <td colspan="2" align="center"> Topics and Discussion </td>
										 </tr>
										 <tr>
										 <td colspan="2">  '.$row['Topics'].' </td>
										 </tr>
										 <tr>
										 <td colspan="2" align="center"> Decisions </td>
										 </tr>
										 <tr>
										 <td colspan="2">  '.$row['Decision'].' </td>
										 </tr>
										 <tr>
										 <td colspan="2" align="center"> Conclusion </td>
										 </tr>
										 <tr>
										 <td colspan="2">  '.$row['Conclusion'].' </td>
										 </tr>
										 <tr>
										 <td colspan="2" align="center">Next Follow Up</td>
										 </tr>
										 <tr>
										 <td colspan="2">  '.$row['Follow_Up'].' </td>
										 </tr>
										 </tbody>
                                     </table>';
              
   
                                
                                }
                                ?>
                                
                            </form>
                        </div>
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
