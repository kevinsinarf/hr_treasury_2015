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

//  MAIN 
$field=" * ";
$table=" PER_LEAVEHIS ";
$pk_id="LEAVEHIS_ID";
$wh=" PER_ID = '".$PER_ID."' {$filter} ";
$orderby="order by LEVEHIS_ID DESC ";
//$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;
$notin = $wh;

/*   

//  MAIN 
$field="b.ABSENT_NAME_TH, a.ATTABSENT_NDATE, a.ATTABSENT_SDATE, a.ATTABSENT_EDATE, a.ATTABSENT_USED ";
$table=" ATTENDANCE_ABSENT a LEFT JOIN SETUP_ABSENT b ON a.ABSENT_ID = b.ABSENT_ID ";
$pk_id="a.ATTABSENT_ID";
$wh=" a.PER_ID = '".$PER_ID."' {$filter} ";
$orderby="order by a.ATTABSENT_EDATE DESC, a.ATTABSENT_SDATE DESC ";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;
*/
$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

$arr_result = array("1" => "ผ่าน", "2" => "ไม่ผ่าน");

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
<script src="js/profile_absenthis.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <!--li><a href="<?php echo $page_back."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li-->
      <li class="active">ประวัติการลา</li>
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
		<input type="hidden" id="ABSENTHIS_ID" name="ABSENTHIS_ID" value="">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
         <input type="hidden" id="LEAVEHIS_ID" name="LEAVEHIS_ID" value="">       
         
         
         
         
        <div class="row"> <?php echo @(ceil($total_record/$page_size) > 1) ? startPaging("frm-search",$total_record):""; ?> </div>
          
 
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
                    <th width="10%"><div align="center"><strong>พ.ศ.</strong></div></th>
                    <th width="10%"><div align="center"><strong>รอบ</strong></div></th>
                    <th width="10%"><div align="center"><strong>ลาป่วย ( วัน )</strong></div></th>
                    <th width="10%"><div align="center"><strong>ลากิจและพักผ่อน  ( วัน )</strong></div></th>
                    <th width="10%"><div align="center"><strong>มาสาย  ( วัน )</strong></div></th>
                    <th width="10%"><div align="center"><strong>ขาดราชการ  ( วัน )</strong></div></th>
                    <th width="10%"><div align="center"><strong>ลาศึกษาต่อ  ( วัน )</strong></div></th>
							<th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                  </tr>
                </thead>
                <tbody>
			  	<?php
			   if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($query)){
					
                           $edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["LEAVEHIS_ID"]."');\">".$img_view." ดูรายละเอียด</a> ";
                            
					
						?>
						<tr bgcolor="#FFFFFF">
							<td align="center"><?php echo $i+$goto; ?>.</td>
							<td align="center"><?php echo text($rec["LEAVEHIS_YEAR"]); ?></td>
							<td align="center"><?php echo text($rec["ROUND_YEAR"]); ?></td>
							<td align="right"><?php echo number_format($rec["LEAVEHIS_SICK_DAY"],2); ?></td>
                            <?php $private_relax = ($rec["LEAVEHIS_PRIVATE_DAY"]+ $rec["LEAVEHIS_RELAX_DAY"]); ?>
                            <td align="right"><?php echo number_format($private_relax,2); ?></td>
							<td align="right"><?php echo number_format($rec["LEAVEHIS_LATE_DAY"],2); ?></td>
                            <td align="right"><?php echo number_format($rec["LEAVEHIS_WITHOUT_DAY"],2); ?></td>
                            <td align="right"><?php echo number_format($rec["LEAVEHIS_STUDY_DAY"],2); ?></td>
                                <td align="center"><?php // echo $detail;?><?php echo $edit; ?></td>     
						</tr>
						<?php 				
						$i++;
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