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
$path_a = '../fileupload/profile_his/';
//POST
$PER_ID = $_POST['PER_ID'];
$FAMILY_ID = $_POST['FAMILY_ID'];

$txt = (($proc == "add") ? "เพิ่มข้อมูล":"ดูรายละเอียด"); 

if($FAMILY_ID != ''){
	$sql = "SELECT * FROM PER_FAMILY WHERE FAMILY_ID = '".$FAMILY_ID."'";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
}
$rec['ADDRESS_COUNTRY_ID'] = ($rec['ADDRESS_COUNTRY_ID'] == '') ? $default_country_id : $rec['ADDRESS_COUNTRY_ID'];
$rec['FAMILY_NATION_ID'] = ($rec['FAMILY_NATION_ID'] == '') ? $default_nation_id : $rec['FAMILY_NATION_ID'];
$rec['FAMILY_RACE_NATION_ID'] = ($rec['FAMILY_RACE_NATION_ID'] == '') ? $default_nation_id : $rec['FAMILY_RACE_NATION_ID']; 
$rec['FAMILY_RELIGION_ID'] = ($rec['FAMILY_RELIGION_ID'] == '') ? $default_religion_id : $rec['FAMILY_RELIGION_ID'];
//Mask โทรศัพท์
$PCON_PROV_ID = empty($rec["PCON_PROV_ID"])?$default_prov_id:$rec["PCON_PROV_ID"];
$tel_class = $PCON_PROV_ID==$default_prov_id?"telbkk":"telprov";
					
