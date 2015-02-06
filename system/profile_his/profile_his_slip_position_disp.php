<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT= 6;
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
$paramlink = url2code($link2);

$arr_type = GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "POSTYPE_ID = '1' AND ACTIVE_STATUS = '1' and DELETE_FLAG = '0' AND TYPE_ID IN (1,2)", "TYPE_NAME_TH");

$filter = "";
if($S_POSCOM_NO != ""){
	$filter .= " and POSCOM_NO like '%".ctext($S_POSCOM_NO)."%'";
}
if($S_POSCOM_DATE != ""){
	$filter .= " and A.POSCOM_DATE = '".conv_date_db($S_POSCOM_DATE)."' ";
}
if($S_POSCOM_TITLE != ""){
	$filter .= " and A.POSCOM_TITLE like '".ctext($S_POSCOM_TITLE)."%' ";
}
if($S_TYPE_ID != ""){
	$filter .= " and B.TYPE_ID = '".$S_TYPE_ID."' ";
}


$field = "A.POSCOM_ID, A.POSCOM_NO, A.POSCOM_DATE, A.POSCOM_TITLE, TYPE_NAME_TH, A.POSCOM_SDATE";
$table = "POSITION_COMMAND A 
JOIN SETUP_POS_TYPE B ON A.POSCOM_LAST_TYPE_ID = B.TYPE_ID ";
$pk_id = "POSCOM_ID";
$wh = "A.DELETE_FLAG = '0' AND (A.TRANSFER_STATUS = 0  OR A.TRANSFER_STATUS IS NULL ) {$filter}";
$orderby = "order by A.POSCOM_DATE DESC";
$notin = $wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));


//ประเภทคำสั่ง
$arr_ct = GetSqlSelectArray( "CT_ID", "CT_NAME_TH", "SETUP_COMMAND_TYPE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0", "CT_NAME_TH" ); 

//ประเภทความเคลื่อนไหว
$arr_mov = GetSqlSelectArray("MOVEMENT_ID" , "MOVEMENT_NAME_TH" ,"SETUP_MOVEMENT","ACTIVE_STATUS = 1 AND DELETE_FLAG= 0 AND MOVEMENT_TYPE = 7","MOVEMENT_NAME_TH");
$arr_command_type = GetSqlSelectArray("CT_ID", "CT_NAME_TH", "SETUP_COMMAND_TYPE", " CT_TYPE = '1' ", "CT_NAME_TH");
$arr_movement = GetSqlSelectArray("MOVEMENT_ID", "MOVEMENT_NAME_TH", "SETUP_MOVEMENT", " ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' AND POSTYPE_ID = '1'", "MOVEMENT_NAME_TH");

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
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_his_slip_position_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php"); ?></div>
  <div><?php include($path."include/menu.php"); ?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
 <!--     <li><a href="profile_his_oth_disp.php?<?php echo $paramlink; ?>"><?php echo Showmenu($menu_sub_id);?></a></li>-->
      <li class="active"><?php echo Showmenu($menu_sub_id);?> (ข้อมูลการเลื่อนตำแหน่ง)</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
  		<?php include("tab_transfer.php");?>
        <div class="grouptab">
        <?php //include("tab_info.php");?>
		<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID;?>">
        <input type="hidden" id="POSCOM_ID" name="POSCOM_ID" value="">
		<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        
        <div class="row"><?php echo ($nums>0) ? startPaging("frm-search",$total_record):""; ?></div>
            
             <div class="row">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่คำสั่ง : </div>
				<div class="col-xs-12 col-md-2"><input type="text" name="S_POSCOM_NO" id="S_POSCOM_NO" value="<?php echo $S_POSCOM_NO;?>" class="form-control"></div>
				<div class="col-xs-12 col-md-2"></div>
                <div class="col-xs-12 col-md-2">ลงวันที่ :  </div>
				<div class="col-xs-12 col-md-2">
                	<div class="input-group">
                        <input type="text" class="form-control col-md-13" name="S_POSCOM_DATE" id="S_POSCOM_DATE" value="<?php echo $S_POSCOM_DATE;?>" placeholder="DD/MM/YYYY">
                        <span class="input-group-addon datepicker" for="S_POSCOM_DATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                    </div>
                </div>
			</div>
            <div class="row">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เรื่อง : </div>
				<div class="col-xs-12 col-md-3"><input type="text" name="S_POSCOM_TITLE" id="S_POSCOM_TITLE" value="<?php echo $S_POSCOM_TITLE;?>" class="form-control"></div>
                <div class="col-xs-12 col-md-1"></div>
                <div class="col-xs-12 col-md-2">ประเภทตำแหน่ง :  </div>
				<div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('S_TYPE_ID', 'S_TYPE_ID', $arr_type, 'ทั้งหมด', $S_TYPE_ID, '', '', '1', '', '1');?></div>
				<div class="col-xs-12 col-md-1"></div>
			</div>
                <div class="row" style="text-align:center;">
                                <button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button>
                </div>
        <div class="col-xs-12 col-sm-12">
			<div class="table-responsive">
                <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                    <thead>
                        <tr class="bgHead">
                            <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                          	<th width="8%"><div align="center"><strong>เลขที่คำสั่ง</strong></div></th>                                                            
                          	<th width="8%"><div align="center"><strong>ลงวันที่</strong></div></th>
                            <th width="24%"><div align="center"><strong>เรื่อง</strong></div></th>
                            <th width="10%"><div align="center"><strong>ประเภทตำแหน่ง</strong></div></th>
                            <th width="8%"><div align="center"><strong>วันที่มีผล</strong></div></th>
                          	<th width="10%"><div align="center"><strong>จัดการ</strong></div></th>
                        </tr>
                    </thead>
                    <tbody >
                    <?php
					if($nums > 0){
						$i = 1;
						while($rec = $db->db_fetch_array($query)){
								$view = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"viewData('".$rec["POSCOM_ID"]."');\">".$img_view." ดูรายละเอียด</a> ";
							?>
							<tr>
								<td align="center"><?php echo $i+$goto; ?>.</td>
								<td align="center"><?php echo text($rec['POSCOM_NO']);?></td>
								<td align="center"><?php echo conv_date($rec['POSCOM_DATE'],'short');?></td>
								<td align="left"><?php echo text($rec['POSCOM_TITLE']);?></td>
								<td align="center"><?php echo text($rec['TYPE_NAME_TH']);?></td>
								<td align="center"><?php echo conv_date($rec['POSCOM_SDATE'], 'short');?>&nbsp;</td>
								<td align="center"><?php echo $view ?></td>
							</tr>
							<?php
							$i++;
							}
					}else{
						echo "<tr><td align=\"center\" colspan=\"7\">ไม่พบข้อมูล</td></tr>";
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