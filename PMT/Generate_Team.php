<?php
session_start();
if(!isset($_SESSION['UName']) || $_SESSION['UName'] == "")
{
header("Location:index.php");

}
include("Role_Prev.php");
if($FLG_TEAM_GENERATION_VIEW<>1)
{
    header("Location:Dashboard.php");
}
$message="";
$messageTL="";
$messageD="";
$messageEx="";
$msgTL="";
$msgD="";
$msgE="";
include("config.php");

//---------------------------------------for team leader ----------------------------------------------->
	if(isset($_POST['btnSubmitTL']))
	{
		
		$teamleader=($_POST['cmbteamleader']);
		$Project = $_POST['cmb_project'];
		$sql = "SElect Id from designation_master where Name='Team Leader'";
		$res = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($res);
		$sql= "SELECT * FROM `team` WHERE Staff_Id='$teamleader' and Designation_Id='".$row['Id']."' and Project_Id='$Project'";
		$sql .= " and Company_Id=" . $_SESSION['CID'];
		$res2= mysqli_query($link,$sql);
		$fetch = mysqli_num_rows($res2);
		if($fetch>=1)
		{
			$msgTL= "Already Available";
		}
		else
		{
		// Code to select the data from team table with same staff id/project id & designation
		// retrive the data and check if there is no. of record is 1 or more
		// if record avaialbel then ignore other wise execute insert into query
		$sql = "INSERT INTO `team`( `Staff_Id`, `Designation_Id`, `Project_Id`, Company_Id)";
		$sql = $sql . " VALUES ('" . $teamleader . "','" . $row['Id'] . "','" . $Project . "','" . $_SESSION['CID'] . "')";
		$res1 = mysqli_query($link,$sql);
		
	}
							
	}
	if(isset($_GET['didTL']))
		{
			$Id=$_GET['didTL'];
			$proj = $_GET['cmb_project'];
			$sql = "Delete from team where Staff_Id=" . $Id;
			$sql = $sql . " and Project_Id=" . $proj;
			$sql = $sql . " and Designation_Id=1";
			$sql .= " and Company_Id=" . $_SESSION['CID'];
			$res = mysqli_query($link,$sql);
			if($res)
				$messageTL = "Record deleted successfully.";
			else
				$messageTL = "Error while deleting record.";
		}

//---------------------------------------for developer-------------------------------------------------->

if(isset($_POST['btnSubmitD']))
	{

		$developer=($_POST['cmbdeveloper']);
		$Project = $_POST['cmb_project'];
		$sql = "SElect Id from designation_master where Name='developer'";

		$res = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($res);
		$sql= "SELECT * FROM `team` WHERE Staff_Id='$developer' and Designation_Id='".$row['Id']."' and Project_Id= '$Project' ";
		$sql .= " and Company_Id=" . $_SESSION['CID'];
		$res2= mysqli_query($link,$sql);
		$fetch = mysqli_num_rows($res2);
		
		if($fetch>=1)
		{
			$msgD= "Already Available ";
		}
		else
		{
		
		$sql = "INSERT INTO `team`( `Staff_Id`, `Designation_Id`, `Project_Id`,Company_Id)";
		$sql = $sql . " VALUES ('" . $developer . "','" . $row['Id'] . "','" . $Project . "','" . $_SESSION['CID'] . "')";
		$res1 = mysqli_query($link,$sql);
		
		}
							
	}

	if(isset($_GET['didD']))
		{
			$Id=$_GET['didD'];
			$proj = $_GET['cmb_project'];
			$sql = "Delete from team where Staff_Id=" . $Id;
			$sql = $sql . " and Project_Id=" . $proj;
			$sql = $sql . " and Designation_Id=2";
			$sql .= " and Company_Id=" . $_SESSION['CID'];
			$res = mysqli_query($link,$sql);
			if($res)
				$messageD = "Record deleted successfully.";
			else
				$messageD = "Error while deleting record.";
		}

	
