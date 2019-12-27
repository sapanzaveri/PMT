<?php
include("config.php");
$sql="Select t.*, s.Name as sname, d.Name as desi, p.Name as pname ";
	$sql .="  from team t, staff_master s, designation_master d,";
	$sql .=" project_master p";

	//$sql .=" and t.Status_Id=sm.Id";
	$sql .=" Where  t.Staff_Id=s.Id ";
	$sql .="and t.Project_Id=p.Id ";
	$sql .="and t.Designation_Id=d.Id ";

$res = mysqli_query($link,$sql);
$row = mysqli_fetch_array($res);
				
?>


<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Project Report </title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-flash-1.5.1/b-html5-1.5.1/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-flash-1.5.1/b-html5-1.5.1/datatables.min.js"></script>


<body>
    <div id="wrapper">
      <div id="right-sidebar">
            <div class="sidebar-container">
 				
		 </div>
		</div>
   
    
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
						<form method="post" action="projectteamreportPrint.php">
                           <h5 align="center">Project Report</h5>
						 <INPUT TYPE="button" id="button" onClick="printpage()" class="col-lg-offset-9 btn btn-primary" value="Print"/>
                         <INPUT TYPE="button" id="button"  onclick="exportTableToCSV('AllprojectReport.csv')" name="Excel" class=" btn btn-primary" value="Excel"/>
                          
                    <div class="ibox-content">
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover display">
                    <?php
                        $sql = "select * from project_master";
                        $res = mysqli_query($link,$sql);
                        while($row=mysqli_fetch_array($res))
                        {
                    echo '<thead>
                    <tr>
                        <th colspan="3" style="text-align: center">Project Name</th>
                    </tr>';
                            echo '<tr >';
                            echo '<td colspan="3" style="text-align: center">' . $row['Name'] . '</td>';
                            echo '</tr>';
                            $sql="Select t.*,d.name as Desi, s.Name as sname from team t,designation_master d, staff_master s ";
                            $sql .= " where t.Project_Id=" . $row['Id'];
                            $sql .= " and t.Designation_id=d.Id ";
                            $sql .= " and t.Staff_Id = s.Id";
                            $tres = mysqli_query($link,$sql);
                    echo '<tr>
                        <th>Team Member </th>
                     	<th>Designation</th>
                    </tr>
                    </thead>
                    <tbody>';
                            while($trow = mysqli_fetch_array($tres))
                            {
                                echo '<tr >';
							echo '<td>' . $trow['sname'] . '</td>';
                            echo '<td>' . $trow['Desi'] . '</td>';
                            echo '</tr>';
                            }
                        echo '</tbody>';
                        }
                    		
					?>
                    	</table>
					
						</div>
					</div>
					</div>
                    </form>
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
     <script>
    function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}
         function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}
    </script>
  
</body>

<!-- Mirrored from webapplayers.com/inspinia_admin-v2.7.1/dashboard_5.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2017 12:21:52 GMT -->
</html>
