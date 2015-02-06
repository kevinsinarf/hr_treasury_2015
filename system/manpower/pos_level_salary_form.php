<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$LEVEL_SALARY_ID=$_POST['LEVEL_SALARY_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 


$sql=  " SELECT * FROM SETUP_POS_LEVEL_SALARY WHERE LEVEL_SALARY_ID ='".$LEVEL_SALARY_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$LEVEL_SALARY_ID = text($rec["LEVEL_SALARY_ID"]);
$LEVEL_ID = text($rec["LEVEL_ID"]);
$LEVEL_SALARY_CODE = text($rec["LEVEL_SALARY_CODE"]);
$LEVEL_SALARY_NAME_TH = text($rec["LEVEL_SALARY_NAME_TH"]);
$LEVEL_SALARY_NAME_EN = text($rec["LEVEL_SALARY_NAME_EN"]);
$LEVEL_SALARY_MIN = number_format($rec["LEVEL_SALARY_MIN"],2);
$LEVEL_SALARY_MID = number_format($rec["LEVEL_SALARY_MID"],2);
$LEVEL_SALARY_MAX = number_format($rec["LEVEL_SALARY_MAX"],2);
$ACTIVE_STATUS = ($proc == "add") ? 1:text($rec["ACTIVE_STATUS"]);

$arr_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '1' ","TYPE_NAME_TH");

$arr_lv=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "TYPE_ID = ' ".$rec['TYPE_ID']." ' and ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '1'", "LEVEL_NAME_TH");

$arr_salary=GetSqlSelectArray("SALARYTITLE_ID", "SALARYTITLE_NAME_TH", "SETUP_POS_SALARY_TITLE", "DELETE_FLAG='0'", "SALARYTITLE_NAME_TH");

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
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/pos_level_salary_disp.js?<?php echo rand(); ?>"></script>

</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="pos_level_salary_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12">
        <div class="groupdata" >
          <form id="frm-input" method="post" action="process/pos_level_salary_process.php">
            <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
            <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        	<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        	<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
            <input name="LEVEL_SALARY_ID" type="hidden" id="LEVEL_SALARY_ID" value="<?php echo $LEVEL_SALARY_ID; ?>">
            <input name="flagDup1" type="hidden" id="flagDup1">
            <input name="flagDup2" type="hidden" id="flagDup2">
            <input name="flagDup3" type="hidden" id="flagDup3">
            
			<div class="row formSep">
            <div class="col-xs-12 col-md-2"><?php echo $arr_txt['type_pos'];?> :<span style="color:red;">*</span></div>
			<div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('TYPE_ID','TYPE_ID',$arr_type,$arr_txt['type_pos'],$rec['TYPE_ID'],'onchange="getLevel(this,this.value,\'LEVEL_ID\')" ','','1');?>
            </div></div>
            
        	<div class="row formSep">
			<div class="col-xs-12 col-md-2"><?php echo $arr_txt['level_pos'];?> :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
			<div class="col-xs-12 col-md-3"><span id='s_level'>
			<?php echo GetHtmlSelect('LEVEL_ID','LEVEL_ID',$arr_lv,$arr_txt['level_pos'],$rec['LEVEL_ID'],'','','1');?></span>
            </div></div>
            
            <div class="row formSep">
			<div class="col-xs-12 col-md-2">ขั้นเงินเดือน :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
			<div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('SALARYTITLE_ID','SALARYTITLE_ID',$arr_salary,'ขั้นเงินเดือน',$rec['SALARYTITLE_ID'],'','','1');?>
            </div></div>
            
			<div class="row formSep">
				<div class="col-xs-12 col-sm-2">ขั้นต่ำ :&nbsp;<span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-2">
						<input id="LEVEL_SALARY_MIN" name="LEVEL_SALARY_MIN" type="text" class="form-control" placeholder="ขั้นต่ำ" style="text-align:right" value="<?php echo $LEVEL_SALARY_MIN; ?>" onBlur="NumberFormat(this,2);" maxlength="10">
				</div>
				<div class="col-xs-12 col-sm-2">จุดกึ่งกลาง : <span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-2">
						<input id="LEVEL_SALARY_MID" name="LEVEL_SALARY_MID" type="text" class="form-control" placeholder="จุดกึ่งกลาง" style="text-align:right" value="<?php echo $LEVEL_SALARY_MID; ?>" onBlur="NumberFormat(this,2);" maxlength="10">
				</div>
                <div class="col-xs-12 col-sm-2">ขั้นสูง :&nbsp;<span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-2">
				<input id="LEVEL_SALARY_MAX" name="LEVEL_SALARY_MAX" type="text" class="form-control" placeholder="ขั้นสูง" style="text-align:right" value="<?php echo $LEVEL_SALARY_MAX; ?>" onBlur="NumberFormat(this,2);" maxlength="10">
				</div>

				
			</div>
			<div class="row formSep">
				<div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['active'];?>&nbsp;<span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-6 col-md-1">
					<label >
						<input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$rec['ACTIVE_STATUS']=='' ?"checked":"")?>>
							<?php echo $arr_act_status['1'];?>
					</label>
				</div>
				<div class="col-xs-6 col-md-1">
					<label>
						<input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?>>
							<?php echo $arr_act_status['0'];?>
					</label>
				</div>
			</div>
            <div class="formlast">
				<div class="col-xs-12 col-sm-12" align="center">
					<button type="button" class="btn btn-primary" onClick="	chkinput();">บันทึก</button>
					<button type="button" class="btn btn-default" onClick="self.location.href='pos_level_salary_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
				</div>
			</div>
          </form>
        </div>
      </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>