?>
<?php 
//---------------------------------------for extra-------------------------------------------------->
if(isset($_POST['btnSubmitEx']))
	{
		
		$extra=($_POST['cmbadditional']);
		$Project = $_POST['cmb_project'];
		//$sql = "SElect Id from designation_master where Name= 'tester'";
		$desi = $_POST['cmb_Designation'];
		
		
		$sql= "SELECT * FROM `team` WHERE Staff_Id='$extra' and Designation_Id='$desi' and Project_Id= '$Project' ";
		$sql .= " and Company_Id=" . $_SESSION['CID'];
		$res2= mysqli_query($link,$sql);
		$fetch = mysqli_num_rows($res2);
		
		if($fetch>=1)
		{
			$msgE= "Already Available ";
		}
		else
		{
		$sql = "INSERT INTO `team`( `Staff_Id`, `Designation_Id`, `Project_Id`,Company_Id)";
		$sql = $sql . " VALUES ('" . $extra . "','" . $desi . "','" . $Project . "','" . $_SESSION['CID'] . "')";
		
		$res1 = mysqli_query($link,$sql);
		
		}
							
	}

	if(isset($_GET['did']))
	{
		$Id=$_GET['did'];
		$proj = $_GET['cmb_project'];
		$sql = "Delete from team where Staff_Id=" . $Id;
		$sql = $sql . " and Project_Id=" . $proj;
		$sql = $sql . " and Designation_Id>=3";
		$sql .= " and Company_Id=" . $_SESSION['CID'];
		$res = mysqli_query($link,$sql);
		if($res)
			$messageEX = "Record deleted successfully.";
		else
			$messageEX = "Error while deleting record.";
	}

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Generate Team</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.css" rel="stylesheet">

<link href="css/animate.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<script language="javascript" type="text/javascript">
function ComboClick() {

document.frmEntry.submit();

}
</script>

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


			<div class="row">
	<div class="col-lg-12">
    
	   <form id="frmEntry" name="frmEntry" method="post" action="Generate_Team.php">
		<div class="ibox float-e-margins">
					<div class="ibox-content">
			
						<div class="row" >
							 <div class="form-group">
							 <?php echo $message; ?>
							
							<br>
							 
							
							 <label class="col-md-2 col-md-offset-3 control-label"><strong>Project Name</strong></label>
						<div class="col-sm-4" ><select class="form-control m-b" name="cmb_project" id="cmb_project" onChange="ComboClick();">
					   	<option	 value="0">--- Select Project ---</option>
						   <?php

							$sql = "Select * from project_master ";
							$sql = $sql . " Where 1=1 ";
                            if($_SESSION['Des']<>"Admin")
                            {
                                $sql .= " and Id in (Select Project_Id from Team where Staff_Id=" . $_SESSION['UID'] . ")";
                          // echo $sql;
                            }
                            $sql .= " and Company_Id=" . $_SESSION['CID'];
								$sql .= " order by Name";
							echo $sql;
							$dres = mysqli_query($link,$sql);
							while($drow = mysqli_fetch_array($dres))
							{
								//echo '<Option value="' . $drow['Id'] . '" ';

								echo '<option value="' . $drow['Id'] . '" ';
								if(isset($_REQUEST['cmb_project']) && $_REQUEST['cmb_project']==$drow['Id'])
									echo ' selected="Selected" ';
								echo '>' . $drow['Name'] . '</option>';

							}

							?>
							</select>	
								 </div></div></div></div>
							<div class="table table-striped">
