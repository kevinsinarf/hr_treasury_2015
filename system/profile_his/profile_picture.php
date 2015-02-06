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

$sql = "select * from PER_PICTURE where DELETE_FLAG='0' and PER_ID = '".$PER_ID."' order by ACTIVE_STATUS DESC, PIC_DEFAULT, PIC_SEQ ASC";
$query = $db->query($sql);
$nums = $db->db_num_rows($query);

//สถานะการใช้ภาพถ่าย  
$arr_pic_status = array('1'=>"เป็นภาพปัจจุบัน", '2'=>"ไม่เป็นภาพปัจจุบัน");
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
<script src="js/profile_picture.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
           <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active">ประวัติภาพถ่าย</li>
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
                <input type="hidden" id="PIC_ID" name="PIC_ID" value="">

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
                                        <th width="6%"><div align="center"><strong>ลำดับภาพที่</strong></div></th>
                                        <th width="12%"><div align="center"><strong>วันที่ถ่ายภาพ</strong></div></th>
                                        <th width="30%"><div align="center"><strong>หมายเหตุ</strong></div></th>
                                        <th width="12%"><div align="center"><strong>สถานะการใช้ภาพถ่าย</strong></div></th>
                                        <th width="10%"><div align="center"><strong><?php echo $arr_txt['active'];?></strong></div></th>
                                        <th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
                                if($nums > 0){
                                    $i=1;
                                    while($rec = $db->db_fetch_array($query)){
                                        $edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["PIC_ID"]."');\">".$img_edit." แก้ไข</a> ";
                                        if($rec['ACTIVE_STATUS']=="1" && $rec['PIC_DEFAULT']=="1"){
                                            $delete = "";
                                        }else{
                                            $delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["PIC_ID"]."');\">".$img_del." ลบ</a> ";
                                        }
                                        ?>
                                        <tr bgcolor="#FFFFFF">
                                            <td align="center"><?php echo $i+$goto; ?>.</td>
                                            <td align="center"><?php echo text($rec['PIC_SEQ']);?></td>
                                            <td align="center"><?php echo conv_date($rec["PIC_DATE"],'short'); ?></td>
                                            <td align="left" style="padding-left:5px"><?php echo text($rec["PIC_REMARK"]); ?></td>
                                            <td align="center"><?php echo $arr_pic_status[$rec["PIC_DEFAULT"]]; ?></td>
                                            <td align="center"><?php echo $arr_act_status[$rec["ACTIVE_STATUS"]]; ?></td>
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
                </div>
            </form>
        </div>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
