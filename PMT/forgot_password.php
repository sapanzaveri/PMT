<?php
	include("config.php");
    include("PHPMailer-5.2-stable\PHPMailerAutoload.php");
if(isset($_REQUEST['btnSubmit']))
{
	$sql = "Select u.Password,s.* from login_master u,staff_master s where Username='" . $_POST['txt_email'] . "' " ;
	$sql = $sql . " and u.Staff_Id=s.Id ";
//echo $sql;
	$res = mysqli_query($link,$sql);
	
	if(mysqli_num_rows($res)>=1)
	{
		$row=mysqli_fetch_array($res);
		$to = $row['Email'];
		$msg = "Your password is : " . $row['Password'];
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
        $content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                <html xmlns="http://www.w3.org/1999/xhtml">
                                <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                </head>
                                <body>
                                <form action="newpassword.php" method="get">
                                    
                                    <h3>Welcome To Project Management Tool</h3>
                                    
                                    <div>
                                    <a href ="http://localhost:8080/Project%20Management%20Tool/pmt/newpassword.php?sid=' . $row['Email']. '">Click here to Change your Password</a>
                                </div>
                            
                                </body>
                                </html>';
         $mail->MsgHTML($content);
        $mail->IsHTML(true);
        if(!$mail->Send()) 
            
        
			?>
	<script type="text/javascript">
		alert ("Your password is sent your registered Email ID.");
		window.location.href="index.php";
</script>
	<?php	
	}
	else
	{
		?>
		<script type="text/javascript">
		alert ("Invalid Email ID.");
		window.location.href="forgot_password.php";
</script>
<?php
	}
}
?>

<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.7.1/forgot_password.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2017 12:24:32 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Forgot password</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
	
	


</head>

<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">
					<form action="forgot_password.php" method="post">
						<?php $message; ?>
                    <h2 class="font-bold">Forgot password</h2>

                    <p>
                        Enter your email address and your password will be reset and emailed to you.
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                        
                                <div class="form-group">
                                    <input type="email" name="txt_email" id="txt_email" class="form-control" placeholder="Email address" required="">
                                </div>
								<button type="submit" class="btn btn-primary block full-width m-b" name="btnSubmit" id="btnSubmit">Send Email</button>
                              
							
                            
                        </div>
                    </div>
					</form>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
            
            </div>
            <div class="col-md-6 text-right">
               <small></small>
            </div>
        </div>
    </div>

</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.7.1/forgot_password.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2017 12:24:32 GMT -->
</html>
