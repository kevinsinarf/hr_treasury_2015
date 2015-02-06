<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$paramlink = url2code($link);
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

//POST
$PER_ID=$_POST['PER_ID'];
$PCHILD_ID=$_POST['PCHILD_ID'];

$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 

//DATA
 $sql = "SELECT PCHILD_ID,PCHILD_PREFIX_ID,PCHILD_FIRSTNAME_TH,PCHILD_MIDNAME_TH,PCHILD_LASTNAME_TH,
PCHILD_FIRSTNAME_EN,PCHILD_MIDNAME_EN,PCHILD_LASTNAME_EN,PCHILD_IDCARD,PCHILD_BIRTHDATE,PCHILD_STATUS, ACTIVE_STATUS
FROM PER_CHILD  where DELETE_FLAG = '0' AND PCHILD_ID = '".$PCHILD_ID."'";
$query = $db->query($sql);
$data = $db->db_fetch_array($query);

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
<script src="js/profile_child_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
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
      <li><a href="profile_child_disp.php?<?php echo url2code($link2); ?>">ประวัติบุตร</a></li>
	   <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12">
    <div class="groupdata" ><br>
	<?php include ("tab_info.php"); ?>
	<div class="clearfix"></div>
      <form id="frm-input" method="post" action="process/profile_child_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        <input type="hidden" id="PCHILD_ID" name="PCHILD_ID"  value="<?php echo $PCHILD_ID; ?>">
         <div class="clearfix">
         </div>
		<div class="clearfix"></div>
            <div class="row formSep">
            <div class="col-md-2 col-sm-2 " style="white-space:nowrap"><?php echo $arr_txt['idcard']; ?> :&nbsp; <span style="color:red;">*</span>&nbsp; </div>
				<div class="col-md-2 col-sm-2">
					<input type="text" id="PCHILD_IDCARD" class="form-control idcard" name="PCHILD_IDCARD"  maxlength="13"  placeholder="<?php echo $arr_txt['idcard']; ?>"  
                    value="<?php echo $data['PCHILD_IDCARD']; ?>">
			</div> </div>

        <div class="row formSep">
				<div class="col-md-2 col-sm-2"><?php echo $arr_txt['title']; ?> : <span style="color:red;">*</span>&nbsp; </div>
				<div class="col-md-2 col-sm-2">
				<?php 
						echo GetHtmlSelect('PREFIX_ID','PREFIX_ID',$arr_prefix_child,$arr_txt['title']." (".$arr_txt['th'].")",$data['PCHILD_PREFIX_ID'],'onchange=\'getTitle();\'','','1');
					?>
			</div>            
            <div class="col-xs-12 col-md-2 col-md-offset-2" style="white-space:nowrap;">
					<?php echo $arr_txt['title']; ?> (<?php echo $arr_txt['en'] ;?>) :</div>
					<div class="col-xs-12 col-md-2"><span id="prefix_en">
					<?php echo ($arr_prefix_en[$data['PCHILD_PREFIX_ID']])?$arr_prefix_en[$data['PCHILD_PREFIX_ID']]:"-"?></span></div>
                    </div>
                    
            <div class="row formSep">
             <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">วันเดือนปีเกิด&nbsp;<span style="color:red;">*</span>&nbsp;</div>
			  <div class="col-xs-12 col-md-2">
					<div class="input-group">
						<input type="text" id="PCHILD_BIRTHDATE" name="PCHILD_BIRTHDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" 
						value="<?php echo  conv_date(text($data["PCHILD_BIRTHDATE"]),'');?>">
						<span class="input-group-addon datepicker" for="PCHILD_BIRTHDATE" >&nbsp;
						<span class="glyphicon glyphicon-calendar"></span>&nbsp;
						</span>
					</div>						
				</div>
			</div>
           
            
		<div class="clearfix"></div>
		<div class="row formSep">
			
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['fname']; ?> (<?php echo $arr_txt['th'] ;?>) : &nbsp;<span style="color:red;">*</span>&nbsp;
			</div>
			<div class="col-xs-12 col-md-2">
				<input type="text" id="PCHILD_FIRSTNAME_TH" name="PCHILD_FIRSTNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['fname']; ?> (<?php echo $arr_txt['th'] ;?>)" maxlength="100" value="<?php echo text($data["PCHILD_FIRSTNAME_TH"]); ?>">
			</div>
			<div class="col-xs-12 col-md-2 " style="white-space:nowrap;"><?php echo $arr_txt['mname']; ?> (<?php echo $arr_txt['th'] ;?>) : 
			</div>
			<div class="col-xs-12 col-md-2">
				<input type="text" id="PCHILD_MIDNAME_TH" name="PCHILD_MIDNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['mname']; ?> (<?php echo $arr_txt['th'] ;?>)" maxlength="100" value="<?php echo text($data["PCHILD_MIDNAME_TH"]); ?>">
			</div>
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['lname']; ?> (<?php echo $arr_txt['th'] ;?>) : &nbsp;<span style="color:red;">*</span>&nbsp;
			</div>
			<div class="col-xs-12 col-md-2">
				<input type="text" id="PCHILD_LASTNAME_TH" name="PCHILD_LASTNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['lname']; ?> (<?php echo $arr_txt['th'] ;?>)" maxlength="100" value="<?php echo text($data["PCHILD_LASTNAME_TH"]); ?>">
			</div>
		</div>
        
		<div class="row formSep">
			<div class="clearfix"></div>
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['fname']; ?> (<?php echo $arr_txt['en'] ;?>) :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
			<div class="col-xs-12 col-md-2">
				<input type="text" id="PCHILD_FIRSTNAME_EN" name="PCHILD_FIRSTNAME_EN" class="form-control" placeholder="<?php echo $arr_txt['fname']; ?> (<?php echo $arr_txt['en'] ;?>)" maxlength="100" value="<?php echo text($data["PCHILD_FIRSTNAME_EN"]); ?>">
			</div>
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['mname']; ?> (<?php echo $arr_txt['en'] ;?>)</div>
			<div class="col-xs-12 col-md-2">
				<input type="text" id="PCHILD_MIDNAME_EN" name="PCHILD_MIDNAME_EN" class="form-control" placeholder="<?php echo $arr_txt['mname']; ?> (<?php echo $arr_txt['en'] ;?>)" maxlength="100" value="<?php echo text($data["PCHILD_MIDNAME_EN"]); ?>">
			</div>
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['lname']; ?> (<?php echo $arr_txt['en'] ;?>)&nbsp;<span style="color:red;">*</span>&nbsp;</div>
			<div class="col-xs-12 col-md-2">
				<input type="text" id="PCHILD_LASTNAME_EN" name="PCHILD_LASTNAME_EN" class="form-control" placeholder="<?php echo $arr_txt['lname']; ?> (<?php echo $arr_txt['en'] ;?>)" maxlength="100" value="<?php echo text($data["PCHILD_LASTNAME_EN"]); ?>">
			</div>
		</div>
		<div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานะภาพ&nbsp;<span style="color:red;">*</span></div>
            <div class="col-xs-12 col-md-2">
                <label>
					<input type="radio" id="PCHILD_STATUS" name="PCHILD_STATUS" value="1" <?php echo ($data['PCHILD_STATUS']=='1' || $data['PCHILD_STATUS']==''?"checked":"")?>>
                           มีชีวิตอยู่</label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label>
					<input type="radio" id="PCHILD_STATUS" name="PCHILD_STATUS" value="2" <?php echo ($data['PCHILD_STATUS']=='2'?"checked":"")?>>
                         ถึงแก่กรรม</label>
            </div>
        </div>
        
        <div class="row formSep">
					<div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['active'];?>&nbsp;<span style="color:red;">*</span>&nbsp;</div>
					<div class="col-xs-12 col-md-2">
						<label ><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($data['ACTIVE_STATUS']=='1'||$data['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>
					
					 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label ><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($data['ACTIVE_STATUS']=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?></label></div>
				</div>
                
		<div class="clearfix"></div><br>
        <div class="col-xs-12 col-sm-12" align="center">
          <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
          <button type="button" class="btn btn-default" onClick="self.location.href='profile_child_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
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