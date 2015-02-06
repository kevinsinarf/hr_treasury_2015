<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT;
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

$field="*";
$table="PER_PUNISHMENT a
LEFT JOIN SETUP_CRIME_MAIN c on a.INFORM_CRIME_ID = c.CRIME_ID
LEFT JOIN SETUP_PUNNISH e on   a.FINAL_PUNISH_ID  = e.PUNISH_ID";
$pk_id="a.PUN_ID";
$orderby="";

$sql = "select ".$field." from ".$table." where a.DELETE_FLAG = 0 AND  a.PER_ID = '".$PER_ID."' ".$orderby;
$query_pen = $db->query($sql);
$nums = $db->db_num_rows($query_pen);

//echo $sql;

//ฐานความผิด
$arr_cri = GetSqlSelectArray("CRIME_ID", "CRIME_NAME_TH", "SETUP_CRIME_MAIN", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "CRIME_NAME_TH");
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
<script src="js/profile_punishment.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active">ประวัติการรับโทษทางวินัย</li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content"> 
    	<?php include("tab_profile.php");?> 
        <div class="grouptab">
           
            <?php include("tab_info.php");?>
			
            <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
                <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PUN_ID" name="PUN_ID" value="<?php echo $PENALTY_ID?>">
                <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        		<input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
                <input type="hidden" id="LEAVEHIS_ID" name="LEAVEHIS_ID" value="">
                <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID; ?>">
                
                
		<?php if(chkPermission($menu_sub_id, 'add')=='1'){?>
		<div class="row">  
			<div class="col-xs-12 col-sm-1"><a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();"><?php echo $img_save;?> เพิ่มข้อมูล</a></div>
		</div>
		<?php }?>
                
                <div class="row">
                    <div class="col-xs-12 col-md-12">             
                        <div class="table-responsive">
				<table class="table table-bordered table-striped table-hover table-condensed">
					<thead>
						<tr class="bgHead">
							<th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
							<th width="10%"><div align="center"><strong>เลขที่คำร้อง</strong> </div></th>
                            <th width="10%"><div align="center"><strong>วันที่ร้องเรียน</strong></div></th>
                   	    	<th width="25%"><div align="center"><strong>ฐานความผิด</strong></div></th>
                           <?php /*	<th width="15%"><div align="center"><strong>สถานะ</strong></div></th> */ ?>
							<th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if($nums > 0){
						$i=0;
						while($rec_main = $db->db_fetch_array($query_pen)){
						
                            $edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec_main["PUN_ID"]."');\">".$img_edit." แก้ไข</a> ";
                            $delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec_main["PUN_ID"]."');\">".$img_del." ลบ</a> ";
						
							$name=Showname($rec_main["INFORM_TO_PREFIX_ID"],$rec_main["INFORM_TO_FIRSTNAME"],$rec_main["INFORM_TO_MIDNAME"],$rec_main["INFORM_TO_LASTNAME"]);
							
							$name_by =Showname($rec_main["INFORM_BY_PREFIX_ID"],$rec_main["INFORM_BY_FIRSTNAME_TH"],$rec_main["INFORM_BY_MIDNAME_TH"],$rec_main["INFORM_BY_LASTNAME_TH"]);
							$rec_main = convert_text($rec_main);
								$detail = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec_main["PUN_ID"]."','".$ACT."');\">".$img_view." ดูรายละเอียด</a>";
							?>
                            <tr>
                            <?php /*
                                <td align="center"><?php echo (++$i+$goto).".";?></td>
                                <td align="center"><?php echo $rec_main['INFORM_NO'];?></td>
                                <td align="center"><?php echo conv_date($rec_main['INFORM_DATE'],'short');?></td>
                                <td align="left"><?php echo $rec_main['CRIME_NAME_TH'];?></td>
                                <td align="left"><?php echo $arr_penalty_status[$rec_main['PENALTY_STATUS']];?></td>
                                <td align="center"><?php echo $detail;?></td>
								*/ ?>
                                
                                <td align="center"><?php echo (++$i+$goto).".";?></td>
                                <td align="center"><?php echo $rec_main['FINAL_NO'];?></td>
                                <td align="center"><?php echo conv_date($rec_main['FINAL_DATE'],'short');?></td>
                                <td align="left"><?php echo $rec_main['PUNISH_NAME_TH'];?></td>
                               <?php /* <td align="left"><?php // echo $arr_penalty_status[$rec_main['PENALTY_STATUS']];?></td> */ ?>
                                <td align="center"><?php // echo $detail;?><?php echo $edit.$delete; ?></td>
                            </tr>
                            <?php
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
            </form>
        </div>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