<!--------------------------------------Team Leader COdeing--------------------------------------------->
						<br> 
						
						<div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5> <strong>Team Leader </strong></h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                               
                               
                            </div>
                        </div>
                        <div class="ibox-content">
                            
						<div class="col-lg-5">  <label>Team Leader Name</label>
						<!--</div> -->
						<?php if(isset($_REQUEST['cmb_project']) && $_REQUEST['cmb_project']<>0)
						{ ?>
							</div>
					  		<div class="col-lg-offset-11">
                            <?php
                                //Code to check whether designation is TeamLeader for the selected project or not??
                                $sql = "Select Designation_Id from Team where Project_Id=" . $_REQUEST['cmb_project'];
                                $sql .= " and Staff_Id=" . $_SESSION['UID'];
                                $sql .= " and Company_Id=" . $_SESSION['CID'];
							$tlRes = mysqli_query($link,$sql);
                                if(mysqli_num_rows($tlRes)>=1)
                                {
                                    $tmRow = mysqli_fetch_array($tlRes);
                                    if($tmRow['Designation_Id']==1 )
                                    echo '<input type="button" class="btn btn-primary"  name="btnSubmit" id="btnSubmit" value="ADD" data-toggle="modal" data-target="#teamleader">';
                                }
                                elseif( $_SESSION['Des']=="Admin")
                                    echo '<input type="button" class="btn btn-primary"  name="btnSubmit" id="btnSubmit" value="ADD" data-toggle="modal" data-target="#teamleader">';
						  ?>
							</div>
<!-- Modal -->				
							<div id="teamleader" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
							  <!--<form method="post" action="Generate_Team.php"> -->
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Team Leader</h4>
								  </div>
								  <div class="modal-body">
									
									<body>
									 <?php
										$sql = "Select Id, Name from staff_master ";
										$sql .= " Where Id not in(select Staff_Id from team where ";
										$sql .= " Project_Id= " . $_REQUEST['cmb_project'] . ")";
										$sql .= " and Designation_Id<>(Select Id from designation_master ";
										$sql .= " Where Name='Admin') ";
										$sql .= " and Company_Id=" . $_SESSION['CID'];
										$sql .= " order by Name";
										
										$dres = mysqli_query($link,$sql);
										if (mysqli_num_rows($dres) > 0)
										{
											?>
									<div>
										<label> Add Team Leader</label>
										
										<div><select class="form-control m-b" name="cmbteamleader" id="cmbteamleader">
										<?php	 
										while($drow = mysqli_fetch_array($dres))
										{
											echo '<Option value="' . $drow['Id'] . '" ';
											//if($Id <>0 && $row['Designation_Id'] == $drow['Id'])
												//echo " Selected=selected ";
											echo ' >' . $drow['Name'] . '</option>';
											
										}
									?>
										</select></div>
									</div>
									</body>
								  </div>
								  <div class="modal-footer">
								  
								  <input type="submit" id="btnSubmitTL" name="btnSubmitTL" class="btn btn-default" >
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								   <?php
								}
									else 
										echo 'No more Staff Free for this Project.';
									?>
								  </div>
								  <!--</form>-->
								</div>

							  </div>
							</div>
						<div class="form-group ">
							<table class="table table-striped">

								<!--<thead>

							   <tr>
									<td>Team_Leader Name </td>

								</tr>
								</thead>-->
								<tbody> 
								<?php }
					
										else
											echo '</div>';
								?>
								<br>
								<?php echo $msgTL; echo $messageTL;?>
					<?php
					if(isset($_REQUEST['cmb_project']))
					{
						$sql = "select t.Staff_Id , s.Name from team t , staff_master s";
						
						$sql .= " where t.Staff_Id = s.Id ";
						$sql .= " and t.Company_Id=" . $_SESSION['CID'];
						$sql .= " and t.Designation_Id= (select Id from designation_master where Name='Team Leader')";
						
						if(isset($_REQUEST['cmb_project'])) 
						$sql = $sql . " and Project_Id=" . $_REQUEST['cmb_project'];
					
						$res = mysqli_query($link,$sql);
						while($row = mysqli_fetch_array($res))
						{
							echo '<tr>';
							echo '<td>' . $row['Name'] .'</td>';
						
							$sql = "Select Designation_Id from Team where Project_Id=" . $_REQUEST['cmb_project'];
                            $sql .= " and Staff_Id=" . $_SESSION['UID'];
                            $sql .= " and Company_Id=" . $_SESSION['CID'];    
							$tlRes = mysqli_query($link,$sql);
                                if(mysqli_num_rows($tlRes)>=1)
                                {
                                    $tmRow = mysqli_fetch_array($tlRes);
                                    if($tmRow['Designation_Id']==1 )
                     echo '<td> <a onClick="javascript:deleteconfigTL(' . $row['Staff_Id'] . ',' . $_REQUEST['cmb_project'] . ');" ><i class="fa fa-trash col-lg-offset-10" style=font-size:1.5em;color:red;>  </i></a></td>';

                                }
                                elseif( $_SESSION['Des']=="Admin")
                      echo '<td> <a onClick="javascript:deleteconfigTL(' . $row['Staff_Id'] . ',' . $_REQUEST['cmb_project'] . ');" ><i class="fa fa-trash col-lg-offset-10" style=font-size:1.5em;color:red;>  </i></a></td>';

									
												echo '</tr>';
						}
					}

			?>
							</tbody>
							</table>
			</div>
                        </div>
                    </div>
                </div>
						

