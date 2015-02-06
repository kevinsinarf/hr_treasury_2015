<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT = 2;
$link = "r=home&menu_id=".$menu_id;  /// for mobile
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
$paramlink = url2code($link);

$sql = "SELECT * FROM PER_HEIRHIS a where a.DELETE_FLAG='0' and a.PER_ID = '".$PER_ID."' ORDER BY ACTIVE_STATUS DESC, HEIR_SDATE DESC";
$query = $db->query($sql);
$nums = $db->db_num_rows($query);

$arr_type_salary = array(1 => 'เงินเดือน', 2 => 'เงินบำนาญรวมกับ ช.ค.บ.', 3 => 'เบี้ยหวัดรวมกับ ช.ค.บ.');
$arr_type_heir = array(1 => 'แบบที่ 1', 2 => 'แบบที่ 2');
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
<script src="js/profile_heirhis_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active">ประวัติของผู้ถูกแสดงเจตนาให้รับบำเหน็จตกทอด</li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content"> 
    	<?php include("tab_profile.php");?>
        <div class="grouptab">
            <br>
            <?php include("tab_info.php");?>
            <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
                <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
                <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        		<input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
                <input type="hidden" id="HEIR_ID" name="HEIR_ID" value="">

                <div class="row">
                	<div class="col-xs-12 col-md-12"> 
                		<a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();">
                		<?php echo $img_save;?> เพิ่มข้อมูล</a> 
                	</div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-condensed">
                                <thead>
                                    <tr class="bgHead">
                                        <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                                        <th width="10%"><div align="center"><strong>เมื่อวันที่</strong></div></th>
                                        <th width="15%"><div align="center"><strong>ประเภทการหนังสือแสดงเจตนา</strong></div></th>
                                        <th width="15%"><div align="center"><strong>ประเภทรายได้</strong></div></th>
                                        <th width="15%"><div align="center"><strong>เดือนละ</strong></div></th>
										<th width="8%"><div align="center"><strong>รวม(คน)</strong></div></th>
                                        <th width="10%"><div align="center"><strong>สถานะ</strong></div></th>
                                        <th width="10%"><div align="center"><strong>จัดการ</strong></div></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
                                if($nums > 0){
                                    $i=1;
                                    while($rec = $db->db_fetch_array($query)){
										$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["HEIR_ID"]."');\">".$img_edit." แก้ไข</a> ";
										?>
										<tr bgcolor="#FFFFFF">
											<td align="center"><?php echo $i+$goto; ?></td>
											<td align="center" ><?php echo conv_date($rec['HEIR_SDATE'],'short'); ?></td>
											<td align="center"><?php echo $arr_type_heir[$rec['HEIR_TYPE_FORM']]; ?></td>
											<td align="left"><?php echo $arr_type_salary[$rec['HEIR_TYPE_SALARY']]; ?></td>
											<td align="right"><?php echo number_format($rec['HEIR_SALARY'],2); ?></td>
											<td align="center"><?php echo $rec['HEIR_TOTAL']; ?></td>
											<td align="center"><?php echo $arr_act_status[$rec['ACTIVE_STATUS']]; ?></td>
											<td align="center"><?php echo $edit; ?></td>
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
                </div>
            </form>
        </div>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
