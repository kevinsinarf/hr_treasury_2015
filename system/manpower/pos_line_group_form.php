<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POST
$LEVEL_ID=$_POST['LEVEL_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 

$sql=  " SELECT  * 
FROM SETUP_POS_LINE_GROUP WHERE LG_ID ='".$LG_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$LEVEL_ID = text($rec["LG_ID"]);
$POSTYPE_ID = text($rec["POSTYPE_ID"]);
$TYPE_ID = text($rec["TYPE_ID"]);
$LG_NAME_TH = text($rec["LG_NAME_TH"]);
$LG_NAME_EN = text($rec["LG_NAME_EN"]);
$LG_SHORTNAME_TH = text($rec["LG_SHORTNAME_TH"]);
$LG_SHORTNAME_EN = text($rec["LG_SHORTNAME_EN"]);
$ACTIVE_STATUS = ($proc == "add") ? 1:text($rec["ACTIVE_STATUS"]);

$SQL_POS_TYPE ="SELECT TYPE_ID, TYPE_NAME_TH FROM SETUP_POS_TYPE WHERE POSTYPE_ID = '1' AND DELETE_FLAG = '0' ORDER BY TYPE_SEQ ASC ";
$query_POS_TYPE = $db->query($SQL_POS_TYPE);
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
<script src="js/pos_line_group_disp.js?<?php echo rand(); ?>"></script>

</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="pos_line_group_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content">
        <div class="groupdata" >
		<form id="frm-input" method="post" action="process/pos_line_group_process.php">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input name="LG_ID" type="hidden" id="LG_ID" value="<?php echo $LG_ID; ?>">
        <input name="flagDup1" type="hidden" id="flagDup1">
        <input name="flagDup2" type="hidden" id="flagDup2">
        <input name="flagDup3" type="hidden" id="flagDup3">
        <input name="flagDup4" type="hidden" id="flagDup4">
        <input name="flagDup5" type="hidden" id="flagDup5">
		<div class="row formSep">
            <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['type_pos'];?> :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-sm-3">
                <select id="TYPE_ID" name="TYPE_ID" class="selectbox form-control" placeholder="<?php echo $arr_txt['type_pos'];?>" style="width:200px;">
                    <option value=""></option>
                    <?php
                    while($rec2 = $db->db_fetch_array($query_POS_TYPE)){
                        ?>
                        <option value="<?php echo $rec2['TYPE_ID']?>" <?php echo ($TYPE_ID== $rec2['TYPE_ID']?"selected":"");?>><?php echo text($rec2['TYPE_NAME_TH'])?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">ชื่อสายงานภาษาไทย :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-sm-2"><input id="LG_NAME_TH" type="text" name="LG_NAME_TH" class="form-control" maxlength="100" placeholder="ชื่อสายงานภาษาไทย" value="<?php echo  $LG_NAME_TH; ?>" onKeyUp="chkDup('chkDup1','flagDup1','LG_NAME_TH','LG_ID','SETUP_POS_LINE_GROUP','');"></div>
            <div class="col-xs-12 col-sm-2"><span id="chkDup1" class="hidden-xs label"></span></div>
            <div class="col-md-2 col-sm-2">ชื่อย่อสายงานภาษาไทย :</div>
			<div class="col-md-2 col-sm-2">
                <span id="chkDup4" class="visible-xs label"></span>
                <input id="LG_SHORTNAME_TH" type="text" name="LG_SHORTNAME_TH" class="form-control" placeholder="ชื่อย่อระดับภาษาไทย" value="<?php echo  $LG_SHORTNAME_TH ; ?>" maxlength="10" onKeyUp="chkDup('chkDup4','flagDup4','LG_SHORTNAME_TH','LG_ID','SETUP_POS_LINE_GROUP','TYPE_ID='+$('#TYPE_ID').val());">
            </div>
            <div class="col-xs-12 col-sm-2"><span id="chkDup4" class="hidden-xs label"></span></div>
        </div>
            
        <div class="row formSep">      
            <div class="col-xs-12 col-sm-2">ชื่อสายงานภาษาอังกฤษ :</div>
            <div class="col-xs-12 col-sm-2"><input id="LG_NAME_EN" type="text" name="LG_NAME_EN" class="form-control" maxlength="100" placeholder="ชื่อสายงานภาษาอังกฤษ" value="<?php echo  $LG_NAME_EN ; ?>" onKeyUp="chkDup('chkDup2','flagDup2','LG_NAME_EN','LG_ID','SETUP_POS_LINE_GROUP','');"></div> 
            <div class="col-xs-12 col-sm-2"><span id="chkDup2" class=" hidden-xs label"></span></div>
            <div class="col-xs-12 col-sm-2">ชื่อย่อสายงานภาษาอังกฤษ :</div>
			<div class="col-xs-12 col-sm-2"><input id="LG_SHORTNAME_EN" type="text" name="LG_SHORTNAME_EN" class="form-control" placeholder="ชื่อย่อสายงานภาษาอังกฤษ" value="<?php echo  $LG_SHORTNAME_EN ; ?>" maxlength="10" onKeyUp="chkDup('chkDup5','flagDup5','LG_SHORTNAME_EN','LG_ID','SETUP_POS_LINE_GROUP','TYPE_ID='+$('#TYPE_ID').val());"></div>
            <div class="col-xs-12 col-sm-2"><span id="chkDup5" class=" hidden-xs label"></span></div> 
        </div>
        
		<div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['active'];?> :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-6 col-md-1"><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$rec['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></div>
            <div class="col-xs-6 col-md-1"><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?>> <?php echo $arr_act_status['0'];?></div>
		</div>
        
		<div class="formlast">
			<div class="col-xs-12 col-sm-12" align="center">
				<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
				<button type="button" class="btn btn-default" onClick="self.location.href='pos_line_group_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
			</div>
		</div>
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>