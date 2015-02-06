<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$filter = "";
if($sCOMPEN_CODE != ""){
	$filter .= " and A.COMPEN_CODE LIKE '%".$sCOMPEN_CODE."%' ";
}
if($sCOMPEN_TITLE != ""){
	$filter .= " and A.COMPEN_TITLE LIKE '%".ctext($sCOMPEN_TITLE)."%' ";
}
if($sLEVEL_ID != ""){
	$filter .= " and A.LEVEL_ID = '".$sLEVEL_ID."' ";
}
if($sLINE_ID != ""){
	$filter .= " and A.LINE_ID = '".$sLINE_ID."' ";
}
if($sACTIVE_STATUS != ""){
	$filter .= " and A.ACTIVE_STATUS = '".$sACTIVE_STATUS."' ";
}


$field=" A.COMPEN_ID , A.COMPEN_CODE , A.COMPEN_TITLE , B.LEVEL_NAME_TH AS LEVEL_NAME , C.LINE_NAME_TH AS LINE_NAME , A.ACTIVE_STATUS ";
$table=" SETUP_POS_COMPENSATION A 
LEFT JOIN SETUP_POS_LEVEL B ON A.LEVEL_ID = B.LEVEL_ID
LEFT JOIN SETUP_POS_LINE C ON A.LINE_ID = C.LINE_ID
";
$pk_id="COMPEN_ID";
$wh="1=1 and a.ACTIVE_STATUS='1' and a.DELETE_FLAG='0' {$filter} ";
$orderby="order by A.ACTIVE_STATUS desc, A.COMPEN_ID desc";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top $page_size ".$field." from ".$table." where ".$pk_id." not in (select top $goto ".$pk_id." from ".$table.") $filter ";
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where 1=1 $filter"));

$SQL_POS_LEVEL ="SELECT LEVEL_ID , LEVEL_NAME_TH as LEVEL_NAME  FROM SETUP_POS_LEVEL WHERE ACTIVE_STATUS='1' ";
$query_POS_LEVEL = $db->query($SQL_POS_LEVEL);

$SQL_POS_LINE ="SELECT LINE_ID , LINE_NAME_TH as LINE_NAME  FROM SETUP_POS_LINE WHERE ACTIVE_STATUS='1' ";
$query_POS_LINE = $db->query($SQL_POS_LINE);

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
<script src="js/pos_compensation_disp.js?<?php echo rand(); ?>"></script>
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
  <div class="col-xs-12 col-sm-12">
    <div class="groupdata">
      <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="COMPEN_ID"name="COMPEN_ID" value="<?php echo $COMPEN_ID; ?>">
		<div class="row">
			<div class="col-xs-12 col-sm-2">รหัสค่าตอบแทน :</div>
			<div class="col-xs-12 col-sm-3"><input name="sCOMPEN_CODE" type="text" id="sCOMPEN_CODE" class="form-control"
					placeholder="รหัสค่าตอบแทน" value="<?php echo $sCOMPEN_CODE; ?>">
			</div>
			<div class="col-xs-12 col-sm-2 col-sm-offset-1">หัวข้อค่าตอบแทน :</div>
			<div class="col-xs-12 col-sm-3"><input name="sCOMPEN_TITLE" type="text" id="sCOMPEN_TITLE" class="form-control"
					placeholder="หัวข้อค่าตอบแทน" value="<?php echo $sCOMPEN_TITLE; ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-2"><?php echo $arr_txt['level_pos'];?> :</div>
			<div class="col-xs-12 col-sm-3">
				<select name="sLEVEL_ID" class="selectbox form-control" id="sLEVEL_ID"placeholder="--ทั้งหมด--">
					<option value=""></option>
							<?php 
									while($recL = $db->db_fetch_array($query_POS_LEVEL)){
							$sel = ($recL["LEVEL_ID"] == $sLEVEL_ID) ? "selected":"";
							?>
					<option value="<?php echo $recL["LEVEL_ID"]; ?>" <?php echo $sel; ?>><?php echo text($recL["LEVEL_NAME"]); ?></option>
							<?php
								}
							?>
				</select>
			</div>
			<div class="col-xs-12 col-sm-2 col-sm-offset-1"><?php echo $arr_txt['pos_in'];?> :</div>
			<div class="col-xs-12 col-sm-3">
				<select name="sLINE_ID" class="selectbox form-control" id="sLINE_ID"placeholder="--ทั้งหมด--">
					<option value=""></option>
							<?php 
									while($recL = $db->db_fetch_array($query_POS_LINE)){
							$sel = ($recL["LINE_ID"] == $sLINE_ID) ? "selected":"";
							?>
					<option value="<?php echo $recL["LINE_ID"]; ?>" <?php echo $sel; ?>><?php echo text($recL["LINE_NAME"]); ?></option>
							<?php
								}
							?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-2"><?php echo $arr_txt['active'];?> :</div>
			<div class="col-xs-12 col-sm-3">
				<select id="sACTIVE_STATUS" name="sACTIVE_STATUS" class="selectbox form-control"placeholder="--ทั้งหมด--">
					<option value=""></option>
							<?php foreach($arr_act_status as $key => $val){?>
					<option value="<?php echo $key?>" <?php echo ($sACTIVE_STATUS==$key && $sACTIVE_STATUS!=''?"selected":"");?>><?php echo ($val)?></option>
							<?php 
								}
							?>
				</select>
			</div>
			<div class="col-xs-12 col-sm-4 col-sm-offset-1">
				<button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12"> <a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();"><?php echo $img_save;?> เพิ่มข้อมูล</a> </div>
		</div>
        <div class="row"><?php echo ($nums > 0) ? startPaging("frm-search",$total_record):""; ?></div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12">
          <div class="table-responsive">
            <table width="776" class="table table-bordered table-striped table-hover">
              <thead>
                <tr class="bgHead">
                  <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                  <th width="17%"><div align="center">รหัสค่าตอบแทน</div></th>
                  <th width="20%"><div align="center">หัวข้อค่าตอบแทน</div></th>
                  <th width="19%"><div align="center"><?php echo $arr_txt['level_pos'];?></div></th>
                  <th width="17%"><div align="center"><?php echo $arr_txt['pos_in'];?></div></th>
                  <th width="10%"><div align="center"><strong><?php echo $arr_txt['active'];?></strong></div></th>
                  <th width="15%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                </tr>
              </thead>
              <tbody>
                <?php
				if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($query)){
					   // $rec = array_change_key_case($rec,CASE_LOWER);
						$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["COMPEN_ID"]."');\">".$img_edit." แก้ไข</a> ";
						$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["COMPEN_ID"]."');\">".$img_del." ลบ</a> ";
						
						$status = ($rec["ACTIVE_STATUS"] == "1") ? "ใช้งาน":"ไม่ใช้งาน";
				?>
                <tr bgcolor="#FFFFFF">
                  <td align="center"><?php echo $i+$goto; ?></td>
                  <td align="left"><?php echo text($rec["COMPEN_CODE"]); ?></td>
                  <td align="left"><?php echo text($rec["COMPEN_TITLE"]); ?></td>
                  <td align="left"><?php echo text($rec["LEVEL_NAME"]); ?></td>
                  <td align="left"><?php echo text($rec["LINE_NAME"]); ?></td>
                  <td align="center"><?php echo ($arr_act_status[$rec["ACTIVE_STATUS"]]);?></td>
                  <td align="center"><?php echo $edit.$delete; ?></td>
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
        <div class="row"><?php echo ($nums > 0) ? endPaging("frm-search",$total_record):""; ?></div>
      </form>
    </div>
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