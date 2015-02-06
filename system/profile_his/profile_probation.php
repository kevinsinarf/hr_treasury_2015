<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
//page back
if($PT_ID=="2"){
	$page_back = "profile_his_empser.php";
	$POSTYPE_ID = '3';
}elseif($PT_ID=="3"){
	$page_back = "profile_his_emp.php";
	$POSTYPE_ID = '5';
}else{
	$page_back = "profile_his_disp.php";
	$POSTYPE_ID = '1';
}

//  MAIN 
$field="PROHIS_ID, PER_ID, PRO_SEQ, TYPE_ID, LEVEL_ID, LINE_ID, MANAGE_ID, PROHIS_RESULT";
$table=" PER_PROBATIONHIS ";
$orderby="order by PRO_SEQ ASC ";

$sql = "select ".$field." from ".$table." where PER_ID = '".$PER_ID."'".$orderby;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);

$arr_result = array("1" => "ผ่าน", "2" => "ไม่ผ่าน", 3=> "ขยายระยะเวลาทดลองปฏิบัติราชการ");
//สายงาน
$arr_pos_line = GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LINE_NAME_TH");
//ตำแหน่งในการบริหาร
$arr_manage = GetSqlSelectArray("MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "MANAGE_NAME_TH");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
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
<script src="js/profile_probation.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
      <li class="active">ประวัติการทดลองราชการ</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <?php include("tab_profile.php");?>
    <div class="grouptab">
      <?php include("tab_info.php");?>
      <div class="clearfix"></div>
      <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
		<input type="hidden" id="PRO_ID" name="PRO_ID" value="">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
          
        <div class="row">
          <div class="col-xs-12 col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                  <tr class="bgHead">
                    <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
					<th width="10%"><div align="center"><strong>ครั้งที่</strong></div></th>
                    <th width="10%"><div align="center"><strong>วันที่ประเมิน</strong></div></th>
                    <th width="15%"><div align="center"><strong>ประเภทตำแหน่ง</strong></div></th>
                    <th width="15%"><div align="center"><strong>ระดับตำแหน่ง</strong></div></th>
                    <th width="15%"><div align="center"><strong>ตำแหน่งในสายงาน</strong></div></th>
                    <th width="15%"><div align="center"><strong>ตำแหน่งในการบริหาร</strong></div></th>
                    <th width="10%"><div align="center"><strong>ผลการประเมิน</strong></div></th>
                  </tr>
                </thead>
                <tbody>
                <?php
			    if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($query)){
				 		if($rec['PRO_SEQ'] == 1){
							$PER_DATE_PRO = $info['PER_DATE_PRO1'];	
						}else if($rec['PRO_SEQ'] == 2){
							$PER_DATE_PRO = $info['PER_DATE_PRO2'];
						}else if($rec['PRO_SEQ'] == 3){
							$PER_DATE_PRO = $info['PER_DATE_PRO3'];	
						}
						?>
                        <tr bgcolor="#FFFFFF">
                            <td align="center"><?php echo $i+$goto; ?>.</td>
                            <td align="center"><?php echo text($rec["PRO_SEQ"]); ?></td>
                            <td align="center"><?php echo conv_date($PER_DATE_PRO,'short'); ?></td>
                            <td align="left"><?php echo text($arr_pos_type[$rec["TYPE_ID"]]); ?></td>
                            <td align="left"><?php echo text($arr_pos_level[$rec["LEVEL_ID"]]); ?></td>
                            <td align="left"><?php echo text($arr_pos_line[$rec["LINE_ID"]]); ?></td>
                            <td align="left"><?php echo text($arr_manage[$rec["MANAGE_ID"]]); ?></td>
                            <td align="center"><?php echo ($arr_result[$rec["PROHIS_RESULT"]]); ?></td>
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
          </div>
        </div>
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>