<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POST
$S_YEAR_BDG = $_POST['S_YEAR_BDG'];
$S_ROUND = $_POST['S_ROUND'];
$ORG_ID = $_POST['ORG_ID'];


$filter = "";
if($s_name != ""){
	$filter .= " and (A.NAME like '%".ctext($s_name)."%') ";
}
if(!empty($S_TYPE_ID) && $S_TYPE_ID != 'undefined'){
	$filter .= " AND  A.TYPE_ID = ".$S_TYPE_ID;
}
if(!empty($S_LEVEL_ID) && $S_LEVEL_ID != 'undefined'){
	$filter .= " AND A.LEVEL_ID = ".$S_LEVEL_ID;
}
if(!empty($S_LINE_ID) && $S_LINE_ID != 'undefined'){
	$filter .= " AND A.LINE_ID = ".$S_LINE_ID;
}
if(!empty($S_ORG_ID_3) && $S_ORG_ID_3 != 'undefined'){
	$filter .= " AND A.ORG_ID_3 = ".$S_ORG_ID_3;
}
if(!empty($S_LG_ID) && $S_LG_ID != 'undefined'){
	$filter .= " AND A.LG_ID = ".$S_LG_ID;
}
if(!empty($S_POS_NO) && $S_POS_NO != 'undefined'){
	$filter .= " AND A.POS_NO = ".trim($S_POS_NO);
}


$txt = "บันทึกข้อมูล"; 


$ORG_NAME = $db->get_data_field("SELECT ORG_NAME_TH FROM SETUP_ORG WHERE ORG_ID = '".$ORG_ID."'", "ORG_NAME_TH");

$field = " A.SAL_UP_ID, A.PER_ID, A.NAME, A.POS_ID, A.POS_NO, A.TYPE_ID, C.TYPE_NAME_TH, 
            A.LEVEL_ID, A.LINE_ID, D.LEVEL_NAME_TH, E.LINE_NAME_TH,  A.SALARY_NOW, A.SCORE, A.LEVEL_SALARY_MAX, A.SCORE_ID, A.SALARY_CAL,
			A.SALARY_NEW, A.SALARY_SPE_NEW, A.SCORE_PERCENT, A.SALARY_UP, A.SALARY_SPE_UP, A.REMARKS";
$table = "SAL_UP_SALARY A  
			LEFT JOIN SETUP_POS_TYPE C ON A.TYPE_ID = C.TYPE_ID
			LEFT JOIN SETUP_POS_LEVEL D ON A.LEVEL_ID = D.LEVEL_ID
			LEFT JOIN SETUP_POS_LINE E ON A.LINE_ID = E.LINE_ID";
			
$pk_id = " A.SAL_UP_ID ";
$wh = " A.POSTYPE_ID = 1 AND A.SAL_UP_TYPE = 1 AND A.CONFIRM_TYPE >= 2 AND A.YEAR_BDG = '".$S_YEAR_BDG."' AND A.ROUND = '".$S_ROUND."' AND  A.ORG_ID_3 = '".$ORG_ID."'  {$filter}";
$orderby = "order by A.POS_NO ASC";
$notin = $wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select ".$field." from ".$table." where ".$notin;

$query = $db->query($sql);
$nums = $db->db_num_rows($query);

$query_up = $db->query("SELECT COUNT(SAL_UP_ID)AS NUM_UP FROM SAL_UP_SALARY WHERE POSTYPE_ID = 1 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND ORG_ID_3 = '".$ORG_ID."' AND SAL_UP_TYPE = 1  AND CONFIRM_TYPE = 3 ");
$rec_up = $db->db_fetch_array($query_up);
$num_up = (int)$rec_up['NUM_UP'];