//ประเทศ
$arr_country = GetSqlSelectArray("COUNTRY_ID", "COUNTRY_NAME_TH", "SETUP_COUNTRY", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "COUNTRY_NAME_TH");
//จังหวัด
$arr_prov = GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME");
//อำเภอ/เขต
$arr_ampr_addr = GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$rec['ADDRESS_PROV_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
$arr_ampr_died = GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$rec['DIED_PROV_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
$arr_ampr_marry = GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$rec['MARRY_PROV_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
$arr_ampr_divorce = GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$rec['DIVORCE_PROV_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
$arr_ampr_sprotege = GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$rec['PROTEGE_SPROV_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
$arr_ampr_eprotege = GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$rec['PROTEGE_EPROV_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
//ตำบล/แขวง
$arr_tamb = GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='".$rec['ADDRESS_AMPR_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");
$arr_prefix=GetSqlSelectArray("PREFIX_ID", "PREFIX_NAME_TH", "V_PREFIX", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PREFIX_SEQ,PREFIX_NAME_TH"); //คำนำหน้าชื่อ th
$arr_snation=GetSqlSelectArray("NATION_ID", "NATION_NAME_TH", "SETUP_NATION", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "NATION_NAME_TH");//สัญชาติ
$arr_sreligion=GetSqlSelectArray("RELIGION_ID", "RELIGION_NAME_TH", "SETUP_RELIGION", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "RELIGION_CODE");//ศาสนา
$arr_sjob=GetSqlSelectArray("JOB_ID", "JOB_NAME_TH", "V_SETUP_JOB", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "JOB_NAME_TH");//อาชีพ
// บุตรที่เกิดจากคู่สมรส
$q_fami_par = $db->query("SELECT FAMILY_ID, FAMILY_PREFIX_ID, FAMILY_FIRSTNAME_TH, FAMILY_MIDNAME_TH, FAMILY_LASTNAME_TH FROM PER_FAMILY WHERE FAMILY_RELATIONSHIP = '3' AND PER_ID = '".$PER_ID."'");
while($r_fami_par = $db->db_fetch_array($q_fami_par)){
	$arr_family[$r_fami_par['FAMILY_ID']] = Showname($r_fami_par["FAMILY_PREFIX_ID"],$r_fami_par["FAMILY_FIRSTNAME_TH"],$r_fami_par["FAMILY_MIDNAME_TH"],$r_fami_par["FAMILY_LASTNAME_TH"]);
}
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
<script src="js/profile_contact_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      	<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	 	
      	<li><a href="profile_contact_disp.php?<?php echo url2code($link2); ?>">ประวัติบุคคลในครอบครัว</a></li>
	   	<li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" ><br>
	<?php include ("tab_info.php"); ?>
	<div class="clearfix"></div>
     
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        <input type="hidden" id="FAMILY_ID" name="FAMILY_ID"  value="<?php echo $FAMILY_ID; ?>">
        <input type="hidden" id="default_country_id" name="default_country_id" value="<?php echo $default_country_id;?>">
        <input type="hidden" id="default_prov_id" name="default_prov_id" value="<?php echo $default_prov_id;?>">
        <input type="hidden" id="PER_STATUS_MARRY" name="PER_STATUS_MARRY" value="<?php echo $info['PER_STATUS_MARRY'];?>">
        
        <div class="panel-group" id="accordion">
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();">
                        <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                        <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >
                        ข้อมูลส่วนตัวของบุคคลภายในครอบครัว
                    </a>
                </div>
            </div>
            
            <div id="collapse1" class="collapse in">
                <div class="row formSep">
                    <div class="col-md-2 col-sm-2 " style="white-space:nowrap">วันที่แจ้ง :&nbsp; <span style="color:red;">*</span>&nbsp; </div>
                    <div class="col-md-2 col-sm-2">
                        <div class="input-group">
                            <?php echo  conv_date($rec["FAMILY_DATE"]);?>
                            
                        </div>	
                    </div>
                    <div class="col-md-2 col-sm-2"></div>
                    <div class="col-md-2 col-sm-2" style="white-space:nowrap">ความสัมพันธ์ :&nbsp; <span style="color:red;">*</span>&nbsp; </div>
                    <div class="col-md-2 col-sm-2"><?php echo GetHtmlSelect_v2('FAMILY_RELATIONSHIP', 'FAMILY_RELATIONSHIP',$arr_family_relation, "ความสัมพันธ์", $rec['FAMILY_RELATIONSHIP'],'onchange="chkFamilyType(this.value);"','','1','','2');?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-md-2 col-sm-2 " style="white-space:nowrap">ประเภทบัตร :&nbsp;</div>
                    <div class="col-md-2 col-sm-2">
                        <input type="radio" name="FAMILY_IDTYPE" disabled id="FAMILY_IDTYPE" value="1" <?php if($rec['FAMILY_IDTYPE'] == '' || $rec['FAMILY_IDTYPE'] == 1){ echo "checked";} ?> onChange="getType('1');"> <?php echo $arr_txt['idcard']; ?><br>
                        <input type="radio" name="FAMILY_IDTYPE" disabled id="FAMILY_IDTYPE" value="2" onChange="getType('2');"> เลขที่หนังสือเดินทาง
                    </div>  
                    <div class="col-md-2 col-sm-2"></div> 
                    <div class="col-md-2 col-sm-2" style="white-space:nowrap"><span id="shw_txt_type"><?php if($rec['FAMILY_IDTYPE'] == '' || $rec['FAMILY_IDTYPE'] == 1){ echo $arr_txt['idcard'];}else{ echo "เลขที่หนังสือเดินทาง";}?></span> :&nbsp; </div>
                    <div class="col-md-2 col-sm-2">
                     <?php echo text($rec['FAMILY_IDCARD']); ?>
                     <?php echo text($rec['FAMILY_IDCARD']); ?>
                    </div> 
                </div>
                
				<div class="row formSep">
                	<div class="col-md-2 col-sm-2" style="white-space:nowrap">วันเดือนปีเกิด : </div>
                    <div class="col-md-2 col-sm-2">
                        <div class="input-group">
                            <?php echo  conv_date($rec["FAMILY_BIRTHDATE"]);?> 
                        </div>	
                    </div>
                    <div class="col-md-2 col-sm-2"></div>
                    <div class="col-md-2 col-sm-2">คำนำหน้าชื่อ : <span style="color:red;">*</span>&nbsp; </div>
                    <div class="col-md-2 col-sm-2"><?php echo GetHtmlSelect_v('FAMILY_PREFIX_ID','FAMILY_PREFIX_ID',$arr_prefix,"คำนำหน้าชื่อ",$rec['FAMILY_PREFIX_ID'],'','','1'); ?></div> 
                </div> 
               
               	<div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อตัว (ไทย) : &nbsp;<span style="color:red;">*</span>&nbsp;</div>
                    <div class="col-xs-12 col-md-2"><?php echo text($rec["FAMILY_FIRSTNAME_TH"]); ?></div>
                    <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ชื่อรอง (ไทย) : </div>
                    <div class="col-xs-12 col-md-2"><?php echo text($rec["FAMILY_MIDNAME_TH"]); ?></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อสกุล (ไทย) : &nbsp;<span style="color:red;">*</span>&nbsp;</div>
                    <div class="col-xs-12 col-md-2"><?php echo text($rec["FAMILY_LASTNAME_TH"]); ?></div>
                </div>
        
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อตัว (อังกฤษ) :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                    <div class="col-xs-12 col-md-2"><?php echo text($rec["FAMILY_FIRSTNAME_EN"]); ?></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อรอง (อังกฤษ) :</div>
                    <div class="col-xs-12 col-md-2"><?php echo text($rec["FAMILY_MIDNAME_EN"]); ?></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อสกุล (อังกฤษ) :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                    <div class="col-xs-12 col-md-2"><?php echo text($rec["FAMILY_LASTNAME_EN"]); ?></div>
                </div> 
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">เพศ :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                    <div class="col-xs-12 col-md-1"><label ><input type="radio" disabled id="FAMILY_GENDER" name="FAMILY_GENDER"  value="1" <?php echo ($rec['FAMILY_GENDER']=='1'||$rec['FAMILY_GENDER']=='' ?"checked":"")?>> ชาย</label></div>
                    <div class="col-xs-12 col-md-1"><label ><input type="radio" disabled id="FAMILY_GENDER" name="FAMILY_GENDER" value="2" <?php echo ($rec['FAMILY_GENDER']=='2'?"checked":"")?> > หญิง</label></div>
                    <div class="col-xs-12 col-md-2"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">สัญชาติ :</div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('FAMILY_NATION_ID','FAMILY_NATION_ID',$arr_snation, "สัญชาติ", $rec['FAMILY_NATION_ID'],'','','1'); ?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">เชื้อชาติ :&nbsp;</div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('FAMILY_RACE_NATION_ID','FAMILY_RACE_NATION_ID',$arr_snation, "เชื้อชาติ", $rec['FAMILY_RACE_NATION_ID'],'','','1'); ?></div>
                    <div class="col-xs-12 col-md-2"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">ศาสนา :</div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('FAMILY_RELIGION_ID','FAMILY_RELIGION_ID',$arr_sreligion, "ศาสนา", $rec['FAMILY_RELIGION_ID'],'','','1'); ?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">อาชีพ :&nbsp;</div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('FAMILY_JOB_ID','FAMILY_JOB_ID',$arr_sjob, "อาชีพ", $rec['FAMILY_JOB_ID'],'onChange=chkOther(this.value);','','1'); ?></div>
                    <div class="col-xs-12 col-md-2"></div>
                    <span id="shw_job_other">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">โปรดระบุ : </div>
                    <div class="col-xs-12 col-md-2"> <?php echo text($rec['FAMILY_JOB_OTHER']);?></div>
                    </span>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">สถานะการมีชีวิต :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v2('FAMILY_STATUS','FAMILY_STATUS',$arr_family_status, "สถานะการมีชีวิต", $rec['FAMILY_STATUS'],'onchange="chkFamilyStatus(this.value);"','','1', '', '2'); ?></div>
                </div>
            </div>
        </div>
        
        <span id="shw_family_type1_1">
            <div class="panel-group" id="accordion">
                <div class="row head-form">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse7" onClick="$('.switchPic7').toggle();">
                            <img class="switchPic7" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                            <img class="switchPic7" src="<?php echo $path;?>images/clse.gif" >
                            ข้อมูลใบมรณะบัตร
                        </a>
                    </div>
                </div>
                
                <div id="collapse7" class="collapse in">
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ :</div>
                        <div class="col-xs-12 col-md-2"><?php echo text($rec['DIED_NO']); ?></div>
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ลงวันที่ :</div>
                        <div class="col-xs-12 col-md-2">
                            <div class="input-group">
                                 <?php echo  conv_date($rec["DIED_DATE"]);?>
                                 
                            </div>
                        </div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่เสียชีวิต :</div>
                        <div class="col-xs-12 col-md-2">
                            <div class="input-group">
                                 <?php echo  conv_date($rec["DIED_SDATE"]);?>
                                 
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สาเหตุที่เสียชีวิต :</div>
                        <div class="col-xs-12 col-md-3"> <?php echo text($rec['DIED_REASON']); ?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานที่เสียชีวิต :</div>
                        <div class="col-xs-12 col-md-3"> <?php echo text($rec['DIED_PLACE']); ?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัด :</div>
                        <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('DIED_PROV_ID','DIED_PROV_ID',$arr_prov,'จังหวัด',$rec['DIED_PROV_ID'], 'onchange="getRampr(this,\'DIED_AMPR_ID\',\'DIED_TAMB_ID\', \'ss_died_ampr\');" ','','1');?></div>
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อำเภอ/เขต :</div>
                        <div class="col-xs-12 col-md-2"><span id='ss_died_ampr'><?php echo GetHtmlSelect_v('DIED_AMPR_ID','DIED_AMPR_ID',$arr_ampr_died,'อำเภอ/เขต',$rec['DIED_AMPR_ID'],'','1');?></span></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ไฟล์แนบ :</div>
                        <div class="col-xs-12 col-md-3">
                        	<div class="input-group"  >
                                <input type="file" style="display:none;" id="DIED_FILE" name="DIED_FILE"  class="form-control" placeholder="ไฟล์แนบ" value="<?php echo text($rec['DIED_FILE']); ?>">
                                <?php echo displayDownloadFileAttach($path_a,$rec['DIED_FILE'],$arr_txt['download']);?>
                            </div>
                            <input type="hidden" id="OLD_DIED_FILE" name="OLD_DIED_FILE"   value="<?php echo !empty($rec["DIED_FILE"])?text($rec["DIED_FILE"]):""; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </span>        
        
        <div class="panel-group" id="accordion">
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onClick="$('.switchPic2').toggle();">
                        <img class="switchPic2" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                        <img class="switchPic2" src="<?php echo $path;?>images/clse.gif" >
                        ข้อมูลที่ติดต่อบุคคลในครอบครัว
                    </a>
                </div>
            </div>
            
            <div id="collapse2" class="collapse in">
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเทศ :&nbsp;</div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('ADDRESS_COUNTRY_ID','ADDRESS_COUNTRY_ID',$arr_country,'',$rec['ADDRESS_COUNTRY_ID'],'onchange="getcountry(this.value)"','','1');?></div>
                    <div class="col-xs-12 col-md-2"></div>
                    <span class="chk_city">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap">เมือง : </div>
                        <div class="col-xs-12 col-md-2"><?php echo text($rec['ADDRESS_CITY']);?></div>
                    </span>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ห้อง :&nbsp;</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($rec["ADDRESS_ROOM_NO"]); ?></div>  
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชั้น :</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($rec["ADDRESS_FLOOR"]); ?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อาคาร :&nbsp;</div>
                    <div class="col-xs-12 col-md-3"> <?php echo text($rec["ADDRESS_BUILDING"]); ?></div>  
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">บ้านเลขที่ :</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($rec["ADDRESS_HOME_NO"]); ?></div>
                </div>
            	
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่ที่ :</div>
                    <div class="col-xs-12 col-md-3"> <?php echo text($rec["ADDRESS_MOO"]); ?></div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่บ้าน :</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($rec["ADDRESS_VILLAGE"]); ?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ซอย :</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($rec["ADDRESS_SOI"]); ?></div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ถนน :</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($rec["ADDRESS_ROAD"]); ?></div>
                </div>
                	                                        
                <div class="chk_country">
                    <div class="row formSep" <?php echo ($rec['ADDRESS_COUNTRY_ID'] == $default_country_id)?"":"style='display:none'";?>>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัด :&nbsp;</div>
                        <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('ADDRESS_PROV_ID','ADDRESS_PROV_ID',$arr_prov,'จังหวัด',$rec['ADDRESS_PROV_ID'], 'onchange="getRampr(this,\'ADDRESS_AMPR_ID\',\'ADDRESS_TAMB_ID\', \'ss_ampr\', \'ss_tamb\');getTelClass(this.value, \''.$key.'\');$(\'#ADDRESS_POSTCODE\').val(\'\');" ','','1');?></div>
                        <div class="col-xs-12 col-md-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อำเภอ/เขต :&nbsp;</div>
                        <div class="col-xs-12 col-md-2"><span id='ss_ampr'><?php echo GetHtmlSelect_v('ADDRESS_AMPR_ID','ADDRESS_AMPR_ID',$arr_ampr_addr,'อำเภอ/เขต',$rec['ADDRESS_AMPR_ID'],'onchange="getStamb(this,this.value,\'ADDRESS_TAMB_ID'.'\', \'ss_tamb\');"','','1');?></span></div>
                    </div>
                    
                    <div class="row formSep" <?php echo ($rec['ADDRESS_COUNTRY_ID'] == $default_country_id)?"":"style='display:none'";?>>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ตำบล/แขวง :&nbsp;</div>
                        <div class="col-xs-12 col-md-2"><span id='ss_tamb'><?php echo GetHtmlSelect_v('ADDRESS_TAMB_ID','ADDRESS_TAMB_ID',$arr_tamb,'ตำบล/แขวง',$rec['ADDRESS_TAMB_ID'],'onchange="getZip(this.id,this.value,\'ADDRESS_POSTCODE\')"','','1');?></span></div>
                        <div class="col-xs-12 col-md-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">รหัสไปรษณีย์ :&nbsp;</div>
                        <div class="col-xs-12 col-md-2"><?php echo text($rec['ADDRESS_POSTCODE']); ?></div>
                    </div>
                </div>
                    
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมายเลขโทรศัพท์ :</div>
                    <div class="col-xs-12 col-md-2"><?php echo text($rec['ADDRESS_TEL']); ?></div>
                    <div class="col-xs-12 col-sm-1">
                        <div class="input-group">
                        <?php if(!isset($rec['ADDRESS_TEL_EXT'])){ ?>
                            <span class="input-group-addon">ต่อ</span>
                            <?php } ?>
                             <?php echo $rec['ADDRESS_TEL_EXT']; ?>
                        </div>	
                    </div>
                    <div class="col-xs-12 col-sm-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมายเลขโทรสาร :</div>
                    <div class="col-xs-12 col-md-2"><?php echo text($rec['ADDRESS_FAX']); ?></div>
                    <div class="col-xs-12 col-sm-1">
                        <div class="input-group">
                         <?php if(!isset($rec['ADDRESS_FAX_EXT'])){ ?>
                            <span class="input-group-addon">ต่อ</span>
                            <?php } ?>
                            <?php echo $rec['ADDRESS_FAX_EXT']; ?>
                        </div>	
                    </div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมายเลขโทรศัพท์เคลื่อนที่ :</div>
                    <div class="col-xs-12 col-md-2"><?php echo text($rec['ADDRESS_MOBILE']); ?></div>
                    <div class="col-xs-12 col-sm-2"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อีเมล์ :</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($rec['ADDRESS_EMAIL']); ?></div>
                </div>
            </div>
        </div>
        
        <span id="shw_family_type3">
            <div class="panel-group" id="accordion">
                <div class="row head-form">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onClick="$('.switchPic3').toggle();">
                            <img class="switchPic3" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                            <img class="switchPic3" src="<?php echo $path;?>images/clse.gif" >
                            ข้อมูลการสมรส
                        </a>
                    </div>
                </div>
                
                <div id="collapse3" class="collapse in">
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">การสมรสแบบ :</div>
                        <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('MARRY_TYPE','MARRY_TYPE',$arr_marry_type, "การสมรสแบบ", $rec['MARRY_TYPE'],'','','1', '', '2'); ?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ลำดับครั้งการสมรส :</div>
                        <div class="col-xs-12 col-md-1"><?php echo text($rec['MARRY_SEQ']); ?></div>
                        <div class="col-xs-12 col-sm-3"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานะของการสมรส :</div>
                        <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('MARRY_STATUS','MARRY_STATUS',$arr_marry_status, "สถานะของการสมรส", $rec['MARRY_STATUS'],'onchange="chkMarryStatus(this.value);"','','1', '', '2'); ?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ :</div>
                        <div class="col-xs-12 col-md-1"> <?php echo text($rec['MARRY_NO']); ?></div>
                        <div class="col-xs-12 col-sm-3"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ลงวันที่ :</div>
                        <div class="col-xs-12 col-md-2">
                            <div class="input-group">
                                 <?php echo  conv_date($rec["MARRY_DATE"]);?>
                                <span class="input-group-addon datepicker" for="MARRY_DATE" >&nbsp;
                                <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัด :</div>
                        <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('MARRY_PROV_ID','MARRY_PROV_ID',$arr_prov,'จังหวัด',$rec['MARRY_PROV_ID'], 'onchange="getRampr(this,\'MARRY_AMPR_ID\',\'MARRY_TAMB_ID\',\'ss_marry_ampr\');" ','','1');?></div>
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อำเภอ/เขต :</div>
                        <div class="col-xs-12 col-md-2"><span id='ss_marry_ampr'><?php echo GetHtmlSelect_v('MARRY_AMPR_ID','MARRY_AMPR_ID',$arr_ampr_marry,'อำเภอ/เขต',$rec['MARRY_AMPR_ID'],'','1');?></span></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อสกุลเดิม (ไทย) :</div>
                        <div class="col-xs-12 col-md-2"><?php echo text($rec['MARRY_LASTNAME_TH']); ?></div>
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อสกุลเดิม (อังกฤษ) :</div>
                        <div class="col-xs-12 col-md-2"><?php echo text($rec['MARRY_LASTNAME_EN']); ?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ไฟล์แนบ :</div>
                        <div class="col-xs-12 col-md-3">
                        	<div class="input-group"  >
                                <input type="file" id="MARRY_FILE" style="display:none;" name="MARRY_FILE"  class="form-control" placeholder="ไฟล์แนบ" value="<?php echo text($rec['MARRY_FILE']); ?>">
                                <?php echo displayDownloadFileAttach($path_a,$rec['MARRY_FILE'],$arr_txt['download']);?>
                            </div>
                            <input type="hidden" id="OLD_MARRY_FILE" name="OLD_MARRY_FILE"   value="<?php echo !empty($rec["MARRY_FILE"])?text($rec["MARRY_FILE"]):""; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </span>
        
        <span id="shw_family_type3_1">
            <div class="panel-group" id="accordion">
                <div class="row head-form">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" onClick="$('.switchPic4').toggle();">
                            <img class="switchPic4" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                            <img class="switchPic4" src="<?php echo $path;?>images/clse.gif" >
                            ข้อมูลการหย่า
                        </a>
                    </div>
                </div>
                
                <div id="collapse4" class="collapse in">
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ :</div>
                        <div class="col-xs-12 col-md-2"> <?php echo text($rec['DIVORCE_NO']); ?></div>
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ลงวันที่ :</div>
                        <div class="col-xs-12 col-md-2">
                            <div class="input-group">
                                <?php echo  conv_date($rec["DIVORCE_DATE"]);?>
                                 
                            </div>
                        </div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัด :</div>
                        <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('DIVORCE_PROV_ID','DIVORCE_PROV_ID',$arr_prov,'จังหวัด',$rec['DIVORCE_PROV_ID'], 'onchange="getRampr(this,\'DIVORCE_AMPR_ID\',\'DIVORCE_TAMB_ID\',\'ss_divorce_ampr\');" ','','1');?></div>
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อำเภอ/เขต :</div>
                        <div class="col-xs-12 col-md-2"><span id='ss_divorce_ampr'><?php echo GetHtmlSelect_v('DIVORCE_AMPR_ID','DIVORCE_AMPR_ID',$arr_ampr_divorce,'อำเภอ/เขต',$rec['DIVORCE_AMPR_ID'],'','1');?></span></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ไฟล์แนบ :</div>
                        <div class="col-xs-12 col-md-3">
                        	<div class="input-group"  >
                                <input type="file" id="DIVORCE_FILE" style="display:none;" name="DIVORCE_FILE"  class="form-control" placeholder="ไฟล์แนบ" value="<?php echo text($rec['DIVORCE_FILE']); ?>">
                                <?php echo displayDownloadFileAttach($path_a,$rec['DIVORCE_FILE'],$arr_txt['download']);?>
                            </div>
                            <input type="hidden" id="OLD_DIVORCE_FILE" name="OLD_DIVORCE_FILE"   value="<?php echo !empty($rec["DIVORCE_FILE"])?text($rec["DIVORCE_FILE"]):""; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </span>
        
        <span id="shw_family_type4">
            <div class="panel-group" id="accordion">
                <div class="row head-form">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" onClick="$('.switchPic5').toggle();">
                            <img class="switchPic5" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                            <img class="switchPic5" src="<?php echo $path;?>images/clse.gif" >
                            ข้อมูลใบสูติบัตร
                        </a>
                    </div>
                </div>
                
                <div id="collapse5" class="collapse in">
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ :</div>
                        <div class="col-xs-12 col-md-2"><?php echo text($rec['BIRTH_NO']); ?></div>
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ลงวันที่ :</div>
                        <div class="col-xs-12 col-md-2">
                            <div class="input-group">
                                 <?php echo  conv_date($rec["BIRTH_DATE"]);?>
                                 
                            </div>
                        </div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เป็นบุตรลำดับที่ :</div>
                        <div class="col-xs-12 col-md-1"><?php echo text($rec['BIRTH_SEQ']); ?></div>
                        <div class="col-xs-12 col-sm-3"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ออก ณ :</div>
                        <div class="col-xs-12 col-md-3"><?php echo text($rec['BIRTH_PLACE']); ?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">คู่สมรส :</div>
                        <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('BIRTH_MARRY_ID','BIRTH_MARRY_ID',$arr_family,'คู่สมรส',$rec['BIRTH_MARRY_ID'], '','','1','','2');?></div>
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ไฟล์แนบ :</div>
                        <div class="col-xs-12 col-md-3">
                        	<div class="input-group"  >
                                <input type="file" id="BIRTH_FILE" style="display:none;" name="BIRTH_FILE"  class="form-control" placeholder="ไฟล์แนบ" value="<?php echo text($rec['BIRTH_FILE']); ?>">
                                <?php echo displayDownloadFileAttach($path_a,$rec['BIRTH_FILE'],$arr_txt['download']);?>
                            </div>
                            <input type="hidden" id="OLD_BIRTH_FILE" name="OLD_BIRTH_FILE"   value="<?php echo !empty($rec["BIRTH_FILE"])?text($rec["BIRTH_FILE"]):""; ?>">
                        </div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ทะเบียนรับรองบุตร/คำสั่งศาล :</div>
                        <div class="col-xs-12 col-md-2"> <?php echo text($rec['BIRTH_CERT_NO']); ?></div>
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ลงวันที่ :</div>
                        <div class="col-xs-12 col-md-2">
                            <div class="input-group">
                                 <?php echo  conv_date($rec["BIRTH_CERT_DATE"]);?>
                                 
                            </div>
                        </div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ออก ณ :</div>
                        <div class="col-xs-12 col-md-3"> <?php echo text($rec['BIRTH_CERT_PLACE']); ?></div>
                        <div class="col-xs-12 col-sm-1"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ไฟล์แนบ :</div>
                        <div class="col-xs-12 col-md-3">
                        	<div class="input-group"  >
                                <input type="file" id="BIRTH_CERT_FILE" style="display:none;" name="BIRTH_CERT_FILE"  class="form-control" placeholder="ไฟล์แนบ" value="<?php echo text($rec['BIRTH_CERT_FILE']); ?>">
                                <?php echo displayDownloadFileAttach($path_a,$rec['BIRTH_CERT_FILE'],$arr_txt['download']);?>
                            </div>
                            <input type="hidden" id="OLD_BIRTH_CERT_FILE" name="OLD_BIRTH_CERT_FILE"   value="<?php echo !empty($rec["BIRTH_CERT_FILE"])?text($rec["BIRTH_CERT_FILE"]):""; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </span>
        
        <span id="shw_family_type5">
            <div class="panel-group" id="accordion">
                <div class="row head-form">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse6" onClick="$('.switchPic6').toggle();">
                            <img class="switchPic6" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                            <img class="switchPic6" src="<?php echo $path;?>images/clse.gif" >
                            ข้อมูลบุตรบุญธรรม
                        </a>
                    </div>
                </div>
                
                <div id="collapse6" class="collapse in">
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ใบรับรองบุตรบุญธรรม :</div>
                        <div class="col-xs-12 col-md-2"><?php echo text($rec['PROTEGE_SNO']); ?></div>
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ลงวันที่ :</div>
                        <div class="col-xs-12 col-md-2">
                            <div class="input-group">
<?php echo  conv_date($rec["PROTEGE_SDATE"]);?>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัด :</div>
                        <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('PROTEGE_SPROV_ID','PROTEGE_SPROV_ID',$arr_prov,'จังหวัด',$rec['PROTEGE_SPROV_ID'], 'onchange="getRampr(this,\'PROTEGE_SAMPR_ID\',\'PROTEGE_STAMB_ID\',\'ss_protege_sampr\');" ','','1');?></div>
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อำเภอ/เขต :</div>
                        <div class="col-xs-12 col-md-2"><span id='ss_protege_sampr'><?php echo GetHtmlSelect_v('PROTEGE_SAMPR_ID','PROTEGE_SAMPR_ID',$arr_ampr_sprotege,'อำเภอ/เขต',$rec['PROTEGE_SAMPR_ID'],'','1');?></span></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ไฟล์แนบ :</div>
                        <div class="col-xs-12 col-md-3">
                        	<div class="input-group"  >
                                <input type="file" id="PROTEGE_SFILE" style="display:none;" name="PROTEGE_SFILE"  class="form-control" placeholder="ไฟล์แนบ" value="<?php echo text($rec['PROTEGE_SFILE']); ?>">
                                <?php echo displayDownloadFileAttach($path_a,$rec['PROTEGE_SFILE'],$arr_txt['download']);?>
                            </div>
                            <input type="hidden" id="OLD_PROTEGE_SFILE" name="OLD_PROTEGE_SFILE"   value="<?php echo !empty($rec["PROTEGE_SFILE"])?text($rec["PROTEGE_SFILE"]):""; ?>">
                        </div>
                        <div class="col-xs-12 col-sm-1"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานะของการรับรองบุตรบุญธรรม :</div>
                        <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('PROTEGE_STATUS','PROTEGE_STATUS',$arr_protege_status,'สถานะของการรับรองบุตรบุญธรรม',$rec['PROTEGE_STATUS'], 'onchange="chkProtegeStatus(this.value);"','','1','','2');?></div>
                    </div>
                    
                    <span id="shw_protege_e">
                        <div class="row formSep">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ใบเลิกรับบุตรบุญธรรม :</div>
                            <div class="col-xs-12 col-md-2"><?php echo text($rec['PROTEGE_ENO']); ?></div>
                            <div class="col-xs-12 col-sm-2"></div>
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ลงวันที่ :</div>
                            <div class="col-xs-12 col-md-2">
                                <div class="input-group">
                                   <?php echo  conv_date($rec["PROTEGE_EDATE"]);?> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="row formSep">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัด :</div>
                            <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect_v('PROTEGE_EPROV_ID','PROTEGE_EPROV_ID',$arr_prov,'จังหวัด',$rec['PROTEGE_EPROV_ID'], 'onchange="getRampr(this,\'PROTEGE_EAMPR_ID\',\'PROTEGE_ETAMB_ID\',\'ss_protege_eampr\');" ','','1');?></div>
                            <div class="col-xs-12 col-sm-2"></div>
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อำเภอ/เขต :</div>
                            <div class="col-xs-12 col-md-2"><span id='ss_protege_eampr'><?php echo GetHtmlSelect_v('PROTEGE_EAMPR_ID','PROTEGE_EAMPR_ID',$arr_ampr_eprotege,'อำเภอ/เขต',$rec['PROTEGE_EAMPR_ID'],'','1');?></span></div>
                        </div>
                        
                        <div class="row formSep">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ไฟล์แนบ :</div>
                            <div class="col-xs-12 col-md-3">
                                <div class="input-group"  >
                                    <input type="file" id="PROTEGE_EFILE" name="PROTEGE_EFILE"  style="display:none;" class="form-control" placeholder="ไฟล์แนบ" value="<?php echo text($rec['PROTEGE_EFILE']); ?>">
                                    <?php echo displayDownloadFileAttach($path_a,$rec['PROTEGE_EFILE'],$arr_txt['download']);?>
                                </div>
                            <input type="hidden" id="OLD_PROTEGE_EFILE" name="OLD_PROTEGE_EFILE"   value="<?php echo !empty($rec["PROTEGE_EFILE"])?text($rec["PROTEGE_EFILE"]):""; ?>">
                            </div>
                        </div>
                    </span>
                </div>
            </div>
        </span>
         
       
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>