<?php
	session_start();
	if(!isset($_SESSION['UName']) || $_SESSION['UName'] == "")
	{
		header("Location:index.php");
	}
	include("config.php");
	$message="";
     include("Role_Prev.php");
    //echo "Flg:" . $FLG_CUSTOMER_Delete . ": flg:" . $FLG_CUSTOMER_VIEW;
    if($FLG_Staff_Delete == 0 && $FLG_Staff_VIEW == 0 )
    {
        //echo 'step123';
        header("Location:Dashboard.php");
    }

	if(isset($_GET['did']))
	{
		$Id=$_GET['did'];
		$sql = "Delete from staff_master where Id=" . $Id;
		$res = mysqli_query($link,$sql);
		if($res){
			?>
		<script type="text/javascript">
			alert("Staff Delete Successfully");
			window.location.href="Staff_list.php";
</script>
<?php
		}
		else
			?>
		<script type="text/javascript">
			alert("Staff Delete UnSuccessfully");
			window.location.href="Staff_list.php";
</script>
<?php
	}
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Staff list</title>

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
                        <h5>Staff List</h5>
                    
                <button class="col-lg-offset-9 btn btn-primary" onclick="window.location.href='StaffReport.php'">Download Report</button>
                
                    </div>
              
                    <div class="ibox-content">
					<?php echo $message; ?>
                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Skype_id</th>
                        <th>Designation_id</th>
                        <th>Remark</th>
                        <?php    if($FLG_Staff_Edit==1 )
                                    echo '<th>Edit</th>';
                            if($FLG_Staff_Delete == 1  )
                                    echo '<th>Delete</th>';
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
						$sql = "Select s.*, d.Name as desi from staff_master s, designation_master d";
						$sql .= " where s.Designation_Id=d.Id";
						$sql .= " and Company_Id=" .$_SESSION['CID'];
						
						$res = mysqli_query($link,$sql);
						while($row = mysqli_fetch_array($res))
						{
							echo '<tr>';
							echo '<td>' . $row['Name'] . '</td>';
							echo '<td>' . $row['Email'] . '</td>';
							echo '<td>' . $row['Contact'] . '</td>';
							echo '<td>' . $row['Skype_Id'] . '</td>';
							echo '<td>' . $row['desi'] . '</td>';
							echo '<td>' . $row['Remark'] . '</td>';
							if($FLG_Staff_Edit==1 )
							echo '<td><a href="staff_entry.php?sid=' . $row['Id'] . '" ><i class="fa fa-edit "style=font-size:2.5em;></i></a></td>';	
							if($FLG_Staff_Delete==1 )
							echo '<td> <a onclick="javascript:deleteconfig(' . $row['Id'] . ');" ><i class="fa fa-trash" style=font-size:2.5em;color:red;>  </i></a></td>';
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
			  window.location="staff_list.php?did=" + tmp;
			  //alert("Record Deleted Sucessful");
		  }
          
      else
       {
			  //alert("Not Record Deleted");
		 }
    }
</script>
   

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

  <script src="js/plugins/dataTables/datatables.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <script>
        $(document).ready(function()
		{
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: 'lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
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