<!-- ------------------------------------developer codeing---------------------------------------------->
			
				<div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5> <strong>Developer</strong> </h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                
                               
                             
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="col-lg-3">  <label>Developer Name </label>
                            <!-- </div> -->
						
						<?php if(isset($_REQUEST['cmb_project']) && $_REQUEST['cmb_project']<>0)
						{ ?> 
							</div>
					  		<div class="col-lg-offset-10">
                                <?php
                                //Code to check whether designation is TeamLeader for the selected project or not??
                                $sql = "Select Designation_Id from Team where Project_Id=" . $_REQUEST['cmb_project'];
                                $sql .= " and Staff_Id=" . $_SESSION['UID'];
							$sql .= " and Company_Id=" . $_SESSION['CID'];
                                $tlRes = mysqli_query($link,$sql);
                                if(mysqli_num_rows($tlRes)>=1)
                                {
                                    $tmRow = mysqli_fetch_array($tlRes);
                                    if($tmRow['Designation_Id']==1 || $_SESSION['Des']=="Admin")
                                    echo '<input type="button" class="btn btn-primary"  name="btnSubmitDe" id="btnSubmitDe" value="ADD" data-toggle="modal" data-target="#developer">';
                                }
                                     elseif( $_SESSION['Des']=="Admin")
                                    echo '<input type="button" class="btn btn-primary"  name="btnSubmit" id="btnSubmit" value="ADD" data-toggle="modal" data-target="#developer">';
						  ?>
						  
							</div>
<!-- Modal -->
							<div id="developer" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
							  <!--<form method="post" action="Generate_Team.php">-->
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Developer</h4>
								  </div>
								  <div class="modal-body">
									
									<body> 
									<?php
										$sql = "Select Id, Name from staff_master ";
									$sql .= " Where Id not in(select Staff_Id from team where ";
									$sql .= " Project_Id= " . $_REQUEST['cmb_project'] . ")";
									$sql .= " and Designation_Id<>(Select Id from designation_master ";
									$sql .= " Where Name='Admin')  ";
							$sql .= " and Company_Id=" . $_SESSION['CID'];
							$sql .= " order by Name";
										$dres = mysqli_query($link,$sql);
								if(mysqli_num_rows($dres) > 0)
								{
									?>
									<div>
										<label> Add Developer</label>
										<div><select class="form-control m-b" name="cmbdeveloper" id="cmbdeveloper">
									<?php
										while($drow = mysqli_fetch_array($dres))
										{
											echo '<Option value="' . $drow['Id'] . '" ';
											echo ' >' . $drow['Name'] . '</option>';
											
										}
									?>
										</select></div>
									</div>
									</body>
								  </div>
								  <div class="modal-footer">
								  
								  <input type="submit" id="btnSubmitD" name="btnSubmitD" class="btn btn-default">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								  <?php
								}
									else 
										echo 'No more Staff Free for this Project.';
									?>
								  </div>
								  <!--</form>-->
								</div>

							  </div>
							</div>
						 <div class="form-group ">
							<table class="table table-striped">

								<!--<thead>
								<tr>
								   <td>Developer Name </td>

								</tr>

								</thead>-->
								<tbody>
								<?php }
								
										else
											echo '</div>';
								?>
								<br>
								<?php echo $msgD;  echo $messageD;?>
							<?php
								if(isset($_REQUEST['cmb_project']))
								{
							$sql = "Select team.Staff_Id , staff_master.Name  from team";
							$sql .=" INNER JOIN staff_master ON team.Staff_Id = staff_master.Id ";
							$sql .= " Where team.Designation_Id= (select Id from designation_master where Name='developer')";
							$sql .= " and team.Company_Id=" . $_SESSION['CID'];		//Keyur
							if(isset($_REQUEST['cmb_project'])) 
							$sql = $sql . " and Project_Id=" . $_REQUEST['cmb_project'];
								

							$res = mysqli_query($link,$sql);
							while($row = mysqli_fetch_array($res))
									{
										echo '<tr>';
										echo '<td>' . $row['Name'] . '</td>';
								$sql = "Select Designation_Id from Team where Project_Id=" . $_REQUEST['cmb_project'];
                                $sql .= " and Staff_Id=" . $_SESSION['UID'];
								$sql .= " and Company_Id=" . $_SESSION['CID'];
                                $tlRes = mysqli_query($link,$sql);
                                if(mysqli_num_rows($tlRes)>=1)
                                {
                                    $tmRow = mysqli_fetch_array($tlRes);
                                    if($tmRow['Designation_Id']==1 )
                                echo '<td> <a onClick="javascript:deleteconfigD(' . $row['Staff_Id'] . ','         . $_REQUEST['cmb_project'] . ');" ><i class="fa fa-trash col-lg-offset-10" style=font-size:1.5em;color:red;>  </i></a></td>';

                                }
                                elseif( $_SESSION['Des']=="Admin")
                            echo '<td> <a onClick="javascript:deleteconfigD(' . $row['Staff_Id'] . ','         . $_REQUEST['cmb_project'] . ');" ><i class="fa fa-trash col-lg-offset-10" style=font-size:1.5em;color:red;>  </i></a></td>';
						
										echo '</tr>';

									}	
								}
							?>
							</tbody>
							</table>
			</div></div>
                        </div>
                    </div>
                
						
						
			
						
