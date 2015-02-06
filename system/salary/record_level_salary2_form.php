<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$txt = "บันทึกข้อมูล"; 

$filter = "";

$POS_NO = $_POST['S_POS_NO'];
$LEVEL_ID = $_POST['S_LEVEL_ID'];
$TYPE_ID = $_POST['S_TYPE_ID'];
$LINE_ID = $_POST['S_LINE_ID'];
$S_YEAR_BDG = $_POST['S_YEAR_BDG'];
$S_ROUND = $_POST['S_ROUND'];
if($s_name != ""){
	$filter .= " AND (A.NAME like '%".ctext($s_name)."%') ";
}
if(!empty($POS_NO) && $POS_NO != 'undefined'){
	$filter .= " AND A.POS_NO = ".trim($POS_NO);
}
if(!empty($LEVEL_ID) && $LEVEL_ID != 'undefined'){
	$filter .= " AND A.LEVEL_ID = ".trim($LEVEL_ID);
}
if(!empty($TYPE_ID) && $TYPE_ID != 'undefined'){
	$filter .= " AND A.TYPE_ID = ".trim($TYPE_ID);
}
if(!empty($LINE_ID) && $LINE_ID != 'undefined'){
	$filter .= " AND A.LINE_ID = ".trim($LINE_ID);
}


$ORG_NAME = $db->get_data_field("SELECT ORG_NAME_TH FROM SETUP_ORG WHERE ORG_ID = '".$ORG_ID."'", "ORG_NAME_TH");

$field = " A.SAL_UP_ID, A.PER_ID, A.NAME, A.POS_ID, A.POS_NO, A.SALARY_NOW,  A.LEVEL_ID, B.LEVEL_NAME_TH, C.LINE_NAME_TH,
             A.SCORE_ID, A.SALARY_CAL, A.SALARY_NEW, A.SCORE_1, A.SCORE_2, A.SCORE, A.SCORE_PERCENT, A.SALARY_UP, A.LEVEL_SALARY_MAX, A.REMARKS ";
$table = "SAL_UP_SALARY A
            LEFT JOIN SETUP_POS_LEVEL B ON A.LEVEL_ID = B.LEVEL_ID
		    LEFT JOIN SETUP_POS_LINE C ON A.LINE_ID = C.LINE_ID";
		  
$pk_id = "A.SAL_UP_ID";
$wh = "A.POSTYPE_ID = '3' AND A.CONFIRM_TYPE >= 2 AND A.ORG_ID_3 = '".$ORG_ID."' AND A.YEAR_BDG = '".$S_YEAR_BDG."' AND A.ROUND = '".$S_ROUND."' {$filter}";
$orderby = "order by A.POS_NO ASC ";
$notin = $wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;
$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;

$query = $db->query($sql);
$nums = $db->db_num_rows($query);

$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

$query_up = $db->query("SELECT COUNT(SAL_UP_ID)AS NUM_UP FROM SAL_UP_SALARY WHERE POSTYPE_ID = 3 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND ORG_ID_3 = '".$ORG_ID."' AND SAL_UP_TYPE = 1  AND CONFIRM_TYPE = 3 ");
$rec_up = $db->db_fetch_array($query_up);
$num_up = (int)$rec_up['NUM_UP'];