$arr_line_group = GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND TYPE_ID = '".$S_TYPE_ID."' ", "LG_NAME_TH");
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
<script src="js/record_level_salary1_org_form.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-sm-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li><a onClick="$('#page').val(1); $('#frm-search').attr('action','record_level_salary1_org_disp.php').submit(); " href="#">บันทึกการเลื่อนขั้นเงินเดือนข้าราชการตามสำนักข้าราชการ->บันทึกผล (ผู้ปฏิบัติงาน)</a></li>
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
			<input type="hidden" id="ORG_ID" name="ORG_ID" value="<?php echo $ORG_ID;?>">
           
			<div class="row">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ปีงบประมาณ : </div>
				<div class="col-xs-12 col-md-2"><?php echo $S_YEAR_BDG;?></div>
				<div class="col-xs-12 col-md-3"></div>
                <div class="col-xs-12 col-md-2">รอบ :  </div>
				<div class="col-xs-12 col-md-3"><?php echo $arr_round[$S_ROUND];?></div>
			</div>
            
			<div class="row">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">สำนัก : </div>
				<div class="col-xs-12 col-md-2"><?php echo text($ORG_NAME);?></div>
				<div class="col-xs-12 col-md-1"></div>
			</div>
             <div class="row">
             <div class="col-xs-12 col-sm-2 col-md-2" style="white-space:nowrap;">เลขที่ตำแหน่ง :</div>
             <div class="col-xs-12 col-sm-4 col-md-2"><input type="text" name="S_POS_NO" id="S_POS_NO" value="<?php echo $S_POS_NO;?>" class="form-control number"></div>
             <div class="col-xs-12 col-md-3"></div>
             <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ชื่อ-สกุล :</div>
             <div class="col-xs-12 col-sm-2">
                 <input type="text" id="s_name" name="s_name" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $s_name; ?>">
              </div>
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
                             
							  $cond_level =  " and TYPE_ID = '".$S_TYPE_ID."'";
                              $sql_level_name = "Select LEVEL_ID , LEVEL_NAME_TH  From SETUP_POS_LEVEL WHERE ACTIVE_STATUS = 1 AND POSTYPE_ID = '".$POSTYPE_ID."' AND DELETE_FLAG = '0'".$cond_level." ORDER BY LEVEL_SEQ ASC";
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
                              $sql_line_name="SELECT LINE_ID , LINE_NAME_TH FROM SETUP_POS_LINE WHERE DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' AND LG_ID = '".$S_LG_ID."' ORDER BY LINE_NAME_TH ASC";
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
                <div class="col-xs-12 col-sm-12" align="center"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
            </div>
			
			<div class="table-responsive">
                <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data" >
                    <thead class="bgHead">
                        <tr >
                          <th width="3%" rowspan="2" style="vertical-align:middle;"><div align="center"><strong>ลำดับ</strong></div></th>
                          <th width="15%" rowspan="2" style="vertical-align:middle;" ><div align="center"><strong>ชื่อ-สกุล</strong></div></th>
                          <th width="6%" rowspan="2" style="vertical-align:middle;" ><div align="center"><strong>เงินเดือน<br>ปัจจุบัน</strong></div></th>
                          <th width="6%" rowspan="2" style="vertical-align:middle;" ><div align="center"><strong>ฐานในการคำนวณ</strong></div></th>
                          <th width="6%" rowspan="2" style="vertical-align:middle;" ><div align="center"><strong>คะแนนผล<br>ปฏิบัติงาน</strong></div></th>
                          <th width="6%" rowspan="2" style="vertical-align:middle;" ><div align="center"><strong>ร้อยละ<br>ที่ได้เลื่อน</strong></div></th>
                          <th colspan="2"><div align="center"><strong>จำนวนเงินที่ได้เลื่อน</strong></div></th>
                          <th colspan="2"><div align="center"><strong>จำนวนเงินที่ได้จริง</strong></div></th>
                          <th width="10%" rowspan="2" style="vertical-align:middle;" ><div align="center"><strong>หมายเหตุ</strong></div></th>
                        </tr>
                        <tr >
                          <th width="4%"><div align="center"><strong>เงินเดือน</strong></div></th>
                          <th width="8%" ><div align="center"><strong>ค่าตอบแทนพิเศษ</strong></div></th>
                          <th width="5%"><div align="center"><strong>เงินเดือน</strong></div></th>
                          <th width="8%" ><div align="center"><strong>ค่าตอบแทนพิเศษ</strong></div></th>
                        </tr>
                    </thead>
                    <tbody >
                    <?php
					if($nums > 0){
						$i = 1;
						while($rec = $db->db_fetch_array($query)){
							$final = 0;
							$LEVEL_SALARY_MAX = 0;
							$PER_SALARY = $rec['SALARY_NOW'];
							$TXT_ERROR = "";
							$SALARY_STEP_TYPE = $rec['SALARY_STEP_TYPE'];
							$PER_NAME = text(htmlspecialchars_decode($rec['NAME']));
							$POSITION_NO = (trim($rec['POS_NO'])!='') ? $rec['POS_NO'] : '-';
							$LINE_NAME = (trim($rec['LINE_NAME_TH']) != '') ? text($rec['LINE_NAME_TH']) : '-';
							$LEVEL_NAME = (trim($rec['LEVEL_NAME_TH']) != '') ? text($rec['LEVEL_NAME_TH']) : '-';
							$POSITION_NAME = '<strong>เลขที่ตำแหน่ง</strong> : '.$POSITION_NO.'<br><strong>ตำแหน่งในสายงาน</strong> : '.$LINE_NAME.'<br><strong>ระดับตำแหน่ง</strong> : '.$LEVEL_NAME;
							
							//ตรวจสอบการตั้งค่าฐานในการคำนวณ
							$query_line = $db->query("SELECT COUNT(LINE_STEP_ID) AS NUM FROM SETUP_POS_LINE_SALARY WHERE LINE_ID = '".$rec['LINE_ID']."' ");
							$rec_line = $db->db_fetch_array($query_line);
							$NUM_LINE = $rec_line['NUM']; 
							
							
							if($rec['SCORE']>0){
								$final = $rec['SCORE'];
								$LEVEL_SALARY_MAX = $rec['LEVEL_SALARY_MAX'];
							}
							
							$sql_level = "SELECT A.LEVEL_SALARY_MID 
							FROM SETUP_POS_LINE_SALARY A 							
							WHERE A.POSTYPE_ID = '1' AND A.TYPE_ID = '".$rec['TYPE_ID']."' AND A.LINE_ID = '".$rec['LINE_ID']."'
							AND A.LEVEL_ID = '".$rec['LEVEL_ID']."' AND '".$PER_SALARY."' BETWEEN A.LEVEL_SALARY_MIN AND A.LEVEL_SALARY_MAX";
							$query_level = $db->query($sql_level);
							$rec_level = $db->db_fetch_array($query_level);
							$LEVEL_SALARY_MID = $rec_level['LEVEL_SALARY_MID'];
							
							
							
							if($NUM_LINE == 0){
								$TXT_ERROR = "<div style='color:red;' >กรุณาตั้งค่าฐานในการคำนวณ </div>";
								$TXT_ERROR .= "<div style='color:red;' >โครงสร้างและอัตรากำลัง->ตั้งค่า->ข้าราชการ->ตำแหน่งในสายงาน </div>";
							}
							?>
                            <input type="hidden" name="PER_ID[<?php echo $i;?>]" id="PER_ID_<?php echo $i;?>" value="<?php echo $rec['PER_ID'];?>">
                            <input type="hidden" name="TYPE_ID[<?php echo $i;?>]" id="TYPE_ID_<?php echo $i;?>" value="<?php echo $rec['TYPE_ID'];?>">
                            <input type="hidden" name="LEVEL_ID[<?php echo $i;?>]" id="LEVEL_ID_<?php echo $i;?>" value="<?php echo $rec['LEVEL_ID'];?>">
                            <input type="hidden" name="LINE_ID[<?php echo $i;?>]" id="LINE_ID_<?php echo $i;?>" value="<?php echo $rec['LINE_ID'];?>">
                            <input type="hidden" name="SAL_UP_ID[<?php echo $i;?>]" id="SAL_UP_ID_<?php echo $i;?>" value="<?php echo $rec['SAL_UP_ID'];?>">
                            <input type="hidden" name="SCORE_ID[<?php echo $i;?>]" id="SCORE_ID_<?php echo $i;?>" value="<?php echo $rec['SCORE_ID'];?>">
                            <input type="hidden" name="SALARY_NOW[<?php echo $i;?>]" id="SALARY_NOW_<?php echo $i;?>" value="<?php echo number_format($PER_SALARY,2);?>"><!--เงินเดือนปัจจุบัน-->
                            <input type="hidden" name="SALARY_SPE_NOW[<?php echo $i;?>]" id="SALARY_SPE_NOW_<?php echo $i;?>" value="<?php echo number_format($rec['PER_COMPENSATION_2'],2);?>"><!-- ค่าตอบแทนพิเศษ-->
                            <input type="hidden" name="LEVEL_SALARY_MID[<?php echo $i;?>]" id="LEVEL_SALARY_MID_<?php echo $i;?>" value="<?php echo number_format($LEVEL_SALARY_MID,2);?>"><!-- ฐานในการคำนวณ-->
                            <input type="hidden" name="LEVEL_SALARY_MAX[<?php echo $i;?>]" id="LEVEL_SALARY_MAX_<?php echo $i;?>" value="<?php echo number_format($LEVEL_SALARY_MAX,2);?>"><!-- เงินขั้นสูงที่ใช้คำนวณ-->
                            <input type="hidden" name="SALARY_CAL[<?php echo $i;?>]" id="SALARY_CAL_<?php echo $i;?>" value="<?php echo number_format($rec['SALARY_CAL'],2);?>">
                            <input type="hidden" name="SALARY_NEW[<?php echo $i;?>]" id="SALARY_NEW_<?php echo $i;?>" value="<?php echo number_format($rec['SALARY_NEW'],2);?>">  <!-- เงินเดือนใหม่-->
                            <input type="hidden" name="SALARY_SPE_NEW[<?php echo $i;?>]" id="SALARY_SPE_NEW_<?php echo $i;?>" value="<?php echo number_format($rec['SALARY_SPE_NEW'],2);?>"> <!--เงินเดือนพิเศษที่เกินกรอบ-->
                            <tr>
								<td align="center" ><?php echo $i;?>.</td>
								<td align="left">
									<?php echo $PER_NAME;?><br>
                                    <?php echo $POSITION_NAME;?>
                                    <?php echo $TXT_ERROR; ?>
                                </td>
								<td align="right"><?php echo number_format($PER_SALARY,2);?>&nbsp;</td>
								<td align="right"><?php echo number_format($LEVEL_SALARY_MID,2);?>&nbsp;</td>
								<td align="center"><div class="score_final"><input type="text" name="SCORE[<?php echo $i;?>]" id="SCORE_<?php echo $i;?>" value="<?php echo number_format($final,2);?>" class="form-control" maxlength="6" style="width:90px; text-align:center;" onBlur="NumberFormat(this,2);" onKeyUp="chkFormatNam_id(this.value,this.id); getPercent(this.value, '<?php echo $i;?>'); "></div>
                                <input type="hidden" id="ORG_ID_4_<?php echo $i;?>" name="ORG_ID_4[<?php echo $i;?>]" value="<?php echo $rec['ORG_ID_4'];?>">
                                &nbsp;</td>
								<td align="center"><input type="text" name="SCORE_PERCENT[<?php echo $i;?>]" id="SCORE_PERCENT_<?php echo $i;?>" value="<?php echo number_format($rec['SCORE_PERCENT'],5);?>" class="form-control" maxlength="10" style="width:90px; text-align:center;" onBlur="NumberFormat(this,5);" onKeyUp="chkFormatNam_id(this.value,this.id); getSalaryCal('<?php echo $i;?>');">&nbsp;</td>
								<td align="right"><input type="text" name="SALARY_UP[<?php echo $i;?>]" id="SALARY_UP_<?php echo $i;?>" value="<?php echo number_format($rec['SALARY_UP'],2);?>" class="form-control" maxlength="6" style="width:90px;display:inline;text-align:right;" onBlur="NumberFormat(this,2);" onKeyUp="chkFormatNam_id(this.value,this.id); calSalaryNew('<?php echo $i;?>');">&nbsp;</td>
								<td align="right"><input type="text" name="SALARY_SPE_UP[<?php echo $i;?>]" id="SALARY_SPE_UP_<?php echo $i;?>" value="<?php echo number_format($rec['SALARY_SPE_UP'],2);?>" class="form-control" maxlength="6" style="width:90px;display:inline;text-align:right;" onBlur="NumberFormat(this,2);" onKeyUp="chkFormatNam_id(this.value,this.id); calSalarySpeNew('<?php echo $i;?>');">&nbsp;</td>
								<td align="right"><span id="shw_salary_new_<?php echo $i;?>"><?php echo number_format($rec['SALARY_NEW'],2);?></span>&nbsp;
                                   <input type="hidden" name="SHW_NEW[<?php echo $i;?>]" id="SHW_NEW_<?php echo $i;?>" value="<?php echo number_format($rec['SALARY_NEW'],2);?>">
                                </td>
								<td align="right"><span id="shw_salary_spe_new_<?php echo $i;?>"><?php echo number_format($rec['SALARY_SPE_UP'],2);?></span>&nbsp;</td>
								<td align="center"><textarea name="REMARKS[<?php echo $i;?>]" rows="4"  class="form-control" id="REMARKS_<?php echo $i;?>" ><?php echo str_replace("<br>",'',text($rec['REMARKS']));?></textarea></td>
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
            <?php if($num_up == 0){ ?>
            <div class="formlast">
                <div class="col-xs-12 col-sm-12" align="center">
                    <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                    <button type="button" class="btn btn-primary" onClick="ConfirmCom();">อนุมัติการเลื่อนเงินเดือน</button>
                  	<button type="button" class="btn btn-default" onClick="$('#page').val(1); $('#frm-search').attr('action','record_level_salary1_org_disp.php').submit();">ยกเลิก</button></button>
                </div>
            </div>
           <?php } ?>   
		</form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>