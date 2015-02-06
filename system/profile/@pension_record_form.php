<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;
$paramlink = url2code($link);

//POST
$S_PENSION_IDCARD = $_POST['S_PENSION_IDCARD'];
$PENSION_ID = $_POST['PENSION_ID'];

$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 

if($proc == 'add'){
	if($S_PENSION_IDCARD != ''){
		$query = $db->query("SELECT A.PENSION_IDCARD, A.PER_ID, B.PREFIX_ID, PREFIX_NAME_TH, PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH, POSTYPE_NAME_TH,
							 PER_GENDER, PER_DATE_BIRTH, PER_DATE_OCCUPLY, PENSION_DATE_ANNIVERSARY, PER_DATE_RETIRE, PER_DATE_RESIGN, PER_STATUS, GPF_STATUS
							 FROM PENSION_MAIN A JOIN PER_PROFILE B ON B.PER_IDCARD = A.PENSION_IDCARD 
							 JOIN SETUP_POSITION_TYPE C ON C.POSTYPE_ID = A.POSTYPE_ID
							 JOIN SETUP_PREFIX D ON D.PREFIX_ID = B.PREFIX_ID
							 WHERE PENSION_IDCARD = '".str_replace("-","",$S_PENSION_IDCARD)."' AND B.PENSION_STATUS = '1'");
		$rec = $db->db_fetch_array($query);
		$PENSION_IDCARD = $rec['PENSION_IDCARD'];
		$PER_ID = $rec['PER_ID'];
		$PER_NAME = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
		$POSTYPE_NAME_TH = $rec['POSTYPE_NAME_TH'];
		$PER_GENDER = ($rec['PER_GENDER'] == 1) ? "ชาย" : "หญิง";
		$PER_DATE_BIRTH = conv_date($rec['PER_DATE_BIRTH'],'short');
		$PER_DATE_OCCUPLY = conv_date($rec['PER_DATE_OCCUPLY'],'short');
		$PENSION_DATE_ANNIVERSARY = conv_date($rec['PENSION_DATE_ANNIVERSARY'],'short');
		$PER_DATE_RETIRE = conv_date($rec['PER_DATE_RETIRE'],'short');
		$PER_DATE_RESIGN = conv_date($rec['PER_DATE_RESIGN'],'short');
		$PER_STATUS = $arr_per_status[$rec['PER_STATUS']];
		$GPF_STATUS = $arr_gpf[$rec['GPF_STATUS']];
		//$PER_DATE_25 = conv_date(date("Y-m-d", mktime(0,0,0,substr($rec['PER_DATE_OCCUPLY'],5,2),substr($rec['PER_DATE_OCCUPLY'],8,2),substr($rec['PER_DATE_OCCUPLY'],0,4)+25)));
		
		$PENSION_RECEIVE_PREFIX = $rec['PREFIX_NAME_TH'];
		$PENSION_RECEIVE_FIRSTNAME_TH = $rec['PER_FIRSTNAME_TH'];
		$PENSION_RECEIVE_MIDNAME_TH = $rec['PER_MIDNAME_TH'];
		$PENSION_RECEIVE_LASTNAME_TH = $rec['PER_LASTNAME_TH'];
		$PENSION_TYPE_RECEIVE = 1;
		$PENSION_RECEIVE_IDCARDS = str_replace("-","",$S_PENSION_IDCARD);
	}
}else{
	$query = $db->query("SELECT A.PENSION_IDCARD, A.PER_ID, B.PREFIX_ID, PREFIX_NAME_TH, PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH,
						 POSTYPE_NAME_TH, PER_GENDER, PER_DATE_BIRTH, PER_DATE_OCCUPLY, PENSION_DATE_ANNIVERSARY, PER_DATE_RETIRE, PER_DATE_RESIGN, PER_STATUS, GPF_STATUS, 
						 PENSION_TYPE_REQUEST_CIVIL, PENSION_TYPE_PENSION, PENSION_TYPE_RECEIVE, PENSION_RECEIVE_IDCARDS, PENSION_RECEIVE_PREFIX,
						 PENSION_RECEIVE_FIRSTNAME_TH, PENSION_RECEIVE_MIDNAME_TH, PENSION_RECEIVE_LASTNAME_TH, PENSION_RECEIVE_ADDR_ROOM_NO,
						 PENSION_RECEIVE_ADDR_BUILDING, PENSION_RECEIVE_ADDR_HOMENO, PENSION_RECEIVE_ADDR_MOO, PENSION_RECEIVE_ADDR_SOI,
						 PENSION_RECEIVE_ADDR_VILLAGE, PENSION_RECEIVE_ADDR_ROAD, PENSION_RECEIVE_ADDR_TAMB_ID, PENSION_RECEIVE_ADDR_AMPR_ID,
						 PENSION_RECEIVE_ADDR_PROV_ID, PENSION_RECEIVE_ADDR_POSTCODE, PENSION_RECEIVE_ADDR_TEL, PENSION_RECEIVE_ADDR_FAX,
						 PENSION_RECEIVE_ADDR_MOBILE, PENSION_RECEIVE_ADDR_EMAIL, PENSION_BANK_ID, PENSION_BANK_BRANCH, PENSION_BANK_NO, PENSION_BANK_NAME
						 FROM PENSION_MAIN A JOIN PER_PROFILE B ON B.PER_ID = A.PER_ID
						 JOIN SETUP_POSITION_TYPE C ON C.POSTYPE_ID = A.POSTYPE_ID
						 JOIN SETUP_PREFIX D ON D.PREFIX_ID = B.PREFIX_ID
						 WHERE PENSION_ID = '".$PENSION_ID."'");
	$rec = $db->db_fetch_array($query);
	$S_PENSION_IDCARD = $rec['PENSION_IDCARD'];
	$PER_ID = $rec['PER_ID'];
	$PREFIX_ID = $rec['PREFIX_ID'];
	$PREFIX_NAME_TH = $rec['PREFIX_NAME_TH'];
	$PER_FIRSTNAME_TH = $rec['PER_FIRSTNAME_TH'];
	$PER_MIDNAME_TH = $rec['PER_MIDNAME_TH'];
	$PER_LASTNAME_TH = $rec['PER_LASTNAME_TH'];
	$PER_NAME = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
	$POSTYPE_NAME_TH = $rec['POSTYPE_NAME_TH'];
	$PER_GENDER = ($rec['PER_GENDER'] == 1) ? "ชาย" : "หญิง";
	$PER_DATE_BIRTH = conv_date($rec['PER_DATE_BIRTH'],'short');
	$PER_DATE_OCCUPLY = conv_date($rec['PER_DATE_OCCUPLY'],'short');
	$PENSION_DATE_ANNIVERSARY = conv_date($rec['PENSION_DATE_ANNIVERSARY'],'short');
	$PER_DATE_RETIRE = conv_date($rec['PER_DATE_RETIRE'],'short');
	$PER_DATE_RESIGN = conv_date($rec['PER_DATE_RESIGN'],'short');
	$PER_STATUS = $arr_per_status[$rec['PER_STATUS']];
	$GPF_STATUS = $arr_gpf[$rec['GPF_STATUS']];
	$PENSION_TYPE_REQUEST_CIVIL = $rec['PENSION_TYPE_REQUEST_CIVIL'];
	$PENSION_TYPE_PENSION = $rec['PENSION_TYPE_PENSION'];
	$PENSION_TYPE_RECEIVE = $rec['PENSION_TYPE_RECEIVE'];
	$PENSION_RECEIVE_IDCARDS = $rec['PENSION_RECEIVE_IDCARDS'];
	$PENSION_RECEIVE_PREFIX = $rec['PENSION_RECEIVE_PREFIX'];
	$PENSION_RECEIVE_FIRSTNAME_TH = $rec['PENSION_RECEIVE_FIRSTNAME_TH'];
	$PENSION_RECEIVE_MIDNAME_TH = $rec['PENSION_RECEIVE_MIDNAME_TH'];
	$PENSION_RECEIVE_LASTNAME_TH = $rec['PENSION_RECEIVE_LASTNAME_TH'];
	$PENSION_RECEIVE_ADDR_ROOM_NO = $rec['PENSION_RECEIVE_ADDR_ROOM_NO'];
	$PENSION_RECEIVE_ADDR_BUILDING = $rec['PENSION_RECEIVE_ADDR_BUILDING'];
	$PENSION_RECEIVE_ADDR_HOMENO = $rec['PENSION_RECEIVE_ADDR_HOMENO'];
	$PENSION_RECEIVE_ADDR_MOO = $rec['PENSION_RECEIVE_ADDR_MOO'];
	$PENSION_RECEIVE_ADDR_SOI = $rec['PENSION_RECEIVE_ADDR_SOI'];
	$PENSION_RECEIVE_ADDR_VILLAGE = $rec['PENSION_RECEIVE_ADDR_VILLAGE'];
	$PENSION_RECEIVE_ADDR_ROAD = $rec['PENSION_RECEIVE_ADDR_ROAD'];
	$PENSION_RECEIVE_ADDR_TAMB_ID = $rec['PENSION_RECEIVE_ADDR_TAMB_ID'];
	$PENSION_RECEIVE_ADDR_AMPR_ID = $rec['PENSION_RECEIVE_ADDR_AMPR_ID'];
	$PENSION_RECEIVE_ADDR_PROV_ID = $rec['PENSION_RECEIVE_ADDR_PROV_ID'];
	$PENSION_RECEIVE_ADDR_POSTCODE = $rec['PENSION_RECEIVE_ADDR_POSTCODE'];
	$PENSION_RECEIVE_ADDR_TEL = $rec['PENSION_RECEIVE_ADDR_TEL'];
	$PENSION_RECEIVE_ADDR_FAX = $rec['PENSION_RECEIVE_ADDR_FAX'];
	$PENSION_RECEIVE_ADDR_MOBILE = $rec['PENSION_RECEIVE_ADDR_MOBILE'];
	$PENSION_RECEIVE_ADDR_EMAIL = $rec['PENSION_RECEIVE_ADDR_EMAIL'];
	$PENSION_BANK_ID = $rec['PENSION_BANK_ID'];
	$PENSION_BANK_BRANCH = $rec['PENSION_BANK_BRANCH'];
	$PENSION_BANK_NO = $rec['PENSION_BANK_NO'];
	$PENSION_BANK_NAME = $rec['PENSION_BANK_NAME'];
}
//จังหวัด
$arr_prov = GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME");

//อำเภอ/เขต
$arr_ampr = GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$PENSION_RECEIVE_ADDR_PROV_ID."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
					
//ตำบล/แขวง
$arr_tamb = GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='".$PENSION_RECEIVE_ADDR_AMPR_ID."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");

//bank
$arr_bank = GetSqlSelectArray("BANK_ID", "BANK_NAME_TH", "SETUP_BANK", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "BANK_NAME_TH");
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
<script src="js/pension_record_disp.js?<?php echo rand(); ?>"></script>
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
      <li><a href="pension_record_disp.php?<?php echo url2code($link2); ?>">บันทึกข้อมูลการขอบำเหน็จบำนาญ</a></li>
	   <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12">
    <div class="groupdata" >
	<div class="clearfix"></div>
      <form id="frm-input" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="PENSION_ID" name="PENSION_ID"  value="<?php echo $PENSION_ID; ?>">
        <input type="hidden" id="O_PREFIX" name="O_PREFIX" value="<?php echo text($PREFIX_NAME_TH);?>">
        <input type="hidden" id="O_FIRSTNAME_TH" name="O_FIRSTNAME_TH" value="<?php echo text($PER_FIRSTNAME_TH);?>">
        <input type="hidden" id="O_MIDNAME_TH" name="O_MIDNAME_TH" value="<?php echo text($PER_MIDNAME_TH);?>">
        <input type="hidden" id="O_LASTNAME_TH" name="O_LASTNAME_TH"  value="<?php echo text($PER_LASTNAME_TH); ?>">
        <input type="hidden" id="O_PENSION_RECEIVE_PREFIX" name="O_PENSION_RECEIVE_PREFIX" value="<?php echo text($PENSION_RECEIVE_PREFIX);?>">
        <input type="hidden" id="O_PENSION_RECEIVE_FIRSTNAME_TH" name="O_PENSION_RECEIVE_FIRSTNAME_TH" value="<?php echo text($PENSION_RECEIVE_FIRSTNAME_TH);?>">
        <input type="hidden" id="O_PENSION_RECEIVE_MIDNAME_TH" name="O_PENSION_RECEIVE_MIDNAME_TH" value="<?php echo text($PENSION_RECEIVE_MIDNAME_TH);?>">
        <input type="hidden" id="O_PENSION_RECEIVE_LASTNAME_TH" name="O_PENSION_RECEIVE_LASTNAME_TH"  value="<?php echo text($PENSION_RECEIVE_LASTNAME_TH); ?>">
         <div class="clearfix">
         </div>
		<div class="clearfix"></div>
        <div class="panel-group" id="accordion">
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();">
                        <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                        <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >
                        ข้อมูลทั่วไปของผู้มีสิทธิ์รับบำเหน็จบำนาญ
                    </a>
                </div>
            </div>
        
            <div id="collapse1" class="collapse in">
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขประจำตัวประชาชน :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-3"><input type="text" id="S_PENSION_IDCARD" name="S_PENSION_IDCARD" class="form-control idcard" value="<?php echo $S_PENSION_IDCARD; ?>">&nbsp;<button type="button" class="btn btn-primary" onClick="$('#frm-input').submit();">ค้นหา</button></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อตัว-ชื่อรอง-ชื่อสกุล :</div>
                    <div class="col-xs-12 col-md-3"><?php echo $PER_NAME;?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทบุคลากร :</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($POSTYPE_NAME_TH);?></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เพศ :</div>
                    <div class="col-xs-12 col-md-3"><?php echo $PER_GENDER;?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันเดือนปีเกิด :</div>
                    <div class="col-xs-12 col-md-3"><?php echo $PER_DATE_BIRTH;?></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันเดือนปีเข้ารับราชการ :</div>
                    <div class="col-xs-12 col-md-3"><?php echo $PER_DATE_OCCUPLY;?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันเดือนปีอายุราชการครบ 25 ปี :</div>
                    <div class="col-xs-12 col-md-3"><?php echo $PENSION_DATE_ANNIVERSARY;?></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันเดือนปีที่เกษียณอายุราชการ :</div>
                    <div class="col-xs-12 col-md-3"><?php echo $PER_DATE_RETIRE;?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันเดือนปีออกจากราชการ :</div>
                    <div class="col-xs-12 col-md-3"><?php echo $PER_DATE_RESIGN;?></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สาเหตุที่ออกจากราชการ :</div>
                    <div class="col-xs-12 col-md-3"><?php echo $PER_STATUS;?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สมาชิก กบข. :</div>
                    <div class="col-xs-12 col-md-3"><?php echo $GPF_STATUS;?></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สาเหตุที่ขอรับบำเหน็จบำนาญ :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('PENSION_TYPE_REQUEST_CIVIL','PENSION_TYPE_REQUEST_CIVIL',$arr_pension_request,'ทั้งหมด',$PENSION_TYPE_REQUEST_CIVIL,'','','1','','2');?></div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทการขอรับบำเหน็จบำนาญ :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('PENSION_TYPE_PENSION','PENSION_TYPE_PENSION',$arr_pension_type,'ทั้งหมด',$PENSION_TYPE_PENSION,'','','1','','2');?></div>
                </div>
                
            </div>        
        			
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onClick="$('.switchPic2').toggle();">
                        <img class="switchPic2" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic2" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        ข้อมูลประวัติการรับราชการปกติ
                    </a>
                </div>
            </div>
                
            <div id="collapse2" class="collapse">
                <br>
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr class="bgHead">
                            <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                            <th width="18%"><div align="center"><strong>สังกัด</strong></div></th>
                            <th width="14%"><div align="center"><strong>เลขที่ตำแหน่ง</strong></div></th>
                            <th width="16%"><div align="center"><strong>ข้อมูลตำแหน่ง</strong></div></th>
                            <th width="12%"><div align="center"><strong>เริ่่มตั้งแต่วันที่</strong></div></th>
                            <th width="12%"><div align="center"><strong>สิ้นสุดวันที่</strong></div></th>
                            <th width="8%"><div align="center"><strong>ปี</strong></div></th>
                            <th width="8%"><div align="center"><strong>เดือน</strong></div></th>
                            <th width="8%"><div align="center"><strong>วัน</strong></div></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
					$i=1;
                    $q_poshis = $db->query("SELECT POSHIS_POS_NO, ORG_NAME_TH_2, POSHIS_TITLE_NAME_TH, POSHIS_SDATE, POSHIS_EDATE, POSHIS_YEAR, POSHIS_MONTH, POSHIS_DAY FROM PENSION_POSITIONHIS WHERE PER_ID = '".$PER_ID."' AND DELETE_FLAG = '0' AND POSHIS_INPUT_TYPE = '1' ");
					while($r_poshis = $db->db_fetch_array($q_poshis)){
						?>
                        <tr bgcolor="#FFFFFF">
                            <td align="center"><?php echo $i; ?>.</td>
                            <td align="left" style="padding-left:5px"><?php echo text($r_poshis['ORG_NAME_TH_2']);?></td>
                            <td align="center"><?php echo text($r_poshis["POSHIS_POS_NO"]); ?></td>
                            <td align="center"><?php echo text($r_poshis["POSHIS_TITLE_NAME_TH"]); ?></td>
                            <td align="center"><?php echo conv_date($r_poshis['POSHIS_SDATE'], 'short'); ?></td>
                            <td align="center"><?php echo conv_date($r_poshis['POSHIS_EDATE'], 'short'); ?></td>
                            <td align="center"><?php echo $r_poshis['POSHIS_YEAR']; ?></td>
                            <td align="center"><?php echo $r_poshis['POSHIS_MONTH']; ?></td>
                            <td align="center"><?php echo $r_poshis['POSHIS_DAY']; ?></td>
                        </tr>
						<?php
						$i++;
					}
					?>
                    </tbody>
                </table>
            </div> 
            
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onClick="$('.switchPic3').toggle();">
                        <img class="switchPic3" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic3" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        ข้อมูลประวัติการรับราชการเวลาทวีคูณ
                    </a>
                </div>
            </div>
            
            <div id="collapse3" class="collapse">
                <br>
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr class="bgHead">
                            <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                            <th width="15%"><div align="center"><strong>คำอธิบาย</strong></div></th>
                            <th width="15%"><div align="center"><strong>เริ่มตั้งแต่วันที่</strong></div></th>
                            <th width="14%"><div align="center"><strong>สิ้นสุดวันที่</strong></div></th>
                            <th width="8%"><div align="center"><strong>ปี</strong></div></th>
                            <th width="8%"><div align="center"><strong>เดือน</strong></div></th>
                            <th width="8%"><div align="center"><strong>วัน</strong></div></th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
						$j=1;
						$q_multi = $db->query("SELECT MULTIME_NAME_TH, MULTIME_SDATE, MULTIME_EDATE, MULTITIME_YEAR, MULTITIME_MONTH, MULTITIME_DAY FROM PENSION_MULTITIME A JOIN SETUP_MULTITIME B ON B.MULTIME_ID = A.MULTIME_ID WHERE PER_ID = '".$PER_ID."' AND A.DELETE_FLAG = '0' AND MULTI_INPUT_TYPE = '1' ");
						while($r_multi = $db->db_fetch_array($q_multi)){
							?>
							<tr bgcolor="#FFFFFF">
								<td align="center"><?php echo $j; ?>.</td>
								<td align="left" style="padding-left:5px"><?php echo text($r_multi['MULTIME_NAME_TH']);?></td>
								<td align="center"><?php echo conv_date($r_multi["MULTIME_SDATE"], 'short');?></td>
								<td align="center"><?php echo conv_date($r_multi["MULTIME_EDATE"], 'short');?></td>
								<td align="center"><?php echo ($r_multi["MULTITIME_YEAR"] == '') ? '-' : $r_multi['MULTITIME_YEAR'];?></td>
								<td align="center"><?php echo $r_multi['MULTITIME_MONTH'];?></td>
								<td align="center"><?php echo $r_multi['MULTITIME_DAY'];?></td>
							</tr>
							<?php
							$j++;
						}
						?>
                    </tbody>
                </table>
            </div>
            
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" onClick="$('.switchPic4').toggle();">
                        <img class="switchPic4" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic4" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        สรุปเวลาราชการ
                    </a>
                </div>
            </div>
            
            <div id="collapse4" class="collapse">
                <br>
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr class="bgHead">
                            <th width="76%"><div align="center"><strong>รายการ</strong></div></th>
                            <th width="8%"><div align="center"><strong>ปี</strong></div></th>
                            <th width="8%"><div align="center"><strong>เดือน</strong></div></th>
                            <th width="8%"><div align="center"><strong>วัน</strong></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr bgcolor="#FFFFFF">
                            <td align="center"><?php //echo $i+$goto; ?></td>
                            <td align="left" style="padding-left:5px"><?php echo text($rec['PCON_FIRSTNAME_TH']) ."   " .text($rec['PCON_LASTNAME_TH']) ?></td>
                            <td align="center"><?php echo text($rec["PCON_IDCARD"]); ?></td>
                            <td align="center"><?php echo $arr_contact_type[$rec["PCON_TYPE"]]; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" onClick="$('.switchPic5').toggle();">
                        <img class="switchPic5" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic5" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        ข้อมูลประวัติการรับเงินเดือน/ค่าจ้าง 5 ปีย้อนหลัง
                    </a>
                </div>
            </div> 
            
            <div id="collapse5" class="collapse">
                <br>
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr class="bgHead">
                            <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                            <th width="12%"><div align="center"><strong>เริ่มตั้งแต่วันที่</strong></div></th>
                            <th width="12%"><div align="center"><strong>สิ้นสุดวันที่</strong></div></th>
                            <th width="8%"><div align="center"><strong>จำนวนเดือน</strong></div></th>
                            <th width="10%"><div align="center"><strong>เงินเดือน</strong></div></th>
                            <th width="10%"><div align="center"><strong>เงินสด</strong></div></th>
                            <th width="10%"><div align="center"><strong>เงินเพิ่ม</strong></div></th>
                            <th width="10%"><div align="center"><strong>เป็นเงิน</strong></div></th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
						$l=1;
						$q_salary = $db->query("SELECT UPS_EFFECTIVE_DATE, UPS_SALARY_NEW FROM PENSION_UPSALARY WHERE PER_ID = '".$PER_ID."' AND DELETE_FLAG = '0' AND UPS_INPUT_TYPE = '1' ORDER BY UPS_SEQ ASC");
						while($r_salary = $db->db_fetch_array($q_salary)){
							$arrSalary[$l]['UPS_EFFECTIVE_DATE'] = $r_salary['UPS_EFFECTIVE_DATE'];
							$arrSalary[$l]['UPS_SALARY_NEW'] = $r_salary['UPS_SALARY_NEW'];
							$l++;
						}
						if(count($arrSalary) > 0){
							$ll=1;
							foreach($arrSalary as $key => $val){
								
								$SDATE = $arrSalary[$key]['UPS_EFFECTIVE_DATE'];
								if($arrSalary[$key+1]['UPS_EFFECTIVE_DATE'] != ''){
									$date = new DateTime($arrSalary[$key+1]['UPS_EFFECTIVE_DATE']);
									$date->modify('-1 day');
									$EDATE = $date->format('Y-m-d');
								}else{
									$EDATE = $rec['PER_DATE_RETIRE'];
								}
								list($start_y,$start_m,$start_d) = explode("-",$SDATE);
								list($end_y,$end_m,$end_d) = explode("-",$EDATE);
								$total_month = floor(((gregoriantojd($end_m,$end_d,$end_y)-gregoriantojd($start_m,$start_d,$start_y))/30));
								
								$AMOUNT = ($arrSalary[$key]["UPS_SALARY_NEW"])*12;
								?>
								<tr bgcolor="#FFFFFF">
									<td align="center"><?php echo $ll; ?>.</td>
									<td align="center"><?php echo conv_date($SDATE, 'short');?></td>
									<td align="center"><?php echo conv_date($EDATE, 'short'); ?></td>
									<td align="center"><?php echo $total_month;?></td>
									<td align="right"><?php echo number_format($arrSalary[$key]["UPS_SALARY_NEW"],2); ?></td>
									<td align="center">&nbsp;</td>
									<td align="center">&nbsp;</td>
									<td align="right"><?php echo number_format($AMOUNT,2);?></td>
								</tr>
								<?php
								$ll++;
								$TOTAL+=$AMOUNT;
							}
							$AVG60 = $TOTAL/60;
							$PER70 = ($AVG60*0.7);
							
							list($re_y,$re_m,$re_d) = explode("-",$rec['PER_DATE_RETIRE']);
							list($oc_y,$oc_m,$oc_d) = explode("-",$rec['PER_DATE_OCCUPLY']);
							
							$oc_date = $oc_d.'/'.$oc_m.'/'.($oc_y+543);
							$re_date = ($re_y+543).$re_m.$re_d;
							
							$start_date = '21/12/2528';
							$end_date = '25570213';
							$age_y = diff_date($start_date,"y",$end_date);
							$age_m = diff_date($start_date,"m",$end_date);
							?>
                            <tr bgcolor="#FFFFFF">
                              <td colspan="7" align="right"><strong>รวม</strong></td>
                              <td align="right"><strong><?php echo number_format($TOTAL,2);?>&nbsp;</strong></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                              <td colspan="7" align="right"><strong>เฉลี่ย&nbsp;60 เดือนหลัง</strong></td>
                              <td align="right"><?php echo number_format($AVG60,2);?>&nbsp;</td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                              <td colspan="7" align="right"><strong>70 % ของเงินเดือนเฉลี่ย</strong></td>
                              <td align="right"><?php echo number_format($PER70,2);?>&nbsp;</td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                              <td colspan="7" align="right"><strong>เงินบำนาญจ่ายจริง</strong></td>
                              <td align="right"><?php echo $oc_date.' *** '.$re_date;?>&nbsp;</td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                              <td colspan="7" align="right"><strong>เงินบำเหน็จ</strong></td>
                              <td align="right"><?php echo $age_y;?>&nbsp;</td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                              <td colspan="7" align="right"><strong>เงินบำเหน็จดำรงชีพ ครั้งที่ 1</strong></td>
                              <td align="right"><?php echo $age_m;?>&nbsp;</td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                              <td colspan="7" align="right"><strong>เงินบำเหน็จดำรงชีพ ครั้งที่ 2 </strong></td>
                              <td align="right"><?php echo $start_date.' -- '.$oc_date;?>&nbsp;</td>
                      		</tr>
                            <?php
						}
						?>
                    </tbody>
                </table>
            </div>
            
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse6" onClick="$('.switchPic6').toggle();">
                        <img class="switchPic6" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic6" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        ข้อมูลผู้ติดต่อรับบำเหน็จบำนาญ
                    </a>
                </div>
            </div> 
            
            <div id="collapse6" class="collapse">
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ผู้ติดต่อรับบำเหน็จบำนาญ :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-3">
                    <input type="radio" id="PENSION_TYPE_RECEIVE" name="PENSION_TYPE_RECEIVE" value="1" <?php if($PENSION_TYPE_RECEIVE == 1){ echo "checked";}?> onClick="clrContact(this.value);">&nbsp;ติดต่อรับด้วยตนเอง
                    <input type="radio" id="PENSION_TYPE_RECEIVE" name="PENSION_TYPE_RECEIVE" value="2" <?php if($PENSION_TYPE_RECEIVE == 2){ echo "checked";}?> onClick="clrContact(this.value);">&nbsp;มีผู้มาติดต่อรับแทน
                    </div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขประจำตัวประชาชน :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-3"><input type="text" name="PENSION_RECEIVE_IDCARDS" id="PENSION_RECEIVE_IDCARDS" value="<?php echo get_idCard($PENSION_RECEIVE_IDCARDS);?>" class="form-control idcard"></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">คำนำหน้าชื่อ :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-3"><input type="text" id="PENSION_RECEIVE_PREFIX" name="PENSION_RECEIVE_PREFIX" value="<?php echo text($PENSION_RECEIVE_PREFIX);?>" class="form-control "></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อตัว :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-3"><input type="text" name="PENSION_RECEIVE_FIRSTNAME_TH" id="PENSION_RECEIVE_FIRSTNAME_TH" value="<?php echo text($PENSION_RECEIVE_FIRSTNAME_TH);?>" class="form-control"></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อรอง :</div>
                    <div class="col-xs-12 col-md-3"><input type="text" id="PENSION_RECEIVE_MIDNAME_TH" name="PENSION_RECEIVE_MIDNAME_TH" value="<?php echo text($PENSION_RECEIVE_MIDNAME_TH);?>" class="form-control "></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อสกุล :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-3"><input type="text" name="PENSION_RECEIVE_LASTNAME_TH" id="PENSION_RECEIVE_LASTNAME_TH" value="<?php echo text($PENSION_RECEIVE_LASTNAME_TH);?>" class="form-control"></div>
                </div>
                
                <div class="col-sm-5 head">ข้อมูลติดต่อ</div> 
                <div class="clearfix"></div>
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ห้อง :</div>
                    <div class="col-xs-12 col-md-2"><input type="text" id="PENSION_RECEIVE_ADDR_ROOM_NO" name="PENSION_RECEIVE_ADDR_ROOM_NO" value="<?php echo text($PENSION_RECEIVE_ADDR_ROOM_NO);?>" class="form-control "></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อาคาร :</div>
                    <div class="col-xs-12 col-md-2"><input type="text" name="PENSION_RECEIVE_ADDR_BUILDING" id="PENSION_RECEIVE_ADDR_BUILDING" value="<?php echo text($PENSION_RECEIVE_ADDR_BUILDING);?>" class="form-control"></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">บ้านเลขที่ :</div>
                    <div class="col-xs-12 col-md-2"><input type="text" name="PENSION_RECEIVE_ADDR_HOMENO" id="PENSION_RECEIVE_ADDR_HOMENO" value="<?php echo text($PENSION_RECEIVE_ADDR_HOMENO);?>" class="form-control"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่ที่ :</div>
                    <div class="col-xs-12 col-md-2"><input type="text" id="PENSION_RECEIVE_ADDR_MOO" name="PENSION_RECEIVE_ADDR_MOO" class="form-control " value="<?php echo text($PENSION_RECEIVE_ADDR_MOO);?>"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่บ้าน :</div>
                    <div class="col-xs-12 col-md-2"><input type="text" name="PENSION_RECEIVE_ADDR_VILLAGE" id="PENSION_RECEIVE_ADDR_VILLAGE" value="<?php echo text($PENSION_RECEIVE_ADDR_VILLAGE);?>" class="form-control"></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ซอย :</div>
                    <div class="col-xs-12 col-md-2"><input type="text" name="PENSION_RECEIVE_ADDR_SOI" id="PENSION_RECEIVE_ADDR_SOI" value="<?php echo text($PENSION_RECEIVE_ADDR_SOI);?>" class="form-control"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ถนน :</div>
                    <div class="col-xs-12 col-md-2"><input type="text" name="PENSION_RECEIVE_ADDR_ROAD" id="PENSION_RECEIVE_ADDR_ROAD" value="<?php echo text($PENSION_RECEIVE_ADDR_ROAD);?>" class="form-control"></div>
                </div>
                                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัด :</div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('PENSION_RECEIVE_ADDR_PROV_ID','PENSION_RECEIVE_ADDR_PROV_ID',$arr_prov,'จังหวัด',$PENSION_RECEIVE_ADDR_PROV_ID,'onchange="getRampr(this,\'PENSION_RECEIVE_ADDR_AMPR_ID'.'\',\'PENSION_RECEIVE_ADDR_TAMB_ID'.'\')"','','1');?></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อำเภอ :</div>
                    <div class="col-xs-12 col-md-2"><span id='ss_ampr'><?php echo GetHtmlSelect('PENSION_RECEIVE_ADDR_AMPR_ID','PENSION_RECEIVE_ADDR_AMPR_ID',$arr_ampr,'อำเภอ/เขต',$PENSION_RECEIVE_ADDR_AMPR_ID,'onchange="getStamb(this.id,this.value,\'PENSION_RECEIVE_ADDR_TAMB_ID'.'\') " ','','1');?></span></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ตำบล :</div>
                    <div class="col-xs-12 col-md-2"><span id='ss_tamb'><?php echo GetHtmlSelect('PENSION_RECEIVE_ADDR_TAMB_ID','PENSION_RECEIVE_ADDR_TAMB_ID',$arr_tamb,'ตำบล/แขวง',$PENSION_RECEIVE_ADDR_TAMB_ID,'','','1');?></span></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">รหัสไปรษณีย์ :</div>
                    <div class="col-xs-12 col-md-2"><input type="text" id="PENSION_RECEIVE_ADDR_POSTCODE" name="PENSION_RECEIVE_ADDR_POSTCODE" value="<?php echo text($PENSION_RECEIVE_ADDR_POSTCODE);?>" class="form-control " maxlength="5"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์พื้นฐาน :</div>
                    <div class="col-xs-12 col-md-2"><input type="text" name="PENSION_RECEIVE_ADDR_TEL" id="PENSION_RECEIVE_ADDR_TEL" value="<?php echo text($PENSION_RECEIVE_ADDR_TEL);?>" class="form-control"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรสาร :</div>
                    <div class="col-xs-12 col-md-2"><input type="text" name="PENSION_RECEIVE_ADDR_FAX" id="PENSION_RECEIVE_ADDR_FAX" value="<?php echo text($PENSION_RECEIVE_ADDR_FAX);?>" class="form-control"></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์เคลื่อนที่ :</div>
                    <div class="col-xs-12 col-md-2"><input type="text" id="PENSION_RECEIVE_ADDR_MOBILE" name="PENSION_RECEIVE_ADDR_MOBILE" value="<?php echo text($PENSION_RECEIVE_ADDR_MOBILE);?>" class="form-control "></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อีเมล์ :</div>
                    <div class="col-xs-12 col-md-2"><input type="text" name="PENSION_RECEIVE_ADDR_EMAIL" id="PENSION_RECEIVE_ADDR_EMAIL" value="<?php echo text($PENSION_RECEIVE_ADDR_EMAIL);?>" class="form-control"></div>
                </div>
                                                    
                <div class="col-sm-5 head">ข้อมูลธนาคาร</div> 
                <div class="clearfix"></div>
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ธนาคาร :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('PENSION_BANK_ID','PENSION_BANK_ID',$arr_bank,'ธนาคาร',$PENSION_BANK_ID,'','','1');?></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สาขา :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2"><input type="text" name="PENSION_BANK_BRANCH" id="PENSION_BANK_BRANCH" value="<?php echo text($PENSION_BANK_BRANCH);?>" class="form-control"></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่บัญชี :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2"><input type="text" id="PENSION_BANK_NO" name="PENSION_BANK_NO" class="form-control " value="<?php echo text($PENSION_BANK_NO);?>"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อบัญชี :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2"><input type="text" name="PENSION_BANK_NAME" id="PENSION_BANK_NAME" value="<?php echo text($PENSION_BANK_NAME);?>" class="form-control"></div>
                </div>
            </div>
        </div>
            
		<div class="clearfix"></div><br>
        <div class="col-xs-12 col-sm-12" align="center">
          <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
          <button type="button" class="btn btn-default" 
          onClick="self.location.href='pension_record_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
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