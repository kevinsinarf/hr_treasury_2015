<?php 
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;  /// for mobile
$paramlink = url2code($link);
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

$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 
$TRAINHIS_ID = $_POST['TRAINHIS_ID'];

if($proc == 'edit'){
	$sql = "SELECT * FROM PER_TRAINHIS WHERE TRAINHIS_ID = '".$TRAINHIS_ID."'";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
}

//ประเทศ

$arr_country=GetSqlSelectArray("COUNTRY_ID", "COUNTRY_NAME_TH", "SETUP_COUNTRY", "DELETE_FLAG='0'", "COUNTRY_NAME_TH");
$rec['COUNTRY_ID'] = $rec['COUNTRY_ID'] == "" ? $default_country_id : $rec['COUNTRY_ID'];
//จังหวัด
$arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "DELETE_FLAG='0'", "PROV_TH_NAME");
$PROV_ID = empty($rec['PROV_ID'])?$default_prov_id:$rec['PROV_ID'];

##------------------- ข้าราชการ ------------------------##

//กระทรวง
$arr_org1 = GetSqlSelectArray("ORG_ID","ORG_NAME_TH","SETUP_ORG","OL_ID = '2' and DELETE_FLAG='0' ","ORG_SEQ" );
//สำนัก
$cond_org3 = ($rec['ORG_ID_2'] != '') ? " AND ORG_PARENT_ID = '".$rec['ORG_ID_2']."'" : "";
$arr_org3 = GetSqlSelectArray("ORG_ID","ORG_NAME_TH","SETUP_ORG"," DELETE_FLAG = '0' ".$cond_org3, "ORG_SEQ" );

