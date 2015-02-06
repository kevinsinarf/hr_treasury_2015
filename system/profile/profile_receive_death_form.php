<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;

//POST
$FAMILY_ID = $_POST['FAMILY_ID'];
$proc = empty($proc)?'edit':$proc;
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 
$path_a = '../fileupload/profile_his/';

//tab active
$ACT = 2;
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
if($proc=="edit"){
	$table="PER_FAMILY A LEFT JOIN SETUP_COUNTRY B ON  A.ADDRESS_COUNTRY_ID = B.COUNTRY_ID 
			LEFT JOIN SETUP_PROV C ON C.PROV_ID = A.ADDRESS_PROV_ID
			LEFT JOIN SETUP_AMPR D ON D.AMPR_ID =A.ADDRESS_AMPR_ID
			LEFT JOIN SETUP_TAMB E ON E.TAMB_ID = A.ADDRESS_TAMB_ID";
	$sql = "select A.ACTIVE_STATUS AS F_ACTIVE_STATUS, * from ".$table." where A.FAMILY_ID = '".$FAMILY_ID."'";
	$query = $db->query($sql);
	$data = $db->db_fetch_array($query);
}
$arr_prefix=GetSqlSelectArray("PREFIX_ID", "PREFIX_NAME_TH", "V_PREFIX", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PREFIX_SEQ,PREFIX_NAME_TH"); //คำนำหน้าชื่อ th
$arr_snation=GetSqlSelectArray("NATION_ID", "NATION_NAME_TH", "SETUP_NATION", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "NATION_NAME_TH");//สัญชาติ
$arr_sreligion=GetSqlSelectArray("RELIGION_ID", "RELIGION_NAME_TH", "SETUP_RELIGION", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "RELIGION_CODE");//ศาสนา
$arr_sjob=GetSqlSelectArray("JOB_ID", "JOB_NAME_TH", "V_SETUP_JOB", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "JOB_NAME_TH");//อาชีพ
$arr_country=GetSqlSelectArray("COUNTRY_ID", "COUNTRY_NAME_TH", "SETUP_COUNTRY", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "COUNTRY_NAME_TH");//ประเทศ
$arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME"); //จังหวัด
$arr_ampr = GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "ACTIVE_STATUS='1' and DELETE_FLAG='0' and PROV_ID = '".$data['ADDRESS_PROV_ID']."' ", "AMPR_NAME_TH"); 
$arr_tamb = GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "ACTIVE_STATUS='1' and DELETE_FLAG='0' and AMPR_ID = '".$data['ADDRESS_AMPR_ID']."'", "TAMB_NAME_TH"); 
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
<script src="js/profile_receive_death_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
         <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
           <li><a href="profile_receive_death_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id)."&PER_ID=".$PER_ID;?>">ประวัติของผู้ถูกแสดงเจตนารับเงินช่วยเหลือพิเศษกรณีถึงแก่ความตาย</a></li>
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
        <form id="frm-input" method="post" action="process/profile_receive_death_proc.php" enctype="multipart/form-data" >
            <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
            <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
            <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
            <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
            <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
            <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID; ?>">
            <input type="hidden" id="FAMILY_ID" name="FAMILY_ID" value="<?php echo $FAMILY_ID; ?>">
            <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
            <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
            <?php include("tab_info.php");?>
            <div class="panel-group" id="accordion">
                <div class="row head-form">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();">
                            <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                            <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >ข้อมูลส่วนตัวของผู้ถูกแสดงเจตนารับเงินช่วยเหลือพิเศษกรณีถึงแก่ความตาย
                        </a>
                    </div>
                </div>
                
                <div id="collapse1" class="collapse in">
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่แจ้ง : <span style="color:red;">*</span>&nbsp;</div>
                        <div class="col-xs-12 col-sm-2">
                            <div class="input-group">
                                <input type="text" id="FAMILY_DATE" name="FAMILY_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["FAMILY_DATE"]);?>">
                                <span class="input-group-addon datepicker" for="FAMILY_DATE" >&nbsp;
                                <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                </span>
                            </div>
                    	</div> 
                        <div class="col-xs-12 col-md-2" ></div>
                        <div class="col-xs-12 col-md-2" align="left"><label><input type="checkbox" name="ACTIVE_STATUS" id="ACTIVE_STATUS" value="1" <?php echo ($data['F_ACTIVE_STATUS']=='1'?"checked":"")?> />&nbsp;&nbsp;&nbsp;</label> เป็นผู้ถูกระบุปัจจุบัน &nbsp;</div>
                	</div>
                
                    <div class="row formSep">
                        <div class="col-md-2 col-sm-2 " style="white-space:nowrap">ประเภทบัตร :&nbsp;</div>
                        <div class="col-md-2 col-sm-2">
                            <input type="radio" name="FAMILY_IDTYPE" id="FAMILY_IDTYPE" value="1" <?php if($data['FAMILY_IDTYPE'] == '' || $data['FAMILY_IDTYPE'] == 1){ echo "checked";} ?> onChange="getType('1');"> <?php echo $arr_txt['idcard']; ?><br>
                            <input type="radio" name="FAMILY_IDTYPE" id="FAMILY_IDTYPE" value="2" onChange="getType('2');" <?php if($data['FAMILY_IDTYPE'] == 2){ echo "checked";} ?>> เลขที่หนังสือเดินทาง
                        </div>  
                        <div class="col-md-2 col-sm-2"></div> 
                        <div class="col-md-2 col-sm-2" style="white-space:nowrap"><span id="shw_txt_type"><?php if($data['FAMILY_IDTYPE'] == '' || $data['FAMILY_IDTYPE'] == 1){ echo $arr_txt['idcard'];}else{ echo "เลขที่หนังสือเดินทาง";}?></span> : &nbsp;</div>
                        <div class="col-md-2 col-sm-2">
                        <input type="text" id="FAMILY_IDCARD1" class="form-control idcard" name="FAMILY_IDCARD1" maxlength="13" value="<?php echo text($data['FAMILY_IDCARD']); ?>" placeholder="<?php echo $arr_txt['idcard']; ?>">
                        <input type="text" id="FAMILY_IDCARD2" class="form-control" name="FAMILY_IDCARD2" maxlength="30" value="<?php echo text($data['FAMILY_IDCARD']); ?>" placeholder="เลขที่หนังสือเดินทาง">
                        </div> 
                    </div>
                                
                    <div class="row"></div>
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันเดือนปีเกิด : </div>
                        <div class="col-xs-12 col-sm-2">
                        <div class="input-group">
                            <input type="text" id="FAMILY_BIRTHDATE" name="FAMILY_BIRTHDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["FAMILY_DATE"]);?>">
                            <span class="input-group-addon datepicker" for="FAMILY_BIRTHDATE" >&nbsp;
                            <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                            </span>
                              
                        </div> 
                        </div>			
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['title'];?> : <span style="color:red;">*</span>&nbsp;</div>
                        <div class="col-xs-12 col-sm-2"><?php echo GetHtmlSelect('FAMILY_PREFIX_ID','FAMILY_PREFIX_ID',$arr_prefix,$arr_txt['title']." (".$arr_txt['th'].")",$data['FAMILY_PREFIX_ID'],'','','1') ; ?> </div>
                    </div> 
                  
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['fname'].$arr_txt['th']; ?> : <span style="color:red;">*</span> </div>
                        <div class="col-xs-12 col-sm-2"><input type="text" id="FAMILY_FIRSTNAME_TH" name="FAMILY_FIRSTNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['fname'].$arr_txt['th']; ?>" value="<?php echo text($data['FAMILY_FIRSTNAME_TH']) ;?>" maxlength="100"></div> <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['fname'].$arr_txt['en']; ?> : </div>
                        <div class="col-xs-12 col-sm-2"><input type="text" id="FAMILY_FIRSTNAME_EN" name="FAMILY_FIRSTNAME_EN" class="form-control" placeholder="<?php echo $arr_txt['fname'].$arr_txt['en']; ?>" value="<?php echo text($data['FAMILY_FIRSTNAME_EN']) ;?>" maxlength="100"></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['mname'].$arr_txt['th']; ?>  :</div>
                        <div class="col-xs-12 col-sm-2"><input type="text" id="FAMILY_MIDNAME_TH" name="FAMILY_MIDNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['fname'].$arr_txt['th']; ?>" value="<?php echo text($data['FAMILY_MIDNAME_TH']) ;?>" maxlength="100"></div> <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['mname'].$arr_txt['en']; ?> :</div>
                        <div class="col-xs-12 col-sm-2"><input type="text" id="FAMILY_MIDNAME_EN" name="FAMILY_MIDNAME_EN" class="form-control" placeholder="<?php echo $arr_txt['mname'].$arr_txt['en']; ?>" value="<?php echo text($data['FAMILY_MIDNAME_EN']) ;?>" maxlength="100"></div>				
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['lname'].$arr_txt['th']; ?> : <span style="color:red;">*</span></div>
                        <div class="col-xs-12 col-sm-2"><input type="text" id="FAMILY_LASTNAME_TH" name="FAMILY_LASTNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['lname'].$arr_txt['th']; ?>" value="<?php echo text($data['FAMILY_LASTNAME_TH']) ;?>" maxlength="100"></div> <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['lname'].$arr_txt['en']; ?> : </div>
                        <div class="col-xs-12 col-sm-2"><input type="text" id="FAMILY_LASTNAME_EN" name="FAMILY_LASTNAME_EN" class="form-control" placeholder="<?php echo $arr_txt['lname'].$arr_txt['en']; ?>" value="<?php echo text($data['FAMILY_LASTNAME_EN']) ;?>" maxlength="100"></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap">เพศ :&nbsp;</div>
                        <div class="col-xs-12 col-md-1"><label ><input type="radio" id="FAMILY_GENDER" name="FAMILY_GENDER"  value="1" <?php echo ($data['FAMILY_GENDER']=='1'||$rec['FAMILY_GENDER']=='' ?"checked":"")?>> ชาย</label></div>
                        <div class="col-xs-12 col-md-1"><label ><input type="radio" id="FAMILY_GENDER" name="FAMILY_GENDER" value="2" <?php echo ($data['FAMILY_GENDER']=='2'?"checked":"")?> > หญิง</label></div> <div class="col-xs-12 col-md-2"></div>
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สัญชาติ :&nbsp;</div>
                        <div class="col-xs-12 col-sm-2"><?php echo GetHtmlSelect('FAMILY_NATION_ID','FAMILY_NATION_ID',$arr_snation, "สัญชาติ", empty($data['FAMILY_NATION_ID'])?$default_nation_id:$data['FAMILY_NATION_ID'],'','','1'); ?></div> 
                    </div>
                    
                    <div class="row formSep">
                       	<div class="col-xs-12 col-sm-2" style="white-space:nowrap">เชื้อชาติ :&nbsp;&nbsp;</div>
                       	<div class="col-xs-12 col-sm-2"><?php echo GetHtmlSelect('FAMILY_RACE_NATION_ID','FAMILY_RACE_NATION_ID',$arr_snation, "เชื้อชาติ", empty($data['FAMILY_RACE_NATION_ID'])?$default_nation_id:$data['FAMILY_RACE_NATION_ID'],'','','1'); ?></div> 
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ศาสนา : </div>
                        <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelect('FAMILY_RELIGION_ID','FAMILY_RELIGION_ID',$arr_sreligion,"ศาสนา",empty($data['FAMILY_RELIGION_ID'])?$default_religion_id:$data['FAMILY_RELIGION_ID'],'','','1');?></div>							
                    </div>
                                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">อาชีพ :&nbsp;</div>
                        <div class="col-xs-12 col-sm-2">
                        <select id="FAMILY_JOB_ID" name="FAMILY_JOB_ID" class="selectbox form-control" placeholder="อาชีพ" onChange="chkwork(this.value);">
                            <option value="" ></option>
                            <?php 
                            foreach ($arr_sjob as $key => $value){  ?>
                            <option value="<?php echo $key ; ?>" <?php echo ($data['FAMILY_JOB_ID'] == $key?"selected":"");?>><?php echo text($value);?></option>
                            <?php }?>
                        </select>						
                        </div> 
                        
                        <div class="col-xs-12 col-sm-2"></div>
                        <div id="work">
                            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">โปรดระบุ :
                            <span style="color:red;"></span></div>   
                            <div class="col-xs-12 col-sm-2"><input type="text" id="FAMILY_JOB_OTHER" name="FAMILY_JOB_OTHER" class="form-control" placeholder="โปรดระบุ" value="<?php echo text($data['FAMILY_JOB_OTHER']);?>" maxlength="100"></div>
                        </div>
                    </div>
                        
                    <div class="row formSep">
                        <!--<div class="col-xs-12 col-sm-2" style="white-space:nowrap">สถานะการมีชีวิต : <span style="color:red;">*</span></div>
                        <div class="col-xs-12 col-sm-2">
                            <select id="FAMILY_STATUS" name="FAMILY_STATUS" class="selectbox form-control" placeholder="สถานะการมีชีวิต">
                                <option value="" ></option>
                                <?php foreach ($arr_family_status as $key => $value){  ?>
                                <option value="<?php echo $key ; ?>" <?php echo ($data['FAMILY_STATUS'] == $key?"selected":"");?>><?php echo $value;?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-2"></div>-->
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ไฟล์แนบ : </div>
                        <div class="col-xs-12 col-sm-3">
                            <div class="input-group"  >
                                <input type="file" id="FAMILY_FILE" name="FAMILY_FILE"  class="form-control" placeholder="ไฟล์แนบ" value="<?php echo text($data['FAMILY_FILE']); ?>">
                                <?php echo displayDownloadFileAttach($path_a,$data['FAMILY_FILE'],$arr_txt['download']);?>
                            </div>
                            <input type="hidden" id="OLD_FAMILY_FILE" name="OLD_FAMILY_FILE" value="<?php echo !empty($data["FAMILY_FILE"])?text($data["FAMILY_FILE"]):""; ?>">
                        </div>
                    </div>
                </div>
     		</div>
            
            <div class="panel-group" id="accordion">            
                <div class="row head-form">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onClick="$('.switchPic2').toggle();">
                            <img class="switchPic2" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                            <img class="switchPic2" src="<?php echo $path;?>images/clse.gif" >
                           ข้อมูลที่ติดต่อของผู้ถูกแสดงเจตนารับเงินช่วยเหลือพิเศษกรณีถึงแก่ความตาย
                        </a>
                    </div>
                </div>
                
                <div id="collapse2" class="collapse in">
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเทศ : </div>
                        <div class="col-xs-12 col-sm-2"><?php echo GetHtmlSelect('ADDRESS_COUNTRY_ID','ADDRESS_COUNTRY_ID',$arr_country,'',empty($data['ADDRESS_COUNTRY_ID'])?$default_country_id:$data['ADDRESS_COUNTRY_ID'],'onchange="GetCity(this.value)"','','1');?></div> 
                        <div class="col-xs-12 col-sm-2"></div>
                        <div id="city1">
                            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">เมือง :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                            <div class="col-xs-6 col-md-2"><input type="text" id="ADDRESS_CITY" name="ADDRESS_CITY" class="form-control" placeholder="เมือง" value="<?php echo text($data['ADDRESS_CITY']) ;?>" ></div>
                        </div>	
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">เลขที่ห้อง :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                        <div class="col-xs-6 col-md-2"><input type="text" id="ADDRESS_ROOM_NO" name="ADDRESS_ROOM_NO" class="form-control" placeholder="เลขที่ห้อง" value="<?php echo text($data['ADDRESS_ROOM_NO']) ;?>" ></div> <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ชั้น :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                        <div class="col-xs-6 col-md-2"><input type="text" id="ADDRESS_FLOOR" name="ADDRESS_FLOOR" class="form-control" placeholder="ชั้น" value="<?php echo text($data['ADDRESS_FLOOR']) ;?>" ></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">อาคาร :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                        <div class="col-xs-6 col-md-2"><input type="text" id="ADDRESS_BUILDING" name="ADDRESS_BUILDING" class="form-control" placeholder="อาคาร" value="<?php echo text($data['ADDRESS_BUILDING']) ;?>" ></div> <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">บ้านเลขที่ :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                        <div class="col-xs-6 col-md-2"><input type="text" id="ADDRESS_HOME_NO" name="ADDRESS_HOME_NO" class="form-control" placeholder="ชั้น" value="<?php echo text($data['ADDRESS_HOME_NO']) ;?>" ></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">หมู่ที่ :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                        <div class="col-xs-6 col-md-2"><input type="text" id="ADDRESS_MOO" name="ADDRESS_MOO" class="form-control" placeholder="หมู่ที่" value="<?php echo text($data['ADDRESS_MOO']) ;?>" ></div><div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">หมู่บ้าน:&nbsp;<span style="color:red;"></span>&nbsp;</div>
                        <div class="col-xs-6 col-md-2"><input type="text" id="ADDRESS_VILLAGE" name="ADDRESS_VILLAGE" class="form-control" placeholder="ชั้น" value="<?php echo text($data['ADDRESS_VILLAGE']) ;?>" ></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ซอย :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                        <div class="col-xs-6 col-md-2"><input type="text" id="ADDRESS_SOI" name="ADDRESS_SOI" class="form-control" placeholder="ซอย" value="<?php echo text($data['ADDRESS_SOI']) ;?>" ></div> <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ถนน :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                        <div class="col-xs-6 col-md-2"><input type="text" id="ADDRESS_ROAD" name="ADDRESS_ROAD" class="form-control" placeholder="ถนน" value="<?php echo text($data['ADDRESS_ROAD']) ;?>" ></div>
                    </div>
                    
                    <div id="prov1">
                        <div class="row formSep">
                            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">จังหวัด : <span style="color:red;"></span></div>
                            <div class="col-xs-12 col-sm-2">
                            <select id="ADDRESS_PROV_ID" name="ADDRESS_PROV_ID" class="selectbox form-control" placeholder="จังหวัด" onChange="getRampr(this.value);" >
                                <option value="" ></option>
                                <?php foreach ($arr_prov as $key => $value){  ?>
                                <option value="<?php echo $key ; ?>" <?php echo ($data['ADDRESS_PROV_ID'] == $key?"selected":"");?>><?php echo text($value);?></option>
                                <?php }?>
                            </select>
                            </div>	
                         
                            <div class="col-xs-12 col-sm-2"></div>	
                            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">อำเภอ/เขต :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                            <div class="col-xs-12 col-sm-2">
                                 <span  id="SS_ADDRESS_AMPR_ID">
                                 <select id="ADDRESS_AMPR_ID" name="ADDRESS_AMPR_ID" class="selectbox form-control" placeholder="อำเภอ/เขต" onChange="getStamb(this.value);" >
                                    <option value="" ></option>
                                    <?php foreach ($arr_ampr as $key => $value){  ?>
                                    <option value="<?php echo $key ; ?>" <?php echo ($data['ADDRESS_AMPR_ID'] == $key?"selected":"");?>><?php echo text($value);?></option>
                                    <?php }?>
                                </select>
                                </span>
                            </div> 
                        </div>
                    
                        <div class="row formSep">
                            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำบล/แขวง : <span style="color:red;"></span></div>
                            <div class="col-xs-12 col-sm-2">
                                <span  id="SS_ADDRESS_TAMB_ID">
                                    <select id="ADDRESS_TAMB_ID" name="ADDRESS_TAMB_ID" class="selectbox form-control" placeholder="ตำบล/แขวง"  onChange="getZipcode(this.value);">
                                        <option value="" ></option>
                                        <?php foreach ($arr_tamb as $key => $value){  ?>
                                        <option value="<?php echo $key ; ?>" <?php echo ($data['ADDRESS_TAMB_ID'] == $key?"selected":"");?>><?php echo text($value);?></option>
                                        <?php }?>
                                    </select>
                                </span>
                            </div>	  
                            <div class="col-xs-12 col-sm-2"></div>	
                            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">รหัสไปรษณีย์ :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                            <div class="col-xs-12 col-sm-2">
                                <span  id="SS_ADDRESS_POSTCODE">
                                <input type="text" id="ADDRESS_POSTCODE" name="ADDRESS_POSTCODE" class="form-control number" placeholder="รหัสไปรษณีย์" maxlength="5" value="<?php echo text($data['ADDRESS_POSTCODE']); ?>">		
                                </span>				
                            </div> 
                        </div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์ :</div>
                        <div class="col-xs-12 col-md-2"><input type="text" id="ADDRESS_TEL" name="ADDRESS_TEL" class="form-control telbkk" placeholder="โทรศัพท์" maxlength="20" value="<?php echo text($data['ADDRESS_TEL']); ?>"></div>
                        <div class="col-xs-12 col-sm-2">
                            <div class="input-group">
                                <span class="input-group-addon">ต่อ</span>
                                <input type="text" id="ADDRESS_TEL_EXT" name="ADDRESS_TEL_EXT" maxlength="4" class="form-control" placeholder="ต่อ" style="width:100px;" value="<?php echo text($data['ADDRESS_TEL_EXT']); ?>">
                            </div>	
                        </div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรสาร :</div>
                        <div class="col-xs-12 col-md-2"><input type="text" id="ADDRESS_FAX" name="ADDRESS_FAX" class="form-control telbkk" placeholder="โทรสาร" maxlength="20" value="<?php echo text($data['ADDRESS_FAX']); ?>"></div>
                        <div class="col-xs-12 col-sm-2">
                            <div class="input-group">
                                <span class="input-group-addon">ต่อ</span>
                                <input type="text" id="ADDRESS_FAX_EXT" name="ADDRESS_FAX_EXT" maxlength="4" class="form-control" placeholder="ต่อ"  style="width:100px;" value="<?php echo text($data['ADDRESS_FAX_EXT']); ?>">
                            </div>
                        </div>  
                    </div> 
                         
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์เคลื่อนที่ :</div>
                        <div class="col-xs-12 col-md-2"><input type="text" id="ADDRESS_MOBILE" name="ADDRESS_MOBILE"  class="form-control mobile" placeholder="โทรศัพท์เคลื่อนที่" maxlength="20" value="<?php echo $data['ADDRESS_MOBILE']; ?>"></div>
                        <div class="col-xs-12 col-md-2"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อีเมล์:</div>
                        <div class="col-xs-12 col-md-2"><input type="text" id="ADDRESS_EMAIL" name="ADDRESS_EMAIL" class="form-control" placeholder="อีเมล์"  value="<?php echo($data['ADDRESS_EMAIL']); ?>"></div>
                    </div> 
                </div>
        	</div>	
  
            <div class="col-xs-12 col-sm-12" align="center">
                <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                <button type="button" class="btn btn-default" onClick="self.location.href='<?php echo "profile_receive_death_disp.php?".url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID)."&PER_ID=".$PER_ID;?>';">ยกเลิก</button>
            </div>
        </form>
		</div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</div>
</body>
</html>