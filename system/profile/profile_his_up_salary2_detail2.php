<?php
$path = "../../";
include($path . "include/config_header_top.php");
$link = "r=home&menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id."&YEAR_BDG=".$YEAR_BDG;  /// for mobile
$link2 = "r=home&menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id."&YEAR_BDG=".$YEAR_BDG."&SAL_COM_ID=".$SAL_COM_ID;
 
$paramlink = url2code($link);
$paramlink2 = url2code($link2);
$txt = ($proc == "add") ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล";
$ORG_ID_3  = $_POST['ORG_ID_3'];
$YEAR_BDG = $_POST['YEAR_BDG'];
$ROUND = $_POST['ROUND'];
$SAL_COM_ID = $_POST['SAL_COM_ID'];

$filter = "";
if($name != ""){
	$filter .= searchName("a.SS_FIRSTNAME_TH","a.SS_MIDNAME_TH","a.SS_LASTNAME_TH",ctext($name));
}
if($ef_status != ""){
	$filter .= " and b.SSP_STATUS_1 = '".$ef_status."' ";
}

$sql = "SELECT A.YEAR_BDG, A.ROUND, B.COM_TITLE, B.COM_NO, B.COM_SDATE, B.COM_DATE, C.PREFIX_ID, C.PER_FIRSTNAME_TH, C.PER_MIDNAME_TH, C.PER_LASTNAME_TH, D.ORG_NAME_TH, A.SALARY_NEW, E.LEVEL_NAME_TH, G.LINE_NAME_TH 
FROM SAL_UP_SALARY A
LEFT JOIN SAL_COMMAND B ON A.SAL_COM_ID = B.SAL_COM_ID
LEFT JOIN PER_PROFILE C ON A.PER_ID = C.PER_ID
LEFT JOIN SETUP_ORG D ON A.ORG_ID_3 = D.ORG_ID
LEFT JOIN SETUP_POS_LEVEL E ON A.LEVEL_ID = E.LEVEL_ID
LEFT JOIN SETUP_POS_LINE G ON A.LINE_ID = G.LINE_ID  
WHERE A.SAL_COM_ID = '".$SAL_COM_ID."' ";


$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("SELECT A.YEAR_BDG, A.ROUND, B.COM_TITLE, B.COM_NO, B.COM_SDATE, B.COM_DATE, C.PREFIX_ID, C.PER_FIRSTNAME_TH, C.PER_MIDNAME_TH, C.PER_LASTNAME_TH, D.ORG_NAME_TH, A.SALARY_NEW 
FROM SAL_UP_SALARY A
LEFT JOIN SAL_COMMAND B ON A.SAL_COM_ID = B.SAL_COM_ID
LEFT JOIN PER_PROFILE C ON A.PER_ID = C.PER_ID
LEFT JOIN SETUP_ORG D ON A.ORG_ID_3 = D.ORG_ID
WHERE A.ORG_ID_3= '".$ORG_ID_3."'"));

$sql_org = "SELECT ORG_ID_3,B.ORG_NAME_TH FROM SAL_UP_SALARY A LEFT JOIN SETUP_ORG B ON A.ORG_ID_3 = B.ORG_ID WHERE A.ORG_ID_3 = '".$ORG_ID_3."'";
$query_org=$db->query($sql_org);
$rec_org=$db->db_fetch_array($query_org);

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
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
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
<script src="js/profile_his_up_salary2_detail2.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path . "include/header.php"); ?></div>
	<div><?php include($path . "include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
         <li><a href="profile_his_up_salary_disp.php?<?php echo $paramlink; ?>"><?php echo Showmenu($menu_sub_id);?> (ข้อมูลการเลื่อนขั้นเงินเดือน)</a></li>
         <li><a href="#" onClick="$('#frm-search').attr('action','profile_his_up_salary_detail.php').submit();">ข้อมูลการเลื่อนขั้นเงินเดือน</a></li>
			<li class="active">รายละเอียด</li>
        </ol>
	</div>
	<div class="col-xs-12 col-md-12">
		<div class="groupdata">
			<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
				<input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
				<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
				<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="ORG_ID_3" name="ORG_ID_3" value="<?php echo $ORG_ID_3;?>">
                <input type="hidden" id="SAL_COM_ID" name="SAL_COM_ID" value="<?php echo $SAL_COM_ID;?>">
                <div class="row">
                	<div class="col-xs-12 col-md-2"><strong>ปีงบประมาณ :</strong></div>
                    <div class="col-xs-12 col-sm-2"><?php echo $YEAR_BDG; ?></div>
                    
                </div>
                <div class="row">
                <div class="col-xs-12 col-md-2"><strong>รอบ :</strong></div>
                    <div class="col-xs-12 col-sm-2"><?php echo $ROUND; ?></div>
               </div>
                <div class="row">
                	<div class="col-xs-12 col-md-2"><strong>สำนัก :</strong></div>
                    <div class="col-xs-12 col-sm-4"><?php echo text($rec_org['ORG_NAME_TH']);?></div>
                </div>
                
				<div class="col-xs-12 col-md-12">
					<div class="table-responsive">
                        <table width="397" class="table table-bordered table-striped table-hover table-condensed">
                          <thead>
                               <tr class="bgHead">
                              <th width="25%"  style="text-align:center; vertical-align:middle" ><strong>ชื่อ-สกุล</strong></th>
                              <th width="20%"  style="text-align:center; vertical-align:middle" ><strong>ระดับตำแหน่ง</strong></th>
                              <th width="20%" style="text-align:center; vertical-align:middle" ><strong>ตำแหน่งในสายงาน</strong></th>
                              <th width="10%"  style="text-align:center; vertical-align:middle" ><strong>เงินเดือน</strong></th>
                           </tr>
                           </thead>
							<tbody>
                            
							<?php
							
							if ($nums > 0) {
								$i = 1;					
								$total = 0;			
								while($rec= $db->db_fetch_array($query)) {
									$total +=($rec['SALARY_NEW']);
								 ?>
                           <tr bgcolor="#FFFFFF">
                              <td align="left"><?php echo  text($arr_prefix[$rec["PREFIX_ID"]]).' '.text($rec["PER_FIRSTNAME_TH"]).' '.text($rec["PER_MIDNAME_TH"]).' '.text($rec["PER_LASTNAME_TH"]); ?></td>
                              <td align="left"><?php echo text($rec['LEVEL_NAME_TH']); ?></td>
                              <td align="left"><?php echo text($rec['LINE_NAME_TH']); ?></td>
                              <td align="right"><?php echo  number_format($rec['SALARY_NEW'],2); ?></td>
                            </tr>
                        <?php 
                           $i++;
                        } } ?>                          
                        <tr bgcolor="#FFFFFF">
                          <td colspan="3" align="center"><strong>รวม</strong></td>
                          <td align="right"><strong><?php echo  number_format($total,2); ?></strong></td>
                        </tr>
           
                         </tbody>
                       </table>
					</div>
				</div>
				<div class="row"><?php echo ($nums>0)?endPaging("frm-search",$total_record):"";?></div>
			</form>
		</div>
	</div>
	<div style="text-align:center; bottom:0px;"><?php include($path . "include/footer.php"); ?></div>
</div>
</body>
</html>