$arr_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' AND POSTYPE_ID = 3 and DELETE_FLAG='0' AND TYPE_ID = '".$S_TYPE_ID."' ", "LEVEL_SEQ");

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
<script src="js/record_level_salary2_form.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-sm-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li><a href="#" onClick="$('#page').val(1); $('#frm-search').attr('action','record_level_salary2_disp.php').submit();">บันทึกการเลื่อนค่ตอบแทนพนักงานราชการตามสำนัก->พนักงานราชการ</a></li>
			<li class="active"><?php echo Showmenu($menu_sub_id);?></li>
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
				<div class="col-xs-12 col-md-3"><?php echo $arr_emp_round[$S_ROUND];?></div>
			</div>
            
			<div class="row">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">สังกัด (ปฏิบัติ) : </div>
				<div class="col-xs-12 col-md-4"><?php echo text($ORG_NAME);?></div>
			</div>
            <div class="row">
             <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ตำแหน่ง : </div>
                <div class="col-xs-12 col-md-2">
                    <input type="text" id="S_POS_NO" name="S_POS_NO" class="form-control" placeholder="เลขที่ตำแหน่ง"  value="<?php echo $S_POS_NO; ?>" onKeyUp="check_number(this.value,'S_POS_NO');" >
                </div>
                <div class="col-xs-12 col-md-3" ></div>
                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['name'];?> :</div>
                <div class="col-xs-12 col-sm-2">
                <input type="text" id="s_name" name="s_name" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $s_name; ?>">
                </div>
            </div>
             <div class="row">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทพนักงานราชการ : </div>
					<div class="col-xs-12 col-md-2">
						<select id="S_TYPE_ID" name="S_TYPE_ID" class="selectbox form-control" placeholder="ประเภทพนักงานราชการ" onChange="get_level(this); ">
							<option value=""></option>
							<?php
							
							$sql_type_name = "Select TYPE_ID , TYPE_NAME_TH From SETUP_POS_TYPE WHERE ACTIVE_STATUS = 1 AND POSTYPE_ID = '3' AND DELETE_FLAG = 0 ORDER BY TYPE_NAME_TH";
							$query_type_name = $db->query($sql_type_name);
							$select_type[$S_TYPE_ID] = "Selected='Selected'";
							while($type = $db->db_fetch_array($query_type_name)){
								echo '<option value="'.$type['TYPE_ID'].'" '.$select_type[$type['TYPE_ID']].' >'.text($type['TYPE_NAME_TH']).'</option>';
							}
							
							?>
						</select>
					</div>
                    <div class="col-xs-12 col-md-3"></div>
                    <div class="col-xs-12 col-md-2" >ประเภทกลุ่มงาน : </div>
					<div class="col-xs-12 col-md-2">
						<?php echo GetHtmlSelect('S_LEVEL_ID', 'S_LEVEL_ID',$arr_level , 'ประเภทกลุ่มงาน' ,$S_LEVEL_ID ,'onChange="get_line(this); "', '1', '', ''); ?>
				  </div>
                   
				</div>
			 <div class="row">
                    <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ตำแหน่ง : </div>
					<div class="col-xs-12 col-md-2" >
						<select id="S_LINE_ID" name="S_LINE_ID" class="selectbox form-control" placeholder="ตำแหน่ง" >
							<option value=""></option>
							<?php
								$sql_line_name = "Select LINE_ID , LINE_NAME_TH From SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND LEVEL_ID = '".$S_LEVEL_ID."' AND POSTYPE_ID = 3  ORDER BY LINE_NAME_TH ASC";
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
			<div class="row"><?php echo ($nums>0) ? startPaging("frm-search",$total_record):""; ?></div>
			
			<div class="table-responsive">
                <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                    <thead class="bgHead" >
                        <tr >
                          <th width="3%" rowspan="2" style="vertical-align:middle;"><div align="center"><strong>ลำดับ</strong></div></th>
                          <th width="20%" rowspan="2" style="vertical-align:middle;"><div align="center"><strong>ชื่อ - สกุล</strong></div></th>
                          <th width="6%" rowspan="2" style="vertical-align:middle;" ><div align="center"><strong>ค่าตอบแทน</strong></div></th>
                          <th width="6%" colspan="3"><div align="center"><strong>คะแนนผลปฏิบัติงาน</strong></div></th>
                          <th width="6%" rowspan="2" ><div align="center"><strong>ร้อยละ<br>ที่ได้เลื่อน</strong></div></th>
                          <th width="6%" rowspan="2"><div align="center"><strong>ค่าตอบแทน<br>ที่ได้เลื่อน</strong></div></th>
                          <th width="6%" rowspan="2"><div align="center"><strong>ค่าตอบแทน<br>ที่ได้เลื่อนจริง</strong></div></th>
                          <th width="10%" rowspan="2" nowrap style="vertical-align:middle;" ><div align="center"><strong>หมายเหตุ</strong></div></th>
                        </tr>
                        <tr >
                            <th width="6%" nowrap><div align="center"><strong>ครั้งที่ 1</strong></div></th>
                          	<th width="6%" nowrap><div align="center"><strong>ครั้งที่ 2</strong></div></th>
               	    	  	<th width="6%" nowrap><div align="center"><strong>เฉลี่ย</strong></div></th>
                       	</tr>
                    </thead>
                    <tbody >
                    <?php
					
					if($nums > 0){
						$i = 1;
						while($rec = $db->db_fetch_array($query)){
							$PER_NAME = text(htmlspecialchars_decode($rec['NAME']));
							$POSITION_NO = (trim($db->get_pos_no($rec['PER_ID']))!='') ? $db->get_pos_no($rec['PER_ID']) : '-';
							$LINE_NAME = (trim($rec['LINE_NAME_TH']) != '') ? text($rec['LINE_NAME_TH']) : '-';
							$LEVEL_NAME = (trim($rec['LEVEL_NAME_TH']) != '') ? text($rec['LEVEL_NAME_TH']) : '-';
							$ORG_NAME = (trim($rec['ORG_NAME_TH']) != '') ? text($rec['ORG_NAME_TH']) : '-';
							$POSITION_NAME = '<strong>เลขที่ตำแหน่ง :</strong> '.$POSITION_NO.'<br><strong>ประเภทกลุ่มงาน :</strong> '.$LEVEL_NAME.'<br><strong>ตำแหน่ง : </strong>'.$LINE_NAME;							

							?>
                            <input type="hidden" name="PER_ID[<?php echo $i;?>]" id="PER_ID_<?php echo $i;?>" value="<?php echo $rec['PER_ID'];?>">
                            <input type="hidden" name="LEVEL_ID[<?php echo $i;?>]" id="LEVEL_ID_<?php echo $i;?>" value="<?php echo $rec['LEVEL_ID'];?>">
                            <input type="hidden" name="SAL_UP_ID[<?php echo $i;?>]" id="SAL_UP_ID_<?php echo $i;?>" value="<?php echo $rec['SAL_UP_ID'];?>">
                            <input type="hidden" name="SCORE_ID[<?php echo $i;?>]" id="SCORE_ID_<?php echo $i;?>" value="<?php echo $rec['SCORE_ID'];?>">
                            <input type="hidden" name="LEVEL_SALARY_MAX[<?php echo $i;?>]" id="LEVEL_SALARY_MAX_<?php echo $i;?>" value="<?php echo number_format($rec['LEVEL_SALARY_MAX'],2);?>"><!-- เงินขั้นสูงที่ใช้คำนวณ-->
                            <input type="hidden" name="SALARY_NOW[<?php echo $i;?>]" id="SALARY_NOW_<?php echo $i;?>" value="<?php echo number_format($rec['SALARY_NOW'],2);?>">
                            <input type="hidden" name="SALARY_CAL[<?php echo $i;?>]" id="SALARY_CAL_<?php echo $i;?>" value="<?php echo number_format($rec['SALARY_CAL'],2);?>">
                            <input type="hidden" name="SALARY_NEW[<?php echo $i;?>]" id="SALARY_NEW_<?php echo $i;?>" value="<?php echo number_format($rec['SALARY_NEW'],2);?>">
                            <tr>
								<td align="center"><?php echo $i;?>.</td>
								<td align="left">
									<?php echo $PER_NAME;?><br>
                               	 	<?php echo $POSITION_NAME;?>
                                </td>
								 <td align="right"><?php echo number_format($rec['SALARY_NOW'],2);?>&nbsp;</td>
                                 <td align="center">
                                	<input name="SCORE_1[<?php echo $i;?>]"  id="SCORE_1_<?php echo $i;?>" value="<?php echo number_format($rec['SCORE_1'],2);?>" type="text" class="form-control" maxlength="6"  onKeyUp="getAvg(this); chkFormatNam_id(this.value,this.id);" onBlur="NumberFormat(this,2);" style="width:60px;"  >
                                 </td>
                                 <td align="center">
                                	<input name="SCORE_2[<?php echo $i;?>]" id="SCORE_2_<?php echo $i;?>" value="<?php echo number_format($rec['SCORE_2'],2);?>" type="text" class="form-control" maxlength="6" onKeyUp="getAvg(this); chkFormatNam_id(this.value,this.id);" onBlur="NumberFormat(this,2);" style="width:60px;" >
                                </td>
								 <td align="center">
                                	<input type="text" name="SCORE[<?php echo $i;?>]" id="SCORE_<?php echo $i;?>" value="<?php echo number_format($rec['SCORE'],2);?>" class="form-control" maxlength="6" style="width:60px;" onBlur="NumberFormat(this,2);" onKeyUp="getPercent('<?php echo $i;?>', this.value); chkFormatNam_id(this.value,this.id);">
                                 </td>
                                 <td align="center">
                                 	<input type="text" name="SCORE_PERCENT[<?php echo $i;?>]" id="SCORE_PERCENT_<?php echo $i;?>" value="<?php echo number_format($rec['SCORE_PERCENT'],5);?>" class="form-control" maxlength="6" style="width:80px;display:inline;text-align:right;" onBlur="NumberFormat(this,2);" onKeyUp="chkFormatNam_id(this.value,this.id); getSalaryCal('<?php echo $i;?>');" >
                                 
                                 </td>
								<td align="center"><input type="text" name="SALARY_UP[<?php echo $i;?>]" id="SALARY_UP_<?php echo $i;?>" value="<?php echo number_format($rec['SALARY_UP'],2);?>" class="form-control" maxlength="6" style="width:80px;display:inline;text-align:right;" onBlur="NumberFormat(this,2);" onKeyUp="chkFormatNam_id(this.value,this.id); calSalaryNew('<?php echo $i;?>');">&nbsp;</td>
								<td align="right"><span id="shw_salary_new_<?php echo $i;?>"><?php echo number_format($rec['SALARY_NEW'],2);?></span>&nbsp;</td>
                                <td align="center"><textarea name="REMARKS[<?php echo $i;?>]" id="REMARKS_<?php echo $i;?>" class="form-control"   rows="4"><?php echo text($rec['REMARKS']);?></textarea></td>
							</tr>
							<?php
							$i++;
						}
					}else{
						echo "<tr><td align=\"center\" colspan=\"15\">ไม่พบข้อมูล</td></tr>";	
					}
                    ?>
                 	</tbody>
                </table>
			</div>
			<?php if($num_up == 0){ ?>
            <div class="formlast">
                <div class="col-xs-12 col-sm-12" align="center">
                    <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                    <button type="button" class="btn btn-primary" onClick="ConfirmCom();">อนุมัติการเลื่อนค่าตอบแทน</button>
                  	<button type="button" class="btn btn-default" onClick="$('#page').val(1); $('#frm-search').attr('action','record_level_salary2_disp.php').submit(); ">ยกเลิก</button></button>
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