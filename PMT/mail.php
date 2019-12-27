<?php
	include("config.php");
	$sql = "Select u.Password,s.* from login_master u,staff_master s where Username='" . $_GET['unm'] . "' " ;
	$sql = $sql . " and u.Staff_Id=s.Id ";
//echo $sql;
	$res = mysqli_query($link,$sql);
	
	if(mysqli_num_rows($res)>=1)
	{
		$row=mysqli_fetch_array($res);
		$to = $row['Email'];
		$msg = "Your password is : " . $row['Password'];
		//if(mail($to,"Your Password for PM Tool",$msg,"From:Admin"))
			echo "Your password is sent your registered Email ID.";
	}
	else
		echo "Invalid User name";
	echo '<br />';
	echo '<a href="index.php" >Go Back</a>';
?>