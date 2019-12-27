<?php
		$message="";
	$Id =0;
	include("config.php");
    function generateRandomString($length = 3) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$rnd= generateRandomString();
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
		$Address1=($_POST['txt_address1']);
        $Address2=($_POST['txt_address2']);
        $Email=($_POST['txt_email']);
        $password=($_POST['txt_pwd']);
		$Phone=($_POST['txt_phone']);
        $Website=($_POST['txt_website']);
        $Country=($_POST['cmb_Country']);
        $State=($_POST['cmb_State']);
        $City=($_POST['cmb_City']);
		$Remark=($_POST['txt_remark']);
		
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
			alert("Image Formate Don`t Match");
			window.location.href="Company_Entry.php";
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
		$sql = "INSERT INTO `company_master` (`Name`, `Address1`, `Address2`, `Logo`, `Contact_No`, `E_Mail`, `Website`, `City_Id`, `State_Id`, `Country_Id`, `Remark` ,`Code`, `Password`) VALUES ('$Name','$Address1','$Address2','$newname','$Phone', '$Email' , '$Website','$City','$State','$Country','$Remark', '$rnd', '$password')";
			
            $resultset=mysqli_query($link,$sql);
            
            $sql = "Select max(Id) as Id from company_master ";
			$resTmp = mysqli_query($link,$sql);
			$rowTmp = mysqli_fetch_array($resTmp);
			$cb_Id = $rowTmp['Id'];
			$sql = "Select * from company_master ";
			$resTmp = mysqli_query($link,$sql);
			while($rowTmp = mysqli_fetch_array($resTmp))
			{
		 $sql ="INSERT INTO `staff_master`(`Name`, `Contact`, `Email`,`Designation_Id`, `Address`, `Image`, `Company_Id`, `Password`) VALUES"; $sql .= "('$Name','$Phone','$Email',5,'$Address1','$newname','" . $cb_Id . "', '$password')";
		mysqli_query($link,$sql);   
			}
            
            $sql = "Select max(Id) as sId from staff_master ";
			$resTmp1 = mysqli_query($link,$sql);
			$rowTmp1 = mysqli_fetch_array($resTmp1);
			$cb_Id1 = $rowTmp1['sId'];
			$sql = "Select * from staff_master ";
			$resTmp1 = mysqli_query($link,$sql);
			while($rowTmp1 = mysqli_fetch_array($resTmp1))
			{
		$sql = "INSERT INTO `login_master`(`Username`, `Password`, `IsActive`, `Staff_Id`, `Company_Id`) VALUES (";
		$sql .= " '$Email', '$password', '1', '" . $cb_Id1 . "', '$cb_Id')";
      
		mysqli_query($link,$sql);
			}
           
		}
		else
		{
			$sql="Update company_master set";
			$sql .= " Name='$Name', ";
            $sql .= " Address1='$Address1', ";
            $sql .= " Address2='$Address2', ";
            if($image<>'')
				$sql .= " Logo='$newname', ";
			$sql .= " Contact='$Phone', ";
			$sql .= " Email='$Email', ";
			$sql .= " Website='$Website', ";
		    $sql .= " City_Id='$City', ";
			$sql .= " State_Id='$State', ";
            $sql .= " Country_Id='$Country', ";
			$sql .= " Remark='$Remark' ";
			$sql .= " Where Id=" . $hdnId;
       
			$redirect ='#';
            $resultset=mysqli_query($link,$sql);
		}
		
		if($resultset)
			{
				
	 include("PHPMailer-5.2-stable\PHPMailerAutoload.php");
	  $to = $_POST['txt_email'];

		$mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = "ssl";
        $mail->Port     = 465;  
        $mail->Username = "projectmanagementtool2017@gmail.com";
        $mail->Password = "pmt@2017";
        $mail->Host     = "smtp.gmail.com";
        $mail->Mailer   = "smtp";
        $mail->SetFrom("projectmanagementtool2017@gmail.com", "PMT");
        $mail->AddReplyTo("projectmanagementtool2017@gmail.com", "PHPPot");
        $mail->AddAddress($to);
        $mail->Subject = "Project Management Tool";
        $mail->WordWrap   = 80;
             $content =
            '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                <html xmlns="http://www.w3.org/1999/xhtml">
                                <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                </head>
                                <body>
                                <form action="Company_Entry.php" method="get">
                                    <h3>Welcome To Project Management Tool </h3>
                                     <h4> Your Company Registration  has been Successfully Done </h4>
									 <p> Your Email/ UserName is '. $Email.', </p>
									<p> Password is '.$password.' and Company code is '.$rnd.' </p>   
                                </body>
                                </html>';
            $mail->MsgHTML($content);
        $mail->IsHTML(true);
if(!$mail->Send()) 
{
    echo '<script type="text/javascript">
		alert ("Your registration not done.");
		window.location.href="change_password.php"
</script>';
}
else 
{
  echo '<script type="text/javascript">
		alert ("Company Saved Successfully Your Company Code is= `'.$rnd.'`");
		window.location.href="Dashboard.php"
</script>'; 
}
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
						{
							$message = 'Error while saving Image.';
					}
					}
		
		}
		else 
		{
		echo '
		<script type="text/javascript">
			alert("Company Already Exist");
			window.location.href="Company_Entry.php";
</script>';



			//header('Location: '.$redirect);
		}
	}

		if(isset($_GET['sid']))
	{
		$Id = $_GET['sid'];
		$sql = "SElect * from company_master where Id=" . $Id;
		$res=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($res);
	}
