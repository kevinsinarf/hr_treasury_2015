<?php
session_start();
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

switch($proc){
	case "edit" :
	
	$table   = " COMPETENCY_SET ";
	$field   = " * ";
	$cond    = " WHERE COMSET_ID = '".$COMSET_ID."' ";
 
 	//--QUERY
	$sql_edit =  "SELECT ".$field." FROM ".$table.$cond;
	$query_edit = $db->query($sql_edit);
	$rec_edit = $db->db_fetch_array($query_edit);
	break;
}

$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล";


//หัวข้อสรรถนะ
$query_compet = $db->query("SELECT * FROM COMPETENCY_TITLE WHERE ACTIVE_STATUS = 1 AND COMTITLE_TYPE = 1");
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = 1 ", "TYPE_NAME_TH");	//ประเภทตำแหน่ง
$arr_pos_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = 1 ", "LEVEL_NAME_TH"); //ระดับตำแหน่ง/กลุ่มงาน
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
<script src="js/competency_main_year.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
    <div><?php include($path."include/menu.php"); ?></div>
        <div class="col-xs-12 col-sm-12">
            <ol class="breadcrumb">
              <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
              <li><a href="competency_main_year_disp.php?<?php echo $paramlink; ?>">สมรรถนะหลักประจำปี</a></li>
              <li class="active"><?php echo $txt; ?></li>
            </ol>
        </div>
        <div class="col-xs-12 col-sm-12" id="content">
            <div class="groupdata" >
                <form id="frm" method="post" action="process/competency_main_year_process.php">
                    <input name="proc" type="hidden" id="proc" value="<?php echo $proc; ?>">
                    <input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
                    <input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
                    <input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
                    <input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
                    <input name="COMSET_ID" type="hidden" id="COMSET_ID" value="<?php echo $COMSET_ID; ?>">
                    <div class="row formSep">
                      <div class="col-xs-12 col-sm-2" >ปีที่ใช้สมรรถนะ : <span style="color:red;">*</span>&nbsp;</div>
                      <div class="col-xs-12 col-sm-3">
                      <select id="COMSET_YEAR" name="COMSET_YEAR" onChange="Chkrepeat();" class="selectbox form-control" placeholder="ปีที่ใช้สมรรถนะ">
                        <option value=""></option>
                        <?php for($Y=($YEAR_PRESENT-10);$Y<=($YEAR_PRESENT+2);$Y++){//select ปี
                                  $A_CONFIG_YEAR[$Y] = $Y; ?>
                            <option value="<?php echo $Y; ?>"<?php echo ($Y == $rec_edit['COMSET_YEAR'] ? "selected" : ""); ?>><?php echo $Y; ?></option>
                        <?php } ?>
                    </select>
                      </div>
                      <div class="col-xs-12 col-sm-1" ></div>
                      <div class="col-xs-12 col-sm-2" >ชื่อหัวข้อสมรรถนะหลัก : <span style="color:red;">*</span>&nbsp;</div>
                      <div class="col-xs-12 col-sm-3">
                      <select id="COMTITLE_ID" name="COMTITLE_ID" class="selectbox form-control" placeholder="ชื่อหัวข้อสมรรถนะหลัก" onChange="Chkrepeat();" >
                        <option value=""></option>
                        <?php while($rec_com = $db->db_fetch_array($query_compet)){ ?>
                                  
                            <option value="<?php echo $rec_com['COMTITLE_ID']; ?>"<?php echo ($rec_com['COMTITLE_ID'] == $rec_edit['COMTITLE_ID'] ? "selected" : ""); ?>><?php echo text($rec_com['COMTITLE_NAME_TH']); ?></option>
                        <?php } ?>
                      </select>
                      </div>
                    </div>
                    
                    <div class="row formSep">
                      <div class="clearfix"></div>
                      <div class="col-xs-12 col-sm-2" >ประเภทตำแหน่ง : <span style="color:red;">*</span>&nbsp;</div>
                      <div class="col-xs-12 col-sm-3">
                      <?php echo GetHtmlSelect("TYPE_ID", "TYPE_ID", $arr_pos_type, "ประเภทตำแหน่ง", $rec_edit['TYPE_ID'], "onChange=\"ChkLevel(this);\"","", "", 200, ""); ?>
                      </div>
                      <div class="col-xs-12 col-sm-1" ></div>
                      <div class="col-xs-12 col-sm-2" >ระดับตำแหน่ง : <span style="color:red;">*</span>&nbsp;</div>
                      <div class="col-xs-12 col-sm-3">
                      <?php echo GetHtmlSelect("LEVEL_ID", "LEVEL_ID", $arr_pos_level, "ระดับตำแหน่ง",$rec_edit['LEVEL_ID'], "","", "", 200, ""); ?>
                      </div>
                    </div>
                    
                    <div class="row formSep">
                      <div class="clearfix"></div>
                      <div class="col-xs-12 col-sm-2" >ค่าความคาดหวัง : <span style="color:red;">*</span>&nbsp;</div>
                      <div class="col-xs-12 col-sm-2">
                     	<input id="COMSET_EXPECT"  name="COMSET_EXPECT" type="text" class="form-control number" placeholder="ค่าความคาดหวัง" value="<?php echo $rec_edit['COMSET_EXPECT']; ?>" >
                      
                      </div>
                    </div>
                    
                   <div class="formlast">
                    <div class="col-xs-12 col-sm-12" align="center">
                        <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                        <button type="button" class="btn btn-default" onClick="self.location.href='competency_main_year_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
                    </div>
                    </div>
                    <div class="clearfix"></div><br \> 
                </form>
            </div>
        </div>
    </div>
    <br \>
    <div style="position:relative; text-align:center;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>