<?php
ob_start();
session_start();

if (!$_SESSION['username']) {
   
   header("Location: index.php");
   
}
$Role = $_SESSION['Role'];
$message="";
include("config.php");
if(isset($_GET['did']))
{
	if($Role <> 'Admin')
		$message = "You are not authorized to delete the course";
	else
	{
	$sql = "delete from standard_master where id=" . $_GET['did'];
	$res = mysqli_query($link,$sql);
	if($res)
		$message = "Standard deleted successfully";
	else
		$message = "Error while deleting Standard";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Admin Panel</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />
	
	<link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Morris Chart Css-->
    <link href="plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
	
	<!-- CSS for Dropdown -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/css/bootstrap-select.min.css">
   
	

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-red">
   
    <?php include("left_panel.php"); ?>

 <section class="content">
 <div class="container-fluid">
            <div class="block-header">
             </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Standard List
                            </h2>
                            <ul class="header-dropdown m-r--5" style="padding-bottom:10px">
                           <a href="insert_standard.php">  <button type="button" class="btn bg-cyan btn-block btn-lg waves-effect">ADD</button></a>
                            </ul>
                        </div>
                        <div class="body">
                        	<?php echo $message; ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Standard Name</th>
                                             <th>Course Name</th>
                                              <th>Mediaum Name</th>
                                            <?php 
												if($Role == 'Admin')
												{
													echo '<th>Edit</th>
													<th>Delete</th>';
												}
											?>
                                         
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            
                                           <th>Standard Name</th>
                                             <th>Course Name</th>
                                              <th>Mediaum Name</th>
                                            <?php 
												if($Role == 'Admin')
												{
													echo '<th>Edit</th>
													<th>Delete</th>';
												}
											?>
                                        </tr>
                                    </tfoot>
                                    			<?php
								 include('./config.php');	
                              					 $sql = "select * from standard_master";
								 $sql4="SELECT s.*,r.course_name,m.medium_name from standard_master s,course_master r,medium_master m";
									$sql4 = $sql4 . " WHERE s.course_id =r.id " ;
									$sql4 = $sql4 . " and s.medium_id = m.id " ;
									
									//echo $sql4;
									$results = $link->query($sql4);
	                           					echo '<tbody>';
									while($row = $results->fetch_array()) {
									     echo '<tr>';
				                                             //echo '<td>'.$row ['id'].'</td>';
				                                             echo '<td>'.$row ['std_name'].'</td>';
									     echo '<td>' .$row['course_name'].'</td>';
									     echo '<td>' .$row['medium_name'].'</td>';	
										 if($Role == 'Admin')
											 {					
									     echo '<td><a href=insert_standard.php?id=' . $row['id'].'&op_id=2> <img src="images/file_edit.png" height="15" width="15" /></a></td>';
                                            echo '<td><a href="#" onclick="ConfirmDelete(' . $row['id'] . ')"><img src="images/delete.png" height="15" width="15" /></a></td>';
											 }
                                            echo'</tr>';
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
</section>
<script>
function ConfirmDelete(id)
{
  if(confirm("Are you sure you want to delete?")==true)
  {
	  window.location="standard_list.php?did=" + id;
  }
}
</script>
</script>
  <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>
	
	    <!-- Jquery CountTo Plugin Js -->
    <script src="plugins/jquery-countto/jquery.countTo.js"></script>
	
    <!-- Jquery DataTable Plugin Js -->
    <script src="plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/tables/jquery-datatable.js"></script>
	<script src="js/pages/index.js"></script>

	<!-- Dropdown Js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js"></script>
	 

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
</body>
</html>