<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POST
$S_YEAR_BDG = $_POST['S_YEAR_BDG'];
$S_ROUND = $_POST['S_ROUND'];

if($YEAR_BDG != ""){
	$filter .= " and YEAR_BDG = '".ctext($YEAR_BDG)."' ";
}
if($ROUND != ""){
	$filter .= " and ROUND = '".ctext($ROUND)."' ";
}

//DEFALUT
if($S_YEAR_BDG == ''){
	$S_YEAR_BDG = (date('Y')+543);
}
if($S_ROUND == ''){
	$S_ROUND = 1;
}


$sql_org = "SELECT A.ORG_ID_3, B.ORG_NAME_TH 
                FROM SAL_UP_SALARY A
				JOIN SETUP_ORG B ON A.ORG_ID_3 = B.ORG_ID
				WHERE A.YEAR_BDG = '".$S_YEAR_BDG."' AND A.ROUND = '".$S_ROUND."' AND A.POSTYPE_ID = 5
				GROUP BY A.ORG_ID_3, B.ORG_NAME_TH, B.ORG_SEQ
				ORDER BY CASE WHEN B.ORG_SEQ IS NULL THEN 1 ELSE 0 END ,B.ORG_SEQ ASC" ;
 $query_org = $db->query($sql_org);
 $nums = $db->db_num_rows($query_org);
 
 $txt_error = '';
if($nums == 0){
	$txt_error = "<div class='row' style='color:red'>**กรุณาอนุมัติกรอบวงเงินก่อน</div>";
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
<script src="js/record_level_salary3_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-sm-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active">บันทึกการเลื่อนขั้นค่าจ้างของลูกจ้างประจำตามสำนัก->ลูกจ้างประจำ->บันทึกผล</li>
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
			<input type="hidden" id="ORG_ID" name="ORG_ID" value="">
            
			<div class="row">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ปีงบประมาณ : <span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-2">
                <select name="S_YEAR_BDG" id="S_YEAR_BDG" class="selectbox form-control" placeholder="ปีงบประมาณ">
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
                <select name="S_ROUND" id="S_ROUND" class="selectbox form-control" placeholder="รอบ">
                    <option value=""></option>
					<?php 
                    foreach($arr_emp_gov_round as $index => $val){
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
                          	<th width="25%"><div align="center"><strong>สำนัก (ปฏิบัติ)</strong></div></th>
                          	<th width="8%"><div align="center"><strong>จำนวนคน</strong></div></th>                                                            
                          	<th width="12%"><div align="center"><strong>เงินเดือน</strong></div></th>
                          	<th width="8%"><div align="center"><strong>ร้อยละที่ได้เลื่อน<br>0.5 ขั้น</strong></div></th>
                          	<th width="8%"><div align="center"><strong>ร้อยละที่ได้เลื่อน<br> 1 ขั้น</strong></div></th>
                            <th width="8%"><div align="center"><strong>ร้อยละที่ได้เลื่อน<br> 1.5 ขั้น</strong></div></th>
                          	<th width="15%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                        </tr>
                    </thead>
                    <tbody >
                    <?php
					if($nums > 0){
					
					$i = 1;
					while($rec_org = $db->db_fetch_array($query_org)){
						$query_frame = $db->query("SELECT COUNT(PER_ID) AS NUM_PER, SUM(SALARY_NOW) AS SALARY_NOW FROM SAL_UP_SALARY WHERE POSTYPE_ID = 5 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND ORG_ID_3 = '".$rec_org['ORG_ID_3']."' ");
						$rec_frame = $db->db_fetch_array($query_frame);
						
						//ร้อยละที่ได้เลื่อน 0.5
						$query_1 = $db->query("SELECT COUNT(SAL_UP_ID) AS NUM_PER FROM SAL_UP_SALARY WHERE POSTYPE_ID = 5 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND ORG_ID_3 = '".$rec_org['ORG_ID_3']."' AND STEP_UP = 0.5 ");
						$rec_1 = $db->db_fetch_array($query_1);
						//ร้อยละที่ได้เลื่อน 1
						$query_2 = $db->query("SELECT COUNT(SAL_UP_ID) AS NUM_PER FROM SAL_UP_SALARY WHERE POSTYPE_ID = 5 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND ORG_ID_3 = '".$rec_org['ORG_ID_3']."' AND STEP_UP = 1 ");
						$rec_2 = $db->db_fetch_array($query_2);
						//ร้อยละที่ได้เลื่อน 1.5
						$query_3 = $db->query("SELECT COUNT(SAL_UP_ID) AS NUM_PER FROM SAL_UP_SALARY WHERE POSTYPE_ID = 5 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND ORG_ID_3 = '".$rec_org['ORG_ID_3']."' AND STEP_UP = 1.5 ");
						$rec_3 = $db->db_fetch_array($query_3);
						
						$PERCENT_1 = ($rec_1['NUM_PER']/$rec_frame['NUM_PER'])*100;
						$PERCENT_2 = ($rec_2['NUM_PER']/$rec_frame['NUM_PER'])*100;
						$PERCENT_3 = ($rec_3['NUM_PER']/$rec_frame['NUM_PER'])*100;
						
						$query_score = $db->query("SELECT COUNT(SCORE_ID) AS NUM FROM SAL_SCORE WHERE POSTYPE_ID = 5 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."'  AND SCORE_STATUS = 1 AND CONFIRM_TYPE >= 2 ");
						$rec_score = $db->db_fetch_array($query_score);
						
						if((int)$rec_score['NUM'] > 0){
							$detail = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec_org["ORG_ID_3"]."');\">".$img_edit." บันทึกข้อมูล</a>";
						}else{
							$detail = "<div class='row' style='color:red'>กรุณาอนุมัติเกณฑ์การประเมินก่อน</div>";
						}
						
						
						$SALARY_UP = $db->get_data_field("SELECT SUM(SALARY_UP) AS SALARY_UP FROM SAL_UP_SALARY WHERE YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND ORG_ID_3 = '".$rec_org['ORG_ID_3']."' AND POSTYPE_ID = '3' AND SAL_UP_TYPE = 1", "SALARY_UP");
						$PERCENT = @($SALARY_UP/$rec_frame['SALARY_NOW'])*100;
						?>
                        <tr>
                            <td align="center"><?php echo $i;?>.</td>
                            <td align="left"><?php echo text($rec_org["ORG_NAME_TH"]);?></td>
                            <td align="center"><?php echo $rec_frame['NUM_PER'];?>&nbsp;</td>
                            <td align="right"><?php echo number_format($rec_frame['SALARY_NOW'],2);?>&nbsp;</td>
                            <td align="center"><?php echo number_format($PERCENT_1,2);?>&nbsp;</td>
                            <td align="center"><?php echo number_format($PERCENT_2,2);?>&nbsp;</td>
                            <td align="center"><?php echo number_format($PERCENT_3,2);?>&nbsp;</td>
                            <td align="center"><?php echo $detail;?></td>
                        </tr>
                        <?php
						$i++;
					}
					}else{
						echo "<tr><td align=\"center\" colspan=\"8\">ไม่พบข้อมูล</td></tr>";
					}
                    ?>
                 	</tbody>
                </table>
			</div>
                                       
		</form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>