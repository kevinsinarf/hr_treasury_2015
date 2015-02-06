<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$filter = "";
if($s_name_th != "" ){
	$filter .= " and LEVEL_NAME_TH like '%".ctext($s_name_th)."%'";
}
if($s_name_en != "" ){
	$filter .= " and LEVEL_NAME_EN like '%".ctext($s_name_en)."%' ";
}
if($sSPT_ID != ""){
	$filter .= " and a.TYPE_ID = '".$sSPT_ID."' ";
}

if($sACTIVE_STATUS != ""){
	$filter .= " and a.ACTIVE_STATUS = '".$sACTIVE_STATUS."' ";
}

$field="   LEVEL_ID , LEVEL_NAME_TH  ,LEVEL_NAME_EN , POSTYPE_NAME_TH , TYPE_NAME_TH , a.ACTIVE_STATUS ";
$table=" SETUP_POS_LEVEL  a
INNER JOIN SETUP_POSITION_TYPE b ON a.POSTYPE_ID = b.POSTYPE_ID 
left JOIN SETUP_POS_TYPE c ON a.TYPE_ID = c.TYPE_ID";
$pk_id="LEVEL_ID";
$wh="1=1 and a.DELETE_FLAG='0' AND a.POSTYPE_ID = '1' {$filter} ";
$orderby="order by TYPE_NAME_TH asc, a.LEVEL_NAME_TH asc";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;
	
$sql = "select top $page_size ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh." $filter"));
	
$SQL_POS_TYPE ="SELECT TYPE_ID,TYPE_NAME_TH FROM SETUP_POS_TYPE WHERE POSTYPE_ID = '1' AND DELETE_FLAG = '0' ORDER BY TYPE_SEQ ASC";
$query_POS_TYPE = $db->query($SQL_POS_TYPE);
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
<script src="js/pos_level_disp.js?<?php echo rand(); ?>"></script>
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
        <input type="hidden" id="LEVEL_ID" name="LEVEL_ID"  value="<?php echo $LEVEL_ID; ?>">
        <div class="row">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['type_pos'];?> :</div>
            <div class="col-xs-12 col-sm-3">
            <select id="sSPT_ID" name="sSPT_ID" class="selectbox form-control" placeholder="--ทั้งหมด--">
                <option value=""></option>
                <?php while($rec = $db->db_fetch_array($query_POS_TYPE)){?>
                <option value="<?php echo $rec['TYPE_ID']?>" <?php echo ($sSPT_ID== $rec['TYPE_ID']?"selected":"");?>><?php echo text($rec['TYPE_NAME_TH'])?></option>
                <?php }?>
            </select>
            </div>
        </div>
        
       	<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ชื่อระดับภาษาไทย :</div>
			<div class="col-xs-12 col-sm-3"><input type="text" id="s_name_th" name="s_name_th" class="form-control" placeholder="ชื่อระดับภาษาไทย" value="<?php echo $s_name_th; ?>"></div>
			<div class="col-xs-12 col-sm-2"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ชื่อระดับภาษาอังกฤษ :</div>
            <div class="col-xs-12 col-sm-3"><input type="text" id="s_name_en" name="s_name_en" class="form-control" placeholder="ชื่อระดับภาษาอังกฤษ" value="<?php echo $s_name_en; ?>"></div>
		</div>
        
        <div class="row" style="text-align:center; margin-top:15px;">
          	<div class="col-xs-12"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
		</div>
        	
	    <div class="col-sm-12">
        	<a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();"><?php echo $img_save;?> เพิ่มข้อมูล</a> 
        </div>
        
		<div class="row"><?php echo ($nums > 0) ? startPaging("frm-search",$total_record):""; ?></div>
			<div class="col-xs-12 col-sm-12">
			  <div class="table-responsive">
				<table width="776" class="table table-bordered table-striped table-hover">
				  <thead>
					<tr class="bgHead">
					  <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
					  <th width="15%"><div align="center"><strong><?php echo $arr_txt['type_pos'];?></strong></div></th>
                      <th width="20%"><div align="center"><strong>ชื่อระดับภาษาไทย</strong></div></th>
					  <th width="20%"><div align="center"><strong>ชื่อระดับภาษาอังกฤษ</strong> </div></th>
					  <th width="10%"><div align="center"><strong>จัดการ</strong></div></th>
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
                              <td align="left"><?php echo  text($rec["LEVEL_NAME_TH"]); ?></td>
                              <td align="left"><?php echo text($rec["LEVEL_NAME_EN"]); ?></td>
                              <td align="center"><?php echo $edit.$delete; ?></td>
                            </tr>
                            <?php 
							$i++;
						}
					}else{
						echo "<tr><td align=\"center\" colspan=\"6\">ไม่พบข้อมูล</td></tr>";
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
  <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>