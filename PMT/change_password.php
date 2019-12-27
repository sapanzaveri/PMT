<?php
session_start();
if(!isset($_SESSION['UName']) || $_SESSION['UName'] == "")
	{
		header("Location:index.php");
	}
include('config.php');
$message= "";
if(isset($_POST['btnSubmit']))
{
$old_password=$_POST['oldpassword'];
$new_password=$_POST['password'];
$con_password=$_POST['confirm_password'];
$sql= "select * from login_master where Staff_Id='".$_SESSION['UID']."'";
$chg_pwd=mysqli_query($link,$sql);
$chg_pwd1=mysqli_fetch_array($chg_pwd);
$data_pwd=$chg_pwd1['Password'];
if($data_pwd==$old_password)
{
if($new_password==$con_password)
{
$update_pwd=mysqli_query($link,"update login_master set Password='$new_password' where Staff_Id='".$_SESSION['UID']."'");
   include("PHPMailer-5.2-stable\PHPMailerAutoload.php");
	   $sql = "Select * from login_master";
        $sql .= " Where Staff_Id='".$_SESSION['UID']."'";
        $newres= mysqli_query($link, $sql);
        $newrow =  mysqli_fetch_array($newres);
		$to = $newrow['Username'];

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
                                    <h3>Welcome To Project Management Tool </h3>
                                     <h4> Your Password Change request has been Successfully Done </h4>
									 <p> Your Password is '.$new_password.' </p>   
                                </body>
                                </html>';
            $mail->MsgHTML($content);
        $mail->IsHTML(true);
if(!$mail->Send()) 
{
    echo '<script type="text/javascript">
		alert ("Your Password  Not changed.");
		window.location.href="change_password.php"
</script>';
}
else 
{
  echo '<script type="text/javascript">
		alert ("Your Password changed.");
		window.location.href="Dashboard.php"
</script>'; 
}
}
else
{
echo '<script type="text/javascript">
			alert ("Your New Password and Confirm Password don`t Match");
			window.location.href="change_password.php";
</script>';
}
}
else
{
echo '<script type="text/javascript">
			alert ("Your old password is Wrong !!!");
			window.location.href="change_password.php";
</script>';
}

}
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> New Password</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name"> <img alt="image"  src="img/logo.png" />
                             </span></h1>

            </div>
            <h3>Project Management Tool</h3>
            <form  method="post" class="m-t" role="form" action="change_password.php">
                <?php echo $message; ?>
                
                   <div class="form-group">
                    <input type="password" class="form-control" placeholder="Old Password" required="" Name="oldpassword" id="oldpassword">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="" Name="password" id="password">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Confirm Password" required="" Name="confirm_password" id="confirm_password" onFocus="ValidatePassword">
                </div>
                	<button type="submit" class="btn btn-primary block full-width m-b" name="btnSubmit" id="btnSubmit">Change Password</button>
                
			</form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
       <script type="text/javascript">
		var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
			</script>
</body>
</html>
