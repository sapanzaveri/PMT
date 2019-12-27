<?php 
session_start();
	if(!isset($_SESSION['UN']) || $_SESSION['UN'] == "")
	{
		header("Location:Login.php");
	}
$Id=0;
include("config.php");
if(isset($_REQUEST['btnSubmit']))
{
		//$con=mysqli_connect('localhost','root','','project_management_tool');
		$Title = ($_POST['txt_title']);
		$des = ($_POST['txt_des']);
		$Estimation = ($_POST['Estimation']);
        $Closing_Date = ($_POST['dt_closingdate']);
        if(isset($_POST['ios']))
            $TP = ($_POST['ios']);
        if(isset($_POST['Android']))
            $TP .=  ", " . $_POST['Android'];
        if(isset($_POST['Window'] ))
            $TP .=  ", " . $_POST['Window'];
        if(isset($_POST['Website']))
            $TP .=  ", " . $_POST['Website'];
		$ET = ($_POST['txt_essi']);
        if(isset($_POST['txt_IsUrgent']) && $_POST['txt_IsUrgent'] == 'True')
		   $IsUrgent='1';
		else	
		   $IsUrgent='0';
         if(isset($_POST['txt_IsActive']) && $_POST['txt_IsActive'] == 'True')
		   $IsActive='1';
		else	
		   $IsActive='0';
		$hdnId = $_POST['hdnId'];

		
		if($hdnId==0)
		{
		$sql = "INSERT INTO `rfp`(`Title`, `Description`,`Estimation`, `Estimated_Time`, `Type_Project`, `Customer_Id`,`IsUrgent`, `IsActive`, `Start_Date`, `Closing_Date`) VALUES ('$Title','$des','$Estimation','$ET', '$TP'," . $_SESSION['UN']. ",$IsUrgent,$IsActive,".date('y-m-d').",'$Closing_Date')";

		}
		else
		{
			$sql ="Select Start_Date from rfp where Id=" . $hdnId;
			$sres=mysqli_query($link,$sql);
			$srow = mysqli_fetch_array($sres);
		 	$sql="Update rfp set";
			$sql .= " Title='$Title', ";
			$sql .= " Description='$des', ";
			$sql .= " Estimation='$Estimation', ";
            $sql .= " Estimated_Time='$ET', ";
            $sql .= " Type_Project='$TP', ";
            $sql .= " Customer_Id='".$_SESSION['UN']."', ";
			$sql .= " IsUrgent=$IsUrgent, ";
            $sql .= " IsActive=$IsActive, ";
			$sql .= " Start_Date='".$srow['Start_Date']."', ";
            $sql .= " Closing_Date='$Closing_Date' ";
			$sql .= " Where Id=" . $hdnId;
            $redirect ='RFP_list.php';
		}
		$resultset=mysqli_query($link,$sql);
		if($resultset)
		{
		?>
		<script type="text/javascript">
			alert("RFP Send Successfully");
			window.location.href="RFP.php";
</script>
<?php	
		header('Location: '.$redirect);
		}
		else 
		{
		?>
		<script type="text/javascript">
			alert("RFP Already Exist");
			window.location.href="RFP.php";
</script>
<?php	 

		}
	}
if(isset($_GET['cid']))
	{
		$Id = $_GET['cid'];
		$sql = "SElect * from rfp where Id=" . $Id;
		$res=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($res);
	}
?>

