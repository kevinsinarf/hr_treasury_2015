<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
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
			<li class="active">บันทึกการเลื่อนขั้นเงินเดือนผู้บริหาร</li>
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
			<input type="hidden" id="MT_ID" name="MT_ID" value="">
            
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
				<div class="col-xs-12 col-md-1">
                <select name="S_ROUND" id="S_ROUND" class="selectbox form-control" placeholder="เลือกรอบ">
                    <option value=""></option>
					<?php 
                    for($r=1;$r<=2;$r++){
                        ?>
                        <option value="<?php echo $r;?>" <?php if($r == $S_ROUND){ echo "selected"; }?>><?php echo $r;?></option>
                        <?php
                    }
                    ?>
                </select>
                </div>
				<div class="col-xs-12 col-md-1"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
			</div>
             
            <?php if($proc == 'search'){?>                       
			<div class="row"><?php echo ($nums>0) ? startPaging("frm-search",$total_record):""; ?></div>
			<div class="col-xs-12 col-sm-12">
			<div class="table-responsive">
                <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                    <thead>
                        <tr class="bgHead">
                            <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                          	<th width="30%"><div align="center"><strong>ตำแหน่งทางการบริหาร</strong></div></th>
                          	<th width="10%"><div align="center"><strong>จำนวนคน</strong></div></th>                                                            
                          	<th width="14%"><div align="center"><strong>เงินเดือน</strong></div></th>
                          	<th width="14%"><div align="center"><strong>จำนวนเงินที่ได้เลื่อน</strong></div></th>
                          	<th width="10%"><div align="center"><strong>ร้อยละที่ได้เลื่อน</strong></div></th>
                          	<th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                        </tr>
                    </thead>
                    <tbody >
                    <?php
					$q_manage = $db->query("SELECT MT_ID, MT_NAME_TH, 
					(SELECT SUM(PER_SALARY)	FROM PER_PROFILE WHERE PER_PROFILE.MT_ID = SETUP_POS_MANAGE_TYPE.MT_ID AND PT_ID = '1') AS SALARY,
					(SELECT COUNT(PER_ID) FROM PER_PROFILE WHERE PER_PROFILE.MT_ID = SETUP_POS_MANAGE_TYPE.MT_ID AND PT_ID = '1') AS NUM
					FROM SETUP_POS_MANAGE_TYPE  WHERE ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' ORDER BY MT_SEQ");
					$i = 1;
					while($r_manage = $db->db_fetch_array($q_manage)){
						$detail = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$r_manage["MT_ID"]."');\">".$img_edit." บันทึกข้อมูล</a>";
						$SALARY_UP = $db->get_data_field("SELECT SUM(SALARY_UP) AS SALARY_UP FROM SAL_UP_SALARY WHERE YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND MT_ID = '".$r_manage['MT_ID']."' AND POSTYPE_ID = '1'", "SALARY_UP");
						$PERCENT = @($SALARY_UP/$r_manage['SALARY'])*100;
						?>
                        <tr>
                            <td align="center"><?php echo $i;?>.</td>
                            <td align="left"><?php echo text($r_manage['MT_NAME_TH']);?></td>
                            <td align="center"><?php echo $r_manage['NUM'];?>&nbsp;</td>
                            <td align="right"><?php echo number_format($r_manage['SALARY'],2);?>&nbsp;</td>
                            <td align="right"><?php echo number_format($SALARY_UP,2);?>&nbsp;</td>
                            <td align="center"><?php echo number_format($PERCENT,2);?>&nbsp;</td>
                            <td align="center"><?php echo $detail;?>&nbsp;</td>
                        </tr>
                        <?php
						$i++;
					}
                    ?>
                 	</tbody>
                </table>
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