<?php
	session_start();
	
	$message="";
	include("config.php");
	if(isset($_POST['btnSubmit']))
	{
		$Email = $_POST['txt_email'];
		$Password =($_POST['txt_password']);
	
	
		$sql = "SELECT * FROM `customer_master` ";
		$sql = $sql . " WHERE Email = '$Email' AND Password ='$Password'";
		
		$result = mysqli_query($link, $sql);
		
		if (mysqli_num_rows($result) == 1)
		{
			$row = mysqli_fetch_array($result);
            $_SESSION['UN']=$row['Id'];
			//$_SESSION['Staff_Id'] = $row[]
			header('location:Dashboard.php');
			
		}
		else 
		{
			echo '<script type="text/javascript">
			alert("Invalid User Name/Password.");
			window.location.href="Login.php";
</script>';
			
		}
	
		
	}
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Project Management Tool Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
<script>
	function ForgotPwd()
	{
		unm=document.getElementById('txt_email').value;
		//alert("mail.php?unm=" + unm);
		window.open("forgot_password.php?unm=" + unm);
	};
</script>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name"> <img alt="image"  src="img/logo.png"> </img>
                             </span></h1>

            </div>
            <h2><strong>Customer Login</strong></h2>
            <h3>Welcome to Project Management Tool</h3>
            <form  method="post" class="m-t" role="form" action="Login.php">
               
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Username" required="" Name="txt_email" id="txt_email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="" Name="txt_password" id="txt_password">
                </div>
                	<button type="submit" class="btn btn-primary block full-width m-b" name="btnSubmit" id="btnSubmit">Login</button>
                <a href="register.php"><small>SIGN UP</small></a></BR>
                <a href="" onClick="ForgotPwd();"><small>Forgot password?</small></a>
                
			</form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
