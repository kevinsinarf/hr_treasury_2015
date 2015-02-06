<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

// กลุ่มงาน
$q_level = $db->query("SELECT LEVEL_ID, LEVEL_NAME_TH FROM SETUP_POS_LEVEL WHERE POSTYPE_ID = '3' AND ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' ORDER BY LEVEL_SEQ ASC");
while($r_level = $db->db_fetch_array($q_level)){
	$arr_level[$r_level['LEVEL_ID']] = text($r_level['LEVEL_NAME_TH']);
}

$query = $db->query("SELECT * FROM SAL_STEP WHERE LEVEL_SEQ = '".$S_LEVEL_SEQ."'");
$rec = $db->db_fetch_array($query);
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
<script src="js/set_salary3_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-sm-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
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
			<input type="hidden" id="STEP_ID" name="STEP_ID" value="<?php echo $rec['STEP_ID']; ?>">
            
			<div class="row">
                <div class="col-xs-12 col-md-2">กลุ่ม :  <span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-1">
                <select name="S_LEVEL_SEQ" id="S_LEVEL_SEQ" class="selectbox form-control" placeholder="เลือกกลุ่ม">
                    <option value=""></option>
					<?php 
                    for($g=1;$g<=4;$g++){
                        ?>
                        <option value="<?php echo $g;?>" <?php if($g == $S_LEVEL_SEQ){ echo "selected"; }?>><?php echo $g;?></option>
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
                          <th width="6%" rowspan="2"><div align="center"><strong>ลำดับขั้น</strong></div></th>
                          <th colspan="3"><div align="center"><strong>อัตราค่าจ้าง / ขั้นวิ่ง</strong></div></th>
                          <th>&nbsp;</th>
                        </tr>
                        <tr class="bgHead">
                            <th width="10%"><div align="center"><strong>รายเดือน</strong></div></th>                                                            
                          	<th width="10%"><div align="center"><strong>รายวัน</strong></div></th>
                          	<th width="10%"><div align="center"><strong>รายชั่วโมง</strong></div></th>
                            <th width="5%"><div align="center"><strong>ลบ</strong></div></th>
                        </tr>
                    </thead>
                    <tbody >
                    <?php
					$q_edit = $db->query("SELECT * FROM SAL_STEP_DETAIL WHERE STEP_ID = '".$rec['STEP_ID']."' ");
					$i = 0;
					while($r_edit = $db->db_fetch_array($q_edit)){
						$i++;
						$id_tb = "A".$i;//id tr ตั้งขึ้นมาเอง
						?>
                        <tr id="<?php echo $id_tb;?>" >
                            <td align="center"><input type="text" id="STEP_NO_<?php echo $id_tb;?>" name="STEP_NO[]" value="<?php echo number_format($r_edit['STEP_NO'],1);?>" class="form-control" maxlength="6" style="width:100px;text-align:center;" onBlur="NumberFormat(this,1)"></td>
                            <td align="center"><input type="text" id="SAL_MONTH_<?php echo $id_tb;?>" name="SAL_MONTH[]" value="<?php echo number_format($r_edit['SAL_MONTH'],2);?>" class="form-control" maxlength="6" style="width:120px;text-align:right;" onBlur="NumberFormat(this,2)"></td>
                            <td align="center"><input type="text" id="SAL_DAY_<?php echo $id_tb;?>" name="SAL_DAY[]" value="<?php echo number_format($r_edit['SAL_DAY'],2);?>" class="form-control" maxlength="6" style="width:120px;text-align:right;" onBlur="NumberFormat(this,2)"></td>
                            <td align="center"><input type="text" id="SAL_HOURS_<?php echo $id_tb;?>" name="SAL_HOURS[]" value="<?php echo number_format($r_edit['SAL_HOURS'],2);?>" class="form-control" maxlength="6" style="width:120px;text-align:right;" onBlur="NumberFormat(this,2)"></td>
                            <td align="center"><a class="btn btn-default btn-xs" data-backdrop="static" href="javascript:void(0);" onClick="remove_id('<?php echo $id_tb;?>');" ><?php echo $img_del;?> ลบ</a></td>
                        </tr>
                        <?php
                        }
                    ?>
                 	</tbody>
                </table>
                <div align="right"><a href="javascript:void(0);" onClick="add_row();"><img src="<?php echo $path; ?>images/ico078.gif" border="0">เพิ่มรายการใหม่</a></div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่มีผลบังคับใช้ : <span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2">
                        <div class="input-group">
                            <input type="text" class="form-control col-md-13" name="S_STEP_ACTIVE_DATE" id="S_STEP_ACTIVE_DATE" value="<?php echo conv_date($rec['STEP_ACTIVE_DATE']);?>" placeholder="DD/MM/YYYY">
                            <span class="input-group-addon datepicker" for="S_STEP_ACTIVE_DATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานะการใช้งาน : <span style="color:red;">*</span></div>
                        <div class="col-xs-12 col-md-2">
                        <input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS" value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$rec['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?>
                        </div>
                        <div class="col-xs-12 col-md-1"></div>
                    </div>
                </div>
			</div>
            
            <div class="formlast">
                <div class="col-xs-12 col-sm-12" align="center">
                    <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                </div>
            </div>
            <br>
            <?php } ?>
		</form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>