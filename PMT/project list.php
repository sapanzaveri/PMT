<?php
	session_start();
	include("config.php");
	if(!isset($_SESSION['UName']) || $_SESSION['UName'] == "")
	{
		header("Location:index.php");
	}
	$message="";

     include("Role_Prev.php");
    //echo "Flg:" . $FLG_CUSTOMER_Delete . ": flg:" . $FLG_CUSTOMER_VIEW;
    if($FLG_Project_Delete == 0 && $FLG_Project_View == 0 )
    {
        //echo 'step123';
        header("Location:Dashboard.php");
    }

	if(isset($_GET['did']))
	{
		$Id=$_GET['did'];
		$sql = "Delete from project_master where Id=" . $Id;
		$res = mysqli_query($link,$sql);
		if($res)
			{
			?>
		<script type="text/javascript">
			alert("Project Delete Successfully");
			window.location.href="project list.php";
</script>
<?php
		}
		else
			?>
		<script type="text/javascript">
			alert("Project Delete UnSuccessfully");
			window.location.href="project list.php";
</script>
<?php
	}
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Project List</title>

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
   
    
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                  <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Project List</h5>
                <button class="col-lg-offset-9 btn btn-primary" onclick="window.location.href='Project Report.php'">Download Report</button>
                
              
                    </div>
                    <div class="ibox-content">
							<?php echo $message; ?>
                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" id="example" >
                    
                    
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
         				<th width="120">Start Date</th>
                       	<th width="120">Due Date</th>
                        <th>Customer Name </th>
                        <th>Project Type</th>
                        <th>Status</th>
                         <?php    if($FLG_Project_Edit==1 )
                                    echo '<th>Edit</th>';
                            if($FLG_Project_Delete == 1  )
                                    echo '<th>Delete</th>';
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
						$sql = "SElect p.*, c.Name as cus, pt.Name as pro_type, st.Name as sname";
						$sql .=" from project_master p, customer_master c, project_type_master pt,";
						$sql .=" status_master st";
						$sql .=" where p.Customer_Id=c.Id and p.Project_Type=pt.Id";
						$sql .=" and p.Status_Id=st.Id";
						$sql .=" and p.Company_Id=" .$_SESSION['CID'];
						
						$res = mysqli_query($link,$sql);
						while($row = mysqli_fetch_array($res))
						{
							echo '<tr class="gradeX">';
							echo '<td>' . $row['Name'] . '</td>';
							echo '<td>' . $row['Description'] . '</td>';
							echo '<td>' . $row['Start_Date'] . '</td>';
							echo '<td>' . $row['Due_Date'] . '</td>';
							echo '<td>' . $row['cus'] . '</td>';
							echo '<td>' . $row['pro_type'] . '</td>';
							echo '<td>' . $row['sname'] . '</td>';
							if($FLG_Project_Edit==1 )
							echo '<td><a href="project_Entry.php?Pid=' . $row['Id'] . '" ><i class="fa fa-edit" style=font-size:2.5em; ></i></a></td>';	
							if($FLG_Project_Delete==1 )
							echo '<td> <a onclick="javascript:deleteconfig(' . $row['Id'] . ');" ><i class="fa fa-trash"  style=font-size:2.5em;color:red;>  </i></a></td>';
							echo '</tr>';
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
	</div>		
    	<script type="text/javascript">
			
    	function deleteconfig(tmp)
    			{
				var x = confirm("Are you sure you want to delete?");
				if (x==true)
				{
			  	window.location="project list.php?did=" + tmp;
			  	//alert("Record Deleted Sucessful");
				}
         		else
       			{
			  	//alert("Not Record Deleted");
				}
    			}
	</script>
	<script type="text/javascript">
	
	</script>
  
   <!-- code for printng 
 	<script type="text/javascript" src="js/jquery-1.12.4.js"></script>
  	<script type="text/javascript" src="js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script> 
    <script type="text/javascript" src="js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="js/jszip.min.js"></script>
    <script type="text/javascript" src="js/vfs_fonts.js"></script>
    <script type="text/javascript" src="js/buttons.print.min.js"></script>
    <script type="text/javascript" src="js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="js/pdfmake.min.js"></script>
   
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
    $(document).ready(function()  {

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
    
	 <script src="js/plugins/dataTables/datatables.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function()
		{
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: 'lTfgitp',
               
                   // { extend: 'copy'},
                    //{extend: 'csv'},
                    //{extend: 'excel', title: 'ExampleFile'},
                    //{extend: 'pdf', title: 'ExampleFile'},

                     buttons: [
                     {
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>


</body>

<!-- Mirrored from webapplayers.com/inspinia_admin-v2.7.1/dashboard_5.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2017 12:21:52 GMT -->
</html>