<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Request For Purposal</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

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
                       
                        
							
							 	
                                </div>
                           
                        </div>
						   
						   <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Request For Proposal</h5>
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
                    
 						 <form method="post" class="form-horizontal" action="RFP.php">
                        
                              
                               <input type="hidden" name="hdnId" id="hdnId" value="<?php echo $Id; ?>">
                                <div class="form-group"><label class="col-sm-2 control-label">Title</label>

                                    <div class="col-sm-5"><input type="text" class="form-control" id="txt_title" name="txt_title" placeholder="Enter Title"  required oninvalid="this.setCustomValidity('Enter Proper Title ')"  onchange="this.setCustomValidity('')"
                                    pattern="[a-z A-Z]+" value="<?php if($Id<>0) echo $row['Title']; ?>" ></div>
                                </div>
                                 <div class="form-group"><label class="col-sm-2 control-label">Description</label> 
                                        <div class="col-sm-5"><TextArea type="text" class="form-control" id="txt_des" name="txt_des" placeholder="Enter Description"><?php if($Id<>0) echo $row['Description']; ?></TextArea></div>
                                

                                          </div>
                             <div class="form-group"><label class="col-sm-2 control-label">Type Of Project</label>
                                 <div class="col-sm-5">  <input type="checkbox" name="ios" <?php
																if($Id<>0 && strpos($row['Type_Project'],'ios') !== false)
																	echo ' checked ';
																?> value="ios" >ios &nbsp; &nbsp;
                                  <input type="checkbox" name="Android" <?php
																if($Id<>0 && strpos($row['Type_Project'],'Android') !== false)
																	echo ' checked ';
																?> value="Android" > Android &nbsp; &nbsp;
                                   <input type="checkbox" name="Window" <?php
																if($Id<>0 && strpos($row['Type_Project'],'Window') !== false)
																	echo ' checked ';
																?>value="Window" > Window &nbsp; &nbsp;
                                     <input type="checkbox" name="Website"<?php
																if($Id<>0 && strpos($row['Type_Project'],'Website') !== false)
																	echo ' checked ';
																?> value="Website" > Website &nbsp; &nbsp;
                                                                     </div>
                             </div>
                             <div class="form-group"><label class="col-sm-2 control-label">Estimation</label>
                                 <div class="col-sm-5"> <input type="radio" name="Estimation" <?php
																if($Id<>0 && strpos($row['Estimation'],'Separte') !== false)
																	echo ' checked ';
																?> value="Separte" checked>Separte &nbsp;
  									<input type="radio" name="Estimation"  <?php
																if($Id<>0 && strpos($row['Estimation'],'Combine') !== false)
																	echo ' checked ';
																?>value="Combine"> Combine &nbsp;
                                 <input type="radio" name="Estimation"  <?php
																if($Id<>0 && strpos($row['Estimation'],'Both') !== false)
																	echo ' checked ';
																?>value="Both"> Both </div>
                             </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Essimated Duration</label>

                                    <div class="col-sm-5"><input type="text" class="form-control" id="txt_essi" name="txt_essi" placeholder="Enter Duration"  value="<?php if($Id<>0) echo $row['Estimated_Time']; ?>" 
                                    ></div>
                                </div>
                                
                                 <div class="form-group"><label class="col-sm-2 control-label">Closing Date</label>

                                    <div class="col-sm-5"><input type="date" class="form-control" id="dt_closingdate" name="dt_closingdate" placeholder="Enter Duration"  value="<?php if($Id<>0) echo $row['Closing_Date']; ?>" onBlur="compare();"  ></div>
                                </div>    
                                <div class="form-group"><label class="col-sm-2 control-label">IsUrgent</label>

                                    <div class="col-sm-1"><input type="checkbox" class="form-control"  value="True" id="txt_IsUrgent" name="txt_IsUrgent" placeholder="Enter Remark" <?php if($Id<>0 && $row['IsUrgent']==1) echo "Checked=checked "; ?> >
                                   
                                       </div>
                                	</div>
                                     <div class="form-group"><label class="col-sm-2 control-label">IsActive</label>

                                    <div class="col-sm-1"><input type="checkbox" class="form-control"  value="True" id="txt_IsActive" name="txt_IsActive" placeholder="Enter Remark" <?php if($Id<>0 && $row['IsActive']==1) echo "Checked=checked "; ?> >
                                   
                                       </div>
                                	</div>
                                <div class="hr-line-dashed"></div>
                               <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white" type="RESET">Cancel</button>
                                       <a href="Task.php">
                                         <button class="btn btn-primary" type="submit" name="btnSubmit" id="btnSubmit">Save</button>
										</a>
                                    </div>
                                </div>
                                </div>
                            </form>
							 
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
    <script type="text/javascript">
	
		function compare()

{	
	
	if (document.getElementById("dt_closingdate").value)
		{
			
   
    if( (new Date() >= new Date(document.getElementById("dt_closingdate").value)))
			
    {
		//var form = document.getElementById("txt_ddate");
		//for.reset();
		
		alert("Start date should not be less than End date");
		document.getElementById("dt_closingdate").value='';
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
