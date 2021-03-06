<?php
$path = "../../";
include($path . "include/config_header_top.php");
$link = "r=home&menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id;  /// for mobile
$paramlink = url2code($link);

/*$SAPA_ID=($SAPA_ID?$SAPA_ID:key($arr_sapa));

$filter = "";
if($name != ""){
	$filter .= searchName("a.SS_FIRSTNAME_TH","a.SS_MIDNAME_TH","a.SS_LASTNAME_TH",ctext($name));
}
if($ef_status != ""){
	$filter .= " and b.SSP_STATUS_1 = '".$ef_status."' ";
}

$field="a.SS_ID,a.SS_IDCARD,a.PREFIX_ID, a.SS_FIRSTNAME_TH,a.SS_MIDNAME_TH,a.SS_LASTNAME_TH,b.PARTY_ID,b.SSP_STATUS_1";
$table="SS_PROFILE a
JOIN SS_SAPA_POSITION b on a.SS_ID = b.SS_ID";
$pk_id="b.SSP_ID";
$wh="1=1 and a.ACTIVE_STATUS='1' and a.DELETE_FLAG='0' and b.SSP_STATUS_3='1' and  b.SAPA_ID='".$SAPA_ID."' ".$filter;
$orderby="order by a.SS_FIRSTNAME_TH, (case when Rtrim(a.SS_MIDNAME_TH)!='' then a.SS_MIDNAME_TH else '' end), a.SS_LASTNAME_TH asc";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));*/
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
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
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
<script language="javascript">
	function searchData(){
		$("#page").val(1);
		$("#frm-search").submit();
	}
</script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path . "include/header.php"); ?></div>
	<div><?php include($path . "include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li><a href="report_all_disp.php?<?php echo $paramlink; ?>"><?php echo showMenu($menu_sub_id);?></a></li>
			<li class="active">ลูกจ้างประจำ (รายงานตรวจสอบ การถูกลงโทษ)</li>
		</ol>
	</div>
	<div class="col-xs-12 col-md-12">
		<div class="groupdata">
			<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
				<input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
				<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
				<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
							<? include ("inc.head.report1.php"); // form รายงาน ?>
				<div class="row">
					<div class="col-xs-6 col-md-6  text-left"><?php echo PrintAll('eform'); ?></div>
				</div>
				<div class="col-xs-12 col-md-12">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover table-condensed">
							<thead>							
								<tr class="bgHead">
									<th width="5%"><div align="center"><strong>เลขที่ตำแหน่ง</strong></div></th>
									<th width="15%"><div align="center"><strong>ชื่อ - สกุล </strong></div></th>
									<th width="10%"><div align="center"><strong>ตำแหน่ง</strong></div></th>
									<th width="10%"><div align="center"><strong>สำนัก</strong></div></th>
									<th width="10%"><div align="center"><strong>กลุ่มงาน</strong></div></th>
									<th width="20%"><div align="center"><strong>ฐานความผิด</strong></div></th>
									<th width="20%"><div align="center"><strong>โทษทางวินัย</strong></div></th>
									<th width="10%"><div align="center"><strong>มีผล ณ วันที่</strong></div></th>
								</tr>
							</thead>
							<tbody>
							<?php
							/*if ($nums > 0) {
								$i = 1;								
								while($rec= $db->db_fetch_array($query)) {*/
									$name=Showname($rec["PREFIX_ID"],$rec["SS_FIRSTNAME_TH"],$rec["SS_MIDNAME_TH"],$rec["SS_LASTNAME_TH"]);
								 ?>
								<tr bgcolor="#FFFFFF">
									<td align="center">1</td>
									<td align="left">นายเอกนัฏ  พร้อมพันธุ์</td>
									<td align="left">ผู้บริหาร</td>
									<td align="left">ทดสอบ</td>
									<td align="left">ทดสอบ</td>
									<td align="left">ทดสอบ</td>
									<td align="left">ทดสอบ</td>
									<td align="center">6 ก.พ. 2557</td>
								</tr>
								<?php
									/*$i++; 
									}	
								 } else {
									echo "<tr><td align=\"center\" colspan=\"8\">ไม่พบข้อมูล</td></tr>";
								 }*/
								?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row"><?php echo ($nums>0)?endPaging("frm-search",$total_record):"";?></div>
			</form>
		</div>
	</div>
	<div style="text-align:center; bottom:0px;"><?php include($path . "include/footer.php"); ?></div>
</div>
</body>
</html>