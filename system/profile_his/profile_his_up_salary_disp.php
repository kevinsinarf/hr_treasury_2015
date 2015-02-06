<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT= 4;
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
$paramlink = url2code($link2);

if(!empty($_POST['YEAR_BDG'])){
	$filter .= " and YEAR_BDG = '".$_POST['YEAR_BDG']."'";	
}
if(!empty($_POST['ROUND'])){
	$filter .= " and ROUND = '".$_POST['ROUND']."'";	
}
if(!empty($_POST['COM_DATE'])){
	$filter .= " and COM_DATE = '".conv_date_db($_POST['COM_DATE'])."'";	
}
if(!empty($_POST['COM_SDATE'])){
	$filter .= " and COM_SDATE = '".conv_date_db($_POST['COM_SDATE'])."'";	
}

$field="A.SAL_COM_ID, A.YEAR_BDG, A.ROUND, A.COM_NO, A.COM_DATE, A.COM_TITLE, A.COM_SDATE";
$table = "SAL_COMMAND A ";

$pk_id = "A.SAL_COM_ID";
$wh = "DELETE_FLAG = 0 AND (TRANSFER_STATUS = 0 OR TRANSFER_STATUS IS NULL) and CONFIRM_TYPE = 2 {$filter}";
$orderby = " ORDER BY A.COM_DATE DESC";
$groupby = "";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh."".$orderby.") ".$groupby." ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin ;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$numrows = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh."".$groupby));
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
<script src="js/profile_his_up_salary_detail.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php"); ?></div>
  <div><?php include($path."include/menu.php"); ?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
      <li><?php echo Showmenu($menu_sub_id);?> (ข้อมูลการเลื่อนขั้นเงินเดือน)</li>
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
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID;?>">
        <input type="hidden" id="PENALTY_ID" name="PENALTY_ID" value="<?php echo $PENALTY_ID;?>">
		<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        <input type="hidden" id="SAL_COM_ID" name="SAL_COM_ID" value="<?php echo $SAL_COM_ID ?>">
           <div class="row">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">ปีงบประมาณ :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                <div class="col-xs-12 col-md-2">
                <input type="text" id="YEAR_BDG" name="YEAR_BDG" class="form-control" placeholder="ปีงบประมาณ" maxlength="100"  value="<?php echo $YEAR_BDG;?>" >	
                </div>
                 <div class="col-xs-12 col-md-2"></div>
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">รอบ :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                <div class="col-xs-12 col-md-2">
                 <input type="text" id="ROUND" name="ROUND" class="form-control" placeholder="รอบ" maxlength="100"  value="<?php echo $ROUND;?>" >	
                </div> 
               </div>
				<div class="row">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">ลงวันที่ :&nbsp;<span style="color:red;"></span>&nbsp;</div>   
                    <div class="col-xs-12 col-md-2">
                    <div class="input-group">
                     <input type="text" id="COM_DATE" name="COM_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="100"  value="<?php echo $COM_DATE;?>" >	
                    <span class="input-group-addon datepicker" for="COM_DATE" >&nbsp;
                    <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </div>
                    </div>
                    <div class="col-xs-12 col-md-2"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่มีผล :&nbsp;<span style="color:red;"></span>&nbsp;</div> 
                     <div class="col-xs-12 col-md-2">
                     <div class="input-group">
                    <input type="text" id="COM_SDATE" name="COM_SDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo $COM_SDATE;?>">
                    <span class="input-group-addon datepicker" for="COM_SDATE" >&nbsp;
                    <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>
                    </div> 
                    </div>	
                <div class="row">
                            <div class="col-xs-5 col-md-5"></div>
                            <div class="col-xs-5 col-md-2">
                                <button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button>
                            </div>
                  </div>
         <table width="397" class="table table-bordered table-striped table-hover table-condensed">
              <thead>
                <tr class="bgHead">
                  <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                  <th width="5%"><div align="center">ปี</div></th>
                  <th width="5%"><div align="center"><strong>รอบ</strong></div></th>
                  <th width="8%"><div align="center"><strong>เลขที่คำสั่ง</strong></div></th>
                  <th width="20%"><div align="center"><strong>เรื่อง</strong> </div></th>
                  <th width="10%"><div align="center"><strong>ลงวันที่</strong></div></th>
                  <th width="10%"><div align="center"><strong>วันที่มีผล</strong></div></th>
                  <th width="5%"><div align="center"><strong>จัดการ</strong></div></th>
                </tr>
              </thead>
              <tbody>
              <?php 
			   if($numrows > 0){
				   $i = 1;
			  		while($rec = $db->db_fetch_array($query)){
					  $view = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"viewData('".$rec["SAL_COM_ID"]."');\">".$img_view." ดูรายละเอียด</a> ";
					  ?>
						<tr bgcolor="#FFFFFF">
						  <td align="center"><?php echo $i;?>.</td>
						  <td align="center"><?php echo $rec["YEAR_BDG"]; ?></td>
						  <td align="center"><?php echo $rec['ROUND']; ?></td>
						  <td align="center"><?php echo text($rec['COM_NO']);?>&nbsp;</td>
						  <td align="left"><?php echo text($rec['COM_TITLE']); ?></td>
						  <td align="center"><?php echo conv_date($rec['COM_DATE'],'short');?></td>
						  <td align="center"><?php echo conv_date($rec['COM_SDATE'],'short');?></td>
						  <td align="center"><?php echo $view; ?></td>
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
        
       
      </form>
        </div>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>