//ประเภทตำแหน่ง
$arr_pos_type =GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", " DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "TYPE_SEQ");
//สายงาน
$arr_pos_lg = GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", " DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LG_NAME_TH");
//ระดับ
$arr_level_gov =  GetSqlSelectArray("LEVEL_ID","LEVEL_NAME_TH","SETUP_POS_LEVEL"," DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' AND TYPE_ID = '".$rec['TYPE_ID']."' ","LEVEL_SEQ");
//ตำแหน่งในสายงาน
$arr_line = GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", " DELETE_FLAG = 0 AND LG_ID = '".$rec['LG_ID']."' ", "LINE_NAME_TH");
//ประเภทตำแหน่งทางการบริหาร
$arr_type_mt = GetSqlSelectArray("MT_ID", "MT_NAME_TH", "SETUP_POS_MANAGE_TYPE", "DELETE_FLAG = 0  ", "MT_SEQ"); 
//ต่ำแหน่งทางการบริหาร
$arr_manage = GetSqlSelectArray("MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", " DELETE_FLAG = 0 AND TYPE_ID = '".$rec['TYPE_ID']."' ", "MANAGE_NAME_TH");

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
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
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
<script src="<?php echo $path; ?>bootstrap/js/tooltip.js"></script> 
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_dev.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  		<li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
	  		<li><a href="profile_dev.php?<?php echo url2code($link2);?>">ประวัติการศึกษาดูงาน/ฝึกอบรม/สัมมนา</a></li>
	  		<li class="active"><?php echo "แก้ไขข้อมูล";?></li>
		</ol>
	</div>
	<div class="col-xs-12 col-md-12" id="content">
		<?php include("tab_profile.php");?>
		<div class="grouptab">
		 <?php include("tab_info.php");?>
		 <div class="clearfix"></div>
			<form id="frm-input" method="post" action="process/profile_dev_process.php" >
				<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
				<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
				<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
				<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
				<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        		<input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
				<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
				<input type="hidden" id="TRAINHIS_ID" name="TRAINHIS_ID" value="<?php echo $TRAINHIS_ID?>">
                <input type="hidden" id="default_country_id" name="default_country_id" value="<?php echo $default_country_id;?>">
                <input type="hidden" id="default_prov_id" name="default_prov_id" value="<?php echo $default_prov_id;?>"> 
                <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="<?php echo $POSTYPE_ID?>"> 
				<input type="hidden" id="POS_NO" name="POS_NO" value="<?php echo $POS_NO?>"> 
				
            		
                <div class="row head-form">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;"> ประวัติการฝึกอบรม/สัมมนา/ศึกษาดูงาน</div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">โครงการ : </div>
                    <div class="col-xs-12 col-sm-6"><input type="text" name="TRAINHIS_PROJECT_NAME" id="TRAINHIS_PROJECT_NAME" class = "form-control" value="<?php echo text($rec['TRAINHIS_PROJECT_NAME']);?>" ></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">หลักสูตร : &nbsp;<span style="color:red;">*</span>&nbsp;</div>
                    <div class="col-xs-12 col-sm-6"><input type="text" name="TRAINHIS_COURSE_NAME" id="TRAINHIS_COURSE_NAME" class = "form-control" value="<?php echo text($rec['TRAINHIS_COURSE_NAME']);?>" ></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">รุ่น : &nbsp;</div>
                    <div class="col-xs-12 col-md-6"><input type="text" name="TRAINHIS_GEN_NAME" id="TRAINHIS_GEN_NAME" class = "form-control" value="<?php echo text($rec['TRAINHIS_GEN_NAME']);?>" ></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">รุ่นที่ : &nbsp;</div>
                    <div class="col-xs-12 col-md-2"><input type="text" name="TRAINHIS_GEN_NO" id="TRAINHIS_GEN_NO" class = "form-control" value="<?php echo text($rec['TRAINHIS_GEN_NO']);?>" ></div>
                    <div class="col-xs-12 col-md-2"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ลักษณะการพัฒนาบุคลากร : &nbsp;<span style="color:red;">*</span>&nbsp;</div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('TRAINHIS_TYPE_DEV','TRAINHIS_TYPE_DEV',$arr_type_dev,"ลักษณะการพัฒนาบุคลากร"."",$rec['TRAINHIS_TYPE_DEV'],'','','1','','2');?></div>
                </div>	
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทกิจกรรม : &nbsp;<span style="color:red;">*</span>&nbsp;</div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('TRAINHIS_TYPE_ACT','TRAINHIS_TYPE_ACT',$arr_train_type_act,'ประเภทกิจกรรม',$rec['TRAINHIS_TYPE_ACT'],'','','1','','2');?></div>
                    <div class="col-xs-12 col-md-2"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทตามสถานที่ : &nbsp;<span style="color:red;">*</span>&nbsp;</div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('TRAINHIS_TYPE_PLACE','TRAINHIS_TYPE_PLACE',$arr_train_type_place,'ประเภทตามสถานที่',$rec['TRAINHIS_TYPE_PLACE'],'','','1','','2');?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทโครงการตามผู้จัด : &nbsp;<span style="color:red;">*</span>&nbsp;</div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('TRAINHIS_TYPE_ORG','TRAINHIS_TYPE_ORG',$arr_train_type_org,'ประเภทโครงการตามผู้จัด',$rec['TRAINHIS_TYPE_ORG'],'','','1','','2');?></div>
                    <div class="col-xs-12 col-md-2"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทการเข้าร่วม : &nbsp;<span style="color:red;">*</span>&nbsp;</div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('TRAINHIS_TYPE_ATTEND','TRAINHIS_TYPE_ATTEND',$arr_train_type_attend,'ประเภทการเข้าร่วม',$rec['TRAINHIS_TYPE_ATTEND'],'','','1','','2');?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเทศ :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                    <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('S_COUNTRY','S_COUNTRY',$arr_country,'ประเทศ',$rec['COUNTRY_ID'],'onchange="getcountry(this.value);"','','1');?></div>
                    <div class="col-xs-12 col-md-1"></div>
                    <span class="chk_country">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัด :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                        <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('s_prov','s_prov',$arr_prov,'จังหวัด',$PROV_ID,'onchange="getRampr(this,\'s_ampr\',\'s_tamb\');"','','1');?></div>
                    </span>

                </div>
                
                <div class="row formSep">
                    <span class="chk_city">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เมือง :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                        <div class="col-xs-12 col-md-2"><input type="text" id="S_CITY" name="S_CITY" class="form-control" placeholder="เมือง" maxlength="10" value="<?php echo text($rec['TRAINHIS_CITY']); ?>"></div>
                    </span>
                </div>
                
            
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หน่วยงานที่จัด : &nbsp;<span style="color:red;">*</span>&nbsp;</div>
                    <div class="col-xs-12 col-md-6"><input type="text" name="TRAINHIS_ORG_NAME" id="TRAINHIS_ORG_NAME" class = "form-control" value="<?php echo text($rec['TRAINHIS_ORG_NAME']);?>"></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานที่จัด : </div>
                    <div class="col-xs-12 col-md-6"><input type="text" name="TRAINHIS_PLACE_NAME" id="TRAINHIS_PLACE_NAME" class = "form-control" value="<?php echo text($rec['TRAINHIS_PLACE_NAME']);?>"></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ฝึกอบรมตั้งแต่วันที่ : <span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2">
                        <div class="input-group">
                            <input type="text" id="TRAINHIS_SDATE" name="TRAINHIS_SDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo  conv_date($rec["TRAINHIS_SDATE"]);?>">
                            <span class="input-group-addon datepicker" for="TRAINHIS_SDATE" >&nbsp;
                            <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ถึงวันที่ : <span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2">
                        <div class="input-group">
                            <input type="text" id="TRAINHIS_EDATE" name="TRAINHIS_EDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo  conv_date($rec["TRAINHIS_EDATE"]);?>">
                            <span class="input-group-addon datepicker" for="TRAINHIS_EDATE" >&nbsp;
                            <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ระดับการประเมิน : </div>
                    <div class="col-xs-12 col-md-1"><input type="text" name="TRAINHIS_RESULT" id="TRAINHIS_RESULT" class = "form-control number" value="<?php echo $rec['TRAINHIS_RESULT'];?>" style="width:100px;" ></div>
                </div>
                
                <div class="row head-form">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;"> ข้อมูลตำแหน่งขณะที่ฝึกอบรม/สัมมนา/ศึกษาดูงาน</div>
                </div>
   				    
                <span id = "gov" >
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2 col-md-2" style="white-space:nowrap;">กระทรวง : &nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo GetHtmlSelect('GOV_ORG_ID_1','GOV_ORG_ID_1', $arr_org1 , 'กระทรวง', $rec['ORG_ID_1'],"onChange=\"get_gov_org2(this.value);\"",'','','300','1'); ?></div>
                        <div class="col-xs-12 col-sm-1"></div>
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">กรม : &nbsp;<span style="color:red;">*</span>&nbsp;</div>
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
					</div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2 col-md-2" style="white-space:nowrap;">สำนัก/กอง : </div>
                        <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('GOV_ORG_ID_3','GOV_ORG_ID_3', $arr_org3 , 'สำนัก/กอง',$rec['ORG_ID_3'],"onChange=\"get_gov_org4(this.value);\"",'','','300','1'); ?></div>
                        <div class="col-xs-12 col-md-1"></div>
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
                    </div>
            
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2 col-md-2" style="white-space:nowrap;">ต่ำกว่าสำนัก/กอง 2 ระดับ<br>(ฝ่าย) : </div>
                        <div class="col-xs-12 col-md-3">
                            <select id="GOV_ORG_ID_5" name="GOV_ORG_ID_5" class="selectbox form-control" placeholder="ฝ่าย" style="width:300px;">
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
                    </div>
                    <!------------ข้าราชการ---------------------------------------------------------------->  
                    <?php if($POSTYPE_ID == 1){ ?>
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['type_pos']; ?> : </div>
                        <div class="col-xs-12 col-md-3">
                        	<?php echo GetHtmlSelect('TYPE_ID', 'TYPE_ID',$arr_pos_type , $arr_txt['type_pos'] ,$rec['TYPE_ID'] ," onChange='get_level(this); get_line_group(this); ' ",'', '', '300', '1'); ?>
                           
                    	</div>
                    	<div class="col-xs-12 col-md-2 col-md-offset-1" >ระดับตำแหน่ง : </div>
                    	<div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('LEVEL_ID', 'LEVEL_ID',$arr_level_gov , 'ระดับ' ,$rec['LEVEL_ID'] ,'','', '', '300', '1'); ?></div>
                    </div>
                    
                     <div class="row formSep">
                     	<div class="col-xs-12 col-md-2 " >สายงาน : </div>
                        <div class="col-xs-12 col-md-3">
							<?php echo GetHtmlSelect('LG_ID', 'LG_ID', $arr_pos_lg, 'สายงาน' ,$rec['LG_ID'] ," onchange='get_line(this);' ", '', '', '300', '1'); ?>
                        </div>
                        <div class="col-xs-12 col-md-2 col-md-offset-1 " >ตำแหน่งในสายงาน : &nbsp;</div>
                        <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('LINE_ID', 'LINE_ID',$arr_line, 'ตำแหน่งในสายงาน' ,$rec['LINE_ID'] ,'', '', '', '300', '1'); ?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ประเภทตำแหน่งทางการบริหาร : &nbsp;</div>
                        <div class="col-xs-12 col-md-3"><?php  echo GetHtmlSelect('MT_ID','MT_ID',$arr_type_mt,'ประเภทตำแหน่งทางการบริหาร',$rec['MT_ID'],'onchange=get_manage(this);','','1');?></div>
                        
                        <div class="col-xs-12 col-md-2 col-md-offset-1" >ตำแหน่งทางการบริหาร : </div>
                        <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('MANAGE_ID', 'MANAGE_ID', $arr_manage, 'ตำแหน่งทางการบริหาร' ,$rec['MANAGE_ID'] ,'', '', '', '300', '1'); ?></div>
                    </div> 
                       
                </span>
                <?php } ?>
                <!-- พนักงานราชการ -->
                <?php if($POSTYPE_ID == 3){ ?>
                <div class="row formSep">
                  <div class="col-xs-12 col-md-2 " >ปีที่อนุมัติกรอบ : </div>
                  <div class="col-xs-12 col-md-3">
                  	<input type="text" id="POS_YEAR" name="POS_YEAR" class="form-control number" placeholder="ปีที่อนุมัติกรอบ" maxlength="10" value="<?php echo $rec['POS_YEAR']; ?>" style="width:170px;" >
                  </div>
                   <div class="col-xs-12 col-md-2 col-md-offset-1" >ประเภทพนักงานราชการ : </div>
                  <div class="col-xs-12 col-md-3">
                      <?php echo GetHtmlSelect('TYPE_ID', 'TYPE_ID',$arr_pos_type , 'ประเภทพนักงานราชการ' ,$rec['TYPE_ID'] ," onChange='get_level(this); ' ",'', '', '300', '1'); ?>
                  </div>
                 </div>
                 
                  <div class="row formSep">
                     	<div class="col-xs-12 col-md-2 " >ประเภทกลุ่มงาน : </div>
                        <div class="col-xs-12 col-md-3">
							<?php echo GetHtmlSelect('LEVEL_ID', 'LEVEL_ID',$arr_level_gov , 'ประเภทกลุ่มงาน' ,$rec['LEVEL_ID'] ," onChange='get_line(this); ' ",'', '', '300', '1'); ?>
                        </div>
                        <div class="col-xs-12 col-md-2 col-md-offset-1 " >ตำแหน่ง : &nbsp;</div>
                        <div class="col-xs-12 col-md-3">
							<?php echo GetHtmlSelect('LINE_ID', 'LINE_ID',$arr_line_gov, 'ตำแหน่ง' ,$rec['LINE_ID'] ,'', '', '', '300', '1'); ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if($POSTYPE_ID == 5){ ?>
                 <div class="row formSep">
                  <div class="col-xs-12 col-md-2 " >กลุ่ม : </div>
                  <div class="col-xs-12 col-md-3">
                      <?php echo GetHtmlSelect('TYPE_ID', 'TYPE_ID',$arr_pos_type , 'กลุ่ม' ,$rec['TYPE_ID'] ," onChange='get_level(this); get_line_group(this); ' ",'', '', '300', '1'); ?>
                  </div>
                  <div class="col-xs-12 col-md-2 col-md-offset-1 " >สายงาน : </div>
                  <div class="col-xs-12 col-md-3">
				  	<?php echo GetHtmlSelect('LG_ID', 'LG_ID', $arr_pos_lg, 'สายงาน' ,$rec['LG_ID'] ," onChange='get_line(this);' ", '', '', '300', '1'); ?>
                  </div>
                </div>
                <div class="row formSep">
                  <div class="col-xs-12 col-md-2  " >ตำแหน่งในสายงาน : &nbsp;</div>
                  <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('LINE_ID', 'LINE_ID',$arr_line_gov, 'ตำแหน่งในสายงาน' ,$rec['LINE_ID'] ,'', '', '', '300', '1'); ?></div>
                  <div class="col-xs-12 col-md-2 col-md-offset-1 " >ระดับตำแหน่ง : &nbsp;</div>
                  <div class="col-xs-12 col-md-3">
                      <?php echo GetHtmlSelect('LEVEL_ID', 'LEVEL_ID',$arr_level_gov , 'ระดับตำแหน่ง' ,$rec['LEVEL_ID'] ," ",'', '', '300', '1'); ?>
                  </div>
                  </div>
                <?php } ?>
                <div class="formlast">
                    <div class="col-xs-12 col-md-12" align="center">
                    <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                    <button type="button" class="btn btn-default" onClick="self.location.href='profile_dev.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
   <div style="text-align:center;width: 100%;
    height: 120px;
    position: relative;
    z-index: 1;bottom:0px;
">
   <?php include($path."include/footer.php"); ?>
   </div>
</div>
</body>
</html>