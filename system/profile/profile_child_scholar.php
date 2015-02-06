<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
//page back
if($PT_ID=="2"){
	$page_back = "profile_his_empser.php";
	$POSTYPE_ID = '3';
}elseif($PT_ID=="3"){
	$page_back = "profile_his_emp.php";
	$POSTYPE_ID = '5';
}else{
	$page_back = "profile_his_disp.php";
	$POSTYPE_ID = '1';
}

$field="a.CHS_ID, a.PER_ID, a.CHS_SEQ, a.CHS_ACADEMIC_YEAR, b.FAMILY_PREFIX_ID, b.FAMILY_FIRSTNAME_TH, b.FAMILY_MIDNAME_TH, b.FAMILY_LASTNAME_TH, c.EL_NAME_TH, d.INS_NAME_TH, e.PROV_TH_NAME, f.COUNTRY_NAME_TH, a.ACTIVE_STATUS
";
	
$table=" PER_CHILD_SCHOLAR  a
		LEFT JOIN PER_FAMILY b ON a.FAMILY_ID = b.FAMILY_ID
		LEFT JOIN SETUP_EDU_LEVEL c ON a.EL_ID = c.EL_ID 
		LEFT JOIN SETUP_EDU_INSTITUTE d ON a.INS_ID = d.INS_ID 
		LEFT JOIN SETUP_PROV e ON a.PROV_ID = e.PROV_ID 
		LEFT JOIN SETUP_COUNTRY f ON a.COUNTRY_ID = f.COUNTRY_ID ";
$pk_id="a.CHS_ID";
$wh=" a.PER_ID = '".$PER_ID."' AND a.DELETE_FLAG = '0' {$filter} ";
$orderby="order by a.ACTIVE_STATUS DESC, a.CHS_SEQ ASC ";
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
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
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
<script src="js/profile_child_scholar.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div>
    <?php include($path."include/header.php");?>
  </div>
  <div>
    <?php include($path."include/menu.php");?>
  </div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active">ประวัติการรับทุนการศึกษาบุตร</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12">
    <?php include("tab_profile.php");?>
    <div class="grouptab">
      <?php include("tab_info.php");?>
      <div class="clearfix"></div>
      <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
		<input type="hidden" id="CHS_ID" name="CHS_ID" value="">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        <div class="row"> <?php echo @(ceil($total_record/$page_size) > 1) ? startPaging("frm-search",$total_record):""; ?> </div>
        
        <div class="row">
          <div class="col-xs-12 col-md-12"> <a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();"><?php echo $img_save;?> เพิ่มข้อมูล</a> </div>
        </div>  
        <div class="row">
          <div class="col-xs-12 col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                  <tr class="bgHead">
                    <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
					<th width="5%"><div align="center"><strong>ครั้งที่</strong></div></th>
                    <th width="16%"><div align="center"><strong>ชื่อ-สกุล บุตร</strong></div></th>
                    <th width="14%"><div align="center"><strong>ระดับการศึกษา</strong></div></th>
                    <th width="16%"><div align="center"><strong>สถาบันการศึกษา</strong></div></th>
                    <th width="10%"><div align="center"><strong>จังหวัด</strong></div></th>
                    <th width="10%"><div align="center"><strong>ประเทศ</strong></div></th>
                    <th width="8%"><div align="center"><strong>สถานะ</strong></div></th>
                    <th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                       if($nums > 0){
                            $i=1;
                            while($rec = $db->db_fetch_array($query)){
								$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["CHS_ID"]."');\">".$img_edit." แก้ไข</a> ";
                                $delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["CHS_ID"]."');\">".$img_del." ลบ</a> ";
				 ?>
                  <tr bgcolor="#FFFFFF">
                    <td align="center"><?php echo $i+$goto; ?>.</td>
					<td align="center"><?php echo text($rec["CHS_SEQ"]); ?></td>
					<td align="left" style="padding-left:10px"><?php echo Showname($rec["PCHILD_PREFIX_ID"],$rec["PCHILD_FIRSTNAME_TH"],$rec["PCHILD_MIDNAME_TH"],$rec["PCHILD_LASTNAME_TH"]); ?></td>
                    <td align="left" style="padding-left:10px"><?php echo text($rec["EL_NAME_TH"]); ?></td>
                    <td align="left" style="padding-left:10px"><?php echo text($rec["INS_NAME_TH"]); ?></td>
                    <td align="left" style="padding-left:10px"><?php echo text($rec["PROV_TH_NAME"]); ?></td>
                    <td align="left" style="padding-left:10px"><?php echo text($rec["COUNTRY_NAME_TH"]); ?></td>
                    <td align="center"><?php echo $arr_act_status[$rec["ACTIVE_STATUS"]]; ?></td>
                    <td align="center" nowrap><?php echo $edit.$delete; ?></td>
                  </tr>
                  <?php 				$i++;
                                        }
                                    }else{
                                        echo "<tr><td align=\"center\" colspan=\"9\">ไม่พบข้อมูล</td></tr>";
                            }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row"> <?php echo ($nums>0)?endPaging("frm-search",$total_record):""; ?> </div>
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>