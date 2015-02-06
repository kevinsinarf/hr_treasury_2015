<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;
$paramlink = url2code($link);
$txt = ($proc == "add") ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล";

$query_frame  = $db->query("SELECT MAX(CAST(POS_NO AS INT)) AS POS_NO_MAX FROM POSITION_FRAME ");
$rec_frame = $db->db_fetch_array($query_frame);
$pos_no_max = (int)$rec_frame['POS_NO_MAX']+1;

if($menu_sub_id <= 103){
    $sub_menu = "สำนักงานเลขาธิการสภาผู้แทนราษฎร";
}else{
    $sub_menu = "สำนักงานเลขาธิการวุฒิสภา"; 
}

switch($menu_sub_id){
	case 101 : {
		$POSTYPE_ID = 1;
		$ORG_ID_2 = 15;
		$TITLE_SUB = "ตำแหน่งข้าราชการ (สำนักงานเลขาธิการสภาผู้แทนราษฎร)";
	}break;
	case 102 : {
		$POSTYPE_ID = 3;
		$ORG_ID_2 = 15;
		$TITLE_SUB = "ตำแหน่งพนักงานราชการ (สำนักงานเลขาธิการสภาผู้แทนราษฎร)";
	}break;
	case 103 : {
		$POSTYPE_ID = 5;
		$ORG_ID_2 = 15;
		$TITLE_SUB = "ตำแหน่งลูกจ้างประจำ (สำนักงานเลขาธิการสภาผู้แทนราษฎร)";
	}break;
	case 104 : {
		$POSTYPE_ID = 1;
		$ORG_ID_2 = 16;
		$TITLE_SUB = "ตำแหน่งข้าราชการ (สำนักงานเลขาธิการวุฒิสภา)";
	}break;
	case 105 : {
		$POSTYPE_ID = 3;
		$ORG_ID_2 = 16;
		$TITLE_SUB = "ตำแหน่งพนักงานราชการ (สำนักงานเลขาธิการวุฒิสภา)";
	}break;
	case 106 : {
		$POSTYPE_ID = 5;
		$ORG_ID_2 = 16;
		$TITLE_SUB = "ตำแหน่งลูกจ้างประจำ (สำนักงานเลขาธิการวุฒิสภา)";
	}break;
	default : {
		$sql = "Select * From AUT_MENU_SETTING where menu_id = '".$menu_sub_id."'";
		$query = $db->query($sql);
		$data_menu = $db->db_fetch_array($query);
	}
}
if($proc == 'add'){
	$default_pos_no = $db->get_data_field("Select (MAX(POS_NO)+1) AS POS_NO From POSITION_FRAME" , "POS_NO");

}else{
	$sql = "Select * From POSITION_FRAME Where POS_ID = ".$POS_ID;
	$query = $db->query($sql);
	$data = $db->db_fetch_array($query);
	$default_pos_no = $data['POS_NO'];
}

