<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POST
$CERTIFICATE_ID=$_POST['CERTIFICATE_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 

//DATA
$sql = "select * from SETUP_CERTIFICATE where CERTIFICATE_ID = '".$CERTIFICATE_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

//$rec = @array_change_key_case($rec,CASE_LOWER);


$SQL_Cery_by = "SELECT  CERTIFICATE_BY as CERTIFICATE_BY FROM SETUP_CERTIFICATE WHERE ACTIVE_STATUS='1' and DELETE_FLAG='0' order by CERTIFICATE_BY asc";
$query_Cery_by = $db->query($SQL_Cery_by);

 


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
<script src="js/data_certificate.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="certificate_list.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12">
        <div class="groupdata" >
			<!--<div class="row heading"><?php echo $txt;?></div>-->
            <form id="frm-input" method="post" action="process/data_certificate_process.php">
            	<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
            	<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="CERTIFICATE_ID" name="CERTIFICATE_ID" value="<?php echo $CERTIFICATE_ID; ?>">
                <input type="hidden" id="flagDup1" name="flagDup1">
                <input type="hidden" id="flagDup2" name="flagDup2">
                <?php /*<input type="hidden" id="flagDup3" name="flagDup3"> */ ?>
                <input type="hidden" id="flagDup4" name="flagDup4">
                <input type="hidden" id="flagDup5" name="flagDup5">
 
			<?php /*	<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					รหัสใบประกอบวิชาชีพ &nbsp;&nbsp;</div>
					<div class="col-xs-12 col-md-3">
                    <input type="text" id="CERTIFICATE_CODE" name="CERTIFICATE_CODE" class="form-control" placeholder="รหัสใบประกอบวิชาชีพ " value="<?php echo text($rec["CERTIFICATE_CODE"]); ?>" maxlength="20" onKeyUp="chkDup('chkDup3','flagDup3','CERTIFICATE_CODE','CERTIFICATE_ID','SETUP_CERTIFICATE','');" >
                    </div> 
                    <span id="chkDup3" class="col-sm-2 hidden-xs label"></span>
				</div>
              */?>
                
                
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					ใบประกอบวิชาชีพ (<?php echo $arr_txt['th'];?>)&nbsp;<span style="color:red;">*</span>&nbsp;</div>
					<div class="col-xs-12 col-md-3">
                    <input type="text" id="CERTIFICATE_NAME_TH" name="CERTIFICATE_NAME_TH" class="form-control" placeholder="ใบประกอบวิชาชีพ (<?php echo $arr_txt['th'];?>)" value="<?php echo text($rec["CERTIFICATE_NAME_TH"]); ?>" maxlength="100" onKeyUp="chkDup('chkDup1','flagDup1','CERTIFICATE_NAME_TH','CERTIFICATE_ID','SETUP_CERTIFICATE','');">
                    </div> 
                    <span id="chkDup1" class="col-sm-2 hidden-xs label"></span>
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					ใบประกอบวิชาชีพ (<?php echo $arr_txt['en'];?>)&nbsp;</div> 
					<div class="col-xs-12 col-md-3"><input type="text" id="CERTIFICATE_NAME_EN" name="CERTIFICATE_NAME_EN" class="form-control" placeholder="ใบประกอบวิชาชีพ (<?php echo $arr_txt['en'];?>)" value="<?php echo text($rec["CERTIFICATE_NAME_EN"]); ?>" maxlength="100" onKeyUp="chkDup('chkDup2','flagDup2','CERTIFICATE_NAME_EN','CERTIFICATE_ID','SETUP_CERTIFICATE','');"></div> 
                    <span id="chkDup2" class="col-sm-2 hidden-xs label"></span>
				</div>
                
                
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					ชื่อย่อใบประกอบวิชาชีพ (<?php echo $arr_txt['th'];?>)&nbsp; &nbsp;</div>
					<div class="col-xs-12 col-md-3">
                    <input type="text" id="CERTIFICATE_SHORTNAME_TH" name="CERTIFICATE_SHORTNAME_TH" class="form-control" placeholder="ชื่อย่อใบประกอบวิชาชีพ (<?php echo $arr_txt['th'];?>)" value="<?php echo text($rec["CERTIFICATE_SHORTNAME_TH"]); ?>" maxlength="20" onKeyUp="chkDup('chkDup4','flagDup4','CERTIFICATE_SHORTNAME_TH','CERTIFICATE_ID','SETUP_CERTIFICATE','');">
                    </div> 
                    <span id="chkDup4" class="col-sm-2 hidden-xs label"></span>
				</div>

				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					ชื่อย่อใบประกอบวิชาชีพ (<?php echo $arr_txt['en'];?>)&nbsp; &nbsp;</div>
					<div class="col-xs-12 col-md-3">
                    <input type="text" id="CERTIFICATE_SHORTNAME_EN" name="CERTIFICATE_SHORTNAME_EN" class="form-control" placeholder="ชื่อย่อใบประกอบวิชาชีพ (<?php echo $arr_txt['en'];?>)" value="<?php echo text($rec["CERTIFICATE_SHORTNAME_EN"]); ?>" maxlength="20" onKeyUp="chkDup('chkDup5','flagDup5','CERTIFICATE_SHORTNAME_EN','CERTIFICATE_ID','SETUP_CERTIFICATE','');">
                    </div> 
                    <span id="chkDup5" class="col-sm-2 hidden-xs label"></span>
				</div>         
                
        
 

				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					หน่วยงานที่ออกให้&nbsp; &nbsp;</div>
					<div class="col-xs-12 col-md-3">  
				<select id="CERTIFICATE_BY" name="CERTIFICATE_BY" class="selectbox form-control" placeholder="หน่วยงานที่ออกให้">
				  <option value=""></option>
				  <?php while($rec1 = $db->db_fetch_array($query_Cery_by)){?>
					<option value="<?php echo text($rec1['CERTIFICATE_BY'])?>" <?php echo ($rec1['CERTIFICATE_BY'] == $rec['CERTIFICATE_BY']?"selected":"");?>>
					<?php echo text($rec1['CERTIFICATE_BY'])?> </option>
				  <?php }?>
				</select> 
                    </div> 
                    <span id="chkDup5" class="col-sm-2 hidden-xs label"></span>
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
						<button type="button" class="btn btn-default" onClick="self.location.href='certificate_list.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
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