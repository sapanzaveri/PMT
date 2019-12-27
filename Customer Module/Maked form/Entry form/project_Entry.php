<?php
	session_start();
	if(!isset($_SESSION['UName']) || $_SESSION['UName'] == "")
	{
		header("Location:index.php");
	}
	include("config.php");
	$message="";
	$Id =0;
	if(isset($_POST['btnSubmit']))
	{
		
		$Name=($_POST['txt_name']);
		$description=($_POST['txt_des']);
		$Sdate=($_POST['txt_sdate']);
		$ddate=($_POST['txt_ddate']);
		$hdnId = $_POST['hdnId'];
		if($hdnId==0)
		{
		$sql = "INSERT INTO `project_master`(`Name`, `Description`, `Start_Date`, `Due_Date`) VALUES('$Name','$description','$Sdate','$ddate')";
		}
		else
		{
			$sql="Update project_master set";
			$sql .= " Name='$Name', ";
			$sql .= " Description='$description', ";
			$sql .= " Start_Date='$Sdate', ";
			$sql .= " Due_Date='$ddate' ";
			$sql .= " Where Id=" . $hdnId;
		}
		$resultset=mysqli_query($link,$sql);
		if($resultset)
		{
		$message = "Successful data insert";
		}
		else 
		{
		$message = "Not successfull data insert" .$sql;
		}
	}
		if(isset($_GET['Pid']))
		{
		$Id = $_GET['Pid'];
		$sql = "SElect * from project_master where Id=" . $Id;
		$res=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($res);
		}

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>project Entry</title>

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
						<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>PROJECT ENTRY FORM</h5>
                            
                        <div class="ibox-content">
                            <form method="post" class="form-horizontal" action="project_Entry.php">
                               <?php echo $message; ?>
                              		  <input type="hidden" name="hdnId" id="hdnId" value="<?php echo $Id; ?>">
                               		<div class="form-group"><label class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-6"><input type="text" class="form-control" id="txt_name" name="txt_name" placeholder="Enter Name" required="" value="<?php if($Id<>0) echo $row['Name']; ?>"></div>
                                	</div>
                               		<div class="form-group"><label class="col-sm-2 control-label">Description</label>

                                    <div class="col-sm-6"><input type="text" class="form-control" id="txt_des" name="txt_des" placeholder="Enter Description" required="" value="<?php if($Id<>0) echo $row['Description']; ?>"></div>
                                	</div>
                                	<div class="form-group"><label class="col-sm-2 control-label">Start_Date</label>

                                    <div class="col-sm-6"><input type="date" class="form-control" id="txt_sdate" name="txt_sdate" placeholder="Enter Start_Date" Required="" value="<?php if($Id<>0) echo $row['Start_Date']; ?>"></div>
                               		</div>
                                 	<div class="form-group"><label class="col-sm-2 control-label">Due_Date</label>

                                    <div class="col-sm-6"><input type="Date" class="form-control" id="txt_ddate" name="txt_ddate" placeholder="Enter Due Date" Required="" value="<?php if($Id<>0) echo $row['Due_Date']; ?>">
                                    </div>
                                	</div>
   
                               			<div class="hr-line-dashed"></div>
                               			<div class="form-group">
                                    	<div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white" type="submit">Cancel</button>
                                        <button class="btn btn-primary" type="submit" name="btnSubmit" id="btnSubmit">Save</button>
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
