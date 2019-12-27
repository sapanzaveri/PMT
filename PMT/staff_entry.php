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
		function getExtension($str) 
	{
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
	 	}

	if(isset($_POST['btnSubmit']))
	{
		
		$Name=($_POST['txt_name']);
		$Email=($_POST['txt_email']);
		$Phone=($_POST['txt_phone']);
		$Skype=($_POST['txt_skype']);
		$Remark=($_POST['txt_remark']);
		$password=($_POST['password']);
		$degignation=($_POST['desgination']);
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
					echo '<script type="text/javascript">
				alert("Image Formate Don`t match");
				window.location.href="staff_entry.php";
				</script>';
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
		$hdnId = $_POST['hdnId'];
		if($hdnId==0)
		{
		$sql = "INSERT INTO `staff_master` (`Name`, `Contact`, `Email`, `Skype_Id`, `Designation_Id`, `Remark` , `Image`, `Company_Id`, `Password`) VALUES ('$Name','$Phone','$Email','$Skype','$degignation', '$Remark' , '$newname','". $_SESSION['CID']."', '$password')";
		$resultset=mysqli_query($link,$sql);
			$sql = "Select max(Id) as Id from staff_master ";
			$resTmp = mysqli_query($link,$sql);
			$rowTmp = mysqli_fetch_array($resTmp);
			$cb_Id = $rowTmp['Id'];
			$sql = "Select * from staff_master ";
			$resTmp = mysqli_query($link,$sql);
			while($rowTmp = mysqli_fetch_array($resTmp))
			{
		$sql = "INSERT INTO `login_master`(`Username`, `Password`, `IsActive`, `Staff_Id`, `Company_Id`) VALUES (";
		$sql .= " '$Email', '$password', '1', '" . $cb_Id . "', '".$_SESSION['CID']."')";
		mysqli_query($link,$sql);
			}
		}
		else
		{
			
			$sql="Update staff_master set";
			$sql .= " Name='$Name', ";
			$sql .= " Contact='$Phone', ";
			$sql .= " Email='$Email', ";
			$sql .= " Password='$password', ";
			$sql .= " Skype_Id='$Skype', ";
			if($image<>'')
				$sql .= " Image='$newname', ";
			$sql .= " Designation_Id='$degignation', ";
			$sql .= " Company_Id='".$_SESSION['CID'] ."', ";
			$sql .= " Remark='$Remark' ";
			$sql .= " Where Id=" . $hdnId;
        
			$redirect ='Staff_list.php';
			$resultset=mysqli_query($link,$sql);
		}
		
		if($resultset)
		{
			
		echo '
		<script type="text/javascript">
			alert("Staff Saved Successfully");
			window.location.href="staff_entry.php";
</script>';

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
							echo '<script type="text/javascript">
			alert("Image Formate Don`t match");
			window.location.href="staff_entry.php";
</script>';
					}
		header('Location: '.$redirect);
		}
		else 
		{
		?>
		<script type="text/javascript">
			alert("Staff Already Exist");
			window.location.href="staff_entry.php";
</script>

<?php	
		
			//header('Location: '.$redirect);
		}
	}

		if(isset($_GET['sid']))
	{
		$Id = $_GET['sid'];
		$sql = "SElect * from staff_master where Id=" . $Id;
		$res=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($res);
	}
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Staff Entry</title>

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
                            <h5>STAFF ENTRY FORM</h5>
                            
                        <div class="ibox-content">
                            <form method="post" class="form-horizontal" action="staff_entry.php" enctype="multipart/form-data">
                               <?php echo $message; ?>
                               <input type="hidden" name="hdnId" id="hdnId" value="<?php echo $Id; ?>">
                                <div class="form-group"><label class="col-sm-2 control-label"> Name</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" id="txt_name" name="txt_name" placeholder="Enter Name" required oninvalid="this.setCustomValidity('Enter Proper Name ')"  onchange="this.setCustomValidity('')" pattern="[a-z A-Z]+" value="<?php if($Id<>0) echo $row['Name']; ?>"></div>
                                </div>
                                 <div class="form-group"><label class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10"><input type="EMail" class="form-control" id="txt_email" name="txt_email" placeholder="Enter Email"  required="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?php if($Id<>0) echo $row['Email']; ?>"></div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Password</label>

                                    <div class="col-sm-10"><input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" value="<?php if($Id<>0) echo $row['Password']; ?>"></div>
                                	</div>
                                 <div class="form-group"><label class="col-sm-2 control-label">Contact</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" id="txt_phone" name="txt_phone" placeholder="Enter Phone Number" required oninvalid="this.setCustomValidity('Enter proper number  ')"  onchange="this.setCustomValidity('')" pattern="[7-9]{1}[0-9]{9}" value="<?php if($Id<>0) echo $row['Contact']; ?>"></div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Skype ID</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" id="txt_skype" name="txt_skype" placeholder="Enter Skype_Id" value="<?php if($Id<>0) echo $row['Skype_Id']; ?>"></div>
                                	</div>
                                    
                                     <div class="form-group"><label class="col-sm-2 control-label">Designation</label>
									<div class="col-sm-4"><select class="form-control m-b" name="desgination" id="desgination" value="<?php if($Id<>0) echo $row['Designation_Id']; ?>">
                                    <?php
										$sql = "Select Id, Name from designation_master order by Name";
										$dres = mysqli_query($link,$sql);
										while($drow = mysqli_fetch_array($dres))
										{
											echo '<Option value="' . $drow['Id'] . '" ';
											if($Id <>0 && $row['Designation_Id'] == $drow['Id'])
												echo " Selected=selected ";
											echo ' >' . $drow['Name'] . '</option>';
											
										}
									?>
                                    </select>	
										</div></div>
                         <div class="form-group"> 
                            <label class="col-md-2 control-label"> Image </label>
                                          <div class="col-sm-4"> 
                                           
                                            <div class="form-line">
                                                <input type="file"  class="form-control" name="fuImage" id="fuImage" placeholder="Enter Image" onChange="readURL(this);">
                                                <!--<img id="blah" src="#" />-->
                                            </div>
                                        </div>
                        
                       
                           
                        </div>
                                      
								<div class="form-group"><label class="col-sm-2 control-label">Remark</label>

                                    <div class="col-sm-10"><textarea type="text" class="form-control" id="txt_remark" name="txt_remark" placeholder="Enter Remark"><?php if($Id<>0) echo $row['Remark']; ?></textarea></div>
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
