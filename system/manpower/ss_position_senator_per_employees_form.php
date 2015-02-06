<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;
$paramlink = url2code($link);
$txt = ($proc == "add") ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล";
$path_img=$path.'fileupload/file_position_frame/';
$sub_menu = "สำนักงานเลขาธิการวุฒิสภา";

if($proc == 'add'){
	$query_frame  = $db->query("SELECT MAX(CAST(POS_NO AS INT)) AS POS_NO_MAX FROM POSITION_FRAME WHERE POSTYPE_ID = 3 AND ORG_ID_2 = 16 ");
	$rec_frame = $db->db_fetch_array($query_frame);
	$pos_no = (int)$rec_frame['POS_NO_MAX']+1;
}else{
	$sql = "Select * From POSITION_FRAME Where POS_ID = ".$POS_ID;
	$query = $db->query($sql);
	$data = $db->db_fetch_array($query);
	$pos_no = $data['POS_NO'];
	
	$sql_per = "SELECT A.PREFIX_ID, A.PER_FIRSTNAME_TH, A.PER_MIDNAME_TH, A.PER_LASTNAME_TH, A.PER_SALARY, A.PER_SALARY_POSITION, A.PER_COMPENSATION_1, 
	A.PER_COMPENSATION_2 , B.LEVEL_NAME_TH
	FROM PER_PROFILE A
	LEFT JOIN SETUP_POS_LEVEL B ON A.LEVEL_ID = B.LEVEL_ID
	 WHERE A.POS_ID = '".$data['POS_ID']."' ";
	$query_per = $db->query($sql_per); 
	$rec_per = $db->db_fetch_array($query_per);
	$PER_NAME = Showname($rec_per["PREFIX_ID"],$rec_per["PER_FIRSTNAME_TH"],$rec_per["PER_MIDNAME_TH"],$rec_per["PER_LASTNAME_TH"]);
}
//$array
$arr_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' AND POSTYPE_ID = 3 and DELETE_FLAG='0' AND TYPE_ID = '".$data['TYPE_ID']."' ", "LEVEL_SEQ");
$arr_status_request = array(1=>'ปกติ', 2=>'มีการร้องขอ');

