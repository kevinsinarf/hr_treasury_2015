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
$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 
//MAIN

$sql = "SELECT * 
FROM PER_DECORATEHIS
WHERE DELETE_FLAG='0' AND DEH_ID = '".$DEH_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

//คู่สมรส

$sql_marry = " select FAMILY_ID,FAMILY_PREFIX_ID,FAMILY_FIRSTNAME_TH,FAMILY_MIDNAME_TH,FAMILY_LASTNAME_TH from PER_FAMILY where per_id = '".$PER_ID."' AND  FAMILY_RELATIONSHIP = 3 ";
$query_marry = $db->query($sql_marry);
$num_marry = $db->db_num_rows($query_marry);

//ตระกูลเครื่องอิสริยาภรณ์
$arr_dec_family=GetSqlSelectArray("DEF_ID", "DEF_NAME_TH", "SETUP_DECORATION_FAMILY", "DELETE_FLAG='0'", "DEF_NAME_TH"); 
//เครื่องราชอิสริยาภรณ์
if(!empty($rec['DEF_ID'])){
	$Cond_DEF .= " AND DEF_ID = '".$rec['DEF_ID']."' ";
}else{
	$Cond_DEF .= " AND (DEF_ID IS NULL OR DEF_ID = '0') ";
}

$arr_dec=GetSqlSelectArray("DEC_ID", "DEC_NAME_TH", "SETUP_DECORATION", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ".$Cond_DEF, "DEC_NAME_TH");
//ประเภทตำแหน่ง
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "TYPE_SEQ");
//ระดับตำแหน่ง/กลุ่มงาน
$arr_poss_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "DELETE_FLAG='0'  AND TYPE_ID = '".$rec['TYPE_ID']."' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LEVEL_NAME_TH");
//สายงาน
$arr_pos_lg=GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "TYPE_ID = '".$rec['TYPE_ID']."' AND POSTYPE_ID = '".$POSTYPE_ID."' AND DELETE_FLAG='0' ", "LG_NAME_TH");
//ตำแหน่งในสายงาน
$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "DELETE_FLAG='0'  AND TYPE_ID = '".$rec['TYPE_ID']."' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LINE_NAME_TH");
//ตำแหน่งในการบริหาร
$sql_manage_name='';
if(!empty($rec['TYPE_ID'])){
	$sql_manage_name .= " OR TYPE_ID = ".$rec['TYPE_ID'];
}
$arr_manage=GetSqlSelectArray("MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", "DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' AND (TYPE_ID IS NULL ".$sql_manage_name.") ", "MANAGE_NAME_TH");

