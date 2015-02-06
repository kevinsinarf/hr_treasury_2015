<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//$SAL_COM_ID=$_POST['SAL_COM_ID'];
$proc = ($proc == '' ) ? "add" : $proc;
$txt = ($proc == "add") ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล";

$sql=  " SELECT CT_ID, MOVEMENT_ID, SAL_COM_ID,YEAR_BDG ,ROUND,COM_NO,COM_DATE,COM_TITLE,COM_SDATE,CREATE_BY,UPDATE_BY,CREATE_DATE,UPDATE_DATE,POSTYPE_ID FROM SAL_COMMAND WHERE  SAL_COM_ID ='".$SAL_COM_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
if($proc == 'edit'){
	$YEAR_BDG = $rec['YEAR_BDG'];
	$ROUND = $rec['ROUND'];
}

$sql_sal_up ="SELECT SUM(SALARY_NEW) AS SALARY_SUM, COUNT(PER_ID) AS PERSONAL, B.ORG_NAME_TH, A.ORG_ID_3 FROM SAL_UP_SALARY A
LEFT JOIN SETUP_ORG B ON A.ORG_ID_3 = B.ORG_ID
WHERE POSTYPE_ID = '1' AND YEAR_BDG = '".$YEAR_BDG."' AND ROUND = '".$ROUND."'  AND A.MANAGE_ID <= 0
GROUP BY ORG_ID_3, B.ORG_NAME_TH ORDER BY B.ORG_NAME_TH";
$query_sal_up = $db->query($sql_sal_up);
$nums = $db->db_num_rows($query_sal_up);
$total_record = $db->db_num_rows($db->query("SELECT SUM(SALARY_NEW) AS SALARY_SUM, COUNT(PER_ID) AS PERSONAL, B.ORG_NAME_TH, A.ORG_ID_3 FROM SAL_UP_SALARY A
LEFT JOIN SETUP_ORG B ON A.ORG_ID_3 = B.ORG_ID
WHERE POSTYPE_ID = '1' AND YEAR_BDG = '".$YEAR_BDG."' AND ROUND = '".$ROUND."' GROUP BY ORG_ID_3, B.ORG_NAME_TH ORDER BY B.ORG_NAME_TH"));
//$rec = @array_change_key_case($rec,CASE_LOWER);
$COM_NO = text($rec["COM_NO"]);
$COM_DATE = conv_date($rec["COM_DATE"]);
$COM_TITLE = text($rec["COM_TITLE"]);
$COM_SDATE = conv_date($rec["COM_SDATE"]);


if($proc == 'add')
{
	$YEAR_BDG = $YEAR_BDG;
	$ROUND = $ROUND;
}
else
{
	$YEAR_BDG = text($rec["YEAR_BDG"]);
	$ROUND = text($rec["ROUND"]);
}
$arr_command_type = GetSqlSelectArray("CT_ID", "CT_NAME_TH", "SETUP_COMMAND_TYPE", " CT_TYPE = '1' ", "CT_NAME_TH");
$arr_movement = GetSqlSelectArray("MOVEMENT_ID", "MOVEMENT_NAME_TH", "SETUP_MOVEMENT", " ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' AND POSTYPE_ID = '1'", "MOVEMENT_NAME_TH");
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
<script src="js/command_up_salary_2_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="command_up_salary2_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content">
        <div class="groupdata" >
		<form id="frm-input" method="post" action="process/command_up_salary2_process.php">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="SAL_COM_ID" name="SAL_COM_ID" value="<?php echo $SAL_COM_ID; ?>">
        <input type="hidden" id="YEAR_BDG" name="YEAR_BDG" value="<?php echo $YEAR_BDG; ?>">
        <input type="hidden" id="ROUND" name="ROUND" value="<?php echo $ROUND; ?>">
        <input type="hidden" id="ORG_ID_3" name="ORG_ID_3" value="">
        <div class="row">
        	<div class="col-xs-12 col-md-2"  style="white-space:nowrap;">ปีงบประมาณ :</div>
            <div class="col-xs-12 col-sm-3"><?php echo $YEAR_BDG; ?></div>
            <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">รอบ :</div>
            <div class="col-xs-12 col-sm-3"><?php echo $ROUND; ?></div>
        </div>
         <div class="row ">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">ประเภทคำสั่ง :&nbsp;<span style="color:red">*</span></div>
            <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('CT_ID','CT_ID',$arr_command_type,'ประเภทคำสั่ง',$rec['CT_ID'],'','','1','','1');?></div> 
            <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-md-2">ประเภทความเคลื่อนไหว : <span style="color:red">*</span></div>
            <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('MOVEMENT_ID', 'MOVEMENT_ID', $arr_movement, 'ประเภทความเคลื่อนไหว' ,$rec['MOVEMENT_ID'] ,'', '', '', '300', '1'); ?></div>  
        </div>
		<div class="row">
			<div class="col-xs-12 col-md-2 " style="white-space:nowrap">เลขที่คำสั่ง :<span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><input type="text" id="COM_NO" name="COM_NO" maxlength="100" class="form-control" placeholder="เลขที่คำสั่ง" value="<?php echo text($rec["COM_NO"]); ?>"></div>            
			<div class="col-xs-12 col-sm-2 col-md-offset-1" style="white-space:nowrap;">ลงวันที่ : <span style="color:red;">*</span></div>
            <div class="col-xs-8 col-md-2"><div id="REPORT_SDATE"><div class="input-group"><input type="text" id="COM_DATE" name="COM_DATE" class="form-control date" placeholder="ลงวันที่" maxlength="10" value="<?php echo ($COM_DATE);?>"><span class="input-group-addon datepicker" for="COM_DATE" data-date="<?php echo text($rec["COM_DATE"]); ?>">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span></div></div></div>
		</div>
        <div class="row">
			<div class="col-xs-12 col-md-2 " style="white-space:nowrap">เรื่อง :<span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><input type="text" id="COM_TITLE" name="COM_TITLE" maxlength="100" class="form-control" placeholder="เรื่อง" value="<?php echo text($rec["COM_TITLE"]); ?>"></div>            
			<div class="col-xs-12 col-sm-2 col-md-offset-1" style="white-space:nowrap;">วันที่มีผล : <span style="color:red;">*</span></div>
            <div class="col-xs-8 col-md-2"><div id="REPORT_SDATE"><div class="input-group"><input type="text" id="COM_SDATE" name="COM_SDATE" class="form-control date" placeholder="วันที่มีผล" maxlength="10" value="<?php echo ($COM_SDATE);?>"><span class="input-group-addon datepicker" for="COM_SDATE" data-date="<?php echo text($rec["COM_SDATE"]); ?>">&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span></div></div></div>
        </div>
            <br>
				<div class="col-xs-12 col-md-12">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover table-condensed">
							<thead>							
								<tr class="bgHead">
									<th width="60%"><div align="center"><strong>สำนัก</strong></div></th>
									<th width="15%"><div align="center"><strong>เงินเดือนที่เลื่อน</strong></div></th>
                                    <th width="10%"><div align="center"><strong>จำนวนอัตรา (คน)</strong></div></th>
									<th width="5%"><div align="center"><strong>ดูรายละเอียด</strong></div></th>
								</tr>
							</thead>
							<tbody>
							<?php
							if ($nums > 0) {
								$i = 1;						
								while($rec_sal_up= $db->db_fetch_array($query_sal_up)) {
							$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"View('".$rec_sal_up["ORG_ID_3"]."');\">".$img_save." ดูรายละเอียด</a> ";
								 ?>
								<tr bgcolor="#FFFFFF">
									<td align="left"><?php echo text($rec_sal_up['ORG_NAME_TH']); ?>
                  					<input type="hidden" id="ORG_ID_<?php echo $rec_sal_up['ORG_ID_3'] ?>" name="ORG_ID[]" value="<?php echo $rec_sal_up['ORG_ID_3'] ?>" >
                                    </td>
									<td align="right"><?php echo number_format($rec_sal_up['SALARY_SUM'],2); ?> </td>
									<td align="center"><?php echo text($rec_sal_up['PERSONAL'],2); ?> </td>
									<td align="center"><?php echo $edit; ?></td>
								</tr>
								<?php
									$i++; 
									}	
								 } else {
									echo "<tr><td align=\"center\" colspan=\"4\">ไม่พบข้อมูล</td></tr>";
								 }
								?>
							</tbody>
						</table>
					</div>
				</div>
                        <div class="row">
			<div class="col-xs-12 col-md-12" align="center">
			  <button type="button" class="btn btn-primary" onClick="chkinput();">ยืนยัน</button>
			</div>

				<div class="row"><?php echo ($nums>0)?endPaging("frm-input",$total_record):"";?></div>
        </div>
      </form>
    </div>
  </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>
<!-- Modal -->
<div class="modal fade" id="myModal"></div>
<!-- /.modal -->