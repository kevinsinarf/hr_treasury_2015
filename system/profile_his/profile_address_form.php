<?php 
$path = "../../";
include($path."include/config_header_top.php");
$ACT=2;

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

$txt = (($proc == "add") ? "เปลี่ยนแปลงข้อมูลที่อยู่":"แก้ไขข้อมูล"); 
if($proc == 'edit'){
	$sql = "SELECT * FROM PER_ADDRESS WHERE PADD_ID = '".$PADD_ID."'";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
}

//ประเทศ
$arr_country=GetSqlSelectArray("COUNTRY_ID", "COUNTRY_NAME_TH", "SETUP_COUNTRY", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "COUNTRY_NAME_TH");
$rec['PADD_COUNTRY_ID'] = $rec['PADD_COUNTRY_ID'] == "" ? $default_country_id : $rec['PADD_COUNTRY_ID'];
//จังหวัด
$arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME");
$PADD_PROV_ID = empty($rec['PADD_PROV_ID'])?$default_prov_id:$rec['PADD_PROV_ID'];

//อำเภอ/เขต
$arr_ampr=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$PADD_PROV_ID."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");

//ตำบล/แขวง
$arr_tamb=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='".$rec['PADD_AMPR_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");

//Mask โทรศัพท์
$tel_class = $PADD_PROV_ID==$default_prov_id?"telbkk":"telprov";
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
<script src="js/profile_address.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  		<li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
	  		<li><a href="profile_address.php?<?php echo url2code($link2);?>">ประวัติที่อยู่</a></li>
	  		<li class="active"><?php echo $txt;?></li>
		</ol>
	</div>
	<div class="col-xs-12 col-md-12" id="content">
		<?php include("tab_profile.php");?>
		<div class="grouptab">
		 <?php include("tab_info.php");?>
		 <div class="clearfix"></div>
			<form id="frm-input" method="post" action="process/profile_address_process.php" >
				<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
				<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
				<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
				<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
				<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        		<input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
				<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
				<input type="hidden" id="PADD_ID" name="PADD_ID" value="<?php echo $PADD_ID?>">
                <input type="hidden" id="default_country_id" name="default_country_id" value="<?php echo $default_country_id;?>">
                <input type="hidden" id="default_prov_id" name="default_prov_id" value="<?php echo $default_prov_id;?>">
                
                <div class="row head-form"><img class="switchPic1" src="<?php echo $path;?>images/clse.gif" > ข้อมูลที่อยู่</div>
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่แจ้ง : <span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2">
                        <div class="input-group">
                            <input type="text" id="PADD_DATE" name="PADD_DATE" class="form-control" placeholder="วันที่แจ้ง" maxlength="10"value="<?php echo  conv_date(text($rec["PADD_DATE"]),'');?>">
                            <span class="input-group-addon datepicker" for="PADD_DATE" >&nbsp;
                            <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                            </span>
                        </div>
                    </div>	
                    <div class="col-xs-12 col-md-2"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทที่อยู่ : <span style="color:red;">*</span></div>
                    <div class="col-md-2 col-sm-3"><?php echo GetHtmlSelect('PADD_TYPE','PADD_TYPE',$arr_address,"ประเภทที่อยู่"."",$rec['PADD_TYPE'],'','','1','','2');?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเทศ :</div>
                    <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('S_COUNTRY','S_COUNTRY',$arr_country,'ประเทศ',$rec['PADD_COUNTRY_ID'],'onchange="getcountry(this.value);"','','1');?></div>
                    <div class="col-xs-12 col-md-1"></div>
                    <span class="chk_city">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เมือง :</div>
                        <div class="col-xs-12 col-md-3"><input type="text" id="S_CITY" name="S_CITY" class="form-control" placeholder="เมือง" maxlength="10" value="<?php echo $rec['PADD_CITY']; ?>"></div>
                	</span>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ห้อง :</div>
                    <div class="col-xs-12 col-md-3"><input type="text" id="S_ROOM" name="S_ROOM" class="form-control" placeholder="เลขที่ห้อง" maxlength="100" value="<?php echo text($rec['PADD_ROOM_NO']); ?>"></div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชั้น :</div>
                    <div class="col-xs-12 col-md-3"><input type="text" id="S_FLOOR" name="S_FLOOR" class="form-control" placeholder="ชั้น" maxlength="100" value="<?php echo text($rec['PADD_FLOOR']); ?>"></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อาคาร :</div>
                    <div class="col-xs-12 col-md-3"><input type="text" id="S_BUILDING" name="S_BUILDING" class="form-control" placeholder="อาคาร" maxlength="100" value="<?php echo text($rec['PADD_BUILDING']); ?>"></div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">บ้านเลขที่ :</div>
                    <div class="col-xs-12 col-md-3"><input type="text" id="S_HOMENO" name="S_HOMENO" class="form-control" placeholder="บ้านเลขที่" maxlength="100" value="<?php echo text($rec['PADD_HOME_NO']); ?>"></div>
                </div>
                    
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่ที่ :</div>
                    <div class="col-xs-12 col-md-3"><input type="text" id="S_MOO" name="S_MOO" class="form-control" placeholder="หมู่ที่" maxlength="100" value="<?php echo text($rec['PADD_MOO']); ?>"></div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่บ้าน :</div>
                    <div class="col-xs-12 col-md-3"><input type="text" id="S_VILLAGE" name="S_VILLAGE" class="form-control" placeholder="หมู่บ้าน" maxlength="100" value="<?php echo text($rec['PADD_VILLAGE']); ?>"></div>
                </div>  
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ซอย :</div>
                    <div class="col-xs-12 col-md-3"><input type="text" id="S_SOI" name="S_SOI" class="form-control" placeholder="ซอย" maxlength="100" value="<?php echo text($rec['PADD_SOI']); ?>"></div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ถนน :</div>
                    <div class="col-xs-12 col-md-3"><input type="text" id="S_ROAD" name="S_ROAD" class="form-control" placeholder="ถนน" maxlength="100" value="<?php echo text($rec['PADD_ROAD']); ?>"></div>
                </div> 
                
                <div class="chk_country">
                    <div class="row formSep" <?php echo ($rec['PADD_COUNTRY_ID'] == $default_country_id)?"":"style='display:none'";?>>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัด :</div>
                        <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('s_prov','s_prov',$arr_prov,'จังหวัด',$PADD_PROV_ID,'onchange="getRampr(this,\'s_ampr\',\'s_tamb\');getTelClass(this.value, \'\');"','','1');?></div>
                        <div class="col-xs-12 col-md-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อำเภอ/เขต :</div>
                        <div class="col-xs-12 col-md-2"><span id='ss_ampr'><?php echo GetHtmlSelect('s_ampr','s_ampr',$arr_ampr,'อำเภอ/เขต',$rec['PADD_AMPR_ID'],'onchange="getStamb(this.id,this.value,\'s_tamb\') " ','','1');?></span></div>
                    </div>	
                    
                    <div class="row formSep" <?php echo ($rec['PADD_COUNTRY_ID'] == $default_country_id)?"":"style='display:none'";?>>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ตำบล/แขวง :</div>
                        <div class="col-xs-12 col-md-2"><span id='ss_tamb'><?php echo GetHtmlSelect('s_tamb','s_tamb',$arr_tamb,'ตำบล/แขวง',$rec['PADD_TAMB_ID'],'onchange="getZip(this.id,this.value,\'PADD_POSTCODE\')"','','1');?></span></div>
                        <div class="col-xs-12 col-md-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">รหัสไปรษณีย์ :</div>
                        <div class="col-xs-12 col-md-2"><input type="text" id="PADD_POSTCODE" name="PADD_POSTCODE" class="form-control number" placeholder="รหัสไปรษณีย์" maxlength="5" value="<?php echo trim($rec['PADD_POSTCODE']); ?>"></div>
                    </div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์ :</div>
                    <div class="col-xs-12 col-md-2"><input type="text" id="S_TEL" name="S_TEL" class="form-control <?php echo $tel_class ?>"  placeholder="โทรศัพท์" maxlength="20" value="<?php echo trim($rec['PADD_TEL']); ?>"></div>
                    <div class="col-xs-12 col-sm-2">
                        <div class="input-group">
                        <span class="input-group-addon">ต่อ</span>
                         <input type="text" id="S_TEL_EXT" name="S_TEL_EXT" maxlength="4" class="form-control number" placeholder="ต่อ" value="<?php echo $rec['PADD_TEL_EXT'] ?>" style="width:80px;">
                        </div>	
                    </div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรสาร :</div>
                    <div class="col-xs-12 col-md-2"><input type="text" id="S_FAX" name="S_FAX" class="form-control <?php echo $tel_class ?>" placeholder="โทรสาร" maxlength="20" value="<?php if( $rec['PADD_FAX'] ==0) { echo ''; }else{  echo trim($rec['PADD_FAX']); }?>"></div>				
                    <div class="col-xs-12 col-sm-2">
                        <div class="input-group">
                        <span class="input-group-addon">ต่อ</span>
                         <input type="text" id="PADD_FAX_EXT" name="PADD_FAX_EXT" maxlength="4" class="form-control number" placeholder="ต่อ" value="<?php echo $rec['PADD_FAX_EXT'] ?>" style="width:80px;">
                        </div>	
                    </div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์เคลื่อนที่ :</div>
                    <div class="col-xs-12 col-md-3"><input type="text" id="S_MOBILE" name="S_MOBILE" class="form-control <?php echo $tel_class ?>"  placeholder="โทรศัพท์เคลื่อนที่" maxlength="20" value="<?php echo trim($rec['PADD_MOBILE']); ?>"></div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อีเมล์ :</div>
                    <div class="col-xs-12 col-md-3"><input type="text" id="S_EMAIL" name="S_EMAIL" class="form-control" placeholder="อีเมล์" maxlength="100" value="<?php echo text($rec['PADD_EMAIL']); ?>"></div>
                </div>
			</form>
        
            <div class="formlast">
                <div class="col-xs-12 col-md-12" align="center">
                    <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                    <button type="button" class="btn btn-default" onClick="self.location.href='profile_address.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
                </div>
            </div>
		</div>
	</div>
   <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>