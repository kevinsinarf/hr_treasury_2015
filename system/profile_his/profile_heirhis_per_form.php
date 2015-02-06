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
$HEIR_ID=$_POST['HEIR_ID'];
$PER_ID = $_POST['PER_ID'];
$HEIRDESC_ID = $_POST['HEIRDESC_ID'];

$txt = (($proc == "edit_per") ? "แก้ไขข้อมูล":"เพิ่มข้อมูล"); 

$sql = "SELECT  *
FROM PER_HEIRHIS  where DELETE_FLAG = '0' AND HEIR_ID = '".$HEIR_ID."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

$HEIR_TYPE_FORM = $rec['HEIR_TYPE_FORM'];
if($HEIR_TYPE_FORM == 2){
	$txt_type_heir = "แบบที่ 2";
}else{
	$txt_type_heir = "แบบที่ 1";
}

if($proc == 'edit_per'){
	$query_per = $db->query("SELECT * FROM PER_HEIRHIS_DESC WHERE HEIRDESC_ID = '".$HEIRDESC_ID."' ");
	$rec_per = $db->db_fetch_array($query_per);
}

$arr_snation=GetSqlSelectArray("NATION_ID", "NATION_NAME_TH", "SETUP_NATION", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "NATION_NAME_TH");//สัญชาติ
$arr_sreligion=GetSqlSelectArray("RELIGION_ID", "RELIGION_NAME_TH", "SETUP_RELIGION", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "RELIGION_CODE");//ศาสนา					
$arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME"); //จังหวัด
//อำเภอ/เขต
$arr_ampr=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$rec_per['ADDRESS_PROV_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
//ตำบล/แขวง
$arr_tamb = GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='".$rec_per['ADDRESS_AMPR_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");
$arr_type_salary = array(1 => 'เงินเดือน', 2 => 'เงินบำนาญรวมกับ ช.ค.บ.', 3 => 'เบี้ยหวัดรวมกับ ช.ค.บ.');
$arr_prefix=GetSqlSelectArray("PREFIX_ID", "PREFIX_NAME_TH", "V_PREFIX", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PREFIX_SEQ,PREFIX_NAME_TH"); //คำนำหน้าชื่อ th
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
<script src="js/profile_heirhis_per_form.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div>
    <?php include($path."include/header.php");?>
  </div>
  <div>
    <?php include($path."include/menu.php");?>
  </div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
      
	  <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
      <li><a href="profile_heirhis_disp.php?<?php echo url2code($link2); ?>">ประวัติของผู้ถูกแสดงเจตนาให้รับบำเหน็จตกทอด</a></li>
	   <li class="active" ><a href="#" onClick="$('#frm-input').attr('action','profile_heirhis_form.php').submit();" >ข้อมูลหนังสือแสดงเจตนาระบุตัวผู้รับบำเหน็จตกทอด</a></li>
       <li class="active"><?php echo $txt; ?>ผู้ถูกแสดงเจตนารับบำเน็จตกทอด</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" >
    <br>
	<?php include ("tab_info.php"); ?>
	
      <form id="frm-input" method="post" action="process/profile_heirhis_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        <input type="hidden" id="HEIR_TYPE_FORM" name="HEIR_TYPE_FORM" value="<?php echo $HEIR_TYPE_FORM; ?>">
        <input type="hidden" id="HEIR_ID" name="HEIR_ID"  value="<?php echo $HEIR_ID; ?>">
        <input type="hidden" id="HEIRDESC_ID" name="HEIRDESC_ID"  value="<?php echo $HEIRDESC_ID; ?>">
       
        
        <div class="row head-form">ข้อมูลหนังสือแสดงเจตนาระบุตัวผู้รับบำเหน็จตกทอด</div>
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">เขียนที่ : </div>
            <div class="col-xs-12 col-sm-7">
            	<?php echo text($rec['HEIR_WRITE']); ?>
            </div> 
        </div>	
         <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">เมื่อวันที่ : </div>
            <div class="col-xs-12 col-sm-2">
                    <?php echo conv_date($rec["HEIR_SDATE"],'short');?>
            </div>
            <div class="col-xs-12 col-sm-2"></div>
           <div class="col-xs-12 col-sm-2">ประเภทหนังสือแสดงเจตนา : </div>
           <div class="col-xs-12 col-sm-2"><?php echo $txt_type_heir; ?></div>  
        </div>	
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทรายได้ : </div>
            <div class="col-xs-12 col-sm-2">
            	<?php  echo $arr_type_salary[$rec['HEIR_TYPE_SALARY']];?>
            </div>
            <div class="col-xs-12 col-sm-2"></div>
           <div class="col-xs-12 col-sm-2">เดือนละ : </div>
           <div class="col-xs-12 col-sm-2">
           	<?php echo number_format($rec['HEIR_SALARY'],2); ?>
           </div>  
        </div>
         <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">รวม (คน) : </div>
            <div class="col-xs-12 col-sm-2">
            	<?php echo $rec['HEIR_TOTAL']; ?>
            </div>
            <?php if($HEIR_TYPE_FORM == 2){ ?>
            <div class="col-xs-12 col-sm-2"></div>
           <div class="col-xs-12 col-sm-2">แทนหนังสือแสดงเจตนาลงวันที่ : </div>
           <div class="col-xs-12 col-sm-2">
           		<?php echo conv_date($rec['HEIR_SDATE_REPLACE'],'short');	?>
           </div>
           <?php } ?>
        </div>						
        <div class="row head-form">ข้อมูลส่วนบุคคลของผู้รับบำเหน็จตกทอด</div>
         <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทบัตร : </div>
            <div class="col-xs-12 col-sm-2">
            	 <input  name="HEIRDESC_IDTYPE" type="radio" value="1" onChange="getType('1')" <?php echo ($rec_per['HEIRDESC_IDTYPE'] == 1 or $rec_per['HEIRDESC_IDTYPE'] == '' )?'checked':''; ?>  > ประจำตัวประชาชน<br>
                 <input name="HEIRDESC_IDTYPE" type="radio" value="2" onChange="getType('2')"  <?php echo ($rec_per['HEIRDESC_IDTYPE'] == 2)?'checked':''; ?> > หนังสือเดินทาง
            </div>
           <div class="col-xs-12 col-sm-2"></div>
           <div class="col-xs-12 col-sm-2"><span id="shw_txt_type" ></span> : </div>
           <div class="col-xs-12 col-sm-2">
		   		<input type="text" id="HEIRDESC_IDCARD1" class="form-control idcard" name="HEIRDESC_IDCARD1" maxlength="13" value="<?php echo text($rec_per['HEIRDESC_IDCARD']); ?>">
                <input type="text" id="HEIRDESC_IDCARD2" class="form-control" name="HEIRDESC_IDCARD2" maxlength="30" value="<?php echo text($rec_per['HEIRDESC_IDCARD']); ?>">
           </div>  
        </div>		
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">คำนำหน้าชื่อ : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-2">
            	 <?php echo GetHtmlSelect('PREFIX_ID',"PREFIX_ID",$arr_prefix,'คำนำหน้าชื่อ',$rec_per['PREFIX_ID'],'','chosen','1',''); ?>
            </div>
            <div class="col-xs-12 col-sm-2"></div>
           <div class="col-xs-12 col-sm-2">วันเดือนปีเกิด : </div>
           <div class="col-xs-12 col-sm-2">
		   		<div class="input-group">
                  <input type="text" id="HEIRDESC_BIRTHDATE" name="HEIRDESC_BIRTHDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo conv_date($rec_per["HEIRDESC_BIRTHDATE"]);?>">
                  <span class="input-group-addon datepicker" for="HEIRDESC_BIRTHDATE" >&nbsp;
                  <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                  </span>
              </div>  
           </div>  
        </div>	
       <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ชื่อตัว (ภาษาไทย) : <span style="color:red;">*</span></div>
        <div class="col-xs-12 col-sm-2">
             <input type="text" id="HEIRDESC_FIRSTNAME_TH" name="HEIRDESC_FIRSTNAME_TH" class="form-control" placeholder="ชื่อตัว (ภาษาไทย)" value="<?php echo text($rec_per['HEIRDESC_FIRSTNAME_TH']); ?>" >
        </div>
        <div class="col-xs-12 col-sm-2"></div>
       <div class="col-xs-12 col-sm-2">ชื่อตัว (ภาษาอังกฤษ) : </div>
       <div class="col-xs-12 col-sm-2">
            <input type="text" id="HEIRDESC_FIRSTNAME_EN" name="HEIRDESC_FIRSTNAME_EN" class="form-control" placeholder="ชื่อตัว (ภาษาอังกฤษ)" value="<?php echo text($rec_per['HEIRDESC_FIRSTNAME_EN']); ?>" >
       </div>  
    </div>	
    <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ชื่อรอง (ภาษาไทย) : </div>
        <div class="col-xs-12 col-sm-2">
             <input type="text" id="HEIRDESC_MIDNAME_TH" name="HEIRDESC_MIDNAME_TH" class="form-control" placeholder="ชื่อรอง (ภาษาไทย)" value="<?php echo text($rec_per['HEIRDESC_MIDNAME_TH']); ?>" >
        </div>
        <div class="col-xs-12 col-sm-2"></div>
       <div class="col-xs-12 col-sm-2">ชื่อรอง (ภาษาอังกฤษ) : </div>
       <div class="col-xs-12 col-sm-2">
            <input type="text" id="HEIRDESC_MIDNAME_EN" name="HEIRDESC_MIDNAME_EN" class="form-control" placeholder="ชื่อรอง (ภาษาอังกฤษ)" value="<?php echo text($rec_per['HEIRDESC_MIDNAME_EN']); ?>" >
       </div>  
    </div>	
    <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ชื่อสกุล (ภาษาไทย) : <span style="color:red;">*</span></div>
        <div class="col-xs-12 col-sm-2">
             <input type="text" id="HEIRDESC_LASTNAME_TH" name="HEIRDESC_LASTNAME_TH" class="form-control" placeholder="ชื่อสกุล (ภาษาไทย)" value="<?php echo text($rec_per['HEIRDESC_LASTNAME_TH']); ?>" >
        </div>
        <div class="col-xs-12 col-sm-2"></div>
       <div class="col-xs-12 col-sm-2">ชื่อสกุล (ภาษาอังกฤษ) : </div>
       <div class="col-xs-12 col-sm-2">
            <input type="text" id="HEIRDESC_LASTNAME_EN" name="HEIRDESC_LASTNAME_EN" class="form-control" placeholder="ชื่อสกุล (ภาษาอังกฤษ)" value="<?php echo text($rec_per['HEIRDESC_LASTNAME_EN']); ?>" >
       </div>  
    </div>	
    <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">เพศ : <span style="color:red;">*</span></div>
        <div class="col-xs-12 col-sm-2">
             <input name="HEIRDESC_GENDER"  type="radio"  value="1" <?php echo ($rec_per['HEIRDESC_GENDER'] == 1 or $rec_per['HEIRDESC_GENDER'] == '')?'checked':''; ?> >&nbsp;ชาย &nbsp;&nbsp;
             <input name="HEIRDESC_GENDER" type="radio" value="2" <?php echo ($rec_per['HEIRDESC_GENDER'] == 2 )?'checked':''; ?>>&nbsp;หญิง
        </div>
        <div class="col-xs-12 col-sm-2"></div>
       <div class="col-xs-12 col-sm-2">สัญชาติ : </div>
       <div class="col-xs-12 col-sm-2">
            <?php echo GetHtmlSelect('HEIRDESC_NATION_ID','HEIRDESC_NATION_ID',$arr_snation,'สัญชาติ',($rec_per['HEIRDESC_NATION_ID'] != '')?$rec_per['HEIRDESC_NATION_ID']:'3','','chosen','1',''); ?>
       </div>  
    </div>	
    <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">เชื้อชาติ : </div>
        <div class="col-xs-12 col-sm-2">
             <?php echo GetHtmlSelect('HEIRDESC_RACE_NATION_ID','HEIRDESC_RACE_NATION_ID',$arr_snation,'เชื้อชาติ',($rec_per['HEIRDESC_RACE_NATION_ID'] != '')?$rec_per['HEIRDESC_RACE_NATION_ID']:'3','','chosen','1',''); ?>
        </div>
        <div class="col-xs-12 col-sm-2"></div>
       <div class="col-xs-12 col-sm-2">ศาสนา : </div>
       <div class="col-xs-12 col-sm-2">
            <?php echo GetHtmlSelect('HEIRDESC_RELIGION_ID','HEIRDESC_RELIGION_ID',$arr_sreligion,'ศาสนา',($rec_per['HEIRDESC_RELIGION_ID'] !='')?$rec_per['HEIRDESC_RELIGION_ID']:'1','','chosen','1',''); ?>
       </div>  
    </div>
    <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">จำนวน : <span style="color:red;">*</span></div>
        <div class="col-xs-12 col-sm-3"><input type="text" id="HEIRDESC_PART" name="HEIRDESC_PART" class="form-control number" placeholder="จำนวน" value="<?php echo text($rec_per['HEIRDESC_PART']); ?>" style=" width:160px; display:inline;" >&nbsp;ส่วน</div>
    </div>		
    <div class="row head-form">ข้อมูลการติดต่อของผู้รับบำเหน็จตกทอด</div>
    <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">เลขที่ห้อง : </div>
        <div class="col-xs-12 col-sm-2">
             <input type="text" id="ADDRESS_ROOM_NO" name="ADDRESS_ROOM_NO" class="form-control" placeholder="เลขที่ห้อง" value="<?php echo text($rec_per['ADDRESS_ROOM_NO']); ?>" >
        </div>
        <div class="col-xs-12 col-sm-2"></div>
       <div class="col-xs-12 col-sm-2">ชั้น : </div>
       <div class="col-xs-12 col-sm-2">
            <input type="text" id="ADDRESS_FLOOR" name="ADDRESS_FLOOR" class="form-control" placeholder="ชั้น" value="<?php echo text($rec_per['ADDRESS_FLOOR']); ?>" >
       </div>  
    </div>
     <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">อาคาร : </div>
        <div class="col-xs-12 col-sm-2">
             <input type="text" id="ADDRESS_BUILDING" name="ADDRESS_BUILDING" class="form-control" placeholder="อาคาร" value="<?php echo text($rec_per['ADDRESS_BUILDING']); ?>" >
        </div>
        <div class="col-xs-12 col-sm-2"></div>
       <div class="col-xs-12 col-sm-2">บ้านเลขที่ : <span style="color:red;">*</span></div>
       <div class="col-xs-12 col-sm-2">
            <input type="text" id="ADDRESS_HOME_NO" name="ADDRESS_HOME_NO" class="form-control" placeholder="บ้านเลขที่" value="<?php echo text($rec_per['ADDRESS_HOME_NO']); ?>" >
       </div>  
    </div>
    <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">หมู่ที่ : </div>
        <div class="col-xs-12 col-sm-2">
             <input type="text" id="ADDRESS_MOO" name="ADDRESS_MOO" class="form-control number" placeholder="หมู่ที่" value="<?php echo text($rec_per['ADDRESS_MOO']); ?>" >
        </div>
        <div class="col-xs-12 col-sm-2"></div>
       <div class="col-xs-12 col-sm-2">หมู่บ้าน : </div>
       <div class="col-xs-12 col-sm-2">
            <input type="text" id="ADDRESS_VILLAGE" name="ADDRESS_VILLAGE" class="form-control " placeholder="หมู่บ้าน" value="<?php echo text($rec_per['ADDRESS_VILLAGE']); ?>" >
       </div>  
    </div>
    <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ซอย : </div>
        <div class="col-xs-12 col-sm-2">
             <input type="text" id="ADDRESS_SOI" name="ADDRESS_SOI" class="form-control " placeholder="ซอย" value="<?php echo text($rec_per['ADDRESS_SOI']); ?>" >
        </div>
        <div class="col-xs-12 col-sm-2"></div>
       <div class="col-xs-12 col-sm-2">ถนน : </div>
       <div class="col-xs-12 col-sm-2">
           <input type="text" id="ADDRESS_ROAD" name="ADDRESS_ROAD" class="form-control " placeholder="ถนน" value="<?php echo text($rec_per['ADDRESS_ROAD']); ?>" >
       </div>  
    </div>
    <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">จังหวัด : <span style="color:red;">*</span></div>
        <div class="col-xs-12 col-sm-2">
             <?php echo GetHtmlSelect('ADDRESS_PROV_ID',"ADDRESS_PROV_ID",$arr_prov,'จังหวัด',$rec_per['ADDRESS_PROV_ID']," onChange='getRampr(this)' ",'chosen','1',''); ?>
        </div>
        <div class="col-xs-12 col-sm-2"></div>
       <div class="col-xs-12 col-sm-2">อำเภอ/เขต : <span style="color:red;">*</span></div>
       <div class="col-xs-12 col-sm-2">
           <?php echo GetHtmlSelect('ADDRESS_AMPR_ID','ADDRESS_AMPR_ID',$arr_ampr,'อำเภอ/เขต',$rec_per['ADDRESS_AMPR_ID']," onChange='getStamb(this);' ",'chosen','1',''); ?>
       </div>  
    </div>
    <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำบล/แขวง : <span style="color:red;">*</span></div>
        <div class="col-xs-12 col-sm-2">
             <?php echo GetHtmlSelect('ADDRESS_TAMB_ID','ADDRESS_TAMB_ID',$arr_tamb,'ตำบล/แขวง',$rec_per['ADDRESS_TAMB_ID']," onChange='getZipcode(this);' ",'chosen','1',''); ?>
        </div>
        <div class="col-xs-12 col-sm-2"></div>
       <div class="col-xs-12 col-sm-2">รหัสไปรษณีย์ : <span style="color:red;">*</span></div>
       <div class="col-xs-12 col-sm-2">
           <input type="text" id="ADDRESS_ZIPCODE" name="ADDRESS_ZIPCODE" class="form-control" placeholder="รหัสไปรษณีย์" value="<?php echo text($rec_per['ADDRESS_ZIPCODE']); ?>" >
       </div>  
    </div>
    <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">หมายเลขโทรศัพท์ : <span style="color:red;">*</span></div>
        <div class="col-xs-12 col-sm-2">
             <input type="text" id="ADDRESS_TEL" name="ADDRESS_TEL" class="form-control  telbkk" placeholder="หมายเลขโทรศัพท์" value="<?php echo text($rec_per['ADDRESS_TEL']); ?>" > 
         </div>
        <div class="col-xs-12 col-sm-2">
        	<div class="input-group">
              <span class="input-group-addon">ต่อ</span>
              <input type="text" id="ADDRESS_TEL_EXT" name="ADDRESS_TEL_EXT"  class="form-control number" placeholder="ต่อ" value="<?php echo $rec_per['ADDRESS_TEL_EXT']; ?>" style="width:100px;"  >
              </div>
        </div>
       <div class="col-xs-12 col-sm-2">หมายเลขโทรสาร : </div>
       <div class="col-xs-12 col-sm-2">
           <input type="text" id="ADDRESS_FAX" name="ADDRESS_FAX" class="form-control  telbkk" placeholder="หมายเลขโทรสาร" value="<?php echo text($rec_per['ADDRESS_FAX']); ?>" >
           
       </div>
       <div class="col-xs-12 col-sm-2">
       	<div class="input-group">
            <span class="input-group-addon">ต่อ</span>
            <input type="text" id="ADDRESS_FAX_EXT" name="ADDRESS_FAX_EXT"  class="form-control number " placeholder="ต่อ" value="<?php echo $rec_per['ADDRESS_FAX_EXT']; ?>" style="width:100px;">
           </div>
       </div>  
    </div>
    <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">หมายเลขโทรศัพท์เคลื่อนที่ : </div>
        <div class="col-xs-12 col-sm-2">
            <input type="text" id="ADDRESS_MOBILE" name="ADDRESS_MOBILE" class="form-control mobile" placeholder="หมายเลขโทรศัพท์เคลื่อนที่" value="<?php echo text($rec_per['ADDRESS_MOBILE']); ?>" >
        </div>
        <div class="col-xs-12 col-sm-2"></div>
       <div class="col-xs-12 col-sm-2">อีเมล์ : </div>
       <div class="col-xs-12 col-sm-2">
       		<input type="text" id="ADDRESS_EMAIL" name="ADDRESS_EMAIL" class="form-control" placeholder="อีเมล์" value="<?php echo text($rec_per['ADDRESS_EMAIL']); ?>" >
       </div>  
    </div>
   
      <div class="col-xs-12 col-sm-12" align="center" style="margin-top:10px;">
        <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
        <button type="button" class="btn btn-default" 
        onClick="$('#frm-input').attr('action','profile_heirhis_form.php').submit();" >ยกเลิก</button>
      </div>
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>