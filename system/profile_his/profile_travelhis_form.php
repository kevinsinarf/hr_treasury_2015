<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&PER_ID=".$PER_ID."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&ACT=".$ACT;
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
//POST
$PER_ID=$_POST['PER_ID'];
$TRAV_ID=$_POST['TRAV_ID'];
$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 
//MAIN
$sql = "SELECT a.* FROM PER_TRAVELHIS a WHERE a.DELETE_FLAG='0' AND a.TRAV_ID = '".$TRAV_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

//ประเทศ
$rec['COUNTRY_ID'] = !empty($rec['COUNTRY_ID'])?$rec['COUNTRY_ID']:$default_country_id;

$arr_country=GetSqlSelectArray("COUNTRY_ID", "COUNTRY_NAME_TH", "SETUP_COUNTRY", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "COUNTRY_NAME_TH");//ประเทศ
//ประเภทตำแหน่ง
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "TYPE_SEQ");
//ระดับตำแหน่ง/กลุ่มงาน
$arr_poss_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  AND TYPE_ID = '".$rec['TYPE_ID']."' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LEVEL_SEQ");
//สายงาน
$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  AND TYPE_ID = '".$rec['TYPE_ID']."' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LINE_NAME_TH");
//ตำแหน่งในการบริหาร
$sql_manage_name='';
if(!empty($rec['TYPE_ID'])){
	$sql_manage_name .= " OR TYPE_ID = ".$rec['TYPE_ID'];
}
$arr_manage=GetSqlSelectArray("MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' AND (TYPE_ID IS NULL ".$sql_manage_name.") ", "MANAGE_NAME_TH");
//org1
$arr_org1=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.OL_ID='2' ", "ORG_NAME_TH");
//org2
$arr_org2=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", " a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_1']."' ", "ORG_NAME_TH");
//org3
$arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_2']."' ", "ORG_NAME_TH");
//org4
$arr_org4=GetSqlSelectArray( "a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_3']."'  ", "ORG_NAME_TH");
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
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_travelhis.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
	  <li><a href="profile_travelhis.php?<?php echo url2code($link2); ?>">ประวัติการเดินทางไปต่างประเทศ</a></li>
      <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
<div class="col-xs-12 col-sm-12" id="content">
<div class="groupdata" > <br>
	<?php include ("tab_info.php"); ?>
    <div class="clearfix"></div>
    <form id="frm-input" method="post" action="process/profile_travelhis_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
		<input type="hidden" id="TRAV_ID" name="TRAV_ID" value="<?php echo $TRAV_ID?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทตำแหน่ง : </div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('TYPE_ID','TYPE_ID',$arr_pos_type,'ประเภทตำแหน่ง',$rec['TYPE_ID'],'onchange="getPosLevel(this.value,\''.$POSTYPE_ID.'\');getPosLine(this.value,\''.$POSTYPE_ID.'\');getPosManage(this.value,\''.$POSTYPE_ID.'\');"','','1');?></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับตำแหน่ง : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_level'><?php  echo GetHtmlSelect('LEVEL_ID','LEVEL_ID',$arr_poss_level,'ระดับตำแหน่ง',$rec['LEVEL_ID'],'','','1');?></span></div> 
        </div>		
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งในสายงาน : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_line'><?php  echo GetHtmlSelect('LINE_ID','LINE_ID',$arr_pos_line,'ตำแหน่งในสายงาน',$rec['LINE_ID'],'','','1');?></span></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งทางการบริหาร :</div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_manage'><?php  echo GetHtmlSelect('MANAGE_ID','MANAGE_ID',$arr_manage,'ตำแหน่งทางการบริหาร',$rec['MANAGE_ID'],'','','1');?></span></div> 
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับกระทรวง :</div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('ORG_ID_1','ORG_ID_1',$arr_org1,'ระดับกระทรวง',$rec['ORG_ID_1'],'onchange="getORG1(this.value,\'ORG_ID_2\');"','','');?></div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับกรม :</div>
            <div class="col-xs-12 col-sm-3"><span id='ss_org2'><?php  echo GetHtmlSelect('ORG_ID_2','ORG_ID_2',$arr_org2,'ระดับกรม',$rec['ORG_ID_2'],'onchange="getORG2(this.value,\'ORG_ID_3\');"','','');?></span></div> 
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับกอง/สำนัก/กลุ่ม : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_org3'><?php echo GetHtmlSelect('ORG_ID_3','ORG_ID_3',$arr_org3,'ระดับกอง/สำนัก/กลุ่ม',$rec['ORG_ID_3'],'onchange="getORG3(this.value,\'ORG_ID_4\');"','','1');?></span></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับส่วน/กลุ่มงาน : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_org4'><?php  echo GetHtmlSelect('ORG_ID_4','ORG_ID_4',$arr_org4,'ระดับส่วน/กลุ่มงาน ',$rec['ORG_ID_4'],'','','1');?></span></div> 
        </div>
        
		<div class="row formSep">
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเทศ :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-2"><?php  echo GetHtmlSelect('COUNTRY_ID','COUNTRY_ID',$arr_country,'ประเทศ',$rec['COUNTRY_ID'],'','','1');?>				</div>
		</div>
        
        <div class="row formSep">
        	<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่ไป :&nbsp;<span style="color:red;">*</span></div>
            <div class="col-xs-12 col-md-2">	
            	<div class="input-group">
                    <input type="text" id="TRAV_SDATE" name="TRAV_SDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo conv_date($rec["TRAV_SDATE"]);?>">
                    <span class="input-group-addon datepicker" for="TRAV_SDATE" >&nbsp;
                    <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>
            </div>
            <div class="col-xs-12 col-md-2"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่กลับ :&nbsp;<span style="color:red;">*</span></div>
            <div class="col-xs-12 col-md-2">	
            	<div class="input-group">
                    <input type="text" id="TRAV_EDATE" name="TRAV_EDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo conv_date($rec["TRAV_EDATE"]);?>">
                    <span class="input-group-addon datepicker" for="TRAV_EDATE" >&nbsp;
                    <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>
            </div>
     	</div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมายเหตุ  : &nbsp;</div>
            <div class="col-xs-12 col-md-5"><textarea id="TRAV_NOTE" name="TRAV_NOTE" class="form-control" placeholder="หมายเหตุ" maxlength="255" rows="3" ><?php echo text($rec['TRAV_NOTE']); ?></textarea></div>
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานะ:&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-3">
                <label><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS" value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$rec['ACTIVE_STATUS']=='' ?"checked":"")?>> ใช้งาน </label>&nbsp;&nbsp;
                <label><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?> > ไม่ใช้งาน </label>
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-12" align="center">
			<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
			<button type="button" class="btn btn-default" onClick="self.location.href='profile_travelhis.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
        </div>
        <br>
    </form>
</div>
</div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>