<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$link2 = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;
$paramlink = url2code($link);

$field = "PENSION_ID, PENSION_IDCARD, A.PER_ID, B.PREFIX_ID, PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH, POSTYPE_NAME_TH, PER_STATUS, PENSION_TYPE_PENSION, PENSION_TYPE_REQUEST_CIVIL";
$table = "PENSION_MAIN A JOIN PER_PROFILE B ON B.PER_IDCARD = A.PENSION_IDCARD JOIN SETUP_POSITION_TYPE C ON C.POSTYPE_ID = A.POSTYPE_ID";
$pk_id = "PENSION_ID";
$wh = "A.DELETE_FLAG='0' AND B.PENSION_STATUS = '2' {$filter}";
$orderby = "order by PENSION_ID DESC";
$notin = $wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;
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
<script src="<?php echo $path; ?>bootstrap/js/jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/transition.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/holder.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/collapse.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/dropdown.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/modal.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/carousel.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/respond.min.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/html5shiv.js"></script>
<script src="js/pension_request_approve_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li class="active">ผลการอนุมัติการขอบำเหน็จบำนาญ</li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12"> 
            <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
                <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PENSION_ID" name="PENSION_ID" value="">
                <div class="row">
                	<div class="col-xs-12 col-md-12"></div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-condensed">
                                <thead>
                                    <tr class="bgHead">
                                        <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                                        <th width="12%"><div align="center"><strong><?php echo $arr_txt['idcard']; ?></strong></div></th>
                                    	<th width="20%"><div align="center"><strong>ชื่อ-สกุล</strong></div></th>
                                        <th width="10%"><div align="center"><strong>ประเภทบุคลากร</strong></div></th>
                                        <th width="10%"><div align="center"><strong>สาเหตุการออกจากราชการ</strong></div></th>
                                        <th width="10%"><div align="center"><strong>ประเภทการขอรับ</strong></div></th>
                                        <th width="10%"><div align="center"><strong>สาเหตุการขอรับ</strong></div></th>
                                        <th width="10%"><div align="center"><strong>สถานะการขอรับบำเหน็จบำนาญ</strong></div></th>
                                        <th width="8%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($nums > 0){
                                        $i=1;
                                        while($rec = $db->db_fetch_array($query)){
											$PER_NAME = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
											$approve = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"approveData('".$rec["PENSION_ID"]."');\"><span class=\"glyphicon glyphicon-saved\"></span> อนุมัติ</a> ";
											?>
											<tr bgcolor="#FFFFFF">
												<td align="center"><?php echo $i+$goto;?></td>
												<td align="center"><?php echo get_idCard($rec["PENSION_IDCARD"]);?></td>
												<td align="left" style="padding-left:5px"><?php echo $PER_NAME;?></td>
												<td align="center"><?php echo text($rec["POSTYPE_NAME_TH"]);?></td>
												<td align="center"><?php echo $arr_per_status[$rec['PER_STATUS']];?>&nbsp;</td>
												<td align="center"><?php echo $arr_pension_type[$rec['PENSION_TYPE_PENSION']];?></td>
												<td align="center"><?php echo $arr_pension_request[$rec['PENSION_TYPE_REQUEST_CIVIL']];?></td>
												<td align="center"><?php echo $rec[''];?>&nbsp;</td>
												<td align="center"><?php echo $approve;?></td>
											</tr>
											<?php 
                                       		$i++;
                                        }
                                    }else{
                                        echo "<tr><td align=\"center\" colspan=\"7\">".$arr_txt['data_not_found']."</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>                  
                    </div>
                </div>
                <div class="row"><?php echo ($nums>0)?endPaging("frm-search",$total_record):"";?></div>
            </form>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
