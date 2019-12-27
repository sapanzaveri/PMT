<?php
 
$link = mysqli_connect('localhost', 'root', '','project_management_tool');
$base_url=$_SERVER['SERVER_NAME'];
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


?>