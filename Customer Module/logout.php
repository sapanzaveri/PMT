<?php
session_start();
unset($_SESSION['UN']);
session_destroy();

header("Location:../index.php");
exit;
?>
<!doctype html>


<html>
<head>
<meta charset="utf-8">
<title> Logout </title>
</head>

<body>
</body>
</html>