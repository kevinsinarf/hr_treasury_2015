<?php
session_start();
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล";

$sql = "SELECT * FROM COMPETENCY_SET  where DELETE_FLAG = '0' AND COMSET_ID = '".$COMSET_ID."'";
$query = $db->query($sql);
$data = $db->db_fetch_array($query);

//หัวข้อสรรถนะ
$arr_compet=GetSqlSelectArray("COMTITLE_ID", "COMTITLE_NAME_TH", "COMPETENCY_TITLE", "ACTIVE_STATUS='1' and COMTITLE_TYPE='2'", "COMTITLE_NAME_TH");
//ประเภทตำแหน่ง
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "TYPE_NAME_TH");
//ระดับตำแหน่ง/กลุ่มงาน
$arr_pos_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LEVEL_NAME_TH");
//สายงาน
$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LINE_NAME_TH");

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
<script src="js/competency_line_year.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
    <div><?php include($path."include/menu.php"); ?></div>
        <div class="col-xs-12 col-sm-12">
            <ol class="breadcrumb">
              <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
              <li><a href="competency_line_year_disp.php?<?php echo $paramlink; ?>">สมรรถนะสายงานประจำปี</a></li>
              <li class="active"><?php echo $txt; ?></li>
            </ol>
        </div>
        <div class="col-xs-12 col-sm-12" id="content">
            <div class="groupdata" >
                
                <form id="frm-input" method="post" action="process/competency_line_year_process.php">
                    <input name="proc" type="hidden" id="proc" value="<?php echo $proc; ?>">
                    <input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
                    <input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
                    <input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
                    <input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
                    <input name="COMSET_ID" type="hidden" id="COMSET_ID" value="<?php echo $COMSET_ID; ?>">
                    <input name="flagDup2" type="hidden" id="flagDup2" >
                    
                    <div class="row formSep">
                      <div class="col-xs-12 col-sm-2" >ปีที่ใช้สมรรถนะ : <span style="color:red;">*</span>&nbsp;</div>
                      <div class="col-xs-12 col-sm-3">
                      <select id="COMSET_YEAR"  name="COMSET_YEAR" onChange="Chkrepeat();" style="width:300px;"  class="selectbox form-control" placeholder="ปีที่ใช้สมรรถนะ" >
                        <option value=""></option>
                        <?php for($Y=($YEAR_PRESENT-10);$Y<=($YEAR_PRESENT+2);$Y++){//select ปี
                                  $A_CONFIG_YEAR[$Y] = $Y; ?>
                            <option value="<?php echo $Y; ?>"<?php echo ($Y == $data['COMSET_YEAR'] ? "selected" : ""); ?>><?php echo $Y; ?></option>
                        <?php } ?>
                    </select>
                      </div>
                    </div>
                    
                    <div class="row formSep">
                      <div class="clearfix"></div>
                      <div class="col-xs-12 col-sm-2" >ชื่อหัวข้อสมรรถนะสายงาน : <span style="color:red;">*</span>&nbsp;</div>
                      <div class="col-xs-12 col-sm-3">
                      <?php  echo GetHtmlSelect('COMTITLE_ID','COMTITLE_ID',$arr_compet,'ชื่อหัวข้อสมรรถนะสายงาน',$data['COMTITLE_ID'],'onChange=\'Chkrepeat();\' ','','1'); ?>
                      </div>
                      <span id="chkDup2" class="col-sm-3 hidden-xs label"></span>
                      </div>
                      
                      <div class="row formSep">
                      <div class="col-xs-12 col-sm-2" >ค่าความคาดหวัง : <span style="color:red;">*</span>&nbsp;</div>
                      <div class="col-xs-12 col-sm-3">
                     	<input style=" width:300px;" id="COMSET_EXPECT" name="COMSET_EXPECT" type="text" class="form-control number" placeholder="ค่าความคาดหวัง" value="<?php echo $data['COMSET_EXPECT']; ?>" >
                      </div>
                      <div class="col-xs-12 col-sm-1"></div>
                      <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทตำแหน่ง : <span style="color:red;">*</span></div>
                      <div class="col-xs-12 col-sm-3">
                        <?php  echo GetHtmlSelect('TYPE_ID','TYPE_ID',$arr_pos_type,'ประเภทตำแหน่ง',$data['TYPE_ID'],'','','1');?>
                    </div>
                    </div>
                    
                    <div class="row formSep">
                      <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับตำแหน่ง : <span style="color:red;">*</span></div>
                      <div class="col-xs-12 col-sm-3">
                      <?php  echo GetHtmlSelect('LEVEL_ID','LEVEL_ID',$arr_pos_level,'ระดับตำแหน่ง',$data['LEVEL_ID'],'','','1');?>
                      </div> 
                      <div class="col-xs-12 col-sm-1"></div>
                      <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งในสายงาน : <span style="color:red;">*</span></div>
                      <div class="col-xs-12 col-sm-3">
                          <?php  
                          echo GetHtmlSelect('LINE_ID','LINE_ID',$arr_pos_line,'ตำแหน่งในสายงาน',$data['LINE_ID'],'','','1');?>
                      </div>  
                    </div>
                   
                   <div class="formlast">
                    <div class="col-xs-12 col-sm-12" align="center">
                        <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                        <button type="button" class="btn btn-default" onClick="self.location.href='competency_line_year_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
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