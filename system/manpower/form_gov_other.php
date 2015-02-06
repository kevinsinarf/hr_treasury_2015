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
$prov_id = $rec["org_prov_id"];
$ampr_id = $rec["org_ampr_id"];
$tamb_id = $rec["org_tamb_id"];
$org_tel = $rec["org_tel"];
$org_ext = text($rec['org_ext']);
$org_fax = $rec["org_fax"];
$active_status = $rec["active_status"];
$ct_id = $rec['ct_id'];
$org_notice_date = $rec['org_notice_date'];
$org_notice_sdate = $rec['org_notice_sdate'];
$org_notice_title = text($rec['org_notice_title']);
$org_gazette_book = text($rec['org_gazette_book']);
$org_gazette_part = text($rec['org_gazette_part']);
$org_gazette_date = $rec['org_gazette_date'];
$org_gazette_page = text($rec['org_gazette_page']);
$org_gazette_sdate = $rec['org_gazette_sdate'];
$org_seq = text($rec['org_seq']);


if($org_parent_id != ""){
	$parent_name = $db->get_data_field("select org_name_th from setup_org where org_id = '".$org_parent_id."' ","org_name_th");
}

$sqlOL = "";
if($proc == 'add'){
	if($seq == 'ministry'){
		$sqlOL = "select ol_id,ol_name_th from setup_org_level where ol_id = '2'";
	}else{
		$sqlOL = "select ol_id,ol_name_th from setup_org_level where ol_id = '".$seq."' ";
	}  
}else{
	$sqlOL = "select b.ol_id,b.ol_name_th from 
	setup_org a INNER JOIN setup_org_level b ON a.ol_id = b.ol_id where org_id = '".$org_id."'";   
}
$QOL = $db->query($sqlOL);

$Stype = "select ot_id , ot_name_th from setup_org_type";
$Qtype = $db->query($Stype);

$Sprovince = "select * from setup_prov order by prov_th_name asc";
$Qprov = $db->query($Sprovince);

$Sampr = "select * from setup_ampr where prov_id = '".$prov_id."' order by ampr_name_th asc";
$Qampr = $db->query($Sampr);

$Stamb = "select * from setup_tamb where ampr_id = '".$ampr_id."' order by tamb_name_th asc";
$Qtamb = $db->query($Stamb);

