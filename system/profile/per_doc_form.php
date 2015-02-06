<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT = 6;
$act=1;
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

//1 เพิ่มข้อมูล
$star1 = ($proc == 'add' || ($proc == 'edit' && $REQ_STA >= '1') ? "<span style=\"color:red;\">*</span>" : "");
$sty1 = ($proc == 'add' || ($proc == 'edit' && $REQ_STA >= '1') ? "style=\"display:none;\"" : "");
$txt1 = ($proc == 'add' || ($proc == 'edit' && $REQ_STA >= '1') ? "1" : "2");
//2 รับเรื่อง
$star2 = (($proc == 'req' && $REQ_STA == '1') || ($proc == 'edit' && $REQ_STA >= '2') ? "<span style=\"color:red;\">*</span>" : "");
$sty2 = (($proc == 'view' && $REQ_STA >= '1') || ($proc == 'edit' && $REQ_STA >= '2') ? "" : "style=\"display:none;\"");
$txt2 = (($proc == 'view' && $REQ_STA == '5') || ($proc == 'edit' && $REQ_STA >= '2') ? "1" : "2");
//3 จัดทำ
$star3 = (($proc == 'req' && $REQ_STA == '2') || ($proc == 'edit' && $REQ_STA >= '3') ? "<span style=\"color:red;\">*</span>" : "");
$sty3 = (($proc == 'view' && $REQ_STA >= '3') || ($proc == 'edit' && $REQ_STA >= '3') ? "" : "style=\"display:none;\"");
$txt3 = (($proc == 'view' && $REQ_STA == '5') || ($proc == 'edit' && $REQ_STA >= '3') ? "1" : "2");
//4 จ่ายบัตร
$star4 = (($proc == 'req' && $REQ_STA == '3') || ($proc == 'edit' && $REQ_STA >= '4') ? "<span style=\"color:red;\">*</span>" : "");
$sty4 = (($proc == 'view' && $REQ_STA >= '4') ? "" : "style=\"display:none;\"");
$txt4 = (($proc == 'view' && $REQ_STA == '5') || ($proc == 'edit' && $REQ_STA >= '4') ? "1" : "2");
//5 ข้อมูลการขอมีบัตร
$star5 = (($proc == 'view' && $REQ_STA != '4') || ($proc == 'edit' && $REQ_STA >= '4') ? "<span style=\"color:red;\">*</span>" : "");
$sty5 = (($proc == 'view' && $REQ_STA >= '4') || ($proc == 'edit' && $REQ_STA >= '4') ? "" : "style=\"display:none;\"");
$txt5 = ($proc == 'add' || ($proc == 'req' && $REQ_STA <= '3') || ($proc == 'edit' && $REQ_STA <= '4') ? "1" : "2");
$sty1='';
$sty2='';
$sty3='';
$sty4='';
$sty5='';
$arr_language = array('1' => 'ไทย', '2' => 'อังกฤษ', '3' => 'ไทยและอังกฤษ');
$per_a=GetSqlSelectArray("PER_ID", "PREFIX_NAME_TH+''+PER_FIRSTNAME_TH+' '+PER_MIDNAME_TH+' '+PER_LASTNAME_TH as FullName", "PER_PROFILE a INNER JOIN SETUP_PREFIX b ON b.PREFIX_ID=a.PREFIX_ID ", "a.ACTIVE_STATUS = 1 AND a.DELETE_FLAG = 0 and ORG_ID_4 = 49 ", "PER_FIRSTNAME_TH");
$per_a3=$db->get_data_rec("SELECT PER_ID,PREFIX_NAME_TH+''+PER_FIRSTNAME_TH+' '+PER_MIDNAME_TH+' '+PER_LASTNAME_TH as FullName FROM PER_PROFILE a INNER JOIN SETUP_PREFIX b ON b.PREFIX_ID=a.PREFIX_ID INNER JOIN AUT_USER c ON a.PER_ID=c.AUT_PER_ID WHERE a.ACTIVE_STATUS = 1 AND a.DELETE_FLAG = 0 and ORG_ID_4 = 49 and c.AUT_PER_ID='139' ");//ตามผู้ใช้งานระบบ
if($proc!='add'){
	//DATA
	$sql = "select * FROM CERTIFICATE a LEFT JOIN CERTIFICATE_PER b ON a.CERT_ID=b.CERT_ID JOIN PER_PROFILE c ON c.PER_ID=a.PER_ID  where a.CERT_ID = '".$CERT_ID."' ";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);

        $MAKE = $rec['MAKE_BY']!=''?$rec['MAKE_BY']:$per_a3['PER_ID'];
        $ACCEPT_TIME_H = $rec['ACCEPT_TIME']!=NULL?substr($rec['ACCEPT_TIME'],0,2):$time_now_h_default;
        $ACCEPT_TIME_M = $rec['ACCEPT_TIME']!=NULL?substr($rec['ACCEPT_TIME'],2,4):$time_now_m_default;
        $MAKE_FINISH_TIME_H = $rec['MAKE_FINISH_TIME']!=NULL?substr($rec['MAKE_FINISH_TIME'],0,2):$time_now_h_default;
        $MAKE_FINISH_TIME_M = $rec['MAKE_FINISH_TIME']!=NULL?substr($rec['MAKE_FINISH_TIME'],2,4):$time_now_m_default;
        $DISTRIBUTE_TIME_H = $rec['DISTRIBUTE_TIME']!=NULL?substr($rec['DISTRIBUTE_TIME'],0,2):$time_now_h_default;
        $DISTRIBUTE_TIME_M = $rec['DISTRIBUTE_TIME']!=NULL?substr($rec['DISTRIBUTE_TIME'],2,4):$time_now_m_default;

        $AC_EX = explode("/", $rec['ACCEPT_NO']);
        $AC_NO1 = $AC_EX[0];
        $AC_NO2 = $AC_EX[1];
        
}else{
$rec = $db->get_data_rec("SELECT PREFIX_ID,PER_FIRSTNAME_TH,PER_MIDNAME_TH,PER_LASTNAME_TH,LINE_ID,ORG_ID_4 FROM PER_PROFILE WHERE PER_ID = '".$PER_ID."' ");     
}
$arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME"); //จังหวัด
$arr_doc_type=GetSqlSelectArray("DOC_TYPE_ID", "DOC_TYPE_NAME_TH", "DOC_TYPE", "TYPE_DOC= '1' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "DOC_TYPE_NAME_TH"); //ประเภทหนังสือรับรอง
$arr_group=GetSqlSelectArray("SPGROUP_ID", "SPGROUP_NAME_TH", "SP_SETUP_POSITION_GROUP", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "SPGROUP_NAME_TH"); //กลุ่มตำแหน่ง
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
<script src="<?php echo $path; ?>bootstrap/js/jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/transition.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/holder.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/collapse.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/dropdown.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/modal.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/carousel.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/respond.min.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/html5shiv.js"></script>
<script src="js/profile_missalhis.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
           <li><a href="per_doc_disp.php?<?php echo url2code($link2); ?>">ประวัติการขอรับหนังสือรับรอง</a></li>
		  <li class="active">ข้อมูลการขอรับหนังสือรับรอง</li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content"> 
        <div class="groupdata">
            <br>
            <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
                <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
                <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        		<input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
                <input type="hidden" id="MISS_ID" name="MISS_ID" value="">
              
        
                <div class="row head-form">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();"><?php echo switchPic($path, "switchPic1", "0"); ?> ข้อมูลรายการหลักของการขอหนังสือรับรองการดำรงตำแหน่ง</a>
			</div>
			<div id="collapse1" class="collapse in">
                                <div class="row formSep">
					<div class="col-xs-12 col-md-2 " style="white-space:nowrap">เลขทะเบียนรับสำนักงานฯ :&nbsp;<?php echo $star1;?> </div>
					<div class="col-xs-12 col-md-2"><?php if ($txt1 == '1') { ?><input type="text" id="REQUEST_EOFFICE_NO" name="REQUEST_EOFFICE_NO" class="form-control " placeholder="เลขทะเบียนรับสำนักงานฯ" value="<?php echo text($rec['REQUEST_EOFFICE_NO']); ?>"><?php } else {echo text($rec['REQUEST_EOFFICE_NO']);}?></div>
					<div class="col-xs-12 col-md-2 col-md-offset-2" style="white-space:nowrap">ลงวันที่ :&nbsp;<?php echo $star1;?> </div>
					<div class="col-xs-12 col-md-2"><?php if ($txt1 == '1') { ?><div class="input-group"><input type="text" class="form-control date" name="REQUEST_EOFFICE_DATE" id="REQUEST_EOFFICE_DATE"  value="<?php echo $rec['REQUEST_EOFFICE_DATE']!=''?conv_date($rec['REQUEST_EOFFICE_DATE']):$date_now_default; ?>" placeholder="ลงวันที่"><span class="input-group-addon datepicker" for="REQUEST_EOFFICE_DATE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span></div><?php } else {echo conv_date($rec['REQUEST_EOFFICE_DATE'], 'short');}?></div>
				</div>
                                <div class="row formSep">
					<div class="col-xs-12 col-md-2 " style="white-space:nowrap">เรื่อง :&nbsp; <?php echo $star1; ?></div>
					<div class="col-xs-12 col-md-9"><?php if ($txt1 == '1') { ?><input type="text" id="REQUEST_TITLE" name="REQUEST_TITLE" class="form-control" placeholder="เรื่อง" value="<?php echo text($rec['REQUEST_TITLE']); ?>"><?php } else {echo text($rec['REQUEST_TITLE']);}?></div>
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" >ภาษา : </div>
					<div class="col-xs-12 col-md-2"><?php echo ($txt1 == '1') ? GetHtmlSelect("REQUEST_LANGUAGE", "REQUEST_LANGUAGE", $arr_language, "", ($proc=='add'?"1":$rec['REQUEST_LANGUAGE']), "onchange=GetLan(this.value)", "", "", "", "2") : $arr_language [$rec['REQUEST_LANGUAGE']]; ?></div>
				</div>
				<div class="row formSep">
					<span id="L1" <?php echo $rec['REQUEST_LANGUAGE']!='2'?'':'hidden' ?>>
						<div class="col-xs-12 col-md-2">จำนวนหนังสือรับรองภาษาไทย : </div>
						<div class="col-xs-12 col-md-2"><?php if ($txt1 == '1') { ?><input type="text" id="REQUEST_TH" name="REQUEST_TH" class="form-control number" placeholder="จำนวนหนังสือรับรองภาษาไทย" maxlength="2" value="<?php echo ($proc=='add'?"1":$rec['REQUEST_TH']);?>"><?php } else {echo text($rec['REQUEST_TH']);}?></div>
						<div class="col-xs-12 col-md-1">ฉบับ</div>
					</span>
					<span id="L2" <?php echo $rec['REQUEST_LANGUAGE']!='1'&&$proc!='add'?'':'hidden' ?>>
						<div id="L2C" class="col-xs-12 col-md-2 <?php echo $rec['REQUEST_LANGUAGE']=='3'?'col-md-offset-1':'' ?>" style="white-space:nowrap">จำนวนหนังสือรับรองภาษาอังกฤษ : </div>
						<div class="col-xs-12 col-md-2"><?php if ($txt1 == '1') { ?><input type="text" id="REQUEST_EN" name="REQUEST_EN" class="form-control number" placeholder="จำนวนหนังสือรับรองภาษาอังกฤษ" maxlength="2" value="<?php echo ($proc=='add'?"1":$rec['REQUEST_EN']);?>"><?php } else {echo text($rec['REQUEST_EN']);}?></div>
						<div class="col-xs-12 col-md-1">ฉบับ</div>
						</span>
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">เหตุผลที่ขอรับหนังสือรับรอง :&nbsp; <?php echo $star1; ?></div>
					<div class="col-xs-12 col-md-3"><?php echo ($txt1 == '1') ? GetHtmlSelect("REASON_ID", "REASON_ID", $arr_doc_req, "เหตุผลที่ขอรับหนังสือรับรอง", $rec['REASON_ID'], "", "", "", "", "") : text($arr_doc_req[$rec['REASON_ID']]); ?></div>
				</div>
				<div class="row formSep"> 
					<div class="col-xs-12 col-md-2">ผู้ขอรับหนังสือรับรองการดำรงตำแหน่ง: </div>
					<div class="col-xs-12 col-md-3"><?php echo $sys_name;?></div>
				</div>
				<span id="PER_DETAIL" class="<?php echo $proc!='add'&&$act=='1'?'':'hidden'?>">
					<div class="row formSep">
						<div class="col-xs-12 col-md-2" style="white-space:nowrap"><?php echo $arr_txt['pos_in']; ?> : </div>
						<div class="col-xs-12 col-md-3"><span id="d_line"><?php echo text($arr_setup_line[$rec['LINE_ID']]); ?></span></div>
						<div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap"><?php echo "ระดับส่วน/กลุ่มงาน"; ?> : </div>
						<div class="col-xs-12 col-md-3"><span id="d_org"><?php echo text($arr_setup_org[$rec["ORG_ID_4"]]); ?></span></div>
					</div>
				</span>
				 <div class="row formSep">
						<div class="col-xs-12 col-md-2" style="white-space:nowrap"><?php echo $arr_txt['pos_in']; ?> : </div>
						<div class="col-xs-12 col-md-3"><span id="d_line"><?php echo text($arr_setup_line[$rec['LINE_ID']]); ?></span></div>
						<div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap"><?php echo "ระดับส่วน/กลุ่มงาน"; ?> : </div>
						<div class="col-xs-12 col-md-3"><span id="d_org"><?php echo text($arr_setup_org[$rec["ORG_ID_4"]]); ?></span></div>
					</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">หมายเหตุ :&nbsp; </div>
					<div class="col-xs-12 col-md-9"><?php if ($txt1 == '1') { ?><textarea rows="4" id="REQUEST_NOTE" name="REQUEST_NOTE" class="form-control" placeholder="หมายเหตุ"><?php echo text($rec['REQUEST_NOTE']); ?></textarea><?php } else {echo text($rec['REQUEST_NOTE']);}?></div>
				</div>
				<div class="row formSep" style="<?php echo $proc=='add'?'display:none':''?>">
					<div class="col-xs-12 col-md-2">สถานะจัดทำหนังสือรับรอง : <?php echo $star1; ?></div>
					<div class="col-xs-12 col-md-2"><?php echo $arr_req_doc_status[$rec['CERT_STATUS']]; ?></div>
				</div>
			</div>
			<span <?php echo $sty2; ?>> 
				<div class="row head-form">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onClick="$('.switchPic2').toggle();"><?php echo switchPic($path, "switchPic2", "0"); ?> ข้อมูลการรับเรื่อง </a>
				</div>
				<div id="collapse2" class="collapse in">
					<div class="row formSep">
						<div class="col-xs-12 col-md-2">ผู้รับเรื่องเข้ากลุ่มงานทะเบียนประวัติและสถิติ :&nbsp; <?php echo $star2; ?></div>
						<div class="col-xs-12 col-md-3"><?php echo ($txt2 == '1') ? GetHtmlSelect("ACCEPT_BY", "ACCEPT_BY", $per_a, 'ผู้รับเรื่องเข้ากลุ่มงานทะเบียนประวัติและสถิติ', $rec['ACCEPT_BY'], "", "", '', '', "1") : text($per_a[$rec['ACCEPT_BY']]); ?></div>
						<div class="col-xs-12 col-md-2 col-md-offset-1">เลขที่ลงรับกลุ่มงานทะเบียนประวัติและสถิติ : <?php echo $star2; ?></div>
							<?php if ($txt2 == '1') { ?>
							<div class="col-xs-12 col-md-1" ><input type="text" id="ACCEPT_NO1" name="ACCEPT_NO1" class="form-control number" placeholder="เลขที่ลงรับกลุ่มงานทะเบียนประวัติและสถิติ" value="<?php echo $AC_NO1; ?>"></div>
							<div class="col-xs-12 col-md-1"><input type="text" id="ACCEPT_NO2" name="ACCEPT_NO2" class="form-control book" placeholder="เลขที่ลงรับกลุ่มงานทะเบียนประวัติและสถิติ" value="<?php echo $AC_NO2; ?>"></div>
							<?php } else { ?>
							<div class="col-xs-12 col-md-3"><?php echo text($rec['ACCEPT_NO']); ?></div>
							<?php } ?>
					</div>
					<div class="row formSep">
						<div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่ลงรับเข้ากลุ่มทะเบียน :&nbsp; <?php echo $star2; ?></div>
						<div class="col-xs-12 col-md-2"><?php if ($txt2 == '1') { ?><div class="input-group"><input type="text" class="form-control date" name="ACCEPT_DATE" id="ACCEPT_DATE"  value="<?php echo $date_now1,'short'; ?>" placeholder="วันที่ลงรับเข้ากลุ่มทะเบียน"><span class="input-group-addon datepicker" for="ACCEPT_DATE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span></div><?php } else {echo conv_date($rec['ACCEPT_DATE'], 'short');}?></div>
						<div class="col-md-2 col-sm-3 col-md-offset-2">เวลาที่ลงรับ :&nbsp; <?php echo $star2; ?></div>
						<div class="col-md-1 col-sm-3" ><?php if ($txt2 == '1') { ?>
							<select id="ACCEPT_TIME_H" name="ACCEPT_TIME_H" class="selectbox form-control" placeholder="ชั่วโมง">
								<option value=""></option>
								<?php for ($i = 0; $i <= 23; $i++) { ?>
									<option value="<?php echo strlen($i) == 1 ? "0" . $i : $i; ?>"<?php echo ($i == ($ACCEPT_TIME_H?$ACCEPT_TIME_H:date('H')) ? "selected" : ""); ?>><?php echo strlen($i) == 1 ? "0" . $i : $i; ?></option>
								<?php } ?>
							</select>
							<?php
								} else {
									echo $rec['ACCEPT_TIME'] == '' ? '' : $ACCEPT_TIME_H . " : " . $ACCEPT_TIME_M . " น.";
								}
						  ?></div>
						<div class="col-md-1 col-sm-3">
							<?php if ($txt2 == '1') { ?>
							<select id="ACCEPT_TIME_M" name="ACCEPT_TIME_M" class="selectbox form-control" placeholder="นาที">
								<option value=""></option>
								<?php for ($i = 0; $i <= 59; $i++) { ?>
									<option value="<?php echo strlen($i) == 1 ? "0" . $i : $i; ?>"<?php echo ($i == ($ACCEPT_TIME_M?$ACCEPT_TIME_M:date('i')) ? "selected" : ""); ?>><?php echo strlen($i) == 1 ? "0" . $i : $i; ?></option>
									<?php } ?>
							</select>
							<?php } ?>
						</div>
					</div>
				</div>
			</span>
			<span <?php echo $sty3; ?>>    
				<div class="row head-form">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onClick="$('.switchPic3').toggle();"><?php echo switchPic($path, "switchPic3", "0"); ?> ข้อมูลการจัดทำหนังสือรับรอง</a>
				</div>
				<div id="collapse3" class="collapse in">
					<div class="row formSep">   
						<div class="col-xs-12 col-md-2">ผู้ที่ต้องจัดหนังสือรับรอง : <?php echo $star3; ?></div>
						<div class="col-xs-12 col-md-3"><?php echo ($txt3 == '1') ? text($per_a3['FullName']).'<input type="hidden" id="MAKE_BY" name="MAKE_BY" value="'.$MAKE.'" >' : text($per_a[$rec['MAKE_BY']]); ?></div>
						<div class="col-xs-12 col-md-2 col-md-offset-1">ผู้เสนอเรื่อง : <?php echo $star3; ?></div>
						<div class="col-xs-12 col-md-3"><?php echo ($txt3 == '1') ? GetHtmlSelect("PRESENT_BY", "PRESENT_BY", $per_a, 'ผู้เสนอเรื่อง', $rec['PRESENT_BY'], "", "", '', '', "1") : text($per_a[$rec['PRESENT_BY']]); ?></div>
					</div>
					<?php //echo text($USER_BY) ; ?>
					<div class="row formSep">
						<div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่จัดทำเสร็จ :&nbsp; <?php echo $star3; ?></div>
						<div class="col-xs-12 col-md-2"><?php if ($txt3 == '1') { ?><div class="input-group"><input type="text" class="form-control date" name="MAKE_FINISH_DATE" id="MAKE_FINISH_DATE"  value="<?php echo $rec['MAKE_FINISH_DATE']!=''?conv_date($rec['MAKE_FINISH_DATE']):$date_now_default; ?>" placeholder="วันที่จัดทำเสร็จ"><span class="input-group-addon datepicker" for="MAKE_FINISH_DATE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span></div><?php } else {echo conv_date($rec['MAKE_FINISH_DATE'], 'short');}?>
						</div>
						<div class="col-md-2 col-sm-3 col-md-offset-2">เวลาที่จัดทำเสร็จ : <?php echo $star3; ?></div>
						<div class="col-md-1 col-sm-3" ><?php if ($txt3 == '1') { ?>
							<select id="MAKE_FINISH_TIME_H" name="MAKE_FINISH_TIME_H" class="selectbox form-control" placeholder="ชั่วโมง">
								<option value=""></option>
							<?php for ($i = 0; $i <= 23; $i++) { ?>
									<option value="<?php echo strlen($i) == 1 ? "0" . $i : $i; ?>"<?php echo ($i == $MAKE_FINISH_TIME_H ? "selected" : ""); ?>><?php echo strlen($i) == 1 ? "0" . $i : $i; ?></option>
							<?php } ?>
							</select>
							<?php
							} else {
								echo $rec['MAKE_FINISH_TIME'] == '' ? '' : $MAKE_FINISH_TIME_H . " : " . $MAKE_FINISH_TIME_M . " น.";
							}
							?></div>
						<div class="col-md-1 col-sm-3"><?php if ($txt3 == '1') { ?>
							<select id="MAKE_FINISH_TIME_M" name="MAKE_FINISH_TIME_M" class="selectbox form-control" placeholder="นาที">
								<option value=""></option>
									<?php for ($i = 0; $i <= 59; $i++) { ?>
									<option value="<?php echo strlen($i) == 1 ? "0" . $i : $i; ?>"<?php echo ($i == $MAKE_FINISH_TIME_M ? "selected" : ""); ?>><?php echo strlen($i) == 1 ? "0" . $i : $i; ?></option>
									<?php } ?>
							</select>
						<?php } ?>
						</div>
					</div>
					<div class="row formSep">
						<span <?php echo $rec['REQUEST_LANGUAGE']!='2'?'':'hidden' ?>>
							<div class="col-xs-12 col-md-2 " style="white-space:nowrap">เลขที่หนังสือรับรองภาษาไทย :&nbsp; </div>
							<div class="col-xs-12 col-md-2"><?php if ($txt3 == '1') { echo $rec['MAKE_NO_TH']; ?><input type="hidden" id="MAKE_NO_TH" name="MAKE_NO_TH" class="form-control " placeholder="เลขที่หนังสือรับรองภาษาไทย" value="<?php echo text($rec['MAKE_NO_TH']); ?>"><?php } else {echo text($rec['MAKE_NO_TH']);}?></div>
						</span>
						<span <?php echo $rec['REQUEST_LANGUAGE']!='1'?'':'hidden' ?>>
							<div class="col-xs-12 col-md-2 <?php echo $rec['REQUEST_LANGUAGE']=='3'?'col-md-offset-2':''?>" style="white-space:nowrap">เลขที่หนังสือรับรองภาษาอังกฤษ :&nbsp; </div>
							<div class="col-xs-12 col-md-2 "><?php if ($txt3 == '1') { echo $rec['MAKE_NO_EN']; ?><input type="hidden" id="MAKE_NO_EN" name="MAKE_NO_EN" class="form-control " placeholder="เลขที่หนังสือรับรองภาษาอังกฤษ" value="<?php echo text($rec['MAKE_NO_EN']); ?>"><?php } else {echo text($rec['MAKE_NO_EN']);}?></div>
						</span>
                    </div>
				</div>
			</span>
			<span <?php echo $sty4; ?>>    
				<div class="row head-form">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse4" onClick="$('.switchPic4').toggle();"><?php echo switchPic($path, "switchPic4", "0"); ?> ข้อมูลการจ่ายหนังสือรับรอง</a>
				</div>
				<div id="collapse4" class="collapse in">
					<div class="row formSep">   
						<div class="col-xs-12 col-md-2">ผู้จ่ายหนังสือรับรอง : <?php echo $star4; ?></div>
						<div class="col-xs-12 col-md-3"><?php echo ($txt4 == '1') ? GetHtmlSelect("DISTRIBUTE_BY", "DISTRIBUTE_BY", $per_a, "ผู้จ่ายหนังสือรับรอง", $rec['DISTRIBUTE_BY'], "", "", "", "", "1") : text($per_a[$rec['DISTRIBUTE_BY']]); ?></div>
						<div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap">ผู้รับหนังสือรับรอง :&nbsp; <?php echo $star4; ?></div>
						<div class="col-xs-12 col-md-3"><?php if ($txt4 == '1') { ?><input type="text" id="DISTRIBUTE_TO" name="DISTRIBUTE_TO" class="form-control" placeholder="ผู้รับหนังสือรับรอง" value="<?php echo $rec['DISTRIBUTE_TO']!=''||$proc=='edit'?text($rec['DISTRIBUTE_TO']):str_replace('&nbsp;',' ',$name); ?>"><?php } else { echo text($rec['DISTRIBUTE_TO']);}?></div>
					</div>
					<div class="row formSep">
						<div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่จ่ายหนังสือรับรอง :&nbsp; <?php echo $star4; ?></div>
						<div class="col-xs-12 col-md-2"><?php if ($txt4 == '1') { ?><div class="input-group"><input type="text" class="form-control date" name="DISTRIBUTE_DATE" id="DISTRIBUTE_DATE"  value="<?php echo $rec['DISTRIBUTE_DATE']!=''?conv_date($rec['DISTRIBUTE_DATE']):$date_now_default; ?>" placeholder="วันที่หนังสือรับรอง"><span class="input-group-addon datepicker" for="DISTRIBUTE_DATE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span></div><?php } else { echo conv_date($rec['DISTRIBUTE_DATE'], 'short');}?></div>
						<div class="col-md-2 col-sm-3 col-md-offset-2">เวลาที่จ่ายหนังสือรับรอง : <?php echo $star4; ?></div>
						<div class="col-md-1 col-sm-3" >
							<?php if ($txt4 == '1') { ?>
							<select id="DISTRIBUTE_TIME_H" name="DISTRIBUTE_TIME_H" class="selectbox form-control" placeholder="ชั่วโมง">
								<option value=""></option>
								<?php for ($i = 0; $i <= 23; $i++) { ?>
									<option value="<?php echo strlen($i) == 1 ? "0" . $i : $i; ?>"<?php echo ($i == $DISTRIBUTE_TIME_H ? "selected" : ""); ?>><?php echo strlen($i) == 1 ? "0" . $i : $i; ?></option>
							   <?php } ?>
							</select>
							<?php } else { echo $rec['DISTRIBUTE_TIME'] == '' ? '' : $DISTRIBUTE_TIME_H . " : " . $DISTRIBUTE_TIME_M . " น.";}?>
						</div>
						<div class="col-md-1 col-sm-3"><?php if ($txt4 == '1') { ?>
								<select id="DISTRIBUTE_TIME_M" name="DISTRIBUTE_TIME_M" class="selectbox form-control" placeholder="นาที">
									<option value=""></option>
										<?php for ($i = 0; $i <= 59; $i++) { ?>
										<option value="<?php echo strlen($i) == 1 ? "0" . $i : $i; ?>"<?php echo ($i == $DISTRIBUTE_TIME_M ? "selected" : ""); ?>><?php echo strlen($i) == 1 ? "0" . $i : $i; ?></option>
										<?php } ?>
								</select>
								<?php } ?></div>
					</div>
					<div class="row formSep">
						<div class="col-xs-12 col-md-2" style="white-space:nowrap">หมายเหตุ :&nbsp; </div>
						<div class="col-xs-12 col-md-9"><?php if ($txt4 == '1') { ?><textarea rows="4" id="CERT_NOTE" name="CERT_NOTE" class="form-control" placeholder="หมายเหตุ"><?php echo text($rec['CERT_NOTE']); ?></textarea><?php } else {echo text($rec['CERT_NOTE']);}?></div>
					</div>
				</div>
			</span>
			<?php 
			//ประวัติการดำรงตำแหน่ง
			for($c=6; $c<=($act=='2'?"10":"6"); $c++){
				if($c==6){
					$h_pos=($act=='2'?"ประเภทสมาชิกสภาผู้แทนราษฎร แบบแบ่งเขต":"ข้อมูลการดำรงตำแหน่ง");
					if($act=='1'){
						$s_table="PER_PROFILE";
						$selet = "*";
						$s_cond=" DELETE_FLAG='0' and PER_ID='".$PER_ID."' ";
						$s_order=" order by PER_ID DESC";
					}elseif($act=='2'){
						$s_table="SS_SAPA_POSITION";
						$selet = "*, convert(varchar, SSP_PROMISE_DATE, 21) as SSP_PROMISE_DATE";
						$s_cond="DELETE_FLAG='0' and SS_ID='".$rec[$id]."' and SS_TYPE_ID='1' ";
						$s_order=" order by SSP_ID DESC";
					}elseif($act=='5'){
						$SAPA_ID=($_POST['SAPA_ID']!=''?$_POST['SAPA_ID']:@array_search(max($arr_sapa),$arr_sapa));
						$selet = " a.*,c.PREFIX_ID,c.SS_FIRSTNAME_TH,c.SS_MIDNAME_TH,c.SS_LASTNAME_TH";
						$s_table="V_SP_LIST a LEFT JOIN SS_SAPA_POSITION b ON a.SSP_ID=b.SSP_ID and b.SAPA_ID='".$SAPA_ID."'
						LEFT JOIN SS_PROFILE c ON b.SS_ID=c.SS_ID";
						$s_cond="a.ACTIVE_STATUS='1' and a.DELETE_FLAG='0' and a.SP_ID='".$rec[$id]."' ";
						$s_order=" order by a.SSP_ID DESC";
					}else{#04/05/2557
						$s_table="V_SP_LIST";
						$selet = "*";
						$s_cond="ACTIVE_STATUS='1' and DELETE_FLAG='0' and SP_ID='".$SP_ID."' ";
						$s_order=" order by SP_ID DESC";
					}
				}elseif($c==7){
					$h_pos="ประเภทสมาชิกสภาผู้แทนราษฎร แบบบัญชีรายชื่อ";
					$s_table="SS_SAPA_POSITION";
					$selet = " *, convert(varchar, SSP_PROMISE_DATE, 21) as SSP_PROMISE_DATE ";
					$s_cond="DELETE_FLAG='0' and SS_ID='".$rec[$id]."' and SS_TYPE_ID='7'";
					$s_order=" order by SSP_ID DESC";
				}elseif($c==8){
					$h_pos="การดำรงตำแหน่งทางการเมือง";
					$selet = "*";
					$s_table="SS_POLITICSHIS";
					$s_cond="DELETE_FLAG='0' and SS_ID='".$rec[$id]."'";
				}elseif($c==9){
					$h_pos="การดำรงตำแหน่งในคณะกรรมาธิการสามัญ";
					$s_table="SS_POSITIONHIS";
					$selet = "*";
					$s_cond=" ACTIVE_STATUS='1' and DELETE_FLAG='0' and SS_ID='".$rec[$id]."' and POSHIS_TYPE='1' and SSCOMT_ID='1' ";
				}elseif($c==10){
					$h_pos="การดำรงตำแหน่งในคณะกรรมาธิการวิสามัญ";
					$s_table="SS_POSITIONHIS";
					$selet = "*";
					$s_cond="ACTIVE_STATUS='1' and DELETE_FLAG='0' and SS_ID='".$rec[$id]."' and POSHIS_TYPE='1' and SSCOMT_ID='2' ";
				}
				//sql_pos
				$sql_pos=" select ".$selet." from ".$s_table." where ".$s_cond.$s_order; //exit();
				$query_pos=$db->query($sql_pos);
				$nums=$db->db_num_rows($query_pos);
			?>
			<div class="row head-form"> 
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $c;?>" onClick="$('.switchPic<?php echo $c;?>').toggle();"><?php echo switchPic($path, "switchPic".$c, "0"); ?> <?php echo $h_pos;?></a>
			</div>
			<div id="collapse<?php echo $c;?>" class="collapse in">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover table-condensed">
						<thead>
							<tr class="bgHead">
								<th width="8%"><div align="center"><strong><input type="checkbox" id="allchk" name="allchk" value="1" onClick="allChk();"></strong> เลือก </div></th>
								<th width="35%"><div align="center"><strong>รายการ</strong></div></th>
								<?php if($act=='1'){?><th width="57%"><div align="center"><strong>ข้อมูล</strong></div></th><?php }?>
							</tr>
						</thead>
						<tbody id="t_detail<?php echo $c;?>">
						<?php
						if($nums>0){
							$i=1;
							while($rec2=$db->db_fetch_array($query_pos)){
                                                            
								if($act==1){//บุคลากรภายในสำนักงานฯ
									for($x=1; $x<=17; $x++){
										//detail
										$de1=$arr_txt['pos_no'];
										$de6="สำนัก/กลุ่ม";
										$de13="เงินเพิ่มการครองชีพชั่วคราว";
										$de15="ความประพฤติ";
										$de16="วันที่บรรจุ";
										$de17="วันที่ออกจากราชการ";
										if($rec2['POSTYPE_ID']=='1'){
											$de2="ประเภทตำแหน่ง";
											$de3="ระดับ";
											$de4="ตำแหน่งในสายงาน";
											$de5="ตำแหน่งในการบริหาร";
											$de7="กลุ่มงาน";
											$de8="เงินเดือน";
											$de9="เงินประจำตำแหน่ง";
											$de10="เงินค่าตอบแทนนอกเหนือเงินเดือน";
											$de11="ค่าตอบแทนพิเศษ (กรณีเงินเดือนเต็มขั้น)";
											$de12="เงินค่าตอบแทนพิเศษของข้าราชการรัฐสภาสามัญ";
										}elseif($rec2['POSTYPE_ID']=='3'){
											$de2="ประเภทพนักงานราชการ";
											$de3="ประเภทกลุ่มงาน";
											$de4="ตำแหน่ง";
											$de8="ค่าตอบแทน";
											$de11="ค่าตอบแทนพิเศษ (กรณีค่าตอบแทนเต็มขั้น)";
											$de12="เงินค่าตอบแทนพิเศษของพนักงานราชการ";
										}elseif($rec2['POSTYPE_ID']=='5'){
											$de2="กลุ่มงาน";
											$de3="ระดับ";
											$de4="ตำแหน่ง";
											$de7="กลุ่มงาน";
											$de8="ค่าจ้าง";
											$de11="ค่าตอบแทนพิเศษ (กรณีค่าจ้างเต็มขั้น)";
											$de12="เงินค่าตอบแทนพิเศษของลูกจ้างประจำ";
											$de14="ค่าตอบแทนพิเศษจากการประเมิน (พนักงานราชการ)";
										}
										//data
										$data1=$rec2['POS_NO'].'<input type="hidden" id="POS_NO" name="POS_NO" value="'.$rec2['POS_NO'].'">';
										$data2=text($arr_pos_type[$rec2['TYPE_ID']]).'<input type="hidden" id="TYPE_ID" name="TYPE_ID" value="'.$rec2['TYPE_ID'].'">';
										$data3=text($arr_pos_level[$rec2['LEVEL_ID']]).'<input type="hidden" id="LEVEL_ID" name="LEVEL_ID" value="'.$rec2['LEVEL_ID'].'">';
										$data4=text($arr_pos_line[$rec2['LINE_ID']]).'<input type="hidden" id="LINE_ID" name="LINE_ID" value="'.$rec2['LINE_ID'].'">';
										$data5=text($arr_type_manage[$rec2['MANAGE_ID']]).'<input type="hidden" id="MANAGE_ID" name="MANAGE_ID" value="'.$rec2['MANAGE_ID'].'">';
										$data6=($rec['ORG_ID_3']?text($arr_setup_org[$rec2['ORG_ID_3']]):"-").'<input type="hidden" id="ORG_ID_3" name="ORG_ID_3" value="'.$rec2['ORG_ID_3'].'">';
										$data7=($rec2['ORG_ID_4']?text($arr_setup_org[$rec2['ORG_ID_4']]):"-").'<input type="hidden" id="ORG_ID_4" name="ORG_ID_4" value="'.$rec2['ORG_ID_4'].'">';
										$data8=($rec2['POS_SALARY']?number_format($rec2['POS_SALARY'],2):"-").'<input type="hidden" id="POS_SALARY" name="POS_SALARY" value="'.$rec2['POS_SALARY'].'">';
										$data9=($rec2['POS_SALARY_POSITION']?number_format($rec2['POS_SALARY_POSITION'],2):"-").'<input type="hidden" id="POS_SALARY_POSITION" name="POS_SALARY_POSITION" value="'.$rec2['POS_SALARY_POSITION'].'">';
										$data10=($rec2['POS_COMPENSATIVE_1']?number_format($rec2['POS_COMPENSATIVE_1'],2):"-").'<input type="hidden" id="POS_COMPENSATIVE_1" name="POS_COMPENSATIVE_1" value="'.$rec2['POS_COMPENSATIVE_1'].'">';
										$data11=($rec2['POS_COMPENSATIVE_2']?number_format($rec2['POS_COMPENSATIVE_2'],2):"-").'<input type="hidden" id="POS_COMPENSATIVE_2" name="POS_COMPENSATIVE_2" value="'.$rec2['POS_COMPENSATIVE_2'].'">';
										$data12=($rec2['POS_COMPENSATIVE_3']?number_format($rec2['POS_COMPENSATIVE_3'],2):"-").'<input type="hidden" id="POS_COMPENSATIVE_3" name="POS_COMPENSATIVE_3" value="'.$rec2['POS_COMPENSATIVE_3'].'">';
										$data13=($rec2['POS_COMPENSATIVE_4']?number_format($rec2['POS_COMPENSATIVE_4'],2):"-").'<input type="hidden" id="POS_COMPENSATIVE_4" name="POS_COMPENSATIVE_4" value="'.$rec2['POS_COMPENSATIVE_4'].'">';
										$data14=($rec2['POS_COMPENSATIVE_6']?number_format($rec2['POS_COMPENSATIVE_6'],2):"-").'<input type="hidden" id="POS_COMPENSATIVE_6" name="POS_COMPENSATIVE_6" value="'.$rec2['POS_COMPENSATIVE_6'].'">';
										$data15='<textarea id="CERTPER_BEHAVIOR" name="CERTPER_BEHAVIOR" class="form-control" placeholder="ความประพฤติ" cols="100" rows="3" ></textarea><br>
										<div class="col-md-12">แนบไฟล์ :</div>
										<div class="col-md-8"><input type="file" id="CERTPER_BEHAVIOR_FILE" name="CERTPER_BEHAVIOR_FILE" class="form-control" value=""></div>';
										$data16=conv_date($rec2['PER_DATE_ENTRANCE'],'short');
										$data17=conv_date($rec2['PER_DATE_RESIGN'],'short');
										
										if(${'de'.$x}!=''){
											echo "
											<tr>
												<td align=\"center\">
                                                                                                        
													<input type=\"hidden\" id=\"POS_TEXT".$c.'_'.$x."\" name=\"POS_TEXT[".$c.'_'.$x."]\" value=\"".$pos_name."\">
													<input type=\"checkbox\" id=\"chk".$c.'_'.$x."\" name=\"chk[".$c.'_'.$x."]\" value=\"1\" ".($rec['CERTPER_CONTROL'][$x-1]=='1'||$rec['CERTSS_CONTROL'][$x-1]=='1'?"checked":"").">
												</td>
												<td align=\"left\">".${'de'.$x}."</td>
												<td align=\"left\">".${'data'.$x}."</td>
											</tr>
											";
										}
									}
								}else if($act==2){//สส และอดีต สส
									if($c==6){//ประเภทสมาชิกสภาผู้แทนราษฎร แบบแบ่งเขต
										$pos_name=text($arr_prov[$rec2['PROV_ID']])." ตั้งแต่วันที่ ".conv_date($rec2['SSP_PROMISE_DATE'],'short')." ถึง".($rec2['SSP_TERMINATE_DATE']?" ".conv_date($rec2['SSP_TERMINATE_DATE'],'short'):"ปัจจุบัน ได้รับเงินประจำตำแหน่ง ".number_format($rec2['SSP_POSITION'])." บาทและเงินเพิ่ม ".number_format($rec2['SSP_MORE'])." บาท");
										$wh_ss = " AND POLHIS_ID IS NULL AND POSHIS_ID IS NULL";
									}else if($c==7){//ประเภทสมาชิกสภาผู้แทนราษฎร แบบบัญชีรายชื่อ
										$pos_name="ตั้งแต่วันที่ ".conv_date($rec2['SSP_PROMISE_DATE'],'short')." ถึง".($rec2['SSP_TERMINATE_DATE']?" ".conv_date($rec2['SSP_TERMINATE_DATE'],'short'):"ปัจจุบัน ได้รับเงินประจำตำแหน่ง ".number_format($rec2['SSP_POSITION'])." บาทและเงินเพิ่ม ".number_format($rec2['SSP_MORE'])." บาท");
										$wh_ss = " AND POLHIS_ID IS NULL AND POSHIS_ID IS NULL";
									}else if($c==8){//ตำแหน่งทางการเมือง
										$pos_name=text($arr_type_pol[$rec2['POLPOS_ID']])." ตั้งแต่วันที่ ".conv_date($rec2['ASSIGN_DATE'],'short')." ถึง".($rec2['RESIGN_DATE']?" ".conv_date($rec2['RESIGN_DATE'],'short'):"ปัจจุบัน");
											$wh_ss = " AND POLHIS_ID IS NOT NULL AND POSHIS_ID IS NULL";
									}else if($c==9){//ตำแหน่งทางการเมือง
										$pos_name=text($arr[$rec2['SSCOM_ID']]);
										$wh_ss = " AND POLHIS_ID IS  NULL AND POSHIS_ID IS NOT  NULL";
									}else if($c==10){//ตำแหน่งในคณะกรรมาธิการวิสามัญ
										$pos_name=text($arr[$rec2['SSCOM_ID']]);
										$wh_ss = " AND POLHIS_ID IS  NULL AND POSHIS_ID IS  NOT NULL";
									}
										//เช็คดีฟอล
										$chk_ss = $db->db_num_rows($db->query("SELECT CERTSS_ID  FROM CERTIFICATE_SS WHERE CERT_ID = '".$CERT_ID."' AND SSP_ID = '".$rec2['SSP_ID']."' {$wh_ss}  "));
                                                                       
									}else{
									if($rec2['RESIGN_SDATE']){
										$before="เคยเป็น"; 
										$salary="";
										$after=conv_date($rec2['RESIGN_SDATE'],'short');
									}else{
										$before=""; 
										$salary=" มีเงินเดือน ".number_format($rec2['SPMAN_SALARY'],2)." บาท เงินประจำตำแหน่ง ".number_format($rec2['SPMAN_SALARY_POSITION'],2)." บาท";
										$after="ปัจจุบัน";
									}
								
									if($act==3){//ข้าราชการรัฐสภาฝ่ายการเมือง
										$pos_name=$before.text($rec2['SPPOSTYPE_NAME_TH'])."ของ".text($rec2['SPGROUP_NAME_TH'])." ตำแหน่ง".text($rec2['SPPOS_NAME_TH']).$salary."  ตั้งแต่วันที่ ".conv_date($rec2['ASSIGN_SDATE'],'short')." ถึง".$after;
									}else if($act==4){//คณะทำงานทางการเมือง
										$pos_name=$before.text($rec2['SPPOSTYPE_NAME_TH'])."ของ".text($rec2['SPGROUP_NAME_TH'])." ตำแหน่ง".text($rec2['SPPOS_NAME_TH']).$salary."  ตั้งแต่วันที่ ".conv_date($rec2['ASSIGN_SDATE'],'short')." ถึง".$after;
									}else if($act==5){//ผู้ปฏิบัติงานให้ สส
										//สส ที่ปฏิบัติงานให้
										$name=Showname($rec2["PREFIX_ID"],$rec2["SS_FIRSTNAME_TH"],$rec2["SS_MIDNAME_TH"],$rec2["SS_LASTNAME_TH"]);
								 
										$pos_name=$before.text($rec2['SPPOSTYPE_NAME_TH'])." (".$name.") "." ตำแหน่ง" .text($rec2['SPPOS_NAME_TH']).$salary."  ตั้งแต่วันที่ ".conv_date($rec2['ASSIGN_SDATE'],'short')." ถึง".$after;
									}else if($act==6){//คณะกรรมาธิการ
										$pos_name=$before.text($rec2['SSCOM_NAME_TH'])." ตำแหน่ง".text($rec2['SSCOMP_NAME_TH']).$salary."  ตั้งแต่วันที่ ".conv_date($rec2['ASSIGN_SDATE'],'short')." ถึง".$after;
									}
										//เช็คดีฟอล
										$chk_sp = $db->db_num_rows($db->query("SELECT CERTSP_ID  FROM CERTIFICATE_SP WHERE DELETE_FLAG = '0' AND CERT_ID = '".$CERT_ID."' AND SPMAN_ID = '".$rec2['SPMAN_ID']."'"));
								} 
								
								if($act>1){
									echo "
									<tr><input type=\"hidden\" id=\"SSP_ID".$c.'_'.$i."\" name=\"SSP_ID[".$c.'_'.$i."]\" value=\"".$rec2['SSP_ID']."\">
										<input type=\"hidden\" id=\"POLHIS_ID".$c.'_'.$i."\" name=\"POLHIS_ID[".$c.'_'.$i."]\" value=\"".$rec2['POLHIS_ID']."\">
										<input type=\"hidden\" id=\"POSHIS_ID".$c.'_'.$i."\" name=\"POSHIS_ID[".$c.'_'.$i."]\" value=\"".$rec2['POSHIS_ID']."\">
										<input type=\"hidden\" id=\"SPMAN_ID".$c.'_'.$i."\" name=\"SPMAN_ID[".$c.'_'.$i."]\" value=\"".$rec2['SPMAN_ID']."\">
										<td align=\"center\"><input type=\"checkbox\" id=\"chk".$c.'_'.$i."\" name=\"chk[".$c.'_'.$i."]\" value=\"1\" ".($chk_ss>'0'||$chk_sp>'0'?'checked':'')." > </td>
										<td align=\"left\">".$pos_name."<input type=\"hidden\" id=\"POS_TEXT".$c.'_'.$i."\" name=\"POS_TEXT[".$c.'_'.$i."]\" value=\"".$pos_name."\"></td>
									</tr>";
								}
								$i++;
							}
						}else{
							echo "<tr><td align=\"center\" colspan=\"3\">ไม่พบข้อมูล</td></tr>";
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
			<?php }?>
			<!--<div class="row head-form">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse5" onclick="$('.switchPic5').toggle();"><?php echo switchPic($path, "switchPic5", "0"); ?> กรณีใช้ค้ำประกันตัวผู้ต้องหา</a>
			</div>
			<div id="collapse5" class="collapse in">
				<div class="row formSep">
					<div class="col-xs-12 col-md-2 " style="white-space:nowrap">ศาล/สถานีตำรวจ :&nbsp; </div>
					<div class="col-xs-12 col-md-9"><input type="text" id="GUARANTEE_PLACE" name="GUARANTEE_PLACE" class="form-control" placeholder="ศาล/สถานีตำรวจ" value="<?php echo text($rec['GUARANTEE_PLACE'])?>"></div>
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2">ประเภทคดี :&nbsp; </div>
					<div class="col-xs-12 col-md-3 <?php echo $a1 ?> "><?php echo GetHtmlSelect("GUARANTEE_TYPE", "GUARANTEE_TYPE", $a, "ประเภทคดี", $rec['GUARANTEE_TYPE'], "", "", '', '200', "2"); ?></div>
					<div class="col-xs-12 col-md-2 col-md-offset-1">เลขที่คดี : </div>
					<div class="col-xs-12 col-md-3"><input type="text" id="GUARANTEE_NO" name="GUARANTEE_NO" class="form-control number" placeholder="เลขที่คดี" value="<?php echo $rec['GUARANTEE_NO'];?>"></div>
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่เริ่มภาระผูกพัน :&nbsp; </div>
					<div class="col-xs-12 col-md-2"><div class="input-group"><input type="text" class="form-control date" name="GUARANTEE_SDATE" id="GUARANTEE_SDATE"  value="<?php echo conv_date($rec['GUARANTEE_SDATE']); ?>" placeholder="วันที่เริ่มภาระผูกพัน"><span class="input-group-addon datepicker" for="GUARANTEE_SDATE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span></div></div>
					<div class="col-xs-12 col-md-2 col-md-offset-2" style="white-space:nowrap">แนบไฟล์ (เอกสารคดี) :&nbsp; </div>
					<div class="col-xs-12 col-md-3"><input type="file" id="GUARANTEE_SFILE" name="GUARANTEE_SFILE" class="form-control number"  value="">
					<input type="hidden" id="old_filename1" name="old_filename1" value="<?php echo $rec1["GUARANTEE_SFILE"]; ?>"></div>
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">วงเงินค้ำประกัน :&nbsp; </div>
					<div class="col-xs-12 col-md-2"><input type="text" id="GUARANTEE_MONEY" name="GUARANTEE_MONEY" class="form-control number" placeholder="วงเงินค้ำประกัน" onBlur="NumberFormat(this);" value="<?php echo $rec['GUARANTEE_MONEY']?>"></div>
					<div class="col-xs-12 col-md-2 col-md-offset-2" style="white-space:nowrap">สถานะของการโดนบังคับคดี :&nbsp; </div>
					<div class="col-xs-12 col-md-3">
						<label><input type="radio" id="GUARANTEE_RESULT1" name="GUARANTEE_RESULT"  value="1" <?php echo $rec['GUARANTEE_RESULT']=='1'?'checked':''; ?>>  มีการบังคับคดี</label>&nbsp;&nbsp;
						<label><input type="radio" id="GUARANTEE_RESULT2" name="GUARANTEE_RESULT"  value="2" <?php echo $rec['GUARANTEE_RESULT']=='2'||$rec['GUARANTEE_RESULT']==''?'checked':''; ?>> ไม่มีการบังคับคดี</label>
					</div>
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่พ้นภาระผูกพัน :&nbsp; </div>
					<div class="col-xs-12 col-md-2"><div class="input-group"><input type="text" class="form-control date" name="GUARANTEE_EDATE" id="GUARANTEE_EDATE"  value="<?php echo conv_date($rec['GUARANTEE_EDATE']); ?>" placeholder="วันที่พ้นภาระผูกพัน"><span class="input-group-addon datepicker" for="GUARANTEE_EDATE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span></div></div>
					<div class="col-xs-12 col-md-2 col-md-offset-2" style="white-space:nowrap">แนบไฟล์ (เอกสารพ้นภาระผูกพัน) :&nbsp; </div>
					<div class="col-xs-12 col-md-3"><input type="file" id="GUARANTEE_EFILE" name="GUARANTEE_EFILE" class="form-control number"  value=""><input type="hidden" id="old_filename2" name="old_filename2" value="<?php echo $rec1["GUARANTEE_EFILE"]; ?>"></div>
				</div>
			</div>-->
			<div class="row formSep2">
				<div class="col-xs-12 col-sm-12" align="center">
					<button type="button" class="btn btn-default" onClick="self.location.href = 'per_doc_disp.php?<?php echo url2code($link2); ?>';">ยกเลิก</button>                    
                </div>
			</div>
            </form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>
