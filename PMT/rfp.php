<?php
	session_start();
	if(!isset($_SESSION['UName']) || $_SESSION['UName'] == "")
	{
		header("Location:index.php");
	}
$flg = 0;
$goToEsstimation=0;
$message="";
include("config.php");
$Id=0;
function getExtension($str) 
	{
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
	 }
if(isset($_GET['rid']))
{
	$Id = $_GET['rid'];
    $sql = "Delete from tmp where Staff_Id=" . $_SESSION['UID'];
    mysqli_query($link,$sql);
	$sql="Select r.*, c.Name as cn from rfp r, customer_master c";
    $sql .=" Where r.Id=" .$Id;
   $sql .= " and r.Customer_Id=c.Id";
    
    $res1=mysqli_query($link,$sql);
		$row1=mysqli_fetch_array($res1);

}

if(isset($_POST['btnSubmit']))
{
		$flg=1;
	 $Id=$_POST['hdnRid'];
	
		$newname="";
		$theData = "";
		$doc = $_FILES['fdoc']['tmp_name'];
			//print_r($image);
			if($doc <>'')
			{
				 $filename = stripslashes($_FILES['fdoc']['name']);
				 $extension = getExtension($filename);
				 $extension = strtolower($extension);
				if (($extension <> "docx") && ($extension <> "doc") && ($extension <> "pdf") ) 
				{
					$message = 'Unknown extension!';
				}
				else
				{
					$myFile = 'doc/filename.txt';
					$fh = fopen($myFile, 'r');
					$theData = fread($fh,5);
					fclose($fh);
					
					 $newname = "doc/" . $theData . '.' . $extension;
				
				}
			}
	
	$sql ="INSERT INTO `bid_result`(`File`, `Rfp_Id`,`Company_Id`, `IsShown`, `Staff_Id`) VALUES(";
	$sql .= "'$newname','$Id', '". $_SESSION['CID']."', '1', '".$_SESSION['UID']."')";

	$fres=mysqli_query($link,$sql);
		
	if($fres)
	{
	echo '<script type="text/javascript">
			alert("Bid Send Successfully");
		window.location.href="Dashboard.php";
</script>';
		if($_FILES['fdoc']['name']>'')
					{
						$message = $message . //";In if;";
					 $copied = copy($_FILES['fdoc']['tmp_name'], $newname);
												
						if ($copied)
						{
							$message = $message . //"Coppied done;";
							$fh = fopen($myFile, 'w') or die("cant open file");
							fwrite($fh, $theData + 1);
							fclose($fh);
							
						}
						else
							$message = 'Error while saving Image.' . $sql;
					}
	}
	else 
	{
		echo '<script type="text/javascript">
			alert("Bid Send UnSuccessfully'.$sql.'");
			window.location.href="rfp.php?rid=' . $Id . '";
			</script>';
	}
}
if(isset($_POST['btnSubmit1']))
{
	echo '<script type="text/javascript">
			
			window.location.href="Dashboard.php";
			</script>';
}
if(isset($_POST['btnbid']))
{
	echo '<script type="text/javascript">
			
			
			
			alert("Downloaded the Sample file");
			window.location.href="doc/rfp.docx";	
			
			</script>';
	
}

