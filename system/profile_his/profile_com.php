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
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
      <li class="active">ประวัติการประเมินสมรรถนะ</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
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
        
        <div class="row">
          <div class="col-xs-12 col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                  <tr class="bgHead">
                    <th width="5%" rowspan="5"><div align="center"><strong>ลำดับ</strong></div></th>
                    <th width="10%" rowspan="2"><div align="center"><strong>รอบ/ปี</strong></div></th>
                    <th width="15%" rowspan="2"><div align="center"><strong>ตำแหน่ง</strong></div></th>
                    <th width="15%" rowspan="2"><div align="center"><strong>สำนัก</strong></div></th>
                    <th width="15%" rowspan="2"><div align="center"><strong>กลุ่มงาน</strong></div></th>
                    <th colspan="3"><div align="center"><strong>คะแนน</strong></div></th>
                  </tr>
                  <tr class="bgHead">
                    <th width="10%"><div align="center"><strong>สมรรถนะหลัก</strong></div></th>
                    <th width="10%"><div align="center"><strong>สมรรถนะสายงาน</strong></div></th>
                    <th width="10%"><div align="center"><strong>สมรรถนะการบริหาร</strong></div></th>
                  </tr>
                </thead>
                <tbody>
                <?php
				$field="b.ROUND_YEAR, b.ROUND_SEQUENCE, c.LINE_NAME_TH, d.ORG_NAME_TH AS ORG3, e.ORG_NAME_TH AS ORG4, a.RESULT_ASS_SCORE_1, a.RESULT_ASS_SCORE_2, a.RESULT_ASS_SCORE_3";
				$table="DEV_ASS_PER AS a LEFT JOIN 
						DEV_ASS_ROUND AS b ON a.ASS_ROUND_ID = b.ASS_ROUND_ID LEFT JOIN 
						SETUP_POS_LINE AS c ON a.SUP_LINE_ID = c.LINE_ID LEFT JOIN 
						SETUP_ORG AS d ON a.SUP_ORG_ID_3 = d.ORG_ID LEFT JOIN 
						SETUP_ORG AS e ON a.SUP_ORG_ID_4 = e.ORG_ID";
				$orderby=" ORDER BY a.ASS_PER_ID ASC";
				
				$sql = "SELECT ".$field." FROM ".$table." WHERE a.PER_ID='".$PER_ID."' AND (a.DELETE_FLAG='' OR a.DELETE_FLAG IS NULL)".$orderby; 
				$query = $db->query($sql);
				$nums = $db->db_num_rows($query);
				
				if ($nums > 0) {
					$i = 1;
					while($rec = $db->db_fetch_array($query)) {
						?>
                        <tr bgcolor="#FFFFFF">
                            <td align="center"><?php echo $i; ?>.</td>
                            <td align="center"><?php echo $rec['ROUND_SEQUENCE']."/".$rec['ROUND_YEAR']; ?></td>
                            <td align="center"><?php echo text($rec['LINE_NAME_TH']); ?></td>
                            <td align="center"><?php echo text($rec['ORG3']); ?></td>
                            <td align="center"><?php echo text($rec['ORG4']); ?></td>
                            <td align="center"><?php echo number_format($rec['RESULT_ASS_SCORE_1'],2); ?></td>
                            <td align="center"><?php echo number_format($rec['RESULT_ASS_SCORE_2'],2); ?></td>
                            <td align="center"><?php echo number_format($rec['RESULT_ASS_SCORE_3'],2); ?></td>
                        </tr>
                        <?php
						$i++;
					}                        
				} else {
					echo "<tr><td align=\"center\" colspan=\"11\">".$arr_txt['data_not_found']."</td></tr>";
				}
				?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>