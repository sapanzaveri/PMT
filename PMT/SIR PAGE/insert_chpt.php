<?php
session_start();

if (!$_SESSION['username']) {
   
   header("Location: index.php");
   
}
$Role = $_SESSION['Role'];
$LoginId = $_SESSION['LoginId'];
include("./config.php");
$id=0;
$msg="";
function getExtension($str) 
	{
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 	}
$message="";
$chpt_name = "";
$stdname =  "";
$coursename =  "";
$mediumname =  "";
$sub_name  =  "";
if(isset($_POST['btnsubmit'])){
			$error=0;
			$hdnId=$_POST['hdnId'];
			$chpt_name = $_POST['chpt_name'];
			$chptimge = $_FILES['fuImage']['name'];
			$stdname = $_POST['cmbStandard'];
			$coursename = $_POST['cmbCourse'];
			$mediumname = $_POST['cmbMedium'];
			$sub_name  = $_POST['cmbSubject'];
			$chpt_no= $_POST['txtChpt_No'];
			$lang = $_POST['cmbLang'];
			$newname="";
			$theData = "";
			$image = $_FILES['fuImage']['tmp_name'];
			//print_r($image);
			if($image <>'')
			{
				 $filename = stripslashes($_FILES['fuImage']['name']);
				 $extension = getExtension($filename);
				 $extension = strtolower($extension);
				if (($extension <> "jpg") && ($extension <> "jpeg") && ($extension <> "png") && ($extension <> "gif")) 
				{
					$message = 'Unknown extension!';
				}
				else
				{
					$myFile = 'images/filename.txt';
					$fh = fopen($myFile, 'r');
					$theData = fread($fh,5);
					fclose($fh);
					
					 $newname = "images/" . $theData . '.' . $extension;
				
				}
			}
			if($hdnId==0)
			{
				$sql = "Select count(*) from chpt_master ";
				$sql = " where (chpt_name='$chpt_name' or chpt_no=$chpt_no) ";
				$sql = $sql . " and std_id=$stdname ";
				$sql = $sql . " and course_id=$coursename ";
				$sql = $sql . " and medium_id=$mediumname ";
				$sql = $sql . " and sub_id=$sub_name ";
				$res = mysqli_query($link,$sql);
				$trow= mysqli_fetch_array($res);
				if($trow[0]>=1)
				{
					$msg="Chapter name/no already set for given subject";
					$error=1;
				}
				$sql = "insert into chpt_master(chpt_name,chpt_imge,std_id,course_id,medium_id, sub_id, chpt_no, language, login_id) ";
				$sql=$sql . "Values ('$chpt_name', '$newname', '$stdname', '$coursename', '$mediumname',";
				$sql = $sql . " '$sub_name',$chpt_no, '$lang',$LoginId)";
			}
			else
			{
				$sql = "Select count(*) from chpt_master ";
				$sql = " where (chpt_name='$chpt_name' or chpt_no=$chpt_no) ";
				$sql = $sql . " and std_id=$stdname ";
				$sql = $sql . " and course_id=$coursename ";
				$sql = $sql . " and medium_id=$mediumname ";
				$sql = $sql . " and sub_id=$sub_name ";
				$sql = $sql . " and id<>" . $hdnId;
				$res = mysqli_query($link,$sql);
				$trow= mysqli_fetch_array($res);
				if($trow[0]>=1)
				{
					$msg="Chapter name/no already set for given subject";
					$error=1;
				}
				$sql = "Update chpt_master set chpt_name='$chpt_name', ";
				$sql = $sql . " chpt_imge='$newname',";
				$sql = $sql . " std_id='$stdname',";
				$sql = $sql . " course_id='$coursename',";
				$sql = $sql . " medium_id='$mediumname',";
				$sql = $sql . " sub_id='$sub_name',";
				$sql = $sql . " chpt_no='$chpt_no',";
				$sql = $sql . " login_id=$LoginId, ";
				$sql = $sql . " language='$lang' ";
				$sql = $sql . " Where id=" . $hdnId;
			}
			if($error==0)
			{
			//echo $sql;
				if(mysqli_query($link,$sql))
				{
					$message	= $message .	"Record Saved Successfully";
					if($_FILES['fuImage']['name']>'')
					{
						$message = $message . //";In if;";
					 $copied = copy($_FILES['fuImage']['tmp_name'], $newname);
												
						if ($copied)
						{
							$message = $message . //"Coppied done;";
							$fh = fopen($myFile, 'w') or die("cant open file");
							fwrite($fh, $theData + 1);
							fclose($fh);
							
						}
						else
							$message = 'Error while saving Image.';
					}
				}
				else
				{
					$message	=	"Error while Saving Record";
				}
			}
				
		//	header("Location: chpt_list.php?sql=" . $sql . ";theData=" . $theData . ";Newname=" . $newname . ";Message=" . $message);
}
if(isset($_GET['id']))
{
	$id=$_GET['id'];
		$sql = "Select * from chpt_master where id=" . $id;
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
                               Add New Chapter
                            </h2>
                          
                        </div>
                        <div class="body">
                        <?php echo $message ;?>
                            <form  method="POST" enctype="multipart/form-data" name="frmEntry" id="frmEntry" >
                            <div class="row clearfix">
                                	<div class="col-lg-6 col-md-6 col-sm-4 col-xs-5 form-control-label">
	                                	<?php echo $msg; ?>
                                        <input type="hidden" id="hdnId" name="hdnId" value="<?php echo $id; ?>" >
                                    </div>
                                </div>
								<!--  use class  selectpicker for every dropdown -->
                                
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
									 	$selected=0;
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
                                         if($row_cnt_medium==0){
                                         	//echo '<option value="no value">No Value</option>';
                                         }else{
                                           	while($row_mediumname = $res_mediumname->fetch_array()) {
                                            	echo '<option value="'.$row_mediumname['id'] .'"';
												if(isset($_REQUEST['cmbMedium']) && $row_mediumname["id"]==$_REQUEST["cmbMedium"]) 
                                                { 
													echo " Selected=selected "; 
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
                                        <label for="standard">Standard</label>
                                    </div>
									<div class="col-lg-5 col-md-5 col-sm-8 col-xs-7">
                                    <select class="selectpicker" name="cmbStandard"  onChange="ComboClick();">
                                    <option value="0">--Select Standard--</option>  
									     <?php 
											if(!(isset($_POST['cmbMedium'])) && $id<>0)
											{
                                         		$sql = "select id, std_name from standard_master ";
											 	$sql .= " where course_id=" . $row['course_id'];
											 	$sql .= " and medium_id=" . $row['medium_id'];
											}
											else
											{
 											 $sql = "select id, std_name from standard_master ";
											 $sql .= " where course_id=" . $_REQUEST['cmbCourse'];
											 $sql .= " and medium_id=" . $_REQUEST['cmbMedium'];
											}
									         
											 echo $sql;
	                                         $res_stdname = $link->query($sql);
											 $row_cnt_std = $res_stdname->num_rows;
											 $selected=0;
										   	 if( $row_cnt_std==0){
										      }
											 else{
												while($row_stdname = $res_stdname->fetch_array()) 
												{
									 				echo '<option value="'.$row_stdname['id'] . '" ';
													if(isset($_REQUEST['cmbStandard']) && $row_stdname["id"]==$_REQUEST["cmbStandard"]) 
                                                { 
													echo " Selected=selected "; 
													$selected=1;
												} 
												elseif($id<>0 && $row_stdname['id']==$row['std_id'] && $selected==0)
												{ echo " Selected=selected "; }
                                                echo ' >'.$row_stdname['std_name'].'</option>';                                            
											 }									   }
									      ?>
									
                                    </select>		
                                    </div>
								</div>
								<div class="row clearfix">
								    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="subject">Subject</label>
                                    </div>
									<div class="col-lg-5 col-md-5 col-sm-8 col-xs-7">
                                    <select class="selectpicker" name="cmbSubject"  >  
                                    <option value="0">--Select Subject--</option>
									     <?php 
										 	if(!isset($_REQUEST['cmbStandard']) && $id<>0)
											{
									         $sql = "select id, sub_name from subject_master";
											 $sql .= " Where std_id=" . $row['std_id'];
											 $sql .= " and course_id=" . $row['course_id'];
											 $sql .= " and medium_id=" . $row['medium_id'];
											}
											else
											{
									         $sql = "select id, sub_name from subject_master";
											 $sql .= " Where std_id=" . $_REQUEST['cmbStandard'];
											 $sql .= " and course_id=" . $_REQUEST['cmbCourse'];
											 $sql .= " and medium_id=" . $_REQUEST['cmbMedium'];
											}
											$selected=0;
											 $res_sub_name = $link->query($sql);
									         
											    $row_cnt_subject = $res_sub_name->num_rows;
										   if($row_cnt_subject==0){
											   
										   }else{
											   
											   while($row_sub_name = $res_sub_name->fetch_array()) {
												   echo '<option value="'.$row_sub_name['id'].'" ';
												   if(isset($_REQUEST['cmbSubject']) && $row_sub_name["id"]==$_REQUEST["cmbSubject"]) 
                                                	{ 
													echo " Selected=selected "; 
													$selected=1;
													} 
												elseif($id<>0 && $row_sub_name['id']==$row['sub_id'] && $selected==0)
												{ echo " Selected=selected "; }
											   echo '>'.$row_sub_name['sub_name'].'</option>';
									                                                           
												  }
											   
										   }
									 
									      ?>
									
                                    </select>		
                                    </div>
								</div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="subject">Language</label>
                                    </div>
									<div class="col-lg-5 col-md-5 col-sm-8 col-xs-7">
                                    	<select class="selectpicker" name="cmbLang"  >
                                        <option value="English" <?php if($id<>0 && $row['language']=='English') echo 'Selected=selected'; ?> >English</option>
                                        <option value="Hindi" <?php if($id<>0 && $row['language']=='Hindi') echo 'Selected=selected'; ?> >Hindi</option>
                                        <option value="Gujarati" <?php if($id<>0 && $row['language']=='Gujarati') echo 'Selected=selected'; ?> >Gujarati</option>
                                        <option value="Sanskrit" <?php if($id<>0 && $row['language']=='Sanskrit') echo 'Selected=selected'; ?> >Sanskrit</option>
                                        </select>
                                   	</div>
                                </div>
								<div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="chpt_name">Chapter No</label>
                                    </div>
                                    <div class="col-lg-10 col-md-5 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text"  class="form-control" name="txtChpt_No" id="txtChpt_No" placeholder="Enter your Chapeter No" value="<?php if($id<>0) echo $row['chpt_no']; ?>" required >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="chpt_name">Chapter Name</label>
                                    </div>
                                    <div class="col-lg-10 col-md-5 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea  name="chpt_name" id="chpt_name" class="ckeditor"><?php if($id<>0) echo $row['chpt_name']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
								
								<div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="fuImage">Chapter Image</label>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="file"  class="form-control" name="fuImage" id="fuImage" placeholder="Enter Chapter Image" onChange="readURL(this);">
                                                <img id="blah" src="#" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
								<!--  use class  selectpicker for every dropdown -->
								
								<div class="row clearfix">
                                    <div>
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
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript">

function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(50)
                        .height(50)
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

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