/*if(isset($_POST['btnbid']))
{
    $flg=1;
     $Id=$_POST['hdnRid'];
		
}
	if(isset($_POST['btnAdd']))
	{
        $flg=1;
        $Id=$_POST['hdnRid'];
		$modal=($_POST['txt_modal']);
		$cost=($_POST['txt_cost']);
		$top=($_POST['Top']);
        $sql ="INSERT INTO `tmp`(`Module`, `Cost`,`Staff_Id`,`Type_Of_Project`) VALUES ('$modal','$cost','".$_SESSION['UID']."','$top')";
        
		$resultset=mysqli_query($link,$sql);
		$goToEsstimation=1;
	}

if(isset($_POST['btnSubmit']))
{
    	$flg=1;
		$Id=$_POST['hdnRid'];
		$des=($_POST['txt_des']);
		$Apc=($_POST['txt_Approxcost']);
		$Apt=($_POST['txt_Approxtime']);
		$sql="INSERT INTO `company_bid`(`rfp_id`, `Description`, `Approx_Estimation`, `Approx_Cost`, `Staff_Id`) VALUES (";
		$sql .= " '$Id', '$des', '$Apt', '$Apc', '".$_SESSION['UID']."' )";
		$resultset=mysqli_query($link,$sql);
		
		if($resultset)
		{
			$sql = "Select max(Id) as Id from company_bid ";
			$resTmp = mysqli_query($link,$sql);
			$rowTmp = mysqli_fetch_array($resTmp);
			$cb_Id = $rowTmp['Id'];
			$sql = "Select * from tmp ";
			$resTmp = mysqli_query($link,$sql);
			while($rowTmp = mysqli_fetch_array($resTmp))
			{
				$sql = "insert into bid_estimation(Cb_Id,Module,Cost,Type_Of_Project)Values(";
				$sql .= "'$cb_Id','" . $rowTmp['Module'] . "','" . $rowTmp['Cost'] . "','" . $rowTmp['Type_Of_Project'] . "')";
				mysqli_query($link,$sql);
			}
		echo '<script type="text/javascript">
			alert("BID Send Successfully");
			window.location.href="Dashboard.php";
			</script>';
		}
		else 
		{
		echo '<script type="text/javascript">
			alert("BID Send Not Successfully");
			window.location.href="Dashboard.php";
			</script>';
		}
}

	
*/	
if($Id<>0)
{
    $sql="Select r.*, c.Name as cn from rfp r, customer_master c";
    $sql .=" Where r.Id=" .$Id;
   $sql .= " and r.Customer_Id=c.Id";
    
    $res1=mysqli_query($link,$sql);
		$row1=mysqli_fetch_array($res1);

}
		?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> RFP </title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
<script>
	function goToEsstimation()
	{
		//window.scrollTo(700);
		//window.location.href="Dashboard.php?#tf-chat";
		document.frmEntry.txtMessage.focus();
	};
	window.onload = goToEsstimation();
	</script>

</head>

<body <?php if($goToEsstimation==1) echo 'onload="javascript:goToEsstimation()"' ?> >
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
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Request For Purposal</h5>
                           
                        <div class="ibox-content">
                            <form method="POST" action="rfp.php" class="form-horizontal" enctype="multipart/form-data">
                                <?php echo $message; ?>
                                <input type="hidden" id="hdnRid" name="hdnRid" value="<?php echo $Id; ?>" >
                                <div class="form-group ">
                                    <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example "> 
                                 <tr>
                                    <th class="col-lg-2"> Customer Name  </th>
                                    <td> <strong> <?php echo $row1['cn']; ?></strong> </td>
                                      
                                </tr>
                                <tr>
                                    <th > Title </th>
                                    <td><strong> <?php echo $row1['Title']; ?>  </strong> </td>
                                </tr>
                                 <tr >
                                    <th> Description </th>
                                    <td><strong> <?php echo $row1['Description']; ?> </strong></td>
                                </tr>
                                <tr>
                                    <th> Type Of Project </th>
                                    <td > <strong><?php echo $row1['Type_Project']; ?></strong></td>
                                </tr>
                                <tr>
                                    <th> Estimation </th>
                                    <td> <strong><?php echo $row1['Estimation']; ?> </strong></td>
                                </tr>
                                <tr>
                                    <th> Estimation Time </th>
                                    <td> <strong><?php echo $row1['Estimated_Time']; ?></strong></td>
                                </tr>
                                </table>

                                   </div>
                                </div>
                                 
                                
                        <!--    </form>-->
                            
                           
                           <div class="form-group"> 
                            <label class="col-md-1 control-label"> File </label>
                                          <div class="col-sm-5"> 
                                           
                                            <div class="form-line">
                                                <input type="file"  class="form-control" name="fdoc" id="fdoc" onChange="readURL(this);" required>
                                                <!--<img id="blah" src="#" />-->
                                            </div>
                                        </div>
							   <button class="btn btn-primary" name="btnSubmit" id="btnSubmit"> Send </button>
							 	
                           <a href="doc/rfp.docx" class="col-lg-offset-7"><input type="button" class="btn btn-primary" value="Sample Proposal Download"></a>
                           <a href="Dashboard.php"> <button class="btn btn-primary" onclick="location.href='Dashboard.php'"; name="btnSubmit1" id="btnSubmit1"> Back To Home</button></a>
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
    <?php
    if($goToEsstimation==1)
{
	echo "<script>
	
 document.getElementById('tf-esstimation').scrollIntoView(); 


</script>";
}
?>

</body>

<!-- Mirrored from webapplayers.com/inspinia_admin-v2.7.1/dashboard_5.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2017 12:21:52 GMT -->
</html>
