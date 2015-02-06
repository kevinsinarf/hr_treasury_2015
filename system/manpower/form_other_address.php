<?php
session_start();
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล";

$sqlEdit = "select * from setup_org where org_id = '".$org_id."' ";
$QEdit = $db->query($sqlEdit);
$rec = $db->db_fetch_array($QEdit);
$rec = @array_change_key_case($rec,CASE_LOWER);
$org_year = $rec["org_year"];
$org_parent_id = $rec["org_parent_id"];
$ot_id = $rec["ot_id"];
$ol_id = $rec["ol_id"];
$org_name_th = text($rec["org_name_th"]);
$org_name_en = text($rec["org_name_en"]);
$org_shortname_th = text($rec["org_shortname_th"]);
$org_shortname_en = text($rec["org_shortname_en"]);
$org_address = text($rec["org_address"]);
$org_prov_id = text($rec["org_prov_id"]);
$org_ampr_id = text($rec["org_ampr_id"]);
$org_tamb_id = text($rec["org_tamb_id"]);
$org_tel = $rec["org_tel"];
$org_fax = $rec["org_fax"];
$active_status = $rec["active_status"];

if($org_parent_id != ""){
	$parent_name = $db->get_data_field("select org_name_th from setup_org where org_id = '".$org_parent_id."' ","org_name_th");
}

$sqlOL = "";
if($proc == 'add'){
	if($seq == ''){
		$sqlOL = "select ol_id,ol_name_th from setup_org_level where ol_id = '16'";
	}else{
		$sqlOL = "select ol_id,ol_name_th from setup_org_level where ol_id = '17'";
	}  
}else{
	$sqlOL = "select b.ol_id,b.ol_name_th from 
	setup_org a INNER JOIN setup_org_level b ON a.ol_id = b.ol_id where org_id = '".$org_id."'";   
}
$QOL = $db->query($sqlOL);

$Stype = "select ot_id , ot_name_th from setup_org_type where ot_id = '".$ot_id."'";
$Qtype = $db->query($Stype);


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
<link href="<?php echo $path; ?>bootstrap/css/chosen.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="<?php echo $path; ?>bootstrap/js/jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/transition.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/holder.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/collapse.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/dropdown.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/modal.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/carousel.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/respond.min.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/html5shiv.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/chosen.jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/disp_gov_other.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
    <div><?php include($path."include/menu.php"); ?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="#" onClick="$('#frm').attr('action','disp_gov_other.php').submit();" >ส่วนราชการอื่น</a></li>
          <li class="active"><?php echo $txt; ?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content">
        <div class="groupdata" >
            <form id="frm" method="post" action="process/gov_other_process.php">
                <input name="proc" type="hidden" id="proc" value="edit1">
                <input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
                <input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
                <input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
                <input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
                <input name="parent_id" type="hidden" id="parent_id" value="<?php echo $org_parent_id; ?>">
                <input name="org_id" type="hidden" id="org_id" value="<?php echo $org_id; ?>">
                <input name="seq" type="hidden" id="seq" value="<?php echo $seq; ?>">
                 <input name="S_ORG_ID_1" type="hidden" id="S_ORG_ID_1" value="<?php echo $S_ORG_ID_1; ?>">
                 <input name="S_ORG_ID_2" type="hidden" id="S_ORG_ID_2" value="<?php echo $S_ORG_ID_2; ?>">
                <div class="row formSep ">
                    <div class="col-xs-12 col-sm-2" >ปีที่จัดโครงสร้าง :</div>
                    <div class="col-xs-12 col-sm-3"><?php echo $org_year; ?></div>
                    <?php if($org_parent_id != ""){ ?>
                    <div class="col-xs-12 col-sm-2" >หน่วยงานต้นสังกัด :</div>
                    <div class="col-xs-12 col-sm-3"><?php echo text($parent_name); ?></div>
                    <?php } ?>
                </div>
                
                <div class="row formSep ">
                    <div class="col-xs-12 col-sm-2" >ประเภทส่วนราชการ :</div>
                    <div class="col-xs-12 col-sm-3">
					<?php 
					while($recType = $db->db_fetch_array($Qtype)){
						$sel = ($ot_id == $recType["ot_id"]) ? "$ot_id":"";
						echo text($recType["ot_name_th"]); 
                    }
					?>
                	</div>
                	<div class="col-xs-12 col-sm-2" >ฐานะของหน่วยงาน :</div>
                	<div class="col-xs-12 col-sm-3">
					<?php 
					while($recOL = $db->db_fetch_array($QOL)){ 
						$recOL = array_change_key_case($recOL,CASE_LOWER);
						echo text($recOL["ol_name_th"]);
					}
					?>
                	</div>
                </div>
                
                <div class="row formSep">
                	<div class="col-xs-12 col-sm-2" >ชื่อหน่วยงาน(ภาษาไทย) :</div>
                	<div class="col-xs-12 col-sm-3"><?php echo $org_name_th; ?></div>
               	 	<div class="col-xs-12 col-sm-2" >ชื่อหน่วยงาน(ภาษาอังกฤษ) :</div>
                	<div class="col-xs-12 col-sm-3"><?php echo $org_name_en; ?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-sm-2" >ชื่อย่อหน่วยงาน(ภาษาไทย) :</div>
                    <div class="col-xs-12 col-sm-3"><?php echo $org_shortname_th; ?></div>
                    <div class="col-xs-12 col-sm-2" >ชื่อย่อหน่วยงาน(ภาษาอังกฤษ) :</div>
                    <div class="col-xs-12 col-sm-3"><?php echo $org_shortname_en; ?></div>
                </div>
                
                <div class="row formSep">
					<?php 
                    //จังหวัด
                    $arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME");
                    //อำเภอ/เขต
                    $arr_ampr=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$org_prov_id."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
                    //ตำบล/แขวง
                    $arr_tamb=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='".$org_ampr_id."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");
                    ?>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัด </div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('prov_id','prov_id',$arr_prov,'จังหวัด',$org_prov_id,'onchange="getRampr(this,\'ampr_id'.'\',\'tamb_id'.'\')"','','1');?></div>
                    <div class="col-xs-12 col-md-1" style="white-space:nowrap;">อำเภอ/เขต </div>
                    <div class="col-xs-12 col-md-2"><span id='ss_ampr'><?php echo GetHtmlSelect('ampr_id','ampr_id',$arr_ampr,'อำเภอ/เขต',$org_ampr_id,'onchange="getStamb(this.id,this.value,\'tamb_id'.'\') " ','','1');?></span></div>
                    <div class="col-xs-12 col-md-1" style="white-space:nowrap;">ตำบล/แขวง </div>
                    <div class="col-xs-12 col-md-2"><span id='ss_tamb'><?php echo GetHtmlSelect('tamb_id','tamb_id',$arr_tamb,'ตำบล/แขวง',$org_tamb_id,'','','1');?></span></div>            
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-sm-2" >ที่อยู่ :</div>
                    <div class="col-xs-12 col-sm-8"><textarea name="org_address" class="form-control" id="org_address" rows="5"><?php echo $org_address; ?></textarea></div>
                </div>
           		
                <div class="formlast">
                	<div class="col-xs-12 col-sm-12" align="center">
                    <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                    <button type="button" class="btn btn-default" onClick="$('#frm').attr('action','disp_gov_other.php').submit();" >ยกเลิก</button>
                	</div>
                </div> 
            </form>
        </div>
    </div>
 <div style="text-align:center;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>