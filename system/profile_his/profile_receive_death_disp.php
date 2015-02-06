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

$field="A.FAMILY_DATE , A.FAMILY_IDCARD ,A.FAMILY_PREFIX_ID,A.FAMILY_FIRSTNAME_TH ,A.FAMILY_MIDNAME_TH
,A.FAMILY_LASTNAME_TH ,B.COUNTRY_NAME_TH ,A.ADDRESS_CITY,A.FAMILY_ID
,A.ADDRESS_ROOM_NO,A.ADDRESS_FLOOR,A.ADDRESS_BUILDING,A.ADDRESS_HOME_NO
,A.ADDRESS_MOO,A.ADDRESS_VILLAGE,A.ADDRESS_SOI,A.ADDRESS_ROAD,A.ADDRESS_POSTCODE,A.ADDRESS_TEL,A.ADDRESS_TEL_EXT ,ADDRESS_FAX ,E.TAMB_NAME_TH, D.AMPR_NAME_TH ,C.PROV_TH_NAME,A.ADDRESS_COUNTRY_ID
,A.ADDRESS_FAX_EXT,A.ADDRESS_MOBILE ,A.ACTIVE_STATUS";
$table="PER_FAMILY A
LEFT JOIN SETUP_COUNTRY B ON  A.ADDRESS_COUNTRY_ID = B.COUNTRY_ID 
LEFT JOIN SETUP_PROV C ON C.PROV_ID = A.ADDRESS_PROV_ID
LEFT JOIN SETUP_AMPR D ON D.AMPR_ID =A.ADDRESS_AMPR_ID
LEFT JOIN SETUP_TAMB E ON E.TAMB_ID = A.ADDRESS_TAMB_ID";
$orderby=" order by  A.ACTIVE_STATUS DESC";

$sql = "select ".$field." from ".$table." where A.DELETE_FLAG='0' and FAMILY_RELATIONSHIP = '6' and  A.PER_ID = '".$PER_ID."'".$orderby;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);

$arr_status = array('1'=>'เป็นผู้ถูกระบุปัจจุบัน', '0' => 'ยกเลิก');