//$array
$arr_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "LEVEL_NAME_TH");
$arr_cl=GetSqlSelectArray("CO_ID", "convert(varchar,LEVEL_ID_MIN)+'|'+convert(varchar,LEVEL_ID_MAX) as CO_NAME", "SETUP_POS_CO_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND TYPE_ID = '".$data['TYPE_ID']."'", "CO_ID");
$arr_salary = GetSqlSelectArray("SALARYTITLE_ID", "SALARYTITLE_NAME_TH", "SETUP_POS_SALARY_TITLE", "1=1", "SALARYTITLE_NAME_TH");
$arr_edu_level = GetSqlSelectArray("EL_ID", "EL_NAME_TH", "SETUP_EDU_LEVEL", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0", "EL_SEQ"); 
$arr_line_group = GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0", "LG_NAME_TH");  
$arr_type_manage = GetSqlSelectArray("MT_ID", "MT_NAME_TH", "SETUP_POS_MANAGE_TYPE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0", "MT_ID"); 
$arr_manage = GetSqlSelectArray("MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0", "MANAGE_NAME_TH"); 

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
<script src="js/ss_position_per_form.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li><a href="ss_position_per_disp.php?<?php echo $paramlink; ?>"><?php echo showMenu($menu_sub_id)." (".$sub_menu.")"; ?></a></li>
			<li class="active"><?php echo $txt; ?></li>
		</ol>
	</div>
	<div class="col-xs-12 col-sm-12">
		<div class="groupdata" >
			<form id="frm-input" method="post" action="process/ss_position_per_process.php">
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
					<div class="col-xs-12 col-md-2" style="white-space:nowrap;">สำนัก/กลุ่ม : </div>
					<div class="col-xs-12 col-md-3">
						<select id="ORG_ID_3" name="ORG_ID_3" class="selectbox form-control" placeholder="สำนัก/กลุ่ม" onChange="get_org_4(this);" >
							<option value=""></option>
							<?php
							$sql_org_3 = "Select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND OL_ID = 16 AND ORG_PARENT_ID = ".$ORG_ID_2." ORDER BY ORG_NAME_TH ASC";
							$query_org_3 = $db->query($sql_org_3);
							$select_org_3[$data['ORG_ID_3']] = "Selected='Selected'";
							while($org = $db->db_fetch_array($query_org_3)){
								echo '<option value="'.$org['ORG_ID'].'" '.$select_org_3[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
							}
							?>
						</select>
					</div>
                    <?php if($POSTYPE_ID != 3){?>
					<div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">กลุ่มงาน </div>
					<div class="col-xs-12 col-md-3">
						<select id="ORG_ID_4" name="ORG_ID_4" class="selectbox form-control" placeholder="กลุ่มงาน">
							<option value=""></option>
							<?php
							if(!empty($data['ORG_ID_4'])){
								$sql_org_4 = "Select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND ORG_PARENT_ID = ".$data['ORG_ID_3'];
								$query_org_4 = $db->query($sql_org_4);
								$select_org_4[$data['ORG_ID_4']] = "Selected='Selected'";
								while($org = $db->db_fetch_array($query_org_4)){
									echo '<option value="'.$org['ORG_ID'].'" '.$select_org_4[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
								}
							}
							?>
						</select>
					</div>
                    <?php } ?>
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ตำแหน่ง <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3">
						<input type="text" id="POS_NO" name="POS_NO" class="form-control" placeholder="เลขที่ตำแหน่ง" maxlength="10" value="<?php echo $pos_no_max; ?>" onKeyUp="check_number(this.value,'POS_NO');" style="width:100px;" >
					</div>
					<?php
					if($POSTYPE_ID == 3){
						$POS_YEAR = (4-(2557+3)%4)+2557;
						if($proc == 'add'){ $POS_LIVE_YEAR = $POS_YEAR;}else{$POS_LIVE_YEAR = $data['POS_YEAR'];}
						echo '<div class="col-xs-12 col-md-2 col-md-offset-2" style="white-space:nowrap;">ปีกรอบ <span style="color:red;">*</span></div>
						<div class="col-xs-12 col-md-2">
							<input type="text" id="POS_LIVE_YEAR" name="POS_LIVE_YEAR" class="form-control" placeholder="ปีกรอบ" maxlength="4" value="'.$POS_LIVE_YEAR.'" onkeyup="check_number(this.value,\'POS_LIVE_YEAR\');">
						</div>';
					}
					?>
                    <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ระดับการศึกษาแรกบรรจุ </div>
					<div class="col-xs-12 col-md-3">
                    	<?php echo GetHtmlSelect('EL_ID', 'EL_ID',$arr_edu_level , 'ระดับการศึกษาแรกบรรจุ' ,$data['EL_ID'] ,'', '1', '', ''); ?>
                    </div>
				</div>
				<?php if($POSTYPE_ID == 1 || $POSTYPE_ID == 5){ ?>
                <?php $text_level = array(1=> 'ประเภทตำแหน่ง' ,5=> 'กลุ่ม'); ?>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $text_level[$POSTYPE_ID];?> <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3">
						<select id="TYPE_ID" name="TYPE_ID" class="selectbox form-control" placeholder="<?php echo $text_level[$POSTYPE_ID];?>" onChange="get_level(this);get_line(this);get_manage(this);getFrame(this);">
							<option value=""></option>
							<?php
							$sql_type_name = "Select TYPE_ID , TYPE_NAME_TH From SETUP_POS_TYPE WHERE ACTIVE_STATUS = 1 AND POSTYPE_ID = '".$POSTYPE_ID."' AND DELETE_FLAG = 0 ORDER BY TYPE_NAME_TH";
							$query_type_name = $db->query($sql_type_name);
							$select_type[$data['TYPE_ID']] = "Selected='Selected'";
							while($type = $db->db_fetch_array($query_type_name)){
								echo '<option value="'.$type['TYPE_ID'].'" '.$select_type[$type['TYPE_ID']].' >'.text($type['TYPE_NAME_TH']).'</option>';
							}
							?>
						</select>
					</div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ระดับ </div>
					<div class="col-xs-12 col-md-3">
						
					</div>
				</div>
                <div class="row formSep">
                <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ระดับตำแหน่ง<span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3">
						<select id="LEVEL_ID_gov" name="LEVEL_ID" class="selectbox form-control" placeholder="ระดับตำแหน่ง" >
							<option value=""></option>
							<?php
							if(!empty($data['LEVEL_ID'])){
								$sql_level_name = "Select LEVEL_ID , LEVEL_NAME_TH  From SETUP_POS_LEVEL WHERE ACTIVE_STATUS = 1 AND TYPE_ID = ".$data['TYPE_ID']." AND POSTYPE_ID = ".$POSTYPE_ID." AND DELETE_FLAG='0' ORDER BY LEVEL_ID";
								$select_level[$data['LEVEL_ID']] = "Selected='Selected'";
								$query_level_name = $db->query($sql_level_name);
								while($level = $db->db_fetch_array($query_level_name)){
									echo '<option value="'.$level['LEVEL_ID'].'" '.$select_level[$level['LEVEL_ID']].'>'.text($level['LEVEL_NAME_TH']).'</option>';
								}
							}
							?>
						</select>
					</div>
                 </div>
				<div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สายงาน <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3" >
						<?php echo GetHtmlSelect('LG_ID', 'LG_ID',$arr_line_group , 'สายงาน' ,$data['LG_ID'] ,'', '1', '', ''); ?>	
					</div>	
					<div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ตำแหน่งในสายงาน <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3" >
						<select id="LINE_ID" name="LINE_ID" class="selectbox form-control" placeholder="ตำแหน่งในสายงาน" >
							<option value=""></option>
							<?php
							if(!empty($data['LINE_ID'])){
								$sql_line_name = "Select LINE_ID , LINE_NAME_TH From SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND TYPE_ID = ".$data['TYPE_ID']." AND POSTYPE_ID = ".$POSTYPE_ID." ORDER BY LINE_NAME_TH ASC";
								$select_line[$data['LINE_ID']] = "Selected='Selected'";
								$query_line_name = $db->query($sql_line_name);
								while($line = $db->db_fetch_array($query_line_name)){
									echo '<option value="'.$line['LINE_ID'].'" '.$select_line[$line['LINE_ID']].'>'.text($line['LINE_NAME_TH']).'</option>';
								}
							}
							?>
						</select>
					</div>	
				</div>
                <div class="row formSep">
                    <?php if($POSTYPE_ID == 1){ ?>
					<div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ประเภทตำแหน่งในสายงานบริหาร</div>
					<div class="col-xs-12 col-md-3">
						<?php echo GetHtmlSelect('MT_ID', 'MT_ID',$arr_line_group , 'ตำแหน่งในสายงานบริหาร' ,$data['MT_ID'] ,'', '1', '', ''); ?>
					</div>
                    <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ตำแหน่งในสายงานบริหาร : </div>
					<div class="col-xs-12 col-md-3">
						<?php echo GetHtmlSelect('MANAGE_ID', 'MANAGE_ID',$arr_manage, 'ตำแหน่งในสายงานบริหาร' ,$data['MANAGE_ID'] ,'', '1', '', ''); ?>		
					</div>

                    <?php } ?>					
				</div>
				
				<?php } ?>
				
				<div class="row head-form">ข้อมูลสวัสดิการเงินเดือน เงินค่าตอบแทน</div>
					<div class="row formSep ">
						<div class="col-xs-4 col-md-2" style="white-space:nowrap;" align="center" ><strong>รายการ</strong> </div>
						<div class="col-xs-4 col-md-2 col-md-offset-5" style="white-space:nowrap;" align="center" ><strong>กรอบ <span style="color:red;">*</span></strong></div>
						<div class="col-xs-4 col-md-2" style="white-space:nowrap;" align="center" ><strong>จ่ายจริง</strong></div>
					</div>
				<div class="row formSep">
					<?php $arr_textSalary = array(1=>'เงินเดือน',3=>'ค่าตอบแทน',5=>'ค่าจ้าง');?>
					<div class="col-xs-4 col-md-2" style="white-space:nowrap;"><?php echo $arr_textSalary[$POSTYPE_ID];?></div>
					<div class="col-xs-4 col-md-2 col-md-offset-5" >
						<input type="text" id="POS_FRAME_SALARY" name="POS_FRAME_SALARY" class="form-control" placeholder="<?php echo $arr_textSalary[$POSTYPE_ID];?>" maxlength="13" value="<?php echo number_format($data['POS_FRAME_SALARY'],2); ?>" onBlur="NumberFormat(this,2)" style="text-align:right;" >
						<input type="hidden" id="textSalary" value="<?php echo $arr_textSalary[$POSTYPE_ID];?>" >
					</div>
					<div class="col-xs-4 col-md-2" >
						<input type="text" id="POS_TRUE_SALARY" name="POS_TRUE_SALARY" class="form-control" placeholder="<?php echo $arr_textSalary[$POSTYPE_ID];?>" maxlength="13" value="<?php echo number_format($data['POS_TRUE_SALARY'],2); ?>" onBlur="NumberFormat(this,2)" style="text-align:right;" >
					</div>					
				</div>
				<?php if($POSTYPE_ID == 1){ ?>
				<div class="row formSep">
					<div class="col-xs-4 col-md-2" style="white-space:nowrap;">เงินประจำตำแหน่ง</div>
					<div class="col-xs-4 col-md-2 col-md-offset-5" >
						<input type="text" id="POS_FRAME_POSITION_SALARY" name="POS_FRAME_POSITION_SALARY" class="form-control" placeholder="เงินประจำตำแหน่ง" maxlength="13" value="<?php echo number_format($data['POS_FRAME_POSITION_SALARY'],2); ?>" onBlur="NumberFormat(this,2)" style="text-align:right;" >
					</div>
					<div class="col-xs-4 col-md-2" >
						<input type="text" id="POS_TRUE_POSITION_SALARY" name="POS_TRUE_POSITION_SALARY" class="form-control" placeholder="เงินประจำตำแหน่ง" maxlength="13" value="<?php echo number_format($data['POS_TRUE_POSITION_SALARY'],2); ?>" onBlur="NumberFormat(this,2)" style="text-align:right;" >
					</div>					
				</div>
				<div class="row formSep">
					<div class="col-xs-4 col-md-2" style="white-space:nowrap;">เงินค่าตอบแทน</div>
					<div class="col-xs-4 col-md-2 col-md-offset-5" >
						<input type="text" id="POS_FRAME_COMPENSATION_1" name="POS_FRAME_COMPENSATION_1" class="form-control" placeholder="เงินค่าตอบแทน" maxlength="13" value="<?php echo number_format($data['POS_FRAME_COMPENSATION_1'],2); ?>" onBlur="NumberFormat(this,2)" style="text-align:right;" >
					</div>
					<div class="col-xs-4 col-md-2" >
						<input type="text" id="POS_TRUE_COMPENSATION_1" name="POS_TRUE_COMPENSATION_1" class="form-control" placeholder="เงินค่าตอบแทน" maxlength="13" value="<?php echo number_format($data['POS_TRUE_COMPENSATION_1'],2); ?>" onBlur="NumberFormat(this,2)" style="text-align:right;" >
					</div>					
				</div>
				<?php } ?>
				<div class="row formSep2">
					<div class="col-xs-4 col-md-2" style="white-space:nowrap;">เงินค่าตอบแทนพิเศษ</div>
					<div class="col-xs-4 col-md-2 col-md-offset-5" >
						<input type="text" id="POS_FRAME_COMPENSATION_2" name="POS_FRAME_COMPENSATION_2" class="form-control" placeholder="เงินค่าตอบแทนพิเศษ" maxlength="13" value="<?php echo number_format($data['POS_FRAME_COMPENSATION_2'],2); ?>" onBlur="NumberFormat(this,2)" style="text-align:right;" >
					</div>
					<div class="col-xs-4 col-md-2" >
						<input type="text" id="POS_TRUE_COMPENSATION_2" name="POS_TRUE_COMPENSATION_2" class="form-control" placeholder="เงินค่าตอบแทนพิเศษ" maxlength="13" value="<?php echo number_format($data['POS_TRUE_COMPENSATION_2'],2); ?>" onBlur="NumberFormat(this,2)" style="text-align:right;" >
					</div>					
				</div> 
				<div class="row head-form">ข้อมูลการเคลื่อนไหวสำคัญของตำแหน่ง</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่อนุมัติกรอบตำแหน่ง </div>
					<div class="col-xs-12 col-md-2">
						<div id="DIV_POS_DATE_EFFECTIVE" class="input-group datepicker">
							<input type="text" id="POS_DATE_EFFECTIVE" name="POS_DATE_EFFECTIVE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date(text($data['POS_DATE_EFFECTIVE'])); ?>">
							<span class="input-group-addon datepicker" for="POS_DATE_EFFECTIVE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
						</div>
					</div>
					<div class="col-xs-12 col-md-2 col-md-offset-2" style="white-space:nowrap;">วันที่ตำแหน่งมีเงิน </div>
					<div class="col-xs-12 col-md-2">
						<div id="DIV_POS_DATE_SALARY" class="input-group datepicker">
							<input type="text" id="POS_DATE_SALARY" name="POS_DATE_SALARY" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date(text($data['POS_DATE_SALARY'])); ?>">
							<span class="input-group-addon datepicker" for="POS_DATE_SALARY">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
						</div>
					</div>					
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานะของตำแหน่ง <span style="color:red;">*</span></div>
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
					<div class="col-xs-12 col-md-2 col-md-offset-2" style="white-space:nowrap;">สถานะของการร้องขอ </div>
					<div class="col-xs-12 col-md-3">ปกติ</div>
					<input name="POS_STATUS_REQUEST" type="hidden" id="POS_STATUS_REQUEST" value="1" />
				</div>
				<div class="formlast">
					<div class="col-xs-12 col-md-12" align="center">
					<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
					<button type="button" class="btn btn-default" onClick="self.location.href='ss_position_per_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>