?>
<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.7.1/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2017 12:24:32 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Company Registration</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
<script language="javascript" type="text/javascript">
function ComboClick() {

document.frmEntry.submit();

}
</script>

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>
                    <h1 class="logo-name"> <img alt="image"  src="img/logo.png" />
                             </span></h1>

            </div>
            <h3>Company Registration</h3>
            <p>Create account to see it in action.</p>
            <form method="post" class="form-horizontal" action="Company_Entry.php" enctype="multipart/form-data" id="frmEntry" name="frmEntry">
                               <?php echo $message; ?>
                               <input type="hidden" name="hdnId" id="hdnId" value="<?php echo $Id; ?>">
                                <div class="form-group"><label class="control-label"> Name</label>

                                    <div><input type="text" class="form-control" id="txt_name" name="txt_name" placeholder="Enter Name" required oninvalid="this.setCustomValidity('Enter Proper Name ')"  onchange="this.setCustomValidity('')" pattern="[a-z A-Z]+" value="<?php if($Id<>0) echo $row['Name']; if(isset($_REQUEST['txt_name'])) echo $_REQUEST['txt_name'];?>"></div>
                                </div>
                                <div class="form-group"><label class=" control-label">Address1</label>

                                    <div ><textarea type="text" class="form-control" id="txt_address1" name="txt_address1" placeholder="Enter Address" required oninvalid="this.setCustomValidity('Enter Address ')"  onchange="this.setCustomValidity('')" ><?php if($Id<>0) echo $row['Name']; if(isset($_REQUEST['txt_address1'])) echo $_REQUEST['txt_address1']; ?></textarea></div>
                                </div>
                                <div class="form-group"><label class="control-label">Address2</label>

                                    <div ><textarea type="text" class="form-control" id="txt_address2" name="txt_address2" placeholder="Enter Address (Optional)"><?php if($Id<>0) echo $row['Name'];
                                    if(isset($_REQUEST['txt_address2'])) echo $_REQUEST['txt_address2'];    ?></textarea></div>
                                </div>
                              
                         <div class="form-group"><label class="control-label">Contact</label>

                                    <div ><input type="text" class="form-control" id="txt_phone" name="txt_phone" placeholder="Enter Phone Number" required oninvalid="this.setCustomValidity('Enter proper number  ')"  onchange="this.setCustomValidity('')" pattern="[7-9]{1}[0-9]{9}" value="<?php if($Id<>0) echo $row['Contact']; if(isset($_REQUEST['txt_phone'])) echo $_REQUEST['txt_phone']; ?>"></div>
                                </div>

                                 <div class="form-group"><label class="control-label">Email</label>

                                    <div ><input type="EMail" class="form-control" id="txt_email" name="txt_email" placeholder="Enter Email"  required="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?php if($Id<>0) echo $row['Name']; if(isset($_REQUEST['txt_email'])) echo $_REQUEST['txt_email']; ?>"></div>
                                </div>
                                 <div class="form-group"><label class="control-label"> Password</label>

                                    <div><input type="password" class="form-control" id="txt_pwd" name="txt_pwd" placeholder="Enter Password" required oninvalid="this.setCustomValidity('Enter Password ')"  onchange="this.setCustomValidity('')"  value="<?php if($Id<>0) echo $row['Name']; if(isset($_REQUEST['txt_pwd'])) echo $_REQUEST['txt_pwd'];?>"></div>
                                </div>
                                    <div class="form-group"><label class="control-label">Website</label>

                                    <div><input type="text" class="form-control" id="txt_website" name="txt_website" placeholder="Enter Website" value="<?php if($Id<>0) echo $row['Name']; if(isset($_REQUEST['txt_website'])) echo $_REQUEST['txt_website']; ?>"></div>
                                </div> 
                                     <div class="form-group"><label class="control-label">Country</label>
                                         <div>
                        <select class="form-control " name="cmb_Country" id="cmb_Country"  onChange="ComboClick();" required>
                        	<option	 value="">--- Select Country ---</option>
                              <?php

							$sql = "Select * from country_master order by Name";
							$dres = mysqli_query($link,$sql);
							while($drow = mysqli_fetch_array($dres))
							{
								//echo '<Option value="' . $drow['Id'] . '" ';

								echo '<option value="' . $drow['Id'] . '" ';
								if(isset($_REQUEST['cmb_Country']) && $_REQUEST['cmb_Country']==$drow['Id'])
									echo ' selected="Selected" ';
								echo '>' . $drow['Name'] . '</option>';

							}

							?>
                        </select>
                </div>
                                </div>
                 <div class="form-group"><label class="control-label">State</label>
                      <div>
                        <select class="form-control " name="cmb_State" id="cmb_State" onChange="ComboClick();" required>
                         <option value="">--- Select State ---</option>
                              <?php
                        if(isset($_REQUEST['cmb_Country']))
							$sql = "Select s.Id as id, s.Name as Name , s.Country_Id as Country_Id, c.Id from state_master s, country_master c ";
                            $sql .= " Where s.Country_Id=" . $_REQUEST['cmb_Country'];
                            $sql .= " and s.Country_Id=c.Id";
                            echo $sql;
							$dres1 = mysqli_query($link,$sql);
							while($drow1 = mysqli_fetch_array($dres1))
							{
								//echo '<Option value="' . $drow['Id'] . '" ';

								echo '<option value="' . $drow1['id'] . '" ';
								if(isset($_REQUEST['cmb_State']) && $_REQUEST['cmb_State']==$drow1['id'])
                                    
									echo ' selected="Selected" ';
								echo '>' . $drow1['Name'] . '</option>';

							}

							?>
                     </select>
                </div>
                     </div>
                 <div class="form-group"><label class="control-label">City</label>
                      <div>
                        <select class="form-control " name="cmb_City" id="cmb_City" required>
                     <option	 value="">--- Select City ---</option>
                              <?php
                            
							$sql = "Select c.*, s.Id from city_master c, state_master s";
                            $sql .= " Where c.State_Id=" .$_REQUEST['cmb_State'];
                            $sql .= " and c.State_Id=s.Id";
                            echo $sql;
							$dres2 = mysqli_query($link,$sql);
							while($drow2 = mysqli_fetch_array($dres2))
							{
								//echo '<Option value="' . $drow['Id'] . '" ';

								echo '<option value="' . $drow2['Id'] . '" ';
								if(isset($_REQUEST['cmb_City']) && $_REQUEST['cmb_City']==$drow2['Id'])
									echo ' selected="Selected" ';
								echo '>' . $drow2['Name'] . '</option>';

							}

							?>
                     </select>
                </div>                        
                     </div>           <div class="form-group"> 
                            <label class=" control-label">Logo </label>
                                          <div> 
                                           
                                            <div class="form-line">
                                                <input type="file"  class="form-control" name="fuImage" id="fuImage" placeholder="Enter Image" onChange="readURL(this);">
                                                <!--<img id="blah" src="#" />-->
                                            </div>
                                        </div>
                           
                        </div>      
								<div class="form-group"><label class="control-label">Remark</label>

                                    <div><textarea type="text" class="form-control" id="txt_remark" name="txt_remark" placeholder="Enter Remark"><?php if($Id<>0) echo $row['Remark'];  if(isset($_REQUEST['txt_remark'])) echo $_REQUEST['txt_remark'];?></textarea></div>
                                	</div>
   
   
                                <div class="hr-line-dashed"></div>
                               <div class="form-group">
                                    <div class="col-sm-offset-1">
                                        <button class="btn btn-white" type="reset">Cancel</button>
                                        <button class="btn btn-primary" type="submit" name="btnSubmit" id="btnSubmit">Save</button>
                                    </div>
                                </div>
                                </div>
                            </form>
            <p class="m-t"> <small>Project Management Tool</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.7.1/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2017 12:24:32 GMT -->
</html>
