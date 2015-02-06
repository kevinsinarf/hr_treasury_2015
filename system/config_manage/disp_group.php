<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$filter = "";
if($se_group_name != ""){
	$filter .= " and group_name like '%".ctext($se_group_name)."%' ";
}
if($s_status != ""){
	$filter .= " and ACTIVE_STATUS = '".ctext($s_status)."' ";
}
$field="*";
$table="aut_group a";
$pk_id="a.user_group_id";
$wh="1=1 and a.DELETE_FLAG='0' {$filter}";
$orderby="order by a.group_name";
$notin=$wh." and ".$pk_id." not in (select top {$goto} ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

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
<script src="js/disp_group.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div id="content" class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
    <div><?php include($path."include/menu.php"); ?></div>
    <div style="height:45em;">
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active"><?php echo showMenu($menu_sub_id);?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12">
        <div class="groupdata">
            <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            	<input name="proc" type="hidden" id="proc" value="<?php echo $proc; ?>">
                <input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
                <input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
            	<input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
                <input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
                <input name="user_group_id" type="hidden" id="user_group_id">
				<div class="row">
					<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ชื่อกลุ่ม :</div>
					<div class="col-xs-12 col-sm-3"><input type="text" id="se_group_name" name="se_group_name" class="form-control" placeholder="ชื่อกลุ่ม" value="<?php echo $se_group_name; ?>"></div>
					<div class="col-xs-12 col-sm-2 col-sm-offset-1 " style="white-space:nowrap;"><?php echo $arr_txt['active'];?> :  </div>
					<div class="col-xs-12 col-sm-2"><?php echo GetHtmlSelect('s_status','s_status',$arr_act_status,'ทั้งหมด',$s_status,'','','1','','2');?></div>
					<div class="col-xs-12 col-md-1"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
				</div>
				<?php if(chkPermission($menu_sub_id, 'add', '2')=='1'){?>
				<div class="row">  
					<div class="col-xs-12 col-sm-1"><a href="javascript:void(0);" class="btn btn-default" onClick="addData();"><?php echo $img_save;?> เพิ่มข้อมูล</a></div>
				</div>
				<?php }?>
                <div class="row"><?php echo ($nums > 0) ? startPaging("frm-search",$total_record):""; ?></div>
                <div class="col-xs-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bgHead">
                                    <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                                    <th width="55%"><div align="center"><strong>ชื่อกลุ่ม</strong></div></th>
                                    <th width="15%"><div align="center"><strong>สถานะ</strong></div></th>
                                    <th width="20%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
								if($nums > 0){
									$i=1;
                                    while($rec = $db->db_fetch_array($query)){
										$rec = array_change_key_case($rec,CASE_LOWER);
										
										$menu_manage = "<a class=\"btn btn-default btn-xs\" href=\"javascript:void(0);\" onClick=\"menuData('".$rec["user_group_id"]."');\"><span class=\"glyphicon glyphicon-list-alt\"></span> เมนูกลุ่มสิทธิ์</a> ";
										if(chkPermission($menu_sub_id, 'edit', '2')=='1'){
											$edit = "<a class=\"btn btn-default btn-xs\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["user_group_id"]."');\">".$img_edit." แก้ไข</a> ";
										}
										if(chkPermission($menu_sub_id, 'delete', '2')=='1'){
											$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["user_group_id"]."');\">".$img_del." ลบ</button> ";
										}
                                ?>
                                <tr>
                                    <td align="center" bgcolor="#FFFFFF" ><?php echo $i+$goto; ?>.</td>
                                    <td bgcolor="#FFFFFF"><?php echo text($rec["group_name"]); ?></td>
                                    <td bgcolor="#FFFFFF" align="center"><?php echo $arr_act_status[$rec["active_status"]];?></td>
                                    <td align="center" bgcolor="#FFFFFF" ><?php echo $menu_manage.$edit.$delete; ?></td>
                                </tr>
                                <?php 
									$i++;
                                    }
								}else{
									echo "<tr><td align=\"center\" colspan=\"4\">ไม่พบข้อมูล</td></tr>";
								}
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row"><?php echo ($nums>0)?endPaging("frm-search",$total_record):"";?></div>
			</form>
        </div>
    </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>