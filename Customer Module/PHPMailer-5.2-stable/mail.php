<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
	require 'PHPMailerAutoload.php';
//require('class.phpmailer.php');
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
$mail->AddAddress("rathod_keyur@yahoo.com");
$mail->Subject = "Test email using PHP mailer";
$mail->WordWrap   = 80;
$content = "<b>Welcome to Project Management Tool.</b>"; $mail->MsgHTML($content);
$mail->IsHTML(true);
if(!$mail->Send()) 
echo "Problem sending email.";
else 
echo "email sent.";
?>
</body>
</html>