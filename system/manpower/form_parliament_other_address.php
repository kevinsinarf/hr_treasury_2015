<?php
session_start();
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$org_id=$_POST['org_id'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล";


$sqlEdit = "select * from setup_org where org_id = '".$org_id."' ";
$QEdit = $db->query($sqlEdit);
$rec1 = $db->db_fetch_array($QEdit);
$rec1 = @array_change_key_case($rec1,CASE_LOWER);
$org_year = $rec1["org_year"];
$org_parent_id = $rec1["org_parent_id"];
$ot_id = $rec1["ot_id"];
$ol_id = $rec1["ol_id"];
$org_name_th = text($rec1["org_name_th"]);
$org_name_en = text($rec1["org_name_en"]);
$org_shortname_th = text($rec1["org_shortname_th"]);
$org_shortname_en = text($rec1["org_shortname_en"]);
$org_address = text($rec1["org_address"]);
$org_prov_id = $rec1["org_prov_id"];
$org_ampr_id = $rec1["org_ampr_id"];
$org_tamb_id = $rec1["org_tamb_id"];
$org_tel = $rec1["org_tel"];
$org_fax = $rec1["org_fax"];
$active_status = $rec1["active_status"];

if($org_parent_id != ""){
	$parent_name = $db->get_data_field("select org_name_th from setup_org where org_id = '".$org_parent_id."' ","org_name_th");
}


if($seq == ''){
	$sqlOL = "select ol_id,ol_name_th from setup_org_level where ol_id = '16'";
}else{
	$sqlOL = "select ol_id,ol_name_th from setup_org_level where ol_id = '17'";
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
<script src="js/disp_parliament_other.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div>
        <div class="col-xs-12 col-sm-12">
            <ol class="breadcrumb">
              <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
              <li><a href="disp_parliament_other.php?<?php echo $paramlink; ?>">สำนักงานเลขาธิการสภาผู้แทนราษฎร</a></li>
              <li class="active"><?php echo $txt; ?></li>
            </ol>
        </div >
        <div class="col-xs-12 col-sm-12" id="content">
            <div class="groupdata">
                            
                <form id="frm-input" method="post" action="process/process_parliament_other.php">
                    <input name="proc" type="hidden" id="proc" value="edit1">
                    <input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
                    <input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
                    <input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
                    <input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
                    <input name="parent_id" type="hidden" id="parent_id" value="<?php echo $org_parent_id; ?>">
                    <input name="org_id" type="hidden" id="org_id" value="<?php echo $org_id; ?>">
                    <input type="hidden" id="SS_ID" name="SS_ID" value="<?php echo $SS_ID?>">
                    <div class="row formSep ">
                    <div class="col-xs-12 col-sm-2" >ปีที่จัดโครงสร้าง :</div>
                    <div class="col-xs-12 col-sm-3"><label><span id="org_year2" name="org_year2"><?php echo $org_year; ?></span></label>
                    <input name="org_year" class="form-control hidden" id="org_year" type="text" value="<?php echo $org_year; ?>"></div>
                    <?php if($org_parent_id != ""){ ?>
                    <div class="col-xs-12 col-sm-2" >หน่วยงานต้นสังกัด :</div>
                    <div class="col-xs-12 col-sm-3"><?php echo text($parent_name); ?></div>
                    <?php } ?></div>
                    <div class="row formSep ">
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-2" >ประเภทส่วนราชการ :</div>
                    <div class="col-xs-12 col-sm-3"><?php
                        	while($recType = $db->db_fetch_array($Qtype)){	
                                                    ?>
                    <label><span id="ot_id2" name="ot_id2"><?php echo text($recType['ot_name_th']); ?></span></label>
                    <input name="ot_id" class="form-control hidden" id="ot_id" type="text" value="<?php echo $recType['ot_id']; ?>">           
                   <?php }?>
                    </div>
                    <div class="clearfix visible-xs"><br \></div>
                    <div class="col-xs-12 col-sm-2" >ฐานะของหน่วยงาน :</div>
                    <div class="col-xs-12 col-sm-3">
                    <?php while($recOL = $db->db_fetch_array($QOL)){ 
					$recOL = array_change_key_case($recOL,CASE_LOWER);?>
                        <label><span id="ol_id2" name="ol_id2"><?php echo text($recOL["ol_name_th"]); ?></span></label>
                        <input id="ol_id" type="hidden" name="ol_id" class="form-control number" placeholder="ปีที่"   value="<?php echo $recOL["ol_id"]; ?>">
                    <?php }?>
                    </div>
                    </div>
                    <div class="row formSep ">
                    <div class="col-xs-12 col-sm-2" >ชื่อหน่วยงาน(ภาษาไทย) :</div>
                    <div class="col-xs-12 col-sm-3"><label><span id="org_name_th2" name="org_name_th2"><?php echo $org_name_th; ?></span></label>
                    <input name="org_name_th" class="form-control hidden" id="org_name_th" type="text" value="<?php echo $org_name_th; ?>"></div>
                    <div class="clearfix visible-xs"><br \></div>
                    <div class="col-xs-12 col-md-2" >ชื่อหน่วยงาน(ภาษาอังกฤษ) :</div>
                    <div class="col-xs-12 col-md-3"><label><span id="org_name_en" name="org_name_en"><?php echo $org_name_en; ?></span></label>
                    <input name="org_name_en" class="form-control hidden" id="org_name_en" type="text" value="<?php echo $org_name_en; ?>"></div>
                    </div>
                    <div class="row formSep ">
                    <div class="col-xs-12 col-sm-2" >ชื่อย่อหน่วยงาน(ภาษาไทย) :</div>
                    <div class="col-xs-12 col-sm-3"><label><span id="org_shortname_th2" name="org_shortname_th2"><?php echo $org_shortname_th; ?></span></label>
                    <input name="org_shortname_th" class="form-control hidden" id="org_shortname_th" type="text" value="<?php echo $org_shortname_th; ?>"></div>
                    <div class="clearfix visible-xs"><br \></div>
                    <div class="col-xs-12 col-sm-2" >ชื่อย่อหน่วยงาน(ภาษาอังกฤษ) :</div>
                    <div class="col-xs-12 col-sm-3"><label><span id="org_shortname_en2" name="org_shortname_en2"><?php echo $org_shortname_en; ?></span></label>
                    <input name="org_shortname_en" class="form-control hidden" id="org_shortname_en" type="text" value="<?php echo $org_shortname_en; ?>"></div>
                    </div>
                     <div class="row formSep">
					<?php 
					//จังหวัด
					$arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME");
					//อำเภอ/เขต
					$arr_ampr=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$rec1['org_prov_id']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
					
					//ตำบล/แขวง
					$arr_tamb=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='".$rec1['org_ampr_id']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");
					?>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัด :</div>
							<div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('prov_id','prov_id',$arr_prov,'จังหวัด',$rec1['org_prov_id'],'onchange="getRampr(this,\'ampr_id\',\'tamb_id\')"','','1');?></div>
							<div class="col-xs-12 col-md-1" style="white-space:nowrap;">อำเภอ/เขต :</div>
							<div class="col-xs-12 col-md-2"><span id='ss_ampr'><?php echo GetHtmlSelect('ampr_id','ampr_id',$arr_ampr,'อำเภอ/เขต',$rec1['org_ampr_id'],'onchange="getStamb(this.id,this.value,\'tamb_id\') " ','','1');?></span></div>
							<div class="col-xs-12 col-md-1" style="white-space:nowrap;">ตำบล/แขวง :</div>
							<div class="col-xs-12 col-md-2"><span id='ss_tamb'><?php echo GetHtmlSelect('s_tamb','s_tamb',$arr_tamb,'ตำบล/แขวง',$rec1['org_tamb_id'],'','','1');?></span></div>            
					</div>
                    <div class="row formSep">
                    <div class="col-xs-12 col-sm-2" >ที่อยู่ :</div>
                    <div class="col-xs-12 col-sm-8"><textarea name="org_address" class="form-control" id="org_address" rows="5"><?php echo $org_address; ?></textarea></div>
                    </div>
                    <div class="formlast">
                    <div class="col-xs-12 col-sm-12" align="center">
                        <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                        <button type="button" class="btn btn-default" onClick="self.location.href='disp_parliament_other.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
                    </div>
                    </div>
                </form>
            
        </div>
        </div>
    </div>
    <br \>
    <div style="text-align:center;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>