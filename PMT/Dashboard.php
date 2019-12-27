<?php
	session_start();

$goToChat=0;
	if(!isset($_SESSION['UName']) || $_SESSION['UName'] == "")
	{
		header("Location:index.php");
	}
include('config.php');
 date_default_timezone_set("Asia/Kolkata");//set you countary name from below timezone list
 $date = date("H:i:s", time());
$sql= "Select Id,Title from rfp";
$res= mysqli_query($link,$sql);
if(isset($_GET['inrow']))
{
	$sql = "Update staff_inquiry set IsShown=1 where Id=" . $_GET['inrow'];
	$tres123 = mysqli_query($link,$sql);
	
}

if(isset($_POST['btnSubmit']))
{
    $msg = $_POST['txtMessage'];
    
    $sql="Insert into discussion_chat(Login_Id,Staff_Id,Message, Dom,Tom,Company_Id) values('". $_SESSION['Login_Id'] . "',";
    $sql .= "'" . $_SESSION['UID'] . "','" . $msg . "', '" . date('y-m-d') . "','" . $date . "','" . $_SESSION['CID'] . "' )";
    $res=mysqli_query($link,$sql);
    //echo '<script>window.scrollTo(700); </script>';
	$goToChat=1;
}

//$row = mysqli_fetch_array($res);
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

<script>
	function goToChat()
	{
		//window.scrollTo(700);
		//window.location.href="Dashboard.php?#tf-chat";
		document.frmEntry.txtMessage.focus();
	};
	window.onload = goToChat();
	</script>
</head>

