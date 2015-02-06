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
$DEH_ID=$_POST['DEH_ID'];
$txt = (($proc == "add") ? "เพิ่มข้อมูล":"ดูรายละเอียด"); 
//MAIN
$POSTYPE_ID = $db->get_data_field("SELECT POSTYPE_ID FROM PER_PROFILE WHERE PER_ID = '".$PER_ID."' ", "POSTYPE_ID");
$sql = "SELECT * 
FROM PER_DECORATEHIS
WHERE DELETE_FLAG='0' AND DEH_ID = '".$DEH_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

//คู่สมรส
$sql_marry = "SELECT PMARRY_ID, PMARRY_PREFIX_ID, PMARRY_FIRSTNAME_TH, PMARRY_MIDNAME_TH ,PMARRY_LASTNAME_TH
FROM PER_MARRYHIS
WHERE DELETE_FLAG='0' AND ACTIVE_STATUS='1' AND PER_ID = '".$PER_ID."' ";
$query_marry = $db->query($sql_marry);
$num_marry = $db->db_num_rows($query_marry);

//ตระกูลเครื่องอิสริยาภรณ์
$arr_dec_family=GetSqlSelectArray("DEF_ID", "DEF_NAME_TH", "SETUP_DECORATION_FAMILY", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "DEF_NAME_TH");
//เครื่องราชอิสริยาภรณ์
if(!empty($rec['DEF_ID'])){
	$Cond_DEF .= " AND DEF_ID = '".$rec['DEF_ID']."' ";
}else{
	$Cond_DEF .= " AND (DEF_ID IS NULL OR DEF_ID = '0') ";
}

$arr_dec=GetSqlSelectArray("DEC_ID", "DEC_NAME_TH", "SETUP_DECORATION", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ".$Cond_DEF, "DEC_NAME_TH");
//ประเภทตำแหน่ง
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "TYPE_SEQ");
//ระดับตำแหน่ง/กลุ่มงาน
$arr_poss_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  AND TYPE_ID = '".$rec['TYPE_ID']."' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LEVEL_NAME_TH");
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
<script src="js/profile_decoratehis.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	   
	  <li><a href="profile_decoratehis.php?<?php echo url2code($link2); ?>">ประวัติการรับพระราชทานเครื่องราชอิสริยาภรณ์</a></li>
      <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
