
<html>
<?php
	$con=mysqli_connect('localhost','root','','test');
	$NAME=$_POST['txt_name'];
	$EMAIL=$_POST['txt_email'];
	$PASSWORD=$_POST['txt_password'];
	
	
	$sql = "INSERT INTO `registration`(`NAME`, `EMAIL`, `PASSWORD`) VALUES ('$NAME','$EMAIL','$PASSWORD')";
	$resultset=mysqli_query($con,$sql);
	if($resultset)
	{
		echo "Data inserted successfully";
	}
	else
	{
		echo "Something went wrong";
	}
?>
</html>
