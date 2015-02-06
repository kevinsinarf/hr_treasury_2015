<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT = 6;
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
$PER_ID = $_POST['PER_ID'];
//1 เพิ่มข้อมูล
$star1 = ($proc == 'add' || ($proc == 'edit' && $REQ_STA >= '1') ? "<span style=\"color:red;\">*</span>" : "");
$sty1 = ($proc == 'add' || ($proc == 'edit' && $REQ_STA >= '1') ? "style=\"display:none;\"" : "");
$txt1 = ($proc == 'add' || ($proc == 'edit' && $REQ_STA >= '1') ? "1" : "2");
//2 รับเรื่อง
$star2 = (($proc == 'req' && $REQ_STA == '1') || ($proc == 'edit' && $REQ_STA >= '2') ? "<span style=\"color:red;\">*</span>" : "");
$sty2 = (($proc == 'view' && $REQ_STA >= '2') || ($proc == 'edit' && $REQ_STA >= '2') ? "" : "style=\"display:none;\"");
$txt2 = (($proc == 'view' && $REQ_STA == '1') || ($proc == 'edit' && $REQ_STA >= '2') ? "1" : "2");
//3 จัดทำ
$star3 = (($proc == 'req' && $REQ_STA == '2') || ($proc == 'edit' && $REQ_STA >= '3') ? "<span style=\"color:red;\">*</span>" : "");
$sty3 = (($proc == 'view' && $REQ_STA >= '3') || ($proc == 'edit' && $REQ_STA >= '3') ? "" : "style=\"display:none;\"");
$txt3 = (($proc == 'view' && $REQ_STA == '2') || ($proc == 'edit' && $REQ_STA >= '3') ? "1" : "2");
//4 จ่ายบัตร
$star4 = (($proc == 'req' && $REQ_STA == '3') || ($proc == 'edit' && $REQ_STA >= '4') ? "<span style=\"color:red;\">*</span>" : "");
$sty4 = (($proc == 'view' && $REQ_STA >= '4') ? "" : "style=\"display:none;\"");
$txt4 = (($proc == 'view' && $REQ_STA == '3') || ($proc == 'edit' && $REQ_STA >= '4') ? "1" : "2");
//5 ข้อมูลการขอมีบัตร
$star5 = (($proc == 'view' && $REQ_STA != '4') || ($proc == 'edit' && $REQ_STA >= '4') ? "<span style=\"color:red;\">*</span>" : "");
$sty5 = (($proc == 'view' && $REQ_STA >= '4') || ($proc == 'edit' && $REQ_STA >= '4') ? "" : "style=\"display:none;\"");
$txt5 = ($proc == 'add' || ($proc == 'req' && $REQ_STA <= '3') || ($proc == 'edit' && $REQ_STA <= '4') ? "1" : "2");

