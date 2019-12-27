<?php
	session_start();
	if(!isset($_SESSION['UName']) || $_SESSION['UName'] == "")
	{
		header("Location:index.php");
	}
include('config.php');
$sql= "Select Id,Title from rfp";
$res= mysqli_query($link,$sql);

if(isset($_POST['btnSubmit']))
{
    $msg = $_POST['txtMessage'];
    
    $sql="Insert into discussion_chat(Login_Id,Staff_Id,Message, Dom,Tom) values('". $_SESSION['Login_Id'] . "',";
    $sql .= "'" . $_SESSION['UID'] . "','" . $msg . "', '" . date('y-m-d') . "','" . date('h:i') . "')";
    $res=mysqli_query($link,$sql);
    
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
                   <form id="frmEntry" action="Chat.php" method="post">
                    <div class="row">
						<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        
                               <h2>Welcome To Project Management Tool</h2> 
                        <br>
                        <div class="ibox-title">
                            <h5>Request For Purposal </h5>
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
                    //echo $sql;
                    $res= mysqli_query($link,$sql);
       
                              	while($row=mysqli_fetch_array($res))
                                {
                                
                                echo '';
                                echo '<tr>';
                                echo '<td>';
                                //echo '<h5> Request For Purposal </h5>';
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
                                 

                    <div class="ibox-title">
                        <small class="pull-right text-muted">Last message:  Mon Jan 26 2015 - 18:39:23</small>
                         Chat room panel
                    </div>


                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-md-9 ">
                                <div class="chat-discussion">

                        <?php
                               $sql="Select d.*, s.*,s.Name as Staff_name ";
								$sql .= " from discussion_chat d, staff_master s ";
								$sql .= " where d.Staff_Id = s.Id ";
								$sql .= " order by d.Id";
								echo $sql;
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
                                    echo '<span class="message-date">' . $crow['Dom'] . ':' . $crow['Tom'] . '</span>';
                                    echo '<span class="message-content">' . $crow['Message'] . '</span>';
                                    echo '</div>
                                    </div>';
                                }
                          echo '';  
                        ?>
                            
                                       
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="chat-users">


                                    <div class="users-list">
                                        <div class="chat-user">
                                            <img class="chat-avatar" src="img/a4.jpg" alt="" >
                                            <div class="chat-user-name">
                                                <a href="#">Karl Jordan</a>
                                            </div>
                                        </div>
                                        <div class="chat-user">
                                            <img class="chat-avatar" src="img/a1.jpg" alt="" >
                                            <div class="chat-user-name">
                                                <a href="#">Monica Smith</a>
                                            </div>
                                        </div>
                                        

                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="chat-message-form">

                                    <div class="form-group">

                                             <div class="input-group input-group-sm"><textarea name="txtMessage" id="txtMessage" class="form-control"></textarea> <span class="input-group-btn"> 
                                            <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" value="Send">
                                                 </span></div>
                                       
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
<div class="small-chat-box fadeInRight animated">

        <div class="heading" draggable="true">
            <small class="chat-date pull-right">
                02.19.2015
            </small>
         chat
        </div>

        <div class="content">

            <div class="left">
                <div class="author-name">
                    Monica Jackson <small class="chat-date">
                    10:02 am
                </small>
                </div>
                <div class="chat-message active">
                    Lorem Ipsum is simply dummy text input.
                </div>

            </div>
            <div class="right">
                <div class="author-name">
                    Mick Smith
                    <small class="chat-date">
                        11:24 am
                    </small>
                </div>
                <div class="chat-message">
                    Lorem Ipsum is simpl.
                </div>
            </div>
            <div class="left">
                <div class="author-name">
                    Alice Novak
                    <small class="chat-date">
                        08:45 pm
                    </small>
                </div>
                <div class="chat-message active">
                    Check this stock char.
                </div>
            </div>
            <div class="right">
                <div class="author-name">
                    Anna Lamson
                    <small class="chat-date">
                        11:24 am
                    </small>
                </div>
                <div class="chat-message">
                    The standard chunk of Lorem Ipsum
                </div>
            </div>
            <div class="left">
                <div class="author-name">
                    Mick Lane
                    <small class="chat-date">
                        08:45 pm
                    </small>
                </div>
                <div class="chat-message active">
                    I belive that. Lorem Ipsum is simply dummy text.
                </div>
            </div>


        </div>
        <div class="form-chat">
            <div class="input-group input-group-sm"><input type="text" class="form-control"> <span class="input-group-btn"> <button
                    class="btn btn-primary" type="button">Send
            </button> </span></div>
        </div>

    </div>
    <div id="small-chat">

        <span class="badge badge-warning pull-right">5</span>
        <a class="open-small-chat">
            <i class="fa fa-comments"></i>

        </a>
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
