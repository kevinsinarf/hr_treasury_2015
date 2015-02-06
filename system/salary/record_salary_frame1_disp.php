<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POS 
$S_YEAR_BDG = trim($_POST['S_YEAR_BDG']);
$S_ROUND = trim($_POST['S_ROUND']);

//DEFULT
if($S_YEAR_BDG == ''){
	$S_YEAR_BDG = (date('Y')+543);
}
if($S_ROUND == ''){
	$S_ROUND = 1;
}

$query_num = $db->query("SELECT COUNT(*) AS NUM FROM SAL_UP_SALARY WHERE YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND SAL_UP_TYPE = 1 AND CONFIRM_TYPE >= 2  ");
$rec_num = $db->db_fetch_array($query_num);
$num_group = $rec_num['NUM'];
$NUM1_CAL = $db->get_data_field("SELECT NUM1 FROM SAL_EVAL WHERE YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND POSTYPE_ID = 1 AND EVAL_TYPE = 1 ", "NUM1");
$query_org = $db->query("SELECT A.ORG_ID_3, B.ORG_NAME_TH 
                                   FROM SAL_UP_SALARY A 
								   JOIN SETUP_ORG B ON A.ORG_ID_3 = B.ORG_ID 
								   WHERE A.POSTYPE_ID = 1 AND A.YEAR_BDG = '".$S_YEAR_BDG."' AND A.ROUND = '".$S_ROUND."' AND A.SAL_UP_TYPE = 1 AND A.CONFIRM_TYPE >= 2
								   GROUP BY A.ORG_ID_3, B.ORG_NAME_TH, B.ORG_SEQ
								   ORDER BY CASE WHEN B.ORG_SEQ IS NULL THEN 1 ELSE 0 END ,B.ORG_SEQ ASC ");

$nums = $db->db_num_rows($query_org);

$query_all = $db->query("SELECT COUNT(SAL_FRAME_ID) AS COUNT_FRAME FROM SAL_FRAME WHERE POSTYPE_ID = 1 AND CONFIRM_TYPE = 2 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."'  ");
$rec_all = $db->db_fetch_array($query_all);
$num_frame = (int)$rec_all['COUNT_FRAME'];

if($NUM1_CAL == ''){
	$NUM1 = 3.00;	
}else{
	$NUM1 = $NUM1_CAL;	
}

$txt_error = '';
if($num_group == 0){
	$txt_error = "<div class='row' style='color:red'>**กรุณาอนุมัติจัดกลุ่มสำหรับการเลื่อนเงินเดือนก่อน</div>";
}else{
	$txt_error = "<div class='row' style='color:red'>**ตัวเลขสีแดง หมายถึงยังไม่บันทึกข้อมูล</div>";
}


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
<script src="js/record_salary_frame1_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-sm-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active">ข้าราชการ-><?php echo Showmenu($menu_sub_id);?></li>
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
			<div class="row">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ปีงบประมาณ : <span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-2">
                <select name="S_YEAR_BDG" id="S_YEAR_BDG" class="selectbox form-control" placeholder="ปีงบประมาณ" onChange="$('#frm-search').submit();">
                <?php 
				for($y=$YEAR_BUDGET;$y>=$YEAR_BUDGET_PREV;$y--){
					?>
                    <option value="<?php echo $y;?>" <?php if($y == $S_YEAR_BDG){ echo "selected";} ?>><?php echo $y;?></option>
                    <?php	
				}
				?>
                </select>
                </div>
				<div class="col-xs-12 col-md-1"></div>
                <div class="col-xs-12 col-md-2">รอบ :  <span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-3">
                <select name="S_ROUND" id="S_ROUND" class="selectbox form-control" placeholder="รอบ" onChange="$('#frm-search').submit();">
                    <option value=""></option>
					<?php 
                   foreach($arr_round as $index => $val){
                        ?>
                        <option value="<?php echo $index;?>" <?php if($index == $S_ROUND){ echo "selected"; }?>><?php echo $val;?></option>
                        <?php
                    }
                    ?>
                </select>
                </div>
				<div class="col-xs-12 col-md-1"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
			</div>
                               
			<div class="row"><?php echo ($nums>0) ? startPaging("frm-search",$total_record):""; ?></div>
			
            <?php echo $txt_error; ?>
			<div class="table-responsive">
                <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                    <thead>
                        <tr class="bgHead">
                            <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                          	<th width="40%"><div align="center"><strong>สังกัด (ปฏิบัติ)</strong></div></th> 
                            <th width="15%"><div align="center"><strong>จำนวนคน</strong></div></th>                                                            
                          	<th width="20%"><div align="center"><strong>เงินเดือน</strong></div></th>
                          	<th width="20%"><div align="center"><strong>เงินเดือน x <input type="text" name="NUM1" id="NUM1" value="<?php echo number_format($NUM1,2);?>" class="form-control" style="width:70px; display:inline;" onBlur="NumberFormat(this,2)" maxlength="5" onKeyUp="calSalary(this.value); chkFormatNam_id(this.value,this.id);" ></strong></div></th>
                        </tr>
                    </thead>
                    <tbody >
                    <?php
					if($nums > 0){
					  $i = 1;
					  while($rec_org = $db->db_fetch_array($query_org)){
						  $SALARY_NOW = 0;
						  $SALARY_FRAME = 0;
						  $NUM_PER = 0;
						  $COLOR = '';
						  $sql_per_group = "SELECT COUNT(A.PER_ID) AS COUNT_PER, SUM(A.SALARY_NOW) AS SUM_SALARY
												   FROM SAL_UP_SALARY A 
												   WHERE A.POSTYPE_ID = 1 AND A.YEAR_BDG = '".$S_YEAR_BDG."' AND A.ROUND = '".$S_ROUND."' AND A.ORG_ID_3 = '".$rec_org['ORG_ID_3']."' AND SAL_UP_TYPE = 1 ";
						  $query_per_group = $db->query($sql_per_group);
						  $rec_per_group = $db->db_fetch_array($query_per_group);
						  $query_frame = $db->query("SELECT * FROM SAL_FRAME WHERE POSTYPE_ID = 1 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND ORG_ID_3 = '".$rec_org['ORG_ID_3']."'   ");
						  $rec_frame = $db->db_fetch_array($query_frame);
						  
						  if((float)$rec_frame['SALARY_FRAME'] > 0){
							  $SALARY_FRAME = $rec_frame['SALARY_FRAME'];
						  }else{
							  $COLOR = 'color:red;';
							  $SALARY_FRAME =  ($rec_per_group['SUM_SALARY']*$NUM1)/100;
						  }
						  if((float)$rec_frame['SALARY_NOW'] > 0){
							  $SALARY_NOW = $rec_frame['SALARY_NOW'];
						  }else{
							  $SALARY_NOW = $rec_per_group['SUM_SALARY'];
						  }
						  if((int)$rec_frame['NUM_PER'] > 0){
							  $NUM_PER = $rec_frame['NUM_PER'];
						  }else{
							  $NUM_PER = $rec_per_group['COUNT_PER'];
						  }
						  
						  //$salary_cal = ($r_org['SALARY']*$NUM1)/100;
						?>
                        <input type="hidden" name="ORG_ID_3[<?php echo $i;?>]" id="ORG_ID_3_<?php echo $i;?>" value="<?php echo $rec_org['ORG_ID_3'];?>">
                        
                        <tr>
                            <td align="center"><?php echo $i;?>.</td>
                            <td align="left"><?php echo text($rec_org['ORG_NAME_TH']);?></td>
                            <td align="center"><?php echo $NUM_PER; ?>
                             	<input type="hidden" name="NUM_PER[<?php echo $i;?>]" id="NUM_PER_<?php echo $i;?>" value="<?php echo $NUM_PER;?>">
                            </td>
                            <td align="right">
								<?php echo number_format($SALARY_NOW,2);?>
                            	<input type="hidden" name="SALARY_NOW[<?php echo $i;?>]" id="SALARY_NOW_<?php echo $i;?>" value="<?php echo number_format($SALARY_NOW,2);?>">
                            </td>
                            <td align="right">
                            	<input type="text" name="SALARY_FRAME[<?php echo $i;?>]" id="SALARY_FRAME_<?php echo $i;?>" value="<?php echo number_format($SALARY_FRAME,2);?>" class="form-control" style="width:120px;display:inline; text-align:right; <?php echo $COLOR; ?>" onBlur="NumberFormat(this,2)" onKeyUp="chkFormatNam_id(this.value,this.id);">&nbsp;
                            </td>
                        </tr>
                        <?php
						$i++;
						}
					}else{
						echo "<tr><td align=\"center\" colspan=\"5\">ไม่พบข้อมูล</td></tr>";
					}
                    ?>
                 	</tbody>
                </table>
			</div>
            <?php if($num_frame == 0 and $nums > 0){ ?>
            <div class="formlast">
                <div class="col-xs-12 col-sm-12" align="center">
                    <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                    <button type="button" class="btn btn-default" onClick="ConfirmGov();">อนุมัติกรอบวงเงิน</button>
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