$arr_remark = GetSqlSelectArray("REMARK_ID","REMARK_NAME" ,"SETUP_POSITION_REMARK" , "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 ","REMARK_NAME");
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
<script src="js/ss_position_senator_per_employees_form.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li><a href="ss_position_senator_per_employees_disp.php?<?php echo $paramlink; ?>"><?php echo showMenu($menu_sub_id)." (".$sub_menu.")"; ?></a></li>
			<li class="active"><?php echo $txt; ?></li>
		</ol>
	</div>
	<div class="col-xs-12 col-sm-12" id="content">
		<div class="groupdata" >
			<form id="frm-input" method="post" action="process/ss_position_senator_per_employees_process.php"enctype="multipart/form-data">
				<input name="proc" type="hidden" id="proc" value="<?php echo $proc; ?>">
				<input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
				<input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
				<input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
				<input name="POSTYPE_ID" type="hidden" id="POSTYPE_ID" value="<?php echo $POSTYPE_ID; ?>">
				<input name="ORG_ID_2" type="hidden" id="ORG_ID_2" value="<?php echo $ORG_ID_2; ?>">
				<input name="POS_ID" type="hidden" id="POS_ID" value="<?php echo $POS_ID; ?>">
				<div class="row head-form">ข้อมูลหลักกรอบอัตรากำลัง</div>
                <div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap;">สำนัก/กลุ่ม : <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3">
						<select id="ORG_ID_3" name="ORG_ID_3" class="selectbox form-control" placeholder="สำนัก/กลุ่ม" >
							<option value="" selected="selected"></option>
							<?php
							$sql_org_3 = "Select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = 16 ORDER BY ORG_SEQ ASC";
							$query_org_3 = $db->query($sql_org_3);
							$select_org_3[$data['ORG_ID_3']] = "Selected='Selected'";
							while($org = $db->db_fetch_array($query_org_3)){
								echo '<option value="'.$org['ORG_ID'].'" '.$select_org_3[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
							}
							?>
						</select>
					</div>
					<div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ปีที่อนุมัติกรอบ :</div>
					<div class="col-xs-12 col-md-3">
						<input type="text" id="POS_YEAR" name="POS_YEAR" class="form-control number" placeholder="ปีที่อนุมัติกรอบ" maxlength="10" value="<?php echo $data['POS_YEAR']; ?>" style="width:170px;" >
					</div>
				</div>
			  <div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ตำแหน่ง : <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3">
						<input type="text" id="POS_NO" name="POS_NO" class="form-control" placeholder="เลขที่ตำแหน่ง" maxlength="10" value="<?php echo $pos_no; ?>" onKeyUp="check_number(this.value,'POS_NO');" style="width:100px;" >
					</div>
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทพนักงานราชการ : <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3">
						<select id="TYPE_ID" name="TYPE_ID" class="selectbox form-control" placeholder="ประเภทพนักงานราชการ" onChange="get_level(this); ">
							<option value=""></option>
							<?php
							$sql_type_name = "Select TYPE_ID , TYPE_NAME_TH From SETUP_POS_TYPE WHERE ACTIVE_STATUS = 1 AND POSTYPE_ID = '3' AND DELETE_FLAG = 0 ORDER BY TYPE_NAME_TH";
							$query_type_name = $db->query($sql_type_name);
							$select_type[$data['TYPE_ID']] = "Selected='Selected'";
							while($type = $db->db_fetch_array($query_type_name)){
								echo '<option value="'.$type['TYPE_ID'].'" '.$select_type[$type['TYPE_ID']].' >'.text($type['TYPE_NAME_TH']).'</option>';
							}
							?>
						</select>
					</div>
                    <div class="col-xs-12 col-md-2 col-md-offset-1" >ประเภทกลุ่มงาน : <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3">
						<?php echo GetHtmlSelect('LEVEL_ID', 'LEVEL_ID',$arr_level , 'ประเภทกลุ่มงาน' ,$data['LEVEL_ID'] ,'onChange="get_line(this); "', '1', '', ''); ?>
				  </div>
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ตำแหน่ง : <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3" >
						<select id="LINE_ID" name="LINE_ID" class="selectbox form-control" placeholder="ตำแหน่ง" >
							<option value=""></option>
							<?php
							if(!empty($data['LINE_ID'])){
								$sql_line_name = "Select LINE_ID , LINE_NAME_TH From SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND LEVEL_ID = ".$data['LEVEL_ID']." AND POSTYPE_ID = 3  ORDER BY LINE_NAME_TH ASC";
								$select_line[$data['LINE_ID']] = "Selected='Selected'";
								$query_line_name = $db->query($sql_line_name);
								while($line = $db->db_fetch_array($query_line_name)){
									echo '<option value="'.$line['LINE_ID'].'" '.$select_line[$line['LINE_ID']].'>'.text($line['LINE_NAME_TH']).'</option>';
								}
							}
							?>
						</select>
					</div>	
                    <div class="col-xs-12 col-md-1"></div>
                        <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">หมายเหตุของตำแหน่ง :</div>
                        <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('REMARK_ID', 'REMARK_ID',$arr_remark, 'หมายเหตุของตำแหน่ง' ,$data['REMARK_ID'] ,'', '1', '', ''); ?></div>
				</div>
                <div class="row formSep">
                        <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">รายละเอียด :</div>
                        <div class="col-xs-12 col-sm-8">
                        <textarea id="REMARK_DETAIL" name="REMARK_DETAIL" class="form-control" placeholder="รายละเอียด" maxlength="255"  ><?php echo  text($data["REMARK_DETAIL"]);?></textarea></div> 		
                </div>
                <div class="row formSep">
					<div class="col-xs-12 col-sm-2">ไฟล์แนบ :&nbsp;</div>
					<div class="col-xs-12 col-md-3">
					<div class="input-group">
						<input type= "file" id="POS_FILE" name="POS_FILE" class="form-control"  value="<?php echo text($data["POS_FILE"]);?>" >
						<?php echo displayDownloadFileAttach($path_img,trim($data['POS_FILE']),$arr_txt['download']);?>
					</div>  
						<input type="hidden" id="OLD_FILE_PIC" name="OLD_FILE_PIC"   value="<?php echo !empty($data["POS_FILE"])?text($data["POS_FILE"]):""; ?>">
					</div>
				</div>
				<div class="row head-form">ข้อมูลเงินเดือน/เงินประจำตำแหน่ง/ค่าตอบแทน/ค่าตอบแทนพิเศษ</div>
					
				<div class="row formSep">
					<div class="col-xs-4 col-md-2" style="white-space:nowrap;">ค่าตอบแทน : <span style="color:red;">*</span></div>
					<div class="col-xs-4 col-md-2" >
						<input type="text" id="POS_FRAME_SALARY" name="POS_FRAME_SALARY" class="form-control" placeholder="เงินเดือน" maxlength="20" value="<?php echo number_format($data['POS_FRAME_SALARY'],2); ?>" onBlur="NumberFormat(this,2)" style="text-align:right;" >
					</div>	
                    				
				</div>
                 <?php if($proc == 'edit'){ ?>
                <div class="row head-form">ข้อมูลผู้ถือครองตำแหน่ง</div>
                <div class="row formSep">
					<div class="col-xs-4 col-md-2" style="white-space:nowrap;">ชื่อ-สกุล :</div>
					<div class="col-xs-4 col-md-3" >
						<?php echo $PER_NAME; ?>
					</div>	
                    <div class="col-xs-4 col-md-2 col-md-offset-1" >ระดับ :</div>
					<div class="col-xs-4 col-md-3" >
						<?php echo text($rec_per['LEVEL_NAME_TH']); ?>
					</div>					
				</div>					
				<div class="row formSep">
					<div class="col-xs-4 col-md-2" style="white-space:nowrap;">ค่าตอบแทน :</div>
					<div class="col-xs-4 col-md-3" >
						<?php echo number_format($rec_per['PER_SALARY'],2); ?>
					</div>		
				</div>
                <?php } ?>
                
				<div class="row head-form">ข้อมูลการเคลื่อนไหวสำคัญของตำแหน่ง</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่อนุมัติกรอบตำแหน่ง :</div>
					<div class="col-xs-12 col-md-2">
						<div id="DIV_POS_DATE_EFFECTIVE" class="input-group datepicker">
							<input type="text" id="POS_DATE_EFFECTIVE" name="POS_DATE_EFFECTIVE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date(text($data['POS_DATE_EFFECTIVE'])); ?>">
							<span class="input-group-addon datepicker" for="POS_DATE_EFFECTIVE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
						</div>
					</div>
					<div class="col-xs-12 col-md-2 col-md-offset-2" style="white-space:nowrap;">วันที่อนุมมัติเงินตำแหน่ง :</div>
					<div class="col-xs-12 col-md-2">
						<div id="DIV_POS_DATE_SALARY" class="input-group datepicker">
							<input type="text" id="POS_DATE_SALARY" name="POS_DATE_SALARY" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date(text($data['POS_DATE_SALARY'])); ?>">
							<span class="input-group-addon datepicker" for="POS_DATE_SALARY">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
						</div>
					</div>					
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานะของตำแหน่ง : <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-2">
						<?php $arr_stauts[$data['POS_STATUS']] = "Selected='Selected'"; ?>
						<select id="POS_STATUS" name="POS_STATUS" class="selectbox form-control" placeholder="สถานะของตำแหน่ง" >
							<option value=""></option>
							<option <?php echo $arr_stauts[1]; ?>value="1">ว่าง ไม่มีเงิน</option>
							<option <?php echo $arr_stauts[2]; ?>value="2">ว่าง มีเงิน</option>
							<option <?php echo $arr_stauts[3]; ?>value="3">มีคนถือครอง</option>
							<option <?php echo $arr_stauts[4]; ?>value="4">ยุบเลิก</option>
						</select>
					</div>
					<div class="col-xs-12 col-md-2 col-md-offset-2" style="white-space:nowrap;">สถานะของการขอเปลี่ยนแปลง : </div>
					<div class="col-xs-12 col-md-3"><?php echo ($data['POS_STATUS_REQUEST'] == '') ? "ปกติ" : $arr_status_request[$data['POS_STATUS_REQUEST']];?></div>
				</div>
				<div class="formlast">
					<div class="col-xs-12 col-md-12" align="center">
					<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
					<button type="button" class="btn btn-default" onClick="self.location.href='ss_position_senator_per_employees_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>