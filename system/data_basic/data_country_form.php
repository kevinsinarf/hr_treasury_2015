<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POST
$COUNTRY_ID=$_POST['COUNTRY_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 

//DATA
$sql = "select * from SETUP_COUNTRY where COUNTRY_ID = '".$COUNTRY_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

//$rec = @array_change_key_case($rec,CASE_LOWER);

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
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/data_country.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="data_country.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content">
        <div class="groupdata" >
			<!--<div class="row heading"><?php echo $txt;?></div>-->
            <form id="frm-input" method="post" action="process/data_country_process.php">
            	<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
            	<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="COUNTRY_ID" name="COUNTRY_ID" value="<?php echo $COUNTRY_ID; ?>">
                <input type="hidden" id="flagDup1" name="flagDup1">
                <input type="hidden" id="flagDup2" name="flagDup2">
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					<?php echo $arr_data['country_name'];?> (<?php echo $arr_txt['th'];?>)&nbsp;<span style="color:red;">*</span>&nbsp;</div>
					<div class="col-xs-12 col-md-3">
                    <input type="text" id="COUNTRY_NAME_TH" name="COUNTRY_NAME_TH" class="form-control" placeholder="<?php echo $arr_data['country_name'];?> (<?php echo $arr_txt['th'];?>)" value="<?php echo text($rec["COUNTRY_NAME_TH"]); ?>" maxlength="100" onKeyUp="chkDup('chkDup1','flagDup1','COUNTRY_NAME_TH','COUNTRY_ID','SETUP_COUNTRY','');">
                    </div> 
                    <span id="chkDup1" class="col-sm-2 hidden-xs label"></span>
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					<?php echo $arr_data['country_name'];?> (<?php echo $arr_txt['en'];?>)&nbsp;<span style="color:red;">*</span>&nbsp;</div> 
					<div class="col-xs-12 col-md-3"><input type="text" id="COUNTRY_NAME_EN" name="COUNTRY_NAME_EN" class="form-control" placeholder="<?php echo $arr_data['country_name'];?> (<?php echo $arr_txt['en'];?>)" value="<?php echo text($rec["COUNTRY_NAME_EN"]); ?>" maxlength="100" onKeyUp="chkDup('chkDup2','flagDup2','COUNTRY_NAME_EN','COUNTRY_ID','SETUP_COUNTRY','');"></div> 
                    <span id="chkDup2" class="col-sm-2 hidden-xs label"></span>
				</div>
                
                <div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap"><?php echo $arr_txt['active'];?>&nbsp;<span style="color:red;">*</span>&nbsp;</div>
					<div class="col-xs-4 col-md-1">
						<label ><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$data['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>
					</div>
					<div class="col-xs-4 col-md-1">
						<label ><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?></label></div>
				</div>
                                
                <div class="formlast">
					<div class="col-xs-12 col-sm-12" align="center">
						<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
						<button type="button" class="btn btn-default" onClick="self.location.href='data_country.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
					</div>
                </div>                               
			</form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>
<!-- Modal -->
<div class="modal fade" id="myModal"></div>
<!-- /.modal -->