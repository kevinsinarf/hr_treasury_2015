<?php
$path = "../../";
include($path."include/config_header_top.php");
//echo $PER_ID;
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;  /// for mobile
$paramlink = url2code($link);
$path_img='../fileupload/profile_his/';
//POST
$ATTENTYPE_ID=$_POST['ATTENTYPE_ID'];
$proc = empty($proc)?'edit':$proc;
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 
//tab active
$ACT = 1;
//page back
//echo $PT_ID ;
if($PT_ID=="2"){
	$page_back = "profile_his_empser.php";
	$POSTYPE_ID = '3';
	$TXT_TYPE = "ประเภทพนักงานราชการ";
	$TXT_LEVEL = "ประเภทกลุ่มงาน";
	$TXT_LINE = "ตำแหน่ง";
}elseif($PT_ID=="3"){
	$page_back = "profile_his_emp.php";
	$POSTYPE_ID = '5';
	$TXT_TYPE = "กลุ่มงาน";
	$TXT_LEVEL = "ระดับ";
	$TXT_LINE = "ตำแหน่งในสายงาน";
}else{
	$page_back = "profile_his_disp.php";
	$POSTYPE_ID = '1';
	$TXT_TYPE = $arr_txt['type_pos'];
	$TXT_LEVEL = "ระดับตำแหน่ง";
	$TXT_LINE = "ตำแหน่งในสายงาน";
}

//DATA
$sql = "select A.*, B.TYPE_NAME_TH, C.LEVEL_NAME_TH, D.LINE_NAME_TH, E.MANAGE_NAME_TH
FROM PER_PROFILE A
LEFT JOIN SETUP_POS_TYPE B ON A.TYPE_ID = B.TYPE_ID
LEFT JOIN SETUP_POS_LEVEL C ON A.LEVEL_ID = C.LEVEL_ID
LEFT JOIN SETUP_POS_LINE D ON A.LINE_ID = D.LINE_ID
LEFT JOIN SETUP_POS_MANAGE E ON A.MANAGE_ID = E.MANAGE_ID 
where A.PER_ID = '".$PER_ID."' ";
$query = $db->query($sql);
$data = $db->db_fetch_array($query);

$ORG_ID_1 = trim($data['ORG_ID_1']);
$ORG_ID_2 = trim($data['ORG_ID_2']);
$CV_ID = trim($data['CV_ID']);

if($ORG_ID_1 == ''){
	$ORG_ID_1 = 405;
}
if($ORG_ID_2 == ''){
	$ORG_ID_2 = 15;
}
if($CV_ID == ''){
	$CV_ID = 1;
}

//ประเภทบุคลากร
$arr_personal_type=GetSqlSelectArray("PT_ID", "PT_NAME_TH", "PERSONAL_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PT_NAME_TH");
//ประเภทตำแหน่ง
//$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "TYPE_SEQ");
//ระดับตำแหน่ง/กลุ่มงาน
//$arr_pos_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LEVEL_NAME_TH");
//ตำแหน่งในสายงาน
//$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LINE_NAME_TH");
//ตำแหน่งในการบริหาร
//$arr_manage=GetSqlSelectArray("MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "MANAGE_NAME_TH");

//org1
$arr_org1=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.OL_ID = 2 AND a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' ", "ORG_NAME_TH");
//org2
$arr_org2=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", " a.ORG_PARENT_ID ='".$ORG_ID_1."' AND a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' ", "ORG_NAME_TH");			
//org3
$arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$ORG_ID_2."' ", "ORG_NAME_TH");
//org4
$arr_org4=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$data['ORG_ID_3']."'  ", "ORG_NAME_TH");
//org5
$arr_org5=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$data['ORG_ID_4']."' ", "ORG_NAME_TH");

//org5
$arr_org6=GetSqlSelectArray("a.CV_ID", "a.CV_NAME_TH", "ANNOUNCE_SETUP_CIVIL_TYPE as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' ", "CV_NAME_TH");

