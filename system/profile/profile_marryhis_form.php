<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
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
$PT_ID=$_POST['PT_ID'];
$PMARRY_ID=$_POST['PMARRY_ID'];
$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 

//DATA
$sql = "SELECT PMARRY_ID,PER_ID,PMARRY_TYPE,PMARRY_SEQ,PMAARY_IDCARD,PMARRY_PREFIX_ID,PMARRY_FIRSTNAME_TH,PMARRY_MIDNAME_TH,
PMARRY_LASTNAME_TH,PMARRY_FIRSTNAME_EN,PMARRY_MIDNAME_EN,PMARRY_LASTNAME_EN,PMARRY_O_LASTNAME_TH,PMARRY_O_LASTNAME_EN,
PMARRY_STATUS,ACTIVE_STATUS
FROM PER_MARRYHIS
WHERE PMARRY_ID = '".$PMARRY_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

$arr_prefix=GetSqlSelectArray("PREFIX_ID", "PREFIX_NAME_TH", "V_PREFIX", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PREFIX_SEQ,PREFIX_NAME_TH"); //คำนำหน้าชื่อ th

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
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
<script src="<?php echo $path; ?>bootstrap/js/chosen.jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_marryhis_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
	<div><?php include($path."include/menu.php");?></div>
	<div class="col-xs-12 col-sm-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			 <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
			<li><a href="profile_marryhis_disp.php?<?php echo url2code($link2); ?>">ประวัติการสมรส</a></li>
			<li class="active"><?php echo $txt; ?></li>
		</ol>
	</div>
	<div class="col-xs-12 col-sm-12" id="content">
		<div class="groupdata" >
			<?php include ("tab_info.php"); ?>
			<form id="frm-input" method="post" action="process/profile_marryhis_process.php" enctype="multipart/form-data">
			<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
			<input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
			<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
			<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
			<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
            <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        	<input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
			<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
			<input type="hidden" id="PMARRY_ID" name="PMARRY_ID" value="<?php echo $PMARRY_ID?>">
            <div class="row formSep">
            	<div class="col-md-2 col-sm-2 " style="white-space:nowrap"><?php echo $arr_txt['idcard']; ?> :&nbsp; <span style="color:red;">*</span>&nbsp; </div>
				<div class="col-md-2 col-sm-2"><input type="text" id="PMAARY_IDCARD" class="form-control idcard" name="PMAARY_IDCARD"  maxlength="13"  placeholder="<?php echo $arr_txt['idcard']; ?>"  value="<?php echo $rec['PMAARY_IDCARD']; ?>"></div>
           </div>
               
			<div class="row formSep">
				<div class="col-md-2 col-sm-2"><?php echo $arr_txt['title']; ?> : <span style="color:red;">*</span>&nbsp; </div>
				<div class="col-md-2 col-sm-2"><?php echo GetHtmlSelect('PMARRY_PREFIX_ID','PMARRY_PREFIX_ID',$arr_prefix,$arr_txt['title']." (".$arr_txt['th'].")",$rec['PMARRY_PREFIX_ID'],'','','1');?></div> 
            </div>
                
            <div class="row formSep">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['fname']; ?> (<?php echo $arr_txt['th']; ?>) : <span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-md-2"><input type="text" id="PMARRY_FIRSTNAME_TH" name="PMARRY_FIRSTNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['fname']; ?> (<?php echo $arr_txt['th']; ?>)" maxlength="100" value="<?php echo text($rec['PMARRY_FIRSTNAME_TH']); ?>"></div>
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['mname']; ?> (<?php echo $arr_txt['th']; ?>) : </div>
				<div class="col-xs-12 col-md-2"><input type="text" id="PMARRY_MIDNAME_TH" name="PMARRY_MIDNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['mname']; ?> (<?php echo $arr_txt['th']; ?>)" maxlength="100" value="<?php echo text($rec['PMARRY_MIDNAME_TH']); ?>"></div>
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['lname']; ?> (<?php echo $arr_txt['th']; ?>) : <span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-md-2"><input type="text" id="PMARRY_LASTNAME_TH" name="PMARRY_LASTNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['lname']; ?> (<?php echo $arr_txt['th']; ?>)" maxlength="100" value="<?php echo text($rec['PMARRY_LASTNAME_TH']); ?>"></div>
            </div>
            
            <div class="row formSep">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['fname']; ?> (<?php echo $arr_txt['en']; ?>) : <span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-md-2"><input type="text" id="PMARRY_FIRSTNAME_EN" name="PMARRY_FIRSTNAME_EN" class="form-control" placeholder="<?php echo $arr_txt['fname']; ?> (<?php echo $arr_txt['en']; ?>)" maxlength="100" value="<?php echo text($rec['PMARRY_FIRSTNAME_EN']); ?>"></div>
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['mname']; ?> (<?php echo $arr_txt['en']; ?>) :</div>
				<div class="col-xs-12 col-md-2"><input type="text" id="PMARRY_MIDNAME_EN" name="PMARRY_MIDNAME_EN" class="form-control" placeholder="<?php echo $arr_txt['mname']; ?> (<?php echo $arr_txt['en']; ?>)" maxlength="100" value="<?php echo text($rec['PMARRY_MIDNAME_EN']); ?>"></div>
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['lname']; ?> (<?php echo $arr_txt['en']; ?>) : <span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-md-2"><input type="text" id="PMARRY_LASTNAME_EN" name="PMARRY_LASTNAME_EN" class="form-control" placeholder="<?php echo $arr_txt['lname']; ?> (<?php echo $arr_txt['en']; ?>)" maxlength="100" value="<?php echo text($rec['PMARRY_LASTNAME_EN']); ?>"></div>
			</div>
            
            <div class="row formSep">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['lname']; ?>ก่อนสมรส (<?php echo $arr_txt['th']; ?>) :</div>
				<div class="col-xs-12 col-md-3"><input type="text" id="PMARRY_O_LASTNAME_TH" name="PMARRY_O_LASTNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['lname']; ?>ก่อนสมรสเดิม (<?php echo $arr_txt['th']; ?>)" maxlength="100" value="<?php echo text($rec['PMARRY_O_LASTNAME_TH']); ?>"></div>
				<div class="col-xs-12 col-md-1"></div>
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['lname']; ?>ก่อนสมรส (<?php echo $arr_txt['en']; ?>):</div>
				<div class="col-xs-12 col-md-3"><input type="text" id="PMARRY_O_LASTNAME_EN" name="PMARRY_O_LASTNAME_EN" class="form-control" placeholder="<?php echo $arr_txt['lname']; ?>ก่อนสมรสเดิม (<?php echo $arr_txt['en']; ?>)" maxlength="100" value="<?php echo ($rec['PMARRY_O_LASTNAME_EN']); ?>"></div>
            </div>    
            
            <div class="row formSep">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทคู่สมรส&nbsp;:&nbsp;<span style="color:red;">*</span></div>
				<div class="col-xs-10 col-md-3">
                    <select id="PMARRY_TYPE" name="PMARRY_TYPE" class="selectbox form-control" placeholder="ประเภทคู่สมรส">
                        <option value="" ></option>
                             <?php foreach ($arr_marry_type as $key => $value){  ?>
                                <option value="<?php echo $key ; ?>" <?php echo ($rec['PMARRY_TYPE'] == $key?"selected":"");?>><?php echo $value;?></option>
                            <?php }?>
                    </select>
				</div>
            </div>
            
           	<div class="row formSep">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานะของการสมรส&nbsp;:&nbsp;<span style="color:red;">*</span></div>
				<div class="col-xs-10 col-md-6">
					<label ><input type="radio" id="PMARRY_STATUS1" name="PMARRY_STATUS" value="1" <?php echo ($rec['PMARRY_STATUS']=='1'||$data['PMARRY_STATUS']=='' ?"checked":"")?>> <?php echo $arr_marry_status['1'];?></label>&nbsp;&nbsp;&nbsp;
					<label ><input type="radio" id="PMARRY_STATUS2" name="PMARRY_STATUS" value="2" <?php echo ($rec['PMARRY_STATUS']=='2'?"checked":"")?> > <?php echo $arr_marry_status['2'];?></label>&nbsp;&nbsp;&nbsp;
					<label ><input type="radio" id="PMARRY_STATUS3" name="PMARRY_STATUS" value="3" <?php echo ($rec['PMARRY_STATUS']=='3'?"checked":"")?> > <?php echo $arr_marry_status['3'];?></label>
				</div>
            </div>
            
            <div class="row formSep">
                <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['active'];?>&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                <div class="col-xs-12 col-md-2">
                <label ><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS" value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$data['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>&nbsp;&nbsp;
                <label ><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?></label>
                </div>
            </div>
                    
			<div class="row formlast">
				<div class="col-xs-12 col-sm-12" align="center">
                  <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                  <button type="button" class="btn btn-default" onClick="self.location.href='profile_marryhis_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
				</div>
			</div>
			</form>
		</div>
	</div>
	<div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>