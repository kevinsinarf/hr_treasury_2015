<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$link2="menu_id=".$menu_id."&PER_ID=".$PER_ID."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&ACT=".$ACT;
$paramlink = url2code($link);

//POST
$PER_ID = $_POST['PER_ID'];
$PUN_ID=$_POST['PUN_ID'];
$ACT = $_POST['ACT'];
$txt = "บันทึกข้อมูล";

//DATA โทษทางวินัย
$arr_punnish = array();
$sql = "SELECT * FROM SETUP_PUNNISH WHERE ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' ORDER BY PUNISH_SEQ ASC";
$query = $db->query($sql);
while($rec = $db->db_fetch_array($query)){
	$rec = convert_text($rec);
	$arr_punnish[$rec['PUNISH_ID']] = $rec['PUNISH_NAME_TH'];
}
$arr_command_type = GetSqlSelectArray("CT_ID", "CT_NAME_TH", "SETUP_COMMAND_TYPE", "CT_TYPE = '1' AND ACTIVE_STATUS = '1' and DELETE_FLAG = '0' ", "CT_NAME_TH");

$sql_penal = "SELECT PENALTY_STATUS  FROM PER_PUNISHMENT WHERE PER_ID = '".$PER_ID."'";
$query_penal = $db->query($sql_penal);
$rec_penal = $db->db_fetch_array($query_penal);
$arr_con = array( '1' => 'ดำเนินการสั่งลงโทษ' , '2'=> 'ดำเนินการสั่งงดโทษ' , '3' => 'ดำเนินการสั่งยุติเรื่อง');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
<link href="<?php echo $path;?>html_editer/sample.css" rel="stylesheet" type="text/css" />
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
<script src="../../bootstrap/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/chosen.jquery.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script type="text/javascript" src="<?php echo $path;?>html_editer/ckeditor.js"></script>
<script src="js/profile_punishment_detail.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li><a href="profile_his_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
            <li><a href="profile_punishment_disp.php?<?php echo url2code($link2); ?>">ประวัติการรับโทษทางวินัย</a></li>
            <!--<li><a href="<?php echo "profile_punishment_disp.php?".url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>">ประวัติการรับโทษทางวินัย</a></li>-->
			<li class="active"><?php echo "รายละเอียด";?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content">
        <div class="groupdata" >
            <form id="frm-input" method="post" action="process/set_penalty_form_process.php">
            	<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
            	<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PUN_ID" name="PUN_ID" value="<?php echo $PUN_ID; ?>">
                <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID; ?>">
                <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT; ?>">
                
                <div class="panel-group" id="accordion">
				<?php include("profile_form_data.php");?>
                <?php if($rec_penal['PENALTY_STATUS']>=2){ include("profile_board_data.php"); }?>
                <?php if($rec_penal['PENALTY_STATUS']>=3){include("profile_pause_data.php"); }?>
                <?php if($rec_penal['PENALTY_STATUS']>=5){ include("profile_result_data.php"); }?>
                <?php if($rec_penal['PENALTY_STATUS']>=6){ include("profile_final_data.php"); }?>
                <?php if($rec_penal['PENALTY_STATUS']>=7){include("profile_examine_kr_data.php"); }?>
                 <?php if($rec_penal['PENALTY_STATUS']>=8){include("profile_kr2_data.php"); }?>
                <?php if($rec_penal['PENALTY_STATUS']>=9){ include("profile_cancel_data.php"); }?>

                <div class="formlast">
					<div class="col-xs-12 col-sm-12" align="center">
						<button type="button" class="btn btn-default" onClick="getBack(<?php echo $PER_ID; ?>,<?php echo $ACT; ?>);" >ยกเลิก</button>
					</div>
                </div>                               
			</form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>