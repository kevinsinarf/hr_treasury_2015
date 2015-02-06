<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$filter = "";
if($S_TYPE_ID != ''){
	$filter = " AND A.TYPE_ID = '".$S_TYPE_ID."' ";
}
if(trim($s_name_th) != ""){
	$filter .= " and A.LEVEL_NAME_TH like '%".ctext(trim($s_name_th))."%'  ";
}
if(trim($s_name_en) != ""){
	$filter .= " and A.LEVEL_NAME_EN like '%".ctext(trim($s_name_en))."%' ";
}


$field="* ";
$table="SETUP_POS_LEVEL A LEFT JOIN SETUP_POS_TYPE B ON A.TYPE_ID = B.TYPE_ID ";
$pk_id="A.LEVEL_ID";
$wh="A.ACTIVE_STATUS = 1 AND A.DELETE_FLAG='0' and A.POSTYPE_ID = '3' {$filter}";
$orderby="order by  B.TYPE_SEQ ASC , A.LEVEL_SEQ ASC ";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH as TYPE_NAME", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '3' ","TYPE_SEQ");
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
<script src="js/setup_pos_level.js?<?php echo rand(); ?>"></script>
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
        <input type="hidden" id="LEVEL_ID" name="LEVEL_ID" value="">
        <div class="row">
            <div class="col-xs-12 col-md-2">ประเภทพนักงานราชการ : </div>
			<div class="col-xs-12 col-md-3">
				<?php echo GetHtmlSelect('S_TYPE_ID','S_TYPE_ID',$arr_pos_type,'--ทั้งหมด--',$S_TYPE_ID,'','','1');?>
            </div>
         </div>
		<div class="row">
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อประเภทกลุ่มงานภาษาไทย :</div>
			<div class="col-xs-12 col-md-3">
            	<input type="text" id="s_name_th" name="s_name_th" class="form-control" placeholder="ชื่อประเภทกลุ่มงานภาษาไทย" value="<?php echo $s_name_th; ?>">
            </div>
            <div class="col-xs-12 col-md-2"></div>
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อประเภทกลุ่มงานภาษาอังกฤษ :</div>
			<div class="col-xs-12 col-md-3">
            	<input type="text" id="s_name_en" name="s_name_en" class="form-control" placeholder="ชื่อประเภทกลุ่มงานภาษาอังกฤษ" value="<?php echo $s_name_en; ?>">
            </div>
        </div>
        <div class="row" style="text-align:center; margin-top:15px;">
        	<div class="col-xs-12 col-md-12"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
        </div>
          <div class="col-xs-12 col-sm-12">
              <a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();"><?php echo $img_save;?> เพิ่มข้อมูล</a>
          </div>
        <div class="row"><?php echo ($nums>0) ? startPaging("frm-search",$total_record):""; ?></div>
        <div class="col-xs-12 col-sm-12">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-condensed">
              <thead>
                <tr class="bgHead">
                  <th width="7%"><div align="center"><strong>ลำดับ</strong></div></th>
                  <th width="15%"><div align="center"><strong>ประเภทพนักงานราชการ</strong></div></th>
                  <th width="30%"><div align="center"><strong>ชื่อประเภทกลุ่มงานภาษาไทย</strong></div></th>
                  <th width="30%"><div align="center"><strong>ชื่อประเภทกลุ่มงานภาษาอังกฤษ</strong></div></th>
                  <th width="12%"><div align="center"><strong>จัดการ</strong></div></th>
                </tr>
				</thead>
				<tbody>
				<?php
				if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($query)){
						
							$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["LEVEL_ID"]."');\">".$img_edit." แก้ไข</a> ";
							$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["LEVEL_ID"]."');\">".$img_del." ลบ</a> ";
				?>
                <tr bgcolor="#FFFFFF">
                  <td align="center"><?php echo $i+$goto; ?>.</td>
                  <td align="left"><?php echo text($rec["TYPE_NAME_TH"]); ?></td>
                  <td align="left"><?php echo text($rec["LEVEL_NAME_TH"]); ?></td>
                  <td align="left"><?php echo text($rec["LEVEL_NAME_EN"]); ?></td>
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