<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT= 1;
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
$paramlink = url2code($link2);
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
<script src="js/profile_his_trans_rule_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php"); ?></div>
  <div><?php include($path."include/menu.php"); ?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
      <li><a href="profile_his_trans_rule_disp.php?<?php echo $paramlink; ?>"><?php echo Showmenu($menu_sub_id);?> (ข้อมูลงานวินัย)</a></li>
      <li class="active">รายละเอียด</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
  		<?php include("tab_transfer.php");?>
        <div class="grouptab">
		<form id="frm-input" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PENALTY_ID" name="PENALTY_ID" value="<?php echo $PENALTY_ID;?>">
		<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        
        <div class="panel-group" id="accordion">
			<?php 
			include("../rule/rule_form_data.php");
            include("../rule/rule_board_data.php");
			if($rec_main['PENALTY_STATUS'] >= 3){
				include("../rule/rule_pause_data.php");
			}
			if($rec_main['PENALTY_STATUS'] >= 5){
            	include("../rule/rule_result_data.php");
			}
			if($rec_main['PENALTY_STATUS'] >= 6){
				include("../rule/rule_final_data.php");
			}
			if($rec_main['PENALTY_STATUS'] >= 7){
				include("../rule/rule_resend_data.php");
			}
			if($rec_main['PENALTY_STATUS'] >= 8){
				include("../rule/rule_kr_data.php");
			}
			if($rec_main['PENALTY_STATUS'] >= 9){
				include("../rule/rule_cancel_data.php");
			}
			?> 
        </div>
        
        <div class="formlast">
            <div class="col-xs-12 col-sm-12" align="center">
                <button type="button" class="btn btn-primary" onClick="chkinput();">โอนข้อมูลเข้าทะเบียนประวัติ</button>
                <button type="button" class="btn btn-default" onClick="self.location.href='profile_his_trans_rule_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PER_ID=".$PER_ID);?>';">ยกเลิก</button>
            </div>
        </div>
      </form>
        </div>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>