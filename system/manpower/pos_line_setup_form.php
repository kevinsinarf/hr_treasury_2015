<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;

$page_back = "pos_line_setup_disp.php";

//POST
$LINE_ID=$_POST['LINE_ID'];

$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 

//DATA
$sql = "SELECT * FROM SETUP_POS_LINE WHERE DELETE_FLAG = '0' AND LINE_ID = '".$LINE_ID."'";
$query = $db->query($sql);
$data = $db->db_fetch_array($query);

$arr_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH as TYPE_NAME", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '5' ","TYPE_SEQ");
$arr_line_group =GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '5' AND TYPE_ID = '".$data['TYPE_ID']."' ","LG_NAME_TH");

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
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/pos_line_setup.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
  <div>
    <?php include($path."include/header.php");?>
  </div>
  <div>
    <?php include($path."include/menu.php");?>
  </div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
	   <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" ><br>
	<div class="clearfix"></div>
      <form id="frm-input" method="post" action="process/pos_line_setup_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="LINE_ID" name="LINE_ID"  value="<?php echo $LINE_ID; ?>">
        <input type="hidden" id="flagDup1" name="flagDup1" >
        <input type="hidden" id="flagDup2" name="flagDup2" > 
        <input type="hidden" id="flagDup3" name="flagDup3" >
        <input type="hidden" id="flagDup4" name="flagDup4" >
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2">กลุ่มงาน : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('TYPE_ID','TYPE_ID',$arr_type,'กลุ่มงาน',$data['TYPE_ID'],'onChange ="get_line_group(this);" ','','1');?></div>
            <div class="col-xs-12 col-md-2"></div>
            <div class="col-xs-12 col-md-2">สายงาน : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('LG_ID','LG_ID',$arr_line_group,'สายงาน',$data['LG_ID'],'','','1');?></div>
        </div>
                
		<div class="row formSep">
			<div class="col-xs-12 col-md-2" >ชื่อตำแหน่งในสายงานภาษาไทย : <span style="color:red;">*</span>&nbsp;</div>
			<div class="col-xs-12 col-md-2"><input type="text" id="LINE_NAME_TH" name="LINE_NAME_TH" class="form-control"  placeholder="ชื่อตำแหน่งในสายงานภาษาไทย" maxlength="100" value="<?php echo text($data["LINE_NAME_TH"]); ?>" onKeyUp="Chkrepeat();"></div>
            <span id="chkDup1" class="col-sm-2 hidden-xs label"></span>
            <div class="col-xs-12 col-md-2">ชื่อย่อตำแหน่งในสายงานภาษาไทย : </div>
			<div class="col-xs-12 col-md-2"><input type="text" id="LINE_SHORTNAME_TH" name="LINE_SHORTNAME_TH" class="form-control" placeholder="ชื่อย่อตำแหน่งในสายงานภาษาไทย" maxlength="20" value="<?php echo text($data["LINE_SHORTNAME_TH"]); ?>" ></div>
       	</div> 
               
        <div class="row formSep">   
			<div class="col-xs-12 col-md-2">ชื่อตำแหน่งในสายงานภาษาอังกฤษ : </div>
			<div class="col-xs-12 col-md-2"><input type="text" id="LINE_NAME_EN" name="LINE_NAME_EN" class="form-control" placeholder="ชื่อตำแหน่งในสายงานภาษาอังกฤษ" maxlength="100" value="<?php echo text($data["LINE_NAME_EN"]); ?>" onKeyUp="Chkrepeat();"></div>
            <span id="chkDup3" class="col-sm-2 hidden-xs label"></span>
            <div class="col-xs-12 col-md-2" >ชื่อย่อตำแหน่งในสายงานภาษาอังกฤษ : </div>
			<div class="col-xs-12 col-md-2"><input type="text" id="LINE_SHORTNAME_EN" name="LINE_SHORTNAME_EN" class="form-control" placeholder="ชื่อย่อตำแหน่งในสายงานภาษาอังกฤษ" maxlength="20" value="<?php echo text($data["LINE_SHORTNAME_EN"]); ?>" ></div>
        </div>
                
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap"><?php echo $arr_txt['active'];?> :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-2">
            <label ><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($data['ACTIVE_STATUS']=='1'||$data['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label ><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($data['ACTIVE_STATUS']=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?></label></div>
        </div>
                
		<div class="clearfix"></div><br>
        <div class="col-xs-12 col-sm-12" align="center">
          <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
          <button type="button" class="btn btn-default" onClick="self.location.href='pos_line_setup_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
        </div>
        <div class="clearfix"></div>
        <br>
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>