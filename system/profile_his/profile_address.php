<?php 
$path = "../../";
include($path."include/config_header_top.php");

$ACT = 2;
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;  /// for mobile
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

$field=" PADD_ID, PADD_TYPE, PADD_ROOM_NO, PADD_FLOOR, PADD_BUILDING, PADD_HOME_NO, PADD_MOO, PADD_VILLAGE, PADD_SOI, PADD_ROAD, 
		 PADD_TAMB_ID, PADD_AMPR_ID, PADD_PROV_ID, PADD_POSTCODE, PADD_TEL, PADD_TEL_EXT, PADD_FAX, PADD_FAX_EXT, PADD_MOBILE";	
$table=" PER_ADDRESS";
$orderby=" order by PADD_ID ASC";

$sql = "select ".$field." from ".$table." where DELETE_FLAG = '0' AND ACTIVE_STATUS = '1' AND PER_ID = '".$PER_ID."'".$orderby;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);

$arr_tamb = GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH"); //ตำบล
$arr_ampr = GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH"); //อำเภอ
$arr_prov = GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME"); //จังหวัด
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
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/tooltip.js"></script> 
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_address.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
            <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
            <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
            <li class="active">ประวัติที่อยู่</li>
		</ol>
	</div>
	<div class="col-xs-12 col-md-12" id="content">
		<?php include("tab_profile.php");?>
		<div class="grouptab">
		 <?php include("tab_info.php");?>
		 <div class="clearfix"></div>
			<form id="frm-search" method="post" action="process/profile_address_process.php" >
				<input type="hidden" id="proc" name="proc" value="<?php echo 'edit'; ?>">
				<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
				<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
				<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
				<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        		<input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
				<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
				<input type="hidden" id="PADD_ID" name="PADD_ID" value="">
				<input type="hidden" id="PADD_TYPE" name="PADD_TYPE" value="">

                <div class="row">
                    <div class="col-xs-12 col-md-12"> 
                        <a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();">
                        <?php echo $img_save;?> เพิ่มข้อมูล</a> 
                    </div>
                </div>
                
                <div class="col-xs-12 col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-condensed">
                            <thead>
                                <tr class="bgHead">
                                    <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                                    <th width="12%"><div align="center"><strong>ประเภท</strong></div></th>
                                    <th width="24%"><div align="center"><strong>ที่อยู่</strong></div></th>
                                    <th width="16%" nowrap><div align="center"><strong>หมายเลขติดต่อ</strong></div></th>
                                    <th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($nums > 0){
                                $i=1;
                                while($rec = $db->db_fetch_array($query)){
                                    $PADD_ROOM_NO = (trim($rec['PADD_ROOM_NO']) != '') ? 'เลขที่ห้อง '.text($rec['PADD_ROOM_NO']) : '';
                                    $PADD_FLOOR = (trim($rec['PADD_FLOOR']) != '') ? ' ชั้น '.text($rec['PADD_FLOOR']) : '';
                                    $PADD_BUILDING = (trim($rec['PADD_BUILDING']) != '') ? ' อาคาร'.text($rec['PADD_BUILDING']) : '';
                                    $PADD_HOME_NO = (trim($rec['PADD_HOME_NO']) != '') ? '<br>บ้านเลขที่ '.text($rec['PADD_HOME_NO']) : '';
                                    $PADD_MOO = (trim($rec['PADD_MOO']) != '') ? ' หมู่ที่ '.text($rec['PADD_MOO']) : '';
                                    $PADD_VILLAGE = (trim($rec['PADD_VILLAGE']) != '') ? ' หมู่บ้าน'.text($rec['PADD_VILLAGE']) : '';
                                    $PADD_SOI = (trim($rec['PADD_SOI']) != '') ? ' ซอย '.text($rec['PADD_SOI']) : '';
                                    $PADD_ROAD = (trim($rec['PADD_ROAD']) != '') ? ' ถนน'.text($rec['PADD_ROAD']) : '';
									$PADD_TAMB_ID = (!empty($rec['PADD_TAMB_ID'])) ? '<br>ตำบล'.text($arr_tamb[$rec['PADD_TAMB_ID']]) : '';
									$PADD_AMPR_ID = (!empty($rec['PADD_AMPR_ID'])) ? ' อำเภอ'.text($arr_ampr[$rec['PADD_AMPR_ID']]) : '';
									$PADD_PROV_ID = (!empty($rec['PADD_PROV_ID'])) ? ' จังหวัด'.text($arr_prov[$rec['PADD_PROV_ID']]) : '';
									$PADD_POSTCODE = (trim($rec['PADD_POSTCODE']) != '') ? ' '.$rec['PADD_POSTCODE'] : '';
                                    
                                    $ADDRESS = $PADD_ROOM_NO.$PADD_FLOOR.$PADD_BUILDING.$PADD_HOME_NO.$PADD_MOO.$PADD_VILLAGE.$PADD_SOI.$PADD_ROAD.$PADD_TAMB_ID.$PADD_AMPR_ID.$PADD_PROV_ID.$PADD_POSTCODE;
                                    
                                    $PADD_TEL_EXT = (trim($rec['PADD_TEL_EXT']) != '') ? ' ต่อ '.text($rec['PADD_TEL_EXT']) : '';
                                    $PADD_FAX_EXT = (trim($rec['PADD_FAX_EXT']) != '') ? ' ต่อ '.text($rec['PADD_FAX_EXT']) : '';
                                    $edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["PADD_ID"]."');\">".$img_edit." แก้ไข</a> ";
                                    $view_his = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"viewHis('".$rec["PADD_TYPE"]."');\">".$img_view." ดูประวัติการเปลี่ยนแปลง</a> ";
                                    ?>
                                    <tr bgcolor="#FFFFFF">
                                        <td align="center"><?php echo $i+$goto; ?>.</td>
                                        <td align="left"><?php echo $arr_address[$rec['PADD_TYPE']];?></td>
                                        <td align="left"><?php echo $ADDRESS;?></td>
                                        <td align="left">โทรศัพท์ <?php echo $rec['PADD_TEL'].$PADD_TEL_EXT;?><br>โทรสาร <?php echo $rec['PADD_FAX'].$PADD_FAX_EXT;?><br>โทรศัพท์เคลื่อนที่ <?php echo $rec['PADD_MOBILE'];?></td>
                                        <td align="center"><?php echo $edit.$view_his;?></td>
                                    </tr>
                                    <?php 
                                    $i++;
                                }
                            }else{
                                echo "<tr><td align=\"center\" colspan=\"5\">".$arr_txt['data_not_found']."</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>                  
                </div>
			</form>
		</div>
	</div>
   <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>