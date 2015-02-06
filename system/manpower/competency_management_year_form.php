<?php
session_start();
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล";

$COMSET_ID = $_POST['COMSET_ID'];

$sql = "SELECT * FROM COMPETENCY_SET  where DELETE_FLAG = '0' AND COMSET_ID = '".$COMSET_ID."'";
$query = $db->query($sql);
$data = $db->db_fetch_array($query);

//หัวข้อสรรถนะ
$arr_compet=GetSqlSelectArray("COMTITLE_ID", "COMTITLE_NAME_TH", "COMPETENCY_TITLE", "ACTIVE_STATUS='1' and COMTITLE_TYPE='3'", "COMTITLE_NAME_TH");
//ตำแหน่งในการบริหาร
$arr_manage=GetSqlSelectArray("MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  ", "MANAGE_ID");

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
<script src="js/competency_management_year.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
    <div><?php include($path."include/menu.php"); ?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="competency_management_year_disp.php?<?php echo $paramlink; ?>">สมรรถนะในการบริหารประจำปี</a></li>
          <li class="active"><?php echo $txt; ?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content">
        <div class="groupdata" >
            <form id="frm-input" method="post" action="process/competency_management_year_process.php">
                <input name="proc" type="hidden" id="proc" value="<?php echo $proc; ?>">
                <input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
                <input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
                <input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
                <input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
                <input name="COMSET_ID" type="hidden" id="COMSET_ID" value="<?php echo $COMSET_ID; ?>">
                <input name="flagDup2" type="hidden" id="flagDup2" >
                
                <div class="row formSep">
                  <div class="col-xs-12 col-sm-3" >ปีที่ใช้สมรรถนะ : <span style="color:red;">*</span>&nbsp;</div>
                  <div class="col-xs-12 col-sm-3">
                  <select id="COMSET_YEAR" style="width:300px;" name="COMSET_YEAR" class="selectbox form-control" placeholder="ปีที่ใช้สมรรถนะ" onChange="Chkrepeat();">
                    <option value=""></option>
                    <?php for($Y=($YEAR_PRESENT-10);$Y<=($YEAR_PRESENT+2);$Y++){//select ปี
                              $A_CONFIG_YEAR[$Y] = $Y; ?>
                        <option value="<?php echo $Y; ?>"<?php echo ($Y == $data['COMSET_YEAR'] ? "selected" : ""); ?>><?php echo $Y; ?></option>
                    <?php } ?>
                	</select>
                  	</div>
                </div>
                
                <div class="row formSep">
                  <div class="col-xs-12 col-sm-3">ชื่อหัวข้อสมรรถนะในการบริหาร : <span style="color:red;">*</span>&nbsp;</div>
                  <div class="col-xs-12 col-sm-3">
                  <?php  echo GetHtmlSelect('COMTITLE_ID','COMTITLE_ID',$arr_compet,'ชื่อหัวข้อสมรรถนะในการบริหาร',$data['COMTITLE_ID'],'onChange=\'Chkrepeat();\' ','','1');?>
                  </div> 
                  <span id="chkDup2" class="col-sm-3 hidden-xs label"></span>
                </div>
               
                
                <div class="row formSep">

                  <div class="col-xs-12 col-sm-3" >ค่าความคาดหวัง : <span style="color:red;">*</span>&nbsp;</div>
                  <div class="col-xs-12 col-sm-3"><input id="COMSET_EXPECT" style="width:300px;" name="COMSET_EXPECT" type="text" class="form-control number" placeholder="ค่าความคาดหวัง" value="<?php echo text($data['COMSET_EXPECT']); ?>" ></div>
                  <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งในการบริหาร : <span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-sm-3">
                      <?php  echo GetHtmlSelect('MANAGE_ID','MANAGE_ID',$arr_manage,'ตำแหน่งในการบริหาร',$data['MANAGE_ID'],'','','1');?>
                 </div> 
                  
                </div>
                
               <div class="formlast">
                <div class="col-xs-12 col-sm-12" align="center">
                    <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                    <button type="button" class="btn btn-default" onClick="self.location.href='competency_management_year_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
                </div>
                </div>
            </form>
        </div>
    </div>
    <br \>
    <div style="position:relative; text-align:center;"><?php include($path."include/footer.php"); ?></div>
</div>

</body>
</html>