<!----------------------------------------------ADDITIONAL--------------------------------------------------->
		   
		   <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5> <strong>Additional</strong> </h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                
                               
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="col-lg-3">  <label> Additional  Name </label>
                            <!-- </div> -->
							<?php if(isset($_REQUEST['cmb_project']) && $_REQUEST['cmb_project']<>0)
						{ ?>
							</div> 
					  		<div class="col-lg-offset-10">
                                 <?php
                                //Code to check whether designation is TeamLeader for the selected project or not??
                                $sql = "Select Designation_Id from Team where Project_Id=" . $_REQUEST['cmb_project'];
                                $sql .= " and Staff_Id=" . $_SESSION['UID'];
							$sql .= " and Company_Id=" . $_SESSION['CID'];
                                $tlRes = mysqli_query($link,$sql);
                                if(mysqli_num_rows($tlRes)>=1)
                                {
                                    $tmRow = mysqli_fetch_array($tlRes);
                                    if($tmRow['Designation_Id']==1 || $_SESSION['Des']=="Admin")
                                    echo '<input type="button" class="btn btn-primary"  name="btnSubmitextra" id="btnSubmitextra" value="ADD" data-toggle="modal" data-target="#extra">';
                                }
                                 elseif( $_SESSION['Des']=="Admin")
                                    echo '<input type="button" class="btn btn-primary"  name="btnSubmit" id="btnSubmit" value="ADD" data-toggle="modal" data-target="#extra">';
						  ?>
						  
						 
							</div>
<!-- Modal -->
							<div id="extra" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
							  <!--<form method="post" action="Generate_Team.php">-->
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Additional</h4>
								  </div>
								  <div class="modal-body">
									
									<body>
									<?php
								$sql = "Select Id, Name from staff_master";
								$sql .= " Where Id not in(select Staff_Id from team where ";
								$sql .= " Project_Id= " . $_REQUEST['cmb_project'] . ") ";
								$sql .= " and Designation_Id<>(Select Id from designation_master ";
								$sql .= " Where Name='Admin') ";
							$sql .= " and Company_Id=" . $_SESSION['CID'];
							$sql .= " order by Name";
							//echo $sql;
										$dres = mysqli_query($link,$sql);
							
									if(mysqli_num_rows($dres) > 0)
									{
									 ?>
									<div>
										<label> Additional</label>
										<div><select class="form-control m-b" name="cmbadditional" id="cmbadditional">
										<?php
										while($drow = mysqli_fetch_array($dres))
										{
											echo '<Option value="' . $drow['Id'] . '" ';
											echo ' >' . $drow['Name'] . '</option>';
											
										}
							
									?>
										</select></div>
										</div>
										<div>
										<label> Designation</label>
										<div><select class="form-control m-b" name="cmb_Designation" id="cmb_Designation">
									<?php
										$sql = "Select Id, Name from Designation_master ";
										$sql .=" Where Id>=3";
										$dres = mysqli_query($link,$sql);
										while($drow = mysqli_fetch_array($dres))
										{
											echo '<Option value="' . $drow['Id'] . '" ';
											echo ' >' . $drow['Name'] . '</option>';
											
										}
							
									?>
										</select></div>
									</div>
									
									</body>
								  </div>
								  <div class="modal-footer">
								  
								  <input type="submit" id="btnSubmitEx" name="btnSubmitEx" class="btn btn-default" >
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								  <?php
								}
									else 
										echo 'No more Staff Free for this Project.';
									?>
								  </div>
								  
								  <!--</form>-->
								</div>

							  </div>
							</div>
							
						 <div class="form-group ">
							<table class="table table-striped">

								<!-- <thead>

								<tr>
									<td> Extra </td>

								</tr>

								</thead>-->
								<tbody>
								<?php }
					
										else
											echo '</div>';
								?>
								<br>
								<?php echo $msgE; echo $messageEx; ?> 
								<?php
								if(isset($_REQUEST['cmb_project']))
								{
						//$sql = "Select team.Staff_Id , staff_master.Name,team.Designation_Id,d.Name as Desi from  designation_master d, team INNER JOIN staff_master ON team.Staff_Id = staff_master.Id ";
						//$sql = $sql . " Where team.Designation_Id in (select Id from designation_master where Name not in ('Team Leader','developer') )";
						//if(isset($_REQUEST['cmb_project'])) 
						//$sql = $sql . " and Project_Id=" . $_REQUEST['cmb_project'];
						//$sql = $sql . " and d.Id = team.Designation_Id ";
						$sql = "Select t.Staff_Id , sm.Name,t.Designation_Id,d.Name as Desi from  designation_master d, team t, staff_master sm where t.Staff_Id = sm.Id ";
						$sql = $sql . " and d.Id in (select Id from designation_master d1 where d1.Name not in ('Team Leader','developer') )";
						if(isset($_REQUEST['cmb_project'])) 
						$sql = $sql . " and Project_Id=" . $_REQUEST['cmb_project'];
						$sql = $sql . " and d.Id = t.Designation_Id ";
						$sql .= " and t.Company_Id=" . $_SESSION['CID'];
									//echo $sql;
						$res = mysqli_query($link,$sql);
						while($row = mysqli_fetch_array($res))
										{
											echo '<tr>';
											echo '<td>' . $row['Name'] . '</td>';
											echo '<td>' . $row['Desi']  . '</td>';
							$sql = "Select Designation_Id from Team where Project_Id=" . $_REQUEST['cmb_project'];
                                $sql .= " and Staff_Id=" . $_SESSION['UID'];
                                $sql .= " and Company_Id=" . $_SESSION['CID'];
											$tlRes = mysqli_query($link,$sql);
                                if(mysqli_num_rows($tlRes)>=1)
                                {
                                    $tmRow = mysqli_fetch_array($tlRes);
                                    if($tmRow['Designation_Id']==1 )
                                echo '<td> <a onClick="javascript:deleteconfig(' . $row['Staff_Id'] . ','         . $_REQUEST['cmb_project'] . ');" ><i class="fa fa-trash col-lg-offset-10" style=font-size:1.5em;color:red;>  </i></a></td>';

                                }
                                elseif( $_SESSION['Des']=="Admin")
                            echo '<td> <a onClick="javascript:deleteconfig(' . $row['Staff_Id'] . ','         . $_REQUEST['cmb_project'] . ');" ><i class="fa fa-trash col-lg-offset-10" style=font-size:1.5em;color:red;>  </i></a></td>';
						
											
											echo '</tr>';

										}
								}
					?>
								</tbody>
							</table>
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


