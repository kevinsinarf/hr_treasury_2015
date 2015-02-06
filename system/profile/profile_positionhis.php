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


//tab active
$ACT=3;

//ประเภทการถือครอง
$arr_poshis_live = array(  
								'1' => 'ปกติ',
								'2' => 'ปฏิบัติราชการแทน',
								'3' => 'รักษาราชการแทน',
								'4' => 'ช่วยราชการภายในสำนักงานฯ',
								'5' => 'ช่วยราชการภายนอกสำนักงานฯ'
						);


$cond_level = ($TYPE_ID != '') ? "AND TYPE_ID = '".$TYPE_ID."'" : "";
$arr_posi_status = array(1 => 'ตำแหน่งปัจจุบัน', 0 => '-');

$field = " A.POSHIS_ID, A.COM_NO, A.COM_DATE, E.MOVEMENT_NAME_TH,  A.TYPE_LIVE, A.COM_SDATE, A.POS_NO, B.TYPE_NAME_TH, C.LINE_NAME_TH, D.LEVEL_NAME_TH, A.SALARY, A.ACTIVE_STATUS     ";
$table = " PER_POSITIONHIS  A  
LEFT JOIN SETUP_POS_TYPE B ON A.TYPE_ID = B.TYPE_ID
LEFT JOIN SETUP_POS_LINE C ON A.LINE_ID = C.LINE_ID
LEFT JOIN SETUP_POS_LEVEL D ON A.LEVEL_ID = D.LEVEL_ID
LEFT JOIN SETUP_MOVEMENT E ON A.MOVEMENT_ID = E.MOVEMENT_ID  ";
 
$pk_id = "A.POSHIS_ID";
$wh = "A.DELETE_FLAG = 0 AND A.PER_ID = '".$PER_ID."' {$filter}";
$orderby = "ORDER BY A.ACTIVE_STATUS DESC, A.COM_DATE ";
$groupby = "";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh."".$orderby.") ".$groupby." ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin ;
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
<script src="js/profile_positionhis.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	 
      <li class="active"><?php echo $arr_txt['profile_history']; ?></li>
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
		<input type="hidden" id="POSHIS_ID" name="POSHIS_ID" value="">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
      
         
        
        <div class="row">
          <div class="col-xs-12 col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                  <tr class="bgHead">
                    <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
					<th width="9%"><div align="center"><strong>เลขที่คำสั่ง/ลงวันที่</strong></div></th>
                    <th width="10%"><div align="center"><strong>ประเภทความเคลื่อนไหว</strong></div></th>
                    <th width="13%"><div align="center"><strong>ประเภทการถือครอง</strong></div></th>
                    <th width="8%"><div align="center"><strong>วันที่มีผล</strong></div></th>
					<th width="20%"><div align="center"><strong>ตำแหน่ง</strong></div></th> 
                    <th width="10%"><div align="center"><strong>สถานะ</strong></div></th> 
                    <th width="8%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                  </tr>
                </thead>
                <tbody>
			  	<?php
               	if($nums > 0){
                    $i=1;
                    while($rec = $db->db_fetch_array($query)){
                        if($rec['POSHIS_DEFAULT']!="1"){
                            $edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["POSHIS_ID"]."');\">".$img_view." ดูรายละเอียด</a> ";
                           
							$position = "<strong>".$arr_txt['pos_no']." : </strong>".$rec['POS_NO']."</br>";
							$position .= "<strong>ประเภทตำแหน่ง : </strong>".text($rec['TYPE_NAME_TH'])."</br>";
							$position .= "<strong>ตำแหน่งในสายงาน : </strong>".text($rec['LINE_NAME_TH'])."</br>";
							$position .= "<strong>ระดับ : </strong>".text($rec['LEVEL_NAME_TH'])."</br>";
							$position .= "<strong>เงินเดือน : </strong>".number_format($rec['SALARY'])."</br>";
                        }
						 ?>
						  <tr bgcolor="#FFFFFF">
							<td align="center"><?php echo $i+$goto; ?>.</td>
							<td align="center"><?php echo "คำสั่ง".text($rec["COM_NO"])."<br>/".conv_date($rec['COM_DATE'],'short'); ?></td>
							<td align="left"><?php echo text($rec['MOVEMENT_NAME_TH']); ?></td>
							<td align="left"><?php echo $arr_poshis_live[$rec["TYPE_LIVE"]]; ?></td>
							<td align="center"><?php echo conv_date($rec["COM_SDATE"], 'short'); ?></td>
							<td align="left"><?php echo $position; ?></td>
                            <td align="center"><?php echo $arr_posi_status[$rec['ACTIVE_STATUS']]; ?></td>
							<td align="center" nowrap><?php echo $edit; ?></td>
						  </tr>
						  <?php 				
						  $i++;
						}
					}else{
						echo "<tr><td align=\"center\" colspan=\"10\">ไม่พบข้อมูล</td></tr>";
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