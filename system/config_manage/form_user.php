<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 

$sql = "select  c.PER_ID,c.PER_IDCARD,a.* ,b.*  
from aut_user a
left join aut_user_group b on a.aut_user_id = b.aut_user_id
INNER JOIN PER_PROFILE c on c.PER_ID=AUT_PER_ID
where a.aut_user_id = '".$aut_user_id."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$per_id_v=$rec["PER_ID"];
$per_iccard_v=$rec['PER_IDCARD'];
$rec = @array_change_key_case($rec,CASE_LOWER);//เปลียนให้เป็นตัวเล็ก
$aut_username = (trim($proc)!='add'?text($rec["aut_username"]):'');
$user_group_id = text($rec["user_group_id"]);
$email = $rec['email'];

$ACTIVE_STATUS = text($rec["active_status"]);

$sqlGroup = "select * from aut_group order by group_name asc";
$queryGroup = $db->query($sqlGroup);
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
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/disp_user.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div>
    	<?php include($path."include/header.php"); ?>
    </div>
    <div>
    	<?php include($path."include/menu.php"); ?>
    </div>
    <div style="height:45em;">
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="disp_user.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id); ?>">ข้อมูลผู้ใช้ระบบ</a></li>
          <li class="active"><?php echo $txt; ?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12">
        <div  class='groupdata'  >
            <div class="row heading">ข้อมูลผู้ใช้ระบบ / <?php echo $txt; ?></div>
            <form id="frm-input" method="post" action="process/process_user.php">
            	<input name="proc" type="hidden" id="proc" value="<?php echo $proc; ?>">
                <input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
                <input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
            	<input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
                <input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
                <input name="aut_user_id" type="hidden" id="aut_user_id" value="<?php echo $aut_user_id; ?>">
				<input type="hidden" id="flagDup1" name="flagDup1" value="<?php echo  $proc=='edit'?0:1;?>" >
				<input type="hidden" id="flagUser" name="flagUser" value="<?php echo  $proc=='edit'?0:1;?>" >
                <input type="hidden" id="flagEmail" name="flagEmail" value="<?php echo  $proc=='edit'?0:1;?>" >
				<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $per_id_v; ;?>" >
                <div class="row head-form">ข้อมูลการเข้าใช้งานระบบ</div>
                <?php if($proc == 'add'){ ?>
                <div class="row formSep">
					<div class="col-xs-12 col-sm-2"><?php echo $arr_txt['idcard'];?> <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-sm-2">
					<div class="input-group">
							<span id="chkDup1" class="col-xs-9 visible-xs label"></span>
							<input type="text" id="PER_IDCARD" name="PER_IDCARD" class="form-control idcard" onkeyup="chk_idcard('chkDup1','flagDup1','PER_IDCARD','chk_idcard');"  placeholder="<?php echo $arr_txt['idcard'];?>" maxlength="17" value="<?php echo $per_iccard_v; ?>" > 
							<span class="input-group-addon"  onClick="form_load();">
								<span class="glyphicon glyphicon-search"></span>
							</span> 
						</div>
					</div>
					<span id="chkDup1" class="col-sm-2 hidden-xs label"></span>
                    
				</div>
                
				<div class="row formSep">
					<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ชื่อผู้ใช้ <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-sm-2">
						<input id="username" type="text" name="username" onkeyup="chk_idcard('spanUser','flagUser','username','chk_dup');"  class="form-control" placeholder="ชื่อผู้ใช้" value="<?php echo $aut_username; ?>">
						
					</div>
					<span id="spanUser" class="col-sm-2 hidden-xs label"></span>
				</div>
               
                <div class="row formSep">
					<div class="col-xs-12 col-sm-2" style="white-space:nowrap">รหัสผ่าน&nbsp;<span style="color:red;">*</span>&nbsp;</div>
					<div class="col-xs-12 col-sm-2"><input id="password" type="password" name="password" class="form-control" placeholder="รหัสผ่าน" ></div>
				</div>
                <div class="row formSep">
                	<div class="col-xs-12 col-sm-2 " style="white-space:nowrap">ยืนยันรหัสผ่าน&nbsp;<span style="color:red;">*</span>&nbsp;</div>
					<div class="col-xs-12 col-sm-2"><input id="confirm_password" type="password" name="confirm_password" class="form-control" placeholder="ยืนยันรหัสผ่าน" ></div>
                </div>
                <?php }else{ ?>
                <div class="row formSep">
					<div class="col-xs-12 col-sm-2"><?php echo $arr_txt['idcard'];?> <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-sm-2">
						<?php echo get_idCard($per_iccard_v); ?>
                        <input type="hidden" id="PER_IDCARD" name="PER_IDCARD" value="<?php echo $per_iccard_v; ?>" >
					</div>
				</div>
                <div class="row formSep">
					<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ชื่อผู้ใช้ <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-sm-2">
						<?php echo $aut_username; ?>
					</div>
				
				</div>
                <?php } ?>
                <div class="row formSep">
					<div class="col-xs-12 col-sm-2" style="white-space:nowrap">Email : <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-sm-3">
						<input id="email" type="text" name="email" onkeyup="chk_email('spanEmail','flagEmail','email','ChkEmail');" autocomplete="off" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
					</div>
					<span id="spanEmail" class="col-sm-2 hidden-xs label"></span>
				</div>
                <div class="row head-form">ข้อมูลสิทธิ์การเข้าใช้งานระบบ</div>
				<div class="row formSep">
					<div class="col-xs-12 col-sm-2" style="white-space:nowrap">กลุ่มสิทธิ์&nbsp;<span style="color:red;">*</span>&nbsp;</div>
					<div class="col-xs-12 col-sm-3">
						<select name="user_group_id" class="selectbox form-control" id="user_group_id" placeholder="เลือกกลุ่มสิทธิ์">
							<option value=""></option>
							<?php
								while($recGroup = $db->db_fetch_array($queryGroup)){
									$recGroup = array_change_key_case($recGroup,CASE_LOWER);
									$sel = ($recGroup["user_group_id"] == $user_group_id) ? "selected":"";
							?>
							<option value="<?php echo $recGroup["user_group_id"]; ?>" <?php echo $sel; ?>><?php echo text($recGroup["group_name"]); ?></option>
							<?php
								}
							?>
						</select>
					</div>
				</div>
               
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap"><?php echo $arr_txt['active'];?> :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
					<div class="col-xs-12 col-md-10">
						<label ><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS" value="1" <?php echo ($ACTIVE_STATUS=='1'||$ACTIVE_STATUS=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>&nbsp;&nbsp;
						<label ><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($ACTIVE_STATUS=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?></label></div>
				</div>
				<br>
                <div class="row">
					<div class="col-xs-12 col-sm-12" align="center">
						<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
						<button type="button" class="btn btn-default" onClick="self.location.href='disp_user.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
					</div>
				</div>
                <div class="clearfix"></div><br>                                
			</form>
        </div>
    </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>
<!-- Modal -->
<!--div class="modal fade" id="myModal"></div-->
<?php echo form_model('myModelprofile','เลือก ชื่อผู้ใช้งาน');?>
<!-- /.modal -->