<div class="col-xs-12 col-sm-12" id="content">
<div class="groupdata" > <br>
	<?php include ("tab_info.php"); ?>
    <div class="clearfix"></div>
     
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
		<input type="hidden" id="DEH_ID" name="DEH_ID" value="<?php echo $DEH_ID?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตระกูลเครื่องอิสริยาภรณ์ : </div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('DEF_ID','DEF_ID',$arr_dec_family,'ตระกูลเครื่องอิสริยาภรณ์',$rec["DEF_ID"],'onchange="getDec(this.value);"','','1');?></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ชั้นเครื่องราชอิสริยาภรณ์ : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_dec'><?php  echo GetHtmlSelect_v('DEC_ID','DEC_ID',$arr_dec,'ชั้นเครื่องราชอิสริยาภรณ์',$rec['DEC_ID'],'','','1');?></span></div> 
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทตำแหน่ง : </div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('TYPE_ID','TYPE_ID',$arr_pos_type,'ประเภทตำแหน่ง',$rec['TYPE_ID'],'onchange="getPosLevel(this.value,\''.$POSTYPE_ID.'\');getPosLine(this.value,\''.$POSTYPE_ID.'\');getPosManage(this.value,\''.$POSTYPE_ID.'\');"','','1');?></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับตำแหน่ง : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_level'><?php  echo GetHtmlSelect_v('LEVEL_ID','LEVEL_ID',$arr_poss_level,'ระดับตำแหน่ง',$rec['LEVEL_ID'],'','','1');?></span></div> 
        </div>		
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งในสายงาน : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_line'><?php  echo GetHtmlSelect_v('LINE_ID','LINE_ID',$arr_pos_line,'ตำแหน่งในสายงาน',$rec['LINE_ID'],'','','1');?></span></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งทางการบริหาร :</div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_manage'><?php  echo GetHtmlSelect_v('MANAGE_ID','MANAGE_ID',$arr_manage,'ตำแหน่งทางการบริหาร',$rec['MANAGE_ID'],'','','1');?></span></div> 
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับกระทรวง : </div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('ORG_ID_1','ORG_ID_1',$arr_org1,'ระดับกระทรวง',$rec['ORG_ID_1'],'onchange="getORG1(this.value,\'ORG_ID_2\');"','','');?></div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ส่วนราชการ : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_org2'><?php  echo GetHtmlSelect_v('ORG_ID_2','ORG_ID_2',$arr_org2,'ระดับกรม',$rec['ORG_ID_2'],'onchange="getORG2(this.value,\'ORG_ID_3\');"','','');?></span></div> 
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">หน่วยงานระดับกอง/สำนัก/กลุ่ม : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_org3'><?php echo GetHtmlSelect_v('ORG_ID_3','ORG_ID_3',$arr_org3,'ระดับกอง/สำนัก/กลุ่ม',$rec['ORG_ID_3'],'onchange="getORG3(this.value,\'ORG_ID_4\');"','','1');?></span></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">หน่วยงานระดับส่วน/กลุ่มงาน : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_org4'><?php  echo GetHtmlSelect_v('ORG_ID_4','ORG_ID_4',$arr_org4,'ระดับส่วน/กลุ่มงาน ',$rec['ORG_ID_4'],'','','1');?></span></div> 
        </div>
        
        <div class="row formSep">
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เงินเดือน :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-2"><?php echo number_format($rec['DEH_SALARY'], 2); ?></div>
            <div class="col-xs-12 col-md-2"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เงินประจำตำแหน่ง :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-2"><?php echo number_format($rec['DEH_SALARY_POSITION'], 2); ?></div>
      	</div>
        
		<div class="row formSep">
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่ลงในราชกิจจานุเบกษา :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-2">				
                <div class="input-group">
                   <?php echo $rec["DEH_GAZZETTE_DATE"]==''?'':conv_date(text($rec["DEH_GAZZETTE_DATE"]),''); ?>
                  
                </div>				
            </div>
            <div class="col-xs-12 col-sm-2"></div>
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">หนังสือราชกิจจานุเบกษาเล่มที่ :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-3"><?php echo text($rec['DEH_GAZZETTE_BOOK']); ?></div>		
		</div>
        
		<div class="row formSep">
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ตอนที่ในหนังสือราชกิจจานุเบกษา :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-3"><?php echo text($rec['DEH_GAZZETTE_PART']); ?></div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หน้าที่ในหนังสือราชกิจจานุเบกษา :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-3"><?php echo text($rec['DEH_GAZZETTE_PAGE']); ?></div>		
		</div>
        
		<div class="row formSep">
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่ได้รับเครื่องราชฯ :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-2">				
                <div class="input-group">
                   <?php echo $rec["DEH_RECEIVE_DATE"]==''?'':conv_date(text($rec["DEH_RECEIVE_DATE"]),''); ?>
                     
                </div>				
            </div>
            <div class="col-xs-12 col-sm-2"></div>
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่ส่งคืนเครื่องราชฯ :&nbsp;</div>
            <div class="col-xs-12 col-md-2">	
                <div class="input-group">
				<?php echo $rec["DEH_RETURN_DATE"]==''?'':conv_date(text($rec["DEH_RETURN_DATE"]),''); ?>
                     
                </div>	
            </div>			
		</div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">คู่สมรส :&nbsp;</div>
            <div class="col-xs-12 col-sm-3">
             
                <?php  
				if($num_marry>0){
					while($rec_marry = $db->db_fetch_array($query_marry)){
					  if($rec['PMARRY_ID']==$rec_marry['PMARRY_ID']){
					     echo Showname($rec_marry["PMARRY_PREFIX_ID"],$rec_marry["PMARRY_FIRSTNAME_TH"],$rec_marry["PMARRY_MIDNAME_TH"],$rec_marry["PMARRY_LASTNAME_TH"]);
					  }
			        }
			     }
					 ?>
 
            </div> 
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมายเหตุ  : &nbsp;</div>
            <div class="col-xs-12 col-md-3"><?php echo text($rec['DEH_NOTE']); ?></div>
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานะ :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-3">
                <label><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS" disabled  value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$rec['ACTIVE_STATUS']=='' ?"checked":"")?>> ใช้งาน </label>&nbsp;&nbsp;
                <label><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" disabled value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?> > ไม่ใช้งาน </label>
            </div>
        </div>
        
</div>
</div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>