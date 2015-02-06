<?php
session_start();
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$sub_menu = "";

$sub_menu = "สำนักงานเลขาธิการวุฒิสภา";
$POSTYPE_ID = 5;
$$ORG_ID_2 = 16;

$filter = "";

if(!empty($S_TYPE_ID) && $S_TYPE_ID != 'undefined'){
	$filter .= " AND A.TYPE_ID = ".$S_TYPE_ID;
}
if(!empty($S_LEVEL_ID) && $S_LEVEL_ID != 'undefined'){
	$filter .= " AND A.LEVEL_ID = ".$S_LEVEL_ID;
}
if(!empty($S_POS_NO) && $S_POS_NO != 'undefined'){
	$filter .= " AND A.POS_NO = ".$S_POS_NO;
}
if(!empty($S_ORG_ID_3) && $S_ORG_ID_3 != 'undefined'){
	$filter .= " AND A.ORG_ID_3 = ".$S_ORG_ID_3;
}
if(!empty($S_POS_STATUS) && $S_POS_STATUS != 'undefined'){
	$filter .= " AND A.POS_STATUS = ".$S_POS_STATUS;
}
$filter .= " AND A.POSTYPE_ID = 5 AND A.ORG_ID_2 = 16 ";

$field="A.POS_ID, A.POS_NO, A.POS_STATUS, B.TYPE_NAME_TH, C.LEVEL_NAME_TH, E.LG_NAME_TH, D.LINE_NAME_TH, O3.ORG_NAME_TH ";
$table=" POSITION_FRAME A 
			LEFT JOIN SETUP_POS_TYPE B ON A.TYPE_ID = B.TYPE_ID
			LEFT JOIN SETUP_POS_LEVEL C ON A.LEVEL_ID = C.LEVEL_ID
			LEFT JOIN SETUP_POS_LINE D ON A.LINE_ID = D.LINE_ID
			LEFT JOIN SETUP_POS_LINE_GROUP E ON E.LG_ID = A.LG_ID
			LEFT JOIN SETUP_ORG AS O3 ON A.ORG_ID_3 = O3.ORG_ID"; 
			

