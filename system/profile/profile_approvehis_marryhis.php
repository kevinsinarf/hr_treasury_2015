<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;;
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
$REQUEST_ID=$_POST['REQUEST_ID'];

//DATA NEW
$sql = "SELECT *, CONVERT(DATE,b.REQUEST_DATETIME) as REQUEST_DATETIME FROM PER_FAMILY a 
INNER JOIN PER_REQUEST b ON a.REQUEST_ID = b.REQUEST_ID and a.PER_ID = b.PER_ID 
WHERE b.DELETE_FLAG = '0' AND b.REQUEST_ID = '".$REQUEST_ID."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$PER_ID = $rec['PER_ID'];

//OLD DATA
$sql = "SELECT * FROM PER_FAMILY WHERE DELETE_FLAG = '0' AND ACTIVE_STATUS = '1' AND PER_ID = '".$PER_ID."' AND FAMILY_RELATIONSHIP = '3'";
$query = $db->query($sql);
$data = $db->db_fetch_array($query);
$arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME"); //จังหวัด
$arr_ampr = GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", " ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
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
<script src="js/profile_approvehis_marryhis.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
	<div><?php include($path."include/menu.php");?></div>
	<div class="col-xs-12 col-sm-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			 <li><a href="profile_approvehis.php?<?php echo url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
			<li class="active">ประวัติการสมรส</li>
		</ol>
	</div>
	<div class="col-xs-12 col-sm-12" id="content">
		<div class="groupdata" >
			<?php include ("tab_info.php"); ?>
			<form id="frm-input" method="post" action="process/profile_approvehis_marryhis_process.php" enctype="multipart/form-data">
			<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
			<input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
			<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
			<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
			<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
            <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        	<input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
			<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
			<input type="hidden" id="REQUEST_ID" name="REQUEST_ID" value="<?php echo $REQUEST_ID?>">
            
            <div class="clearfix"></div>
            <div class="row formSep">
                <div class="col-xs-12 col-sm-2">วันที่ขอเปลี่ยนแปลง&nbsp;:&nbsp;</div>
                <div class="col-xs-12 col-sm-4">
                    <?php echo conv_date($rec['REQUEST_DATETIME'],'short'); ?>				
                    <input type="hidden" id="REQUEST_DATETIME" name="REQUEST_DATETIME"  value="<?php echo conv_date($rec['REQUEST_DATETIME']); ?>">
                </div>
            </div>
            
            <div class="clearfix"></div>
            <div class="row formSep">
                <div class="col-xs-12 col-sm-2">วันที่อนุมัติ&nbsp;:&nbsp;<span style="color:red;">*</span></div>
                <div class="col-xs-12 col-sm-2">
                    <div class="input-group">
                        <input type="text" id="REQUEST_APP_DATE" name="REQUEST_APP_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="">
                        <span class="input-group-addon datepicker" for="REQUEST_APP_DATE" >&nbsp;
                            <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                        </span>
                    </div>						
                </div>
            </div>
            
            <div class="panel-group" id="accordion">
                <div class="row head-form">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();">
                            <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                            <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >
                            ข้อมูลส่วนตัวของคู่สมรส
                        </a>
                    </div>
                </div>
                
                <div id="collapse1" class="collapse in">
                    <div class="clearfix"></div>
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2 " style="white-space:nowrap"><?php echo $arr_txt['idcard']; ?>เดิม&nbsp;:&nbsp; &nbsp; </div>
                        <div class="col-xs-12 col-sm-4"><?php echo get_Idcard($data['FAMILY_IDCARD']); ?></div>
                        
                        <div class="col-xs-12 col-sm-2 " style="white-space:nowrap"><?php echo $arr_txt['idcard']; ?>ใหม่&nbsp;:&nbsp; &nbsp; </div>
                        <div class="col-xs-12 col-sm-3"><?php echo get_Idcard($rec['FAMILY_IDCARD']); ?></div>
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['title']; ?>เดิม (<?php echo $arr_txt['th']; ?>) : &nbsp; </div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($arr_prefix[$data['FAMILY_PREFIX_ID']]); ?></div>
                        
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['title']; ?>ใหม่ (<?php echo $arr_txt['th']; ?>) : &nbsp; </div>
                        <div class="col-xs-12 col-sm-2"><?php echo text($arr_prefix[$rec['FAMILY_PREFIX_ID']]); ?></div>
                    </div>
                                
                    <div class="clearfix"></div>
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['title']; ?>เดิม (<?php echo $arr_txt['en'] ;?>) :</div>
                        <div class="col-xs-12 col-sm-4"><?php echo ($arr_prefix_en[$data['FAMILY_PREFIX_ID']])?$arr_prefix_en[$data['FAMILY_PREFIX_ID']]:"-"?></div>
                        
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['title']; ?>ใหม่ (<?php echo $arr_txt['en'] ;?>) :</div>
                        <div class="col-xs-12 col-sm-3"><?php echo ($arr_prefix_en[$rec['FAMILY_PREFIX_ID']])?$arr_prefix_en[$rec['FAMILY_PREFIX_ID']]:"-"?></div>
                    </div>
                                
                    <div class="clearfix"></div>
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['fname']; ?>เดิม (<?php echo $arr_txt['th']; ?>) : &nbsp;</div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($data['FAMILY_FIRSTNAME_TH']); ?></div>
                        
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['fname']; ?>ใหม่ (<?php echo $arr_txt['th']; ?>) : &nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo text($rec['FAMILY_FIRSTNAME_TH']); ?></div>
                    </div>
                                
                    <div class="clearfix"></div>
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['mname']; ?>เดิม (<?php echo $arr_txt['th']; ?>) : </div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($data['FAMILY_MIDNAME_TH']); ?></div>
                        
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['mname']; ?>ใหม่ (<?php echo $arr_txt['th']; ?>) : </div>
                        <div class="col-xs-12 col-sm-3"><?php echo text($rec['FAMILY_MIDNAME_TH']); ?></div>
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['lname']; ?>เดิม (<?php echo $arr_txt['th']; ?>) : &nbsp;</div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($data['FAMILY_LASTNAME_TH']); ?></div>
                        
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['lname']; ?>ใหม่ (<?php echo $arr_txt['th']; ?>) : &nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo text($rec['FAMILY_LASTNAME_TH']); ?></div>
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['fname']; ?>เดิม (<?php echo $arr_txt['en']; ?>) : &nbsp;</div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($data['FAMILY_FIRSTNAME_EN']); ?></div>
                        
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['fname']; ?>ใหม่ (<?php echo $arr_txt['en']; ?>) : &nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo text($rec['FAMILY_FIRSTNAME_EN']); ?></div>
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['mname']; ?>เดิม (<?php echo $arr_txt['en']; ?>) :</div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($data['FAMILY_MIDNAME_EN']); ?></div>
                        
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['mname']; ?>ใหม่ (<?php echo $arr_txt['en']; ?>) :</div>
                        <div class="col-xs-12 col-sm-3"><?php echo text($rec['FAMILY_MIDNAME_EN']); ?></div>
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['lname']; ?>เดิม (<?php echo $arr_txt['en']; ?>) : &nbsp;</div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($data['FAMILY_LASTNAME_EN']); ?></div>
                        
                        <div class="col-xs-12 col-sm-2"><?php echo $arr_txt['lname']; ?>ใหม่ (<?php echo $arr_txt['en']; ?>) : &nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo text($rec['FAMILY_LASTNAME_EN']); ?></div>
                    </div>
                </div>
            </div>
                
                
           <div class="panel-group" id="accordion">
                <div class="row head-form">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onClick="$('.switchPic3').toggle();">
                            <img class="switchPic3" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                            <img class="switchPic3" src="<?php echo $path;?>images/clse.gif" >
                            ข้อมูลการสมรส
                        </a>
                    </div>
                </div>
                
                <div id="collapse3" class="collapse in">     
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2">การสมรสแบบเดิม :</div>
                        <div class="col-xs-12 col-sm-4"><?php echo $arr_marry_type[$data['MARRY_TYPE']]; ?></div>
                        
                        <div class="col-xs-12 col-sm-2">การสมรสแบบใหม่ :</div>
                        <div class="col-xs-12 col-sm-3"><?php echo $arr_marry_type[$rec['MARRY_TYPE']]; ?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2">ลำดับครั้งการสมรสเดิม :</div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($data['MARRY_SEQ']); ?></div>
                        
                        <div class="col-xs-12 col-sm-2">ลำดับครั้งการสมรสใหม่ :</div>
                        <div class="col-xs-12 col-sm-3"><?php echo text($rec['MARRY_SEQ']); ?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2">สถานะของการสมรสเดิม :</div>
                        <div class="col-xs-12 col-sm-4"><?php echo $arr_marry_status[$data['MARRY_STATUS']]; ?></div>
                        
                        <div class="col-xs-12 col-sm-2">สถานะของการสมรสใหม่ :</div>
                        <div class="col-xs-12 col-sm-3"><?php echo $arr_marry_status[$rec['MARRY_STATUS']]; ?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2">เลขที่เดิม&nbsp;:&nbsp;</div>
                        <div class="col-xs-10 col-sm-4"><?php echo text($data['MARRY_NO']);?></div>
                        
                        <div class="col-xs-12 col-sm-2">เลขที่ใหม่&nbsp;:&nbsp;</div>
                        <div class="col-xs-10 col-sm-3"><?php echo text($rec['MARRY_NO']);?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2">ลงวันที่เดิม&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-4"><?php echo conv_date($data['MARRY_DATE'],'short');?></div>
                        
                        <div class="col-xs-12 col-sm-2">ลงวันที่ใหม่&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo conv_date($rec['MARRY_DATE'],'short');?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2">จังหวัดเดิม&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($arr_prov[$data['MARRY_PROV_ID']]);?></div>
                        
                        <div class="col-xs-12 col-sm-2">จังหวัดใหม่&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo text($arr_prov[$rec['MARRY_PROV_ID']]);?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2">อำเภอเดิม&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($arr_ampr[$data['MARRY_AMPR_ID']]);?></div>
                        
                        <div class="col-xs-12 col-sm-2">อำเภอใหม่&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo text($arr_ampr[$rec['MARRY_AMPR_ID']]);?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2">ชื่อสกุลเดิม (ไทย) เดิม&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($data['MARRY_LASTNAME_TH']);?></div>
                        
                        <div class="col-xs-12 col-sm-2">ชื่อสกุลเดิม (ไทย) ใหม่&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo text($rec['MARRY_LASTNAME_TH']);?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2">ชื่อสกุลเดิม (อังกฤษ) เดิม&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($data['MARRY_LASTNAME_EN']);?></div>
                        
                        <div class="col-xs-12 col-sm-2">ชื่อสกุลเดิม (อังกฤษ) ใหม่&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo text($rec['MARRY_LASTNAME_EN']);?></div>
                    </div>
                </div>
            </div>
            
            <div class="panel-group" id="accordion">
                <div class="row head-form">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" onClick="$('.switchPic4').toggle();">
                            <img class="switchPic4" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                            <img class="switchPic4" src="<?php echo $path;?>images/clse.gif" >
                            ข้อมูลการหย่า
                        </a>
                    </div>
                </div>
                
                <div id="collapse4" class="collapse in">
                	<div class="row formSep">
                        <div class="col-xs-12 col-sm-2">เลขที่เดิม&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($data['DIVORCE_NO']);?></div>
                        
                        <div class="col-xs-12 col-sm-2">เลขที่ใหม่&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo text($rec['DIVORCE_NO']);?></div>
                    </div>
                    
                	<div class="row formSep">
                        <div class="col-xs-12 col-sm-2">ลงวันที่เดิม&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-4"><?php echo conv_date($data['DIVORCE_DATE'],'short');?></div>
                        
                        <div class="col-xs-12 col-sm-2">ลงวันที่ใหม่&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo conv_date($rec['DIVORCE_DATE'],'short');?></div>
                    </div>
                    
                	<div class="row formSep">
                        <div class="col-xs-12 col-sm-2">จังหวัดเดิม&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($arr_prov[$data['DIVORCE_PROV_ID']]);?></div>
                        
                        <div class="col-xs-12 col-sm-2">จังหวัดใหม่&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo text($arr_prov[$rec['DIVORCE_PROV_ID']]);?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2">อำเภอเดิม&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-4"><?php echo text($arr_ampr[$data['DIVORCE_AMPR_ID']]);?></div>
                        
                        <div class="col-xs-12 col-sm-2">อำเภอใหม่&nbsp;:&nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo text($arr_ampr[$rec['DIVORCE_AMPR_ID']]);?></div>
                    </div>
                </div>
            </div>
            
            <div class="panel-group" id="accordion">
                <div class="row head-form">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" onClick="$('.switchPic5').toggle();">
                            <img class="switchPic5" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                            <img class="switchPic5" src="<?php echo $path;?>images/clse.gif" >
                            การอนุมัติข้อมูล
                        </a>
                    </div>
                </div>
                
                <div id="collapse5" class="collapse in">
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">การอนุมัติ&nbsp;:&nbsp;<span style="color:red;">*</span></div>
                        <div class="col-xs-12 col-sm-4">
                            <label ><input type="radio" id="REQUEST_RESULT2" name="REQUEST_RESULT" value="2" <?php echo $rec['REQUEST_RESULT']=='2' || $rec['REQUEST_RESULT']=='1' || $rec['REQUEST_RESULT']==''?'checked':'';?> >&nbsp;<?php echo $arr_request_result['2'];?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label ><input type="radio" id="REQUEST_RESULT3" name="REQUEST_RESULT" value="3" <?php echo $rec['REQUEST_RESULT']=='3'?'checked':'';?> >&nbsp;<?php echo $arr_request_result['3'];?></label>
                        </div>
                    </div>
                </div>
            </div>
            
			<div class="row formlast">
				<div class="col-xs-12 col-sm-12" align="center">
                  <button type="button" class="btn btn-primary" onClick="chkApprove();">บันทึก</button>
                  <button type="button" class="btn btn-default" onClick="self.location.href='profile_approvehis.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
				</div>
			</div>
			</form>
		</div>
	</div>
	<div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>