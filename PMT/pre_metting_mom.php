<?php
	session_start();
	if(!isset($_SESSION['UName']) || $_SESSION['UName'] == "")
	{
		header("Location:index.php");
	}
	$message="";
	$Id =0;
	include("config.php");
    if(isset($_POST['btnSubmit']))
	{
		$Project=($_POST['cmb_project']);
        $Name=($_POST['txt_name']);
        $Purpose=($_POST['txtpurpose']);
        $Dt=($_POST['txtdate']);
        $Tm=($_POST['txttime']);
        $cnt=0;
		if(isset($_POST['chkIsAllowed']))
		{
			$IsAllowed=$_POST['chkIsAllowed'];
			$cnt=1;
		}
        $sql = "Insert into meeting_master(Dom,Name,Project_Id,Purpose,Tom,`Company_Id`, `Staff_Id`) ";
        $sql .= " Values('$Dt','$Name','$Project','$Purpose','$Tm', '".$_SESSION['CID']."', '". $_SESSION['UID'] ."')";
        $res = mysqli_query($link,$sql);
        if($res)
        {
            $sql = "Select Max(Id) as Id from meeting_master";
			$sql .=" Where Company_Id=" . $_SESSION['CID'];
            $res = mysqli_query($link,$sql);
            $row = mysqli_fetch_array($res);
            $mid = $row['Id'];
            //$sql = "Delete from meeting_detail where Meeting_Id=" . $mid;
            //$res = mysqli_query($link,$sql);
			foreach($IsAllowed as $IsA=>$value)
			{
				//echo $value . ":";
				$sql ="Insert into meeting_detail (Meeting_Id,Staff_Id)Values(";
				$sql .= "'$mid','$value')";
				
				$res = mysqli_query($link,$sql);
			}
            $message = "Meeting Set successfully";
                
        }
        else
        {
            $message = "Error while generation meeting";
        }
        
		
    }
		?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pre Metting MOM</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script language="javascript" type="text/javascript">
		function ComboClick() 
		{

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
                            <h5>Pre Meeting</h5>
                            
                        <div class="ibox-content">
                            <form method="post" class="form-horizontal" id="frmEntry" name="frmEntry" action="pre_metting_mom.php">
                                 <div class="form-group"><label class="col-sm-2 control-label">Project</label>

                                    <div class="col-sm-6"><select class="form-control" name="cmb_project" id="cmb_project" onChange="ComboClick();">
                                        <option value="0">--- Select Project ---</option>
										<?php
											$sql="select * from project_master";
											$sql .=" Where Company_Id=" . $_SESSION['CID'];
											$sql .=" order by Name";
											$dres = mysqli_query($link,$sql);
											while($drow=mysqli_fetch_array($dres))
											{
												echo '<option value="' . $drow['Id'] . '"';
												if(isset($_REQUEST['cmb_project']) && $_REQUEST['cmb_project']==$drow['Id'])
												echo ' selected="Selected" ';
												echo ' >' . $drow['Name'] . '</option>';
											}
										?>
										</select>
                                       </div>
                                    
                                </div>
                               
                                <div class="form-group"><label class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-6"><input type="text" class="form-control" id="txt_name" name="txt_name" placeholder="Enter Name"></div>
                                </div>
                                 <div class="form-group"><label class="col-sm-2 control-label">Purpose</label>

                                    <div class="col-sm-6"><textarea name="txtpurpose" id="txtpurpose" placeholder="Enter Purpose" class="form-control"></textarea></div>
                                </div>
                                  <div class="form-group"><label class="col-sm-2 control-label">Date</label>

                                    <div class="col-sm-6"><input type="date" class="form-control" id="txtdate" name="txtdate" placeholder="Enter Name" ></div>
                                </div>
                                 <div class="form-group"><label class="col-sm-2 control-label">Time</label>

                                    <div class="col-sm-6"><input type="time" class="form-control" id="txttime" name="txttime" placeholder="Enter Name" ></div>
                                </div>
                                
                                
                                
   
                                
                        </div>
                    </div>
                </div>
                   <?php if(isset($_REQUEST['cmb_project']) && $_REQUEST['cmb_project']<>0)
							{
								
							?>
                             
						   <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Particapate</h5>
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
											<td><strong>Staff</strong></td>
											<td><strong>Select</strong></td>
											</tr>
										</thead>
										<tbody>
                                            
											
                                           
											<?php
											$sql = "Select t.*, s.Name as stf, d.Name as desi from";
												$sql .= " team t, staff_master s, designation_master d";
												$sql .=" where s.Id=t.Staff_Id and d.Id=t.Designation_Id";
                                                $sql .=" and t.Company_Id=" . $_SESSION['CID'];												if(isset($_REQUEST['cmb_project'])) 
												$sql = $sql . " and Project_Id=" . $_REQUEST['cmb_project'];
											     $sql .= " order by d.Id";   
                                            $fres = mysqli_query($link,$sql);
								            while($frow = mysqli_fetch_array($fres))
											{
												echo '<tr>';
												echo '<td>' . $frow['stf'] ."-" . $frow['desi'] . '</td>';
												echo '<td><input type="checkbox" style= "zoom:2"; value="' . $frow['Staff_Id'] . '" id="chkIsAllowed" name="chkIsAllowed[]" ';
												
												echo '</tr>';
											}
                                            
								
                                            
										?>
                                              
                      
                                            </tbody>
                           
									</table>
                         
                    </div>
                         <div class="hr-line-dashed"></div>
                               <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-5">
                                        <button class="btn btn-white" type="submit">Cancel</button>
                                        <button class="btn btn-primary" type="submit" name="btnSubmit" id="btnSubmit">Save</button>
                                    </div>
                                </div>
                         </div>
                               
                          <?php 
                                    }           
                    ?>
                </div>
            </div>
             </form>
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
