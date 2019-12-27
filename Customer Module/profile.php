<?php
session_start();
	if(!isset($_SESSION['UN']) || $_SESSION['UN'] == "")
	{
		header("Location:../index.php");
	}
	include("config.php");

	$Name="";
	$Email="";
	$Contact="";
	$SkypeId="";
    $Address="";
						$sql = "Select * from customer_master c";
						$sql .= " where Id=" .$_SESSION['UN'];
						
						$res = mysqli_query($link,$sql);
						while($row = mysqli_fetch_array($res))
						{
							
							$Name = '<td>' . $row['Name'] . '</td>';
							$Email = '<td>' . $row['Email'] . '</td>';
                          
						
						
							
													}
							
					?>
          





<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profile Details</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
   <?php include('sidebar.php');
		include("config.php");?>
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
						
                   
                </div>

		   </div>
                 

           
                        <div class="col-md-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Profile Detail</h5>
                        </div>
                        <div>
                            
                            <div class="ibox-content profile-content">
                              
                               <div class="ibox-content no-padding border-left-right col-md-5">
                                <img alt="image" class="img-responsive" src="img/p1.jpg" height="350" width="430">
                            </div> 
								
								
								
                                    <div class="col-md-4">
                                        <h5><span class="bar"> Name </span></h5>
                                        <h4><strong><?php echo $Name;?></strong> </h4>
                                    </div>
                                    
                                <div class="row m-t-lg">
                                    <div class="col-md-4">
                                        <h5><span class="bar">E-Mail</span></h5>
                                        <h4><strong><?php echo $Email;?></strong> </h4>
                                    </div>
                                    
									
									
								
                            
                    </div>
                </div>
                    
					
                        
                        
                    
                 
                 
          
                  	</tbody>
					</table>
					<a href="Dashboard.php"> <button class="btn btn-primary col-lg-offset-10" type="submit" name="btnSubmit" id="btnSubmit" >Back To Home</button></a>
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
