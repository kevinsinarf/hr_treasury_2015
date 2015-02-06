<?php
$path = "../../";
include($path."include/config_header_top.php");

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

$field=" FAMILY_ID, FAMILY_RELATIONSHIP, FAMILY_IDTYPE, FAMILY_IDCARD, FAMILY_PREFIX_ID, FAMILY_FIRSTNAME_TH, FAMILY_MIDNAME_TH, FAMILY_LASTNAME_TH, FAMILY_STATUS, ACTIVE_STATUS";
$table=" PER_FAMILY";
$orderby=" order by  ACTIVE_STATUS DESC, FAMILY_RELATIONSHIP ASC";

$sql = "select ".$field." from ".$table." where DELETE_FLAG = '0' AND FAMILY_RELATIONSHIP != '6' AND PER_ID = '".$PER_ID."' AND REQUEST_STATUS = '2' AND REQUEST_RESULT = '2'".$orderby;
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
<?php list_scriptinclude(); ?>
<script src="js/profile_contact_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active">ประวัติบุคคลในครอบครัว</li>
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
                <input type="hidden" id="FAMILY_ID" name="FAMILY_ID" value="">

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
                                        <th width="8%"><div align="center"><strong>ความสัมพันธ์</strong></div></th>
                                        <th width="14%"><div align="center"><strong><?php echo $arr_txt['idcard']; ?></strong></div></th>
                                        <th width="20%"><div align="center"><strong>ชื่อ-สกุล</strong></div></th>
                                        <th width="10%"><div align="center"><strong>สถานะการมีชีวิต</strong></div></th>
                                        <th width="10%"><div align="center"><strong>สถานะการใช้งาน</strong></div></th>
                                        <th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
                                if($nums > 0){
									$i=1;
									while($rec = $db->db_fetch_array($query)){
										$NAME = Showname($rec["FAMILY_PREFIX_ID"],$rec["FAMILY_FIRSTNAME_TH"],$rec["FAMILY_MIDNAME_TH"],$rec["FAMILY_LASTNAME_TH"]);
										$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["FAMILY_ID"]."');\">".$img_edit." แก้ไข</a> ";
										$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["FAMILY_ID"]."');\">".$img_del." ลบ</a> ";
										$IDCARD = ($rec['FAMILY_IDTYPE'] == 1) ? get_idCard($rec["FAMILY_IDCARD"]) : $rec['FAMILY_IDCARD'];
										?>
										<tr bgcolor="#FFFFFF">
                                            <td align="center"><?php echo $i+$goto;?>.</td>
                                            <td align="center"><?php echo $arr_family_relation[$rec['FAMILY_RELATIONSHIP']];?>&nbsp;</td>
                                            <td align="center"><?php echo $IDCARD;?></td>
                                            <td align="left"><?php echo $NAME;?></td>
                                            <td align="center"><?php echo $arr_family_status[$rec["FAMILY_STATUS"]]; ?></td>
                                            <td align="center"><?php echo $arr_act_status[$rec["ACTIVE_STATUS"]]; ?></td>
                                            <td align="center"><?php echo $edit.$delete;?></td>
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
            </form>
        </div>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
