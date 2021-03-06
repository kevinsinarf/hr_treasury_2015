<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POST
$S_YEAR_BDG = $_POST['S_YEAR_BDG'];
$S_ROUND = $_POST['S_ROUND'];
$LEVEL_ID = $_POST['LEVEL_ID'];


$filter = "";
if($s_name != ""){
	$filter .= " and B.NAME like '%".ctext($s_name)."%' ";
}

if(!empty($S_POS_NO) && $S_POS_NO != 'undefined'){
	$filter .= " AND B.POS_NO = ".trim($S_POS_NO);
}


$txt = "บันทึกข้อมูล"; 

$query_name = $db->query("SELECT A.LEVEL_NAME_TH, B.TYPE_ID, B.TYPE_NAME_TH FROM SETUP_POS_LEVEL A JOIN SETUP_POS_TYPE B ON A.TYPE_ID = B.TYPE_ID WHERE A.LEVEL_ID = '".$LEVEL_ID."' ");
$rec_name = $db->db_fetch_array($query_name);

$field = " B.SAL_UP_ID, B.PER_ID, B.POS_ID, B.POS_NO, B.TYPE_ID, B.NAME, C.TYPE_NAME_TH, 
            B.LEVEL_ID, B.LINE_ID, D.LEVEL_NAME_TH, E.LINE_NAME_TH, G.ORG_NAME_TH, B.SALARY_NOW,
			B.SCORE, B.LEVEL_SALARY_MAX,  B.SCORE_ID, B.SALARY_CAL, B.SALARY_NEW, B.SALARY_SPE_NEW, B.SCORE_PERCENT, B.SALARY_UP, B.SALARY_SPE_UP,
			B.REMARKS    ";
$table = "SAL_UP_SALARY B 
			LEFT JOIN SETUP_POS_TYPE C ON B.TYPE_ID = C.TYPE_ID
			LEFT JOIN SETUP_POS_LEVEL D ON B.LEVEL_ID = D.LEVEL_ID
			LEFT JOIN SETUP_POS_LINE E ON B.LINE_ID = E.LINE_ID
			LEFT JOIN SETUP_ORG G ON B.ORG_ID_3 = G.ORG_ID";
$pk_id = " B.PER_ID ";
$wh = " B.POSTYPE_ID = 1 AND B.YEAR_BDG = '".$S_YEAR_BDG."' AND B.ROUND = '".$S_ROUND."' AND B.LEVEL_ID = '".$LEVEL_ID."' AND B.SAL_UP_TYPE = 2  AND CONFIRM_TYPE >= 1   {$filter}";
$orderby = "order by B.POS_NO ASC";
$notin = $wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select ".$field." from ".$table." where ".$notin;

$query = $db->query($sql);
$nums = $db->db_num_rows($query);



