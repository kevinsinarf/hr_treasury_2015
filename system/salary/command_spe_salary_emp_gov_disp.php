<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$filter = "";
if($YEAR_BDG != ""){
	$filter .= " and YEAR_BDG = '".ctext($YEAR_BDG)."' ";
}
if($ROUND != ""){
	$filter .= " and ROUND = '".ctext($ROUND)."' ";
}

$field="SAL_COM_ID,YEAR_BDG,ROUND,COM_NO,COM_TITLE,COM_SDATE,COM_DATE";
$table="SAL_COMMAND ";
$pk_id="SAL_COM_ID";
$wh="DELETE_FLAG ='0' AND POSTYPE_ID ='5' AND MOVEMENT_ID = 27 {$filter} ";
$orderby="order by SAL_COM_ID asc";
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
<script src="js/command_spe_salary_emp_gov_disp.js?<?php echo rand(); ?>"></script>
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
        <input type="hidden" id="SAL_COM_ID" name="SAL_COM_ID" value="">
        <input type="hidden" id"MOVEMENT_ID" name="MOVEMENT_ID" value="21">
		<div class="row">
			<div class="col-xs-12 col-sm-2" >ปีงบประมาณ : <span style="color:red;">*</span></div>
			<div class="col-xs-12 col-sm-2">
                <select name="YEAR_BDG" id="YEAR_BDG" class="selectbox form-control" placeholder="ปีงบประมาณ">
						<?php 
                        for($y=$YEAR_BUDGET;$y>=$YEAR_BUDGET_PREV;$y--){
                            ?>
                            <option value="<?php echo $y;?>" <?php if($y == $YEAR_BDG){ echo "selected";} ?>><?php echo $y;?></option>
                            <?php	
                        }
                        ?>
                   </select>			
			</div>
			<div class="col-xs-12 col-sm-1" ></div>
			<div class="col-xs-12 col-sm-2" >รอบ : <span style="color:red;">*</span></div>
			<div class="col-xs-12 col-sm-3">
				<select name="ROUND" id="ROUND" class="selectbox form-control" placeholder="รอบ">
                    <option value=""></option>
					<?php 
                    foreach($arr_emp_gov_round as $index => $val){
                        ?>
                       <option value="<?php echo $index;?>" <?php if($index == $ROUND){ echo "selected"; }?>><?php echo $val;?></option>
                        <?php
                    }
                    ?>
                </select>
			</div>
			<div class="col-xs-12 col-sm-2">
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
				<table class="table table-bordered table-striped table-hover table-condensed">
				  <thead>
					<tr class="bgHead">
					  <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
					  <th width="9%"><div align="center"><strong>ปีงบประมาณ</strong> </div></th>
					  <th width="5%"><div align="center"><strong>รอบ</strong> </div></th>
					  <th width="10%"><div align="center"><strong>เลขที่คำสั่ง</strong></div></th>
					  <th width="30%"><div align="center"><strong>เรื่อง</strong> </div></th>
					  <th width="15%"><div align="center"><strong>ลงวันที่</strong> </div></th>
					  <th width="15%"><div align="center"><strong>วันที่มีผล</strong></div></th>
					  <th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
					</tr>
				  </thead>
				  <tbody>
					<?php
									if($nums > 0){
										$i=1;
										while($rec = $db->db_fetch_array($query)){
											//$rec = array_change_key_case($rec,CASE_LOWER);
											$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["SAL_COM_ID"]."');\">".$img_edit." แก้ไข</a> ";
											$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["SAL_COM_ID"]."');\">".$img_del." ลบ</a> ";
									?>
					<tr bgcolor="#FFFFFF">
					  <td align="center"><?php echo $i+$goto; ?>.</td>
					  <td align="center"><?php echo text($rec["YEAR_BDG"]); ?></td>
					  <td align="center"><?php echo text($rec["ROUND"]); ?></td>
                      <td align="center"><?php echo text($rec["COM_NO"]); ?></td>
                      <td align="left"><?php echo text($rec["COM_TITLE"]); ?></td>
                      <td align="center"><?php echo conv_date($rec["COM_DATE"],'short'); ?></td>
					  <td align="center"><?php echo conv_date($rec["COM_SDATE"],'short'); ?></td>
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