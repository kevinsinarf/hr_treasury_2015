<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$MT_ID =  $_POST['MT_ID'];
$proc = ($proc == '' ) ? "add" : $proc;
$txt = ($proc == "add") ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล";

$sql=  " SELECT MT_ID, MT_TYPE,  MT_NAME_TH, MT_NAME_EN, MT_SHORTNAME_TH, MT_SHORTNAME_EN, ACTIVE_STATUS, MT_SEQ FROM SETUP_POS_MANAGE_TYPE  WHERE  MT_ID ='".$MT_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$arr_type = array(1=> 'เป็นตำแหน่งผู้บริหาร', 2 => 'เป็นตำแหน่งพิเศษ', 3 => 'เป็นตำแหน่งปกติ');
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
<script src="js/pos_manage_type_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="pos_manage_type_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content">
        <div class="groupdata" >
		<form id="frm-input" method="post" action="process/pos_manage_type_process.php">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="MT_ID" name="MT_ID" value="<?php echo $MT_ID; ?>">
        <input name="flagDup1" type="hidden" id="flagDup1">
        <input name="flagDup2" type="hidden" id="flagDup2">
        <div class="row formSep">
            <div class="col-xs-12 col-sm-3" style="white-space:nowrap">ลำดับในการจัดเรียง : <span style="color:red;">*</span> </div>
            <div class="col-xs-12 col-sm-2"><input type="text" id="MT_SEQ" name="MT_SEQ" maxlength="100" class="form-control number" placeholder="ลำดับในการจัดเรียง" value="<?php echo text($rec["MT_SEQ"]); ?>"  style="width:100px;"></div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-3">สถานะของตำแหน่งบริหาร&nbsp;: <span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-3">
                 <?php  echo GetHtmlSelect('MT_TYPE','MT_TYPE',$arr_type,'สถานะของตำแหน่งบริหาร',$rec['MT_TYPE'],'','','1','200','2');?>
           		
         	</div>
        </div>
        
		<div class="row formSep">
			<div class="col-xs-12 col-sm-3" style="white-space:nowrap">ชื่อประเภทตำแหน่งทางการบริหาร (ไทย) :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-sm-2">
			<input type="text" id="MT_NAME_TH" name="MT_NAME_TH" maxlength="100" class="form-control" placeholder="ชื่อประเภทตำแหน่งทางการบริหารภาษาไทย" value="<?php echo text($rec["MT_NAME_TH"]); ?>" onKeyUp="chkDup('chkDup1','flagDup1','MT_NAME_TH','MT_ID','SETUP_POS_MANAGE_TYPE','');" >
			</div>
            <div class="col-xs-12 col-sm-1"><span id="chkDup1" class="hidden-xs label"></span></div>
            <div class="col-xs-12 col-sm-3 " style="white-space:nowrap">ชื่อย่อประเภทตำแหน่งทางการบริหาร (ไทย) :</div>
             <div class="col-xs-12 col-sm-2">
			 <input type="text" id="MT_SHORTNAME_TH" name="MT_SHORTNAME_TH" maxlength="100" class="form-control" placeholder="ชื่อย่อประเภทตำแหน่งทางการบริหารภาษาไทย" value="<?php echo text($rec["MT_SHORTNAME_TH"]); ?>" >
			</div>
		</div>
        
        <div class="row formSep">
			<div class="col-xs-12 col-sm-3" style="white-space:nowrap">ชื่อประเภทตำแหน่งทางการบริหาร (อังกฤษ) :</div>
			<div class="col-xs-12 col-sm-2">
			  <input type="text" id="MT_NAME_EN" name="MT_NAME_EN" maxlength="100" class="form-control" placeholder="ชื่อประเภทตำแหน่งทางการบริหารภาษาอังกฤษ" value="<?php echo text($rec["MT_NAME_EN"]); ?>" onKeyUp="chkDup('chkDup2','flagDup2','MT_NAME_EN','MT_ID','SETUP_POS_MANAGE_TYPE','');">
			</div>
            <div class="col-xs-12 col-sm-1">
             <span id="chkDup2" class="hidden-xs label"></span>
            </div>
            <div class="col-xs-12 col-sm-3" style="white-space:nowrap">ชื่อย่อประเภทตำแหน่งทางการบริหาร (อังกฤษ) :</div>
			<div class="col-xs-12 col-sm-1">
             <span id="chkDup2" class="col-xs-9 visible-xs label"></span>
			  <input type="text" id="MT_SHORTNAME_EN" name="MT_SHORTNAME_EN" maxlength="100" class="form-control" placeholder="ชื่อย่อประเภทตำแหน่งทางการบริหารภาษาอังกฤษ" value="<?php echo text($rec["MT_SHORTNAME_EN"]); ?>" >
			</div>
		</div>
        
        <div class="row formSep">
			<div class="col-xs-12 col-sm-3" style="white-space:nowrap"><?php echo $arr_txt['active'];?>&nbsp;: <span style="color:red;">*</span>&nbsp;</div>
			<div class="col-xs-4 col-md-1">
				<label >
					<input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$rec['ACTIVE_STATUS']=='' ?"checked":"")?>>
					<?php echo $arr_act_status['1'];?>
				</label>
			</div>
			<div class="col-xs-4 col-md-1">
				<label >
					<input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?>>
					<?php echo $arr_act_status['0'];?>
				</label>
			</div>
        </div>
        <div class="formlast">
			<div class="col-xs-12 col-sm-12" align="center">
			  <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
			  <button type="button" class="btn btn-default" onClick="self.location.href='pos_manage_type_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button></button>
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
</body>
</html>
<!-- Modal -->
<div class="modal fade" id="myModal"></div>
<!-- /.modal -->