$arr_command_type = GetSqlSelectArray("CT_ID", "CT_NAME_TH", "SETUP_COMMAND_TYPE", " 1=1 ", "CT_NAME_TH");
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
          <li><a href="#" onClick="$('#frm').attr('action','disp_gov_other.php').submit();">ส่วนราชการอื่น</a></li>
          <li class="active"><?php echo $txt; ?></li>
        </ol>
    </div>
    
    <div class="col-xs-12 col-sm-12" id="content">
        <div class="groupdata" >
            <form id="frm" method="post" action="process/gov_other_process.php">
                <input name="proc" type="hidden" id="proc" value="<?php echo $proc; ?>">
                <input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
                <input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
                <input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
                <input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
                <input name="parent_id" type="hidden" id="parent_id" value="<?php echo $org_parent_id; ?>">
                <input name="org_id" type="hidden" id="org_id" value="<?php echo $org_id; ?>">
                <input name="org_id1" type="hidden" id="org_id1" value="<?php echo $org_id1; ?>">
                <input name="seq" type="hidden" id="seq" value="<?php echo $seq; ?>">
                 <input name="S_ORG_ID_1" type="hidden" id="S_ORG_ID_1" value="<?php echo $S_ORG_ID_1; ?>">
                 <input name="S_ORG_ID_2" type="hidden" id="S_ORG_ID_2" value="<?php echo $S_ORG_ID_2; ?>">
                 <input name="flagDup1" type="hidden" id="flagDup1">
                 <div class="row head-form">ประกาศ</div>
                <div class="row formSep">
                  <div class="col-xs-12 col-sm-2" >ประเภทประกาศ </div>
                  <div class="col-xs-12 col-sm-3"><?php echo GetHtmlSelect('CT_ID','CT_ID',$arr_command_type,'ประเภทประกาศ',$ct_id,'','','1');?></div>
                </div>
                 
                 <div class="row formSep">
                  <div class="col-xs-12 col-sm-2" >วันที่ลงประกาศ </div>
                  <div class="col-xs-12 col-sm-2">
                    <div class="input-group">
                      <input type="text" id="ORG_NOTICE_DATE" name="ORG_NOTICE_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date($org_notice_date);;?>">
                      <span class="input-group-addon datepicker" for="ORG_NOTICE_DATE" data-date="<?php echo ($S_DATE);?>">&nbsp;
                          <span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                   </div>
                  </div>
                  <div class="col-xs-12 col-sm-1"></div>
                  <div class="col-xs-12 col-sm-2" >วันที่มีผล </div>
                  <div class="col-xs-12 col-sm-2">
                    <div class="input-group">
                      <input type="text" id="ORG_NOTICE_SDATE" name="ORG_NOTICE_SDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date($org_notice_sdate);?>">
                      <span class="input-group-addon datepicker" for="ORG_NOTICE_SDATE" data-date="<?php echo ($ORG_NOTICE_SDATE);?>">&nbsp;
                          <span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                   </div>
                  </div>
                </div>
                <div class="row formSep">
                  <div class="col-xs-12 col-sm-2" >เรื่อง </div>
                  <div class="col-xs-12 col-sm-7"><input name="ORG_NOTICE_TITLE" class="form-control" id="ORG_NOTICE_TITLE" type="text" value="<?php echo $org_notice_title; ?>"></div>
                </div>
               <div class="row head-form">ราชกิจจานุเบกษา</div>
                <div class="row formSep">
                  <div class="col-xs-12 col-sm-2" >เล่ม </div>
                  <div class="col-xs-12 col-sm-2">
                    <input name="ORG_GAZETTE_BOOK" class="form-control" id="ORG_GAZETTE_BOOK" type="text" value="<?php echo $org_gazette_book; ?>">
                  </div>
                  <div class="col-xs-12 col-sm-1"></div>
                  <div class="col-xs-12 col-sm-2" >ตอนที่ </div>
                  <div class="col-xs-12 col-sm-2">
                    <input name="ORG_GAZETTE_PART" class="form-control" id="ORG_GAZETTE_PART" type="text" value="<?php echo $org_gazette_part; ?>">
                  </div>
                 </div>
                <div class="row formSep">
                  <div class="col-xs-12 col-sm-2" >วันที่ </div>
                  <div class="col-xs-12 col-sm-2">
                    <div class="input-group">
                      <input type="text" id="ORG_GAZETTE_DATE" name="ORG_GAZETTE_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date($org_gazette_date);;?>">
                      <span class="input-group-addon datepicker" for="ORG_GAZETTE_DATE" data-date="<?php echo ($ORG_GAZETTE_DATE);?>">&nbsp;
                      <span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-1"></div>
                <div class="col-xs-12 col-sm-2" >หน้าที่ </div>
                <div class="col-xs-12 col-sm-2">
                  <input name="ORG_GAZETTE_PAGE" class="form-control" id="ORG_GAZETTE_PAGE" type="text" value="<?php echo $org_gazette_page; ?>">
                </div>
               </div>
               <div class="row formSep">
                  <div class="col-xs-12 col-sm-2" >วันที่มีผล </div>
                  <div class="col-xs-12 col-sm-2">
                    <div class="input-group">
                      <input type="text" id="ORG_GAZETTE_SDATE" name="ORG_GAZETTE_SDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date($org_gazette_sdate);?>">
                      <span class="input-group-addon datepicker" for="ORG_GAZETTE_SDATE" data-date="<?php echo ($ORG_GAZETTE_SDATE);?>">&nbsp;
                      <span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                  </div>
                </div>
               </div>
                <div class="row head-form">หน่วยงาน</div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-sm-2" >ลำดับหน่วยงาน </div>
                    <div class="col-xs-12 col-sm-3"><input type="text" name="ORG_SEQ" id="ORG_SEQ" value="<?php echo $org_seq;?>" class="form-control number" style="width:100px;" maxlength="10"></div>
                </div>
                
                <div class="row formSep">
                <div class="col-xs-12 col-sm-2" >ปีที่จัดโครงสร้าง </div>
                <div class="col-xs-12 col-sm-3">
                <select id="org_year" name="org_year" class="selectbox form-control" placeholder="ปีที่จัดโครงสร้าง">
                  <option value=""></option>
                  <?php for($Y=($YEAR_PRESENT-10);$Y<=($YEAR_PRESENT+2);$Y++){//select ปี
                            $A_CONFIG_YEAR[$Y] = $Y; ?>
                      <option value="<?php echo $Y; ?>"<?php echo ($Y == $org_year ? "selected" : ""); ?>><?php echo $Y; ?></option>
                  <?php } ?>
              </select>
                </div>
                <?php if($org_parent_id != ""){ ?>
                <div class="col-xs-12 col-sm-2" >หน่วยงานต้นสังกัด :</div>
                <div class="col-xs-12 col-sm-3"><?php echo text($parent_name); ?></div>
                <?php } ?></div>
                <div class="row formSep">
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-2" >ประเภทส่วนราชการ <span style="color:red;">*</span>&nbsp;</div>
                <div class="col-xs-12 col-sm-3">
                <select name="ot_id" class="selectbox form-control" id="ot_id" placeholder="ประเภทส่วนราชการ">
                    <option value=""></option>
                    <?php
                        while($recType = $db->db_fetch_array($Qtype)){
                            $recType = array_change_key_case($recType,CASE_LOWER);
                            $sel = ($ot_id == $recType["ot_id"]) ? "selected":"";
                    ?>
                    <option value="<?php echo $recType["ot_id"];?>" <?php echo $sel; ?>><?php echo text($recType["ot_name_th"]); ?></option>
                    <?php
                        }
                    ?>
                </select>
                </div>
                <div class="clearfix visible-xs"><br \></div>
                <div class="col-xs-12 col-sm-2" >ฐานะของหน่วยงาน :</div>
                <div class="col-xs-12 col-sm-3"><?php while($recOL = $db->db_fetch_array($QOL)){ 
                            $recOL = array_change_key_case($recOL,CASE_LOWER);?>
                    <label><span id="ol_id2" name="ol_id2"><?php echo text($recOL["ol_name_th"]); ?></span></label>
                    <input id="ol_id" type="hidden" maxlength="2" name="ol_id" class="form-control number" placeholder="ปีที่"   value="<?php echo $recOL["ol_id"]; ?>">
                <?php }?>
                </div>
                </div>
                <div class="row formSep">
                	<div class="col-xs-12 col-sm-2" >ชื่อหน่วยงาน(ภาษาไทย) <span style="color:red;">*</span>&nbsp;</div>
                	<div class="col-xs-12 col-sm-8"><input name="org_name_th" class="form-control" id="org_name_th" type="text" value="<?php echo $org_name_th; ?>"  onKeyUp="chkDup('chkDup1','flagDup1','org_name_th','ORG_ID','SETUP_ORG','ORG_PARENT_ID =<?php echo $org_id1 ?>');" placeholder="ชื่อหน่วยงาน (ภาษาไทย) "></div>
                    <span  id="chkDup1" class="hidden-xs label col-xs-12 col-sm-2"></span>
                </div>
                <div class="row formSep">
                	<div class="col-xs-12 col-sm-2" >ชื่อหน่วยงาน(ภาษาอังกฤษ) :</div>
                	<div class="col-xs-12 col-sm-8"><input name="org_name_en" class="form-control" id="org_name_en" type="text" value="<?php echo $org_name_en; ?>"></div>
                </div>
                <div class="row formSep">
                <div class="col-xs-12 col-sm-2" >ชื่อย่อหน่วยงาน(ภาษาไทย) :</div>
                <div class="col-xs-12 col-sm-3"><input name="org_shortname_th" class="form-control" id="org_shortname_th" type="text" value="<?php echo $org_shortname_th; ?>"></div>
                <div class="clearfix visible-xs"><br \></div>
                <div class="col-xs-12 col-sm-2" >ชื่อย่อหน่วยงาน(ภาษาอังกฤษ) :</div>
                <div class="col-xs-12 col-sm-3"><input name="org_shortname_en" class="form-control" id="org_shortname_en" type="text" value="<?php echo $org_shortname_en; ?>"></div>
                </div>
                 <div class="row formSep">
                <div class="col-xs-12 col-sm-2" >สถานะของการใช้งาน :</div>
                <div class="col-xs-6 col-sm-2">
                           <label><input name="active_status" type="radio" id="active_status1" value="1" <?php echo ($active_status == '1' ? "checked":""); ?>> <?php echo $arr_act_status['1'];?></label>&nbsp;&nbsp;
                           <label><input name="active_status" type="radio" id="active_status2" value="2" <?php echo ($active_status == '2' || $active_status == '' ? "checked":""); ?>> <?php echo $arr_act_status['0'];?></label>	
                </div>
                </div>
                <div class="row head-form">ที่ตั้งหน่วยงาน</div>
                <div class="row formSep">
                <div class="col-xs-12 col-sm-2" >ที่อยู่ :</div>
                <div class="col-xs-12 col-sm-8"><input type="text" name="org_address" class="form-control" id="org_address"  value="<?php echo $org_address; ?>" ></div>
                <div class="clearfix"></div></div>
                <div class="row formSep">
                <div class="col-xs-12 col-sm-2" >จังหวัด :</div>
                <div class="col-xs-12 col-sm-2">
                <select name="prov_id" class="selectbox form-control" id="prov_id" placeholder="จังหวัด" onChange="getRampr(this,'ampr_id','tamb_id');">
                    <option value=""></option>
                    <?php 
                        while($recProvince = $db->db_fetch_array($Qprov)){ 
                            $recProvince = array_change_key_case($recProvince,CASE_LOWER);
                            $sel = ($prov_id == $recProvince["prov_id"]) ? "selected":"";
                    ?>
                    <option value="<?php echo $recProvince["prov_id"]; ?>" <?php echo $sel; ?>><?php echo text($recProvince["prov_th_name"]); ?></option>
                    <?php } ?>
                </select>
                </div>
                <div class="clearfix visible-xs"><br \></div>
                <div class="col-xs-12 col-sm-1" >อำเภอ :</div>
                <div class="col-xs-12 col-sm-2"><span id='ss_ampr'>
                <select name="ampr_id" class="selectbox form-control" id="ampr_id" placeholder="อำเภอ" onChange="getStamb('ampr_id',this.value,'tamb_id')">
                    <option value=""></option>
                    <?php
                        while($recAmpr = $db->db_fetch_array($Qampr)){
                            $recAmpr = array_change_key_case($recAmpr,CASE_LOWER);
                            $sel = ($ampr_id == $recAmpr["ampr_id"]) ? "selected":"";
                    ?>
                    <option value="<?php echo $recAmpr["ampr_id"]; ?>" <?php echo $sel; ?>><?php echo text($recAmpr["ampr_name_th"]); ?></option>
                    <?php
                        }
                    ?>
                </select>
                </span>
                </div>
                <div class="col-xs-12 col-sm-1" >ตำบล :</div>
                <div class="col-xs-12 col-sm-2"><span id='ss_tamb'>
                <select name="tamb_id" class="selectbox form-control" id="tamb_id" placeholder="ตำบล">
                    <option value=""></option>
                    <?php
                        while($recTamb = $db->db_fetch_array($Qtamb)){
                            $recTamb = array_change_key_case($recTamb,CASE_LOWER);
                            $sel = ($tamb_id == $recTamb["tamb_id"]) ? "selected":"";
                    ?>
                    <option value="<?php echo $recTamb["tamb_id"]; ?>" <?php echo $sel; ?>><?php echo text($recTamb["tamb_name_th"]); ?></option>
                    <?php
                        }
                    ?>
                </select>
                </span>
                </div>
                </div>
                <div class="row formSep">
                  <div class="clearfix visible-xs"></div>
                  <div class="col-xs-12 col-sm-2" >หมายเลขโทรศัพท์ :</div>
                  <div class="col-xs-12 col-sm-3"><input name="org_tel" class="form-control number" id="org_tel" type="text" value="<?php echo $org_tel; ?>" style="width:150px; display:inline-table;"  > ต่อ <input name="org_ext" class="form-control number" id="org_ext" type="text" value="<?php echo $org_ext; ?>" style="width:70px; display:inline-table;"  ></div>                     
                  <div class="col-xs-12 col-sm-2" >หมายเลขโทรสาร :</div>
                  <div class="col-xs-12 col-sm-3"><input name="org_fax" class="form-control number" id="org_fax" type="text" value="<?php echo $org_fax; ?>"></div>
                </div>
               <br>
                <div class="col-xs-12 col-sm-12" align="center">
                    <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                    <button type="button" class="btn btn-default" onClick="$('#frm').attr('action','disp_gov_other.php').submit();" >ยกเลิก</button>
                </div>
                <div class="clearfix"></div><br \> 
            </form>
        </div>
    </div>
    <br \>
    <div style="position:relative; text-align:center;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>