$query_up = $db->query("SELECT COUNT(SAL_UP_ID)AS NUM_UP FROM SAL_UP_SALARY WHERE POSTYPE_ID = 1 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND LEVEL_ID = '".$LEVEL_ID."' AND SAL_UP_TYPE = 2  AND CONFIRM_TYPE = 3 ");
$rec_up = $db->db_fetch_array($query_up);
$num_up = (int)$rec_up['NUM_UP'];
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
<script src="js/record_record_up_salary_mg_form.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-sm-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li><a onClick="$('#page').val(1); $('#frm-search').attr('action','record_up_salary_mg_disp.php').submit(); " href="#">บันทึกการเลื่อนขั้นเงินเดือนข้าราชการตามสำนักข้าราชการ->บันทึกผล (ผู้บริหาร)</a></li>
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
            <input type="hidden" id="TYPE_ID" name="TYPE_ID" value="<?php echo $rec_name['TYPE_ID'];?>">
            <input type="hidden" id="LEVEL_ID" name="LEVEL_ID" value="<?php echo $LEVEL_ID;?>">
           
			<div class="row">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ปีงบประมาณ : </div>
				<div class="col-xs-12 col-md-2"><?php echo $S_YEAR_BDG;?></div>
				<div class="col-xs-12 col-md-3"></div>
                <div class="col-xs-12 col-md-2">รอบ :  </div>
				<div class="col-xs-12 col-md-3"><?php echo $arr_round[$S_ROUND];?></div>
			</div>
            
			<div class="row">
				<div class="col-xs-12 col-md-2" >ประเภทตำแหน่ง : </div>
				<div class="col-xs-12 col-md-2"><?php echo text($rec_name['TYPE_NAME_TH']);?></div>
				<div class="col-xs-12 col-md-3"></div>
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ระดับ : </div>
				<div class="col-xs-12 col-md-2"><?php echo text($rec_name['LEVEL_NAME_TH']);?></div>
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
							$PER_NAME = text(htmlspecialchars_decode($rec['NAME']));
							$POSITION_NO = (trim($rec['POS_NO'])!='') ? $rec['POS_NO'] : '-';
							$LINE_NAME = (trim($rec['LINE_NAME_TH']) != '') ? text($rec['LINE_NAME_TH']) : '-';
							$LEVEL_NAME = (trim($rec['LEVEL_NAME_TH']) != '') ? text($rec['LEVEL_NAME_TH']) : '-';
							$ORG_NAME = (trim($rec['ORG_NAME_TH']) != '') ? text($rec['ORG_NAME_TH']) : '-';
							$POSITION_NAME = '<strong>เลขที่ตำแหน่ง</strong> : '.$POSITION_NO.'<br><strong>ตำแหน่งในสายงาน</strong> : '.$LINE_NAME.'<br><strong>ระดับตำแหน่ง</strong> : '.$LEVEL_NAME.'<br><strong>สำนัก/กลุ่ม</strong> : '.$ORG_NAME;
							
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
                            <input type="hidden" name="SAL_UP_ID[<?php echo $i;?>]" id="SAL_UP_ID_<?php echo $i;?>" value="<?php echo $rec['SAL_UP_ID'];?>">
                            <input type="hidden" name="SCORE_ID[<?php echo $i;?>]" id="SCORE_ID_<?php echo $i;?>" value="<?php echo $rec['SCORE_ID'];?>">
                            <input type="hidden" name="SALARY_NOW[<?php echo $i;?>]" id="SALARY_NOW_<?php echo $i;?>" value="<?php echo number_format($PER_SALARY,2);?>"><!--เงินเดือนปัจจุบัน-->
                            <input type="hidden" name="LEVEL_SALARY_MID[<?php echo $i;?>]" id="LEVEL_SALARY_MID_<?php echo $i;?>" value="<?php echo number_format($LEVEL_SALARY_MID,2);?>"><!-- ฐานในการคำนวณ-->
                            <input type="hidden" name="LEVEL_SALARY_MAX[<?php echo $i;?>]" id="LEVEL_SALARY_MAX_<?php echo $i;?>" value="<?php echo number_format($LEVEL_SALARY_MAX,2);?>"><!-- เงินขั้นสูงที่ใช้คำนวณ-->
                            <input type="hidden" name="SALARY_CAL[<?php echo $i;?>]" id="SALARY_CAL_<?php echo $i;?>" value="<?php echo number_format($rec['SALARY_CAL'],2);?>">
                            <input type="hidden" name="SALARY_NEW[<?php echo $i;?>]" id="SALARY_NEW_<?php echo $i;?>" value="<?php echo number_format($rec['SALARY_NEW'],2);?>">  <!-- เงินเดือนใหม่-->
                            <input type="hidden" name="SALARY_SPE_NEW[<?php echo $i;?>]" id="SALARY_SPE_NEW_<?php echo $i;?>" value="<?php echo number_format($rec['SALARY_SPE_NEW'],2);?>"> <!--เงินเดือนพิเศษที่เกินกรอบ-->
                            <input type="hidden" id="LINE_ID_<?php echo $i;?>" name="LINE_ID[<?php echo $i;?>]" value="<?php echo $rec['LINE_ID'];?>">
                            
                            <tr>
								<td align="center"><?php echo $i;?>.</td>
								<td align="left">
									<?php echo $PER_NAME;?><br>
                                    <?php echo $POSITION_NAME;?>
                                    <?php echo $TXT_ERROR; ?>
                                </td>
								<td align="right"><?php echo number_format($PER_SALARY,2);?>&nbsp;</td>
								<td align="right"><?php echo number_format($LEVEL_SALARY_MID,2);?>&nbsp;</td>
								<td align="center">
                                <div class="score_final">
                                	<input type="text" name="SCORE[<?php echo $i;?>]" id="SCORE_<?php echo $i;?>" value="<?php echo number_format($final,2);?>" class="form-control" maxlength="6" style="width:90px; text-align:center;" onBlur="NumberFormat(this,2);" onKeyUp="chkFormatNam_id(this.value,this.id); getPercent(this.value, '<?php echo $i;?>'); ">
                                </div>
                                </td>
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
                  	<button type="button" class="btn btn-default" onClick="$('#page').val(1); $('#frm-search').attr('action','record_up_salary_mg_disp.php').submit();">ยกเลิก</button></button>
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