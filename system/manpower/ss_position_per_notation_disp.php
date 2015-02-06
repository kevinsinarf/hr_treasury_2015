<?php
session_start();
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$sub_menu = "";

$filter = "";
$field=" * ";
$table="SETUP_POSITION_REMARK";

$pk_id="REMARK_ID";
$wh = " ACTIVE_STATUS='1' AND DELETE_FLAG='0' {$filter} ";
$orderby=" ORDER BY REMARK_ID  ASC";
$notin=$wh;

$sql = "select ".$field." from ".$table." where ".$notin;
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
<script src="js/ss_position_per_notation_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
    <div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li class="active"><?php echo showMenu($menu_sub_id); ?></li>
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
				<input name="REMARK_ID" type="hidden" id="REMARK_ID" value="<?php echo $REMARK_ID; ?>">
                
				<div class="row"><div class="col-sm-12"> <a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();"><?php echo $img_save;?> เพิ่มข้อมูล</a> </div></div>
				<div class="row"><?php echo ($nums > 0) ? startPaging("frm-search",$total_record):""; ?></div>
				<div class="col-xs-12 col-sm-12">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<tr class="bgHead">
									<th nowrap width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
									<th nowrap width="70%"><div align="center">หมายเหตุของตำแหน่ง</div></th>
									<th nowrap width="10%"><div align="center"><strong>จัดการ</strong></div></th>
								</tr>
							</thead>
							<tbody>
							<?php
							if($nums > 0){
								$i=1;
								while($rec = $db->db_fetch_array($query)){
									$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["REMARK_ID"]."');\">".$img_edit." แก้ไข</a> ";
									$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["REMARK_ID"]."');\">".$img_del." ลบ</a> ";
									?>
									<tr>
										<td align="center" bgcolor="#FFFFFF" ><?php echo $i+$goto; ?>.</td>
										<td bgcolor="#FFFFFF" align="left"><?php echo text($rec["REMARK_NAME"]); ?></td>
                                        <td bgcolor="#FFFFFF" align="center"><?php echo $edit." ".$delete; ?></td>
                                    </tr>
                           		 	<?php 
									$i++;
								}
							}else{
								
								echo "<tr><td align=\"center\" colspan=\"3\">ไม่พบข้อมูล</td></tr>";
							}
							?>
							</tbody>
						</table>
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
<!-- Modal -->
<div class="modal fade" id="myModal"></div>
<!-- /.modal -->