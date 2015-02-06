<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$SCORE_TYPE = $_POST['SCORE_TYPE'];
$S_YEAR_BDG = trim($_POST['S_YEAR_BDG']);
$S_ROUND = trim($_POST['S_ROUND']);

//DEFALUT
if($S_YEAR_BDG == ''){
	$S_YEAR_BDG = (date('Y')+543);
}
if($S_ROUND == ''){
	$S_ROUND = 1;
}
if($SCORE_TYPE == ''){
	$SCORE_TYPE = 1;
}



$q_edit = $db->query("SELECT   SCORE_TYPE,LV_SCORE_ID, SCORE_S, SCORE_E, PERCENT_SAL,PERCENT_SAL_E 
FROM SAL_SCORE 
WHERE  POSTYPE_ID= '5' AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND   SCORE_STATUS = 1 
ORDER BY SCORE_ID ASC");
$query_num = $db->query("SELECT COUNT(SCORE_ID) AS NUM_SCORE FROM SAL_SCORE WHERE POSTYPE_ID = '5' AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."'   AND SCORE_STATUS = 1 AND CONFIRM_TYPE = 2 ");
$rec_num = $db->db_fetch_array($query_num);
$num_score = (int)$rec_num['NUM_SCORE'];


$arr_type_score = array(
	  '1' => 'แบบช่วงเกณฑ์',
	  '2' => 'แบบกำหนดเกณฑ์',
	  '3' => 'แบบเลือกเกณฑ์'
);
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
<script src="js/set_level_salary3_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-sm-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active">ลูกจ้างประจำ-><?php echo Showmenu($menu_sub_id);?></li>
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
            <input type="hidden" id="SCORE_TYPE" name="SCORE_TYPE" value="1">
			<div class="row">
				<div class="col-xs-12 col-md-2" >ปีงบประมาณ : <span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-3">
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
				<div class="col-xs-12 col-md-2"></div>
                <div class="col-xs-12 col-md-2">รอบ :  <span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-3">
                <select name="S_ROUND" id="S_ROUND" class="selectbox form-control" placeholder="รอบ" onChange="$('#frm-search').submit();" >
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
			</div>
            
          <div class="row" align="center">
            <div class="col-xs-12 col-md-12">
          <button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
          </div>
            
                
			<div class="row"><?php echo ($nums>0) ? startPaging("frm-search",$total_record):""; ?></div>
			<div class="col-xs-12 col-sm-12">
			<div class="table-responsive">
                <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                    <thead>
                        <tr class="bgHead">
                            <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                          	<th width="20%"><div align="center"><strong>ระดับ</strong></div></th>                                                            
                          	<th width="30%"><div align="center"><strong>คะแนน</strong></div></th>
                            <th width="20%"><div align="center"><strong>ขั้น</strong></div></th>
                          	<th width="5%"><div align="center"><strong>ลบ</strong></div></th>
                        </tr>
                    </thead>
                    <tbody >
                    <?php
					
					$i = 0;
					while($r_edit = $db->db_fetch_array($q_edit)){
						$i++;
						$id_tb = "A".$i;//id tr ตั้งขึ้นมาเอง
						?>
                        <tr id="<?php echo $id_tb;?>" >
                            <td align="center"><?php echo $i;?>.</td>
                            <td align="center">
                            <div style="text-align:left; width:105px;">
                            <?php
							$q_lv = $db->query("SELECT  LV_SCORE_ID, LEVEL_NAME FROM SAL_LEVEL_SCORE WHERE ACTIVE_STATUS = '1' ORDER BY LV_SEQ ASC");
							?>
							<select name="LV_SCORE_ID[]" id="LV_SCORE_ID_<?php echo $id_tb;?>" placeholder="ระดับ" class="selectbox form-control" style="width:100px;">
								<option value=""></option>
								<?php
								while($r_lv = $db->db_fetch_array($q_lv)){
									?>
									<option value="<?php echo $r_lv['LV_SCORE_ID'];?>" <?php if($r_lv['LV_SCORE_ID'] == $r_edit['LV_SCORE_ID']){ echo "selected";}?>><?php echo text($r_lv['LEVEL_NAME']);?></option> 
									<?php
								}
								?>
							</select>
                            </div>
                            </td>
                            <td align="center">
                            <input type="text" id="SCORE_S_<?php echo $id_tb;?>" name="SCORE_S[]" value="<?php echo number_format($r_edit['SCORE_S'],2);?>" class="form-control" maxlength="6" style="width:100px;display:inline; text-align:center;" onKeyUp="chkFormatNam_id(this.value,this.id); " onBlur="NumberFormat(this,2)"> 
                            -<input type="text" id="SCORE_E_<?php echo $id_tb;?>" name="SCORE_E[]" value="<?php echo number_format($r_edit['SCORE_E'],2);?>" class="form-control" maxlength="6" style="width:100px;display:inline; text-align:center;" onKeyUp="chkFormatNam_id(this.value,this.id); " onBlur="NumberFormat(this,2)">
                            </td>
                            <td align="center">
                            <input type="text" id="PERCENT_SAL_<?php echo $id_tb;?>" name="PERCENT_SAL[]" value="<?php echo number_format($r_edit['PERCENT_SAL'],2);?>" class="form-control" maxlength="6" style="width:100px;display:inline; text-align:center;" onKeyUp="chkFormatNam_id(this.value,this.id); "  onBlur="NumberFormat(this,2)">
						<?php 
							if($SCORE_TYPE==1||$SCORE_TYPE==3){
							?>
                            <?php if($SCORE_TYPE==1){ echo '-'; }else{ echo ',';} ?><input type="text" id="PERCENT_SAL_E<?php echo $id_tb;?>" name="PERCENT_SAL_E[]" value="<?php echo number_format($r_edit['PERCENT_SAL_E'],2);?>" class="form-control" maxlength="6" style="width:100px;display:inline; text-align:center;" onKeyUp="chkFormatNam_id(this.value,this.id); " onBlur="NumberFormat(this,2)">
							<?php
							}
							
							 ?>
                            </td>
                            <td align="center"><a class="btn btn-default btn-xs" data-backdrop="static" href="javascript:void(0);" onClick="remove_id('<?php echo $id_tb;?>');" >
                            <?php echo $img_del;?> ลบ</a></td>
                        </tr>
                        <?php
                        }
                    ?>
                 	</tbody>
                </table>
                <?php if($num_score == 0){ ?>
                <div align="right"><a href="javascript:void(0);" onClick="add_row(<?php echo $SCORE_TYPE; ?>);"><img src="<?php echo $path; ?>images/ico078.gif" border="0">เพิ่มรายการใหม่</a></div>
				<?php } ?>
            </div>
			</div>
            <?php if($num_score == 0){ ?>
            <div class="formlast">
                <div class="col-xs-12 col-sm-12" align="center">
                    <button type="button" class="btn btn-primary" onClick="chkinput(1);">บันทึก</button>
                    <button type="button" class="btn btn-default" onClick="ConfirmGov(2);">อนุมัติเกณฑ์การประเมิน</button>
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