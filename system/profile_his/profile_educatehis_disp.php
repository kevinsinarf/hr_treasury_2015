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

$field="a.EDU_ID, a.EDU_TYPE, d.EM_NAME_TH,b.EL_NAME_TH,c.ED_NAME_TH,e.INS_NAME_TH,a.ACTIVE_STATUS";
$table="PER_EDUCATEHIS a
LEFT JOIN SETUP_EDU_LEVEL b ON a.EL_ID = b.EL_ID
LEFT JOIN SETUP_EDU_DEGREE c ON a.ED_ID = c.ED_ID
LEFT JOIN SETUP_EDU_MAJOR d ON a.EM_ID = d.EM_ID
LEFT JOIN SETUP_EDU_INSTITUTE e ON a.INS_ID = e.INS_ID";
$orderby=" order by a.EDU_SEQ ASC";

$sql = "select ".$field." from ".$table." where a.REQUEST_STATUS = '2' and a.REQUEST_RESULT = '2' and a.DELETE_FLAG='0' and a.PER_ID = '".$PER_ID."'".$orderby;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
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
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_educatehis_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active">ประวัติการศึกษา</li>
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
                <input type="hidden" id="EDU_ID" name="EDU_ID" value="">
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
                                        <th width="10%"><div align="center"><strong>ประเภทวุฒิ</strong></div></th>
                                        <th width="16%"><div align="center"><strong>สาขาวิชาเอก</strong></div></th>
                                        <th width="15%"><div align="center"><strong>ระดับการศึกษา</strong></div></th>
                                        <th width="20%"><div align="center"><strong>วุฒิการศึกษา</strong></div></th>
                                        <th width="15%"><div align="center"><strong>สถาบันการศึกษา</strong></div></th>
                                        <th width="10%"><div align="center"><strong>สถานะการใช้งาน</strong></div></th>
                                        <th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								if($nums > 0){
									$i=1;
									while($rec = $db->db_fetch_array($query)){
										$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["EDU_ID"]."');\">".$img_edit." แก้ไข</a> ";
									 	$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["EDU_ID"]."');\">".$img_del." ลบ</a> ";
                                    	?>
                                    	<tr bgcolor="#FFFFFF">
                                            <td align="center"><?php echo $i+$goto; ?>.</td>
                                            <td align="center"><?php echo $arr_edu_type[$rec['EDU_TYPE']];?></td>
                                            <td align="left"><?php echo text($rec['EM_NAME_TH']);?></td>
                                            <td align="left"><?php echo text($rec['EL_NAME_TH']);?></td>
                                            <td align="left"><?php echo text($rec['ED_NAME_TH']);?></td>
                                            <td align="left"><?php echo text($rec["INS_NAME_TH"]); ?></td>
                                            <td align="center"><?php echo $arr_act_status[$rec["ACTIVE_STATUS"]]; ?></td>
                                            <td align="center" nowrap><?php echo $edit.$delete;?></td>
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
