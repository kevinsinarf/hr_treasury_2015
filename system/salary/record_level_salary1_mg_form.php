<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$txt = "บันทึกข้อมูล"; 
$MT_ID = $_POST['MT_ID'];
$POSTYPE_ID = 1;
$ORG_ID_2 = 15;

if($s_name != ""){
	$filter .= " and (PER_PROFILE.PER_FIRSTNAME_TH like '%".ctext($s_name)."%' OR PER_PROFILE.PER_MIDNAME_TH like '%".ctext($s_name)."%' OR PER_PROFILE.PER_LASTNAME_TH like '%".ctext($s_name)."%') ";
}
if(!empty($S_TYPE_ID) && $S_TYPE_ID != 'undefined'){
	$filter .= " AND  PER_PROFILE.TYPE_ID = ".$S_TYPE_ID;
}
if(!empty($S_POS_YEAR) && $S_POS_YEAR != 'undefined'){
	$filter .= " AND PER_PROFILE.POS_YEAR = ".$S_POS_YEAR;
}
if(!empty($S_LEVEL_ID) && $S_LEVEL_ID != 'undefined'){
	$filter .= " AND PER_PROFILE.LEVEL_ID = ".$S_LEVEL_ID;
}
if(!empty($S_LINE_ID) && $S_LINE_ID != 'undefined'){
	$filter .= " AND PER_PROFILE.LINE_ID = ".$S_LINE_ID;
}
if(!empty($S_ORG_ID_3) && $S_ORG_ID_3 != 'undefined'){
	$filter .= " AND PER_PROFILE.ORG_ID_3 = ".$S_ORG_ID_3;
}
if(!empty($S_LG_ID) && $S_LG_ID != 'undefined'){
	$filter .= " AND PER_PROFILE.LG_ID = ".$S_LG_ID;
}
if(!empty($S_ORG_ID_4) && $S_ORG_ID_4 != 'undefined'){
	$filter .= " AND PER_PROFILE.ORG_ID_4 = ".$S_ORG_ID_4;
}
if(!empty($S_POS_STATUS) && $S_POS_STATUS != 'undefined'){
	$filter .= " AND PER_PROFILE.POS_STATUS = ".$S_POS_STATUS;
}
if(!empty($S_POS_NO) && $S_POS_NO != 'undefined'){
	$filter .= " AND PER_PROFILE.POS_NO = ".trim($S_POS_NO);
}

$MANAGE_NAME = $db->get_data_field("SELECT MT_NAME_TH FROM SETUP_POS_MANAGE_TYPE WHERE MT_ID = '".$MT_ID."'", "MT_NAME_TH");

$field = "PER_ID, PREFIX_ID, PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH, POS_ID, PER_PROFILE.TYPE_ID, TYPE_NAME_TH, PER_PROFILE.LEVEL_ID, LEVEL_NAME_TH, LINE_NAME_TH, B.ORG_NAME_TH, PER_SALARY, PER_COMPENSATION_2, ORG_ID_4, ORG_ID_3";
$table = "PER_PROFILE LEFT JOIN SETUP_POS_TYPE ON SETUP_POS_TYPE.TYPE_ID = PER_PROFILE.TYPE_ID
		  LEFT JOIN SETUP_POS_LEVEL ON SETUP_POS_LEVEL.LEVEL_ID = PER_PROFILE.LEVEL_ID
		  LEFT JOIN SETUP_POS_LINE ON SETUP_POS_LINE.LINE_ID = PER_PROFILE.LINE_ID
		  LEFT JOIN SETUP_ORG B ON B.ORG_ID = PER_PROFILE.ORG_ID_4
		  LEFT JOIN SETUP_ORG C ON PER_PROFILE.ORG_ID_3 = C.ORG_ID ";