$sty1='';
$sty2='';
$sty3='';
$sty4='';
$sty5='';
//POST
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 
if($proc!='add'){
	//DATA
	$sql = "select a.*,b.CARDD_ASSIGN,b.CARDD_EXPIRE,b.CARDD_NO,b.CARDD_SERIAL,per.PREFIX_ID,per.PER_FIRSTNAME_TH,per.PER_MIDNAME_TH,per.PER_LASTNAME_TH,per.LINE_ID,per.ORG_ID_4 
	FROM CARD a LEFT JOIN CARD_DESC b ON a.CARD_ID=b.CARD_ID LEFT JOIN PER_PROFILE per on per.PER_ID=a.PER_ID 
	where a.CARD_ID = '".$CARD_ID."' ";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);

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
//func แสดงข้อมูลชื่อ
$name=Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"],'th');

//Array
$arr_card_type=array(1=>"บัตรประจำตัว",2=>"บัตรแสดงตน/บัตรเข้าออก"); //ประเภทบัตร
$per_a=GetSqlSelectArray("PER_ID", "PREFIX_NAME_TH+''+PER_FIRSTNAME_TH+' '+PER_MIDNAME_TH+' '+PER_LASTNAME_TH as FullName", "PER_PROFILE a INNER JOIN SETUP_PREFIX b ON b.PREFIX_ID=a.PREFIX_ID ", "a.ACTIVE_STATUS = 1 AND a.DELETE_FLAG = 0 and ORG_ID_4 = 49 ", "PER_FIRSTNAME_TH");
$per_a3=$db->get_data_rec("SELECT PER_ID,PREFIX_NAME_TH+''+PER_FIRSTNAME_TH+' '+PER_MIDNAME_TH+' '+PER_LASTNAME_TH as FullName FROM PER_PROFILE a INNER JOIN SETUP_PREFIX b ON b.PREFIX_ID=a.PREFIX_ID INNER JOIN AUT_USER c ON a.PER_ID=c.AUT_PER_ID WHERE a.ACTIVE_STATUS = 1 AND a.DELETE_FLAG = 0 and ORG_ID_4 = 49 and c.AUT_PER_ID='139' ");//ตามผู้ใช้งานระบบ 
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
           <li><a href="per_card_disp.php?<?php echo url2code($link2); ?>">ประวัติการขอรจัดทำบัตร</a></li>
		  <li class="active">ข้อมูลการจัดทำบัตร</li>
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
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onclick="$('.switchPic1').toggle();"><?php echo switchPic($path, "switchPic1", "0"); ?> ข้อมูลรายการหลักของ</a>
                        </div>
                        <div id="collapse1" class="collapse in">
                            <div class="row formSep"> 
                                <div class="col-xs-12 col-md-2 " style="white-space:nowrap">ประเภทบัตร :&nbsp;<?php echo $star1; ?></div>
                                <div class="col-xs-12 col-md-3"><?php echo $txt1== '1' ? GetHtmlSelect("REQUEST_TYPE", "REQUEST_TYPE", $arr_card_type, "ประเภทบัตร", $rec['REQUEST_TYPE'],"","", "", "", "2"):$arr_card_type[$rec['REQUEST_TYPE']]; ?></div>
                                <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap">เหตุผลที่ขอ :&nbsp; <?php echo $star1; ?></div>
                                <div class="col-xs-12 col-md-3"><?php echo ($txt1 == '1') ? GetHtmlSelect("REASON_ID", "REASON_ID", $arr_card_req, "เหตุผลที่ขอ", $rec['REASON_ID'], "", "", "", "", "") : text($arr_card_req[$rec['REASON_ID']]); ?></div>
                            </div>
                            <div class="row formSep"> 
                                <div class="col-xs-12 col-md-2">ผู้ขอมีบัตร :</div>
                                <div class="col-xs-12 col-md-2"><?php echo $name; ?></div>
                           </div> 
                                <div class="row formSep">
                                    <div class="col-xs-12 col-md-2" style="white-space:nowrap"><?php echo $arr_txt['pos_in']; ?> : </div>
                                    <div class="col-xs-12 col-md-3"><span id="d_line"><?php echo text($arr_setup_line[$rec['LINE_ID']]); ?></span></div>
                                    <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap"><?php echo "ระดับส่วน/กลุ่มงาน"; ?> : </div>
                                    <div class="col-xs-12 col-md-3"><span id="d_org"><?php echo text($arr_setup_org[$rec["ORG_ID_4"]]); ?></span></div>
                                </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-md-2 " style="white-space:nowrap">เรื่อง :&nbsp; <?php echo $star1; ?></div>
                                <div class="col-xs-12 col-md-9"><?php if ($txt1 == '1') { ?><input type="text" id="REQUEST_TITLE" name="REQUEST_TITLE" class="form-control" placeholder="เรื่อง" value="<?php echo text($rec['REQUEST_TITLE']); ?>">
                                 <?php } else { echo text($rec['REQUEST_TITLE']); } ?></div>
                            </div>
                            <div class="row formSep">
                                <div class="col-xs-12 col-md-2 " style="white-space:nowrap">เลขที่หนังสือ :&nbsp; </div>
                                <div class="col-xs-12 col-md-2"><?php if ($txt1 == '1') { ?><input type="text" id="REQUEST_NO" name="REQUEST_NO" class="form-control " placeholder="เลขที่หนังสือ" value="<?php echo text($rec['REQUEST_NO']); ?>">
                                <?php } else { echo text($rec['REQUEST_NO']); } ?></div>
                                <div class="col-xs-12 col-md-2 col-md-offset-2" style="white-space:nowrap">ลงวันที่ :&nbsp; </div>
                                <div class="col-xs-12 col-md-2"><?php if ($txt1 == '1') { ?><div class="input-group"><input type="text" class="form-control date" name="REQUEST_DATE" id="REQUEST_DATE"  value="<?php echo $rec['REQUEST_DATE']!=''?conv_date($rec['REQUEST_DATE']):$date_now_default; ?>" placeholder="ลงวันที่"><span class="input-group-addon datepicker" for="REQUEST_DATE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span></div>
                                <?php } else { echo conv_date($rec['REQUEST_DATE'],short); } ?>
                                </div>
                            </div>
                            <div class="row formSep">
                                <div class="col-xs-12 col-md-2" style="white-space:nowrap">รายละเอียด :&nbsp; </div>
                                <div class="col-xs-12 col-md-9"><?php if ($txt1 == '1') { ?><textarea rows="4" id="REQUEST_NOTE" name="REQUEST_NOTE" class="form-control" placeholder="รายละเอียด"><?php echo text($rec['REQUEST_NOTE']); ?></textarea>
                                <?php } else { echo text($rec['REQUEST_NOTE']); } ?></div>
                            </div>
                            <div class="row formSep">
                                <div class="col-xs-12 col-md-2 " style="white-space:nowrap">เลขที่ลงรับสารบรรณ :&nbsp; </div>
                                <div class="col-xs-12 col-md-2"><?php if ($txt1 == '1') { ?><input type="text" id="REQUEST_EOFFICE_NO" name="REQUEST_EOFFICE_NO" class="form-control " placeholder="เลขที่ลงรับสารบรรณ" value="<?php echo text($rec['REQUEST_EOFFICE_NO']); ?>">
                                <?php } else { echo text($rec['REQUEST_EOFFICE_NO']); } ?></div>
                                <div class="col-xs-12 col-md-2 col-md-offset-2" style="white-space:nowrap">วันที่ลงรับสารบรรณ :&nbsp; </div>
                                <div class="col-xs-12 col-md-2"><?php if ($txt1 == '1') { ?><div class="input-group"><input type="text" class="form-control date" name="REQUEST_EOFFICE_DATE" id="REQUEST_EOFFICE_DATE"  value="<?php echo $rec['REQUEST_EOFFICE_DATE']!=''?conv_date($rec['REQUEST_EOFFICE_DATE']):$date_now_default; ?>" placeholder="วันที่ลงรับสารบรรณ"><span class="input-group-addon datepicker" for="REQUEST_EOFFICE_DATE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span></div>
                                <?php } else { echo conv_date($rec['REQUEST_EOFFICE_DATE'],short); }?>
                                </div>
                            </div>
                            <div class="row formSep" style="<?php echo $proc=='add'?'display:none':''?>">
                                <div class="col-xs-12 col-md-2">สถานะจัดทำบัตร : <?php echo $star1; ?></div>
                                <div class="col-xs-12 col-md-2"><?php echo $arr_req_card_status[$rec['CARD_STATUS']]; ?></div>
                            </div>
                      </div>
                      <span <?php echo $sty2; ?>>    
                        <div class="row head-form">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onclick="$('.switchPic2').toggle();"><?php echo switchPic($path, "switchPic2", "0"); ?> ข้อมูลการรับเรื่อง</a>
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
                              <?php /* 
                              <div class="col-xs-12 col-md-2 col-md-offset-1">เลขที่ลงรับกลุ่มงานทะเบียนประวัติและสถิติ : <?php echo $star2; ?></div>
                              <div class="col-xs-12 col-md-2" ><?php if ($txt2 == '1') { echo text($rec['ACCEPT_NO']); ?><input type="hidden" id="ACCEPT_NO" name="ACCEPT_NO" class="form-control number" placeholder="เลขที่ลงรับกลุ่มงานทะเบียนประวัติและสถิติ" value="<?php echo text($rec['ACCEPT_NO']); ?>"><?php
                              } else { echo text($rec['ACCEPT_NO']); } ?></div>
                               */?>
                              <div class="row formSep">
                              <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่ลงรับเข้ากลุ่มทะเบียน :&nbsp; <?php echo $star2; ?></div>
                              <div class="col-xs-12 col-md-2">
                              <?php if ($txt2 == '1') { ?><div class="input-group"><input type="text" class="form-control date" name="ACCEPT_DATE" id="ACCEPT_DATE"  value="<?php echo $rec['ACCEPT_DATE']!=''?conv_date($rec['ACCEPT_DATE']):$date_now_default; ?>" placeholder="วันที่ลงรับเข้ากลุ่มทะเบียน"><span class="input-group-addon datepicker" for="ACCEPT_DATE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                              </div><?php } else { echo conv_date($rec['ACCEPT_DATE'], 'short'); } ?>
                              </div>
                              <div class="col-md-2 col-sm-3 col-md-offset-2">เวลาที่ลงรับ :&nbsp; <?php echo $star2; ?></div>
                              <div class="col-md-1 col-sm-3" ><?php if ($txt2 == '1'){ ?>
                              <select id="ACCEPT_TIME_H" name="ACCEPT_TIME_H" class="selectbox form-control" placeholder="ชั่วโมง">
                              <option value=""></option>
                              <?php for ($i = '0'; $i <= 23; $i++) { ?>
                              <option value="<?php echo strlen($i) == 1 ? "0" . $i : $i; ?>"<?php echo ($i == $ACCEPT_TIME_H ? "selected" : ""); ?>><?php echo strlen($i) == 1 ? "0" . $i : $i; ?></option>
                              <?php } ?>
                              </select>
                              <?php } else {  echo $rec['ACCEPT_TIME']==''?'':$ACCEPT_TIME_H." : ".$ACCEPT_TIME_M." น."; } ?></div>
                              <div class="col-md-1 col-sm-3"><?php if ($txt2 == '1'){ ?>
                              <select id="ACCEPT_TIME_M" name="ACCEPT_TIME_M" class="selectbox form-control" placeholder="นาที">
                              <option value=""></option>
                              <?php for ($i = '0'; $i <= 59; $i++) { ?>
                              <option value="<?php echo strlen($i) == 1 ? "0" . $i : $i; ?>"<?php echo ($i == $ACCEPT_TIME_M ? "selected" : ""); ?>><?php echo strlen($i) == 1 ? "0" . $i : $i; ?></option>
                              <?php } ?>
                              </select>
                              <?php }  ?></div>
                              </div>
                        </div>
                    </span>
                        
                    <span <?php echo $sty3; ?>>    
                        <div class="row head-form">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onclick="$('.switchPic3').toggle();"><?php echo switchPic($path, "switchPic3", "0"); ?> ข้อมูลการจัดทำบัตร</a>
                        </div>
                        <div id="collapse3" class="collapse in">
                          <div class="row formSep">   
                                <div class="col-xs-12 col-md-2">ผู้ที่ต้องจัดทำบัตร : <?php echo $star3; ?></div>
                                <div class="col-xs-12 col-md-3"><?php echo ($txt3 == '1') ? text($per_a3['FullName']).'<input type="hidden" id="MAKE_BY" name="MAKE_BY" value="'.$MAKE.'" >' : text($per_a[$rec['MAKE_BY']]); ?></div>
                                <div class="col-xs-12 col-md-2 col-md-offset-1">ผู้เสนอเรื่อง : <?php echo $star3; ?></div>
                                <div class="col-xs-12 col-md-3"><?php echo ($txt3 == '1') ? GetHtmlSelect("PRESENT_BY", "PRESENT_BY", $per_a, 'ผู้เสนอเรื่อง', $rec['PRESENT_BY'], "", "", '', '', "1") : text($per_a[$rec['PRESENT_BY']]); ?></div>
                          </div>
                          <div class="row formSep">
                              <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่จัดทำเสร็จ :&nbsp; <?php echo $star3; ?></div>
                              <div class="col-xs-12 col-md-2">
                              <?php if ($txt3 == '1') { ?><div class="input-group"><input type="text" class="form-control date" name="MAKE_FINISH_DATE" id="MAKE_FINISH_DATE"  value="<?php echo $rec['MAKE_FINISH_DATE']!=''?conv_date($rec['MAKE_FINISH_DATE']):$date_now_default; ?>" placeholder="วันที่จัดทำเสร็จ"><span class="input-group-addon datepicker" for="MAKE_FINISH_DATE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                              </div><?php } else { echo conv_date($rec['MAKE_FINISH_DATE'], 'short'); } ?>
                              </div>
                              <div class="col-md-2 col-sm-3 col-md-offset-2">เวลาที่จัดทำเสร็จ : <?php echo $star3; ?></div>
                              <div class="col-md-1 col-sm-3" ><?php if ($txt3 == '1'){ ?>
                              <select id="MAKE_FINISH_TIME_H" name="MAKE_FINISH_TIME_H" class="selectbox form-control" placeholder="ชั่วโมง">
                              <option value=""></option>
                              <?php for ($i = '0'; $i <= 23; $i++) { ?>
                              <option value="<?php echo strlen($i) == 1 ? "0" . $i : $i; ?>"<?php echo ($i == $MAKE_FINISH_TIME_H ? "selected" : ""); ?>><?php echo strlen($i) == 1 ? "0" . $i : $i; ?></option>
                              <?php } ?>
                              </select>
                              <?php } else { echo $rec['MAKE_FINISH_TIME']==''?'':$MAKE_FINISH_TIME_H." : ".$MAKE_FINISH_TIME_M." น."; } ?></div>
                              <div class="col-md-1 col-sm-3"><?php if ($txt3 == '1'){ ?>
                              <select id="MAKE_FINISH_TIME_M" name="MAKE_FINISH_TIME_M" class="selectbox form-control" placeholder="นาที">
                              <option value=""></option>
                              <?php for ($i = '0'; $i <= 59; $i++) { ?>
                              <option value="<?php echo strlen($i) == 1 ? "0" . $i : $i; ?>"<?php echo ($i == $MAKE_FINISH_TIME_M ? "selected" : ""); ?>><?php echo strlen($i) == 1 ? "0" . $i : $i; ?></option>
                              <?php } ?>
                              </select>
                              <?php }  ?></div>
                           </div>
                        </div>
                    
                        <div class="row head-form">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" onclick="$('.switchPic4').toggle();"><?php echo switchPic($path, "switchPic4", "0"); ?> ข้อมูลบัตรประจำตัวเจ้าหน้าที่ของรัฐ</a>
                        </div>
                        <div id="collapse4" class="collapse in">
                          <div class="row formSep">   
                                <div class="col-xs-12 col-md-2">วันที่ออกบัตร : <?php echo $star3; ?></div>
                                <div class="col-xs-12 col-md-2"><?php if($txt3=='1'){ ?><div class="input-group"><input type="text" class="form-control date" id="CARDD_ASSIGN" name="CARDD_ASSIGN" value="<?php echo $rec['CARDD_ASSIGN']!=''?conv_date($rec['CARDD_ASSIGN']):$date_now_default; ?>" placeholder="วันที่ออกบัตร"><span class="input-group-addon datepicker" for="CARDD_ASSIGN">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span></div><?php } else { echo conv_date($rec['CARDD_ASSIGN'],'short'); } ?></div>
                                <div class="col-xs-12 col-md-2 col-md-offset-2">วันที่บัตรอายุ : <?php echo $star3; ?></div>
                                <div class="col-xs-12 col-md-2"><?php if($txt3=='1'){ ?><div class="input-group"><input type="text" class="form-control date" id="CARDD_EXPIRE" name="CARDD_EXPIRE" value="<?php echo conv_date($rec['CARDD_EXPIRE']); ?>" placeholder="วันที่บัตรอายุ"><span class="input-group-addon datepicker" for="CARDD_EXPIRE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span></div><?php } else { echo conv_date($rec['CARDD_EXPIRE'],'short'); } ?></div>
                          </div>  
                          <div class="row formSep">   
                                <div class="col-xs-12 col-md-2">หมายเลขบัตร : <?php echo $star3; ?></div>
                                <div class="col-xs-12 col-md-2"><?php if($txt3=='1'){ ?><input  type="hidden" class="form-control" maxlength="20" id="CARDD_NO" name="CARDD_NO" value="<?php echo text($rec['CARDD_NO']); ?>" placeholder="หมายเลขบัตร"><?php echo text($rec['CARDD_NO']); } else { echo text($rec['CARDD_NO']); } ?></div>
                                <div class="col-xs-12 col-md-2 col-md-offset-2">หมายเลข Serial บัตร : </div>
                                <div class="col-xs-12 col-md-2"><?php if($txt3=='1'){ ?><input type="text" class="form-control " maxlength="20" id="CARDD_SERIAL" name="CARDD_SERIAL" value="<?php echo $rec['CARDD_SERIAL']; ?>" placeholder="หมายเลข Serial บัตร"><?php } else { echo text($rec['CARDD_SERIAL']); } ?></div>

                          </div> 
                        </div>
                    </span>
                        <span <?php echo $sty4; ?>>    
                        <div class="row head-form">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" onclick="$('.switchPic5').toggle();"><?php echo switchPic($path, "switchPic5", "0"); ?> ข้อมูลการจ่ายบัตร</a>
                        </div>
                        <div id="collapse5" class="collapse in">
                          <div class="row formSep">   
                                <div class="col-xs-12 col-md-2">ผู้จ่ายบัตร : <?php echo $star4; ?></div>
                                <div class="col-xs-12 col-md-3"><?php echo ($txt4 == '1') ? GetHtmlSelect("DISTRIBUTE_BY", "DISTRIBUTE_BY", $per_a, "ผู้จ่ายบัตร", $rec['DISTRIBUTE_BY'], "", "", "", "", "1") : text($per_a[$rec['DISTRIBUTE_BY']]); ?></div>
                                <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap">ผู้รับบัตร :&nbsp; <?php echo $star4; ?></div>
                                <div class="col-xs-12 col-md-3"><?php if ($txt4 == '1') { ?><input type="text" id="DISTRIBUTE_TO" name="DISTRIBUTE_TO" class="form-control" placeholder="ผู้รับบัตร" value="<?php echo $rec['DISTRIBUTE_TO']!=''||$proc=='edit'?text($rec['DISTRIBUTE_TO']):str_replace('&nbsp;',' ',$name); ?>">
                                 <?php } else { echo text($rec['DISTRIBUTE_TO']); } ?></div>
                          </div>
                          <div class="row formSep">
                              <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่จ่ายบัตร :&nbsp; <?php echo $star4; ?></div>
                              <div class="col-xs-12 col-md-2">
                              <?php if ($txt4 == '1') { ?><div class="input-group"><input type="text" class="form-control date" name="DISTRIBUTE_DATE" id="DISTRIBUTE_DATE"  value="<?php echo $rec['DISTRIBUTE_DATE']!=''?conv_date($rec['DISTRIBUTE_DATE']):$date_now_default; ?>" placeholder="วันที่จ่ายบัตร"><span class="input-group-addon datepicker" for="DISTRIBUTE_DATE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                              </div><?php } else { echo conv_date($rec['DISTRIBUTE_DATE'], 'short'); } ?>
                              </div>
                              <div class="col-md-2 col-sm-3 col-md-offset-2">เวลาที่จ่ายบัตร : <?php echo $star4; ?></div>
                              <div class="col-md-1 col-sm-3" ><?php if ($txt4 == '1'){ ?>
                              <select id="DISTRIBUTE_TIME_H" name="DISTRIBUTE_TIME_H" class="selectbox form-control" placeholder="ชั่วโมง">
                              <option value=""></option>
                              <?php for ($i = '0'; $i <= 23; $i++) { ?>
                              <option value="<?php echo strlen($i) == 1 ? "0" . $i : $i; ?>"<?php echo ($i == $DISTRIBUTE_TIME_H ? "selected" : ""); ?>><?php echo strlen($i) == 1 ? "0" . $i : $i; ?></option>
                              <?php } ?>
                              </select>
                              <?php } else { echo $rec['DISTRIBUTE_TIME']==''?'':$DISTRIBUTE_TIME_H." : ".$DISTRIBUTE_TIME_M." น."; } ?></div>
                              <div class="col-md-1 col-sm-3"><?php if ($txt4 == '1'){ ?>
                              <select id="DISTRIBUTE_TIME_M" name="DISTRIBUTE_TIME_M" class="selectbox form-control" placeholder="นาที">
                              <option value=""></option>
                              <?php for ($i = '0'; $i <= 59; $i++) { ?>
                              <option value="<?php echo strlen($i) == 1 ? "0" . $i : $i; ?>"<?php echo ($i == $DISTRIBUTE_TIME_M ? "selected" : ""); ?>><?php echo strlen($i) == 1 ? "0" . $i : $i; ?></option>
                              <?php } ?>
                              </select>
                              <?php }  ?></div>
                           </div>
                            <div class="row formSep">
                                <div class="col-xs-12 col-md-2" style="white-space:nowrap">หมายเหตุ :&nbsp; </div>
                                <div class="col-xs-12 col-md-9"><?php if ($txt4 == '1') { ?><textarea rows="4" id="CARD_NOTE" name="CARD_NOTE" class="form-control" placeholder="หมายเหตุ"><?php echo text($rec['CARD_NOTE']); ?></textarea>
                                <?php } else { echo text($rec['CARD_NOTE']); } ?></div>
                            </div>
                        </div>
                        </span>
							<div class="row formSep2">
                    <div class="col-xs-12 col-sm-12" align="center">
                     
                        <button type="button" class="btn btn-default" onClick="self.location.href='per_card_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
                    </div>
                </div> 
            </form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>
