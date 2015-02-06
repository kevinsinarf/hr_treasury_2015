<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;
$paramlink = url2code($link);
$txt = ($proc == "add") ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล";
$path_img=$path.'fileupload/file_position_frame/';
$sub_menu = "สำนักงานเลขาธิการวุฒิสภา";

if($proc == 'add'){
	$query_frame  = $db->query("SELECT MAX(CAST(POS_NO AS INT)) AS POS_NO_MAX FROM POSITION_FRAME WHERE POSTYPE_ID = 1 AND ORG_ID_2 = 16 ");
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
$sql_co = "SELECT A.CO_ID, A.TYPE_ID, B.LEVEL_SEQ AS LEVEL_SEQ_MIN, C.LEVEL_SEQ AS LEVEL_SEQ_MAX FROM SETUP_POS_CO_LEVEL A
		   JOIN SETUP_POS_LEVEL B ON A.LEVEL_ID_MIN = B.LEVEL_ID AND A.TYPE_ID = B.TYPE_ID
		   JOIN SETUP_POS_LEVEL C ON A.LEVEL_ID_MAX = C.LEVEL_ID AND A.TYPE_ID = C.TYPE_ID 
		   WHERE A.ACTIVE_STATUS =1 AND B.POSTYPE_ID = 1 AND  C.POSTYPE_ID = 1 AND A.TYPE_ID = '".$data['TYPE_ID']."' ";
$query_co = $db->query($sql_co);
$i = 0;
while($rec_co = $db->db_fetch_array($query_co)){
	$query_co_level = $db->query("SELECT LEVEL_NAME_TH FROM SETUP_POS_LEVEL WHERE TYPE_ID = '".$rec_co['TYPE_ID']."' AND LEVEL_SEQ BETWEEN '".$rec_co['LEVEL_SEQ_MIN']."' AND '".$rec_co['LEVEL_SEQ_MAX']."' AND POSTYPE_ID = 1 ORDER BY LEVEL_SEQ ASC   ");
	$arr_co_id[] = trim($rec_co['CO_ID']);
	while($rec_co_level = $db->db_fetch_array($query_co_level)){
		$arr_co[trim($rec_co['CO_ID'])][$i] = text($rec_co_level['LEVEL_NAME_TH']);
		$i++;
	}
}

//$array
if(count($arr_co_id) > 0){
	foreach($arr_co_id as $index => $val){
		$text = @implode(' / ', $arr_co[$val]);
		$arr_co_level1[$val] = $text;
	}
}

$arr_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' AND POSTYPE_ID = 1 and DELETE_FLAG='0' AND TYPE_ID = '".$data['TYPE_ID']."' ", "LEVEL_SEQ");
$arr_salary = GetSqlSelectArray("SALARYTITLE_ID", "SALARYTITLE_NAME_TH", "SETUP_POS_SALARY_TITLE", "1=1", "SALARYTITLE_NAME_TH");
$arr_edu_level = GetSqlSelectArray("EL_ID", "EL_NAME_TH", "SETUP_EDU_LEVEL", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0", "EL_SEQ"); 
$arr_line_group = GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND TYPE_ID = '".$data['TYPE_ID']."' ", "LG_NAME_TH");  
$arr_type_manage = GetSqlSelectArray("MT_ID", "MT_NAME_TH", "SETUP_POS_MANAGE_TYPE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0  ", "MT_SEQ"); 
$arr_manage = GetSqlSelectArray("MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND MT_ID = '".$data['MT_ID']."' ", "MANAGE_NAME_TH"); 
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
<script src="js/ss_position_senator_per_official_form.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li><a href="ss_position_senator_per_office_disp.php?<?php echo $paramlink; ?>"><?php echo showMenu($menu_sub_id)." (".$sub_menu.")"; ?></a></li>
			<li class="active"><?php echo $txt; ?></li>
		</ol>
	</div>
	<div class="col-xs-12 col-sm-12" id="content">
		<div class="groupdata" >
			<form id="frm-input" method="post" action="process/ss_position_senator_per_official_process.php"enctype="multipart/form-data">
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
							$sql_org_3 = "Select ORG_ID, ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = 16 ORDER BY ORG_SEQ ASC";
							$query_org_3 = $db->query($sql_org_3);
							$select_org_3[$data['ORG_ID_3']] = "Selected='Selected'";
							while($org = $db->db_fetch_array($query_org_3)){
								echo '<option value="'.$org['ORG_ID'].'" '.$select_org_3[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
							}
							?>
						</select>
					</div>
					<div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">กลุ่มงาน :</div>
					<div class="col-xs-12 col-md-3">
						<select id="ORG_ID_4" name="ORG_ID_4" class="selectbox form-control" placeholder="กลุ่มงาน">
							<option value=""></option>
							<?php
							if(!empty($data['ORG_ID_4'])){
								$sql_org_4 = "Select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$data['ORG_ID_3']."' ORDER BY ORG_SEQ ASC";
								$query_org_4 = $db->query($sql_org_4);
								$select_org_4[$data['ORG_ID_4']] = "Selected='Selected'";
								while($org = $db->db_fetch_array($query_org_4)){
									echo '<option value="'.$org['ORG_ID'].'" '.$select_org_4[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
								}
							}
							?>
						</select>
					</div>
				</div>
			  <div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ตำแหน่ง : <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3">
						<input type="text" id="POS_NO" name="POS_NO" class="form-control" placeholder="เลขที่ตำแหน่ง" maxlength="10" value="<?php echo $pos_no; ?>" onKeyUp="check_number(this.value,'POS_NO');" style="width:100px;" >
					</div>
					
                <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ระดับการศึกษาแรกบรรจุ :</div>
					<div class="col-xs-12 col-md-3">
                    	<select id="EL_ID" name="EL_ID" class="selectbox form-control" placeholder="ระดับการศึกษาแรกบรรจุ" style="width: 400px;">
                        <option value=""></option>
						<?php
						$t = "";
                        $q_edu = $db->query("SELECT EL_ID,EL_GROUP, EL_NAME_TH, EL_TYPE FROM SETUP_EDU_LEVEL WHERE ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' AND EL_GROUP > 6 ORDER BY EL_TYPE, EL_ID");
                        while($r_edu = $db->db_fetch_array($q_edu)){
                            if($t != $r_edu['EL_TYPE']){
								echo ($t != '' ? "" : "</optgroup>");
								?>
								<optgroup label="<?php echo $arr_edu_level_m[$r_edu['EL_TYPE']];?>">
								<?php 
								$t = $r_edu['EL_TYPE'];
							}
							?>
							<option value="<?php echo $r_edu['EL_ID']?>" <?php echo ($r_edu['EL_ID'] == $data['EL_ID'] ? "selected" : "");?> ><?php echo text($r_edu['EL_NAME_TH']);?></option>
							<?php
                        }
                        ?>
                    </select>
                    </div>
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทตำแหน่ง : <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3">
						<select id="TYPE_ID" name="TYPE_ID" class="selectbox form-control" placeholder="ประเภทตำแหน่ง" onChange="get_level(this); get_co_level(this); get_line_group(this); ">
							<option value=""></option>
							<?php
							$sql_type_name = "Select TYPE_ID , TYPE_NAME_TH From SETUP_POS_TYPE WHERE ACTIVE_STATUS = 1 AND POSTYPE_ID = '1' AND DELETE_FLAG = 0 ORDER BY TYPE_SEQ ASC";
							$query_type_name = $db->query($sql_type_name);
							$select_type[$data['TYPE_ID']] = "Selected='Selected'";
							while($type = $db->db_fetch_array($query_type_name)){
								echo '<option value="'.$type['TYPE_ID'].'" '.$select_type[$type['TYPE_ID']].' >'.text($type['TYPE_NAME_TH']).'</option>';
							}
							?>
						</select>
					</div>
                    <div class="col-xs-12 col-md-2 col-md-offset-1" >ระดับ :</div>
					<div class="col-xs-12 col-md-3">
						<?php echo GetHtmlSelect('LEVEL_ID', 'LEVEL_ID',$arr_level , 'ระดับ' ,$data['LEVEL_ID'] ,'', '1', '', ''); ?>
				  </div>
				</div>
                <div class="row formSep">
                <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ระดับตำแหน่ง : <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-9">
						<?php echo GetHtmlSelectNoConv('CO_ID', 'CO_ID',$arr_co_level1, 'ระดับตำแหน่ง' ,$data['CO_ID'] ,'onChange="get_level_salary(this.value);" ', '1', '', ''); ?>
				  </div>
                 </div>
                 <div class="row formSep" >
                <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ช่วงเงินเดือน :</div>
					<div class="col-xs-12 col-md-2">
                        <div class="row">
                        <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">&nbsp;</div>
                            <div class="col-xs-12 col-md-9">
                                
                          </div>
                          </div>
                    	<div class="row">
                        <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ขั้นต่ำ</div>
                            <div class="col-xs-12 col-md-9">
                                
                          </div>
                       </div>
                       <div class="row">
                        <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ขั้นสูง</div>
                            <div class="col-xs-12 col-md-9">
                                
                          </div>
                       </div>
						
						
				  </div>
                  <div  id="salary" >
                     
						
				  </div>
                 </div>
				<div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สายงาน : <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3" >
						<?php echo GetHtmlSelect('LG_ID', 'LG_ID',$arr_line_group , 'สายงาน' ,$data['LG_ID'] ,'onChange="get_line(this);"', '1', '', ''); ?>	
					</div>	
					<div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ตำแหน่งในสายงาน : <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3" >
						<select id="LINE_ID" name="LINE_ID" class="selectbox form-control" placeholder="ตำแหน่งในสายงาน" >
							<option value=""></option>
							<?php
							if(!empty($data['LINE_ID'])){
								$sql_line_name = "Select LINE_ID , LINE_NAME_TH From SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND TYPE_ID = ".$data['TYPE_ID']." AND POSTYPE_ID = 1 ORDER BY LINE_NAME_TH ASC";
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
					<div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ประเภทตำแหน่งทางการบริหาร :</div>
					<div class="col-xs-12 col-md-3">
						<?php echo GetHtmlSelect('MT_ID', 'MT_ID',$arr_type_manage , 'ตำแหน่งในสายงานบริหาร' ,$data['MT_ID'] ,'onChange="get_manage(this);"', '1', '', ''); ?>
					</div>
                    <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ตำแหน่งทางการบริหาร : </div>
					<div class="col-xs-12 col-md-3">
						<?php echo GetHtmlSelect('MANAGE_ID', 'MANAGE_ID',$arr_manage, 'ตำแหน่งในสายงานบริหาร' ,$data['MANAGE_ID'] ,'', '1', '', ''); ?>		
					</div>
			  </div>
              <div class="row formSep">
                    <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">หมายเหตุของตำแหน่ง :</div>
                    <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('REMARK_ID', 'REMARK_ID',$arr_remark, 'หมายเหตุของตำแหน่ง' ,$data['REMARK_ID'] ,'', '1', '', ''); ?></div>
                    <div class="col-xs-12 col-md-1"></div>
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
                <input type="hidden" id="OLD_NAMEHIS_FILE" name="OLD_NAMEHIS_FILE"   value="<?php echo !empty($data["POS_FILE"])?text($data["POS_FILE"]):""; ?>">
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
					<div class="col-xs-4 col-md-2" style="white-space:nowrap;">เงินเดือน :</div>
					<div class="col-xs-4 col-md-3" >
						<?php echo number_format($rec_per['PER_SALARY'],2); ?>
					</div>	
                    <div class="col-xs-4 col-md-2 col-md-offset-1" >เงินประจำตำแหน่ง :</div>
					<div class="col-xs-4 col-md-3" >
						<?php echo number_format($rec_per['PER_SALARY_POSITION'],2); ?>
					</div>					
				</div>
				<div class="row formSep">
					<div class="col-xs-4 col-md-2" style="white-space:nowrap;">ค่าตอบแทน :</div>
					<div class="col-xs-4 col-md-3" >
						<?php echo number_format($rec_per['PER_COMPENSATION_1'],2); ?>
					</div>	
                    <div class="col-xs-4 col-md-2 col-md-offset-1">ค่าตอบแทนพิเศษ :</div>
					<div class="col-xs-4 col-md-2" >
						<?php echo number_format($rec_per['PER_COMPENSATION_2'],2); ?>
				</div>
               </div>
                <?php } ?>
              
				<div class="row head-form">ข้อมูลเงินเดือน/เงินประจำตำแหน่ง/ค่าตอบแทน/ค่าตอบแทนพิเศษ</div>
					
				<div class="row formSep">
					<div class="col-xs-4 col-md-2" style="white-space:nowrap;">เงินเดือน : <span style="color:red;">*</span></div>
					<div class="col-xs-4 col-md-2" >
						<input type="text" id="POS_FRAME_SALARY" name="POS_FRAME_SALARY" class="form-control" placeholder="เงินเดือน" maxlength="20" value="<?php echo number_format($data['POS_FRAME_SALARY'],2); ?>" onBlur="NumberFormat(this,2)" style="text-align:right;" >
					</div>	
                    <div class="col-xs-4 col-md-2 col-md-offset-2" >เงินประจำตำแหน่ง : </div>
					<div class="col-xs-4 col-md-2" >
						<input type="text" id="POS_FRAME_POSITION_SALARY" name="POS_FRAME_POSITION_SALARY" class="form-control" placeholder="เงินประจำตำแหน่ง" maxlength="20" value="<?php echo number_format($data['POS_FRAME_POSITION_SALARY'],2); ?>" onBlur="NumberFormat(this,2)" style="text-align:right;" >
					</div>					
				</div>
				<div class="row formSep">
					<div class="col-xs-4 col-md-2" style="white-space:nowrap;">ค่าตอบแทน :</div>
					<div class="col-xs-4 col-md-2" >
						<input type="text" id="POS_FRAME_COMPENSATION_1" name="POS_FRAME_COMPENSATION_1" class="form-control" placeholder="เงินค่าตอบแทน" maxlength="20" value="<?php echo number_format($data['POS_FRAME_COMPENSATION_1'],2); ?>" onBlur="NumberFormat(this,2)" style="text-align:right;" >
					</div>	
                    <div class="col-xs-4 col-md-2 col-md-offset-2">ค่าตอบแทนพิเศษ :</div>
					<div class="col-xs-4 col-md-2" >
						<input type="text" id="POS_FRAME_COMPENSATION_2" name="POS_FRAME_COMPENSATION_2" class="form-control" placeholder="เงินค่าตอบแทนพิเศษ" maxlength="20" value="<?php echo number_format($data['POS_FRAME_COMPENSATION_2'],2); ?>" onBlur="NumberFormat(this,2)" style="text-align:right;" >
					</div>						
				</div>
                
                
				<div class="row head-form">ข้อมูลการเคลื่อนไหวสำคัญของตำแหน่ง</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่อนุมัติกรอบตำแหน่ง :</div>
					<div class="col-xs-12 col-md-2">
						<div id="DIV_POS_DATE_EFFECTIVE" class="input-group datepicker">
							<input type="text" id="POS_DATE_EFFECTIVE" name="POS_DATE_EFFECTIVE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date(text($data['POS_DATE_EFFECTIVE'])); ?>">
							<span class="input-group-addon datepicker" for="POS_DATE_EFFECTIVE">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
						</div>
					</div>
					<div class="col-xs-12 col-md-2 col-md-offset-2" style="white-space:nowrap;">วันที่อนุมัติเงินตำแหน่ง :</div>
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
					<button type="button" class="btn btn-default" onClick="self.location.href='ss_position_senator_per_office_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>