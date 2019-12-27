<?php
include("config.php");
$Id=0;
if(isset($_GET['pid']))
{
	$Id = $_GET['pid'];
	$sql = "Select cb.*, r.Title from company_bid cb, rfp r"; 
    $sql .=" where cb.Id=".$Id;
    $sql .=" and cb.rfp_Id=r.Id";
    
	$res=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($res);
}
		
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Proposal Estimation </title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
  
       
       
      
     <div id="right-sidebar">
            <div class="sidebar-container">
 				
		 </div>
		</div>
       <div class="wrapper wrapper-content animated fadeIn">

                <div class="p-w-md m-t-sm">
                      <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Proposal Estimation</h5>
                            
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal">
                         
                              <div class="form-group"><label class="col-lg-offset-5 control-label">Proposal Title</label>
                                </div>
                                <div class="form-group"><label class="col-lg-offset-5 control-label"><label><?php echo $row['Title'];?></label>
                                </div>
                                 <div class="form-group"><label class="col-sm-2 control-label">Proposal Date:</label>
									<label>02/02/2018</label>
                                    <div class="col-sm-10"><label ></label></div>
                                </div>
                                 <div class="form-group"><label class="col-sm-2 control-label">Estimate Date:</label>
									<label>06/02/2019</label>
                                    <div class="col-sm-10"><label ></label></div>
                                </div>
                                    <?php 
                                    $total = 0;
                                     $sql = "select * from bid_estimation";
                                
                                        $res = mysqli_query($link,$sql);
                                    while($row=mysqli_fetch_array($res)) 
                                   
                        {        
                          echo '<div class="table-responsive col-lg-offset-1">
                        <table class="table table-striped table-bordered table-hover display ">
                        <thead>
                        <tr>';
                        echo '<th colspan="2"> Type: '  .$row['Type_Of_Project']. '</th>';  
                       echo '</tr>
                         </thead>
                        <tbody>
                       <tr>';
                       echo '<td>' .$row['Module']. '</td>';
                       echo '<td>' .$row['Cost']. '</td>';
                       echo '</tr>
                        </tbody>
                                      </table>
                        </div>';
                                    $total = $total + $row['Cost'] ;
                                    }?>
                            
                                <div class="form-group"><label class="col-sm-2 control-label">Combined Total:</label>

                                    <div class="col-sm-10"><label  class="col-sm-2 control-label"  ><?php echo $total; ?></label></div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label"></label>

                                    <div class="col-sm-10"><label ></label></div>
                                </div>
                                <input type="button" id="button" onClick="printpage()" class="col-lg-offset-6 btn btn-primary" value="Print"/>
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
          <script type="text/javascript">
    function printpage() {
        //Get the print button and put it into a variable
        var printButton = document.getElementById("button");
        //Set the print button visibility to 'hidden' 
        printButton.style.visibility = 'hidden';
        //Print the page content
        window.print()
        //Set the print button to 'visible' again 
        //[Delete this line if you want it to stay hidden after printing]
        printButton.style.visibility = 'visible';
    }
    </script>
</body>

<!-- Mirrored from webapplayers.com/inspinia_admin-v2.7.1/dashboard_5.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2017 12:21:52 GMT -->
</html>
