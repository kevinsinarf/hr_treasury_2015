<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
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

//สถานะ
$status_child =array('1'=>'มีชีวิตอยู่','2'=>'ถึงแก่กรรม');

$field="PCHILD_ID,PER_ID,PCHILD_PREFIX_ID,PCHILD_FIRSTNAME_TH,PCHILD_MIDNAME_TH,PCHILD_LASTNAME_TH,
PCHILD_FIRSTNAME_EN,PCHILD_MIDNAME_EN,PCHILD_LASTNAME_EN,PCHILD_IDCARD,PCHILD_BIRTHDATE,PCHILD_STATUS ";
$table="PER_CHILD";
$pk_id="PCHILD_ID";
$wh="DELETE_FLAG='0' and PER_ID = '".$PER_ID."' {$filter}";
$orderby="order by  PCHILD_BIRTHDATE, PCHILD_PREFIX_ID, PCHILD_FIRSTNAME_TH, PCHILD_MIDNAME_TH, PCHILD_LASTNAME_TH ASC";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

$arr_prefix=GetSqlSelectArray("PREFIX_ID", "PREFIX_NAME_TH", "V_PREFIX", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PREFIX_SEQ,PREFIX_NAME_TH"); //คำนำหน้าชื่อ th
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
<script src="js/profile_child_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active">ประวัติบุตร</li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12"> 
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
                <input type="hidden" id="PCHILD_ID" name="PCHILD_ID" value="">
				<div class="row">
                <?php echo @(ceil($total_record/$page_size) > 1) ? startPaging("frm-search",$total_record):""; ?>
                </div>
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
                                    <th width="24%"><div align="center"><strong>ชื่อ-สกุล</strong></div></th>
                                    <th width="16%"><div align="center"><strong><?php echo $arr_txt['idcard']; ?></strong></div></th>
                                    <th width="15%"><div align="center"><strong>วัน/เดือน/ปีเกิด</strong></div></th>
                                        <th width="15%"><div align="center"><strong>สถานภาพ</strong></div></th>
                                        <th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($nums > 0){
                                        $i=1;
                                        while($rec = $db->db_fetch_array($query)){
                                             //$rec = array_change_key_case($rec,CASE_LOWER);
                                        $edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["PCHILD_ID"]."');\">".$img_edit." แก้ไข</a> ";
                                         $delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["PCHILD_ID"]."');\">".$img_del." ลบ</a> ";
                                    ?>
                                    <tr bgcolor="#FFFFFF">
                                        <td align="center"><?php echo $i+$goto; ?>.</td>
                                        <td align="left" style="padding-left:5px"><?php echo  text($arr_prefix_child[$rec["PCHILD_PREFIX_ID"]]).' '.text($rec["PCHILD_FIRSTNAME_TH"]).' '.text($rec["PCHILD_MIDNAME_TH"]).' '.text($rec["PCHILD_LASTNAME_TH"]); ?></td>
                                        <td align="center"><?php echo get_idCard($rec["PCHILD_IDCARD"]); ?></td>
                                         <td align="center"><?php echo  conv_date($rec["PCHILD_BIRTHDATE"],'short'); ?></td>
										<td align="center"><?php echo $status_child[$rec["PCHILD_STATUS"]]; ?></td>
                                        <td align="center"><?php echo $edit.$delete; ?></td>
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
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