<body <?php if($goToChat==1) echo 'onload="javascript:goToChat()"' ?> >
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
                   <form id="frmEntry" action="Dashboard.php" method="post">
                    <div class="row">
						<div class="row">
                
                  
                    <div class="col-lg-12">
						<div class="col-lg-4">
                <div class="widget style1 lazur-bg ">
                    <div class="row">
                        <div class="col-xs-4">
                           <i class="fa fa-bar-chart-o" style="font-size:5em;color:darkslategray;"></i></a>
                        </div>
                        <div class="col-xs-6 text-center">
                            <span style="font-size:2em;color:darkslategray;">Total Task </span>
                            <h2 class="font-bold" align="center">
							<?php 
								$sql = "Select count(*) from task_master";
								$sql .= " Where Staff_Id=" .$_SESSION['UID'];
								
								$res1 = mysqli_query($link,$sql);
								while($row1 = mysqli_fetch_array($res1))
								echo $row1[0];
							?>
							</h2>
                        </div>
                    </div>
                        </div>
                        </div>
                   
                       <div class="col-lg-4">
                             <div class="ibox float-e-margins">
                    <div class="ibox-title" style="background-color: #293846; color: white;">
                        <h5 >Project List</h5>
                        <div class="ibox-tools" >
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            
                            <!--<a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>-->
                        </div>
                    </div>
                    <div class="ibox-content"  style="background-color:darkgray;" >
 								
                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                   
                    <tbody>
                    <?php
						$sql= "Select Name from team t, project_master p";
						$sql .= " Where Staff_Id=" .$_SESSION['UID'];
						$sql .= " and t.Company_Id=" .$_SESSION['UID'];
						
						$sql .= " and t.Project_Id=p.Id";
						$res = mysqli_query($link,$sql);
						while($row = mysqli_fetch_array($res))
						{
							echo '<tr class="gradeX">';
							echo '<td style="font-size:1em;color:Black;" ><strong>' . $row['Name'] . '</strong></td>';
							echo '</tr>';
					
					
						}
					?>
                    	</tbody>
					</table>
						</div>
                    </div> 
                    </div>
                
                            
            </div>
                             <!-- Iquiry design coding  -->
                        <div class="col-lg-4">
                              
                                    <div class="ibox-title">
                                        <h5>Inquiry List</h5>
                                        <div class="ibox-tools">
                                            <span class="label label-warning-light pull-right"></span>
                                           </div>
                                    </div>
                            <?php
                            $sql="Select s.*, sm.Image, sm.Name as sn from staff_inquiry s, staff_master sm";
                            $sql .=" Where SendTo=".$_SESSION['UID'];
                            $sql .=" and s.Company_Id=".$_SESSION['CID'];
                            $sql .=" and s.Staff_Id=sm.Id";
							$sql .=" and IsShown=0";
							
                            $inres = mysqli_query($link,$sql); 
                            echo ' <div class="ibox-content">';
                            echo ' <div>';
                            echo '  <div class="feed-activity-list">';
                               while($inrow = mysqli_fetch_array($inres))
							{
							   if(!is_null($inrow))
							   { 
                                    echo '<div class="feed-element">';
                                    echo '<a href="#" class="pull-left">';
                                    echo '<img alt="image" class="img-circle" src="'.$inrow['Image'].'">';
                                    echo '</a>';
                                    echo '<div class="media-body ">';
                                    
                                    echo '<a href="Dashboard.php?inrow=' . $inrow['Id'] . '" data-toggle="modal__" data-target="#myModal4__">  <strong>'.$inrow['sn'].'</strong>.</a> <br>';
                                    echo '<small class="text-muted">'.$inrow['Date'].'-'.$inrow['Time'].'</small>';
                                    echo '</div>';
                                    echo '</div>';
                               }
                            }
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';  
                        ?>
                                         

                            </div>
         <div class="ibox float-e-margins"></div>
                           
                        <?php if($_SESSION['Des']=="Admin")
                                {
                        ?>
                       <div class="ibox float-e-margins">
                    
                        <div class="ibox-title">
                            <div class="col-lg-12">
                            <h5>Request For Proposal </h5>
                            </div>
                            <div class="ibox-content">
                                
                        <table class="table table-striped table-bordered table-hover dataTables-example ">
                            <tr>
                                <td>Title</td>
                                <td>Customer Name</td>
                            </tr>
                                    <?php
                    $sql= "Select r.*, c.Name as cn from rfp r, customer_master c";
                    $sql .= " where r.Customer_Id=c.Id";
					$sql .= " and IsActive=1";
					$sql .= " and Closing_Date>'" . date("Y-m-d") . "'";

                    
                    $res= mysqli_query($link,$sql);
       
                              	while($row=mysqli_fetch_array($res))
                                {
                                
                                echo '';
                                echo '<tr>';
                                echo '<td>';
                                //echo '<h5> Request For Purwposal </h5>';
                                echo '<a href="rfp.php?rid=' . $row['Id'] . '">';
								echo '<h5 class="media-heading"><strong>' .$row['Title']. '</strong></h5>';
								echo '</a>';
                                echo '</td>';
                                echo '<td>';
                                echo '<h5 class="media-heading"><strong>' .$row['cn']. '</strong></h5>';
                                echo '</td>';
                                echo '</tr>';
                                echo '';
                               
                                }
                                  
                                ?>
                                </table>
                                </div>
                                </div>
                        </div>
                        <?php 
                                } 
                        ?>
                    <div class="ibox-title" id="tf-chat" >
                        <small class="pull-right text-muted"></small>
                         Chat
                    </div>


                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-md-9 ">
                                <div class="chat-discussion" id="chatDis">

                        <?php
                               $sql="Select d.*, s.*,s.Name as Staff_name ";
								$sql .= " from discussion_chat d, staff_master s ";
								$sql .= " where d.Staff_Id = s.Id ";
								$sql .= " and d.Company_Id=" .$_SESSION['CID'];
								$sql .= " order by d.Id";
								
                               	$res = mysqli_query($link,$sql);
                                while($crow = mysqli_fetch_array($res))
                                {
                                    if($crow['Staff_Id']==$_SESSION['UID'])
                                        echo '<div class="chat-message right">';
                                    else
                                        echo '<div class="chat-message left">';
                                    echo '<img class="message-avatar" src="' . $crow['Image'] . '" alt="" >
                                        <div class="message">';
                                    echo ' <a class="message-author" href="#">' . $crow['Staff_name'] . '</a>';
                                    echo '<span class="message-date">' . $crow['Dom'] . '-' . $crow['Tom'] . '</span>';
                                    echo '<span class="message-content">' . $crow['Message'] . '</span>';
                                    echo '</div>
                                    </div>';
                                }
                          echo '';  
                        ?>
                            
                                       
                                </div>

                            </div>
                            <?php 
							$sql = "Select * from staff_master";
							$sql .= " Where Company_Id=" .$_SESSION['CID'];
							$sres = mysqli_query($link,$sql);
							echo '<div class="col-md-3">';
                            echo '<div class="chat-users">';
                            
							while($srow = mysqli_fetch_array($sres))
							{
							   if(!is_null($srow))
							   {                    
                                echo '<div class="users-list">';
                                echo '<div class="chat-user">';
                                echo  '<img class="chat-avatar" src="' . $srow['Image'] . '" alt="" >';          
                                echo '<div class="chat-user-name">';
								echo '<a href="#">' .$srow['Name']. '</a>';
                                echo '</div>';           
								echo '</div>';
							echo '</div>';
                            	}
                            }
							    echo '</div>';
								echo '</div>';
							?>        
                                    
            
                        </div>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="chat-message-form">

                                    <div class="form-group">
                                                <br>
                                             <div class="input-group input-group-sm" id="asdfg"><textarea name="txtMessage" id="txtMessage" class="form-control"></textarea> <span class="input-group-btn"> 
                                             <a href="#tf-chat">
                                            <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" value="Send">
                                                 </a></span></div>
                                       
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>

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
<!--------------------------------------------------------MOdal Starting---------------------------------------------------------------------------------------------->
   <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
                               <?php
	   									$inId=0;
											if(isset($_GET['inrow']))
											{
												$inId = $_GET['inrow'];
										
										
										$sql = "Select s.*, sm.Name as sn, sm.Image from staff_inquiry s, staff_master sm"; 
										$sql .=" where s.Id=" . $inId;
										$in1res = mysqli_query($link,$sql);
										$in1row = mysqli_fetch_array($in1res);
										echo '<div class="modal-dialog">
                                    <div class="modal-content animated fadeIn">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                         <h4 class="modal-title">INQUIRY DETAILS </h4>
                                         </div>
                                        <div class="modal-body">';
										 echo '<img alt="image" class="img-circle" src="'.$in1row['Image'].'" height="48px" width="48px">';
                                         echo '<h4><strong>Name:-</strong>' . $in1row['sn'] . '</h4>';
										
   										echo '<p><strong>Message:-</strong>' . $in1row['Remark'] . '</p>';
                                            
                                        echo '</div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                           
                                        </div>
                                    </div>
                                </div>';
									}
	   							?>
                                
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
if(isset($_GET['inrow']))
{
	//echo "hi";
	echo "<script>
	$('#myModal4').modal('show');
   
	</script>";

}
if($goToChat==1)
{
	echo "<script>

 document.getElementById('asdfg').scrollIntoView(); 

$('#chatDis').scrollTop($('#chatDis')[0].scrollHeight);
</script>";
}
?>
</body>

<!-- Mirrored from webapplayers.com/inspinia_admin-v2.7.1/dashboard_5.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2017 12:21:52 GMT -->
</html>
