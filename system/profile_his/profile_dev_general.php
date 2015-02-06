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
          <li class="active">ประวัติการศึกษาดูงาน/ฝึกอบรม/สัมมนา</li>
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
        <div class="row"> <?php echo @(ceil($total_record/$page_size) > 1) ? startPaging("frm-search",$total_record):""; ?> </div>
        
        <div class="row">
          <div class="col-xs-12 col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bgHead">
                      <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                      <th><div align="center"><strong>โครงการ</strong></div></th>
                      <th width="30%"><div align="center"><strong>หลักสุตร/กิจกรรม</strong></div></th>
                      <th width="15%"><div align="center"><strong>วันที่</strong></div></th>
                      <th width="10%"><div align="center"><strong>ระยะเวลา</strong></div></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                //ฝึกอบรม/จริยธรรม/ดูงาน
                $i=1;
                $sql_his="SELECT	b.GEN_SDATE,
                                    b.GEN_EDATE,
                                    b.NUM_YEAR,
                                    b.NUM_MONTH,
                                    b.NUM_DAY,
                                    b.ADDRESS_NAME,
                                    d.PROJECT_NAME_TH,
                                    a.COURSE_NAME_TH
                            FROM	DEV_COURSE AS a INNER JOIN 
                                    DEV_GEN AS b ON a.COURSE_ID = b.COURSE_ID INNER JOIN 
                                    DEV_USER_REGIS AS c ON b.GEN_ID = c.GEN_ID INNER JOIN 
                                    DEV_PROJECT AS d ON d.PROJECT_ID = a.PROJECT_ID
                            WHERE	c.TRANSFER_STATUS=1 AND c.PER_ID = '".$PER_ID."' ";
                $exc_his=$db->query($sql_his);
                while($row_his=$db->db_fetch_array($exc_his)){
                ?>
                  <tr>
                    <td align="center"><?php echo $i; ?>.</td>
                    <td><?php echo text($row_his['PROJECT_NAME_TH']); ?></td>
                    <td><?php echo text($row_his['COURSE_NAME_TH']); ?></td>
                    <td align="center"><?php echo conv_date($row_his['GEN_SDATE'])." - ".conv_date($row_his['GEN_EDATE']); ?></td>
                    <td align="center"><?php 
                    echo ($row_his['NUM_YEAR']>0?$row_his['NUM_YEAR']." ปี ":"");
                    echo ($row_his['NUM_MONTH']>0?$row_his['NUM_MONTH']." เดือน ":"");
                    echo ($row_his['NUM_DAY']>0?$row_his['NUM_DAY']." วัน ":"");
                    ?></td>
                    </tr>
                <?php
                    $i++;
                }//while
            
                //แลกเปลี่ยน
                $sql_his="SELECT	a.TOTAL_YEAR,
                                    a.TOTAL_MONTH,
                                    a.TOTAL_DATE,
                                    a.EX_SDATE,
                                    a.EX_EDATE,
                                    c.PROJECT_NAME_TH
                            FROM	DEV_EX_EXCHANGE AS a INNER JOIN 
                                    DEV_EX_USER_REGIS AS b ON a.EXCHANGE_ID = b.EXCHANGE_ID INNER JOIN 
                                    DEV_PROJECT AS c ON a.PROJECT_ID = c.PROJECT_ID
                            WHERE	b.TRANSFER_STATUS=1 AND b.PER_ID = '".$_GET['PER_ID']."' ";
                $exc_his=$db->query($sql_his);
                while($row_his=$db->db_fetch_array($exc_his)){
                ?>
                  <tr>
                    <td align="center"><?php echo $i; ?>.</td>
                     <td><?php echo text($row_his['PROJECT_NAME_TH']); ?></td>
                    <td align="center">&nbsp;</td>
                    <td align="center"><?php echo conv_date($row_his['EX_SDATE'])." - ".conv_date($row_his['EX_SDATE']); ?></td>
                    <td align="center"><?php 
                    echo ($row_his['TOTAL_YEAR']>0?$row_his['TOTAL_YEAR']." ปี ":"");
                    echo ($row_his['TOTAL_MONTH']>0?$row_his['TOTAL_MONTH']." เดือน ":"");
                    echo ($row_his['TOTAL_DATE']>0?$row_his['TOTAL_DATE']." วัน ":"");
                    ?></td>
                    </tr>
                <?php
                    $i++;
                }//while
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