//org1
$arr_org1=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.DELETE_FLAG='0' AND a.OL_ID='2' ", "ORG_NAME_TH");
//org2
$arr_org2=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", " a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_1']."' ", "ORG_NAME_TH");
//org3
$arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_2']."' ", "ORG_NAME_TH");
//org4
$arr_org4=GetSqlSelectArray( "a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_3']."'  ", "ORG_NAME_TH");

//ประเภทตำแหน่งทางการบริหาร
$arr_type_mt2 = GetSqlSelectArray("MT_ID", "MT_NAME_TH", "SETUP_POS_MANAGE_TYPE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0  ", "MT_SEQ"); 
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
	  <li><a href="<?php echo $page_back."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
	  <li><a href="profile_decoratehis.php?<?php echo url2code($link2); ?>">ประวัติการรับพระราชทานเครื่องราชอิสริยาภรณ์</a></li>
      <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
<div class="col-xs-12 col-sm-12" id="content">
<div class="groupdata" > <br>
	<?php include ("tab_info.php"); ?>
    <div class="clearfix"></div>
    <form id="frm-input" method="post" action="process/profile_decoratehis_process.php" enctype="multipart/form-data">
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
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('DEF_ID','DEF_ID',$arr_dec_family,'ตระกูลเครื่องอิสริยาภรณ์',$rec["DEF_ID"],'onchange="getDec(this.value);"','','1');?></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ชั้นเครื่องราชอิสริยาภรณ์ : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><span id='ss_dec'><?php  echo GetHtmlSelect('DEC_ID','DEC_ID',$arr_dec,'ชั้นเครื่องราชอิสริยาภรณ์',$rec['DEC_ID'],'','','1');?></span></div> 
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['type_pos']; ?> : </div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('TYPE_ID','TYPE_ID',$arr_pos_type,$arr_txt['type_pos'],$rec['TYPE_ID'],'onchange="get_level(this.value,\''.$POSTYPE_ID.'\');get_lg(this.value,\''.$POSTYPE_ID.'\');"','','1');?></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับตำแหน่ง : <span style="color:red;">*</span><?php echo $rec['LEVEL_ID']; ?></div>
            <div class="col-xs-12 col-sm-3"><?php echo GetHtmlSelect('LEVEL_ID','LEVEL_ID',$arr_poss_level,'ระดับตำแหน่ง',$rec['LEVEL_ID'],'','','1');?>
			</div> 
        </div>		
        
        <div class="row formSep">
         	<div class="col-xs-12 col-sm-2" style="white-space:nowrap">สายงาน : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('LG_ID','LG_ID',$arr_pos_lg,'ตำแหน่งในสายงาน',$rec['LG_ID'],'onchange=get_line(this.value,\''.$POSTYPE_ID.'\');','','1');?></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งในสายงาน : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('LINE_ID','LINE_ID',$arr_pos_line,'ตำแหน่งในสายงาน',$rec['LINE_ID'],'','','1');?></div> 
            <div class="col-xs-12 col-sm-1"></div>
           
        </div>
        
        <div class="row formSep">
        	<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทตำแหน่งทางการบริหาร :</div>
            
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('MT_ID','MT_ID',$arr_type_mt2,'ประเภทตำแหน่งทางการบริหาร',$rec['MT_ID'],'onchange=get_Manage(this.value,\''.$POSTYPE_ID.'\');','','1');?></div>
             <div class="col-xs-12 col-sm-1"></div>
        	 <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งทางการบริหาร :</div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_manage'><?php  echo GetHtmlSelect('MANAGE_ID','MANAGE_ID',$arr_manage,'ตำแหน่งทางการบริหาร',$rec['MANAGE_ID'],'','','1');?></span></div> 
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับกระทรวง : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('ORG_ID_1','ORG_ID_1',$arr_org1,'ระดับกระทรวง',$rec['ORG_ID_1'],'onchange="getORG2(this.value);"','','');?></div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กรม : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><span id='ss_org2'><?php  echo GetHtmlSelect('ORG_ID_2','ORG_ID_2',$arr_org2,'ระดับกรม',$rec['ORG_ID_2'],'onchange="getORG3(this.value);"','','');?></span></div> 
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">หน่วยงานระดับกอง/สำนัก/กลุ่ม : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_org3'><?php echo GetHtmlSelect('ORG_ID_3','ORG_ID_3',$arr_org3,'ระดับกอง/สำนัก/กลุ่ม',$rec['ORG_ID_3'],'onchange="getORG4(this.value);"','','1');?></span></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">หน่วยงานระดับส่วน/กลุ่มงาน : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_org4'><?php  echo GetHtmlSelect('ORG_ID_4','ORG_ID_4',$arr_org4,'ระดับส่วน/กลุ่มงาน ',$rec['ORG_ID_4'],'','','1');?></span></div> 
        </div>
        
        <div class="row formSep">
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เงินเดือน :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-2"><input type="text" id="DEH_SALARY" name="DEH_SALARY" class="form-control" placeholder="เงินเดือน" maxlength="20" value="<?php echo number_format($rec['DEH_SALARY'], 2); ?>" onBlur="NumberFormat(this,2);" style="text-align:right"></div>
            <div class="col-xs-12 col-md-2"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เงินประจำตำแหน่ง :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-2"><input type="text" id="DEH_SALARY_POSITION" name="DEH_SALARY_POSITION" class="form-control" placeholder="เงินประจำตำแหน่ง" maxlength="20" value="<?php echo number_format($rec['DEH_SALARY_POSITION'], 2); ?>" onBlur="NumberFormat(this,2);" style="text-align:right"></div>
      	</div>
        
		<div class="row formSep">
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่ลงในราชกิจจานุเบกษา : <span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-2">				
                <div class="input-group">
                    <input type="text" id="DEH_GAZZETTE_DATE" name="DEH_GAZZETTE_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo $rec["DEH_GAZZETTE_DATE"]==''?'':conv_date(text($rec["DEH_GAZZETTE_DATE"]),''); ?>" >
                    <span class="input-group-addon datepicker" for="DEH_GAZZETTE_DATE">&nbsp;
                        <span id="sdate" class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>				
            </div>
            <div class="col-xs-12 col-sm-2"></div>
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">หนังสือราชกิจจานุเบกษาเล่มที่ : <span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-3"><input type="text" id="DEH_GAZZETTE_BOOK" name="DEH_GAZZETTE_BOOK" class="form-control number" placeholder="เล่มที่" value="<?php echo text($rec['DEH_GAZZETTE_BOOK']); ?>" ></div>		
		</div>
        
		<div class="row formSep">
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ตอนที่ในหนังสือราชกิจจานุเบกษา :&nbsp;</div>
            <div class="col-xs-12 col-md-3"><input type="text" id="DEH_GAZZETTE_PART" name="DEH_GAZZETTE_PART" class="form-control" placeholder="ตอนที่" value="<?php echo text($rec['DEH_GAZZETTE_PART']); ?>" ></div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หน้าที่ในหนังสือราชกิจจานุเบกษา :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-3"><input type="text" id="DEH_GAZZETTE_PAGE" name="DEH_GAZZETTE_PAGE" class="form-control number" placeholder="หน้าที่" value="<?php echo text($rec['DEH_GAZZETTE_PAGE']); ?>" ></div>		
		</div>
        
		<div class="row formSep">
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่ได้รับเครื่องราชฯ :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-2">				
                <div class="input-group">
                    <input type="text" id="DEH_RECEIVE_DATE" name="DEH_RECEIVE_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo $rec["DEH_RECEIVE_DATE"]==''?'':conv_date(text($rec["DEH_RECEIVE_DATE"]),''); ?>" >
                    <span class="input-group-addon datepicker" for="DEH_RECEIVE_DATE">&nbsp;
                        <span id="sdate" class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>				
            </div>
            <div class="col-xs-12 col-sm-2"></div>
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่ส่งคืนเครื่องราชฯ :&nbsp;</div>
            <div class="col-xs-12 col-md-2">	
                <div class="input-group">
                    <input type="text" id="DEH_RETURN_DATE" name="DEH_RETURN_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo $rec["DEH_RETURN_DATE"]==''?'':conv_date(text($rec["DEH_RETURN_DATE"]),''); ?>">
                    <span class="input-group-addon datepicker" for="DEH_RETURN_DATE" >&nbsp;
                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>	
            </div>			
		</div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">คู่สมรส : </div>
            <div class="col-xs-12 col-sm-3">
            <select id="PMARRY_ID" name="PMARRY_ID" class="selectbox form-control" placeholder="คู่สมรส">
            	<option value=""></option>
                <?php  
				if($num_marry>0){
					while($rec_marry = $db->db_fetch_array($query_marry)){ ?>
						<option value="<?php echo $rec_marry['FAMILY_ID'] ?>" <?php echo $rec['FAMILY_ID']==$rec_marry['FAMILY_ID']?"selected":""; ?>><?php echo Showname($rec_marry["FAMILY_PREFIX_ID"],$rec_marry["FAMILY_FIRSTNAME_TH"],$rec_marry["FAMILY_MIDNAME_TH"],$rec_marry["FAMILY_LASTNAME_TH"]);?></option>
						<?php 
					}
				}else{
					?>
                	<option value="0">-- ไม่พบข้อมูล --</option>
                	<?php 
				}
				?>
			</select>
            </div> 
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมายเหตุ  : &nbsp;</div>
            <div class="col-xs-12 col-md-3"><textarea id="DEH_NOTE" name="DEH_NOTE" class="form-control" placeholder="หมายเหตุ" maxlength="255" rows="3"><?php echo text($rec['DEH_NOTE']); ?></textarea></div>
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานะ :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-3">
                <label><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$rec['ACTIVE_STATUS']=='' ?"checked":"")?>> ใช้งาน </label>&nbsp;&nbsp;
                <label><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?> > ไม่ใช้งาน </label>
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-12" align="center" style="margin-top:10px;">
			<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
			<button type="button" class="btn btn-default" onClick="self.location.href='profile_decoratehis.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
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