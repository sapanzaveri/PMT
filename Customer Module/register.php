<?php
		$message="";
	include("config.php");
	if(isset($_POST['btnSubmit']))
	{
		$Name=($_POST['txt_name']);
		$Email=($_POST['txt_email']);
        $password=($_POST['txt_password']);
        $contact=($_POST['txt_Contact']);
        $Country=($_POST['cmb_Country']);
        $State=($_POST['cmb_State']);
        $City=($_POST['cmb_City']);
        $sql ="INSERT INTO `customer_master`( `Name`, `Email`, `Contact_No`, `Country_Id`, `State_Id`, `City_Id`, `Password`) VALUES ('$Name','$Email','$contact','$Country','$State','$City','$password')";
        $resultset=mysqli_query($link,$sql);
		if($resultset)
		{
			include("PHPMailer-5.2-stable\PHPMailerAutoload.php");
	
		$to = $Email;
		
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
        $mail->SetFrom("projectmanagementtool2017@gmail.com" , "PMT");
        $mail->AddReplyTo("projectmanagementtool2017@gmail.com" , "PHPPot");
        $mail->AddAddress($to);
        $mail->Subject = "Project Managment Tool";
        $mail->WordWrap   = 80;
             $content =
            '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                <html xmlns="http://www.w3.org/1999/xhtml">
                                <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                </head>
                                <body>
                                <form action="newpassword.php" method="get">
                                    <h3> Comfirmation Email of Registration </h3>
                                    <h3> Welcome To Our System </h3>
                                    <p> Your Email'. $Email . " and Password" . $password .' is this.
									</p>
									<p> Thank You for  Using Our System </p>
                                    
                                </body>
                                </html>';
            $mail->MsgHTML($content);
        $mail->IsHTML(true);
        if(!$mail->Send()) 
		{
			echo '<script type="text/javascript">
		alert ("Comfirmation Email of Your Registration has been sent Successfully ");
		window.location.href="Login.php"
</script>';
		}
		else 
		{
		
		echo '<script type="text/javascript">
		alert ("Registration has Successfully but Comfirmation Email of Your Registration has not been sent Successfully");
		window.location.href="Login.php"
</script>';	
		}
		
		  echo '<script type="text/javascript">
			alert("Customer Register Successfully");
			window.location.href="Login.php";
</script>';

		}
		else
        {
          echo'<script type="text/javascript">
			alert("Customer Already Register");
			window.location.href="register.php";
</script>';

            
        }
    }
		?>

<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.7.1/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2017 12:24:32 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>

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
            <h3>Customer Registration</h3>
            <p>Create account to see it in action.</p>
            <form action="register.php" method="post" id="frmEntry" name="frmEntry">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" required="" Name="txt_name" required oninvalid="this.setCustomValidity('Enter Proper Name ')"  onchange="this.setCustomValidity('')" pattern="[a-z A-Z]+"  value="<?php if(isset($_REQUEST['txt_name'])) echo $_REQUEST['txt_name']; ?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" required="" Name="txt_email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  required=""   value="<?php if(isset($_REQUEST['txt_email'])) echo $_REQUEST['txt_email']; ?>">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="" Name="txt_password" value="<?php if(isset($_REQUEST['txt_password'])) echo $_REQUEST['txt_password']; ?>">
                </div>
                 <div class="form-group">
                    <input type="text" class="form-control" placeholder="Contact" required="" Name="txt_Contact"required oninvalid="this.setCustomValidity('Enter proper number')"  onchange="this.setCustomValidity('')"  pattern="[7-9]{1}[0-9]{9}" value="<?php if(isset($_REQUEST['txt_Contact'])) echo $_REQUEST['txt_Contact']; ?>">
                </div>
                    <div class="form-group">
                        <select class="form-control " name="cmb_Country" id="cmb_Country"  onChange="ComboClick();">
                        	<option	 value="0">--- Select Country ---</option>
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
                 <div class="form-group">
                        <select class="form-control " name="cmb_State" id="cmb_State" onChange="ComboClick();">
                     <option value="0">--- Select State ---</option>
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
                 <div class="form-group">
                        <select class="form-control " name="cmb_City" id="cmb_City">
                     <option	 value="0">--- Select City ---</option>
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
                <!--<div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Agree the terms and policy </label></div>
                </div> -->
                <button type="submit" class="btn btn-primary block full-width m-b" NAME="btnSubmit">Register</button>

                <p class="text-muted text-center"><a href="Login.php"s><small>Already have an account?</small></a></p>
              
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
