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

$field="a.TCH_ID, a.PER_IDCARD, a.TCH_NEW_PER_ID, a.TCH_LAST_PT_ID, a.TCH_NEW_PER_ID, a.TCH_NEW_PT_ID, a.TCH_EFFECTIVE_DATE, a.ACTIVE_STATUS
";
	
$table=" PER_TYPECHANGE  a ";
$pk_id="a.TCH_ID";
$wh=" a.TCH_NEW_PER_ID = '".$PER_ID."' AND a.DELETE_FLAG = '0' {$filter} ";
$orderby="order by a.ACTIVE_STATUS DESC, a.TCH_EFFECTIVE_DATE DESC ";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

$arr_result = array("1" => "ผ่าน", "2" => "ไม่ผ่าน");
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
<script src="js/profile_typechange.js?<?php echo rand(); ?>"></script>
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
          <li class="active">ประวัติการเปลี่ยนสถานะบุคลากร</li>
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
		<input type="hidden" id="TCH_ID" name="TCH_ID" value="">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        <div class="row"> <?php echo @(ceil($total_record/$page_size) > 1) ? startPaging("frm-search",$total_record):""; ?> </div>
          
        <div class="row">
          <div class="col-xs-12 col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                  <tr class="bgHead">
                    <th width="5%" style="vertical-align:middle"><div align="center"><strong>ลำดับ</strong></div></th>
					<th width="15%" style="vertical-align:middle"><div align="center"><strong><?php echo $arr_txt['idcard']; ?></strong></div></th>
                    <th width="15%" style="vertical-align:middle"><div align="center"><strong>บุคลากร<br />ภายในสำนั้กงานฯ เดิม</strong></div></th>
                    <th width="15%" style="vertical-align:middle"><div align="center"><strong>ประเภทบุคลากร<br />ภายในสำนักงานฯ เดิม</strong></div></th>
                    <th width="15%" style="vertical-align:middle"><div align="center"><strong>บุคลากร<br />ภายในสำนั้กงานฯ ใหม่</strong></div></th>
                    <th width="15%" style="vertical-align:middle"><div align="center"><strong>ประเภทบุคลากร<br />ภายในสำนั้กงานฯ ใหม่</strong></div></th>
                    <th width="10%" style="vertical-align:middle"><div align="center"><strong>วันที่มีผล</strong></div></th>
                    <th width="10%" style="vertical-align:middle"><div align="center"><strong>สถานะ</strong></div></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
		   if($nums > 0){
				$i=1;
				while($rec = $db->db_fetch_array($query)){
					$last_per = $db->get_data_rec("select PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH, PREFIX_ID from PER_PROFILE where PER_ID = '".$rec['TCH_LAST_PER_ID']."' ");
					$new_per = $db->get_data_rec("select PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH, PREFIX_ID from PER_PROFILE where PER_ID = '".$rec['TCH_NEW_PER_ID']."' ");
				 ?>
                  <tr bgcolor="#FFFFFF">
                    <td align="center"><?php echo $i+$goto; ?></td>
					<td align="center"><?php echo get_idCard($rec["PER_IDCARD"]); ?></td>
					<td align="center"><?php echo Showname($last_per["PREFIX_ID"],$last_per["PER_FIRSTNAME_TH"],$last_per["PER_MIDNAME_TH"],$last_per["PER_LASTNAME_TH"]);?></td>
					<td align="center"><?php echo $arr_act_status[$rec["TCH_LAST_PT_ID"]]; ?></td>
                    <td align="center"><?php echo Showname($new_per["PREFIX_ID"],$new_per["PER_FIRSTNAME_TH"],$new_per["PER_MIDNAME_TH"],$new_per["PER_LASTNAME_TH"]);?></td>
                    <td align="center"><?php echo $arr_act_status[$rec["TCH_NEW_PT_ID"]]; ?></td>
                    <td align="center"><?php echo conv_date($rec["TCH_EFFECTIVE_DATE"],'short'); ?></td>
                    <td align="center"><?php echo $arr_act_status[$rec["ACTIVE_STATUS"]]; ?></td>
                  </tr>
                  <?php 				$i++;
                                        }
                                    }else{
                                        echo "<tr><td align=\"center\" colspan=\"8\">ไม่พบข้อมูล</td></tr>";
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