<script type="text/javascript">
   //------DELETE FUNCTION---------//
	   //-----------------team leader
	   function deleteconfigTL(tmpTL,proj)
    {
      var TL = confirm("Are you sure you want to delete?");
      if (TL==true)
		  {
			 window.location="Generate_Team.php?didTL=" + tmpTL + "&cmb_project=" + proj;
			  //alert("Record Deleted Sucessful");
		  }
          
      else
       {
			  //alert("Not Record Deleted");
		 }
    }
	   //-----------------developer
	    function deleteconfigD(tmpD,proj)
    {
      var D = confirm("Are you sure you want to delete?");
      if (D==true)
		  {
			 window.location="Generate_Team.php?didD=" + tmpD + "&cmb_project=" + proj;
			  //alert("Record Deleted Sucessful");
		  }
          
      else
       {
			  //alert("Not Record Deleted");
		 }
    }
	   //---------------additional 
	    function deleteconfig(tmp,proj)
    {
      var x = confirm("Are you sure you want to delete?");
      if (x==true)
		  {
			  window.location="Generate_Team.php?did=" + tmp + "&cmb_project=" + proj;
			  //alert("Record Deleted Sucessful");
		  }
          
      else
       {
			  //alert("Not Record Deleted");
		 }
    }
</script> 








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
