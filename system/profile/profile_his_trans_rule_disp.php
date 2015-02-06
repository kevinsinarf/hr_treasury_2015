<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT= 1;
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
$paramlink = url2code($link2);

if(!empty($_POST['S_INFORM_NO'])){
	$filter .= " and INFORM_NO LIKE '%".ctext($_POST['S_INFORM_NO'])."%'";	
}
if(!empty($_POST['S_INFORM_DATE'])){
	$filter .= " and INFORM_DATE = '".conv_date_db($_POST['S_INFORM_DATE'])."'";	
}
if(!empty($_POST['S_INFORM_TO_NAME'])){
	$filter .= " and (INFORM_TO_FIRSTNAME LIKE '%".ctext($_POST['S_INFORM_TO_NAME'])."%' OR INFORM_TO_MIDNAME LIKE '%".ctext($_POST['S_INFORM_TO_NAME'])."%' OR INFORM_TO_LASTNAME LIKE '%".ctext($_POST['S_INFORM_TO_NAME'])."%')";	
}
if(!empty($_POST['PENALTY_STATUS'])){
	$filter .= " and PENALTY_STATUS = '".$_POST['PENALTY_STATUS']."'";	
}

$field = "PENALTY_ID, INFORM_NO, INFORM_DATE, INFORM_TO_PREFIX_ID, INFORM_TO_FIRSTNAME, INFORM_TO_MIDNAME, INFORM_TO_LASTNAME, CRIME_NAME_TH, PENALTY_STATUS ";
$table = "PENALTY_PETITION_FORM JOIN SETUP_CRIME_MAIN ON SETUP_CRIME_MAIN.CRIME_ID = PENALTY_PETITION_FORM.INFORM_CRIME_ID ";
$pk_id = "PENALTY_ID";
$wh = " (case when PENALTY_STATUS = '2' then BOARD_TRANSFER_STATUS when PENALTY_STATUS = '3' then PAUSE_TRANSFER_STATUS when PENALTY_STATUS = '4' then RESIGN_TRANSFER_STATUS 
		 when PENALTY_STATUS = '5' then RESULT_TRANSFER_STATUS when PENALTY_STATUS = '6' then FINAL_TRANSFER_STATUS when PENALTY_STATUS = '7' then REPORT_TRANSFER_STATUS 
		 when PENALTY_STATUS = '8' then END_TRANSFER_STATUS when PENALTY_STATUS = '9' then CANCEL_TRANSFER_STATUS end) = '0' 
		 AND PENALTY_STATUS > 1 {$filter}";
$orderby = "ORDER BY INFORM_DATE DESC";
$groupby = "";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh."".$orderby.") ".$groupby." ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin ;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh."".$groupby));
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
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
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
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_his_trans_rule_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php"); ?></div>
  <div><?php include($path."include/menu.php"); ?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
      <li class="active"><?php echo Showmenu($menu_sub_id);?> (ข้อมูลงานวินัย)</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
  		<?php include("tab_transfer.php");?>
        <div class="grouptab">
		<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PENALTY_ID" name="PENALTY_ID" value="">
		<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        
        <div class="row">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">เลขที่คำร้อง :&nbsp;<span style="color:red;"></span>&nbsp;</div>
            <div class="col-xs-12 col-md-3"><input type="text" id="S_INFORM_NO" name="S_INFORM_NO" class="form-control" placeholder="เลขที่คำร้อง" maxlength="100"  value="<?php echo $S_INFORM_NO;?>" ></div>
            <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่ร้องเรียน :&nbsp;<span style="color:red;"></span>&nbsp;</div>
            <div class="col-xs-12 col-md-2">
                <div class="input-group">
                    <input type="text" id="S_INFORM_DATE" name="S_INFORM_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo $S_INFORM_DATE;?>">
                    <span class="input-group-addon datepicker" for="S_INFORM_DATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                </div>
            </div> 
        </div>
        
        <div class="row">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">ชื่อ-สกุลผู้ถูกร้องเรียน :&nbsp;<span style="color:red;"></span>&nbsp;</div>   
            <div class="col-xs-12 col-md-3"><input type="text" id="S_INFORM_TO_NAME" name="S_INFORM_TO_NAME" class="form-control" placeholder="ชื่อ-สกุล" maxlength="100" value="<?php echo $S_INFORM_TO_NAME;?>" ></div>
            <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">สถานะ :&nbsp;<span style="color:red;"></span>&nbsp;</div> 
            <div class="col-xs-12 col-md-3"><?php  echo GetHtmlSelect('PENALTY_STATUS','PENALTY_STATUS',$arr_penalty_status,'สถานะ',$PENALTY_STATUS,'','','1','','2');?></div> 
        </div>	
        
        <div class="row">
            <div class="col-xs-5 col-md-5"></div>
            <div class="col-xs-5 col-md-2"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
        </div>
        
        <div class="col-xs-12 col-sm-12">
          	<div class="table-responsive">
                <table width="397" class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr class="bgHead">
                            <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                            <th width="10%"><div align="center"><strong>เลขที่คำร้อง</strong></div></th>
                            <th width="12%"><div align="center"><strong>วันที่ร้องเรียน</strong></div></th>
                            <th width="16%"><div align="center"><strong>ชื่อ-สกุลผู้ถูกร้องเรียน</strong> </div></th>
                            <th width="14%"><div align="center"><strong>ฐานความผิด</strong></div></th>
                            <th width="12%"><div align="center"><strong>สถานะ</strong></div></th>
                            <th width="8%"><div align="center"><strong>จัดการ</strong></div></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($nums > 0){
                        $i=1;
                        while($rec = $db->db_fetch_array($query)){
                            $view = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"viewData('".$rec["PENALTY_ID"]."');\">".$img_view." ดูรายละเอียด</a> ";
                            $name = Showname($rec['INFORM_TO_PREFIX_ID'],$rec['INFORM_TO_FIRSTNAME'],$rec['INFORM_TO_MIDNAME'],$rec['INFORM_TO_LASTNAME']);
                            ?>
                            <tr bgcolor="#FFFFFF">
                                <td align="center"><?php echo $i;?>.</td>
                                <td align="center"><?php echo text($rec["INFORM_NO"]); ?></td>
                                <td align="center"><?php echo conv_date($rec['INFORM_DATE'],'short'); ?></td>
                                <td align="left"><?php echo $name; ?></td>
                                <td align="left"><?php echo text($rec["CRIME_NAME_TH"]);?></td>
                                <td align="left"><?php echo $arr_penalty_status[$rec['PENALTY_STATUS']];?></td>
                                <td align="center"><?php echo $view; ?></td>
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
    </form>
    </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>