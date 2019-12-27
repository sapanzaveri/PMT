<?php 
session_start();
	if(!isset($_SESSION['UN']) || $_SESSION['UN'] == "")
	{
		header("Location:Login.php");
	}
include('config.php');
if(isset($_POST['btnSubmit']))
{
	 	
}
if(isset($_GET['rfpConf']))
{
	$Id = $_GET['rfpConf'];
	$sql = "Select br.*, r.* , cm.E_Mail as cmail from bid_result br, rfp r, company_master cm";
	$sql .=" Where br.Rfp_Id=" .$Id;
	$sql .=" and br.Company_Id = cm.Id";
        $emres= mysqli_query($link, $sql);
        $emrow =  mysqli_fetch_array($emres);
		
	$sql = "INSERT INTO `notification`(`Description`, `Genrated_Page`, `Redirected_Page`, `Redirected_Field`, `Redirected_Value`, `From_Id`, `To_Id`, `IsShown`) VALUES(";
	$sql .=" 'Your ". $emrow['Title'] ." Proposal Has been Accpected.','Dashboard.php', 'Dashboard.php', 'norem','','".$_SESSION['UN']."', '".$emrow['Staff_Id']."', '0') ";
	$ni=mysqli_query($link,$sql);
	
	$sql = "Update bid_result set";
		$sql .=" IsShown=0 ";
		$sql .=" Where Rfp_Id=" .$Id;
		$bires = mysqli_query($link,$sql);
		$sql = "Update rfp set";
		$sql .= " IsActive=0 ";
		$sql .= " Where Id=" .$Id ;
		$rfres = mysqli_query($link,$sql); 
	include("PHPMailer-5.2-stable\PHPMailerAutoload.php");
	
		$to = $emrow['cmail'];
		
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
                                    <h3> Comfirmation for the Project Proposal Request </h3>
                                    <p> Your '. $emrow['Title'] .' Proposal Has been Accpected. </p>
                                    
                                </body>
                                </html>';
            $mail->MsgHTML($content);
        $mail->IsHTML(true);
        if(!$mail->Send()) 
		{
			echo '<script type="text/javascript">
		alert ("Notification of Confirmation has been sent But Confirmation E-Mail not  Sent");
		window.location.href="Dashboard.php"
</script>';
		}
		else 
		{
		
		echo '<script type="text/javascript">
		alert ("Notification of Confirmation has been sent and Confirmation E-Mail has been Sent");
		window.location.href="Dashboard.php"
</script>';	
		}
		 
}
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Project Management Tool</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
   <?php include('sidebar.php')?>
       <?php include('header.php')?>
       
       <?php include('footer.php')?>
     <div id="right-sidebar">
            <div class="sidebar-container">
 				<?php include('rightsidetoolbar.php') ?>
		 </div>
		</div>
       <div class="wrapper wrapper-content animated fadeIn">

                <div class="p-w-md m-t-sm">
                    <div class="row">
						<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        
                               <h2>Welcome To Project Management Tool</h2>

                            
                                </div>
                                <input type="hidden" id="hdnRid" name="hdnRid" value="<?php echo $Id; ?>" >
                               <form action="Dashboard.php" method="post"> 
                        		<div class="ibox float-e-margins">
                    
                        <div class="ibox-title">
                            <div class="col-lg-12">
                            <h5>Proposal's Bid </h5>
                            </div>
                            <?php
                    $sql = "Select br.*, r.Id as rid ,r.Title, c.Name as cn ,r.Customer_Id from bid_result br, rfp r, company_master c";
					$sql .= " Where br.rfp_Id=r.Id";
					$sql .= " and br.Company_Id=c.Id";
					$sql .= " and r.Customer_Id=". $_SESSION['UN'];
					$sql .= " and IsShown=1";
                   
                    $res= mysqli_query($link,$sql);
       				if(mysqli_num_rows($res)<>0)
					{
						?>
                            <div class="ibox-content">
                                
                        <table class="table table-striped table-bordered table-hover dataTables-example ">
                            <tr>
                                <td>Pruposal Title</td>
                                <td>Company Name</td>
                                <td>Download Proposal</td>
                                <td>Send To </td>
                            </tr>
                      <?php
                   
                              	while($row=mysqli_fetch_array($res))
                                {
                                
                                echo '';
                                echo '<tr>';
                                echo '<td>';
                                //echo '<h5> Request For Purposal </h5>';
                                echo '<a href="../pmt/'. $row['File'] . '">';
								echo '<h5 class="media-heading"><strong>' .$row['Title']. '</strong></h5>';
								echo '</a>';
                                echo '</td>';
                                echo '<td>';
                                echo '<h5 class="media-heading"><strong>' .$row['cn']. '</strong></h5>';
                                echo '</td>';
                                echo '<td>';
								echo '<a href="../pmt/'. $row['File'] . '"> <input type="button" class="btn btn-primary" value="Download Proposal"> </a> ';
                                echo '</td>';
								echo '<td>';
								echo '<a href="Dashboard.php?rfpConf=' . $row['rid'] . '" ><input type="button" class="btn btn-primary" value="Confirm" id="btnSubmit" name="btnSubmit"></a>';
								echo '</td>';
								echo '</tr>';
                                echo '';
                               
                                }
					}
		else 
		{
			echo "<div class='ibox-content'><h4> No Purposal Bid has be Come </h4></div> ";
		}
                                ?>
                                </table>
                                </div>
                                </div>
                        </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                   
                </div>

		   </div>
            </div>
   
    
    
    
    

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="js/plugins/flot/jquery.flot.time.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>


    <script>
        $(document).ready(function() {

            var sparklineCharts = function(){
                $("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 52], {
                    type: 'line',
                    width: '100%',
                    height: '50',
                    lineColor: '#1ab394',
                    fillColor: "transparent"
                });

                $("#sparkline2").sparkline([32, 11, 25, 37, 41, 32, 34, 42], {
                    type: 'line',
                    width: '100%',
                    height: '50',
                    lineColor: '#1ab394',
                    fillColor: "transparent"
                });

                $("#sparkline3").sparkline([34, 22, 24, 41, 10, 18, 16,8], {
                    type: 'line',
                    width: '100%',
                    height: '50',
                    lineColor: '#1C84C6',
                    fillColor: "transparent"
                });
            };

            var sparkResize;

            $(window).resize(function(e) {
                clearTimeout(sparkResize);
                sparkResize = setTimeout(sparklineCharts, 500);
            });

            sparklineCharts();




            var data1 = [
                [0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,20],[11,10],[12,13],[13,4],[14,7],[15,8],[16,12]
            ];
            var data2 = [
                [0,0],[1,2],[2,7],[3,4],[4,11],[5,4],[6,2],[7,5],[8,11],[9,5],[10,4],[11,1],[12,5],[13,2],[14,5],[15,2],[16,0]
            ];
            $("#flot-dashboard5-chart").length && $.plot($("#flot-dashboard5-chart"), [
                        data1,  data2
                    ],
                    {
                        series: {
                            lines: {
                                show: false,
                                fill: true
                            },
                            splines: {
                                show: true,
                                tension: 0.4,
                                lineWidth: 1,
                                fill: 0.4
                            },
                            points: {
                                radius: 0,
                                show: true
                            },
                            shadowSize: 2
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,

                            borderWidth: 2,
                            color: 'transparent'
                        },
                        colors: ["#1ab394", "#1C84C6"],
                        xaxis:{
                        },
                        yaxis: {
                        },
                        tooltip: false
                    }
            );

        });
    </script>
</body>

<!-- Mirrored from webapplayers.com/inspinia_admin-v2.7.1/dashboard_5.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2017 12:21:52 GMT -->
</html>
