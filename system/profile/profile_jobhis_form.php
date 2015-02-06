<?php
$path = "../../";
include($path."include/config_header_top.php");
  
$link = "r=home&menu_id=".$menu_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
//page back
if($PT_ID=="2"){
	$page_back = "profile_his_empser.php";
	$POSTYPE_ID = '3';
}elseif($PT_ID=="3"){
	$page_back = "profile_his_emp.php";
	$POSTYPE_ID = '5';
}else{
	$page_back = "profile_his_disp.php";
	$POSTYPE_ID = '1';
}
$paramlink = url2code($link);

//POST
$PER_ID=$_POST['PER_ID'];
$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 

//DATA
$sql = "SELECT * FROM PER_JOBHIS  where DELETE_FLAG = '0' AND JOH_ID = '".$JOH_ID."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

##------------------- ข้าราชการ ------------------------##
//ประเภทข้าราชการ
$arr_ct_type =  GetSqlSelectArray("CV_ID","CV_NAME_TH","ANNOUNCE_SETUP_CIVIL_TYPE","ACTIVE_STATUS='1' and DELETE_FLAG='0' ","CV_NAME_TH");
//กระทรวง
$arr_org1 = GetSqlSelectArray("ORG_ID","ORG_NAME_TH","SETUP_ORG","OL_ID = '2' and ACTIVE_STATUS=1 and DELETE_FLAG='0' ","ORG_SEQ" );
//สำนัก
$arr_org3 = GetSqlSelectArray("ORG_ID","ORG_NAME_TH","SETUP_ORG","ACTIVE_STATUS = 1 and DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$rec['ORG_ID_2']."'","ORG_SEQ" );
//สายงาน
$arr_line_group = GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND TYPE_ID = '".$rec['TYPE_ID']."' ", "LG_NAME_TH");
//ระดับ
$arr_level_gov =  GetSqlSelectArray("LEVEL_ID","LEVEL_NAME_TH","SETUP_POS_LEVEL","ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '1' AND TYPE_ID = '".$rec['TYPE_ID']."' ","LEVEL_SEQ");
//ตำแหน่งในสายงาน
$arr_line_gov = GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND LG_ID = '".$rec['LG_ID']."' ", "LINE_NAME_TH");


##------------------- พนักงานราชการ ------------------------##
//ประเภทพนักงานข้าราชการ
$arr_type_gov_emp =  GetSqlSelectArray("TYPE_ID","TYPE_NAME_TH","SETUP_POS_TYPE","ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '3' ","TYPE_SEQ");
//ประเภทกลุ่ม (พนักงานราชการ)
$arr_level_gov_emp =  GetSqlSelectArray("LEVEL_ID","LEVEL_NAME_TH","SETUP_POS_LEVEL","ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '3' AND TYPE_ID = '".$rec['TYPE_ID']."' ","LEVEL_SEQ");
//ตำแหน่งในสายงาน
$arr_line_gov_emp = GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND POSTYPE_ID = '3' ", "LINE_NAME_TH");


##------------------- ลูกจ้างประจำ ------------------------##
$arr_type_emp = GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND POSTYPE_ID = '5' ", "TYPE_SEQ");
$arr_line_emp = GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND POSTYPE_ID = '5' AND TYPE_ID = '".$rec['TYPE_ID']."'", "LINE_NAME_TH");
$arr_sjob=GetSqlSelectArray("JOB_ID", "JOB_NAME_TH", "V_SETUP_JOB", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "JOB_NAME_TH");//อาชีพ
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/chosen.css" rel="stylesheet">
<script src="<?php echo $path; ?>bootstrap/js/jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/transition.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/holder.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/collapse.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/dropdown.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/modal.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/carousel.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/respond.min.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/html5shiv.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/chosen.jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_jobhis_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
      <li><a href="profile_jobhis_disp.php?<?php echo url2code($link2); ?>">ประวัติประสบการณ์การทำงาน</a></li>
	  <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" ><br>
	<?php include ("tab_info.php"); ?>

      <form id="frm-input" method="post" action="process/profile_jobhis_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        <input type="hidden" id="JOH_ID" name="JOH_ID"  value="<?php echo $JOH_ID; ?>">
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ลำดับที่:</div>
            <div class="col-xs-12 col-sm-2"><input type="text" id="JOH_SEQ" name="JOH_SEQ" class="form-control" placeholder="ลำดับที่" maxlength="255"  value="<?php echo $rec["JOH_SEQ"];?>" style="width:100px;" ></div>        
            <div class="col-xs-12 col-sm-2"></div>
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">ประเภทอาชีพ : <span style="color:red;">*</span>&nbsp; </div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect("JOH_JOB_TYPE", "JOH_JOB_TYPE", $arr_type_job, "ประเภทอาชีพ", $rec['JOH_JOB_TYPE'],"onchange=\"GetDetail(this.value);\"","","","300","2"); ?></div>
            <div class="col-xs-12 col-sm-1"></div>
                <span id="shw_job_other">
                    <div class="col-xs-12 col-sm-2 ">โปรดระบุ : </div>
                    <div class="col-xs-12 col-sm-3"><input type="text" name="JOB_EJOB_NAME" id="JOB_EJOB_NAME" value="<?php echo text($rec['JOB_EJOB_NAME']);?>" class="form-control" placeholder="โปรดระบุ"></div>
                </span>
            </div>
      
       <!------------ข้าราชการ---------------------------------------------------------------->      
        <span id = "gov" >
           <div class="row formSep">
                <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทข้าราชการ : </div>
                <div class="col-xs-12 col-sm-3"><?php echo GetHtmlSelect('CV_ID','CV_ID', $arr_ct_type , 'ประเภทข้าราชการ', $rec['CV_ID'],'','','','300','1'); ?></div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">กระทรวง : </div>
                <div class="col-xs-12 col-sm-3"><?php echo GetHtmlSelect('GOV_ORG_ID_1','GOV_ORG_ID_1', $arr_org1 , 'กระทรวง', $rec['ORG_ID_1'],"onChange=\"get_gov_org2(this.value);\"",'','','300','1'); ?></div>
            </div>
            
            <div class="row formSep">
                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">กรม : </div>
                <div class="col-xs-12 col-sm-3">
                    <select id="GOV_ORG_ID_2" name="GOV_ORG_ID_2" class="selectbox form-control" placeholder="กรม" onChange="get_gov_org3(this.value);" style="width:300px;">
                        <option value=""></option>
                        <?php
                        $sql_org_name = "SELECT ORG_ID, ORG_NAME_TH FROM SETUP_ORG WHERE ACTIVE_STATUS = 1 AND ORG_PARENT_ID = '".$rec['ORG_ID_1']."' AND DELETE_FLAG = 0 ORDER BY ORG_SEQ ASC";
                        $query_org_name = $db->query($sql_org_name);
                        $select_type[$rec['ORG_ID_2']] = "Selected='Selected'";
                        while($type = $db->db_fetch_array($query_org_name)){
                            echo '<option value="'.$type['ORG_ID'].'" '.$select_type[$type['ORG_ID']].' >'.text($type['ORG_NAME_TH']).'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">สำนัก/กอง : </div>
                <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('GOV_ORG_ID_3','GOV_ORG_ID_3', $arr_org3 , 'สำนัก/กอง',$rec['ORG_ID_3'],"onChange=\"get_gov_org4(this.value);\"",'','','300','1'); ?></div>
             </div>
            
             <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ต่ำกว่าสำนัก/กอง 1 ระดับ<br>(ส่วน/กลุ่ม/กลุ่มงาน) : </div>
                <div class="col-xs-12 col-md-3">
                    <select id="GOV_ORG_ID_4" name="GOV_ORG_ID_4" class="selectbox form-control" placeholder="กลุ่มงาน" onChange="get_gov_org5(this.value);" style="width:300px;">
                        <option value=""></option>
                        <?php
                        $sql_org_4 = "SELECT ORG_ID, ORG_NAME_TH FROM SETUP_ORG WHERE ACTIVE_STATUS = 1 AND ORG_PARENT_ID = '".$rec['ORG_ID_3']."' ORDER BY ORG_SEQ ASC";
                        $query_org_4 = $db->query($sql_org_4);
                        $select_org_4[$rec['ORG_ID_4']] = "Selected='Selected'";
                        while($org = $db->db_fetch_array($query_org_4)){
                            echo '<option value="'.$org['ORG_ID'].'" '.$select_org_4[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ต่ำกว่าสำนัก/กอง 2 ระดับ<br>(ฝ่าย) : </div>
                <div class="col-xs-12 col-md-3">
                    <select id="GOV_ORG_ID_5" name="GOV_ORG_ID_5" class="selectbox form-control" placeholder="ฝ่าย" style="width:300px;">
                        <option value=""></option>
                        <?php
                        $sql_org_4 = "SELECT ORG_ID, ORG_NAME_TH FROM SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$rec['ORG_ID_3']."' ORDER BY ORG_SEQ ASC";
                        $query_org_4 = $db->query($sql_org_4);
                        $select_org_4[$data['ORG_ID_4']] = "Selected='Selected'";
                        while($org = $db->db_fetch_array($query_org_4)){
                            echo '<option value="'.$org['ORG_ID'].'" '.$select_org_4[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
                        }
                        ?>
                    </select>
                </div>                            
             </div>
            
             <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทตำแหน่ง : </div>
                <div class="col-xs-12 col-md-3">
                    <select id="GOV_TYPE_ID" name="GOV_TYPE_ID" class="selectbox form-control" placeholder="ประเภทตำแหน่ง" onChange="get_gov_level(this); get_gov_line_group(this);" style="width:300px;">
                        <option value=""></option>
                        <?php
                        $sql_type_name = "Select TYPE_ID , TYPE_NAME_TH From SETUP_POS_TYPE WHERE ACTIVE_STATUS = 1 AND POSTYPE_ID = '1' AND DELETE_FLAG = 0 ORDER BY TYPE_SEQ ASC";
                        $query_type_name = $db->query($sql_type_name);
                        $select_type[$rec['TYPE_ID']] = "Selected='Selected'";
                        while($type = $db->db_fetch_array($query_type_name)){
                            echo '<option value="'.$type['TYPE_ID'].'" '.$select_type[$type['TYPE_ID']].' >'.text($type['TYPE_NAME_TH']).'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" >สายงาน : </div>
                <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('GOV_LG_ID', 'GOV_LG_ID', $arr_line_group, 'สายงาน' ,$rec['LG_ID'] ,'onChange="get_gov_line(this);"', '', '', '300', '1'); ?></div>
            </div>
            
            <div class="row formSep">
                <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ตำแหน่งในสายงาน : </div>
                <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('GOV_LINE_ID', 'GOV_LINE_ID',$arr_line_gov, 'ตำแหน่งในสายงาน' ,$rec['LINE_ID'] ,'', '', '', '300', '1'); ?></div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" >ระดับ : </div>
                <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('GOV_LEVEL_ID', 'GOV_LEVEL_ID',$arr_level_gov , 'ระดับ' ,$rec['LEVEL_ID'] ,'','', '', '300', '1'); ?></div>
            </div>
             
            <div class="row formSep">
                <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่บรรจุเข้ารับราชการ : </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="input-group">
                        <input type="text" id="GOV_CJOH_SDATE" name="GOV_CJOH_SDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($rec["JOH_SDATE"]);?>">
                        <span class="input-group-addon datepicker" for="GOV_CJOH_SDATE" >&nbsp;
                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                        </span>
                    </div>
                </div> 
                <div class="col-xs-12 col-sm-1"></div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" >วันที่ออกจากงาน : </div>
                    <div class="col-xs-12 col-sm-2">
                    <div class="input-group">
                        <input type="text" id="GOV_CJOH_EDATE" name="GOV_CJOH_EDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($rec["JOH_EDATE"]);?>">
                        <span class="input-group-addon datepicker" for="GOV_CJOH_EDATE" >&nbsp;
                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                        </span>
                    </div>
                </div> 
            </div>
             
            <div class="row formSep">
                <div class="col-xs-12 col-sm-2">เงินเดือนเดือนสุดท้าย : </div>
                <div class="col-xs-12 col-sm-2"><input type="text" id="GOV_CJOH_SALARY" name="GOV_CJOH_SALARY" class="form-control" placeholder="เงินเดือนเดือนสุดท้าย" value="<?php echo number_format($rec['JOH_SALARY'],2);?>" onBlur="NumberFormat(this,2)" style="text-align:right; width:100px;"></div>
            </div>
        </span>   
        
        <!------------พนักงานราชการ---------------------------------------------------------------->
        <span id = "gov_emp">
            <div class="row formSep">
                <div class="col-xs-12 col-sm-2">กระทรวง : </div>
                <div class="col-xs-12 col-sm-3"><?php echo GetHtmlSelect('GOV_EMP_ORG_ID_1','GOV_EMP_ORG_ID_1', $arr_org1, 'กระทรวง', $rec['ORG_ID_1'],"onChange=\"get_gov_emp_org2(this.value);\"",'','','300','1'); ?></div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">กรม : </div>
                <div class="col-xs-12 col-md-3">
                    <select id="GOV_EMP_ORG_ID_2" name="GOV_EMP_ORG_ID_2" class="selectbox form-control" placeholder="กรม" onChange="get_gov_emp_org3(this.value);" style="width:300px;">
                        <option value=""></option>
                        <?php
                        $sql_org_4 = "SELECT ORG_ID, ORG_NAME_TH FROM SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$rec['ORG_ID_1']."' ORDER BY ORG_SEQ ASC";
                        $query_org_4 = $db->query($sql_org_4);
                        $select_org_4[$rec['ORG_ID_2']] = "Selected='Selected'";
                        while($org = $db->db_fetch_array($query_org_4)){
                            echo '<option value="'.$org['ORG_ID'].'" '.$select_org_4[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-1"></div>
            
            <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สำนัก/กอง : </div>
                <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('GOV_EMP_ORG_ID_3','GOV_EMP_ORG_ID_3', $arr_org3 , 'สำนัก/กอง',$rec['ORG_ID_3'],"",'','','300','1'); ?></div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ประเภทพนักงานราชการ : </div>
                <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('GOV_EMP_TYPE_ID','GOV_EMP_TYPE_ID', $arr_type_gov_emp, 'ประเภทพนักงานราชการ', $rec['TYPE_ID'],' onChange="get_level_gov_emp(this);" ','','','300','1'); ?></div>
            </div>
            
            <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทกลุ่ม : </div>
                <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('GOV_EMP_LEVEL_ID','GOV_EMP_LEVEL_ID', $arr_level_gov_emp , 'ประเภทกลุ่ม', $rec['LEVEL_ID'],' onChange="get_line_gov_emp(this);" ','','','300','1'); ?></div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ตำแหน่ง : </div>
                <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('GOV_EMP_LINE_ID', 'GOV_EMP_LINE_ID',$arr_line_gov_emp , 'ตำแหน่ง' ,$rec['LINE_ID'],'','','','300', '1'); ?></div>
            </div>
              
            <div class="row formSep">
                <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่บรรจุเข้ารับราชการ : </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="input-group">
                        <input type="text" id="GOV_EMP_CJOH_SDATE" name="GOV_EMP_CJOH_SDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($rec["JOH_SDATE"]);?>">
                        <span class="input-group-addon datepicker" for="GOV_EMP_CJOH_SDATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                    </div>
                </div> 
                <div class="col-xs-12 col-sm-1"></div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" >วันที่ออกจากงาน : </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="input-group">
                        <input type="text" id="GOV_EMP_CJOH_EDATE" name="GOV_EMP_CJOH_EDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($rec["JOH_EDATE"]);?>">
                        <span class="input-group-addon datepicker" for="GOV_EMP_CJOH_EDATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                    </div>
                </div> 
            </div>
            
            <div class="row formSep">
                <div class="col-xs-12 col-sm-2">ค่าตอบแทนเดือนสุดท้าย : </div>
                <div class="col-xs-12 col-sm-2"><input type="text" id="GOV_EMP_CJOH_SALARY" name="GOV_EMP_CJOH_SALARY" class="form-control" placeholder="ค่าตอบแทนเดือนสุดท้าย" value="<?php echo number_format($rec['JOH_SALARY'],2) ;?>" onBlur="NumberFormat(this,2)" style="text-align:right; width:100px;"></div>
            </div>
        </span>
        
        <!------------ลูกจ้างประจำ---------------------------------------------------------------->
        <span id = "emp">
            <div class="row formSep">
                <div class="col-xs-12 col-sm-2">กระทรวง : </div>
                <div class="col-xs-12 col-sm-3"><?php echo GetHtmlSelect('EMP_ORG_ID_1','EMP_ORG_ID_1', $arr_org1, 'กระทรวง', $rec['ORG_ID_1'],"onChange=\"get_emp_org2(this.value);\"",'','','300','1'); ?></div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">กรม : </div>
                <div class="col-xs-12 col-md-3">
                    <select id="EMP_ORG_ID_2" name="EMP_ORG_ID_2" class="selectbox form-control" placeholder="กรม" onChange="get_emp_org3(this.value);" style="width:300px;">
                        <option value=""></option>
                        <?php
                        $sql_org_4 = "SELECT ORG_ID, ORG_NAME_TH FROM SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$rec['ORG_ID_1']."' ORDER BY ORG_SEQ ASC";
                        $query_org_4 = $db->query($sql_org_4);
                        $select_org_4[$rec['ORG_ID_4']] = "Selected='Selected'";
                        while($org = $db->db_fetch_array($query_org_4)){
                            echo '<option value="'.$org['ORG_ID'].'" '.$select_org_4[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-1"></div>
            <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สำนัก/กอง : </div>
                <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('EMP_ORG_ID_3','EMP_ORG_ID_3', $arr_org3, 'สำนัก/กอง',$rec['ORG_ID_3'],"onchange=\"get_emp_org4(this.value)\"",'','','300','1'); ?></div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ต่ำกว่าสำนัก/กอง 1 ระดับ<br>(ส่วน/กลุ่ม/กลุ่มงาน) : </div>
                <div class="col-xs-12 col-md-3">
                    <select id="EMP_ORG_ID_4" name="EMP_ORG_ID_4" class="selectbox form-control" placeholder="กลุ่มงาน" onChange="get_emp_org5(this.value);" style="width:300px;">
                        <option value=""></option>
                        <?php
                        $sql_org_4 = "Select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$rec['ORG_ID_3']."' ORDER BY ORG_SEQ ASC";
                        $query_org_4 = $db->query($sql_org_4);
                        $select_org_4[$rec['ORG_ID_4']] = "Selected='Selected'";
                        while($org = $db->db_fetch_array($query_org_4)){
                            echo '<option value="'.$org['ORG_ID'].'" '.$select_org_4[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ต่ำกว่าสำนัก/กอง 2 ระดับ(ฝ่าย) : </div>
                <div class="col-xs-12 col-md-3">
                    <select id="EMP_ORG_ID_5" name="EMP_ORG_ID_5" class="selectbox form-control" placeholder="ฝ่าย" style="width:300px;">
                        <option value=""></option>
                        <?php
                        $sql_org_4 = "SELECT ORG_ID, ORG_NAME_TH FROM SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$rec['ORG_ID_4']."' ORDER BY ORG_SEQ ASC";
                        $query_org_4 = $db->query($sql_org_4);
                        $select_org_4[$rec['ORG_ID_5']] = "Selected='Selected'";
                        while($org = $db->db_fetch_array($query_org_4)){
                            echo '<option value="'.$org['ORG_ID'].'" '.$select_org_4[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ประเภทกลุ่มงาน : </div>
                <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('EMP_TYPE_ID', 'EMP_TYPE_ID',$arr_type_emp , 'ประเภทกลุ่มงาน' ,$rec['TYPE_ID'] ,"onchange=\"get_line_emp(this)\"", '', '', '300','1'); ?></div>
            </div>
            
            <div class = "row formSep">
                <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ตำแหน่งในสายงาน : </div>
                <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('EMP_LINE_ID', 'EMP_LINE_ID',$arr_line_emp , 'ตำแหน่งในสายงาน' ,$rec['LINE_ID'] ,"", '', '', '300','1'); ?></div>
                <div class="col-xs-12 col-sm-1"></div>
                <div class="col-xs-12 col-sm-2">ค่าจ้างเดือนสุดท้าย : </div>
                <div class="col-xs-12 col-sm-2"><input type="text" id="EMP_CJOH_SALARY" name="EMP_CJOH_SALARY" class="form-control" placeholder="ค่าจ้างเดือนสุดท้าย" value="<?php echo number_format($rec['JOH_SALARY'],2) ;?>" onBlur="NumberFormat(this,2)" style="text-align:right; width:100px;"></div>
            </div>
            
            <div class="row formSep">
                <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่บรรจุเข้ารับราชการ : </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="input-group">
                        <input type="text" id="EMP_CJOH_SDATE" name="EMP_CJOH_SDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($rec["JOH_SDATE"]);?>">
                        <span class="input-group-addon datepicker" for="EMP_CJOH_SDATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                    </div>
                </div> 
                <div class="col-xs-12 col-sm-1"></div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" >วันที่ออกจากงาน : </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="input-group">
                    <input type="text" id="EMP_CJOH_EDATE" name="EMP_CJOH_EDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($rec["JOH_EDATE"]);?>">
                    <span class="input-group-addon datepicker" for="EMP_CJOH_EDATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                    </div>
                </div> 
            </div>
        </span>
        
        <!----------เอกชน--------------------------------------------------------------------->
        <span id = "other">
            <div class="row formSep">
                  
               
                <div class="col-xs-12 col-sm-2">ชื่ออาขีพ : </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="input-group"><?php echo GetHtmlSelect('JOB_ID','JOB_ID', $arr_sjob, ชื่ออาขีพ, $rec['JOB_ID'],'onChange=chkOther(this.value);','','1'); ?></div>
                </div>
      
            </div>
            
            <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ตำแหน่ง : </div>
                <div class="col-xs-12 col-md-3"><input type="text" id="CJOH_POS_NAME" name="CJOH_POS_NAME" class="form-control" placeholder="ตำแหน่ง" value="<?php echo text($rec['JOH_POS_NAME']) ;?>" maxlength="100"></div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" >หน่วยงาน/บริษัท : </div>
                <div class="col-xs-12 col-md-3"><input type="text" id="CJOH_ORG_NAME" name="CJOH_ORG_NAME" class="form-control" placeholder="หน่วยงาน/บริษัท" value="<?php echo text($rec['JOH_ORG_NAME']) ;?>" maxlength="100"></div>
            </div>
    
            <div class="row formSep">
                <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่เริ่มต้น : </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="input-group">
                        <input type="text" id="OTH_CJOH_SDATE" name="OTH_CJOH_SDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($rec["JOH_SDATE"]);?>">
                        <span class="input-group-addon datepicker" for="OTH_CJOH_SDATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                    </div>
                </div> 
                <div class="col-xs-12 col-sm-1"></div>
                <div class="col-xs-12 col-md-2 col-md-offset-1" >วันที่สิ้นสุด : </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="input-group">
                    <input type="text" id="OTH_CJOH_EDATE" name="OTH_CJOH_EDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($rec["JOH_EDATE"]);?>">
                    <span class="input-group-addon datepicker" for="OTH_CJOH_EDATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                    </div>
                </div> 
            </div>
            <div class="row formSep">
                    <div class="col-xs-12 col-sm-2">ค่าตอบแทนเดือนสุดท้าย : </div>
                <div class="col-xs-12 col-sm-2"><input type="text" id="OTH_CJOH_SALARY" name="OTH_CJOH_SALARY" class="form-control" placeholder="ค่าตอบแทนเดือนสุดท้าย" value="<?php echo number_format($rec['JOH_SALARY'],2) ;?>" onBlur="NumberFormat(this,2)" style="text-align:right; width:100px;"></div>
            </div>
        </span>
        <!--------------------------------------------------------------------------------------->
		<br>
        <div class="col-xs-12 col-sm-12" align="center">
          <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
          <button type="button" class="btn btn-default" onClick="self.location.href='profile_jobhis_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
        </div>
        <br>
      </form>
    </div>
  </div>
  <div style="text-align:center; ">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>