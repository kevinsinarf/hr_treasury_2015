<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$filter = "";
if($s_name != ""){
	$filter .= " and (EM_NAME_TH like '%".ctext($s_name)."%' OR EM_NAME_EN like '%".ctext($s_name)."%') ";
}
if($s_status != ""){
	$filter .= " and ACTIVE_STATUS = '".ctext($s_status)."' ";
}

$field="EM_ID,EM_NAME_TH,EM_NAME_EN,ACTIVE_STATUS";
$table="SETUP_EDU_MAJOR";
$pk_id="EM_ID";
$wh="DELETE_FLAG='0' {$filter}";
$orderby="order by ACTIVE_STATUS desc, EM_ID ASC";
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
<script src="js/edu_major.js?<?php echo rand(); ?>"></script>
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
        <input type="hidden" id="EM_ID" name="EM_ID" value="">
		<div class="row">
			<div class="col-xs-12 col-sm-1" style="white-space:nowrap;"><?php echo $arr_data['edu_major'];?> :</div>
			<div class="col-xs-12 col-sm-3"><input type="text" id="s_name" name="s_name" class="form-control" placeholder="<?php echo $arr_data['edu_major'];?>" value="<?php echo $s_name; ?>"></div>
			<div class="col-xs-12 col-sm-2 col-sm-offset-1 " style="white-space:nowrap;"><?php echo $arr_txt['active'];?> :  </div>
			<div class="col-xs-12 col-sm-2">
				<select id="s_status" name="s_status" class="selectbox form-control" placeholder="--ทั้งหมด--">
					<option value=""></option>
					<?php foreach($arr_act_status as $key => $val){?>
					<option value="<?php echo $key?>" <?php echo ($s_status==$key && $s_status!=''?"selected":"");?>><?php echo $val?></option>
					<?php }?>
				</select>
			</div>
			<div class="col-xs-12 col-md-3"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
        </div>
		<?php if(chkPermission($menu_sub_id, 'add')=='1'){?>
		<div class="row">  
			<div class="col-xs-12 col-sm-1"><a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();"><?php echo $img_save;?> เพิ่มข้อมูล</a></div>
		</div>
		<?php }?>
        <div class="row"><?php echo ($nums>0) ? startPaging("frm-search",$total_record):""; ?></div>
        <div class="col-xs-12 col-sm-12">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-condensed">
              <thead>
                <tr class="bgHead">
                  <th width="10%"><div align="center"><strong>ลำดับ</strong></div></th>
                  <th width="30%"><div align="center"><strong><?php echo $arr_data['edu_major']?> (<?php echo $arr_txt['th'];?>)</strong> </div></th>
                  <th width="30%"><div align="center"><strong><?php echo $arr_data['edu_major']?> (<?php echo $arr_txt['en'];?>)</strong> </div></th>
                  <th width="15%"><div align="center"><strong><?php echo $arr_txt['active']?></strong></div></th>
                  <th width="15%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                </tr>
				</thead>
				<tbody>
				<?php
				if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($query)){
						//$rec = array_change_key_case($rec,CASE_LOWER);
						
						if(chkPermission($menu_sub_id, 'edit')=='1'){
							$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["EM_ID"]."');\">".$img_edit." แก้ไข</a> ";
						}
						if(chkPermission($menu_sub_id, 'delete')=='1'){
							$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["EM_ID"]."');\">".$img_del." ลบ</a> ";
						}
				?>
                <tr bgcolor="#FFFFFF">
                  <td align="center"><?php echo $i+$goto; ?>.</td>
                  <td align="left"><?php echo text($rec["EM_NAME_TH"]); ?></td>
                  <td align="left"><?php echo text($rec["EM_NAME_EN"]); ?></td>
                  <td align="center"><?php echo $arr_act_status[$rec["ACTIVE_STATUS"]];?></td>
                  <td align="center"><?php echo $edit.$delete; ?></td>
                </tr>
                <?php 
                        $i++;
					}
				}else{
					echo "<tr><td align=\"center\" colspan=\"5\">ไม่พบข้อมูล</td></tr>";
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
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>