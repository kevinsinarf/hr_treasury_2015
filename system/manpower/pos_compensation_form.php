<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$COMPEN_ID=$_POST['COMPEN_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 

$sql=  " SELECT * FROM SETUP_POS_COMPENSATION WHERE COMPEN_ID ='".$COMPEN_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$COMPEN_ID = text($rec["COMPEN_ID"]);
$COMPEN_CODE = text($rec["COMPEN_CODE"]);
$COMPEN_TITLE = text($rec["COMPEN_TITLE"]);
$LEVEL_ID = text($rec["LEVEL_ID"]);
$LINE_ID = text($rec["LINE_ID"]);
$COMPEN_YEAR = text($rec["COMPEN_YEAR"]);
$COMPEN_MANAGE_STATUS = text($rec["COMPEN_MANAGE_STATUS"]);
$COMPEN_SALARY_POSITION = text($rec["COMPEN_SALARY_POSITION"]);
$COMPEN_COMPENSATION_1 = text($rec["COMPEN_COMPENSATION_1"]);
$COMPEN_COMPENSATION_2 = text($rec["COMPEN_COMPENSATION_2"]);
$COMPEN_FOR	= text($rec["COMPEN_FOR"]);
$ACTIVE_STATUS = ($proc == "add") ? 1:text($rec["ACTIVE_STATUS"]);


$SQL_POS_LINE ="SELECT LINE_ID , LINE_NAME_TH as LINE_NAME  FROM SETUP_POS_LINE WHERE ACTIVE_STATUS='1' ";
$query_POS_LINE = $db->query($SQL_POS_LINE);

$SQL_POS_LEVEL ="SELECT LEVEL_ID , LEVEL_NAME_TH as LEVEL_NAME  FROM SETUP_POS_LEVEL WHERE ACTIVE_STATUS='1' ";
$query_POS_LEVEL = $db->query($SQL_POS_LEVEL);
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
<script src="js/pos_compensation_disp.js?<?php echo rand(); ?>"></script>

</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="pos_compensation_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12">
        <div class="groupdata" >
          <form id="frm-input" method="post" action="process/pos_compensation_process.php">
            <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
            <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        	<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        	<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
            <input name="LEVEL_SALARY_ID" type="hidden" id="LEVEL_SALARY_ID" value="<?php echo $LEVEL_SALARY_ID; ?>">
            <input name="COMPEN_ID" type="hidden" id="COMPEN_ID" value="<?php echo $COMPEN_ID; ?>">
            <input name="flagDup1" type="hidden" id="flagDup1">
            <input name="flagDup2" type="hidden" id="flagDup2">
            <input name="flagDup3" type="hidden" id="flagDup3">
            <div class="row formSep">
                <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['level_pos'];?> :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-sm-3">
					<select name="LEVEL_ID" class="selectbox form-control" id="LEVEL_ID" placeholder="<?php echo $arr_txt['level_pos'];?>">
						<option value=""></option>
								<?php 
									while($recL = $db->db_fetch_array($query_POS_LEVEL)){
										$sel = ($recL["LEVEL_ID"] == $LEVEL_ID) ? "selected":"";
									?>
						<option value="<?php echo $recL["LEVEL_ID"]; ?>" <?php echo $sel; ?>><?php echo text($recL["LEVEL_NAME"]); ?></option>
								<?php
									}
								?>
					</select>
				</div>
                <div class="col-xs-12 col-sm-2 col-sm-offset-1"><?php echo $arr_txt['pos_in'];?> :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-sm-3">
					<select name="LINE_ID" class="selectbox form-control" id="LINE_ID"placeholder="<?php echo $arr_txt['pos_in'];?> ">
						<option value=""></option>
								<?php 
									while($recL = $db->db_fetch_array($query_POS_LINE)){
										$sel = ($recL["LINE_ID"] == $LINE_ID) ? "selected":"";
								?>
						<option value="<?php echo $recL["LINE_ID"]; ?>" <?php echo $sel; ?>><?php echo text($recL["LINE_NAME"]); ?></option>
								<?php
									}
								?>
					</select>
				</div>
            </div>
            <div class="row formSep">
				<div class="col-xs-12 col-sm-2 ">สถานะทางตำแหน่งบริหาร :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-sm-3">
					<select name="COMPEN_MANAGE_STATUS" class="selectbox form-control" id="COMPEN_MANAGE_STATUS"placeholder="สถานะทางตำแหน่งบริหาร ">
						<option value=""></option>
							<?php 
								foreach($arrCompenMan as $key => $val){ 
									$sel = ($key == $COMPEN_MANAGE_STATUS) ? "selected":"";
							?>
						<option value="<?php echo $key; ?>" <?php echo $sel; ?>><?php echo $val; ?></option>
							<?php } ?>
					</select>
				</div>
				<div class="col-xs-12 col-sm-2 col-sm-offset-1">จำนวนปีที่ดำรงตำแหน่ง :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-sm-3 col-md-2">
                                    <span id="chkDup1" class="col-xs-9 visible-xs label"></span>  
						<input name="COMPEN_YEAR" type="text" id="COMPEN_YEAR" placeholder="จำนวนปีที่ดำรงตำแหน่ง " class="form-control number" value="<?php echo $COMPEN_YEAR; ?>" maxlength="2" onkeyup="chkDup('chkDup1','flagDup1','COMPEN_YEAR','COMPEN_ID','SETUP_POS_COMPENSATION','LEVEL_ID='+$('#LEVEL_ID').val()+'&LINE_ID='+$('#LINE_ID').val());">
				</div>
                                <span id="chkDup1" class="col-sm-2 hidden-xs label"></span>
			</div>
			<div class="row formSep">
				<div class="col-xs-12 col-sm-2">รหัสค่าตอบแทนอื่นๆ :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-sm-2">
                                    <span id="chkDup2" class="col-xs-9 visible-xs label"></span> 
				<input name="COMPEN_CODE" type="text" id="COMPEN_CODE" placeholder="รหัสค่าตอบแทนอื่นๆ " class="form-control number" value="<?php echo $COMPEN_CODE; ?>" maxlength="3" onkeyup="chkDup('chkDup2','flagDup2','COMPEN_CODE','COMPEN_ID','SETUP_POS_COMPENSATION','LEVEL_ID='+$('#LEVEL_ID').val()+'&LINE_ID='+$('#LINE_ID').val());">
				</div>
                                <span id="chkDup2" class="col-sm-2 hidden-xs label"></span>
                        </div>
            <div class="row formSep">
				<div class="col-xs-12 col-sm-2 ">หัวข้อค่าตอบแทน :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-sm-3">
                                    <span id="chkDup3" class="col-xs-9 visible-xs label"></span> 
						<input name="COMPEN_TITLE" type="text" id="COMPEN_TITLE" placeholder="หัวข้อค่าตอบแทน " class="form-control" value="<?php echo $COMPEN_TITLE; ?>" onkeyup="chkDup('chkDup3','flagDup3','COMPEN_TITLE','COMPEN_ID','SETUP_POS_COMPENSATION','LEVEL_ID='+$('#LEVEL_ID').val()+'&LINE_ID='+$('#LINE_ID').val());">
				</div>
                                <span id="chkDup3" class="col-sm-2 hidden-xs label"></span>
            </div>
			<div class="row formSep">
				<div class="col-xs-12 col-sm-2">เงินประจำตำแหน่ง :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-sm-3">
						<input name="COMPEN_SALARY_POSITION" type="text" id="COMPEN_SALARY_POSITION" placeholder="เงินประจำตำแหน่ง " class="form-control number" value="<?php echo $COMPEN_SALARY_POSITION; ?>">
				</div>
			</div>
			<div class="row formSep">
				<div class="col-xs-12 col-sm-2">เงินค่าตอบแทน :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-sm-3">
						<input name="COMPEN_COMPENSATION_1" type="text" id="COMPEN_COMPENSATION_1" placeholder="เงินค่าตอบแทน " class="form-control number" value="<?php echo $COMPEN_COMPENSATION_1; ?>">
				</div>
				<div class="col-xs-12 col-sm-2 col-sm-offset-1">เงินค่าตอบแทนพิเศษ :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-sm-3">
						<input name="COMPEN_COMPENSATION_2" type="text" id="COMPEN_COMPENSATION_2" placeholder="เงินค่าตอบแทนพิเศษ " class="form-control number" value="<?php echo $COMPEN_COMPENSATION_2; ?>">
				</div>
            </div>
			<div class="row formSep">
				<div class="col-xs-12 col-sm-2">สำหรับ :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-sm-3">
					<select name="COMPEN_FOR" class="selectbox form-control" id="COMPEN_FOR"placeholder="สำหรับ ">
						<option value=""></option>
								<?php 
									foreach($arrCompenFor as $key => $val){ 
										$sel = ($key == $COMPEN_FOR) ? "selected":"";
								?>
						<option value="<?php echo $key; ?>" <?php echo $sel; ?>><?php echo $val; ?></option>
								<?php } ?>
					</select>
				</div>
			</div>
			<div class="row formSep">
				<div class="col-xs-4 col-md-2"><?php echo $arr_txt['active'];?>&nbsp;<span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-8 col-md-4">
					<label><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS" value="1" <?php echo ($ACTIVE_STATUS=='1'?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>&nbsp;&nbsp;
					<label><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($ACTIVE_STATUS=='0'?"checked":"")?>> <?php echo $arr_act_status['0'];?></label>
				</div> 
			</div>				
            <div class="formlast">
            <div class="col-xs-12 col-sm-12" align="center">
					<button type="button" class="btn btn-primary" onClick="	chkinput();">บันทึก</button>
					<button type="button" class="btn btn-default" onClick="self.location.href='pos_compensation_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
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