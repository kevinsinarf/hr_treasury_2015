<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$filter = "";
if(trim($s_comset_year) != ""){
	$filter .= " AND a.SKILLSET_YEAR = '".$s_comset_year."' ";
}
if(trim($s_skilltitle_id) != ""){
	$filter .= " AND a.SKILLTITLE_ID = '".$s_skilltitle_id."' ";
}

$field="a.SKILLSET_ID,a.SKILLSET_YEAR,a.SKILLSET_EXPECT,b.SKILLTITLE_NAME_TH,c.TYPE_NAME_TH,d.LEVEL_NAME_TH,e.LINE_NAME_TH ";
$table="SKILL_SET a
left JOIN SKILL_TITLE b ON a.SKILLTITLE_ID = b.SKILLTITLE_ID
left JOIN SETUP_POS_TYPE c ON a.TYPE_ID = c.TYPE_ID
left JOIN SETUP_POS_LEVEL d ON a.LEVEL_ID = d.LEVEL_ID
left JOIN SETUP_POS_LINE e ON a.LINE_ID = e.LINE_ID";
$pk_id="a.SKILLSET_ID";
$wh="a.DELETE_FLAG='0' AND SKILL_SET_TYPE = 2 {$filter}";
$orderby="order by a.SKILLSET_YEAR DESC, b.SKILLTITLE_NAME_TH ASC";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

//หัวข้อทักษะ
$query_skill = $db->query("SELECT * FROM SKILL_TITLE WHERE ACTIVE_STATUS = 1 ORDER BY SKILLTITLE_NAME_TH ASC");

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
<script src="js/knowledge_year.js?<?php echo rand(); ?>"></script>
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
        <input type="hidden" id="SKILLSET_ID" name="SKILLSET_ID" value="">
		<div class="row">
                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ปีที่ใช้หัวความรู้ :</div>
                    <div class="col-xs-12 col-sm-3">
                      <input type="text" id="s_comset_year" name="s_comset_year" class="form-control number" placeholder="ปีที่ใช้สมรรถนะ" value="<?php echo $s_comset_year; ?>">
                    </div>
                    
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ชื่อหัวข้อความรู้จำเป็นในงาน :</div>
                    <div class="col-xs-12 col-sm-3">
                     <select id="s_skilltitle_id" name="s_skilltitle_id" class="selectbox form-control" placeholder="ชื่อหัวข้อความรู้จำเป็นในงาน">
                      <option value=""></option>
                      <?php while($rec_skill = $db->db_fetch_array($query_skill)){ ?>
                                
                          <option value="<?php echo $rec_skill['SKILLTITLE_ID']; ?>"<?php echo ($rec_skill['SKILLTITLE_ID'] == $s_skilltitle_id ? "selected" : ""); ?>><?php echo text($rec_skill['SKILLTITLE_NAME_TH']); ?></option>
                      <?php } ?>
                    </select>	
                    </div>
			<div class="col-xs-12 col-md-2"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
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
                  <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                    <th width="8%" ><div align="center">ปีที่ใช้หัวข้อความรู้</div></th>
                    <th width="20%" ><div align="center"><strong>ชื่อหัวข้อความรู้จำเป็นในงาน</strong></div></th>
                    <th width="8%" ><div align="center"><strong>ค่าความคาดหวัง</strong></div></th>
                    <th width="10%" ><div align="center"><strong>ประเภทตำแหน่ง</strong></div></th>
                    <th width="10%" ><div align="center"><strong>ระดับตำแหน่ง</strong></div></th>
                    <th width="10%" ><div align="center"><strong>ตำแหน่งในสายงาน</strong></div></th>
                    <th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                </tr>
				</thead>
				<tbody>
				<?php
				if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($query)){
						//$rec = array_change_key_case($rec,CASE_LOWER);
						
						if(chkPermission($menu_sub_id, 'edit')=='1'){
							$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["SKILLSET_ID"]."');\">".$img_edit." แก้ไข</a> ";
						}
						if(chkPermission($menu_sub_id, 'delete')=='1'){
							$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["SKILLSET_ID"]."');\">".$img_del." ลบ</a> ";
						}
				?>
                <tr bgcolor="#FFFFFF">
                  <td align="center"><?php echo $i+$goto; ?>.</td>
                  <td align="center"><?php echo text($rec["SKILLSET_YEAR"]); ?></td>
                  <td align="left"><?php echo text($rec["SKILLTITLE_NAME_TH"]); ?></td>
				  <td align="center"><?php echo text($rec["SKILLSET_EXPECT"]); ?></td>
                  <td align="left"><?php echo text($rec["TYPE_NAME_TH"]); ?></td>
				  <td align="left"><?php echo text($rec["LEVEL_NAME_TH"]); ?></td>
                  <td align="left"><?php echo text($rec["LINE_NAME_TH"]); ?></td>
                  <td align="center"><?php echo $edit.$delete; ?></td>
                </tr>
                <?php 
                        $i++;
					}
				}else{
					echo "<tr><td align=\"center\" colspan=\"8\">ไม่พบข้อมูล</td></tr>";
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