$pk_id = "PER_ID";
$wh = "PER_PROFILE.DELETE_FLAG = '0' AND PER_PROFILE.ACTIVE_STATUS = '1' AND PT_ID = '1' AND MT_ID = '".$MT_ID."' {$filter}";
$orderby = "order by TYPE_NAME_TH ASC";
$notin = $wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

$arr_org4 = GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ".$cond_org."", "ORG_SEQ");
$arr_line_group = GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 ".$cond_lg, "LG_NAME_TH");
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
<script src="js/record_level_salary1_mg_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-sm-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li><a href="record_level_salary1_mg_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&S_YEAR_BDG=".$S_YEAR_BDG."&S_ROUND=".$S_ROUND."&proc=search");?>">บันทึกการเลื่อนขั้นเงินเดือนผู้บริหาร</a></li>
			<li class="active"><?php echo $txt;?></li>
		</ol>
	</div>
	<div class="col-xs-12 col-sm-12" id="content">
		<div class="groupdata">
		<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
			<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
			<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
			<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
			<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
			<input type="hidden" id="S_YEAR_BDG" name="S_YEAR_BDG" value="<?php echo $S_YEAR_BDG; ?>">
			<input type="hidden" id="S_ROUND" name="S_ROUND" value="<?php echo $S_ROUND; ?>">
			<input type="hidden" id="MANAGE_ID" name="MANAGE_ID" value="<?php echo $MANAGE_ID;?>">
            <input type="hidden" id="MT_ID" name="MT_ID" value="<?php echo $MT_ID;?>">
            
			<div class="row">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ปีงบประมาณ : </div>
				<div class="col-xs-12 col-md-2"><?php echo $S_YEAR_BDG;?></div>
				<div class="col-xs-12 col-md-3"></div>
                <div class="col-xs-12 col-md-1">รอบ :  </div>
				<div class="col-xs-12 col-md-1"><?php echo $S_ROUND;?></div>
			</div>
            
			<div class="row">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ตำแหน่งทางการบริหาร : </div>
				<div class="col-xs-12 col-md-2"><?php echo text($MANAGE_NAME);?></div>
				<div class="col-xs-12 col-md-1"></div>
			</div>
            <div class="row">
					
						<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ประเภทตำแหน่ง :</div>
						<div class="col-xs-12 col-sm-2">
							<select id="S_TYPE_ID" name="S_TYPE_ID" class="selectbox form-control" placeholder="-ทั้งหมด-" onChange="get_level(this); get_line_group(this);">
								<option value=""></option>
								<?php
								$sql_type_name = "Select TYPE_ID , TYPE_NAME_TH From SETUP_POS_TYPE WHERE ACTIVE_STATUS = 1 AND POSTYPE_ID = '".$POSTYPE_ID."' AND DELETE_FLAG = 0 ORDER BY TYPE_SEQ ASC";
								$query_type_name = $db->query($sql_type_name);
								$select_type[$S_TYPE_ID] = "Selected='Selected'";
								while($type = $db->db_fetch_array($query_type_name)){
									echo '<option value="'.$type['TYPE_ID'].'" '.$select_type[$type['TYPE_ID']].' >'.text($type['TYPE_NAME_TH']).'</option>';
								}
								?>
							</select>
						</div>
                       <div class="col-xs-12 col-md-3"></div>
					   <div class="col-xs-12 col-sm-2 col-md-2" style="white-space:nowrap;">ระดับ :</div>
                      <div class="col-xs-12 col-sm-4 col-md-2">
                          <select id="S_LEVEL_ID" name="S_LEVEL_ID" class="selectbox form-control" placeholder="-ทั้งหมด-" >
                              <option value=""></option>
                              <?php
                              //$cond_level = ($S_TYPE_ID != '') ? " and TYPE_ID = '".$S_TYPE_ID."'" : "";
							  $cond_level =  " and TYPE_ID = '".$S_TYPE_ID."'";
                              $sql_level_name = "Select LEVEL_ID , LEVEL_NAME_TH  From SETUP_POS_LEVEL WHERE ACTIVE_STATUS = 1 AND POSTYPE_ID = '".$POSTYPE_ID."' AND DELETE_FLAG = '0'".$cond_level." ORDER BY LEVEL_SEQ ASC";
                              //$sql_level_name = "SELECT LEVEL_ID , LEVEL_NAME_TH FROM SETUP_POS_LEVEL WHERE POSTYPE_ID = '$POSTYPE_ID' AND DELETE_FLAG='0' AND TYPE_ID='1' ORDER BY LEVEL_NAME_TH asc";
                                  $select_level[$S_LEVEL_ID] = "Selected='Selected'";
                                  $query_level_name = $db->query($sql_level_name);
                                  while($level = $db->db_fetch_array($query_level_name)){
                                      echo '<option value="'.$level['LEVEL_ID'].'" '.$select_level[$level['LEVEL_ID']].'>'.text($level['LEVEL_NAME_TH']).'</option>';
                                  }
                              ?>
                          </select>
                      </div>
						
                       </div>
			<div class="row">
                     <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สายงาน :</div>
                      <div class="col-xs-12 col-md-2" >
                          <?php echo GetHtmlSelect('S_LG_ID', 'S_LG_ID',$arr_line_group , 'สายงาน' ,$S_LG_ID ,'onChange="get_line(this);"', '1', '', ''); ?>	
                      </div>
                      <div class="col-xs-12 col-md-3"></div>	
                      <div class="col-xs-12 col-sm-2 col-md-2" style="white-space:nowrap;">ตำแหน่งในสายงาน :</div>
                      <div class="col-xs-12 col-sm-4 col-md-2">                                        
                          <select id="S_LINE_ID" name="S_LINE_ID" class="selectbox form-control" placeholder="-ทั้งหมด-" >
                              <option value=""></option>
                              <?php
                          
                              $cond_type = ($S_LG_ID != '') ? " and LG_ID = '".$S_LG_ID."'" : "";
                              $sql_line_name="SELECT LINE_ID , LINE_NAME_TH FROM SETUP_POS_LINE WHERE DELETE_FLAG='0' AND POSTYPE_ID = '$POSTYPE_ID'".$cond_type." ORDER BY LINE_NAME_TH ASC";
                              $select_line[$S_LINE_ID] = "Selected='Selected'";
                              $query_line_name = $db->query($sql_line_name);
                              while($line = $db->db_fetch_array($query_line_name)){
                                  echo '<option value="'.$line['LINE_ID'].'" '.$select_line[$line['LINE_ID']].'>'.text($line['LINE_NAME_TH']).'</option>';
                              }
                              ?>
                          </select>
                      </div>
                </div> 
			<div class="row">
					<div class="col-xs-12 col-sm-2 col-md-2" style="white-space:nowrap;">สำนัก/กลุ่ม :</div>
					<div class="col-xs-12 col-sm-4 col-md-2">
						<select id="S_ORG_ID_3" name="S_ORG_ID_3" class="selectbox form-control" placeholder="-ทั้งหมด-" onChange="get_org_4(this);">
							<option value=""></option>
							<?php
							$sql_org_3 = "Select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND OL_ID = 16 AND ORG_PARENT_ID = '".$ORG_ID_2."' ORDER BY ORG_SEQ ASC";
							$query_org_3 = $db->query($sql_org_3);
							$select_org_3[$S_ORG_ID_3] = "Selected='Selected'";
							while($org = $db->db_fetch_array($query_org_3)){
								echo '<option value="'.$org['ORG_ID'].'" '.$select_org_3[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
							}
							?>
						</select>
					</div>
                    <div class="col-xs-12 col-md-3"></div>
					<div class="col-xs-12 col-sm-2 col-md-2" style="white-space:nowrap;">กลุ่มงาน :</div>
					<div class="col-xs-12 col-sm-4 col-md-2">
						<select id="S_ORG_ID_4" name="S_ORG_ID_4" class="selectbox form-control" placeholder="-ทั้งหมด-" >
							<option value=""></option>
							<?php
							$cond_org4 = ($S_ORG_ID_3 != '') ? " AND ORG_PARENT_ID = '".$S_ORG_ID_3."'" : "";
							$sql_org_4 = "Select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' ".$cond_org4." ORDER BY ORG_SEQ ASC";
							$query_org_4 = $db->query($sql_org_4);
							$select_org_4[$S_ORG_ID_4] = "Selected='Selected'";
							while($org = $db->db_fetch_array($query_org_4)){
								echo '<option value="'.$org['ORG_ID'].'" '.$select_org_4[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
							}
							?>
						</select>
					</div>
				</div>                   
			<div class="row">
                    <div class="col-xs-12 col-sm-2 col-md-2" style="white-space:nowrap;">เลขที่ตำแหน่ง :</div>
                    <div class="col-xs-12 col-sm-4 col-md-2"><input type="text" name="S_POS_NO" id="S_POS_NO" value="<?php echo $S_POS_NO;?>" class="form-control"></div>
					<div class="col-xs-12 col-md-3"></div>
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['name'];?> :</div>
                    <div class="col-xs-12 col-sm-2">
            <input type="text" id="s_name" name="s_name" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $s_name; ?>">
           			</div>
				</div>
            <div class="row">
                <div class="col-xs-12 col-sm-12" align="center"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
            </div>
			
			<div class="row"><?php echo ($nums>0) ? startPaging("frm-search",$total_record):""; ?></div>

			<div class="table-responsive">
                <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                    <thead class="bgHead">
                        <tr>
                          <th width="3%" rowspan="2"><div align="center"><strong>ลำดับ</strong></div></th>
                          <th width="14%" rowspan="2"><div align="center"><strong>ชื่อ-ชื่อสกุล</strong></div></th>
                          <th width="6%" rowspan="2"><div align="center"><strong>เงินเดือน<br>ปัจจุบัน</strong></div></th>
                          <th width="6%" rowspan="2"><div align="center"><strong>ค่าตอบแทนพิเศษ</strong></div></th>
                          <th width="6%" rowspan="2"><div align="center"><strong>ฐานในการคำนวณ</strong></div></th>
                          <th width="6%" rowspan="2"><div align="center"><strong>คะแนนผล<br>ปฏิบัติงาน</strong></div></th>
                          <th width="6%" rowspan="2"><div align="center"><strong>ร้อยละที่ได้เลื่อน</strong></div></th>
                          <th colspan="2"><div align="center"><strong>จำนวนเงินที่ได้เลื่อน</strong></div></th>
                          <th colspan="2"><div align="center"><strong>จำนวนเงินที่ได้จริง</strong></div></th>
                          <th width="12%" rowspan="2" nowrap><div align="center"><strong>หมายเหตุ</strong></div></th>
                        </tr>
                        <tr class="bgHead">
                          <th width="6%"><div align="center"><strong>เงินเดือน</strong></div></th>
                          <th width="6%" nowrap><div align="center"><strong>ค่าตอบแทนพิเศษ</strong></div></th>
                          <th width="6%"><div align="center"><strong>เงินเดือน</strong></div></th>
                          <th width="6%" nowrap><div align="center"><strong>ค่าตอบแทนพิเศษ</strong></div></th>
                        </tr>
                    </thead>
                    <tbody >
                    <?php
					if($nums > 0){
						$i = 1;
						while($rec = $db->db_fetch_array($query)){
							$PER_NAME = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
							$POSITION_NO = (trim($db->get_pos_no($rec['PER_ID']))!='') ? $db->get_pos_no($rec['PER_ID']) : '-';
							$LINE_NAME = (trim($rec['LINE_NAME_TH']) != '') ? text($rec['LINE_NAME_TH']) : '-';
							$LEVEL_NAME = (trim($rec['LEVEL_NAME_TH']) != '') ? text($rec['LEVEL_NAME_TH']) : '-';
							$ORG_NAME = (trim($rec['ORG_NAME_TH']) != '') ? text($rec['ORG_NAME_TH']) : '-';
							$POSITION_NAME = '<strong>เลขที่ตำแหน่ง : </strong>'.$POSITION_NO.'<br><strong>สายงานตำแหน่ง : </strong>'.$LINE_NAME.'<br><strong>ระดับตำแหน่ง : </strong>'.$LEVEL_NAME.'<br><strong>กลุ่มงาน : </strong>'.$ORG_NAME;
							
							$LEVEL_SALARY_MID = $db->get_data_field("SELECT LEVEL_SALARY_MID FROM SETUP_POS_LEVEL_SALARY WHERE POSTYPE_ID = '1' AND TYPE_ID = '".$rec['TYPE_ID']."' AND LEVEL_ID = '".$rec['LEVEL_ID']."' AND '".$rec['PER_SALARY']."' BETWEEN LEVEL_SALARY_MIN AND LEVEL_SALARY_MAX", "LEVEL_SALARY_MID");
							$q_edit = $db->query("SELECT * FROM SAL_UP_SALARY WHERE YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND PER_ID = '".$rec['PER_ID']."'");
							$r_edit = $db->db_fetch_array($q_edit);
							
								$pms = $db->get_data_field("SELECT * FROM PMS_FORM WHERE YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND PER_ID = '".$rec['PER_ID']."'" ,"FINAL_SCORE");
							if($r_edit['SCORE']>0){
								$final = $r_edit['SCORE'];
								}
								else{
									$final = $pms;
								}
							
							?>
                            <input type="hidden" name="PER_ID[<?php echo $i;?>]" id="PER_ID_<?php echo $i;?>" value="<?php echo $rec['PER_ID'];?>">
                            <input type="hidden" name="SAL_UP_ID[<?php echo $i;?>]" id="SAL_UP_ID_<?php echo $i;?>" value="<?php echo $r_edit['SAL_UP_ID'];?>">
                            <input type="hidden" name="SCORE_ID[<?php echo $i;?>]" id="SCORE_ID_<?php echo $i;?>" value="<?php echo $r_edit['SCORE_ID'];?>">
                            <input type="hidden" name="SALARY_NOW[<?php echo $i;?>]" id="SALARY_NOW_<?php echo $i;?>" value="<?php echo number_format($rec['PER_SALARY'],2);?>"><!-- เงินเดือนปัจจุบัน-->
                            <input type="hidden" name="SALARY_SPE_NOW[<?php echo $i;?>]" id="SALARY_SPE_NOW_<?php echo $i;?>" value="<?php echo number_format($rec['PER_COMPENSATION_2'],2);?>"><!-- ค่าตอบแทนพิเศษ-->
                            <input type="hidden" name="LEVEL_SALARY_MID[<?php echo $i;?>]" id="LEVEL_SALARY_MID_<?php echo $i;?>" value="<?php echo number_format($LEVEL_SALARY_MID,2);?>"><!-- ฐานในการคำนวณ-->
                            <input type="hidden" name="SALARY_CAL[<?php echo $i;?>]" id="SALARY_CAL_<?php echo $i;?>" value="<?php echo number_format($r_edit['SALARY_CAL'],2);?>"> 
                            <input type="hidden" name="SALARY_NEW[<?php echo $i;?>]" id="SALARY_NEW_<?php echo $i;?>" value="<?php echo number_format($r_edit['SALARY_NEW'],2);?>"> <!-- เงินเดือนใหม่-->
                            <input type="hidden" name="SALARY_SPE_NEW[<?php echo $i;?>]" id="SALARY_SPE_NEW_<?php echo $i;?>" value="<?php echo number_format($r_edit['SALARY_SPE_NEW'],2);?>">  <!--เงินเดือนพิเศษที่เกินกรอบ-->
                            <tr>
								<td align="center"><?php echo $i;?>.</td>
								<td align="left"><?php echo $PER_NAME."<br>".$POSITION_NAME;?>&nbsp;</td>
								<td align="right"><?php echo number_format($rec['PER_SALARY'],2);?>&nbsp;</td>
								<td align="right"><?php echo number_format($rec['PER_COMPENSATION_2'],2);?>&nbsp;</td>
								<td align="right"><?php echo number_format($LEVEL_SALARY_MID,2);?>&nbsp;</td>
								<td align="center"><div class="score_final"><input type="text" name="SCORE[<?php echo $i;?>]" id="SCORE_<?php echo $i;?>" value="<?php echo number_format($r_edit['SCORE'],2);?>" class="form-control" maxlength="6" style="width:60px;display:inline" onBlur="NumberFormat(this,2);" onKeyUp="getPercent(this.value, '<?php echo $i;?>', '<?php echo $rec['PER_ID'];?>');"></div>&nbsp;</td>
								<td align="center"><input type="text" name="SCORE_PERCENT[<?php echo $i;?>]" id="SCORE_PERCENT_<?php echo $i;?>" value="<?php echo number_format($r_edit['SCORE_PERCENT'],2);?>" class="form-control" maxlength="6" style="width:60px;display:inline" onBlur="NumberFormat(this,2);" onKeyUp="getSalaryCal('<?php echo $i;?>');">&nbsp;</td>
								<!--<td align="right"><span id="shw_salary_cal_<?php echo $i;?>"><?php echo number_format($r_edit['SALARY_CAL'],2);?></span>&nbsp;</td>-->
								<td align="right"><input type="text" name="SALARY_UP[<?php echo $i;?>]" id="SALARY_UP_<?php echo $i;?>" value="<?php echo number_format($r_edit['SALARY_UP'],2);?>" class="form-control" maxlength="6" style="width:90px;display:inline;text-align:right;" onBlur="NumberFormat(this,2);" onKeyUp="calSalaryNew('<?php echo $i;?>');">&nbsp;</td>
								<td align="right"><input type="text" name="SALARY_SPE_UP[<?php echo $i;?>]" id="SALARY_SPE_UP_<?php echo $i;?>" value="<?php echo number_format($r_edit['SALARY_SPE_UP'],2);?>" class="form-control" maxlength="6" style="width:90px;display:inline;text-align:right;" onBlur="NumberFormat(this,2);" onKeyUp="calSalarySpeNew('<?php echo $i;?>');">&nbsp;</td>
								<td align="right"><span id="shw_salary_new_<?php echo $i;?>">
								<?php //echo number_format($r_edit['SALARY_NEW'],2);?></span> 
                                <input type="hidden" name="SHW_NEW[<?php echo $i;?>]" id="SHW_NEW_<?php echo $i;?>" value="">&nbsp;</td>
								<td align="right"><span id="shw_salary_spe_new_<?php echo $i;?>"><?php echo number_format($r_edit['SALARY_SPE_NEW'],2);?></span>&nbsp;</td>
								<td align="center"><input type="text" name="REMARKS[<?php echo $i;?>]" id="REMARKS_<?php echo $i;?>" value="<?php echo text($r_edit['REMARKS']);?>" class="form-control">&nbsp;</td>
							</tr>
							<?php
							$i++;
						}
					}else{
						echo "<tr><td align=\"center\" colspan=\"14\">ไม่พบข้อมูล</td></tr>";	
					}
                    ?>
                 	</tbody>
                </table>
			</div>
			
            
            <div class="formlast">
                <div class="col-xs-12 col-sm-12" align="center">
                    <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                  	<button type="button" class="btn btn-default" onClick="self.location.href='record_level_salary1_mg_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&S_YEAR_BDG=".$S_YEAR_BDG."&S_ROUND=".$S_ROUND."&proc=search");?>';">ยกเลิก</button></button>
                </div>
            </div>   
		</form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>