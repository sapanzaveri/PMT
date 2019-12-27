<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    
$FLG_CUSTOMER_ADD = 0;
$FLG_CUSTOMER_VIEW = 0;
$FLG_CUSTOMER_Edit = 0;
$FLG_CUSTOMER_Delete = 0;
$FLG_Staff_ADD = 0;
$FLG_Staff_VIEW = 0;
$FLG_Staff_Edit = 0;
$FLG_Staff_Delete = 0;
$FLG_Technology_Add = 0;
$FLG_Technology_View = 0;
$FLG_Technology_Edit = 0;
$FLG_Technology_Delete = 0;
$FLG_Designation_Add = 0;
$FLG_Designation_View = 0;
$FLG_Designation_Edit = 0;
$FLG_Designation_Delete = 0;
$FLG_Project_Add = 0;
$FLG_Project_View = 0;
$FLG_Project_Edit = 0;
$FLG_Project_Delete = 0;
$FLG_Status_Add = 0;
$FLG_Status_View = 0;
$FLG_Status_Edit = 0;
$FLG_Status_Delete = 0;
$FLG_Task_Add = 0;
$FLG_Task_View = 0;
$FLG_Task_Edit = 0;
$FLG_Task_Delete = 0;
$FLG_ProjectType_Add = 0;
$FLG_ProjectType_View = 0;
$FLG_ProjectType_Edit = 0;
$FLG_ProjectType_Delete = 0;
$FLG_TEAMLEADER_ADD=0;  //For admin
$FLG_TEAM_MEMBER_ADD=0; //For Admin + teamleader
$FLG_TEAM_GENERATION_VIEW=0;    // For all team members in that team
$FLG_TEAM_GENERATION_MODIFY=0;  // Team Leader + 




    include("config.php");
    $sql = "select max(r.IsAllowed) as IsAllowed ,f.Name 
   from role_allocation r,function_master f
   where r.Function_Id=f.Id
   and r.Designation_Id in (Select distinct(Designation_Id) from team where Staff_Id=" . $_SESSION['UID'] . ")";
$sql = $sql . "  group by f.name";
   // echo $sql;
$resFlg = mysqli_query($link,$sql);
if(mysqli_num_rows($resFlg)==0)
{
    $sql = "select max(r.IsAllowed) as IsAllowed ,f.Name 
   from role_allocation r,function_master f
   where r.Function_Id=f.Id
   and r.Designation_Id in (5)";
$sql = $sql . "  group by f.name";
$resFlg = mysqli_query($link,$sql);
}
    while($row_flg=mysqli_fetch_array($resFlg))
    {
        switch ($row_flg['Name']) 
        {
            case 'CustomerAdd':
                $FLG_CUSTOMER_ADD = $row_flg['IsAllowed'];
                break;
            case 'CustomerView':
                $FLG_CUSTOMER_VIEW = $row_flg['IsAllowed'];
                break;
            case 'CustomerEdit':
                $FLG_CUSTOMER_Edit = $row_flg['IsAllowed'];
                break;
            case 'CustomerDelete':
                $FLG_CUSTOMER_Delete = $row_flg['IsAllowed'];
                break;
            case 'StaffAdd':
                $FLG_Staff_ADD = $row_flg['IsAllowed'];
                break;
            case 'StaffView':
                $FLG_Staff_VIEW = $row_flg['IsAllowed'];
                break;
            case 'StaffEdit':
                $FLG_Staff_Edit = $row_flg['IsAllowed'];
                break;
            case 'StaffDelete':
                $FLG_Staff_Delete = $row_flg['IsAllowed'];
                break;
            case 'TechnologyAdd':
                $FLG_Technology_Add = $row_flg['IsAllowed'];
                break;
            case 'TechnologyEdit':
                $FLG_Technology_Edit = $row_flg['IsAllowed'];
                break;
            case 'TechnologyView':
                $FLG_Technology_View = $row_flg['IsAllowed'];
                break;
            case 'TechnologyDelete':
                $FLG_Technology_Delete = $row_flg['IsAllowed'];
                break;
             case 'DesignationAdd':
                $FLG_Designation_Add = $row_flg['IsAllowed'];
                break;
            case 'DesignationEdit':
                $FLG_Designation_Edit = $row_flg['IsAllowed'];
                break;
            case 'DesignationView':
                $FLG_Designation_View = $row_flg['IsAllowed'];
                break;
            case 'DesignationDelete':
                $FLG_Designation_Delete = $row_flg['IsAllowed'];
                break;
            case 'ProjectAdd':
                $FLG_Project_Add = $row_flg['IsAllowed'];
                break;
            case 'ProjectEdit':
                $FLG_Project_Edit = $row_flg['IsAllowed'];
                break;
            case 'ProjectView':
                $FLG_Project_View = $row_flg['IsAllowed'];
                break;
            case 'ProjectDelete':
                $FLG_Project_Delete = $row_flg['IsAllowed'];
                break;
            case 'TaskAdd':
                $FLG_Task_Add = $row_flg['IsAllowed'];
                break;
            case 'TaskEdit':
                $FLG_Task_Edit = $row_flg['IsAllowed'];
                break;
            case 'TaskView':
                $FLG_Task_View = $row_flg['IsAllowed'];
                break;
            case 'TaskDelete':
                $FLG_Task_Delete = $row_flg['IsAllowed'];
                break;
            case 'ProjectTypeAdd':
                $FLG_ProjectType_Add = $row_flg['IsAllowed'];
                break;
            case 'ProjectTypeEdit':
                $FLG_ProjectType_Edit = $row_flg['IsAllowed'];
                break;
            case 'ProjectTypeView':
                $FLG_ProjectType_View = $row_flg['IsAllowed'];
                break;
            case 'ProjectTypeDelete':
                $FLG_ProjectType_Delete = $row_flg['IsAllowed'];
                break;
            case 'TEAMLEADERADD':
                $FLG_TEAMLEADER_ADD= $row_flg['IsAllowed'];
                break;
              case 'TEAMMEMBERADD':
                $FLG_TEAM_MEMBER_ADD= $row_flg['IsAllowed'];
                break;
            case 'TEAMGENERATIONVIEW':
                $FLG_TEAM_GENERATION_VIEW= $row_flg['IsAllowed'];
                break;                                                      
            case 'TEAMGENERATIONMODIFY':
                $FLG_TEAM_GENERATION_MODIFY= $row_flg['IsAllowed'];
                break;
              case 'StatusAdd':
                $FLG_Status_Add= $row_flg['IsAllowed'];
                break;
              case 'StatusEdit':
                $FLG_Status_Edit= $row_flg['IsAllowed'];
                break;
            case 'StatusView':
                $FLG_Status_View= $row_flg['IsAllowed'];
                break;                                                      
            case 'StatusDelete':
                $FLG_sta= $row_flg['IsAllowed'];
                break;    
        }
    }
        

?>