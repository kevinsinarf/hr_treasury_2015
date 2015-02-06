<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
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
$paramlink = url2code($link);

//POST
$PER_ID=$_POST['PER_ID'];
$LANGHIS_ID=$_POST['LANGHIS_ID'];
$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 

//DATA
$sql = "SELECT a.LANGHIS_ID ,a.PER_ID ,a.LANGHIS_DATE ,a.ACTIVE_STATUS ,b.COUNTRY_NAME_TH ,b.COUNTRY_ID ,a.LANGHIS_LISTEN ,a.LANGHIS_SPEAKING , a.LANGHIS_READING, a.LANGHIS_WRITING
FROM PER_LANGUAGE a LEFT JOIN SETUP_COUNTRY b ON b.COUNTRY_ID = a.LANG_ID
WHERE  a.DELETE_FLAG='0' and a.LANGHIS_ID = '".$LANGHIS_ID."'
order by  a.ACTIVE_STATUS DESC, b.COUNTRY_NAME_TH ASC";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

//ประเทศ
$sql_country = "SELECT COUNTRY_ID ,COUNTRY_NAME_TH as COUNTRY_NAME FROM SETUP_COUNTRY WHERE ACTIVE_STATUS='1' and DELETE_FLAG='0' order by COUNTRY_NAME_TH asc";
$query_country = $db->query($sql_country);
$arr_status = array( '1' => 'พอใช้' ,'2' => 'ดี',  '3' => 'ดีมาก');
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
<script src="js/profile_language_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
      <li><a href="profile_language_disp.php?<?php echo url2code($link2); ?>">ประวัติทักษะทางภาษา</a></li>
	  <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" ><br>
	<?php include ("tab_info.php"); ?>
	<div class="clearfix"></div>
      <form id="frm-input" method="post" action="process/profile_language_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        <input type="hidden" id="LANGHIS_ID" name="LANGHIS_ID"  value="<?php echo $LANGHIS_ID; ?>">
		<div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่บันทึก :&nbsp;<span style="color:red;"></span>&nbsp;</div>
            <div class="col-xs-12 col-md-2">
                <div class="input-group">
                <input type="text" class="form-control col-md-13" name="LANGHIS_DATE_1" id="LANGHIS_DATE_1" value="<?php echo conv_date($rec['LANGHIS_DATE']);?>" placeholder="DD/MM/YYYY">
                <span class="input-group-addon datepicker" for="LANGHIS_DATE_1" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                </div>
            </div>
            <div class="col-xs-12 col-md-2"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ภาษา : <span style="color:red;">*</span>&nbsp; </div>
            <div class="col-xs-12 col-md-2">
            	<select id="COUNTRY_ID" name="COUNTRY_ID" class="selectbox form-control" placeholder="ภาษา">
                    <option value=""></option>
					<?php while($rec1 = $db->db_fetch_array($query_country)){?><option value="<?php echo $rec1['COUNTRY_ID']?>" 
                    <?php echo ($rec1['COUNTRY_ID'] == $rec['COUNTRY_ID']?"selected":"");?>><?php echo text($rec1['COUNTRY_NAME'])?></option>
					<?php }?>
                </select>
            </div>
		</div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ฟัง : <span style="color:red;">*</span>&nbsp; </div>
            <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('LANGHIS_LISTEN', 'LANGHIS_LISTEN',$arr_status , 'ฟัง' ,$rec['LANGHIS_LISTEN'],'', '1', '', '','2'); ?></div>
            <div class="col-xs-12 col-md-2"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">พูด : <span style="color:red;">*</span>&nbsp; </div>
            <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('LANGHIS_SPEAKING', 'LANGHIS_SPEAKING',$arr_status , 'พูด' ,$rec['LANGHIS_SPEAKING'],'', '1', '', '','2'); ?></div>
        </div>
                      
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อ่าน : <span style="color:red;">*</span>&nbsp; </div>
            <div class="col-xs-12 col-md-2"> <?php echo GetHtmlSelect('LANGHIS_READING', 'LANGHIS_READING',$arr_status , 'อ่าน' ,$rec['LANGHIS_READING'],'', '1', '', '','2'); ?></div>
            <div class="col-xs-12 col-md-2"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เขียน : <span style="color:red;">*</span>&nbsp; </div>
            <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('LANGHIS_WRITING', 'LANGHIS_WRITING',$arr_status , 'เขียน' ,$rec['LANGHIS_WRITING'],'', '1', '', '','2'); ?></div>
        </div>    
              
        <div class="col-xs-12 col-sm-12" align="center">
          <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
          <button type="button" class="btn btn-default" onClick="self.location.href='profile_language_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
        </div>

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