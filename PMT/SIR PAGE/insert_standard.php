<?php

//ob_start();
session_start();
if (!$_SESSION['username']) {
   
   header("Location: index.php");
   
}
$Role = $_SESSION['Role'];
$LoginId = $_SESSION['LoginId'];
$msg="";
$id=0;
if (!$_SESSION['username']) {
   
   header("Location: index.php");
   
}
include("./config.php");
	if(isset($_POST['btnsubmit']))
	{
		$stdname = $_POST['txtStandard'];
		$course = $_POST['cmbCourse'];
		$medium = $_POST['cmbMedium'];
		$hdnId=$_POST['hdnId'];
		$error=0;
		if($course==0 or $medium==0 or $stdname=="")
		{
			$msg="Plese specify all the required fields.";
			$error=1;
		}
		if($error==0)
		{
			if($hdnId==0)
			{
				$sql="Select count(*) from standard_master where course_id=" . $course;
				$sql = $sql . " and medium_id=" . $medium;
				$sql = $sql . " and std_name='" . $stdname . "'";
				$res = mysqli_query($link,$sql);
				$row = mysqli_fetch_array($res);
				if($row[0]>=1)
				{
					$msg = "Standard already available for given Course & Medium." . $row[0] . $sql;
					$error=1;
				}
				$sql = "insert into standard_master(std_name,course_id,medium_id,login_id) ";
				$sql .= " Values ('$stdname',$course,$medium,$LoginId)";
			}
			else
			{
				$sql="Select count(*) from standard_master where course_id=" . $course;
				$sql = $sql . " and medium_id=" . $medium;
				$sql = $sql . " and std_name='" . $stdname . "'";
				$sql = $sql . " and id<>" . $hdnId;
				$res = mysqli_query($link,$sql);
				$row = mysqli_fetch_array($res);
				if($row[0]>=1)
				{
					$msg = "Standard already available for given Course & Medium." . $row[0] . $sql;
					$error=1;
				}
				$sql =  "UPDATE standard_master SET std_name='$stdname' ";
				
				$sql = $sql . " , course_id=$course";
				$sql = $sql . " , medium_id=$medium";
				$sql = $sql . " , login_id=$LoginId";
				$sql = $sql . " WHERE id='$hdnId'";
			}
			if($error==0)
			{
				echo $sql;
				$res = mysqli_query($link,$sql);
				if($res)
					$msg="Standard Saved successfully";
				else
				{
					$msg = "Error while inserting starndard. $sql";
					$error=1;
				}
			}
		}
   			//header("Location: standard_list.php");
			
        	//ob_get_clean();

	}
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$sql = "Select * from standard_master where id=" . $id;
		echo $sql;
		$res = mysqli_query($link,$sql);
		$row=mysqli_fetch_array($res);
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
    <script language="javascript" type="text/javascript">
    function ComboClick() {

        document.frmEntry.submit();

    }
	</script>
</head>

<body class="theme-red">
   
    <?php include("left_panel.php"); ?>
	<section class="content">
        <div class="container-fluid">
           <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               Add New Standard
                            </h2>
                          
                        </div>
                        <div class="body">
                            <form  method="POST" name="frmEntry" id="frmEntry" >
                            	<div class="row clearfix">
                                	<div class="col-lg-6 col-md-6 col-sm-4 col-xs-5 form-control-label">
	                                	<?php echo $msg; ?>
                                        <input type="hidden" id="hdnId" name="hdnId" value="<?php echo $id; ?>" >
                                    </div>
                                </div>
                                <div class="row clearfix">
								    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="course">Course</label>
                                    </div>
									<div class="col-lg-5 col-md-5 col-sm-8 col-xs-7">
                                    <select class="selectpicker" name="cmbCourse" onChange="ComboClick();">  
                                    <option value="0">--Select Course--</option>
									 <?php 
                                         $coursename_query = "select id, course_name from course_master";
                                         $res_coursename = $link->query($coursename_query);
                                         $row_cnt_course = $res_coursename->num_rows;
										 $selected=0;
                                         if($row_cnt_course==0){
                                            echo '<option value="no value">No Value</option>';
                                         }
                                         else{
                                            while($row_coursename = $res_coursename->fetch_array()) 
											{
                                               	echo '<option value="'.$row_coursename['id'] . '" ';
												if(isset($_REQUEST['cmbCourse']) && $row_coursename["id"]==$_REQUEST["cmbCourse"]) 
                                                { 
													echo " Selected=selected "; 
													$selected=1;
												} 
												elseif($id<>0 && $row_coursename['id']==$row['course_id'] && $selected==0)
												{ echo " Selected=selected "; }
                                                echo ' >'.$row_coursename['course_name'].'</option>';
	                                         }    
										}
                                     ?>
                                    </select>		
                                    </div>
								</div>
                                <div class="row clearfix">
								    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="medium">Medium</label>
                                    </div>
									<div class="col-lg-5 col-md-5 col-sm-8 col-xs-5">
                                    <select  name="cmbMedium" onChange="ComboClick();">  
                                    <option value="0">--Select Medium--</option>
									 <?php 
									 	if(!(isset($_POST['cmbCourse'])) && $id<>0)
										{
                                         $mediumname_query = "select id, medium_name from medium_master";
										 $mediumname_query .= " Where course_id=" . $row['course_id'];
										}
										else
										{
 										 $mediumname_query = "select id, medium_name from medium_master";
										 $mediumname_query .= " Where course_id=" . $_POST['cmbCourse'];
										}
										 echo $mediumname_query;
                                         $res_mediumname = $link->query($mediumname_query);
                                         $row_cnt_medium = $res_mediumname->num_rows;
										 $selected=0;
                                         if($row_cnt_medium==0){
                                         	//echo '<option value="no value">No Value</option>';
                                         }else{
                                           	while($row_mediumname = $res_mediumname->fetch_array()) {
                                            	echo '<option value="'.$row_mediumname['id'] .'"';
												if(isset($_REQUEST['cmbMedium']) && $row_mediumname["id"]==$_REQUEST["cmbMedium"]) 
                                                { echo " Selected=selected "; 
													$selected=1;
												}
												elseif($id<>0 && $row_mediumname['id']==$row['medium_id'] && $selected==0)
												{ echo " Selected=selected "; } 
                                            	echo ' >'.$row_mediumname['medium_name'].'</option>';
											}
										 }
                                 	 ?>
									
                                    </select>		
                                    </div>
								</div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="course_name">Standard</label>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                            	<input type="text"  class="form-control" id="txtStandard" name="txtStandard" placeholder="Enter your Standard Name" value="<?php if($id<>0) echo $row['std_name']; ?>" >
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                               
                                <div class="row clearfix">
                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                        <button type="submit" class="btn  bg-cyan m-t-15 waves-effect" name="btnsubmit" value="btnsubmit">ADD</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
		</div>

	</section>
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