$pk_id="A.POS_ID";
$wh = " A.ACTIVE_STATUS='1' and A.DELETE_FLAG='0' {$filter} ";
$orderby=" ORDER BY A.POS_NO ASC";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));
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
<script src="js/ss_position_senator_per_staff_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
    <div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li class="active"><?php echo showMenu($menu_sub_id)." (".$sub_menu.")"; ?></li>
        </ol>
    </div>
	<div class="col-xs-12 col-sm-12" id="content">
		<div class="groupdata" >
			<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input name="proc" type="hidden" id="proc" value="<?php echo $proc; ?>">
				<input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
				<input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
				<input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
				<input name="POSTYPE_ID" type="hidden" id="POSTYPE_ID" value="<?php echo $POSTYPE_ID; ?>">
				<input name="ORG_ID_2" type="hidden" id="ORG_ID_2" value="<?php echo $ORG_ID_2; ?>">
				<input name="POS_ID" type="hidden" id="POS_ID">
				<div class="row">
					
						<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">กลุ่ม :</div>
						<div class="col-xs-12 col-sm-3">
							<select id="S_TYPE_ID" name="S_TYPE_ID" class="selectbox form-control" placeholder="-ทั้งหมด-" onChange="get_level(this);">
								<option value=""></option>
								<?php
								$sql_type_name = "Select TYPE_ID , TYPE_NAME_TH From SETUP_POS_TYPE WHERE ACTIVE_STATUS = 1 AND POSTYPE_ID = '".$POSTYPE_ID."' AND DELETE_FLAG = 0 ORDER BY TYPE_SEQ ASC";
								$query_type_name = $db->query($sql_type_name);
								$select_type[$S_TYPE_ID] = "Selected='Selected'";
								while($type = $db->db_fetch_array($query_type_name)){
									echo '<option value="'.$type['TYPE_ID'].'" '.$select_type[$type['TYPE_ID']].' >'.text($type['TYPE_NAME_TH']).'</option>';
								}
								?>
							</select>
						</div>
                        <div class="col-xs-12 col-sm-4 col-md-1"></div>
                        <div class="col-xs-12 col-sm-2 col-md-2" style="white-space:nowrap;">ระดับตำแหน่ง :</div>
                        <div class="col-xs-12 col-sm-4 col-md-3">
                            <select id="S_LEVEL_ID" name="S_LEVEL_ID" class="selectbox form-control" placeholder="-ทั้งหมด-" onChange="getLine(this.value);">
                                <option value=""></option>
                                <?php
                                	$cond_level = ($S_TYPE_ID != '') ? " and TYPE_ID = '".$S_TYPE_ID."'" : "";
                                	$sql_level_name = "Select LEVEL_ID , LEVEL_NAME_TH  From SETUP_POS_LEVEL WHERE ACTIVE_STATUS = 1 AND POSTYPE_ID = '$POSTYPE_ID' AND DELETE_FLAG = '0'".$cond_level." ORDER BY LEVEL_SEQ ASC";
                                    $select_level[$S_LEVEL_ID] = "Selected='Selected'";
                                    $query_level_name = $db->query($sql_level_name);
                                    while($level = $db->db_fetch_array($query_level_name)){
                                        echo '<option value="'.$level['LEVEL_ID'].'" '.$select_level[$level['LEVEL_ID']].'>'.text($level['LEVEL_NAME_TH']).'</option>';
                                    }
                                ?>
                            </select>
                        </div>
					</div>       
					
				<div class="row">
					<div class="col-xs-12 col-sm-2 col-md-2" style="white-space:nowrap;">เลขที่ตำแหน่ง :</div>
					<div class="col-xs-12 col-sm-4 col-md-3"><input type="text" name="S_POS_NO" id="S_POS_NO" value="<?php echo $S_POS_NO;?>" class="form-control"></div>
                    <div class="col-xs-12 col-sm-4 col-md-1"></div>
                    <div class="col-xs-12 col-sm-2 col-md-2" style="white-space:nowrap;">สำนัก/กลุ่ม :</div>
					<div class="col-xs-12 col-sm-4 col-md-3">
						<select id="S_ORG_ID_3" name="S_ORG_ID_3" class="selectbox form-control" placeholder="-ทั้งหมด-">
							<option value=""></option>
							<?php
							$sql_org_3 = "Select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND OL_ID = 16 AND ORG_PARENT_ID = 16 ORDER BY ORG_SEQ ASC";
							$query_org_3 = $db->query($sql_org_3);
							$select_org_3[$S_ORG_ID_3] = "Selected='Selected'";
							while($org = $db->db_fetch_array($query_org_3)){
								echo '<option value="'.$org['ORG_ID'].'" '.$select_org_3[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
							}
							?>
						</select>
					</div>
                </div> 
                                
				<div class="row">
					<div class="col-xs-12 col-sm-2 col-md-2" style="white-space:nowrap;">สถานะของตำแหน่ง :</div>
					<div class="col-xs-12 col-sm-4 col-md-3">
						<select id="S_POS_STATUS" name="S_POS_STATUS" class="selectbox form-control" placeholder="-ทั้งหมด-" >
                        	<?php $arr_stauts[$S_POS_STATUS] = "Selected='Selected'"; ?>
							<option value=""></option>
							<option value="1" <?php echo $arr_stauts[1]; ?>>ว่าง ไม่มีเงิน</option>
							<option value="2" <?php echo $arr_stauts[2]; ?>>ว่าง มีเงิน</option>
							<option value="3" <?php echo $arr_stauts[3]; ?>>มีคนถือครอง</option>
							<option value="4" <?php echo $arr_stauts[4]; ?>>ยุบเลิก</option>
						</select>
					</div>
				</div>
                
				<div class="row">
					<div class="col-xs-12 col-sm-3 col-md-12" align="center"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
				</div>
                
				<div class="row"><div class="col-sm-12"> <a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();"><?php echo $img_save;?> เพิ่มข้อมูล</a> </div></div>
				<div class="row"><?php echo ($nums > 0) ? startPaging("frm-search",$total_record):""; ?></div>
				<div class="col-xs-12 col-sm-12">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<tr class="bgHead">
									<th nowrap width="5%"><div align="center">ลำดับ</div></th>
									<th nowrap width="8%"><div align="center">เลขที่ตำแหน่ง</div></th>
									<th nowrap width="12%"><div align="center">กลุ่ม</div></th>
									<th nowrap width="12%"><div align="center">ระดับตำแหน่ง</div></th>
									<th nowrap width="12%"><div align="center">สายงาน</div></th>
									<th nowrap width="12%"><div align="center">ตำแหน่งในสายงาน</div></th>
									<th nowrap width="14%"><div align="center">สำนัก/กลุ่ม</div></th>
									<th nowrap width="8%"><div align="center">สถานะของตำแหน่ง</div></th>
									<th nowrap width="10%"><div align="center">จัดการ</div></th>
								</tr>
							</thead>
							<tbody>
							<?php
							$arr_status = array(1=>'ว่าง ไม่มีเงิน',2=>'ว่าง มีเงิน',3=>'มีผู้ถือครอง',4=>'ยุบเลิก');
							if($nums > 0){
								$i=1;
								while($rec = $db->db_fetch_array($query)){
								   
									$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["POS_ID"]."');\">".$img_edit." แก้ไข</a> ";
									$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["POS_ID"]."');\">".$img_del." ลบ</a> ";
									?>
									<tr>
										<td align="center" bgcolor="#FFFFFF" ><?php echo $i+$goto; ?>.</td>
										<td bgcolor="#FFFFFF" align="center"><?php echo text($rec["POS_NO"]); ?></td>
										<td bgcolor="#FFFFFF"><?php echo  text($rec["TYPE_NAME_TH"]); ?></td>
										<td bgcolor="#FFFFFF"><?php echo text($rec["LEVEL_NAME_TH"]); ?></td>
										<td bgcolor="#FFFFFF"><?php echo text($rec["LG_NAME_TH"]); ?></td>
										<td bgcolor="#FFFFFF"><?php echo text($rec["LINE_NAME_TH"]); ?></td>
										<td bgcolor="#FFFFFF"><?php echo  text($rec["ORG_NAME_TH"]); ?></td>
										<td bgcolor="#FFFFFF" align="center"><?php echo $arr_status[$rec["POS_STATUS"]]; ?></td>
                                        <td bgcolor="#FFFFFF" align="center"><?php echo $edit." ".$delete; ?></td>
                                    </tr>
                           		 	<?php 
									$i++;
								}
							}else{
								if($POSTYPE_ID == 1){
									$colspan = 9;
								}else if($POSTYPE_ID == 5){
									$colspan = 7;
								}else if($POSTYPE_ID == 3){
									$colspan = 8;
								}
								echo "<tr><td align=\"center\" colspan=\"".$colspan."\">ไม่พบข้อมูล</td></tr>";
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="clearfix"></div>
				<?php echo @(ceil($total_record/$page_size) > 1) ? endPaging("frm-search",$total_record):""; ?>
				<div class="clearfix"></div>
				<div class="row"><?php echo ($nums>0)?endPaging("frm-search",$total_record):"";?></div>
			</form>
		</div>
	</div>
	<div style="text-align:center; bottom:0px;">
		<?php include($path."include/footer.php"); ?>
	</div>
</div>
</body>
</html>
<!-- Modal -->
<div class="modal fade" id="myModal"></div>
<!-- /.modal -->