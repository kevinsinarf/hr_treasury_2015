<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$filter = "";

if($S_POSTYPE_ID != ""){
	$filter .= " and POSTYPE_ID = '".$S_POSTYPE_ID."' ";
}

$POSTYPE_ID = 1;
$field=" *";
$table="SETUP_MOVEMENT";
$pk_id=" MOVEMENT_ID";
$wh="1=1 AND DELETE_FLAG = 0 {$filter}";
$orderby="order by  POSTYPE_ID , MOVEMENT_NAME_TH  ASC";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

//ประเภทบุคลากร
$arr_pos=GetSqlSelectArray("POSTYPE_ID", "POSTYPE_NAME_TH", "SETUP_POSITION_TYPE", " DELETE_FLAG='0'", "POSTYPE_NAME_TH");

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
<script src="js/data_title_order_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
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
        <input type="hidden" id="MOVEMENT_ID" name="MOVEMENT_ID" value="">
            
        <div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">สำหรับประเภทบุคลากร :</div>
			<div class="col-xs-12 col-sm-3">
    			<?php echo GetHtmlSelect('S_POSTYPE_ID','S_POSTYPE_ID',$arr_pos,'สำหรับประเภทบุคลากร',$S_POSTYPE_ID,'','','1','','1');?>
            </div>
			
        </div>
        <div class="row" style="text-align:center;">
        	<button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button>
        </div>
        <div class="row">
			<div class="col-sm-12"><a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();"><?php echo $img_save;?> เพิ่มข้อมูล</a> </div>
        </div>
        
        <div class="row"><?php echo ($nums>0) ? startPaging("frm-search",$total_record):""; ?></div>
        <div class="col-xs-12 col-sm-12">
          <div class="table-responsive">
            <table width="397" class="table table-bordered table-striped table-hover table-condensed">
              <thead>
                <tr class="bgHead">
                  <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                   <th width="5%"><div align="center"><strong>รหัส</strong> </div></th>
                  <th width="8%"><div align="center"><strong>ประเภทบุคลากร</strong> </div></th>
                  <th width="25%"><div align="center"><strong>ชื่อประเภทความเคลื่อนไหวภาษาไทย</strong> </div></th>
                  <th width="15%"><div align="center"><strong>ชื่อประเภทความเคลื่อนไหวภาษาอังกฤษ</strong> </div></th>
                  <th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                </tr>
				</thead>
				<tbody>
				<?php
				if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($query)){
						$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["MOVEMENT_ID"]."');\">".$img_edit." แก้ไข</a> ";
						$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["MOVEMENT_ID"]."');\">".$img_del." ลบ</a> ";
						?>
						<tr bgcolor="#FFFFFF">
						  <td align="center"><?php echo $i+$goto; ?>.</td>
                          <td align="center"><?php echo text($rec['MOVEMENT_CODE']); ?></td>
                           <td align="left"><?php echo text($arr_pos[$rec['POSTYPE_ID']]); ?></td>
						  <td align="left"><?php echo text($rec['MOVEMENT_NAME_TH']);   ?></td>
						  <td align="left"><?php echo text($rec['MOVEMENT_NAME_EN']);    ?></td>
						 
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
        <div class="row"><?php echo ($nums>0)?endPaging("frm-search",$total_record):"";?></div>
      </form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>