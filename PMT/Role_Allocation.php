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
		//$con=mysqli_connect('localhost','root','','project_management_tool');
		$desi = $_POST['cmbDesignation'];
		$cnt=0;
		if(isset($_POST['chkIsAllowed']))
		{
			$IsAllowed=$_POST['chkIsAllowed'];
			$cnt=1;
		}
			
		
		$sql="delete from role_allocation where Designation_Id=" . $desi;
		$res = mysqli_query($link,$sql);
		if($cnt==1)
		{
			foreach($IsAllowed as $IsA=>$value)
			{
				//echo $value . ":";
				$sql ="Insert into role_allocation (IsAllowed,Function_Id,Designation_Id) Values(";
				$sql .= "True,'$value','$desi')";
				//echo $sql;
				$res = mysqli_query($link,$sql);
			}
		}
		$sql="Select * from function_master";
		$sql .= " where Id not in (Select Function_Id from role_allocation where Designation_Id=" . $desi . ")";
		//echo $sql;
		$tres = mysqli_query($link,$sql);
		while($trow = mysqli_fetch_array($tres))
		{
			$sql ="Insert into role_allocation (IsAllowed,Function_Id,Designation_Id) Values(";
			$sql .= "false,'" . $trow['Id'] . "','$desi')";
			$res = mysqli_query($link,$sql);
		}
	}

	if(isset($_GET['cid']))
	{
		$Id = $_GET['cid'];
		$sql = "SElect * from customer_master where Id=" . $Id;
		$res=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($res);
	}
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Role Allocation</title>

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
						<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
							<h5><strong>Role Allocation</strong></h5>
                            
                        <div class="ibox-content">
                            <form method="post" class="form-horizontal" action="Role_Allocation.php" id="frmEntry" name="frmEntry">
                               <?php echo $message; ?>
                               <input type="hidden" name="hdnId" id="hdnId" value="<?php echo $Id; ?>">
                                <div class="form-group"><label class="col-md-2 col-md-offset-3 control-label"><strong>Designation</strong></label>

                                    <div class="col-sm-4">
										<select class="form-control m-b" id="cmbDesignation" name="cmbDesignation" onChange="ComboClick();" >
										<option value="0">--- Select Designation ---</option>
										<?php
											$sql="select * from Designation_Master order by Name";
											$dres = mysqli_query($link,$sql);
											while($drow=mysqli_fetch_array($dres))
											{
												echo '<option value="' . $drow['Id'] . '"';
												if(isset($_REQUEST['cmbDesignation']) && $_REQUEST['cmbDesignation']==$drow['Id'])
													echo ' selected="Selected" ';
												echo ' >' . $drow['Name'] . '</option>';
											}
										?>
										</select>
									</div>
                                </div>
								
                                </div>
							</div>
							<br>
							<div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><strong>Functions </strong></h5>
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
 						<div>
									<table class="table table-striped">
										<thead>
											<tr>
											<td><strong>Function</strong></td>
											<td><strong>Select</strong></td>
											</tr>
										</thead>
										<tbody>
										<?php
											//$sql = "Select f.Id,f.Name,r.IsAllowed from function_master f ";
											// $sql .= " Left Join role_allocation r on r.Function_Id=f.Id ";
											$sql = " Select f.Id,f.Name, 0 as IsAllowed from function_master f ";
                                            $sql .= " Where f.Id not in (Select f.Id from function_master f, role_allocation r ";
                                            $sql .= " Where r.Function_Id=f.Id";
                                            if(isset($_REQUEST['cmbDesignation']) && $_REQUEST['cmbDesignation']<>0 )
                                            {
												$sql .= " and r.Designation_Id=" . $_REQUEST['cmbDesignation'];
                                            }
                                            else
                                            {
                                                $sql .= " and r.Designation_Id=0";
                                            }
                                            $sql .= ")";
                                            $sql .= " Union ";
                                            $sql .= " Select f.Id,f.Name,r.IsAllowed from function_master f, role_allocation r ";
                                            $sql .= " Where r.Function_Id=f.Id";
                                            if(isset($_REQUEST['cmbDesignation']) && $_REQUEST['cmbDesignation']<>0)
                                            {
												$sql .= " and r.Designation_Id=" . $_REQUEST['cmbDesignation'];
                                            
                                            //echo $sql;
                                            $fres = mysqli_query($link,$sql);
											/*if(mysqli_num_rows($fres)==0)
											{
												$sql = "Select f.Id,f.Name,false as IsAllowed from function_master f ";
												//$sql .= " Left Join role_allocation r on r.Function_Id=f.Id ";
											
												$fres = mysqli_query($link,$sql);
											
                                            }*/
                                           
											while($frow = mysqli_fetch_array($fres))
											{
												echo '<tr>';
												echo '<td>' . $frow['Name'] . '</td>';
												echo '<td><input type="checkbox" style= "zoom:2"; value="' . $frow['Id'] . '" id="chkIsAllowed" name="chkIsAllowed[]" ';
												
												if($frow['IsAllowed']==true)
												{
													echo ' checked="checked" ';
												}
												else
													echo ' checked!="checked" ';
												echo '>';
												//if($Id<>0 && $row['Isvisible']==1) echo "Checked=checked "; 
												echo '</tr>';
											}
                                            
										?>
										</tbody>
									</table>
								</div>
                                 
                                    <div class="col-lg-offset-4">
										
                                        <button class="btn btn-white" type="RESET">Cancel</button>
                                        <button class="btn btn-primary" type="submit" name="btnSubmit" id="btnSubmit">Save</button>
                                    </div>
                                </div>
								<?php 
                                       }
											else
                                            {
                                                $sql .= " and r.Designation_Id=0";
                                            }  
								/*		
								else
								{
									$sql .= " and r.Designation_Id=0";
								}*/
								?>
							 
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