$arr_country=GetSqlSelectArray("COUNTRY_ID", "COUNTRY_NAME_TH", "SETUP_COUNTRY", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "COUNTRY_NAME_TH");//ประเทศ
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
<script src="js/profile_receive_death_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active">ประวัติของผู้ถูกแสดงเจตนารับเงินช่วยเหลือพิเศษกรณีถึงแก่ความตาย</li>
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
                		<a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData(<?php echo $info['PER_ID'];?>);">
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
                                    	<th width="9%"><div align="center"><strong>วันที่แจ้ง</strong></div></th>
                                    	<th width="13%"><div align="center"><strong><?php echo $arr_txt['idcard']; ?></strong></div></th>
                                  		<th width="14%"><div align="center"><strong>ชื่อ - สกุล</strong></div></th>
                                    	<th width="24%"><div align="center"><strong>ที่อยู่</strong></div></th>
                                    	<th width="18%"><div align="center"><strong>หมายเลขติดต่อ</strong></div></th>
                                        <th width="7%"><div align="center"><strong>สถานะ</strong></div></th>
                                      	<th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
                                if($nums > 0){
                                    $i=1;
                                    while($rec = $db->db_fetch_array($query)){

										$ADDRESS_HOME_NO = (trim($rec['ADDRESS_HOME_NO']) != '') ? 'เลขที่ห้อง '.text($rec['ADDRESS_ROOM_NO']) : '';
										$ADDRESS_FLOOR =  'ชั้น '.text($rec['ADDRESS_FLOOR']); '';
										$PADD_BUILDING = (trim($rec['ADDRESS_BUILDING']) != '') ? ' อาคาร'.text($rec['ADDRESS_BUILDING']) : '';
										$PADD_HOME_NO = (trim($rec['ADDRESS_ROOM_NO']) != '') ? '<br>บ้านเลขที่ห้อง '.text($rec['ADDRESS_ROOM_NO']) : '';
										$PADD_MOO = (trim($rec['PADD_MOO']) != '') ? ' หมู่ที่ '.text($rec['PADD_MOO']) : '';
										$ADDRESS_VILLAGE = (trim($rec['ADDRESS_VILLAGE']) != '') ? ' หมู่บ้าน'.text($rec['ADDRESS_VILLAGE']) : '';
										$PADD_SOI = (trim($rec['ADDRESS_SOI']) != '') ? ' ซอย '.text($rec['ADDRESS_SOI']) : '';
										$ADDRESS_ROAD = (trim($rec['ADDRESS_ROAD']) != '') ? ' ถนน'.text($rec['ADDRESS_ROAD']) : '';
										$TAMB_NAME_TH =  '<br>ตำบล'.text($rec['TAMB_NAME_TH']); ' ';
										$AMPR_NAME_TH = ' อำเภอ'.text($rec['AMPR_NAME_TH']); '';
										$PROV_TH_NAME = ' จังหวัด'.text($rec['PROV_TH_NAME']) ; '';
										$ADDRESS_POSTCODE = (trim($rec['ADDRESS_POSTCODE']) != '') ? ' รหัสไปรษณีย์ '.$rec['ADDRESS_POSTCODE'] : '';
										
										$ADDRESS_COUNTRY_ID =  'ประเทศ '.text($arr_country[$rec['ADDRESS_COUNTRY_ID']]); ' ';
										$ADDRESS_CITY = 'เมือง '.text($rec['ADDRESS_CITY']); '';
										$ADDRESS_  = $ADDRESS_COUNTRY_ID." ".$ADDRESS_CITY;
										
										$ADDRESS = $ADDRESS_ROOM_NO.$ADDRESS_FLOOR.$ADDRESS_BUILDING.$PADD_HOME_NO.$PADD_MOO.$ADDRESS_VILLAGE.$ADDRESS_SOI.$ADDRESS_ROAD.$TAMB_NAME_TH.$AMPR_NAME_TH.$PROV_TH_NAME.$ADDRESS_POSTCODE;
							
										$ADDRESS_TEL_EXT = (trim($rec['ADDRESS_TEL_EXT']) != '') ? ' ต่อ '.text($rec['ADDRESS_TEL_EXT']) : '';
										$ADDRESS_FAX_EXT = (trim($rec['ADDRESS_FAX_EXT']) != '') ? ' ต่อ '.text($rec['ADDRESS_FAX_EXT']) : '';
                                        
										$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["FAMILY_ID"]."');\">".$img_edit." แก้ไข</a> ";
                                        $delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["FAMILY_ID"]."');\">".$img_del." ลบ</a> ";
										?>
										<tr bgcolor="#FFFFFF">
											<td align="center"><?php echo $i+$goto; ?>.</td>
											<td align="center"><?php echo conv_date($rec['FAMILY_DATE'],'short');?></td>
											<td align="center"><?php echo get_idCard($rec["FAMILY_IDCARD"]); ?></td>
											<td align="left"><?php  echo Showname($rec["FAMILY_PREFIX_ID"],$rec["FAMILY_FIRSTNAME_TH"],$rec["FAMILY_MIDNAME_TH"],$rec["FAMILY_LASTNAME_TH"]); ?></td>
											<td align="left"><?php if($rec['ADDRESS_COUNTRY_ID']==41){ echo $ADDRESS;}else{ echo $ADDRESS_;}?></td>
											<td align="left">โทรศัพท์ <?php echo format_phone($rec['ADDRESS_TEL'],"tel","bk",$rec['ADDRESS_TEL_EXT']); ?><br>โทรสาร <?php echo format_phone($rec['ADDRESS_FAX'],"tel","bk",$rec['ADDRESS_FAX_EXT']);?><br>โทรศัพท์เคลื่อนที่ <?php echo format_phone($rec['ADDRESS_MOBILE'],"mobile","bk","");?></td>
											<td align="center"><?php echo $arr_status[$rec['ACTIVE_STATUS']];  ?></td>
											<td align="center"><?php echo $edit.$delete; ?></td>
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