$arr_retype2 = GetSqlSelectArray("RETYPE_ID","RETYPE_NAME_TH","RETIRE_SETUP_TYPE"," ACTIVE_STATUS=1 and DELETE_FLAG='0' ","RETYPE_NAME_TH" );
$arr_prefix=GetSqlSelectArray("PREFIX_ID", "PREFIX_NAME_TH", "V_PREFIX", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PREFIX_SEQ,PREFIX_NAME_TH"); //คำนำหน้าชื่อ th
$arr_snation=GetSqlSelectArray("NATION_ID", "NATION_NAME_TH", "SETUP_NATION", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "NATION_NAME_TH");//สัญชาติ
$arr_sreligion=GetSqlSelectArray("RELIGION_ID", "RELIGION_NAME_TH", "SETUP_RELIGION", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "RELIGION_CODE");//ศาสนา
//echo "<pre>"; print_r($arr_retype2); exit();
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
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_his_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="<?php echo $page_back."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt.text($arr_personal_type[$PT_ID]);?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content">
        <?php 
		if(!empty($PER_ID)){
		include("tab_profile.php");?>
        <div class="grouptab">
        <?php }else{?>
        <div class="groupdata">
        <?php }?>
            <form id="frm-input" method="post" action="process/profile_his_proc.php" enctype="multipart/form-data" >
            	<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
            	<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID; ?>">
				<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        		<input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
       
    
                    <div class="panel-group" id="accordion">
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();">
                                    <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >
                                    ข้อมูลทั่วไป
                                </a>
                            </div>
                        </div>
                        <div id="collapse1" class="collapse in" >
                            
                            <div class="col-xs-12 col-sm-10" >
                                <div class="row formSep visible-xs">
                                    <div class="col-xs-12 col-md-6 col-sm-offset-2">
                                        <div class="col-xs-6 col-md-6"><?php echo showPic_per($data['PER_FILE_PIC']);?></div>
                                    </div>
                                </div>
                                
                                <div class="row formSep">
                                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['idcard'];?> : <span style="color:red;">*</span>&nbsp;</div>
                                    <div class="col-xs-12 col-sm-2"><input type="text" id="PER_IDCARD" name="PER_IDCARD" class="form-control idcard" placeholder="<?php echo $arr_txt['idcard'];?>"  maxlength="13" value="<?php echo $data['PER_IDCARD']; ?>"></div> 
                                </div>
                                             
                                <div class="row formSep">
                                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['title'];?> : <span style="color:red;">*</span>&nbsp;</div>
                                    <div class="col-xs-12 col-sm-2"><?php echo GetHtmlSelect('PREFIX_ID','PREFIX_ID',$arr_prefix,$arr_txt['title']." (".$arr_txt['th'].")",$data['PREFIX_ID'],'','','1'); ?></div>
                                    <div class="col-xs-12 col-sm-2"></div>
                                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">เพศ :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                                    <div class="col-xs-6 col-md-1"><label ><input type="radio" id="GENDER1" name="GENDER"  value="1" <?php echo ($data['PER_GENDER']=='1'||$data['PER_GENDER']=='' ?"checked":"")?>> ชาย</label></div>
                                    <div class="col-xs-6 col-md-1"><label ><input type="radio" id="GENDER2" name="GENDER" value="2" <?php echo ($data['PER_GENDER']=='2'?"checked":"")?> > หญิง</label></div>
                                </div>
                            </div>
                            <!-- -->
                            <div class="col-xs-12 col-sm-2 visible-lg"  >
                                <div class="col-xs-12 col-sm-12"><?php echo showPic_per($data['PER_FILE_PIC']);?></div>
                            </div>
                            <div class="row"></div>
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['fname'].$arr_txt['th']; ?> : <span style="color:red;">*</span></div>
                                <div class="col-xs-12 col-sm-2"><input type="text" id="fname_th" name="fname_th" class="form-control" placeholder="<?php echo $arr_txt['fname'].$arr_txt['th']; ?>" value="<?php echo text($data['PER_FIRSTNAME_TH']) ;?>" maxlength="100"></div> 
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['mname'].$arr_txt['th']; ?> : </div>
                                <div class="col-xs-12 col-sm-2"><input type="text" id="mname_th" name="mname_th" class="form-control" placeholder="<?php echo $arr_txt['mname'].$arr_txt['th']; ?>" value="<?php echo text($data['PER_MIDNAME_TH']) ;?>" maxlength="100"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['lname'].$arr_txt['th']; ?> : <span style="color:red;">*</span></div>
                                <div class="col-xs-12 col-sm-2"><input type="text" id="lname_th" name="lname_th" class="form-control" placeholder="<?php echo $arr_txt['lname'].$arr_txt['th']; ?>" value="<?php echo text($data['PER_LASTNAME_TH']) ;?>" maxlength="100"></div>							
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['fname'].$arr_txt['en']; ?> : </div>
                                <div class="col-xs-12 col-sm-2"><input type="text" id="fname_en" name="fname_en" class="form-control" placeholder="<?php echo $arr_txt['fname'].$arr_txt['en']; ?>" value="<?php echo text($data['PER_FIRSTNAME_EN']) ;?>" maxlength="100"></div> 
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['mname'].$arr_txt['en']; ?> : </div>
                                <div class="col-xs-12 col-sm-2"><input type="text" id="mname_en" name="mname_en" class="form-control" placeholder="<?php echo $arr_txt['mname'].$arr_txt['en']; ?>" value="<?php echo text($data['PER_MIDNAME_EN']) ;?>" maxlength="100"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['lname'].$arr_txt['en']; ?> : </div>
                                <div class="col-xs-12 col-sm-2"><input type="text" id="lname_en" name="lname_en" class="form-control" placeholder="<?php echo $arr_txt['lname'].$arr_txt['en']; ?>" value="<?php echo text($data['PER_LASTNAME_EN']) ;?>" maxlength="100"></div>							
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">หมู่โลหิต : </div>
                                <div class="col-xs-12 col-sm-2">
                                    <select id="BLOOD_TYPE" name="BLOOD_TYPE" class="selectbox form-control" placeholder="หมู่โลหิต">
                                        <option value="" ></option>
                                        <?php foreach ($arr_blood as $key => $value){  ?>
                                        <option value="<?php echo $key ; ?>" <?php echo ($data['PER_BLOOD_TYPE'] == $key?"selected":"");?>><?php echo $value;?></option>
                                        <?php }?>
                                    </select>						
                                </div> 
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันเดือนปีเกิด : <span style="color:red;">*</span> </div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                        <?php $PER_BIRTHDATE_is = conv_date($data["PER_DATE_BIRTH"]) ?>
                                        <input type="text" id="DATE_BIRTH" name="DATE_BIRTH" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  $PER_BIRTHDATE_is;?>">         
                                       
                                        <span class="input-group-addon datepicker" for="DATE_BIRTH" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>	
                                </div> 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สัญชาติ :  </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelect('NATION_ID','NATION_ID',$arr_snation,'สัญชาติ',empty($data['NATION_ID'])?$default_nation_id:$data['NATION_ID'],'','','1');?></div> 
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">เชื้อชาติ :  </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelect('RACE_NATION_ID','RACE_NATION_ID',$arr_snation,'เชื้อชาติ',empty($data['RACE_NATION_ID'])?$default_nation_id:$data['RACE_NATION_ID'],'','','1');?></div>
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ศาสนา : </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelect('RELIGION_ID','RELIGION_ID',$arr_sreligion,'ศาสนา',empty($data['RELIGION_ID'])?$default_religion_id:$data['RELIGION_ID'],'','','1');?></div>							
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สีผิว :</div>
                                <div class="col-xs-12 col-sm-2"><input type="text" id="SKIN_COLOR" name="SKIN_COLOR" class="form-control" placeholder="สีผิว" maxlength="255"  value="<?php echo  text($data["PER_SKIN_COLOR"]);?>"></div> 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ส่วนสูง (ซ.ม.) : </div>
                                <div class="col-xs-12 col-sm-2"><input type="text" id="HEIGHT" name="HEIGHT" class="form-control" placeholder="ส่วนสูง (ซ.ม.)" maxlength="10"  value="<?php echo  text($data["PER_HEIGHT"]);?>" onKeyUp="chkFormatNam(this.value,this.id);"></div>
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">น้ำหนัก (ก.ก.) : </div>
                                <div class="col-xs-12 col-sm-2"><input type="text" id="WEIGHT" name="WEIGHT" class="form-control" placeholder="น้ำหนัก (ก.ก.)" maxlength="10"  value="<?php echo  text($data["PER_WEIGHT"]);?>"onkeyup="chkFormatNam(this.value,this.id);" ></div>							
                            </div>	
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">รอยตำหนิ :</div>
                                <div class="col-xs-12 col-sm-8"><textarea id="SKIN_MARKUP" name="SKIN_MARKUP" class="form-control" placeholder="รอยตำหนิ" maxlength="255"  ><?php echo  text(trim($data["PER_SKIN_MARKUP"]));?></textarea></div> 		
                            </div>
                        </div>
                        </div>
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onClick="$('.switchPic2').toggle();">
                                    <img class="switchPic2" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic2" src="<?php echo $path;?>images/clse.gif" >
                                    ข้อมูลตำแหน่ง
                                </a>
                            </div>
                        </div>
                        
                        <div id="collapse2" class="collapse in">
                        	<div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['pos_no']; ?> : <span style="color:red;">*</span></div>
                                <div class="col-xs-12 col-sm-3">
                                    <div class="input-group" id="ss_name_out">
                                        <input type="text" name="POS_NO" id="POS_NO" class="form-control" placeholder="<?php echo $arr_txt['pos_no']; ?>" readonly value="<?php echo $data["POS_NO"]; ?>">
                                        <input type="hidden" name="POS_ID_OLD" id="POS_ID_OLD" value="<?php echo $data["POS_ID"]; ?>">
                                        <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="<?php echo $POSTYPE_ID ?>">
                                        <input type="hidden" name="POS_ID" id="POS_ID" value="<?php echo $data["POS_ID"]; ?>" >
                                        <span class="input-group-addon" data-toggle="modal" data-target="#myModal" onClick="show_pop();" >
                                        <span class="glyphicon glyphicon-search"></span></span>
                                    </div>
                                </div> 
                            </div>	
                        	<div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ประเภทข้าราชการ : <span style="color:red;">*</span></div>
                                <div class="col-xs-12 col-sm-3">
									<?php  echo GetHtmlSelect3('CV_ID','CV_ID',$arr_org6,"ประเภทข้าราชการ",$CV_ID,'','','1');  ?>                          
								</div> 
                            	</div>	
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $TXT_TYPE; ?> : </div>
                                <div class="col-xs-12 col-sm-3">
                                    <label id="TYPE_NAME_TH"><?php  echo text($data['TYPE_NAME_TH']);?></label>
                                </div> 
                                <div class="col-xs-12 col-sm-1"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $TXT_LEVEL; ?> : </div>
                                <div class="col-xs-12 col-sm-3">
                                    <label id="LEVEL_NAME_TH"><?php  echo text($data['LEVEL_NAME_TH']);?></label>
                                </div> 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $TXT_LINE; ?> : </div>
                                <div class="col-xs-12 col-sm-3">
                                    <label id="LINE_NAME_TH"><?php  echo text($data['LINE_NAME_TH']);?></label>
                                </div> 
                                <?php if($POSTYPE_ID == 1){ ?>
                                <div class="col-xs-12 col-sm-1"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ตำแหน่งทางการบริหาร :</div>
                                <div class="col-xs-12 col-sm-3">
                                    <label id="MANAGE_NAME_TH"><?php  echo text($data['MANAGE_NAME_TH']);?></label>
                                </div> 
                                <?php } ?>
                            </div>
                            
                            <div class="row formSep">
                            	<div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">กระทรวง : <span style="color:red;">*</span></div>
                                <div class="col-xs-12 col-sm-3">
                                    <?php  echo GetHtmlSelect('ORG_ID_1','ORG_ID_1',$arr_org1,'กระทรวง',$ORG_ID_1,'onchange="getORG(this);"','','');?>
                                </div>
                                <div class="col-xs-12 col-sm-1"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">กรม : <span style="color:red;">*</span></div>
                                <div class="col-xs-12 col-sm-3">
                                    <?php  echo GetHtmlSelect('ORG_ID_2','ORG_ID_2',$arr_org2,'กรม',$ORG_ID_2,'onchange="getORG(this);"','','');?>
                                </div> 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ระดับกอง/สำนัก/กลุ่ม : </div>
                                <div class="col-xs-12 col-sm-3">
                                    <span id='ss_org3'>
                                    <?php  echo GetHtmlSelect('ORG_ID_3','ORG_ID_3',$arr_org3,'ระดับกอง/สำนัก/กลุ่ม',$data['ORG_ID_3'],'onchange="getORG(this);"','','1');?>
                                    </span>
                                </div> 
                                <div class="col-xs-12 col-sm-1"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ระดับส่วน/กลุ่มงาน : </div>
                                <div class="col-xs-12 col-sm-3">
                                    <span id='ss_org4'>
                                    <?php  echo GetHtmlSelect('ORG_ID_4','ORG_ID_4',$arr_org4,'ระดับส่วน/กลุ่มงาน ',$data['ORG_ID_4'],'','','1');?>
                                    </span>
                                </div> 
                            </div>
                        </div>
                        
                        
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onClick="$('.switchPic3').toggle();">
                                    <img class="switchPic3" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic3" src="<?php echo $path;?>images/clse.gif" >
                                    ข้อมูลรายได้
                                </a>
                            </div>
                        </div>
                        
                        <div id="collapse3" class="collapse in">
                        	<div class="row formSep">
                                <div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">เงินเดือน/ค่าตอบแทน/ค่าจ้าง : <span style="color:red;">*</span></div>
                                <div class="col-xs-12 col-sm-3"><input type="text" id="SALARY" name="SALARY" class="form-control" placeholder="เงินเดือน/ค่าตอบแทน/ค่าจ้าง" maxlength="10"  value="<?php echo  number_format($data["PER_SALARY"],2);?>" onBlur="NumberFormat(this,2);" style="width:200px; text-align:right;"></div> 
                                <div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">เงินประจำตำแหน่ง :</div>
                                <div class="col-xs-12 col-sm-3"><input type="text" id="SALARY_POSITION" name="SALARY_POSITION" class="form-control" placeholder="เงินประจำตำแหน่ง" maxlength="10"  value="<?php echo  number_format($data["PER_SALARY_POSITION"],2);?>"  onBlur="NumberFormat(this,2);" style="width:200px; text-align:right;"></div> 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">เงินค่าตอบแทนนอกเหนือจากเงินเดือน :</div>
                                <div class="col-xs-12 col-sm-3"><input type="text" id="COMPENSATION_1" name="COMPENSATION_1" class="form-control" placeholder="ค่าตอบแทนนอกเหนือจากเงินเดือน" maxlength="10"  value="<?php echo  number_format($data["PER_COMPENSATION_1"],2);?>" onBlur="NumberFormat(this,2);" style="width:200px; text-align:right;"></div> 
                                <div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">เงินค่าตอบแทนพิเศษ (เงินเดือนเต็มขั้น) : </div>
                                <div class="col-xs-12 col-sm-3"><input type="text" id="COMPENSATION_2" name="COMPENSATION_2" class="form-control" placeholder="ค่าตอบแทนพิเศษ (เงินเดือนเต็มขั้น)" maxlength="10"  value="<?php echo  number_format($data["PER_COMPENSATION_2"],2);?>" onBlur="NumberFormat(this,2);" style="width:200px; text-align:right;"></div> 
                            </div>
                            
                            <?php if($POSTYPE_ID == 5){ ?>
                            <div class="row formSep" id="postype_id_5">
                                <div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">ขั้นเงินเดือน : </div>
                                <div class="col-xs-12 col-sm-2"><input type="text" id="PER_STEP" name="PER_STEP" class="form-control" placeholder="ขั้นเงินเดือน" maxlength="10"  value="<?php echo  number_format($data["PER_STEP"],2);?>" onBlur="NumberFormat(this,2);" style="width:200px; text-align:right;"></div> 
                            </div>
                            <?php } ?>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">เงินเพิ่มพิเศษสำหรับการสู้รบ (พ.ส.ร.) :</div>
                                <div class="col-xs-12 col-sm-3"><input type="text" id="PER_COMPENSATION_3" name="PER_COMPENSATION_3" class="form-control" placeholder="เงินเพิ่มพิเศษสำหรับการสู้รบ (พ.ส.ร.)" maxlength="10"  value="<?php echo  number_format($data["PER_COMPENSATION_3"],2);?>" onBlur="NumberFormat(this,2);" style="width:200px; text-align:right;"></div> 
                                <div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">เงินเพิ่มค่าครองชีพชั่วคราว : </div>
                                <div class="col-xs-12 col-sm-2">
                                <input type="text" id="PER_COMPENSATION_4" name="PER_COMPENSATION_4" class="form-control" placeholder="เงินเพิ่มค่าครองชีพชั่วคราว" maxlength="10"  value="<?php echo  number_format($data["PER_COMPENSATION_4"],2);?>" onBlur="NumberFormat(this,2);" style="width:200px; text-align:right;">
                                </div> 
                        </div>
                        <div class="row formSep">
                        	<div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">เงินเพิ่มสำหรับตำแหน่งที่มีเหตุพิเศษ : </div>
                            <div class="col-xs-12 col-sm-2">
                            <input type="text" id="PER_COMPENSATION_5" name="PER_COMPENSATION_5" class="form-control" placeholder="เงินเพิ่มค่าครองชีพชั่วคราว" maxlength="10"  value="<?php echo  number_format($data["PER_COMPENSATION_5"],2);?>" onBlur="NumberFormat(this,2);" style="width:200px; text-align:right;">
                            </div> 
                        </div>
                        
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" onClick="$('.switchPic4').toggle();">
                                    <img class="switchPic4" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic4" src="<?php echo $path;?>images/clse.gif" >
                                    ข้อมูลช่วงเวลาที่สำคัญในการรับราชการ
                                </a>
                            </div>
                        </div>
                        
                        <div id="collapse4" class="collapse in">
                        	<div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่บรรจุ : <span style="color:red;">*</span> </div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="DATE_ENTRANCE" name="DATE_ENTRANCE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["PER_DATE_ENTRANCE"]);?>">
                                        <span class="input-group-addon datepicker" for="DATE_ENTRANCE" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่เข้าส่วนราชการ : </div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="DATE_OCCUPLY" name="DATE_OCCUPLY" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["PER_DATE_OCCUPLY"]);?>">
                                        <span class="input-group-addon datepicker" for="DATE_OCCUPLY" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>	
                                </div> 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">กำหนดวันเกษียณราชการ : <span style="color:red;">*</span></div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="DATE_RETIRE" name="DATE_RETIRE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php   echo  conv_date($data["PER_DATE_RETIRE"]);?>"> 
                                        <span class="input-group-addon datepicker" for="DATE_RETIRE" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>	
                                </div>
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่ประเมินการทดลองฯ ครั้งที่ 1 :</div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="PER_DATE_PRO1" name="PER_DATE_PRO1" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["PER_DATE_PRO1"]);?>"> 
                                        <span class="input-group-addon datepicker" for="PER_DATE_PRO1" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </div>                                 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่ประเมินการทดลองฯ ครั้งที่ 2 :</div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="PER_DATE_PRO2" name="PER_DATE_PRO2" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["PER_DATE_PRO2"]);?>">
                                        <span class="input-group-addon datepicker" for="PER_DATE_PRO2" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </div>                                 
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่ประเมินการทดลองฯ ครั้งที่ 3 :</div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="PER_DATE_PRO3" name="PER_DATE_PRO3" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["PER_DATE_PRO3"]);?>">
                                        <span class="input-group-addon datepicker" for="PER_DATE_PRO3" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </div>                                 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่ถือครองตำแหน่งปัจจุบัน :</div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="PER_DATE_POSITION" name="PER_DATE_POSITION" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["PER_DATE_POSITION"]);?>">
                                        <span class="input-group-addon datepicker" for="PER_DATE_POSITION" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </div>                                 
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่เริ่มถือครองระดับปัจจุบัน :</div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="PER_DATE_LEVEL" name="PER_DATE_LEVEL" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["PER_DATE_LEVEL"]);?>">
                                        <span class="input-group-addon datepicker" for="PER_DATE_LEVEL" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </div>                                 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่ออกจากราชการ :</div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="DATE_RESIGN" name="DATE_RESIGN" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["PER_DATE_RESIGN"]);?>">
                                        <span class="input-group-addon datepicker" for="DATE_RESIGN" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse6" onClick="$('.switchPic6').toggle();">
                                    <img class="switchPic6" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic6" src="<?php echo $path;?>images/clse.gif" >
                                    ข้อมูลสถานะต่างๆ
                                </a>
                            </div>
                        </div>
                        
                        <div id="collapse6" class="collapse in">
                          <div class="row formSep">
                           		<div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานะของการรับราชการ : <span style="color:red;">*</span></div>
                                <div class="col-xs-12 col-sm-2">
									<?php  echo GetHtmlSelectNoConv('PER_STATUS_CIVIL','PER_STATUS_CIVIL',$arr_status_civil,'สถานะของการรับราชการ',$data['PER_STATUS_CIVIL'],'','','1');?>
                                </div>
                                 <div class="col-xs-12 col-sm-2"></div>
                           		<div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานะของบุคคล : <span style="color:red;">*</span></div>
                                <div class="col-xs-12 col-sm-2">
									<?php  echo GetHtmlSelectNoConv('PER_STATUS','PER_STATUS',$arr_per_status,'สถานะของบุคคล',$data['PER_STATUS'],'','','1');?>
                                </div>
                           </div>	
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">การเป็นสมาชิก กบข. : <span style="color:red;">*</span></div>
                                <div class="col-xs-12 col-sm-2">
									<?php  echo GetHtmlSelectNoConv('GPF_STATUS','GPF_STATUS',$arr_gpf,'การเป็นสมาชิก กบข.',$data['GPF_STATUS'],'','','1');?>
                                </div>
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานภาพการสมรส : </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelectNoConv('PER_STATUS_MARRY','PER_STATUS_MARRY',$arr_smarry_type_status,'สถานภาพการสมรส',$data['PER_STATUS_MARRY'],'','','1');?></div>
                            </div> 
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานะรับราชการทหาร : </div>
                                <div class="col-xs-12 col-sm-2">
								<?php  echo GetHtmlSelectNoConv('PER_STATUS_MILITARY','PER_STATUS_MILITARY',$arr_per_status_military,'สถานะรับราชการทหาร',$data['PER_STATUS_MILITARY'],'','','1');?>
                                </div>
                            </div>
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานะของการเลื่อนระดับ : </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelectNoConv('PER_STATUS_MOVEUP','PER_STATUS_MOVEUP',$arr_status_moveup,'สถานะของการเลื่อนระดับ',$data['PER_STATUS_MOVEUP'],'','','1');?></div>
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานะของการทดลองปฏิบัติราชการ : </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelectNoConv('PER_STATUS_PROBATION','PER_STATUS_PROBATION',$arr_status_probation,'สถานะของการทดลองปฏิบัติราชการ',$data['PER_STATUS_PROBATION'],'','','1');?></div>
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานะของการสอบสวนทางวินัย : </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelectNoConv('PER_STATUS_PENALTY','PER_STATUS_PENALTY',$arr_status_penalty,'สถานะของการสอบสวนทางวินัย',$data['PER_STATUS_PENALTY'],'','','1');?></div>
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานะของการขอบำเหน็จบำนาญ : </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelectNoConv('PENSION_STATUS','PENSION_STATUS',$arr_status_pension,'สถานะของการขอบำเหน็จบำนาญ',$data['PENSION_STATUS'],'','','1');?></div>
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สาเหตุการออกจากราชการ : </div>
                                <div class="col-xs-12 col-sm-2">
									<?php  echo GetHtmlSelect('RETYPE_ID','PER_STATUS_RETYPE_IDCIVIL',$arr_retype2,'สาเหตุการออกจากราชการ',$data['RETYPE_ID'],'','','1');?>
                                </div>
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['active'];?> :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                                <div class="col-xs-6 col-md-1">
                                <label ><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($data['ACTIVE_STATUS']=='1'||$data['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>
                                </div>
                                <div class="col-xs-6 col-md-1">
                                <label ><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($data['ACTIVE_STATUS']=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?></label>
                                </div>
                           </div>		
                        </div>     
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse7" onClick="$('.switchPic7').toggle();">
                                    <img class="switchPic7" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic7" src="<?php echo $path;?>images/clse.gif" >
                                    ข้อมูลไฟล์แนบ
                                </a>
                            </div>
                        </div>
                        <div id="collapse7" class="collapse in">
                        	<div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">นำเข้าไฟล์รูปภาพ :&nbsp;</div>
                                <div class="col-xs-12 col-sm-3">
                                     <div class="input-group">
                                        <input type="file" id="PER_FILE_PIC" name="PER_FILE_PIC" class="form-control"  value="<?php echo text($data["PER_FILE_PIC"]);?>" onChange="checkfile(this);" >
                                        <?php echo displayDownloadFileAttach($path_img,$data['PER_FILE_PIC'],$arr_txt['download']);?>
                                    </div>		
                                    <input type="hidden" id="OLD_FILE_PIC" name="OLD_FILE_PIC"   value="<?php echo !empty($data["PER_FILE_PIC"])?text($data["PER_FILE_PIC"]):""; ?>">
                                </div>
                                <div class="col-xs-12 col-sm-1"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ไฟล์แบบฟอร์มสมาชิก กบข :&nbsp;</div>
                                <div class="col-xs-12 col-sm-3">
                                     <div class="input-group"  >
                                        <input type="file" id="PER_FILE_GPF" name="PER_FILE_GPF" class="form-control"  value="<?php echo text($data["PER_FILE_GPF"]);?>" >
                                        <?php echo displayDownloadFileAttach($path_img,$data['PER_FILE_GPF'],$arr_txt['download']);?>
                                    </div>	
                                    <input type="hidden" id="OLD_FILE_GPF" name="OLD_FILE_GPF"   value="<?php echo !empty($data["PER_FILE_GPF"])?text($data["PER_FILE_GPF"]):""; ?>"> 
                                </div>
                            </div>	
                                
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ไฟล์แบบฟอร์มชั้นความลับ รปภ 1:&nbsp;</div>
                                <div class="col-xs-12 col-sm-3">
                                     <div class="input-group"  >
                                        <input type="file" id="PER_FILE_SECRET" name="PER_FILE_SECRET" class="form-control"  value="<?php echo text($data["PER_FILE_SECRET"]);?>" >
                                        <?php echo displayDownloadFileAttach($path_img,$data['PER_FILE_SECRET'],$arr_txt['download']);?>
                                    </div>
                                    <input type="hidden" id="OLD_FILE_SECRET" name="OLD_FILE_SECRET"   value="<?php echo !empty($data["PER_FILE_SECRET"])?text($data["PER_FILE_SECRET"]):""; ?>">
                                </div>
                                <div class="col-xs-12 col-sm-1"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ไฟล์ ก.พ. 7:&nbsp;</div>
                                <div class="col-xs-12 col-sm-3">
                                     <div class="input-group"  >
                                        <input type="file" id="PER_FILE_MAIN" name="PER_FILE_MAIN" class="form-control"  value="<?php echo text($data["PER_FILE_MAIN"]);?>" >
                                        <?php echo displayDownloadFileAttach($path_img,$data['PER_FILE_MAIN'],$arr_txt['download']);?>
                                    </div>
                                    <input type="hidden" id="OLD_FILE_MAIN" name="OLD_FILE_MAIN"   value="<?php echo !empty($data["PER_FILE_MAIN"])?text($data["PER_FILE_MAIN"]):""; ?>">
                                </div>
                            </div>
                    </div>
                    
                  <div class="row" style="margin-top:10px;">
					<div class="col-xs-12 col-sm-12" align="center">
						<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
						<button type="button" class="btn btn-default" onClick="self.location.href='<?php echo $page_back."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID);?>';">ยกเลิก</button>
					</div>
				</div> 
                    
                </div>
                    
                
			</form>
		</div> 
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</div>
</body>
</html>
<!-- Modal -->
<?php echo form_model('myModal','เลือก'.$arr_txt['pos_no'],'show_display2');?>
<!-- /.modal -->
 
 
 

