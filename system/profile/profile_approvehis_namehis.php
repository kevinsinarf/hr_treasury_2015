<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;
//page back
if($PT_ID=="2"){
	$page_back = "profile_his_empser.php";
	$POSTYPE_ID = '3';
}elseif($PT_ID=="3"){
	$page_back = "profile_his_emp.php";
	$POSTYPE_ID = '5';
}else{
	$page_back = "profile_his_disp.php";
	$POSTYPE_ID = '1';
}

//POST
$REQUEST_ID=$_POST['REQUEST_ID'];

$txt = "เปลี่ยนแปลงข้อมูล";

//DATA
$sql = "SELECT a.*, CONVERT(DATE,b.REQUEST_DATETIME) as REQUEST_DATETIME, b.REQUEST_APP_DATE
FROM PER_NAMEHIS a
INNER JOIN PER_REQUEST b ON a.REQUEST_ID = b.REQUEST_ID and a.PER_ID = b.PER_ID 
WHERE b.DELETE_FLAG = '0' AND b.REQUEST_ID = '".$REQUEST_ID."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$PER_ID = $rec['PER_ID'];
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
<script src="js/profile_approvehis_namehis.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="profile_approvehis.php?<?php echo url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
	  <li class="active">ประวัติการเปลี่ยนคำนำหน้า ชื่อ ชื่อกลาง ชื่อสกุล</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" ><br>
	<?php include ("tab_info.php"); ?>
	<div class="clearfix"></div>
      <form id="frm-input" method="post" action="process/profile_approvehis_namehis_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
        <input type="hidden" id="REQUEST_ID" name="REQUEST_ID"  value="<?php echo $REQUEST_ID; ?>">
		
        <div class="clearfix"></div>
        <div class="row formSep">
            <div class="col-sm-2 col-sm-2">วันที่ขอเปลี่ยนแปลง&nbsp;:&nbsp;</div>
            <div class="col-sm-2 col-sm-2"><?php echo conv_date($rec['REQUEST_DATETIME'],'short'); ?></div>
        </div>
        
        <div class="clearfix"></div>
        <div class="row formSep">
            <div class="col-sm-2 col-sm-2">วันที่อนุมัติ&nbsp;:&nbsp;<span style="color:red;">*</span></div>
            <div class="col-sm-2 col-sm-2">
                <div class="input-group">
                    <input type="text" id="REQUEST_APP_DATE" name="REQUEST_APP_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="">
                    <span class="input-group-addon datepicker" for="REQUEST_APP_DATE" >&nbsp;
                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>						
            </div>
        </div>
        
        <?php if($rec['NAMEHIS_DETAIL_1'] == 1){ ?>
        <div class="clearfix"></div>
        <div class="row formSep">
			<div class="col-sm-2 col-sm-2"><?php echo $arr_txt['title']."เดิม"; ?> : &nbsp; </div>
			<div class="col-sm-2 col-sm-4"><?php echo text($arr_prefix[$rec['NAMEHIS_LAST_PREFIX_ID']]); ?></div>
            <div class="col-sm-2 col-sm-2"><?php echo $arr_txt['title']."ใหม่"; ?> : &nbsp; </div>
			<div class="col-sm-2 col-sm-3"><?php echo text($arr_prefix[$rec['NAMEHIS_NEW_PREFIX_ID']]); ?>
            	<input type="hidden" id="NAMEHIS_NEW_PREFIX_ID" name="NAMEHIS_NEW_PREFIX_ID"  value="<?php echo text($rec['NAMEHIS_NEW_PREFIX_ID']); ?>">
			</div>
     	</div>
        
		<div class="clearfix"></div>
        <div class="row formSep">        
            <div class="col-sm-2 col-sm-2"><?php echo $arr_txt['title']."เดิม"; ?> (<?php echo $arr_txt['en'] ;?>) :</div>
			<div class="col-xs-2 col-sm-4"><span id="prefix_last_en"><?php echo ($arr_prefix_en[$rec['NAMEHIS_LAST_PREFIX_ID']])?$arr_prefix_en[$rec['NAMEHIS_LAST_PREFIX_ID']]:"-"?></span></div>
            <div class="col-sm-2 col-sm-2"><?php echo $arr_txt['title']."ใหม่"; ?> (<?php echo $arr_txt['en'] ;?>) :</div>
			<div class="col-xs-2 col-sm-3"><span id="prefix_new_en"><?php echo ($arr_prefix_en[$rec['NAMEHIS_NEW_PREFIX_ID']])?$arr_prefix_en[$rec['NAMEHIS_NEW_PREFIX_ID']]:"-"?></span></div>
		</div>
        <?php } ?>
        
        <?php if($rec['NAMEHIS_DETAIL_2'] == 1){ ?>
		<div class="clearfix"></div>
		<div class="row formSep">
			<div class="col-xs-2 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['fname']."เดิม"; ?> (<?php echo $arr_txt['th'] ;?>) : &nbsp;&nbsp;</div>
			<div class="col-xs-2 col-sm-4"><?php echo text($rec["NAMEHIS_LAST_FIRSTNAME_TH"]); ?></div>
            <div class="col-xs-2 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['fname']."ใหม่"; ?> (<?php echo $arr_txt['th'] ;?>) : &nbsp;&nbsp;</div>
			<div class="col-sm-2 col-sm-3"><?php echo text($rec["NAMEHIS_NEW_FIRSTNAME_TH"]); ?>
                <input type="hidden" id="NAMEHIS_NEW_FIRSTNAME_TH" name="NAMEHIS_NEW_FIRSTNAME_TH"  value="<?php echo text($rec['NAMEHIS_NEW_FIRSTNAME_TH']); ?>">
			</div>
     	</div> 
        
        <div class="clearfix"></div>
		<div class="row formSep">
			<div class="col-sm-2 col-sm-2"><?php echo $arr_txt['fname']."เดิม"; ?> (<?php echo $arr_txt['en'] ;?>) :&nbsp;&nbsp;</div>
			<div class="col-sm-2 col-sm-4"><?php echo text($rec["NAMEHIS_LAST_FIRSTNAME_EN"]); ?></div>
			<div class="col-sm-2 col-sm-2"><?php echo $arr_txt['fname']."ใหม่"; ?> (<?php echo $arr_txt['en'] ;?>) :&nbsp;&nbsp;</div>
			<div class="col-sm-2 col-sm-3"><?php echo text($rec["NAMEHIS_NEW_FIRSTNAME_EN"]); ?>
                <input type="hidden" id="NAMEHIS_NEW_FIRSTNAME_EN" name="NAMEHIS_NEW_FIRSTNAME_EN"  value="<?php echo text($rec['NAMEHIS_NEW_FIRSTNAME_EN']); ?>">
			</div>
     	</div>         
        <?php } ?>
        
        <?php if($rec['NAMEHIS_DETAIL_3'] == 1){ ?> 
		<div class="clearfix"></div>
        <div class="row formSep">
			<div class="col-sm-2 col-sm-2"><?php echo $arr_txt['mname']."เดิม"; ?> (<?php echo $arr_txt['th'] ;?>) : </div>
			<div class="col-sm-2 col-sm-4"><?php echo text($rec["NAMEHIS_LAST_MIDNAME_TH"]); ?></div>
            <div class="col-sm-2 col-sm-2"><?php echo $arr_txt['mname']."ใหม่"; ?> (<?php echo $arr_txt['th'] ;?>) : </div>
			<div class="col-sm-2 col-sm-3"><?php echo text($rec["NAMEHIS_NEW_MIDNAME_TH"]); ?>
                <input type="hidden" id="NAMEHIS_NEW_MIDNAME_TH" name="NAMEHIS_NEW_MIDNAME_TH"  value="<?php echo text($rec['NAMEHIS_NEW_MIDNAME_TH']); ?>">
			</div>
     	</div>
        
		<div class="clearfix"></div>
        <div class="row formSep">
			<div class="col-sm-2 col-sm-2"><?php echo $arr_txt['mname']."เดิม"; ?> (<?php echo $arr_txt['en'] ;?>) : </div>
			<div class="col-sm-2 col-sm-4"><?php echo text($rec["NAMEHIS_LAST_MIDNAME_EN"]); ?></div>
            <div class="col-sm-2 col-sm-2"><?php echo $arr_txt['mname']."ใหม่"; ?> (<?php echo $arr_txt['en'] ;?>) : </div>
			<div class="col-sm-2 col-sm-3"><?php echo text($rec["NAMEHIS_NEW_MIDNAME_EN"]); ?>
                <input type="hidden" id="NAMEHIS_NEW_MIDNAME_EN" name="NAMEHIS_NEW_MIDNAME_EN"  value="<?php echo text($rec['NAMEHIS_NEW_MIDNAME_EN']); ?>">
			</div>
     	</div> 
        <?php } ?>
        
       <?php if($rec['NAMEHIS_DETAIL_4'] == 1){ ?>  
		<div class="clearfix"></div>
        <div class="row formSep">
			<div class="col-sm-2 col-sm-2"><?php echo $arr_txt['lname']."เดิม"; ?> (<?php echo $arr_txt['th'] ;?>) : &nbsp;&nbsp;</div>
			<div class="col-sm-2 col-sm-4"><?php echo text($rec["NAMEHIS_LAST_LASTNAME_TH"]); ?></div>
            <div class="col-sm-2 col-sm-2"><?php echo $arr_txt['lname']."ใหม่"; ?> (<?php echo $arr_txt['th'] ;?>) : &nbsp;&nbsp;</div>
			<div class="col-sm-2 col-sm-3"><?php echo text($rec["NAMEHIS_NEW_LASTNAME_TH"]); ?>
                <input type="hidden" id="NAMEHIS_NEW_LASTNAME_TH" name="NAMEHIS_NEW_LASTNAME_TH"  value="<?php echo text($rec['NAMEHIS_NEW_LASTNAME_TH']); ?>">
			</div>
		</div>
                        
		<div class="clearfix"></div>
        <div class="row formSep">
			<div class="col-sm-2 col-sm-2"><?php echo $arr_txt['lname']."เดิม"; ?> (<?php echo $arr_txt['en'] ;?>)&nbsp;:&nbsp;</div>
			<div class="col-sm-2 col-sm-4"><?php echo text($rec["NAMEHIS_LAST_LASTNAME_EN"]); ?></div>
            <div class="col-sm-2 col-sm-2"><?php echo $arr_txt['lname']."ใหม่"; ?> (<?php echo $arr_txt['en'] ;?>)&nbsp;:&nbsp;</div>
			<div class="col-sm-2 col-sm-3"><?php echo text($rec["NAMEHIS_NEW_LASTNAME_EN"]); ?>
                <input type="hidden" id="NAMEHIS_NEW_LASTNAME_EN" name="NAMEHIS_NEW_LASTNAME_EN"  value="<?php echo text($rec['NAMEHIS_NEW_LASTNAME_EN']); ?>">
			</div>
		</div>
        <?php } ?>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">การอนุมัติ&nbsp;:&nbsp;<span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-4">
                <label ><input type="radio" id="REQUEST_RESULT2" name="REQUEST_RESULT" value="2" <?php echo $rec['REQUEST_RESULT']=='2' || $rec['REQUEST_RESULT']=='1' || $rec['REQUEST_RESULT']==''?'checked':'';?> >&nbsp;<?php echo $arr_request_result['2'];?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label ><input type="radio" id="REQUEST_RESULT3" name="REQUEST_RESULT" value="3" <?php echo $rec['REQUEST_RESULT']=='3'?'checked':'';?> >&nbsp;<?php echo $arr_request_result['3'];?></label>
            </div>
        </div>
                
		<div class="clearfix"></div><br>
        <div class="row formlast">
            <div class="col-xs-12 col-sm-12" align="center">
              <button type="button" class="btn btn-primary" onClick="chkApprove();">บันทึก</button>
              <button type="button" class="btn btn-default" onClick="self.location.href='profile_approvehis.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
            </div>
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