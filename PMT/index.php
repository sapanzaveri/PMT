<?php
	session_start();
	if(isset($_SESSION['UName']) && $_SESSION['UName'] <> "")
	{
		header("Location:Dashboard.php");
	}
	$message="";
	include("config.php");
	if(isset($_POST['btnSubmit']))
	{
		$Email = $_POST['txt_email'];
		$Password =($_POST['txt_password']);
		$code=($_POST['txt_code']);
	
		$sql = "SELECT * FROM `login_master`";
		$sql = $sql . " WHERE Username = '$Email' AND Password ='$Password'";
		$sql = $sql . " and IsActive=1";
		$sql = $sql . " and Company_Id in (Select Id from company_master where Code='" . $code . "')";
		echo $sql;
		$result = mysqli_query($link, $sql);
		
		if (mysqli_num_rows($result) == 1)
		{
			$row = mysqli_fetch_array($result);
			$_SESSION['UName'] = $Email;
			$_SESSION['UID'] = $row['Staff_Id'];
			$sql = "Select Name as dna from designation_master where id in (Select Designation_Id from staff_master where Id=" . $_SESSION['UID'] . ")";
			$resAdmin = mysqli_query($link,$sql);
			$rowAdmin = mysqli_fetch_array($resAdmin);
				
            //if($row['Staff_Id']==7)
			 $_SESSION['Des'] = $rowAdmin['dna'];
            
                //$_SESSION['Des'] = "";
            //$_SESSION['Staff_Id'] = $row[]
            $_SESSION['Login_Id'] = $row['Id'];
			$_SESSION['CID'] = $row['Company_Id'];
            header('location:index.php');
			
		}
		else 
		{
			echo '<script type="text/javascript">
			alert("Invalid UserName/Password/Company Code");
			window.location.href="Customer_Entry.php";
</script>';
			$message="Invalid User Name/Password.";
			//header('location:Dashboard.php');
			
			//$message="login suceefull";
			
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
		window.open("mail.php?unm=" + unm);
	};
</script>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name"> <img alt="image"  src="img/logo.png" />
                             </span></h1>

            </div>
            <h3>Welcome to Project Management Tool</h3>
            <form  method="post" class="m-t" role="form" action="index.php">
                <?php echo $message; ?>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Username" required="" Name="txt_email" id="txt_email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="" Name="txt_password" id="txt_password">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Company Code" required="" Name="txt_code" id="txt_code">
                </div>
                	<button type="submit" class="btn btn-primary block full-width m-b" name="btnSubmit" id="btnSubmit">Login</button>

                <a href="forgot_password.php" ><small>Forgot password?</small></a>
              
			</form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
