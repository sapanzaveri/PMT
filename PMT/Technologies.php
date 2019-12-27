<?php
	session_start();
	if(!isset($_SESSION['UName']) || $_SESSION['UName'] == "")
	{
		header("Location:index.php");
	}
	$message="";
	$Id =0;
	include("config.php");
        include("Role_Prev.php");
    if($_SESSION['Des']<>"Admin")
    {
        header("Location:Dashboard.php");
    }
    
	if(isset($_POST['btnSubmit']))
	{
	
		$Technologies=($_POST['txt_technologies']);
		$Platform=($_POST['txt_Platform']);
		$hdnId = $_POST['hdnId'];
		if($hdnId==0)
		{
		$sql = "INSERT INTO `technologies`(`Technologies`, `Platform`) VALUES ('$Technologies','$Platform')";
		}
		else
		{
			$sql="Update technologies set";
			$sql .= " Technologies='$Technologies', ";
			$sql .= " Platform='$Platform' ";
			$sql .= " Where Id=" . $hdnId;
			$redirect ='Technologies_list.php';
		}
		$resultset=mysqli_query($link,$sql);
		if($resultset)
		{
		?>
		<script type="text/javascript">
			alert("Technologies Saved Successfully");
			window.location.href="Technologies.php";
</script>
<?php	
		header('Location: '.$redirect);
		}
		else 
		{
		?>
		<script type="text/javascript">
			alert("Technologies Already Exist");
			window.location.href="Technologies.php";
</script>
<?php	
			header('Location: '.$redirect);
		}
	
	}

	if(isset($_GET['tid']))
	{
		$Id = $_GET['tid'];
		$sql = "SElect * from technologies where Id=" . $Id;
		$res=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($res);
	}
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Technologies</title>

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
                            <h5>TECHNOLOGIES</h5>
                            
                        <div class="ibox-content">
                            <form method="post" class="form-horizontal" action="Technologies.php">
                              	 <?php echo $message; ?>
                              	 <input type="hidden" name="hdnId" id="hdnId" value="<?php echo $Id; ?>">
			  						
                                   	<div class="form-group"><label class="col-sm-2 control-label">Platform</label>

                                    <div class="col-sm-4"><input type="text" class="form-control" id="txt_Platform" name="txt_Platform" placeholder="Enter Platform" required oninvalid="this.setCustomValidity('Enter Platform Name  ')"  onchange="this.setCustomValidity('')" pattern="[a-z A-Z 0-9]+" value="<?php if($Id<>0) echo $row['Platform']; ?>">
                                    </div>
                                	</div>
                                    	<div class="form-group"><label class="col-sm-2 control-label">Technologies</label>

                                    <div class="col-sm-4"><input type="text" class="form-control" id="txt_technologies" name="txt_technologies" placeholder="Enter Technologies" required oninvalid="this.setCustomValidity('Enter Technology ')"  onchange="this.setCustomValidity('')" value="<?php if($Id<>0) echo $row['Technologies']; ?>">
                                    </div>
                                	</div>
                                 

                                 
   
                                <div class="hr-line-dashed"></div>
                               <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white" type="reset">Cancel</button>
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
